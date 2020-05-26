const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// vendor apps
mix.js('resources/js/app.js','public/js');
mix.scripts([
    'node_modules/pace-js/pace.js',
    'node_modules/popper.js/dist/umd/popper.js',
    'node_modules/jquery/dist/jquery.js',
    'resources/custom/plugins/jquery-ui-cust/jquery-ui-cust.js',
    'node_modules/bootstrap/dist/js/bootstrap.js',
    'resources/custom/plugins/bootbox/bootbox-cust.js',
    'resources/custom/plugins/bootbox/bootbox-config.js',
    'resources/custom/plugins/jquery-snippets/jquery-snippets.js',
    'node_modules/jquery-throttle-debounce/jquery.ba-throttle-debounce.js',
    'node_modules/jquery-slimscroll/jquery.slimscroll.js',
    'node_modules/node-waves/dist/waves.js',
    'resources/custom/plugins/smartpanels/smartpanels.js',
], 'public/js/app.vendor.js');

//app BLUNDE
mix.scripts([
    "node_modules/holderjs/holder.js",
    "resources/js/_get/app.get.colors.js",
    "resources/js/_config/app.config.js",
    "resources/js/_modules/app.navigation.js",
    "resources/js/_modules/app.menu.slider.js",
    "resources/js/_modules/app.init.js",
    "resources/js/_modules/app.resize.trigger.js",
    "resources/js/_modules/app.scroll.trigger.js",
    "resources/js/_modules/app.domReady.js",
    "resources/js/_modules/app.orientationchange.js",
    "resources/js/_modules/app.window.load.js"
],'public/js/app.blunde.js');

//vendor css
mix.sass('resources/sass/bootstrap.scss','public/css')
    .sass('resources/sass/app.core.scss','public/css')
    .sass('resources/sass/app.icons.scss','public/css');
mix.babel('resources/js/forms.js','public/js/forms.js');
//toastr
mix.styles([
        'node_modules/toastr/toastr.scss',
        'resources/custom/plugins/toastr/toastr-custom.scss'
    ],'public/plugins/toastr/toastr.css')
    .js('node_modules/toastr/toastr.js','public/plugins/toastr/toastr.js');
//sweet alert
mix.sass('resources/custom/plugins/sweetalert2/sweetalert2.scss','public/plugins/sweetalert2')
    .scripts([
        'node_modules/es6-promise-polyfill/promise.js',
        'node_modules/sweetalert2/dist/sweetalert2.js'
    ], 'public/plugins/sweetalert2/sweetalert2.js');
// datepicker
mix.styles([
    'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
    'resources/custom/plugins/datepicker/datepicker-custom.scss'
], 'public/plugins/bootstrap-datepicker/datepicker.css')
    .js('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
        'public/plugins/bootstrap-datepicker/datepicker.js');
//daterangepicker
mix.styles([
    'node_modules/bootstrap-daterangepicker/daterangepicker.css',
    'resources/custom/plugins/daterangepicker/daterangepicker-custom.scss'
], 'public/plugins/bootstrap-daterangepicker/dateragepicker.css')
    .js('node_modules/bootstrap-daterangepicker/daterangepicker.js',
        'public/plugins/bootstrap-daterangepicker/daterangepicker.js');
//dropzone
mix.styles([
    'node_modules/dropzone/dist/dropzone.css',
    'resources/custom/plugins/dropzone/dropzone-custom.scss'
], 'public/plugins/dropzone/dropzone.css')
    .js('node_modules/dropzone/dist/dropzone.js',
        'public/plugins/dropzone/dropzone.js');
//select2
mix.styles([
    'node_modules/select2/dist/css/select2.css',
    'resources/custom/plugins/select2/select2-cust.scss'
], 'public/plugins/select2/select2.css')
    .js('node_modules/select2/dist/js/select2.full.js',
        'public/plugins/select2/select2.js');
//no-uislide
mix.css('node_modules/nouislider/distribute/nouislider.css','public/plugins/nouislider/nouislider.css')
    .js('node_modules/nouislider/distribute/nouislider.js','public/plugins/nouislider/nouislider.js');

//bootstrap-duallistbox

mix.styles([
    "node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css",
    "node_modules/datatables.net-autofill-bs4/css/autoFill.bootstrap4.css",
    "node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css",
    "node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.css",
    "node_modules/datatables.net-select-bs4/css/select.bootstrap4.css",
    "resources/custom/plugins/datatables/datatables.styles.app.scss"
],'public/plugins/datatables/datatables.blunde.css');

mix.scripts([
    "node_modules/datatables.net/js/jquery.dataTables.js",
    "node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js",
    "resources/custom/plugins/datatables/datatables.styles.app.js",
    "node_modules/datatables.net-autofill/js/dataTables.autofill.js",
    "node_modules/datatables.net-buttons/js/dataTables.buttons.js",
    "node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js",
    "node_modules/datatables.net-buttons/js/buttons.html5.js",
    "node_modules/datatables.net-buttons/js/buttons.print.js",
    "resources/custom/plugins/datatables/datatables.styles.buttons.app.js",
    "node_modules/datatables.net-responsive/js/dataTables.responsive.js",
    "node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.js",
    "node_modules/datatables.net-select/js/dataTables.select.js",
    "node_modules/datatables.net-select-bs4/js/select.bootstrap4.js"
],'public/plugins/datatables/datatables.blunde.js');
