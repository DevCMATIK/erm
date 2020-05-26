
<div class="card-body media align-items-center">
    <img src="@if($avatar){{ Storage::url($avatar->getFullPath()) }}@else {{ asset('images/user.png') }} @endif" alt="" class="d-block ui-w-80" width="200px" height="200px">
    <div class="media-body ml-4">
        {!! makeRemoteLink('/file/upload/users/'.Sentinel::getUser()->id,'Subir Imágen','fa-camera-retro','btn-outline-primary') !!}
        @if($avatar)
            {!! makeDeleteButton('Realmente desea eliminar su Imagen?',$user->id,'grantPermission','files/users') !!}
        @endif
    </div>
</div>
<hr class="border-light m-0">

<div class="card-body">
    <form class="" role="form"  id="user-form">
        @csrf
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

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
    {!!  makeValidation('#user-form','/accountGeneral', "") !!}
    {!!  makeValidation('#avatar-form','/uploadAvatar', "location.reload();") !!}
</div>
