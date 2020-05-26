<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white py-1 my-1 text-center">
                {{ \Illuminate\Support\Str::upper($module->name) }}
            </div>
            <div class="card-body">
                <div class="row p-0">
                    @forelse($module->sub_modules as $sub)
                        @include('inspection.check-list.preview.partials.sub-module')
                    @empty
                        <div class="col-lg-12">
                            <div class="alert alert-info">
                                No ha creado sub modulos
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Observaciones</label>
                            <textarea name="observation" class="form-control mt-2" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
