<?php

namespace App\Http\Data\Events;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BackupSensorAverages
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   public $sensor;

    public function __construct(Sensor $sensor)
    {
        $this->sensor = $sensor;
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
