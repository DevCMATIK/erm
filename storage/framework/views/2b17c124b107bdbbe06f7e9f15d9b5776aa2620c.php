<?php $__env->startSection('more-css'); ?>
<?php echo includeCss('plugins/datatables/datatables.blunde.css'); ?>

<?php $__env->stopSection(); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="float-right">
            <?php if(!$navBar): ?>
                <?php if(Route::has('export.'.$entity) && Sentinel::getUser()->hasAccess($entity.'.export')): ?>
                    <?php echo makeLink('export/'.$entity,'Excel','fa-file-excel','btn-success','btn-sm'); ?>

                <?php endif; ?>&nbsp;
                <?php echo makeAddLink(); ?>

                <?php if (! empty(trim($__env->yieldContent('page-buttons')))): ?>
                    <?php echo $__env->yieldContent('page-buttons'); ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php if($navBar): ?>
<?php $__env->startSection('page-navBar'); ?>
    <?php echo $__env->make('layouts.partials.navs.page-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php endif; ?>
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
                    <?php echo makeTable($columns); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/datatables/datatables.blunde.js'); ?>

    <?php echo getAjaxTable($entity); ?>

<?php $__env->stopSection(); ?>

<?php /**PATH /shared/httpd/water-management/resources/views/components/views/crud.blade.php ENDPATH**/ ?>