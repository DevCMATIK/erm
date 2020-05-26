{!! includeCss(
    'css/bootstrap.css',
    'css/app.core.css',
    'css/app.icons.css',
    'plugins/toastr/toastr.css',
    'plugins/sweetalert2/sweetalert2.css'
); !!}

@hasSection('more-css')
    @yield('more-css')
@endif
