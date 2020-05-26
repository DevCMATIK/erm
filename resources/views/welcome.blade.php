@extends('layouts.app')
@section('page-title','Inicio')
@section('page-icon','fa-home')
@section('page-description','Bienvenido/a '.Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name)
@section('page-content')
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Telemetria
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-6">
                                <img src="{{ asset('images/logo2.png') }}" style="width: 60%;" alt="">

                                <blockquote class="blockquote">
                                    <p class="mb-0">Somos un equipo de profesionales que cuenta con 10 años de experiencia, entregando soluciones en ingeniería de automatización, desarrollo de aplicaciones y tecnologías de innovación.</p>
                                    <footer class="blockquote-footer">- Cmatik</footer>
                                </blockquote>
                            </div>
                            <div class="col-6">
                                <img src="{{ asset('images/cmatik.png') }}" style="width: 100%;" alt="">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
