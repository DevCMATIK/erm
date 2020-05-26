<?php

namespace App\Http\Data\Jobs\Device;

use App\Domain\System\Mail\MailLog;
use App\Domain\WaterManagement\Device\Log\DeviceOfflineLog;
use App\Domain\WaterManagement\Group\Group;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class NotifyDevicesOffline implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logs = DeviceOfflineLog::with('device.check_point.sub_zones.zone')->notifiable()->get();
        $logs->filter(function($item) {
            return Carbon::now()->diffInMinutes(Carbon::parse($item->start_date)) >= 15;
        });
        if(count($logs) > 0) {
            $group = Group::with('users')->slug('offline')->first();
            foreach($group->users as $user) {
                Mail::to($user->email)
                    ->send(new \App\Mail\NotifyDevicesOffline($logs));

                $log = MailLog::create([
                    'mail_id' => null,
                    'mail_name' => 'devices-offline',
                    'identifier' => 'offline-devices-email',
                    'date' => Carbon::now()->toDateTimeString(),
                ]);

                $log->users()->create(['user_id' => $user->id]);

            }

        }

    }
}
