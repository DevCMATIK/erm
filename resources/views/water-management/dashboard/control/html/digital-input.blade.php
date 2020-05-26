@if(isset($is_output) && $is_output === true)
    <label class="m-0 mb-n1 font-weight-bolder text-dark " style="font-size: 0.7em !important;" for="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">{{ strtoupper($digital_sensor->sensor->name) }}</label>
    <div class="d-block @if($off) bg-fusion-50 @else bg-{{ $class }} @endif  rounded-plus mb-2 px-2 py-2 text-center text-white"  style="font-size: 0.8em !important; max-width: 120px;" id="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">
        {{ strtoupper($data) }}
    </div>
@else
    <label class="m-0 mb-n1 font-weight-bolder text-dark " style="font-size: 0.7em !important;" for="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">{{ strtoupper($digital_sensor->sensor->name) }}</label>
    <div class="d-block @if($off) bg-fusion-50 @else bg-{{ $class }} @endif rounded-plus mb-2 px-2 py-2 text-center text-white"  style="font-size: 0.8em !important; max-width: 120px;" id="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">
        {{ strtoupper($data) }}
    </div>
@endif

