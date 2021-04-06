
<?php $__env->startSection('page-title','Status reportes DGA : '.$check_point->name.' - '.$check_point->work_code); ?>
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
                <?php
                    if($check_point->dga_report == 1) {
                        $max = 24;
                    } else {
                        $max = 1;
                    }
                ?>
                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $reps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <fieldset>
                        <legend><?php echo e($month); ?></legend>
                        <?php
                            $last_day = \Carbon\Carbon::parse($month.'-01')->endOfMonth()->day;
                        ?>
                        <?php for($i = 1 ; $i<=$last_day ; $i++): ?>
                            <?php
                                $rep = $reps->where('date',$month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT))->first()
                            ?>
                            <?php if($rep): ?>
                                <div class="day-box text-white <?php if($rep['reports'] >= $max): ?> bg-success <?php else: ?> <?php if($month.'-'.str_pad($i, 2, '0', STR_PAD_LEFT) == now()->toDateString()): ?> bg-info <?php else: ?> bg-danger <?php endif; ?> <?php endif; ?>">
                                    <div class="label-day-box" style="float:left; margin-top: -20px; margin-left: -20px; font-size: 1.5em;">
                                        <?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>

                                    </div>
                                    <div class="label-day-box" style="float:right; margin-bottom: -10px; margin-right: -20px; font-size: 1.5em; font-weight: bolder;">
                                        <?php echo e(($rep['reports'] > $max)? $max.' / '.$max :$rep['reports'] .' / '.$max); ?>

                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="day-box text-white bg-secondary">
                                    <div class="label-day-box" style="float:left; margin-top: -20px; margin-left: -20px; font-size: 1.5em;">
                                        <?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>

                                    </div>
                                    <div class="label-day-box" style="float:right; margin-bottom: -10px; margin-right: -20px; font-size: 1.5em; font-weight: bolder;">
                                         n/r
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endfor; ?>
                    </fieldset>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </form>

        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/check-point/report/statistic.blade.php ENDPATH**/ ?>