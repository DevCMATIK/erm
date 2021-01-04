
<?php $__env->startSection('page-title','Inicio'); ?>
<?php $__env->startSection('page-icon','fa-home'); ?>
<?php $__env->startSection('page-description','Bienvenido/a '.Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Telemetria
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-6">
                                <img src="<?php echo e(asset('images/logo2.png')); ?>" style="width: 60%;" alt="">

                                <blockquote class="blockquote">
                                    <p class="mb-0">Somos un equipo de profesionales que cuenta con 10 años de experiencia, entregando soluciones en ingeniería de automatización, desarrollo de aplicaciones y tecnologías de innovación.</p>
                                    <footer class="blockquote-footer">- Cmatik</footer>
                                </blockquote>
                            </div>
                            <div class="col-6">
                                <img src="<?php echo e(asset('images/cmatik.png')); ?>" style="width: 100%;" alt="">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/welcome.blade.php ENDPATH**/ ?>