<div class="form-group input-group-sm mb-1">
    <label class="form-label fs-xs text-muted">{{ \Illuminate\Support\Str::upper($control->name) }}</label>
    <select name="{{ \Illuminate\Support\Str::slug($control->name) }}" class="form-control">
        @foreach(explode(';',$control->values) as $value)
            <option value="{{ ucwords($value) }}">{{ ucwords($value) }}</option>
        @endforeach
    </select>
</div>
