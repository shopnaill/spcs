<?php
namespace App\Events;

use App\Models\SupportRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportRequestReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $supportRequest;

    public function __construct(SupportRequest $supportRequest)
    {
        $this->supportRequest = $supportRequest;
    }

    public function broadcastOn()
    {
        return new Channel('support-requests');
    }

    public function broadcastWith()
    {
        return [
            'requester_name' => $this->supportRequest->requester_name,
            'requester_device' => $this->supportRequest->requester_device,
            'message' => $this->supportRequest->message,
        ];
    }


    public function broadcastAs()
    {
        return 'my-event';
    }
}
