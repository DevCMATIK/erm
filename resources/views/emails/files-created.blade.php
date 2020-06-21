@extends('emails.base')
@section('mail-header')
   Archivos Generados Correctamente!
@endsection
@section('mail-content')
    <p>
        <span style="font-size: 18px;">﻿</span>
        <span style="font-size: 18px;">﻿</span>
        <b>
            <span style="font-size: 12px;">
                <span style="font-size: 18px;">{{ $user->full_name }}</span>,
            </span>
        </b>
    </p>
    <p>Se han generado los archivos solicitados en {{ $reminder->creation_date }}</p>
    <p>Haga click en los siguientes enlaces para descargar:</p>
    <p>
        @foreach($files as $file)
            <a href="https://erm.cmatik.app/download-file/{{ $file->id }}" target="_blank">{{ $file->display_name }}</a><br>
        @endforeach
    </p>
    <p>
        <span style="font-size: 0.8125rem; letter-spacing: 0.1px;">Estos enlaces expiran en {{ $reminder->expires_at }}</span><br>
    </p>
    <p><br></p>
    <p>Saludos Cordiales</p>
    <p>ERM® CMATIK</p>
@endsection
