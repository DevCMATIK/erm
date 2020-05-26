<?php

namespace App\Http\Data\Events;

use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BackupedAverages
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $sensor_id;

    public function __construct($sensor_id)
    {
        $this->sensor_id = $sensor_id;

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
