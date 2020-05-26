@extends('layouts.app')
@section('page-title','Administrar: '.$subZone->name)
@section('page-icon','cog')
@section('page-content')
    <div class="row mb-2">
        <div class="col-xl-2">
            {!! makeLink('/admin-panel', 'Volver') !!}
        </div>
    </div>

    <div class="row bg-white border p-3">
        @include('water-management.admin.panel.partials.configuration')
    </div>
    <div class="row bg-white border p-3 mt-4">
        <div class="col-xl-12" id="columns-config">

        </div>
    </div>

@endsection
@section('page-extra-scripts')
    <script>
        getColumns({{ $subZone->id }});
       function changeColumns(sub_zone)
       {
            let columns = $('#sub_zone_columns').val();
            $.ajax({
                method : 'get',
                url : '/admin-panel/changeColumns/'+sub_zone+'/'+columns,
                success : function () {
                   getColumns(sub_zone);
                }
            });
       }

       function getColumns(sub_zone)
       {
           $.ajax({
               method : 'get',
               url : '/admin-panel/getColumns/'+sub_zone,
               success : function (data) {
                   $('#columns-config').html(data);
               }
           });
       }
       $('#block_columns').click(function(){
           let checked;
           if($(this).prop("checked") === true){
               checked = 1;
           }
           else if($(this).prop("checked") === false){
               checked = 0
           }

           $.ajax({
               method : 'get',
               url : '/admin-panel/changeBlocked/{{ $subZone->id }}/'+checked,
               success : function () {
                   location.reload();
               }
           });
       });


    </script>
@endsection
