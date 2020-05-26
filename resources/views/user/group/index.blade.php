@extends('layouts.app')
@section('page-title','Administrar Grupos de '.$user->full_name)
@section('page-icon','cog')
@section('more-css')
    {!! includeCss('plugins/duallistbox/duallistbox.css') !!}
@endsection
@section('more-scripts')
    {!! includeScript('plugins/duallistbox/duallistbox.js') !!}
@endsection
@section('page-description')
    {!! makeLink('/users','Volver a usuarios','fa-arrow-left', 'btn-primary float-right') !!}
@endsection
@section('page-extra-scripts')
    <script>
        $('#usersGroupList').bootstrapDualListbox({
            nonSelectedListLabel: 'Listado de grupos',
            selectedListLabel: 'Grupos del usuario',
            preserveSelectionOnMove: 'moved'
        });


    </script>
    {!!  makeValidation('#user-group-form','/handleUserGroups/'.$user->id,'') !!}
@endsection
@section('page-content')
    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Administrar Grupos
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form id="user-group-form">
                            @csrf
                            <select name="groups[]" id="usersGroupList" class="form-control" multiple>
                                @foreach($groups as $group)
                                    @if($user->groups->contains($group))
                                        <option value="{{ $group->id }}" selected>{{ $group->name }}</option>
                                    @else
                                        <option value="{{ $group->id }}" >{{ $group->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-info btn-block">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

