
<?php $__env->startSection('page-title','Descarga de variables'); ?>
<?php $__env->startSection('page-icon','file-excel'); ?>
<?php $__env->startSection('page-content'); ?>

    <form method = "post" id="data-form">
    <div class="row" >
        <div class="col">
            <div class="card">
                <div class="card-body" >
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                    <?php echo csrf_field(); ?>
                                    <label class="form-label">Seleccione un rango de fechas</label>
                                    <input type="text" class="form-control datepicker" id="date" name="dates">
                                    <input type="hidden" name="sensors" value="">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group pull-right text-right">
                                <label class="form-label">Presione para </label><br>
                                <button class="btn btn-success" id="download-data"><i class="fas fa-file-excel"></i> Descargar</button>
                                <button class="btn btn-success" id="download-data-test"><i class="fas fa-file-excel"></i> Test Donwloader</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="form-group  m-0 rounded-top">
                                <input type="text" class="form-control form-control-lg shadow-inset-2 m-0" id="js_list_accordion_filter_sub_zones" placeholder="Filtrar Zonas  ">
                            </div>

                            <div id="js_list_accordion_sub_zones" class="accordion accordion-hover accordion-clean">
                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(count($zone->sub_zones) > 0): ?>
                                    <div class="card border-top-left-radius-0 border-top-right-radius-0">
                                        <div class="card-header ">
                                            <a href="javascript:void(0);"
                                               class="card-title collapsed"
                                               data-toggle="collapse"
                                               data-target="#zone_list_<?php echo e($zone->id); ?>"
                                               aria-expanded="false"
                                               data-filter-tags="<?php echo e(strtolower($zone->name)); ?> <?php $__currentLoopData = $zone->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e(strtolower($sub_zone->name)); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                                               <i class="fal fa-filter width-2 fs-xl"></i>
                                               <?php echo e($zone->name); ?> <div class="ml-3" id="header_<?php echo e($zone->id); ?>"></div>
                                               <span class="ml-auto">
                                                    <span class="collapsed-reveal">
                                                        <i class="fal fa-chevron-up fs-xl"></i>
                                                    </span>
                                                    <span class="collapsed-hidden">
                                                        <i class="fal fa-chevron-down fs-xl"></i>
                                                    </span>
                                               </span>
                                            </a>
                                        </div>
                                        <div id="zone_list_<?php echo e($zone->id); ?>" class="collapse"  data-parent="#js_list_accordion_sub_zones">
                                            <div class="card-body">
                                                <ul class="list-group">
                                                    <?php $__currentLoopData = $zone->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item cursor-pointer" id="<?php echo e($zone->id); ?>_<?php echo e($sub_zone->id); ?>" data-remote="true" href="#collapsed_<?php echo e($sub_zone->id); ?>" id="parent_<?php echo e($zone->id); ?>" data-toggle="collapse" data-parent="#collapsed_<?php echo e($sub_zone->id); ?>">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input sub_zones_check" value="<?php echo e($sub_zone->id); ?>" name="sub_zones[]">
                                                                <span class="custom-control-label"><?php echo e($sub_zone->name); ?></span>
                                                            </label>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <span class="filter-message js-filter-message"></span>
                        </div>
                            <div class="col-6" id="check_points_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>


    <script>

        $('#download-data-test').click
        (function(e){
            let form = $('#data-form');
            var sensors  = $('.sensors').serialize();
            if(sensors === '') {
                toastr.error('No ha seleccionado sensores');
            } else {
                    form.submit(function( event ) {
                    form.attr('action', '/exportDataTest');
                });

            }

        }
        );

        $('#download-data').click(function(e){
            let form = $('#data-form');
            var sensors  = $('.sensors').serialize();
            if(sensors === '') {
                toastr.error('No ha seleccionado sensores');
            } else {
                form.submit(function( event ) {
                    form.attr('action', '/downloadDataFromChartTotal');
                });
            }

        });

    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-css'); ?>
    <?php echo includeCss('plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <?php if(Session::has('success')): ?>
        <script>
            Swal.fire(
                {
                    title: "<strong><u>Importante!</u></strong>",
                    type: "info",
                    html: "Debido a la cantidad de data, se ha generado una descarga en segundo plano, un correo será enviado cuando sus archivos estén listos.",
                    showCloseButton: true,
                    showCancelButton: false,
                });
        </script>
    <?php endif; ?>
    <script>

        initApp.listFilter($('#js_list_accordion_sub_zones'), $('#js_list_accordion_filter_sub_zones'));
        $(document).ready(function(){

            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };



            $('.sub_zones_check').click(function(e){
                var sub_zones_selected = $('.sub_zones_check').serialize();
                $.get('/getCheckPoints?'+sub_zones_selected, function(data){
                    $('#check_points_container').html(data);
                });
            });

            $('.datepicker').daterangepicker(
                {
                    opens: 'right',
                    "parentEl": "body",
                    templates: controls,
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    "showDropdowns": true,
                    "showWeekNumbers": true,
                    "showISOWeekNumbers": true,
                    "timePicker": false,
                    "timePicker24Hour": false,
                    "timePickerSeconds": false,
                    "autoApply": false,
                    ranges:
                        {
                            'Hoy': [moment(), moment()],
                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                            'Esta Semana': [moment().startOf('week'), moment().endOf('week')],
                            'Semana Pasada': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                    "alwaysShowCalendars": true,
                    "applyButtonClasses": "btn-default shadow-0",
                    "cancelClass": "btn-success shadow-0"
                }, function(start, end, label)
                {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/data/exports/index.blade.php ENDPATH**/ ?>