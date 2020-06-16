<?php

namespace App\Domain\WaterManagement\Device\Sensor;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Address\Address;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorAverage;
use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorDailyAverage;
use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Label\SensorLabel;
use App\Domain\WaterManagement\Device\Sensor\Range\SensorRange;
use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Domain\WaterManagement\Device\Sensor\Type\SensorType;
use App\Domain\WaterManagement\Report\MailReport;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Sensor extends Model
{
    use HasEagerLimit;

    public $timestamps = false;

    protected $fillable = [
        'type_id',
        'device_id',
        'address_id',
        'name',
        'address_number',
        'enabled',
        'has_alarm',
        'historial',
        'max_value',
        'default_disposition',
        'fix_values_out_of_range',
        'fix_values',
        'fix_min_value',
        'fix_max_value',
        'last_value'
    ];

    protected $appends = ['full_address'];


    public function selected_disposition()
    {
        return $this->dispositions()->where('id',$this->default_disposition);
    }

    public function non_selected_dispositions()
    {
        return $this->dispositions()->where('id','<>',$this->default_disposition);
    }

    public function address()
    {
        return $this->belongsTo(Address::class,'address_id','id');
    }

    public function scopeDigital($query)
    {
        return $query->whereHas('address', function($q) {
            $q->digital();
        });
    }

    public function scopeAnalogous($query)
    {
        return $query->whereHas('address', function($q) {
            $q->analogous();
        });
    }

    public function scopeOutput($query)
    {
        return $query->whereHas('address', function($address){
            $address->type(9);
        });
    }

    public function type()
    {
        return $this->belongsTo(SensorType::class,'type_id','id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class,'device_id','id');
    }


    public function label()
    {
        return $this->hasOne(SensorLabel::class,'sensor_id','id');
    }

    public function dispositions()
    {
        return $this->hasMany(SensorDisposition::class,'sensor_id','id');
    }

    public function ranges()
    {
        return $this->hasMany(SensorRange::class,'sensor_id','id');
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address->slug}{$this->address_number}";
    }

    public function analogous_reports()
    {
        return $this->hasMany(AnalogousReport::class,'sensor_id','id');
    }


    public function today_analogous_reports()
    {
        return $this->analogous_reports()->where('analogous_reports.result','>',1)->today('analogous_reports.date');
    }

    public function yesterday_analogous_reports()
    {
        return $this->analogous_reports()->where('analogous_reports.result','>',1)->yesterday('date');
    }

    public function yesterday_latest_report()
    {
        return $this->hasOne(AnalogousReport::class,'sensor_id','id')->yesterday('analogous_reports.date')->where('analogous_reports.result','>',1)->orderBy('id','desc')->limit(1);
    }


    public function yesterday_earliest_report()
    {
        return $this->hasOne(AnalogousReport::class,'sensor_id','id')->yesterday('analogous_reports.date')->where('analogous_reports.result','>',1)->orderBy('id')->limit(1);
    }
    public function last_hour_analogous_report()
    {
        return $this->analogous_reports()->where('analogous_reports.result','>',1)->lastHour('date');
    }


    public function digital_reports()
    {
        return $this->hasMany(DigitalReport::class,'sensor_id','id');
    }

    public function triggers()
    {
        return $this->hasMany(SensorTrigger::class,'user_id','id');
    }

    public function triggerers()
    {
        return $this->hasMany(SensorTrigger::class,'receptor_id','id');
    }

    public function alarms()
    {
        return $this->hasMany(SensorAlarm::class,'sensor_id','id');
    }

    public function active_alarm()
    {
        return $this->alarms()->has('active_alarm');
    }

    public function active_and_accused_alarm()
    {
        return $this->alarms()->has('active_and_accused_alarm');
    }

    public function active_and_not_accused_alarm()
    {
        return $this->alarms()->has('active_and_not_accused_alarm');
    }

    public function mail_reports()
    {
        return $this->belongsToMany(MailReport::class,'mail_report_sensors','sensor_id','mail_report_id');
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled',1);
    }

    public function average()
    {
        return $this->hasOne(SensorAverage::class,'sensor_id','id');
    }

    public function behaviors()
    {
        return $this->hasMany(SensorBehavior::class,'sensor_id','id');
    }

    public function daily_averages()
    {
        return $this->hasMany(SensorDailyAverage::class,'sensor_id','id');
    }

    public function scopeSensorType($query,$type)
    {
        return $query->whereHas('type',function($q) use($type){
            return $q->where('slug',$type);
        });
    }

    public function consumptions()
    {
        return $this->hasMany(ElectricityConsumption::class,'sensor_id','id');
    }
}
