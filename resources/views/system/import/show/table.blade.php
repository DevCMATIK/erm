@section('more-css')
    {!! includeCss('plugins/datatables/datatables.blunde.css') !!}
@endsection
<div class="row">
    <div class="col-xl-12">

        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Listado de módulos de importación
                </h2>
                <div class="panel-toolbar">`
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <table class="datatables-demo table table-striped table-bordered" id="table-generated">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Importaciones</th>
                            <th>Importar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($imports as $import)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $import->name }}</td>
                                <td>{{ $import->description }}</td>
                                <td>{{ $import->files_count }}</td>
                                <td><a href="importFile/{{ $import->slug }}" class="btn btn-primary btn-xs">Ir a importar</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('more-scripts')
    {!! includeScript('plugins/datatables/datatables.blunde.js') !!}
    {!! getTableScript() !!}
@endsection

