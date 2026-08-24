<?php

namespace App\Console\Commands;

use App\Models\Queue;
use Illuminate\Console\Command;

class CancelAbandonedQueues extends Command
{
    protected $signature = 'queues:cancel-abandoned';
    protected $description = 'Mark unfinished queue entries from previous days as Abandoned';

    public function handle()
    {
        $abandonedQueues = Queue::whereDate('date_issued', '<', now()->format('Y-m-d'))
            ->whereIn('queue_status', ['Waiting', 'Serving'])
            ->get();

        foreach ($abandonedQueues as $queue) {
            $queue->update(['queue_status' => 'Abandoned']);

            $queue->latestProcessing?->update([
                'current_status' => 'Abandoned',
                'end_time' => now(),
            ]);
        }

        $this->info("Marked {$abandonedQueues->count()} queue entries as Abandoned.");
    }
}