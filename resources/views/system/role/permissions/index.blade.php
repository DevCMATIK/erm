@extends('components.modals.form-modal')
@section('modal-title','Permisos del Role: '.$role->name)
@section('modal-content')
    <form class="my-5" role="form"  id="role-permissions-form">
        @csrf
        <div class="card-datatable">
            <table class="table table-bordered table-striped" id="table-generated">
                <thead>
                <tr>
                    <th>Slug</th>
                    <th>Permisos</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input main-control" name="{{ $permission->slug }}" id="{{ $permission->slug }}" value="{{ $permission->slug }}">
                                <label class="custom-control-label" for="{{ $permission->slug }}">{{ $permission->slug }}</label>
                            </div>
                        <td>
                            @foreach(explode(',',$permission->list) as $p)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="{{ $permission->slug }} custom-control-input" name="perms[]" id="{{ $permission->slug.".".$p }}" value="{{ $permission->slug.".".$p }}" @if($role->hasAccess([$permission->slug.".".$p])) checked @endif>
                                            <label class="custom-control-label" for="{{ $permission->slug.".".$p }}">{{ $p }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
    <script>
        $('.main-control').change(function() {
            var id = this.id;
            if($(this).is(":checked")) {

                $('.'+id).prop('checked',true);
            }else {
                $('.'+id).prop('checked',false);
            }
            //'unchecked' event code
        });
    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#role-permissions-form','/rolePermissions/'.$role->id, "tableReload(); closeModal();") !!}
@endsection
@section('modal-width','60')
