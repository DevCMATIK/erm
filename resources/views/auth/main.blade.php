<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }} -  @yield('page-title')</title>
    <meta name="description" content="@yield('page-title')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link rel="icon" href="{{ asset('images/logo-mini.png') }}" sizes="192x192" />
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- base css -->
    @include('components.html-helpers.core-css')
</head>
<body>
<div class="page-wrapper">
    <div class="page-inner bg-gray-200">
        <div class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-lg px-4 bg-info-900">
                <div class="d-flex align-items-center container p-0">
                        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-left">
                            <img src="{{ asset('images/logo-white.png') }}" alt="Cmatik" aria-roledescription="logo" style="height: 60px !important; margin-top: 5px;">
                        </a>
                </div>
            </div>
            <div class="flex-1" style="background: url({{ asset('images/pattern-1.svg') }}) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col col-md-6 col-lg-7 hidden-sm-down" >
                            <img src="{{ asset('images/main.png') }}" alt="" width="150%" style="margin: 0px; margin-left: -200px; margin-top: -150px;">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                            <h1 class="text-dark fw-300 mb-3 d-sm-block d-md-none">
                                @yield('page-title')
                            </h1>
                            <div class="card p-4 rounded-plus bg-faded text-dark">
                               @yield('auth-content')
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-dark">
                        {{ \Carbon\Carbon::now()->year }} © {{ config('app.name') }} by&nbsp;<a href='https://www.cmatik.cl' class='text-dark opacity-40 fw-500' title='cmatik.cl' target='_blank'>cmatik.cl</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.html-helpers.core-scripts')
{!! includeScript('js/forms.js') !!}
@yield('validation')
</body>
</html>
