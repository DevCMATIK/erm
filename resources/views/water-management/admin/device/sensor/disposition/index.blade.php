@extends('components.modals.form-modal')
@section('modal-title','Lineas de disposición')

@section('modal-content')
    <script>
        $(document).ready(function(){

        });
        function addLine()
        {

            $.get('/addNewLine', function(data) {
                $('#disposition-lines-form').append(data);
            });
        }

        function deleteLine(line)
        {
            $.get('/deleteLineInDisposition/'+line, function(data) {
                $('#dline-'+line).remove();
                toastr.success('Linea eliminada');
            });
        }
    </script>
    <h5>Disposicion actual: {{ $disposition->name }}</h5>
    <a href="javascript:void(0);" class="btn btn-primary float-right" onclick="addLine()">Agregar Linea</a><br><br><br>
    <form class="" role="form"  id="disposition-lines-form">
        @csrf
        @forelse($disposition->lines as $line)
            <div class="border p-2 my-1" id="dline-{{ $line->id }}">
                <a href="javascript:void(0);" class="btn btn-danger btn-sm float-right" onclick="deleteLine({{ $line->id }})"><i class="fas fa-times"></i></a><br><br><br>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Gráfico</label>
                            <select name="chart[]" class="form-control">
                                @switch($line->chart)
                                    @case('default')
                                        <option value="default" selected>Por Defecto</option>
                                        <option value="averages">Promedios</option>
                                        <option value="daily-averages">Promedios Diarios</option>
                                    @break
                                    @case('averages')
                                        <option value="default">Por Defecto</option>
                                        <option value="averages" selected>Promedios</option>
                                        <option value="daily-averages">Promedios Diarios</option>
                                    @break
                                    @case('daily-averages')
                                        <option value="default">Por Defecto</option>
                                        <option value="averages">Promedios</option>
                                        <option value="daily-averages" selected>Promedios Diarios</option>
                                    @break
                                @endswitch
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Color</label>
                            <select name="color[]" class="form-control">
                                @switch($line->color)
                                    @case('green')
                                    <option value="green" selected>Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue">Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    @break
                                    @case('red')
                                    <option value="green">Verde</option>
                                    <option value="red" selected >Roja</option>
                                    <option value="blue">Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    @break
                                    @case('blue')
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" selected>Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    @break
                                    @case('yellow')
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow" selected>Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    @break
                                    @case('black')
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black" selected>Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    @break
                                    @case('gray')
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow" >Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray" selected>Ploma</option>
                                    <option value="orange">Naranja</option>
                                    @break
                                    @case('orange')
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange" selected>Naranja</option>
                                    @break
                                @endswitch

                            </select>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Valor</label>
                            <input type="text" class="form-control" name="value[]"  value="{{ $line->value }}">
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Nombre de la Línea</label>
                            <input type="text" class="form-control" name="text[]" value="{{ $line->text }}">
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="border p-2 my-1">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Gráfico</label>
                            <select name="chart[]" class="form-control">
                                <option value="default">Por Defecto</option>
                                <option value="averages">Promedios</option>
                                <option value="daily-averages">Promedios Diarios</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Color</label>
                            <select name="color[]" class="form-control">
                                <option value="green">Verde</option>
                                <option value="red">Roja</option>
                                <option value="blue">Azul</option>
                                <option value="yellow">amarilla</option>
                                <option value="black">Negra</option>
                                <option value="gray">Ploma</option>
                                <option value="orange">Naranja</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Valor</label>
                            <input type="text" class="form-control" name="value[]" >
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Nombre de la Línea</label>
                            <input type="text" class="form-control" name="text[]">
                        </div>
                    </div>
                </div>
            </div>

        @endforelse
    </form>

@endsection
@section('modal-validation')
    {!!  makeValidation('#disposition-lines-form','/disposition-lines/'.$disposition->id, " ") !!}
@endsection
