
<?php $__env->startSection('page-title','Emails'); ?>
<?php $__env->startSection('page-icon','envelope'); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="float-right">
                <?php if(Sentinel::getUser()->hasAccess('mails.create')): ?>
                    <?php echo makeLink('mails/create','Crear Nuevo','fa-plus' ,'btn-primary','btn-sm'); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Listado de registros
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <?php echo makeTable(['Creador','nombre','Asunto','Conectores','Acciones']); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-css'); ?>
    <?php echo includeCss('plugins/datatables/datatables.blunde.css'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/datatables/datatables.blunde.js'); ?>

    <?php echo getAjaxTable('mails'); ?>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/mail/index.blade.php ENDPATH**/ ?>