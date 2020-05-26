<div class="px-2 py-1 {{ $class }} rounded overflow-hidden position-relative text-white mb-1 text-center " >
    <div class="">
        <h3 class="display-4 d-block l-h-n m-0 fw-500" >
            <span class="text-white"  id="" >
                {{ $value }}
                <span class="fs-nano">
                    {{ strtoupper($unit) }}
                </span>

            </span>
            <small class="m-0 l-h-n font-weight-bolder">{{ $sensor_name}}</small>
        </h3>
    </div>
</div>
