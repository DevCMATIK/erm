@section('more-css')
{!! includeCss('plugins/datatables/datatables.blunde.css') !!}
@endsection

<div class="row">
    <div class="col-xl-12">
        <div class="float-right">
            @if(!$navBar)

            @endif

        </div>
    </div>
</div>
@section('page-extra-buttons')
    <div class="pull-right">
        @if(Route::has('export.'.$entity) && Sentinel::getUser()->hasAccess($entity.'.export'))
            {!! makeLink('export/'.$entity,'Excel','fa-file-excel','btn-success','btn-md') !!}
        @endif&nbsp;
        {!! makeAddLink() !!}
    </div>
    @hasSection('page-buttons')
        @yield('page-buttons')
    @endif
@endsection
@if($navBar)
@section('page-navBar')
    @include('layouts.partials.navs.page-navbar')
@endsection
@endif
<div class="row">
    <div class="col-12">
        <div id="panel-1" class="panel">
            <div class="panel-container show">
                <div class="panel-content table-responsive">
                    {!! makeTable($columns) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@section('more-scripts')
    {!! includeScript('plugins/datatables/datatables.blunde.js') !!}
    {!! getAjaxTable($entity) !!}
@endsection


