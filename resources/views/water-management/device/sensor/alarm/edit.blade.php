@extends('components.modals.form-modal')
@section('modal-title','Crear Alarma para el sensor: '.$sensor->name)
@section('modal-content')
    <form class="" role="form"  id="alarm-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Rango Minimo (Valor a comparar en caso de variable Digital)</label>
            <input type="text" class="form-control" id="range_min" name="range_min" value="{{ $alarm->range_min }}">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Maximo</label>
            <input type="text" class="form-control" id="range_max" name="range_max" value="{{ $alarm->range_max }}">
        </div>
        <div class="form-group">
            <label class="form-label">Opciones</label><br>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="1" name="is_active" @if($alarm->is_active == 1) checked @endif>
                <span class="custom-control-label">Habilitada</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="1" name="send_email" @if($alarm->send_email == 1) checked @endif>
                <span class="custom-control-label">Enviar Mail</span>
            </label>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td>
                                <label class="form-label">Grupo</label><br>
                                <label class="custom-control custom-checkbox">

                                    <input type="checkbox" class="custom-control-input" value="{{ $group->id }}" name="group_id[]" @if($alarm->notifications()->where('group_id',$group->id)->first()) checked @endif>
                                    <span class="custom-control-label">{{ $group->name }}</span>
                                </label></td>
                            <td>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <select name="{{ $group->id }}_mail_id" id="{{ $group->id }}_mail_id" class="form-control">
                                        <option value="">Seleccione...</option>
                                        @foreach($mails as $mail)
                                            @if(optional($alarm->notifications()->where('group_id',$group->id)->first())->mail_id == $mail->id)
                                                <option value="{{ $mail->id }}" selected>{{ $mail->name }}</option>
                                            @else
                                                <option value="{{ $mail->id }}">{{ $mail->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="form-label">Recordatorio</label>
                                    <select name="{{ $group->id }}_reminder_id" id="{{ $group->id }}_reminder_id" class="form-control">
                                        <option value="">Seleccione...</option>
                                        @foreach($mails as $mail)
                                            @if(optional($alarm->notifications()->where('group_id',$group->id)->first())->reminder_id == $mail->id)
                                                <option value="{{ $mail->id }}" selected>{{ $mail->name }}</option>
                                            @else
                                                <option value="{{ $mail->id }}">{{ $mail->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>No ha creado grupos</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#alarm-form','/sensor-alarms/'.$alarm->id, "tableReload(); closeModal();") !!}
@endsection
