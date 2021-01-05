@extends('components.modals.form-modal')
@section('modal-title','Crear Area de produccion')
@section('modal-content')
    {!! includeCss('plugins/duallistbox/duallistbox.css') !!}
    {!! includeScript('plugins/duallistbox/duallistbox.js') !!}

                        <form id="production-area-users">
                            @csrf
                            <select name="users[]" id="usersAreaList" class="form-control" multiple>
                                @foreach($users as $user)
                                    @if($production_area->users->contains($user->id))
                                        <option value="{{ $user->id }}" selected>{{ $user->full_name }}</option>
                                    @else
                                        <option value="{{ $user->id }}" >{{ $user->full_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </form>

    <script>
        $('#usersAreaList').bootstrapDualListbox({
            nonSelectedListLabel: 'Listado de Usuarios',
            selectedListLabel: 'Usuarios del Área',
            preserveSelectionOnMove: 'moved'
        });


    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#production-area-users','/production-area/'.$production_area->id.'/users', "tableReload(); closeModal();") !!}
@endsection
