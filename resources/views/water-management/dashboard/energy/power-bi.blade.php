<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        @yield('page-title') - {{ config('app.name') }}
    </title>
    <meta name="description" content="Blank">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="icon" href="{{ asset('images/logo-mini.png') }}" sizes="192x192" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- base css -->
@include('components.html-helpers.core-css')
<!-- Place favicon.ico in the root directory -->

    <link rel="mask-icon" href="" color="#5bbad5">
</head>
<body class="mod-bg-1">
<!-- DOC: script to save and load page settings -->
<script>
    /**
     *	This script should be placed right after the body tag for fast execution
     *	Note: the script is written in pure javascript and does not depend on thirdparty library
     **/
    'use strict';

    var classHolder = document.getElementsByTagName("BODY")[0],
        /**
         * Load from localstorage
         **/
        themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
        themeURL = themeSettings.themeURL || '',
        themeOptions = themeSettings.themeOptions || '';
    /**
     * Load theme options
     **/
    if (themeSettings.themeOptions)
    {
        classHolder.className = themeSettings.themeOptions;
        console.log("%c✔ Theme settings loaded", "color: #148f32");
    }
    else
    {
        console.log("Heads up! Theme settings is empty or does not exist, loading default settings...");
    }
    if (themeSettings.themeURL && !document.getElementById('mytheme'))
    {
        var cssfile = document.createElement('link');
        cssfile.id = 'mytheme';
        cssfile.rel = 'stylesheet';
        cssfile.href = themeURL;
        document.getElementsByTagName('head')[0].appendChild(cssfile);
    }
    /**
     * Save to localstorage
     **/
    var saveSettings = function()
    {
        themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
        {
            return /^(nav|header|mod|display)-/i.test(item);
        }).join(' ');
        if (document.getElementById('mytheme'))
        {
            themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
        };
        localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
    }
    /**
     * Reset settings
     **/
    var resetSettings = function()
    {
        localStorage.setItem("themeSettings", "");
    }

</script>

<!-- BEGIN Page Wrapper -->
<div class="page-wrapper">
    <div class="page-inner ">
        <!-- BEGIN Left Aside -->
        <!-- END Left Aside -->
        <div class="page-content-wrapper">
            <!-- BEGIN Page Header -->
            <header class="page-header bg-info-900" role="banner">
                <!-- DOC: nav menu layout change shortcut -->
                <div class="pt-2 ">
                    <span class="page-logo-link ml-2 text-white fs-xl font-weight-bolder">{{ config('app.name') }} <small>®</small></span> <br>

                    <p class="page-logo-text text-white fs-sm">Efficient Resource Management</p>
                </div>
                <!-- DOC: mobile button appears during mobile width -->
                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center mx-auto">
                    <img src="{{ asset('images/logo-white.png') }}" alt="Cmatik" aria-roledescription="logo" style="height: 50px !important; margin-top: 5px;">
                </a>

            </header>

            <!-- END Page Header -->
            <!-- BEGIN Page Content -->
            <!-- the #js-page-content id is needed for some plugins to initialize -->
            <main id="js-page-content" role="main" class="page-content bg-white">

                <div class="subheader " >
                    <h1 class="subheader-title">
                        <i class='subheader-icon fal fa-bolt'></i>  <span class='fw-300'>{{ 'Resumen Energía: TEST' }}</span>

                    </h1>
                </div>

                <div class="alert alert-info">
                    Copie la siguiente URL en Power BI
                    <h1><strong>https://erm.cmatik.app/zone-resume-table/{{ 'TEST' }}</strong></h1>
                </div>
                <div class="row my-4">
                    <div class="col-12">

                        <table class="table m-0 table-bordered">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Sub Zona</th>
                                <th>Consumo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                @dd($row)
                                <tr>
                                    <td>{{ $row[2] }}</td>
                                    <td>{{ $row[0] }}</td>
                                    <td>{{ number_format($row[1],1,',','') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
            <!-- this overlay is activated only when mobile menu is triggered -->
            <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on">

            </div> <!-- END Page Content -->
            <!-- BEGIN Page Footer -->
            <footer class="page-footer" role="contentinfo">
                @include('layouts.sections.footer')
            </footer>
            <!-- END Page Footer -->
            <!-- BEGIN Shortcuts -->
            <!-- modal shortcut -->
        </div>
    </div>
</div>

@include('components.html-helpers.core-scripts')

</body>
</html>


