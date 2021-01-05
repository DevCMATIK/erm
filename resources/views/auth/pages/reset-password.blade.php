@extends('auth.main')
@section('auth-content')
    <h4 class="text-center text-lighter font-weight-normal mt-5 mb-0">Cambiar mi Contraseña</h4>

    <!-- Form -->
    <form class="my-5" id="reset-password-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Nueva Contraseña</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label class="form-label">Re-ingrese contraseña</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>
        <div class="d-flex justify-content-between  m-0">
            <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
        </div>
    </form>
    <!-- / Form -->

    <div class="text-center text-muted">
        <a href="{{ route('main.login') }}"> Volver Al Login</a>
    </div>
@endsection
@section('validation')
    {!! makeValidation('#reset-password-form',"/reset/$user->email/$code", "location.href = '/';") !!}
@endsection
