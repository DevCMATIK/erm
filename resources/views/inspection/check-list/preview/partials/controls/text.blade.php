<div class="form-group input-group-sm mb-1">
    <label class="form-label fs-xs text-muted">{{ \Illuminate\Support\Str::upper($control->name) }}</label>
    <input type="text" class="form-control" name="{{ \Illuminate\Support\Str::slug($control->name) }}">
</div>
