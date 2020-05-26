@extends('components.modals.form-modal')
@section('modal-title','Modificar Trigger')
@section('modal-content')
    {!! includeCss('plugins/select2/select2.css') !!}


    <form class="" role="form"  id="trigger-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Receptores</label>
            <select name="receptor_id" class="form-control select2">
                <option value="">Seleccione...</option>

                @foreach($devices as $device)
                    @if(count($device->sensors) > 0)
                        <optgroup label="{{ $device->check_point->sub_zones->first()->name }}-{{ $device->name }}">
                            @foreach($device->sensors as $s)
                                @if($s->id == $trigger->receptor_id)
                                    <option value="{{ $s->id }}" selected>{{ strtoupper($s->full_address) }}-{{ $s->name }}</option>
                                @else
                                    <option value="{{ $s->id }}">{{ strtoupper($s->full_address) }}-{{ $s->name }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
        </div>
        @if($sensor->address->configuration_type == 'scale')
            <div class="form-group">
                <label class="form-label">Rango minimo</label>
                <input type="text" class="form-control"  name="range_min" value="{{ $trigger->range_min }}">
            </div>
            <div class="form-group">
                <label class="form-label">Rango Maximo</label>
                <input type="text" class="form-control"  name="range_max" value="{{ $trigger->range_max }}">
            </div>
            <div class="form-group">
                <label class="form-label">Comando a ejecutar cuando mayor que maximo</label>
                <select name="in_range" class="form-control">
                    @if($trigger->in_range === 1)
                        <option value="1" selected>Enviar 1</option>
                        <option value="0">Enviar 0</option>
                    @else
                        <option value="1">Enviar 1</option>
                        <option value="0" selected>Enviar 0</option>
                    @endif
                </select>
            </div>
        @else
            <div class="alert alert-info">
                <strong>Nota: si solo indica valor "cuando es 1" no aplicará ningún cambio en cualquier otro caso</strong>
            </div>
            <div class="form-group">
                <label class="form-label">Cuando es uno</label>
                <input type="text" class="form-control"  name="when_one" value="{{ $trigger->when_one }}">
            </div>
            <div class="form-group">
                <label class="form-label">Cuando es Cero</label>
                <input type="text" class="form-control"  name="when_zero" value="{{ $trigger->when_zero }}">
            </div>
        @endif

        <div class="form-group">
            <label class="form-label">Ejecutar Cada</label>
            <select name="minutes" class="form-control">
                <option value="">Seleccione...</option>
                @switch($trigger->minutes)
                    @case(1)
                        <option value="1" selected>1 Minuto</option>
                        <option value="5">5 Minutos</option>
                        <option value="10">10 Minutos</option>
                    @break
                    @case(5)
                        <option value="1">1 Minuto</option>
                        <option value="5" selected>5 Minutos</option>
                        <option value="10">10 Minutos</option>
                    @break
                    @case(10)
                        <option value="1">1 Minuto</option>
                        <option value="5">5 Minutos</option>
                        <option value="10" selected>10 Minutos</option>
                    @break
                @endswitch
            </select>
        </div>
    </form>
    {!! includeScript('plugins/select2/select2.js') !!}
    <script>

        function modelMatcher (params, data) {
            data.parentText = data.parentText || "";

            // Always return the object if there is nothing to compare
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do a recursive check for options with children
            if (data.children && data.children.length > 0) {
                // Clone the data object if there are children
                // This is required as we modify the object to remove any non-matches
                var match = $.extend(true, {}, data);

                // Check each child of the option
                for (var c = data.children.length - 1; c >= 0; c--) {
                    var child = data.children[c];
                    child.parentText += data.parentText + " " + data.text;

                    var matches = modelMatcher(params, child);

                    // If there wasn't a match, remove the object in the array
                    if (matches == null) {
                        match.children.splice(c, 1);
                    }
                }

                // If any children matched, return the new object
                if (match.children.length > 0) {
                    return match;
                }

                // If there were no matching children, check just the plain object
                return modelMatcher(params, match);
            }

            // If the typed-in term matches the text of this term, or the text from any
            // parent term, then it's a match.
            var original = (data.parentText + ' ' + data.text).toUpperCase();
            var term = params.term.toUpperCase();


            // Check if the text contains the term
            if (original.indexOf(term) > -1) {
                return data;
            }

            // If it doesn't contain the term, don't return anything
            return null;
        }
        $(document).ready(function(){
            $(".select2").select2({
                width: '100%' ,
                dropdownParent: $('.modal'),
                matcher: modelMatcher
            });
        });


    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#trigger-form','/sensor-triggers/'.$trigger->id, "tableReload(); closeModal();") !!}
@endsection
