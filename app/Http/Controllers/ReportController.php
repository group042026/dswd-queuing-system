<?php

namespace App\Http\Controllers;

use App\Exports\ClientProcessingReportExport;
use App\Exports\DailyClientReportExport;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Report;
use App\Models\Queue;
use App\Exports\MonthlyTransactionReportExport;
use App\Exports\QueuePerformanceReportExport;
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

        $clients = Client::whereDate('date_registered', $selectedDate)
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

    public function monthlyTransactionReport(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedMonth = $request->input('month', now()->format('Y-m'));
        [$year, $month] = explode('-', $selectedMonth);

        $baseQuery = fn () => ClientProcessing::where('current_step', 'Releasing')
            ->where('current_status', 'Completed')
            ->whereYear('end_time', $year)
            ->whereMonth('end_time', $month);

        $totalTransactions = $baseQuery()->count();

        $perProgram = $baseQuery()
            ->join('clients', 'clients.id', '=', 'client_processings.client_id')
            ->select('clients.program_requested', DB::raw('count(*) as total'))
            ->groupBy('clients.program_requested')
            ->pluck('total', 'clients.program_requested');

        $perCategory = $baseQuery()
            ->join('clients', 'clients.id', '=', 'client_processings.client_id')
            ->select('clients.client_category', DB::raw('count(*) as total'))
            ->groupBy('clients.client_category')
            ->pluck('total', 'clients.client_category');

        $transactions = $baseQuery()
            ->with('client')
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

    //QUEUE PROCESSING REPORT
    public function queuePerformanceReport(Request $request)
    {
        Gate::authorize('access-admin');

        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        // Average time per step
        $avgTimePerStep = ClientProcessing::where('current_status', 'Completed')
            ->whereNotNull('end_time')
            ->whereDate('start_time', '>=', $dateFrom)
            ->whereDate('end_time', '<=', $dateTo)
            ->select('current_step', DB::raw('AVG(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as avg_minutes'))
            ->groupBy('current_step')
            ->pluck('avg_minutes', 'current_step');

        // Count served per queue_status
        $servedCount = Queue::whereDate('date_issued', '>=', $dateFrom)
            ->whereDate('date_issued', '<=', $dateTo)
            ->select('queue_status', DB::raw('count(*) as total'))
            ->groupBy('queue_status')
            ->pluck('total', 'queue_status');

        $totalQueues = $servedCount->sum();

        // overall duration (registration to completion/cancellation)
        $queues = Queue::with(['client', 'latestProcessing'])
            ->whereDate('date_issued', '>=', $dateFrom)
            ->whereDate('date_issued', '<=', $dateTo)
            ->orderBy('date_issued', 'desc')
            ->paginate(10)
            ->appends(['date_from' => $dateFrom, 'date_to' => $dateTo]);

        return view('admin.queue-performance', [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'avgTimePerStep' => $avgTimePerStep,
            'servedCount' => $servedCount,
            'totalQueues' => $totalQueues,
            'queues' => $queues,
        ]);
    }

    public function exportQueuePerformanceReport(Request $request)
    {
        Gate::authorize('access-admin');

        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $user = auth()->user();

        Report::create([
            'created_by' => $user->id,
            'report_type' => 'Queue Performance Report',
        ]);

        ActivityLog::record(
            'Report Generated',
            "{$user->name} generated Queue Performance Report ({$dateFrom} to {$dateTo})"
        );

        return Excel::download(
            new QueuePerformanceReportExport($dateFrom, $dateTo),
            "queue-performance-report-{$dateFrom}-to-{$dateTo}.xlsx"
        );
    }

    //CLIENT PROCESSING REPORT
    public function clientProcessingReport(Request $request)
    {
        Gate::authorize('access-admin');

        // $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        // $dateTo = $request->input('date_to', now()->startOfMonth()->addDay()->format('Y-m-d'));

        $dateFrom = $request->input('date_from', now()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->addDay()->format('Y-m-d'));


        // Snapshot NGAYON — ilang naka-stuck sa bawat stage (hindi naka-date filter)
        $stuckPerStage = ClientProcessing::whereIn('current_status', ['Waiting', 'Processing'])
            ->select('current_step', DB::raw('count(*) as total'))
            ->groupBy('current_step')
            ->pluck('total', 'current_step');

        $totalStuck = $stuckPerStage->sum();

        // Historical list — buong processing history sa loob ng date range
        $processingHistory = ClientProcessing::with(['client', 'queue', 'user'])
            ->whereDate('start_time', '>=', $dateFrom)
            ->whereDate('start_time', '<=', $dateTo)
            ->orderBy('start_time', 'desc')
            ->paginate(10)
            ->appends(['date_from' => $dateFrom, 'date_to' => $dateTo]);

        return view('admin.client-processing', [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'stuckPerStage' => $stuckPerStage,
            'totalStuck' => $totalStuck,
            'processingHistory' => $processingHistory,
        ]);
    }

    public function exportClientProcessingReport(Request $request)
    {
        Gate::authorize('access-admin');

        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $user = auth()->user();

        Report::create([
            'created_by' => $user->id,
            'report_type' => 'Client Processing Report',
        ]);

        ActivityLog::record(
            'Report Generated',
            "{$user->name} generated Client Processing Report ({$dateFrom} to {$dateTo})"
        );

        return Excel::download(
            new ClientProcessingReportExport($dateFrom, $dateTo),
            "client-processing-report-{$dateFrom}-to-{$dateTo}.xlsx"
        );
    }
}