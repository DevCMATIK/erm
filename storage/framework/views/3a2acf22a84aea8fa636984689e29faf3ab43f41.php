
<?php $__env->startSection('page-title','Control de Alarmas'); ?>
<?php $__env->startSection('page-icon','exclamation-triangle'); ?>
<?php $__env->startSection('page-content'); ?>
<?php echo $__env->make('water-management.dashboard.alarm.boxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $zones = app('App\Services\Zones'); ?>
<?php $typeSensor = app('App\Services\Zones'); ?>
<?php $typeCheckPoints = app('App\Services\Zones'); ?>
<?php $typeAlarms = app('App\Services\Zones'); ?>


  <div class="row">
        <div class="col-12">
            <div id="panel-alarms-table" class="panel">
                <nav class="col-md-12 navbar navbar-light bg-light align-content-center">
                    <a class="navbar-brand">Busqueda Avanzada</a>
                    <?php echo csrf_field(); ?>
                    <form class=" col-12 my-sm-8">
                        <div class="row my-2">
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Seleccione un rango de fechas</label>
                                    <input type="text"  class="form-control datepicker" id="date" name="dates">
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group fix-selectpicker">
                                    <!--Combo Zonas -->
                                    <label class="form-label">Zonas</label>
                                    <select id="zone_id" name="zone[]" multiple
                                            data-live-search="true"
                                            data-actions-box="true"
                                            data-deselect-all-text="Quitar Selección"
                                            data-none-selected-text="Seleccione..."
                                            data-none-results-text="Sin resultados"
                                            data-select-all-text="Seleccionar todo"
                                            class="form-control text-dark selectpicker">
                                        <?php $__currentLoopData = $zones->getZones(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($index); ?>" <?php echo e((collect($request->zone)->contains($index)) ? 'selected' : ''); ?>>
                                                <?php echo e($zone); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('zone_id')): ?>
                                        <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('zone_id')); ?></strong>
                                                </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group fix-selectpicker">
                                    <!--Combo Sub-Zonas -->
                                    <label class="form-label">Sub Zonas</label>
                                    <select id="sub_zone_id" name="sub_zones[]"
                                            data-live-search="true"
                                            data-actions-box="true"
                                            data-deselect-all-text="Quitar Selección"
                                            data-none-selected-text="Seleccione..."
                                            data-none-results-text="Sin resultados"
                                            data-select-all-text="Seleccionar todo"
                                            multiple class="form-control selectpicker  <?php echo e($errors->has('sub_zone_id') ? ' is-invalid' : ''); ?>" data-old="<?php echo e(old('sub-zone_id')); ?>">
                                        <?php if($sub_zones): ?>
                                            <?php $__currentLoopData = $sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($sub_zone->id); ?>" selected><?php echo e($sub_zone->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('sub_zone_id')): ?>
                                        <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('sub_zone_id')); ?></strong>
                                            </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group fix-selectpicker">
                                    <!--Combo Tipos de Sensor -->
                                    <label class="form-label">Tipo de variable</label>
                                    <select id="type_sensor_id" name="type_sensor[]"
                                            data-live-search="true"
                                            data-actions-box="true"
                                            data-deselect-all-text="Quitar Selección"
                                            data-none-selected-text="Seleccione..."
                                            data-none-results-text="Sin resultados"
                                            data-select-all-text="Seleccionar todo"
                                            multiple class="form-control selectpicker <?php echo e($errors->has('type_sensor_id') ? ' is-invalid' : ''); ?>" >
                                        <?php $__currentLoopData = $typeSensor->getTypeSensors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($index); ?>" <?php echo e(old('type_sensor_id') == $index ? 'selected' : ''); ?>>
                                                <?php echo e($sensor); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('type_sensor_id')): ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($errors->first('type_sensor_id')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group fix-selectpicker">
                                    <!--Combo Tipos de Puntos de Control -->
                                    <label class="form-label">Punto de control</label>
                                    <select id="type_checkPoint_id" name="type_checkPoint[]"
                                            data-live-search="true"
                                            data-actions-box="true"
                                            data-deselect-all-text="Quitar Selección"
                                            data-none-selected-text="Seleccione..."
                                            data-none-results-text="Sin resultados"
                                            data-select-all-text="Seleccionar todo"
                                            multiple class="form-control selectpicker <?php echo e($errors->has('type_checkPoint_id') ? ' is-invalid' : ''); ?>">

                                        <?php $__currentLoopData = $typeCheckPoints->getTypeCheckPoints(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $checkPoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($index); ?>" <?php echo e(old('type_checkPoint_id') == $index ? 'selected' : ''); ?>>
                                                <?php echo e($checkPoint); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('type_checkPoint_id')): ?>
                                        <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('type_checkPoint_id')); ?></strong>
                                                </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-6">
                                <div class="form-group fix-selectpicker">
                                    <!--Combo Tipos de Alarmas -->
                                    <label class="form-label">Seleccione Tipo de Alarmas</label>
                                    <select id="type_alarms_id" name="type_alarms[]"
                                            data-live-search="true"
                                            data-actions-box="true"
                                            data-deselect-all-text="Quitar Selección"
                                            data-none-selected-text="Seleccione..."
                                            data-none-results-text="Sin resultados"
                                            data-select-all-text="Seleccionar todo"
                                            multiple class="form-control selectpicker <?php echo e($errors->has('type_alarms_id') ? ' is-invalid' : ''); ?>">
                                        <!-- <option value="" style='color: #51a351'>Tipos de Alarmas: </option> -->
                                        <?php $__currentLoopData = $typeAlarms->getTypeAlarms(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $typeAlarm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($index); ?>" <?php echo e(old('type_alarms_id') == $index ? 'selected' : ''); ?>>
                                                <?php echo e($typeAlarm); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('type_alarms_id')): ?>
                                        <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('type_alarms_id')); ?></strong>
                                                </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-4">
                                <button id="applyFilters" class="btn btn-success col-12 mr-sm-3 my-2 pull-right" type="submit">Aplicar Filtros</button>
                            </div>
                        </div>
                    </form>
                </nav>
            </div>
        </div>
   </div>
    <!--CRUD Alarmas Activas -->
    <div class="row">
       <div class="col-xl-12">
           <div id="panel-alarms-table" class="panel">
               <div class="panel-hdr">
                   <h2>
                       Alarmas Activas
                   </h2>

                   <div class="panel-toolbar">
                       <button class="btn btn-outline-success btn-sm" id="download-active-alarm"><i class="fas fa-file-excel"></i> Excel </button>
                       <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimizar"></button>
                       <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                   </div>
               </div>
               <div class="panel-container show ">
                   <div class="panel-content table-responsive p-0" id="active-alarms-table"></div>
               </div>
           </div>
       </div>
   </div>
    <!--CRUD Ultimas 50 Alarmas -->
    <div class="row">
       <div class="col-xl-12">
           <div id="panel-last-alarms-table" class="panel">
               <div class="panel-hdr">
                   <h2>Ultimas 50 Alarmas</h2>
                   <div class="panel-toolbar">
                       <button class="btn btn-outline-success btn-sm" id="download-last-alarm"><i class="fas fa-file-excel"></i> Excel </button>
                       <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Minimizar"></button>
                       <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                   </div>
               </div>
               <div class="panel-container show " id="contenido">
                   <div class="panel-content table-responsive p-0" id="last-alarms-table"></div>
               </div>
           </div>
       </div>
   </div>
    <div id="reload"></div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
        'plugins/highcharts/highcharts.js',
        'plugins/highcharts/modules/boost.js',
        'plugins/highcharts/modules/exporting.js',
        'plugins/selectpicker/js/bootstrap-select.min.js'
    ]); ?>

    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('select-scripts'); ?>

    <script>
        function getSubZones() {
            let zone = $('#zone_id').val();
            $.get('/getSubZones/'+zone,function(data) {
                $('#sub_zones_container').html(data);
            });
        }
    </script>

    <script>
        $(document).ready(function (){
            function loadSubzone(){
                var zone_id= $('#zone_id').val();
                 if($.trim(zone_id) !=''){
                    $.get('getSubZones', {zone_id: zone_id}, function (subzones){
                        removeItems('sub_zone_id');
                        $.each(subzones, function (index,value){
                            $('#sub_zone_id').append("<option value='"+ index + "'>" + value + "</option>")
                        });
                        $('#sub_zone_id').selectpicker('refresh');
                    });
                }
            }
            $('#zone_id').on('change', loadSubzone);
        });

        function removeItems(select) {
            $('#'+select+' option').each(function(index,element){
                element.remove();
            });

            $('#'+select).selectpicker('refresh');
        }
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-styles'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>

    <script>


        $('#download-active-alarm').click
        (function(e){
                toastr.info("Se esta generando un Excel")
                location.href="/exportActiveAlarm"
            }
        );

        $('#download-last-alarm').click
        (function(e){
                toastr.info("Se esta generando un Excel")
                location.href="/exportLastAlarm"
            }
        );

        initApp.listFilter($('#js_list_accordion_sub_zones'), $('#js_list_accordion_filter_sub_zones'));
        $(document).ready(function(){
            $('.selectpicker').selectpicker('refresh');
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };

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
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' +  + ')');
                });
        });

        $(document).ready(function(){

            getAlarmsTotal();
            getAlarmsOn();
            getLastAlarm();
            getActiveAlarmsTable();
            getLastAlarmsTable();
        });

        function getAlarmsTotal()
        {
            $.get('/kpi/getAlarmsTotal?<?php echo $queryString; ?>',function(data){
                $('#alarms-total').html(data);
            });
        }

        function getAlarmsOn()
        {
            $.get('/kpi/getAlarmsOn?<?php echo $queryString; ?>',function(data){
                $('#alarms-on').html(data);
            });
        }

        function getLastAlarm()
        {
            $.get('/kpi/getLastAlarm',function(data){
                $('#last-alarm').html(data);
            });
        }

        function getActiveAlarmsTable()
        {
            $.get('/dashboard-alarms/getActiveAlarmsTable?<?php echo $queryString; ?>',function(data){
                $('#active-alarms-table').html(data);
            });
        }

        function getLastAlarmsTable()
        {
            $.get('/dashboard-alarms/getLastAlarmsTable?<?php echo $queryString; ?>',function(data){
                $('#last-alarms-table').html(data);
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('more-css'); ?>
    <?php echo includeCss([
        'plugins/bootstrap-daterangepicker/daterangepicker.css',
        'plugins/selectpicker/css/bootstrap-select.min.css'
    ]); ?>


    <style>
        .fix-selectpicker  .dropdown-menu.show {
            transform: scale(1) !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/alarm/index.blade.php ENDPATH**/ ?>