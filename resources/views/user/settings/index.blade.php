@extends('layouts.app')
@section('page-title','Opciones de cuenta')
@section('page-icon','cog')
@section('page-content')
    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-8 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" id="first-item" href="{{ route('userSettings.general') }}">
                        General
                    </a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="{{ route('userSettings.changePassword') }}">
                        Cambiar Contraseña
                    </a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-ajax-content">
                        <!-- Content of tabs goes Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-extra-scripts')
    <script>


        $(document).ready(function(){
            getTabContent($('#first-item').attr('href'));

            $('.list-group-item').click(function (e) {
                e.preventDefault();
                let now_tab = e.target;
                getTabContent($(now_tab).attr('href'));
            });
        });

        function getTabContent(url) {
            $.get(url,function(data){
                $("#tab-ajax-content").html(data);
            });
        }
    </script>
@endsection


