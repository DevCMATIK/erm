@extends('layouts.app-blank')
@section('page-title')
    Descargar Archivos solicitados
@endsection
@section('page-icon','download')
@section('page-content')
    <div class="row">
        <div class="col-12 col-xl-6 col-md-6 col-lg-6  offset-xl-3 offset-md-3 offset-lg-3">
            <div class="alert alert-info">
                <strong>Hola:</strong><br>
                Se han generado los siguientes link de descarga, según la solicitud hecha en : <strong> {{ $reminder->creation_date ?? 'null' }}</strong><br> por <strong> {{ $reminder->user->first_name }} {{ $reminder->user->last_name }}</strong>
            </div>

            <ul class="list-group">
                @forelse ($reminder->files->unique('display_name') as $file)

                    <a href="{{ '/download-file/'.$file->id }}" class="list-group-item mb-1"><i class="fas fa-file-excel"></i> {{ \Illuminate\Support\Str::slug($file->display_name,'_').'.xlsx' }}</a>

                @empty
                    <li class="list-group-item">
                        No se han encontrado archivos para descargar...
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection
@section('more-scripts')

@endsection
@section('page-extra-scripts')



@endsection
