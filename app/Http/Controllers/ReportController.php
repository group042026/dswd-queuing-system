<?php

namespace App\Http\Controllers;

use App\Exports\DailyClientReportExport;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Report;
use App\Exports\MonthlyTransactionReportExport;
use App\Models\ClientProcessing;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //CLIENT DAILY REPORTS
    public function dailyClientReport(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $clients = Client::with(['queue' => function ($q) use ($selectedDate) {
                $q->whereDate('date_issued', $selectedDate);
            }])
            ->whereDate('date_registered', $selectedDate)
            ->orderBy('date_registered', 'asc')
            ->get();

        return view('admin.daily-client', [
            'selectedDate' => $selectedDate,
            'clients' => $clients,
        ]);
    }

    public function exportDailyClientReport(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $user = auth()->user();


        Report::create([
            'created_by' => auth()->id(),
            'report_type' => 'Daily Client Report',
        ]);

        ActivityLog::record(
            'Report Generated',
            "{$user->name} generated Daily Client Report for {$selectedDate}"
        );

        return Excel::download(
            new DailyClientReportExport($selectedDate),
            "daily-client-report-{$selectedDate}.xlsx"
        );
    }

    //MONTHLY TRANSACTION REPORT
    public function monthlyTransactionReport(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedMonth = $request->input('month', now()->format('Y-m')); // format: 2026-08
        [$year, $month] = explode('-', $selectedMonth);

        $baseQuery = fn () => ClientProcessing::where('current_step', 'Releasing')
            ->where('current_status', 'Completed')
            ->whereYear('end_time', $year)
            ->whereMonth('end_time', $month);

        // Summary — total count
        $totalTransactions = $baseQuery()->count();

        // Summary — breakdown per program
        $perProgram = $baseQuery()
            ->join('clients', 'clients.id', '=', 'client_processings.client_id')
            ->select('clients.program_requested', DB::raw('count(*) as total'))
            ->groupBy('clients.program_requested')
            ->pluck('total', 'clients.program_requested');

        // Summary — breakdown per client category
        $perCategory = $baseQuery()
            ->join('clients', 'clients.id', '=', 'client_processings.client_id')
            ->select('clients.client_category', DB::raw('count(*) as total'))
            ->groupBy('clients.client_category')
            ->pluck('total', 'clients.client_category');

        // Detailed list
        $transactions = $baseQuery()
            ->with(['client', 'queue'])
            ->orderBy('end_time', 'desc')
            ->paginate(10)
            ->appends(['month' => $selectedMonth]);

        return view('admin.monthly-transaction', [
            'selectedMonth' => $selectedMonth,
            'totalTransactions' => $totalTransactions,
            'perProgram' => $perProgram,
            'perCategory' => $perCategory,
            'transactions' => $transactions,
        ]);
    }

    public function exportMonthlyTransactionReport(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedMonth = $request->input('month', now()->format('Y-m'));
        $user = auth()->user();

        Report::create([
            'created_by' => $user->id,
            'report_type' => 'Monthly Transaction Report',
        ]);

        ActivityLog::record(
            'Report Generated',
            "{$user->name} generated Monthly Transaction Report for {$selectedMonth}"
        );

        return Excel::download(
            new MonthlyTransactionReportExport($selectedMonth),
            "monthly-transaction-report-{$selectedMonth}.xlsx"
        );
    }
}