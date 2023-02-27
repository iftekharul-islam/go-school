<?php

namespace App\Events;

use App\Attendance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttendanceCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attendance;
    public $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Attendance $attendance, $status)
    {
        $this->attendance = $attendance;
        $this->status = $status;
    }
}
