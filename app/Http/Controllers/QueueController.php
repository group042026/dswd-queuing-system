<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QueueController extends Controller
{
    public function monitor(Request $request)
    {
        Gate::authorize('access-admin');

        $selectedDate = $request->input('date', now()->format('Y-m-d'));

        $queues = Queue::with('client')
                        ->whereDate('date_issued', $selectedDate)
                        ->orderBy('priority', 'desc')
                        ->orderBy('date_issued', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.queueMonitor', [
            'queues' => $queues,
            'selectedDate' => $selectedDate,
        ]);
    }
}
