@extends('components.modals.form-modal')
@section('modal-title','Modificar Usuario')
@section('modal-content')
    <form class="" role="form"  id="user-form">
        @csrf
        @method('put')
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control"  name="first_name" value="{{ $user->first_name }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control"  name="last_name" value="{{ $user->last_name }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-label">Telefono EJ: 56956996921 (número completo)</label>
                    <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                </div>
            </div>
        </div>
        <hr>
        <h5>Roles</h5>
        @foreach($roles as $r)
            <label class="custom-control custom-checkbox">
                <input type="checkbox" @if($user->inRole($r->slug)) checked @endif class="custom-control-input" value="{{ $r->id }}" name="roles[]">
                <span class="custom-control-label">{{ $r->name }}</span>
            </label>
        @endforeach

        <hr>
        <h5>Grupos</h5>
        @foreach($groups as $g)
            <label class="custom-control custom-checkbox">
                <input type="checkbox"  class="custom-control-input" @if($user->inGroup($g->slug)) checked @endif value="{{ $g->id }}" name="groups[]">
                <span class="custom-control-label">{{ $g->name }}</span>
            </label>
        @endforeach
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#user-form','/users/'.$user->id, "tableReload(); closeModal();") !!}
@endsection
@section('modal-width','30')
