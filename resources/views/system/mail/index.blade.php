@extends('layouts.app')
@section('page-title','Emails')
@section('page-icon','envelope')
@section('page-content')
    <div class="row">
        <div class="col-xl-12">
            <div class="float-right">
                @if(Sentinel::getUser()->hasAccess('mails.create'))
                    {!! makeLink('mails/create','Crear Nuevo','fa-plus' ,'btn-primary','btn-sm') !!}
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Listado de registros
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        {!! makeTable(['Creador','nombre','Asunto','Conectores','Acciones']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('more-css')
    {!! includeCss('plugins/datatables/datatables.blunde.css') !!}
@endsection
@section('more-scripts')
    {!! includeScript('plugins/datatables/datatables.blunde.js') !!}
    {!! getAjaxTable('mails') !!}
@endsection



