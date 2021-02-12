<?php $__env->startSection('page-title','Status reportes DGA : Punto de control'); ?>
<?php $__env->startSection('page-icon','check'); ?>
<?php $__env->startSection('more-css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/plugins/step-form-wizard/css/step-form-wizard-all.css')); ?>">

    <style>

        fieldset legend {
            text-align: center;
            margin-bottom: 50px !important;
        }
        fieldset {
            overflow: hidden;
            padding-bottom: 70px !important;
        }
        .day-box {
            display: inline-block;
            width: 14%;
            border: 1px solid #4c5965;
            padding: 30px;
            padding-bottom: 10px !important;
            margin-bottom: 4px;
            text-align: center;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <script src="<?php echo e(asset('/plugins/step-form-wizard/js/step-form-wizard.min.js')); ?>"></script>
    <script>
        sfw = $("#statistics-form").stepFormWizard({
            height: 'first',
            theme: 'sky' ,// sea, sky, simple, circle, sun,
            nextBtn : $('<a class="next-btn sf-right sf-btn bg-primary text-white" href="#">Siguiente</a>'),
            prevBtn : $('<a class="prev-btn sf-left sf-btn bg-primary text-white" href="#">Anterior</a>'),
            finishBtn : $(''),
            showNav : true,
            showButtons : false,
            transition : 'slide',

            onNext: function() {

            },
            onFinish: function() {

            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-description'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <form id="statistics-form">
                <fieldset>
                    <legend>2021-02</legend>
                    <?php for($i = 1 ; $i<=27 ; $i++): ?>
                        <?php
                            $reports = rand(21,24)
                        ?>
                        <div class="day-box text-white <?php if($reports == 24): ?> bg-success <?php else: ?> bg-danger <?php endif; ?>">
                            <div class="label-day-box" style="float:left; margin-top: -20px; margin-left: -20px; font-size: 1.5em;">
                                <?php echo e($i); ?>

                            </div>
                            <div class="label-day-box" style="float:right; margin-bottom: -10px; margin-right: -20px; font-size: 1.5em; font-weight: bolder;">
                                <?php echo e($reports .' / 24'); ?>

                            </div>
                        </div>
                    <?php endfor; ?>
                </fieldset>
                <fieldset>
                    <legend>2021-01</legend>
                    <?php for($i = 1 ; $i<=31 ; $i++): ?>
                        <?php
                            $reports = rand(21,24)
                        ?>
                        <div class="day-box text-white <?php if($reports == 24): ?> bg-success <?php else: ?> bg-danger <?php endif; ?>">
                            <div class="label-day-box" style>
                                <?php echo e($i); ?>

                            </div>
                        </div>
                    <?php endfor; ?>
                </fieldset>
            </form>

        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/check-point/report/statistic.blade.php ENDPATH**/ ?>