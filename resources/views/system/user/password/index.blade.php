@extends('components.modals.form-modal')
@section('modal-title','Resetear contraseña de usuario: ' . $user->full_name)
@section('modal-content')
    <form class="" role="form"  id="userPassword-form">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control"  name="email" readonly value="{{ $user->email }}" >
                </div>
            </div>
        </div>
    </form>
    <p class="note"><strong>Nota: </strong>Solo use este módulo en caso de que el usuario no reciba el correo de reseteo de contraseña.</p>
    <p class="note"><strong>Nota: </strong>La Contraseña será cambiada y mostrada en este mismo pop-up. no lo cierre hasta que copie la contraseña</p>
@endsection
@section('modal-validation')
    {!!  makeValidation('#userPassword-form','/userPasswordReset', "") !!}
@endsection
@section('modal-width','40')
@section('no-submit')
    <button type="button" class="btn btn-danger" onClick="$('.modal-content form').submit();">Cambiar Contraseña</button>
@endsection
