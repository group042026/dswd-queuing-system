<?php

namespace App\Http\Controllers;

use App\Exports\DailyClientReportExport;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
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
}