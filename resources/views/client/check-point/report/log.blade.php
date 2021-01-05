@extends('components.modals.form-modal')
@section('modal-title','Log de reportes a DGA')
@section('modal-content')
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Punto de control</th>
                    <td>{{  $check_point->name }}</td>
                </tr>
                <tr>
                    <th>Sub Zona</th>
                    <td>{{  $check_point->sub_zones()->first()->name }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            {!! makeTable(['Codigo respuesta','texto respuesta','totalizador','caudal','nivel freático','fecha reporte'],false,'table-log') !!}
        </div>
    </div>
    {!! getAjaxTable2('check-point/dga-reports/'.$check_point->id,'table-log') !!}
@endsection
@section('no-submit')
    .
@endsection
