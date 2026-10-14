<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    protected string $backupDir;

    public function __construct()
    {
        $this->backupDir = storage_path('app/backups');
        if (!File::exists($this->backupDir)) {
            File::makeDirectory($this->backupDir, 0755, true);
        }
    }

    /**
     * Show Backup & Restore Dashboard.
     */
    public function index(): View
    {
        Gate::authorize('access-admin');

        $driver = DB::getDriverName();
        $dbName = config("database.connections.{$driver}.database");
        $dbSize = $this->getDatabaseSize($driver);

        // Fetch all backup files
        $backupFiles = File::files($this->backupDir);
        $backups = [];

        foreach ($backupFiles as $file) {
            $filename = $file->getFilename();
            if ($filename === '.gitignore' || str_starts_with($filename, '.')) {
                continue;
            }

            $extension = strtolower($file->getExtension());
            if (!in_array($extension, ['sql', 'sqlite'])) {
                continue;
            }

            $sizeBytes = $file->getSize();
            $detectedDriver = 'Unknown';
            if (str_contains($filename, 'sqlite') || $extension === 'sqlite') {
                $detectedDriver = 'SQLite';
            } elseif (str_contains($filename, 'mysql') || $extension === 'sql') {
                $detectedDriver = 'MySQL';
            }

            $backups[] = [
                'filename' => $filename,
                'driver' => $detectedDriver,
                'extension' => $extension,
                'size' => $this->formatBytes($sizeBytes),
                'size_bytes' => $sizeBytes,
                'created_at' => \Carbon\Carbon::createFromTimestamp($file->getMTime()),
            ];
        }

        // Sort latest backups first
        usort($backups, fn ($a, $b) => $b['created_at']->timestamp <=> $a['created_at']->timestamp);

        $lastBackup = !empty($backups) ? $backups[0]['created_at'] : null;

        return view('admin.backupNrestore', [
            'backups' => $backups,
            'dbDriver' => ucfirst($driver),
            'dbName' => is_string($dbName) ? basename($dbName) : 'Unknown',
            'dbSize' => $dbSize,
            'lastBackup' => $lastBackup,
        ]);
    }

    /**
     * Create a new database backup.
     */
    public function create(): RedirectResponse
    {
        Gate::authorize('access-admin');

        $driver = DB::getDriverName();
        $timestamp = now()->format('Y-m-d_H-i-s');

        try {
            if ($driver === 'sqlite') {
                $filename = "backup-sqlite-{$timestamp}.sqlite";
                $targetPath = $this->backupDir . DIRECTORY_SEPARATOR . $filename;
                $this->backupSqlite($targetPath);
            } elseif ($driver === 'mysql' || $driver === 'mariadb') {
                $filename = "backup-mysql-{$timestamp}.sql";
                $targetPath = $this->backupDir . DIRECTORY_SEPARATOR . $filename;
                $this->backupMySQL($targetPath);
            } else {
                return back()->with('error', "Database driver [{$driver}] is not supported for automated backups.");
            }

            ActivityLog::record(
                'Database Backup Created',
                "Admin created {$driver} database backup: {$filename}"
            );

            return back()->with('success', "Database backup [{$filename}] created successfully.");
        } catch (\Throwable $e) {
            return back()->with('error', "Failed to create backup: {$e->getMessage()}");
        }
    }

    /**
     * Download a specific backup file.
     */
    public function download(string $filename): BinaryFileResponse|RedirectResponse
    {
        Gate::authorize('access-admin');

        $cleanFilename = basename($filename);
        $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $cleanFilename;

        if (!File::exists($filePath)) {
            return back()->with('error', 'The requested backup file does not exist.');
        }

        return response()->download($filePath, $cleanFilename);
    }

    /**
     * Delete a specific backup file.
     */
    public function destroy(string $filename): RedirectResponse
    {
        Gate::authorize('access-admin');

        $cleanFilename = basename($filename);
        $filePath = $this->backupDir . DIRECTORY_SEPARATOR . $cleanFilename;

        if (!File::exists($filePath)) {
            return back()->with('error', 'The requested backup file does not exist.');
        }

        File::delete($filePath);

        ActivityLog::record(
            'Database Backup Deleted',
            "Admin deleted database backup: {$cleanFilename}"
        );

        return back()->with('success', "Backup file [{$cleanFilename}] was successfully deleted.");
    }

    /**
     * Restore database from an existing file or an uploaded file.
     */
    public function restore(Request $request): RedirectResponse
    {
        Gate::authorize('access-admin');

        $request->validate([
            'filename' => 'nullable|string',
            'backup_file' => 'nullable|file|max:102400', // max 100MB
        ]);

        $driver = DB::getDriverName();
        $sourcePath = null;
        $displayName = '';
        $isUploaded = false;

        // 1. Determine the source backup file
        if ($request->hasFile('backup_file')) {
            $uploaded = $request->file('backup_file');
            $extension = strtolower($uploaded->getClientOriginalExtension());

            if (!in_array($extension, ['sql', 'sqlite'])) {
                return back()->with('error', 'Invalid file type. Only .sql and .sqlite files are accepted.');
            }

            $displayName = $uploaded->getClientOriginalName();
            $tempName = 'temp_restore_' . now()->timestamp . '.' . $extension;
            $sourcePath = $this->backupDir . DIRECTORY_SEPARATOR . $tempName;
            $uploaded->move($this->backupDir, $tempName);
            $isUploaded = true;
        } elseif ($request->filled('filename')) {
            $cleanName = basename($request->input('filename'));
            $sourcePath = $this->backupDir . DIRECTORY_SEPARATOR . $cleanName;
            $displayName = $cleanName;

            if (!File::exists($sourcePath)) {
                return back()->with('error', 'The selected backup file does not exist.');
            }
        } else {
            return back()->with('error', 'Please select an existing backup or upload a backup file.');
        }

        try {
            $ext = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));

            if ($driver === 'sqlite') {
                if ($ext === 'sqlite') {
                    $this->restoreSqliteFile($sourcePath);
                } elseif ($ext === 'sql') {
                    $this->restoreSqlStatements($sourcePath, 'sqlite');
                } else {
                    throw new \Exception("Unsupported file extension [{$ext}] for SQLite.");
                }
            } elseif ($driver === 'mysql' || $driver === 'mariadb') {
                if ($ext === 'sql') {
                    $this->restoreSqlStatements($sourcePath, 'mysql');
                } else {
                    throw new \Exception("SQLite binary files cannot be restored into a MySQL database. Please use a .sql backup.");
                }
            } else {
                throw new \Exception("Restore is not supported for driver [{$driver}].");
            }

            ActivityLog::record(
                'Database Restored',
                "Admin successfully restored {$driver} database from: {$displayName}"
            );

            return back()->with('success', "Database successfully restored from [{$displayName}].");
        } catch (\Throwable $e) {
            return back()->with('error', "Restore failed: {$e->getMessage()}");
        } finally {
            if ($isUploaded && File::exists($sourcePath)) {
                File::delete($sourcePath);
            }
        }
    }

    /**
     * Backup SQLite Database.
     */
    protected function backupSqlite(string $targetPath): void
    {
        $dbPath = config('database.connections.sqlite.database', database_path('database.sqlite'));

        if (!File::exists($dbPath)) {
            throw new \Exception("SQLite database file not found at: {$dbPath}");
        }

        // Try clean VACUUM INTO first (supported in SQLite 3.27+)
        try {
            if (File::exists($targetPath)) {
                File::delete($targetPath);
            }
            DB::statement("VACUUM INTO '{$targetPath}'");
        } catch (\Throwable) {
            // Fallback to safe file copy
            if (!copy($dbPath, $targetPath)) {
                throw new \Exception('Failed to copy SQLite database file to backup destination.');
            }
        }
    }

    /**
     * Backup MySQL Database using pure PHP PDO.
     */
    protected function backupMySQL(string $targetPath): void
    {
        $pdo = DB::connection('mysql')->getPdo();
        $dbName = config('database.connections.mysql.database');

        $handle = fopen($targetPath, 'w');
        if (!$handle) {
            throw new \Exception('Unable to open target file for writing.');
        }

        fwrite($handle, "-- ========================================================\n");
        fwrite($handle, "-- DSWD Queuing System MySQL Database Dump\n");
        fwrite($handle, "-- Generated: " . now()->toDateTimeString() . "\n");
        fwrite($handle, "-- Database: {$dbName}\n");
        fwrite($handle, "-- ========================================================\n\n");
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
        fwrite($handle, "SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";\n");
        fwrite($handle, "SET NAMES utf8mb4;\n\n");

        $tablesStmt = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
        $tables = $tablesStmt->fetchAll(\PDO::FETCH_NUM);

        foreach ($tables as $tableRow) {
            $table = $tableRow[0];

            // 1. Table Structure
            $createTableStmt = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
            $createSql = $createTableStmt['Create Table'] ?? '';

            fwrite($handle, "\n-- --------------------------------------------------------\n");
            fwrite($handle, "-- Structure for table `{$table}`\n");
            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
            fwrite($handle, $createSql . ";\n\n");

            // 2. Table Data
            $countStmt = $pdo->query("SELECT COUNT(*) FROM `{$table}`");
            $rowCount = (int) $countStmt->fetchColumn();

            if ($rowCount > 0) {
                fwrite($handle, "-- Dumping data for table `{$table}` ({$rowCount} rows)\n");
                $chunkSize = 500;
                $offset = 0;

                while ($offset < $rowCount) {
                    $rows = $pdo->query("SELECT * FROM `{$table}` LIMIT {$chunkSize} OFFSET {$offset}")->fetchAll(\PDO::FETCH_ASSOC);
                    if (empty($rows)) {
                        break;
                    }

                    $columns = array_map(fn ($col) => "`{$col}`", array_keys($rows[0]));
                    $colList = implode(', ', $columns);

                    $valueLines = [];
                    foreach ($rows as $row) {
                        $values = array_map(function ($val) use ($pdo) {
                            if ($val === null) {
                                return 'NULL';
                            }
                            return $pdo->quote((string) $val);
                        }, array_values($row));

                        $valueLines[] = '(' . implode(', ', $values) . ')';
                    }

                    fwrite($handle, "INSERT INTO `{$table}` ({$colList}) VALUES\n" . implode(",\n", $valueLines) . ";\n\n");
                    $offset += $chunkSize;
                }
            }
        }

        fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        fwrite($handle, "-- Dump completed successfully.\n");
        fclose($handle);
    }

    /**
     * Restore an SQLite .sqlite binary database.
     */
    protected function restoreSqliteFile(string $sourcePath): void
    {
        $targetDb = config('database.connections.sqlite.database', database_path('database.sqlite'));

        // Verify SQLite 3 file header (first 16 bytes: "SQLite format 3\0")
        $header = file_get_contents($sourcePath, false, null, 0, 16);
        if ($header !== "SQLite format 3\0") {
            throw new \Exception('The provided file is not a valid SQLite database.');
        }

        // Close PDO connections before swapping files
        DB::disconnect();
        gc_collect_cycles();

        // Remove active WAL or shared memory files if present
        $walFile = $targetDb . '-wal';
        $shmFile = $targetDb . '-shm';
        if (File::exists($walFile)) {
            File::delete($walFile);
        }
        if (File::exists($shmFile)) {
            File::delete($shmFile);
        }

        // Copy source file to destination
        if (!copy($sourcePath, $targetDb)) {
            throw new \Exception('Failed to overwrite SQLite database file.');
        }

        // Reconnect and verify integrity
        DB::reconnect();
        $integrity = DB::select('PRAGMA integrity_check');
        $status = $integrity[0]->integrity_check ?? 'ok';

        if (strtolower($status) !== 'ok') {
            throw new \Exception("Database integrity check failed: {$status}");
        }
    }

    /**
     * Restore database from a .sql script (SQLite or MySQL).
     */
    protected function restoreSqlStatements(string $sqlFilePath, string $driver): void
    {
        $pdo = DB::connection($driver)->getPdo();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($driver === 'sqlite') {
            $pdo->exec('PRAGMA foreign_keys = OFF;');
        }

        $handle = fopen($sqlFilePath, 'r');
        if (!$handle) {
            throw new \Exception('Unable to open SQL file for reading.');
        }

        $currentQuery = '';

        while (($line = fgets($handle)) !== false) {
            $trimmed = trim($line);

            // Skip SQL comments and blank lines
            if ($trimmed === '' || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '/*')) {
                continue;
            }

            $currentQuery .= $line;

            // When a statement terminates with a semicolon at the end of the line
            if (str_ends_with($trimmed, ';')) {
                try {
                    $pdo->exec($currentQuery);
                } catch (\Throwable $e) {
                    fclose($handle);
                    throw new \Exception("SQL execution error: {$e->getMessage()} in query: " . substr($currentQuery, 0, 100));
                }
                $currentQuery = '';
            }
        }

        fclose($handle);

        if ($driver === 'mysql' || $driver === 'mariadb') {
            $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($driver === 'sqlite') {
            $pdo->exec('PRAGMA foreign_keys = ON;');
        }
    }

    /**
     * Calculate current database size.
     */
    protected function getDatabaseSize(string $driver): string
    {
        try {
            if ($driver === 'sqlite') {
                $dbPath = config('database.connections.sqlite.database', database_path('database.sqlite'));
                if (File::exists($dbPath)) {
                    return $this->formatBytes(File::size($dbPath));
                }
            } elseif ($driver === 'mysql' || $driver === 'mariadb') {
                $dbName = config('database.connections.mysql.database');
                $result = DB::select(
                    'SELECT SUM(data_length + index_length) AS size FROM information_schema.TABLES WHERE table_schema = ?',
                    [$dbName]
                );
                $sizeBytes = $result[0]->size ?? 0;
                return $this->formatBytes((int) $sizeBytes);
            }
        } catch (\Throwable) {
            // Ignore error if database cannot be queried
        }

        return 'N/A';
    }

    /**
     * Helper to format bytes into readable KB/MB/GB.
     */
    protected function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
