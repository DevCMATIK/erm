@extends('auth.main')
@section('page-title','Forgot Password')
@section('auth-content')
    <h4 class="text-center text-lighter font-weight-normal mt-5 mb-0">Recuperar Contraseña</h4>

    <!-- Form -->
    <form class="my-5" id="forgot-password-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Correo electrónico</label>
            <input type="text" class="form-control" name="email">
        </div>

        <div class="d-flex justify-content-between  m-0">
            <button type="submit" class="btn btn-primary btn-block">Envíame e-mail de recuperación</button>
        </div>
    </form>
    <!-- / Form -->

    <div class="text-center text-muted">
        Recordaste tu contraseña?,
        <a href="{{ route('main.login') }}"> Volver Al Login</a>
    </div>
@endsection
@section('validation')
    {!! makeValidation('#forgot-password-form','/forgot-password', "location.href = '/';") !!}
@endsection
