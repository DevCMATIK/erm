@extends('auth.main')

@section('auth-content')
    <form id="login-form">
        @csrf
        <div class="form-group">
            <label class="form-label" for="username">E-mail</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="email" value="">
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Contraseña</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="******" value="">

        </div>
        <div class="form-group text-left">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="rememberMe" id="rememberme">
                <label class="custom-control-label" for="rememberme"> Recuérdame</label>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('main.forgot-password') }}" class="btn btn-link">Olvidó su contraseña?</a>
            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-lg-12 pr-lg-1 my-2">
                <button type="submit" class="btn btn-info btn-block btn-lg">Ingresar</button>
            </div>
        </div>
    </form>
@endsection
@section('validation')
    {!! makeValidation('#login-form','/login',"location.href = '/';") !!}
@endsection

