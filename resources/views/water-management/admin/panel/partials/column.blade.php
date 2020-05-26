<div class="form-group">
    <input type="text"
           class="form-control column_name"
           id="column_name_{{$subZone->id}}_{{$i}}"
           placeholder="Nombre Columna Ej: Pozos"
           @if($element = $subZone->elements()->where('column',$i)->first())
             value="{{ $element->name }}"
            @endif
    >
</div>
