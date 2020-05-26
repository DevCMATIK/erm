@extends('layouts.app')
@section('page-title','Vista Previa')
@section('page-icon','eye')

@section('page-content')

    <div class="row">
      <div class="col-12">
          <div class="card">
              <div class="card-header text-center">
                  {{ \Illuminate\Support\Str::upper($checkList->name) }}
                  {!! makeLink('/check-lists','Check Lists','fa-check-square','btn-info','btn-sm float-right') !!}
              </div>
              <div class="card-body p-1">
                  @forelse($checkList->modules as $module)
                        @include('inspection.check-list.preview.partials.module')
                  @empty
                    <div class="alert alert-info">
                        Debe crear modulos para visualizar mas informacion
                    </div>
                  @endforelse
              </div>
          </div>
      </div>
    </div>
@endsection
