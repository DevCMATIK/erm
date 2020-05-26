@extends('layouts.app')
@section('page-title','Administrar Grupos')
@section('page-icon','cog')
@section('more-css')
    {!! includeCss('plugins/duallistbox/duallistbox.css') !!}
@endsection
@section('more-scripts')
    {!! includeScript('plugins/duallistbox/duallistbox.js') !!}
@endsection
@section('page-description')
    {!! makeLink('/groups','Administrar Grupos','fa-users', 'btn-primary float-right') !!}
    {!! makeLink('/users','Administrar Usuarios','fa-user', 'btn-info float-right mr-1') !!}
@endsection
@section('page-content')

    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Administrar usuarios de grupo
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       <div class="row">
                           <div class="col-md-3">
                               <ul class="list-group mb-6">
                                   @forelse($groups as $group)
                                       <li class="list-group-item">
                                           <a href="javascript:void(0);" onclick="getUsersFromGroup({{ $group->id }})" id="group_{{ $group->id }}" class="group-item text-contrast">
                                               <i class="fas fa-users"></i>
                                               {{ $group->name }}
                                           </a>
                                       </li>
                                   @empty
                                       <li class="list-group-item">No ha creado Grupos</li>
                                   @endforelse
                               </ul>
                           </div>
                           <div class="col-md-9" id="list-group-users">
                                <div class="alert alert-info">
                                    <strong>Nota:</strong>
                                    Seleccione un grupo para administrar los usuarios.
                                </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getUsersFromGroup(group_id) {
            $('.group-item').removeClass('text-white').parent().removeClass('active text-white');
            $('#group_'+group_id).addClass('text-white').parent().addClass('active');
            getView('getUsersFromGroup/'+group_id,'#list-group-users');

        }
    </script>

@endsection

