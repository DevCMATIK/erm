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
    <p>Haga click en el siguiente enlace para ir a la página de descarga:</p>
    <p>
        <a href="https://erm.cmatik.app/descargar-archivos/{{ $file->id }}" target="_blank">Click Aqui</a><br>
    </p>
    <p><br></p>
    <p>Saludos Cordiales</p>
    <p>ERM® CMATIK</p>
@endsection
