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
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="icon" href="{{ asset('images/logo-mini.png') }}" sizes="192x192" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- base css -->
@include('components.html-helpers.core-css')
<!-- Place favicon.ico in the root directory -->

    <link rel="mask-icon" href="" color="#5bbad5">
    <style>
        .dropdown-toggle::after {
            content: none !important;
        }

        .table-bordered, .table-bordered th,.table-bordered td {
            border-color: #e5e5e5 !important;
        }
    </style>
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
        <aside class="page-sidebar bg-info-800">
            <div class="page-logo bg-info-900 flex-column">
                <img src="{{ asset('images/logo-white-st.PNG') }}" alt="" style="width: 60%;  bottom: 0;">

                <p class="page-logo-text text-white mr-1 fs-sm  mt-n3">Efficient Resource Management</p>
            </div>
            <!-- BEGIN PRIMARY NAVIGATION -->
            <nav id="js-primary-nav" class="primary-nav bg-info-800" role="navigation">
                @include('layouts.sections.nav')
            </nav>
        </aside>
        <!-- END Left Aside -->
        <div class="page-content-wrapper">
            <!-- BEGIN Page Header -->
        @include('layouts.sections.header')
        <!-- END Page Header -->
            <!-- BEGIN Page Content -->
            <!-- the #js-page-content id is needed for some plugins to initialize -->
            <main id="js-page-content" role="main" class="page-content @hasSection('page-bg') @yield('page-bg') @else bg-gray-50 @endif">
                @if(isset($navBar) && $navBar != '')
                    @yield('page-navBar')
                @else
                    <div class="subheader @hasSection('page-bg') text-white @endif" >
                        <h1 class="subheader-title @hasSection('page-bg') text-white @endif">
                            <i class='subheader-icon fal fa-@yield('page-icon') @hasSection('page-bg') text-white @endif'></i>  <span class='fw-300'>@yield('page-title')</span>
                            @hasSection('page-description')
                                <small>@yield('page-description')</small>
                            @endif
                        </h1>
                    </div>
                @endif


                @yield('page-content')
            </main>
            <!-- this overlay is activated only when mobile menu is triggered -->
            <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on">

            </div> <!-- END Page Content -->
            <!-- BEGIN Page Footer -->
            <footer class="page-footer @hasSection('page-bg') bg-gray text-white @endif" role="contentinfo">
                @include('layouts.sections.footer')
            </footer>
            <!-- END Page Footer -->
            <!-- BEGIN Shortcuts -->
            <!-- modal shortcut -->
        </div>
    </div>
</div>
<div class="modal fadeindown" id="remoteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


        </div>
    </div>
</div>
@include('components.html-helpers.core-scripts')
@hasSection('page-extra-scripts')
    @yield('page-extra-scripts')
@endif
<script>
    $(document).ready(function() {

    });

    let remoteModal = $('#remoteModal');
    remoteModal.on('show.bs.modal', function (e) {
        $(this).find('.modal-content').load(e.relatedTarget.href);
    });
    remoteModal.on('hidden.bs.modal', function (e) {
        $('#remoteModal .modal-content').html('');
        $('.dtp').remove();
    });
</script>
</body>
</html>
