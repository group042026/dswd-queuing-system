<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('access-admin');

        $request->validate([
            'user_id' => ['nullable', 'string'],
            'action' => ['nullable', 'string', 'max:100'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        // Kung walang filter na pinasa, default sa today (kapareho ng dating behavior)
        $isFiltered = $request->hasAny(['user_id', 'action', 'date_from', 'date_to']);

        $dateFrom = $isFiltered ? $request->input('date_from') : now()->format('Y-m-d');
        $dateTo = $isFiltered ? $request->input('date_to') : now()->format('Y-m-d');

        $logs = ActivityLog::with('user')
            ->when($request->filled('user_id'), function ($query) use ($request) {
                $request->input('user_id') === 'system'
                    ? $query->whereNull('user_id')
                    : $query->where('user_id', $request->input('user_id'));
            })
            ->when($request->filled('action'), function ($query) use ($request) {
                $query->where('action_type', $request->input('action'));
            })
            ->when($dateFrom, fn ($query) => $query->whereDate('time_committed', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->whereDate('time_committed', '<=', $dateTo))
            ->orderBy('time_committed', 'desc')
            ->paginate(10)
            ->withQueryString();

        $users = User::orderBy('first_name')->get(['id', 'first_name', 'last_name']);

        // Initial render: action list ng napiling user (fallback kung walang JS)
        $actions = ActivityLog::select('action_type')
            ->when($request->filled('user_id'), function ($query) use ($request) {
                $request->input('user_id') === 'system'
                    ? $query->whereNull('user_id')
                    : $query->where('user_id', $request->input('user_id'));
            })
            ->distinct()
            ->orderBy('action_type')
            ->pluck('action_type');

        // Para sa auto-update ng Action dropdown pag nagpalit ng user: [user_id => [actions...]]
        $actionMap = ActivityLog::select('user_id', 'action_type')
            ->distinct()
            ->orderBy('action_type')
            ->get()
            ->groupBy(fn ($row) => $row->user_id ?? 'system')
            ->map(fn ($rows) => $rows->pluck('action_type')->values());

        return view('admin.activitylogs', [
            'logs' => $logs,
            'users' => $users,
            'actions' => $actions,
            'actionMap' => $actionMap,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }
}
