<div style="margin: 0 !important;" class="p-3 m-0 mb-1 {{ $bg ?? 'bg-primary-300' }} {{ (isset($extraClasses))?implode(' ',$extraClasses):'' }} rounded  text-white @if($value > 99999999 && $value < 1000000000) pb-2 pt-4 @endif @if($value > 999999999) pb-2 pt-5 @endif">
    <div class="">
        <h3 class="display-4 d-block l-h-n m-0 fw-500 main-box-number" @if($value > 99999999 && $value < 1000000000) style="font-size:2.5em;" @endif @if($value > 999999999) style="font-size:2.1em;" @endif>
            <div class="main-box-value" style="margin: 0; float: left; margin-right:3px;">
                {{ number_format($value,0,',','.') }}
            </div>
            <span class="fs-nano main-box-measure" >
                    {{ $measure }}
                </span>
            <small class="m-0 l-h-n box-label" >{{ $title }}</small>
        </h3>
    </div>
    <i class="fas {{ $icon ?? 'fa-database' }} position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1 main-box-icon" style="font-size:6rem "></i>
</div>
