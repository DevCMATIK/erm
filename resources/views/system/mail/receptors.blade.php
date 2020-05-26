@extends('components.modals.form-modal')
@section('modal-title','Receptores del email')
@section('modal-content')
   <div class="row">
       <div class="col">
           <table class="table table-striped">
               <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
               </thead>
               <tbody>
               @foreach($users as $u)
                <tr>
                    <td>{{ $u->user->full_name }}</td>
                    <td>{{ $u->user->email }}</td>
                </tr>
               @endforeach
               </tbody>
           </table>
       </div>
   </div>
@endsection
@section('no-submit')
    .
@endsection
