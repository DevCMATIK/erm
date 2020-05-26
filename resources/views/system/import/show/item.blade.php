
	@foreach($imports->chunk(5) as $chunk)
        <div class="row">
            @foreach($chunk as $import)
				<div class="col">
					<div class="card">
						<div class="card-header">
							<b>{{ ucwords($import->name) }}</b>
						</div>
						<div class="card-body">
							{{ substr($import->description,0,20) }}...
						</div>
						<div class="card-footer">
							<a href="importFile/{{ $import->slug }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-upload"></i> Importar</a>
						</div>
					</div>
				</div>
            @endforeach
        </div>
        <hr>
	@endforeach


