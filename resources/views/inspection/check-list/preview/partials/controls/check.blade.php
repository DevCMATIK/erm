<h6 class="fs-sm text-muted">{{ \Illuminate\Support\Str::upper($control->name) }}</h6>
@foreach(explode(';',$control->values) as $value)
    <div class="custom-control custom-checkbox">
        <input type="checkbox" value="{{ $value }}" class="custom-control-input" id="{{ \Illuminate\Support\Str::slug($control->name).'-'.\Illuminate\Support\Str::slug($value)  }}" name="{{ \Illuminate\Support\Str::slug($control->name) }}[]">
        <label class="custom-control-label fs-xs" for="{{ \Illuminate\Support\Str::slug($control->name).'-'.\Illuminate\Support\Str::slug($value)  }}">{{ ucwords($value) }}</label>
    </div>
@endforeach
