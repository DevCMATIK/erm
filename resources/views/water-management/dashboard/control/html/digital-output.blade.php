<style>
    #d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}} .onoffswitch-inner:before {
        content: "{{ strtoupper($digital_sensor->sensor->label->on_label) }}";
    }
    #d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}} .onoffswitch-inner:after {
        content: "{{ strtoupper($digital_sensor->sensor->label->off_label) }}";
    }
</style>
@if($off)
    <label class="m-0 mb-n1 font-weight-bolder text-dark " style="font-size: 0.7em !important;" for="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">{{ strtoupper($digital_sensor->sensor->name) }}</label>
    <div class="d-block @if($off) bg-fusion-50 @else bg-{{ $class }} @endif  rounded-plus mb-2 px-2 py-2 text-center text-white"  style="font-size: 0.8em !important; max-width: 120px;" id="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">
        {{ strtoupper($data) }}
    </div>
@else
    <label class="m-0 mb-n1 font-weight-bolder " style="font-size: 0.7em !important;" for="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">{{ strtoupper($digital_sensor->sensor->name) }}</label>
    <div class="onoffswitch" id="d_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}">
        <input type="checkbox" name="switch_{{ $digital_sensor->sensor->device->internal_id }}_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}_{{ $digital_sensor->sensor->address->name }}_{{ $digital_sensor->sensor->address_number }}" class="onoffswitch-checkbox" id="switch_{{ $digital_sensor->sensor->device->internal_id }}_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}_{{ $digital_sensor->sensor->address->name }}_{{ $digital_sensor->sensor->address_number }}"  @if($digital_sensor->sensor->device->report->$address == 1) checked @endif>
        <label class="onoffswitch-label" for="switch_{{ $digital_sensor->sensor->device->internal_id }}_{{$digital_sensor->id}}_{{$digital_sensor->sensor->id}}_{{ $digital_sensor->sensor->address->name }}_{{ $digital_sensor->sensor->address_number }}">
            <span class="onoffswitch-inner"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </div>
@endif


