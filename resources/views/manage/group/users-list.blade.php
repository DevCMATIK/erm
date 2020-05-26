
<h5>
    <i class="fas fa-users"></i>
    {{ $group->name }}
</h5>
<hr>
<form id="user-group-form">
    @csrf
    <select name="users[]" id="usersGroupList" class="form-control" multiple>
        @foreach($users as $user)
            @if($group->users->contains($user))
                <option value="{{ $user->id }}" selected>{{ $user->full_name }}</option>
            @else
                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
            @endif
        @endforeach
    </select>
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-info btn-block">Guardar</button>
    </div>
</form>
<script>
    $('#usersGroupList').bootstrapDualListbox({
        nonSelectedListLabel: 'Listado de usuarios',
        selectedListLabel: 'Usuarios en el grupo',
        preserveSelectionOnMove: 'moved'
    });


</script>
{!!  makeValidation('#user-group-form','/handleUsersFromGroup/'.$group->id,'getUsersFromGroup('.$group->id.')') !!}


