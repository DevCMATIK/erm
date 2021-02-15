<?php $__env->startSection('page-title'); ?>
    Puntos de Control que reportan a DGA
    <?php if(Sentinel::getUser()->hasAccess('dga.export')): ?>
        <?php echo makeLink(route('check-point.reports-export'),'Exportar Todo','fa-file-excel','btn-success float-right','btn-md'); ?>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
    <label class="btn btn-panel hover-effect-dot js-panel-collapse waves-effect waves-themed"></label>
    <?php echo makeDefaultView(['Punto de Control','Código de Obra','Frecuencia','Zona','Cantidad de reportes','Status','Acciones'],'check-point/dga-reports'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/check-point/report/index.blade.php ENDPATH**/ ?>