<?php

namespace App\Http\Data\Events;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class BackupDevice
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $device;

    public function __construct(Device $device)
    {
        $this->device = $device;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
