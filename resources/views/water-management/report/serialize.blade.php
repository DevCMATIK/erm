@extends('components.modals.form-modal')
@section('modal-title','Serializar Sensores')
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
                    @foreach($mailReport->sensors as $sensor)

                        <li class="dd-item border" data-id="{{ $sensor->id }}">
                            <div class="dd-handle">
                                <span class="fas fa-circle}}"></span>&nbsp;{{ $sensor->device->sub_element->first()->element->sub_zone->name }} -
                                {{ $sensor->device->name}} -
                                {{ $sensor->full_address}}
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="sensors-serialization-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Json Sensors</label>
            <textarea id="nestable-output" name="sensors" class="form-control input-sm"></textarea>
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
            $('#nestable').nestable({ group: 1 , maxDepth: 1}).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });
    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#sensors-serialization-form','/mailReportSerialization/'.$mailReport->id, "") !!}
@endsection
