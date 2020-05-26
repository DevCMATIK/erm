@extends('components.modals.form-modal')
@section('modal-title','Ordenar Zonas')
@section('modal-content')
    {!! includeCss(['plugins/nestable/nestable.css']) !!}
    {!! includeScript([
        'plugins/nestable/nestable.js',
        'plugins/jstree/jstree.js'
    ]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    @foreach($zones as $zone)

                        <li class="dd-item border" data-id="{{ $zone->id}}">
                            <div class="dd-handle">
                                 {{ $zone->name }}
                                <span class="label label-primary float-right">{{ $zone->position }}</span>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="zone-serialization-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Json Menu</label>
            <textarea id="nestable-output" name="zone" class="form-control input-sm"></textarea>
        </div>

    </form>
    <script>
        // Nestable
        $(function() {
            function updateOutput(e) {
                var list   = e.length ? e : $(e.target);
                var output = list.data('output');

                output.val(window.JSON ? window.JSON.stringify(list.nestable('serialize')) :
                    'JSON browser support required for this demo.');
            };
            $('#nestable').nestable({ group: 1 , maxDepth: 3}).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });
    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#zone-serialization-form','/zoneSerialization', "tableReload(); closeModal();") !!}
@endsection
