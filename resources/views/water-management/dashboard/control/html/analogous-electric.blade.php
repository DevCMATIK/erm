@php
    if($analogous_sensor->sensor->type->slug == 'ee-energia') {
        $class = 'bg-success-500';
        $icon = 'fa-battery-bolt';
    }elseif($analogous_sensor->sensor->type->slug == 'ee-corriente'){
        $class = 'bg-warning-500';
        $icon = 'fa-bars';
    } elseif($analogous_sensor->sensor->type->slug == 'ee-potencia'){
        $class = 'bg-danger-500';
        $icon = 'fa-tachometer';
    }else {
        $class = 'bg-primary-500';
        $icon = 'fa-bolt';
    }
@endphp
<div class="p-3 {{ $class }} rounded overflow-hidden position-relative text-white mb-g " >

       <div class="">
             <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                <a class="text-white" href="/getDataAsChart/{{ $analogous_sensor->sensor->device_id }}/{{ $analogous_sensor->sensor->id }}"  {!! makeLinkRemote() !!} id="" >
                    @if(is_string($data))
                       {{ $data }}
                    @else
                        {{ $data }}<span class="fs-nano">
                        {{ strtoupper(optional(optional($disposition)->unit)->name) }}</span>
                    @endif
                </a>
                <small class="m-0 l-h-n">{{ $analogous_sensor->sensor->name}}</small>
             </h3>
       </div>
        <i class="fas {{ $icon }} position-absolute pos-right pos-bottom opacity-15 mb-2 mr-1" style="font-size:5rem"></i>
</div>



