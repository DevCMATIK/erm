@extends('components.modals.form-modal')
@section('modal-title','Modificar columnas')
@section('modal-content')
    {!! includeCss(['plugins/nestable/nestable.css']) !!}
    {!! includeScript([
        'plugins/nestable/nestable.js',
        'plugins/jstree/jstree.js'
    ]) !!}
    <div class="row">
        <div class="col-md-2">
            @php
                $i = 1;
            @endphp
            <div class="dd" id="fields-list">
                <ol class="dd-list">
                    @foreach($fields as $f)

                        <li class="dd-item">
                            <div class="dd-handle"> {{ numToAlpha($i) }}
                            </div>
                        </li>
                        @php $i++ @endphp
                    @endforeach
                </ol>
            </div>
        </div>
        <div class="col-md-10">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    @php $x = 1; @endphp
                    @foreach($fields as $f)
                        <li class="dd-item" data-id="{{ $f }}">
                            <div class="dd-handle"> {{ $f }}
                                <span class="label label-primary float-right">{{ numToAlpha($x) }}</span>
                            </div>
                        </li>
                        @php $x++; @endphp
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="import-serialization-form">
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
    {!!  makeValidation('#import-serialization-form','serializeImport/'.$import->id, "closeModal();") !!}
@endsection
@section('modal-width','50')
