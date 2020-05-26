@extends('layouts.modal.layout')
@section('modal-icon','fa-list-ol')
@section('modal-title','Serializar Sequiencia')
@section('modal-content')
    {!! printCss(['libs/nestable/nestable.css']) !!}
    {!! printScript([
        'libs/nestable/nestable.js',
        'libs/jstree/jstree.js'
    ]) !!}

        <div class="col-md-12">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    @php $x = 1; @endphp
                    @foreach($imports as $import)
                        <li class="dd-item" data-id="{{ $import->id }}">
                            <div class="dd-handle"> {{ $import->name }}</div>
                        </li>
                        @php $x++; @endphp
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="queuedImport-serialization-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Json Fields</label>
            <textarea id="nestable-output" name="fields" class="form-control input-sm"></textarea>
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
            $('#nestable').nestable({ group: 1,maxDepth: 1 }).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });
    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#queuedImport-serialization-form','serializeQueuedImport/'.$queue->id, "closeModal();") !!}
@endsection
@section('modal-width','50')
