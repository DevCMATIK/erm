
<?php $__env->startSection('page-title'); ?>
    Dashboard TEST
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','bolt'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php echo includeCss('plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>

    <style>
        @media (max-width: 576px) {
            .main-box-number {
                font-size: 1.3em;
            }
            .box-label {
                font-size: 0.7em;
            }

            .main-box-icon {
                visibility: hidden;
            }
        }
    </style>
    <div class="card border">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#consumption-container">Consumo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#energy-container">Energía</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="consumption-container" role="tabpanel">
                <div class="card-body">
                    <?php echo $__env->make('test.electric.sections.consumption', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <div class="tab-pane fade" id="energy-container" role="tabpanel">
                <div class="card-body">
                    <?php echo $__env->make('test.electric.sections.energy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>

    <script>
        $('.btn-alarm').hide();

        $(document).ready(function(){
            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            };

            $('.date-filter').daterangepicker(
                {
                    opens: 'right',
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

            $('.consumption-date').daterangepicker(
                {
                    opens: 'right',
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
                    startDate : moment().subtract(30,'days'),
                    endDate: moment(),
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
                    var start_date = start.format('YYYY-MM-DD');
                    var end_date = end.format('YYYY-MM-DD');

                    if(start.startOf('month').isSame(start_date,'day') && end.endOf('month').isSame(end_date,'day')) {
                        $('.consumption-box').removeClass('col-xl-6 col-lg-6 col-md-6',200).addClass('col-xl-3 col-lg-3 col-md-3',200);
                        setTimeout(function(){
                            $('.hide-on-date').show('slideDown');
                        },400)

                        $('#consumption .box-label').html('Consumo mes actual');
                        $('#zone-consumption .box-label').html('Consumo Pocillas mes actual');
                    } else {
                        $('.hide-on-date').hide();
                        $('.consumption-box').removeClass('col-xl-3 col-lg-3 col-md-3',200).addClass('col-xl-6 col-lg-6 col-md-6',200);
                        $('#consumption .box-label').html('Consumo total');
                        $('#zone-consumption .box-label').html('Pocillas consumo total');
                    }
                }
            );
        });


    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/test/electric/index.blade.php ENDPATH**/ ?>