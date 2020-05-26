<div class="col-lg-{{ $sub->columns * 4 }}">
    @if(count($sub->controls) > 0)
        <div class="card my-1">
            @if($sub->name)
                <div class="card-header bg-primary text-center text-white p-1">
                    {{ \Illuminate\Support\Str::upper($sub->name) }}
                </div>
            @endif
            <div class="card-body p-1">
                @include('inspection.check-list.preview.partials.controls')
            </div>
        </div>
    @endif
</div>

