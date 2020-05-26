@extends('components.modals.form-modal')
@section('modal-title','Roles del usuario: '.$user->full_name)
@section('modal-content')
    <form class="" role="form"  id="userRoles-form">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="form-label">Roles </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            @foreach($roles as $r)
                                @if($user->inRole($r->slug))
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" checked="checked" class="custom-control-input" value="{{ $r->slug }}" name="roles[]">
                                        <span class="custom-control-label">{{ $r->name }}</span>
                                    </label>
                                @else
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="{{ $r->slug }}" name="roles[]">
                                        <span class="custom-control-label">{{ $r->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal-validation')
    {!!  makeValidation('#userRoles-form','/userRoles/'.$user->id, "closeModal();") !!}
@endsection
@section('modal-width','20')
