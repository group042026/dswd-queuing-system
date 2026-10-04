<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientIdAutofillCompleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $scanSession,
        public array $fields,
    ) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel("id-autofill.{$this->scanSession}")];
    }

    public function broadcastAs(): string
    {
        return 'client.id-autofill.completed';
    }

    public function broadcastWith(): array
    {
        return [
            'scanSession' => $this->scanSession,
            'fields' => $this->fields,
        ];
    }
}
