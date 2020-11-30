<div class="p-2 {{ $bg ?? 'bg-primary-300' }} {{ (isset($extraClasses))?implode(' ',$extraClasses):'' }} rounded overflow-hidden position-relative text-white @if(isset($mb)) {{ $mb }} @else mb-g @endif @if(strlen($value) > 8 && strlen($value) < 10) pb-1 pt-2 @endif @if(strlen($value) >= 10) pb-1 pt-3 @endif">
    <div class="">
        <h3 class="display-4 d-block l-h-n m-0 fw-900" @if(strlen($value) > 8 && strlen($value) < 10) style="font-size:2.5em;" @endif @if(strlen($value) >= 10) style="font-size:2.1em;" @endif>
            <div class="data-box-value" style="margin: 0; float: left; margin-right:5px;">
                @if($value < 0) C/D @else {{ number_format($value,0,',','.') }} @endif
            </div>
            <span class="fs-nano">
                    {{ $measure }}
                </span>
            <small class="m-0 l-h-n fw-700">{{ $title }}</small>
        </h3>
    </div>
</div>

