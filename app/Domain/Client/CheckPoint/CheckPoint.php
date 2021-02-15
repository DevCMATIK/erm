<?php

namespace App\Domain\Client\CheckPoint;

use App\App\Traits\Model\Sluggable;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\CheckPoint\Flow\CheckPointAuthorizedFlow;
use App\Domain\Client\CheckPoint\Flow\CheckPointFlow;
use App\Domain\Client\CheckPoint\Grid\CheckPointGrid;
use App\Domain\Client\CheckPoint\Indicator\CheckPointIndicator;
use App\Domain\Client\CheckPoint\Label\CheckPointLabel;
use App\Domain\Client\CheckPoint\Totalizer\CheckPointTotalizer;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Sub\SubZoneSubElement;
use App\Domain\WaterManagement\Device\Consumption\DeviceConsumption;
use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CheckPoint extends Model implements Auditable
{
    use Sluggable,SoftDeletes, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'type_id','slug','name','dga_report','work_code'
    ];

    public function sub_zones()
    {
        return $this->belongsToMany(SubZone::class,'check_point_sub_zones','check_point_id','sub_zone_id');
    }

    public function type()
    {
        return $this->belongsTo(CheckPointType::class,'type_id','id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class,'check_point_id','id');
    }

    public function devices_offline()
    {
        return $this->devices()->has('is_offline');
    }

    public function active_alarm()
    {
        return $this->devices()->has('active_alarm');
    }

    public function active_and_accused_alarm()
    {
        return $this->devices()->has('active_and_accused_alarm');
    }

    public function active_and_not_accused_alarm()
    {
        return $this->devices()->has('active_and_not_accused_alarm');
    }

    public function sub_element()
    {
        return $this->hasMany(SubZoneSubElement::class,'check_point_id','id');
    }

    public function label()
    {
        return $this->hasMany(CheckPointLabel::class,'check_point_id','id');
    }

    public function authorized_flow()
    {
        return $this->hasOne(CheckPointAuthorizedFlow::class,'check_point_id','id');
    }

    public function flow_averages()
    {
        return $this->hasMany(CheckPointFlow::class,'check_point_id','id');
    }

    public function totalizers()
    {
        return $this->hasMany(CheckPointTotalizer::class,'check_point_id','id');
    }

    public function consumptions()
    {
        return $this->hasMany(DeviceConsumption::class,'check_point_id','id');
    }

    public function scopeCheckType($query,$slug)
    {
        return $query->whereHas('type',function($q) use($slug){
            return $q->where('slug',$slug);
        });
    }

    public function grids()
    {
        return $this->hasMany(CheckPointGrid::class,'check_point_id','id')->orderBy('check_point_grids.row');
    }

    public function dga_reports()
    {
        return $this->hasMany(CheckPointReport::class,'check_point_id','id');
    }

    public function indicators()
    {
        return $this->hasMany(CheckPointIndicator::class,'check_point_id','id');
    }

    public function last_report()
    {
        return $this->hasOne(CheckPointReport::class,'check_point_id','id')->orderByDesc('report_date');
    }

    public function this_month_reports()
    {
        return $this->dga_reports()->whereRaw('report_date between "'.Carbon::now()->startOfMonth()->toDateString().' 00:00:00"  and "'.Carbon::now()->endOfMonth()->toDateString().' 23:59:59"');
    }

    public function this_month_failed_reports()
    {
        return $this->this_month_reports()->where('response','<>',0);
    }

    public function reports_to_date()
    {
        return $this->dga_reports()->whereRaw('report_date between "'.Carbon::now()->startOfMonth()->toDateString().' 00:00:00"  and "'.Carbon::yesterday()->toDateString().' 23:59:59"');

    }
}
