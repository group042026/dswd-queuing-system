<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MovUploaded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $clientId,
        public int $documentId,
        public string $fileUrl,
        public string $documentName,
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel("mov-upload.{$this->clientId}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'mov.uploaded';
    }
}