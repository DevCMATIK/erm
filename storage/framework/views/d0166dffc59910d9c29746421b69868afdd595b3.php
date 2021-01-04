<?php $__env->startSection('modal-title','Log de reportes a DGa'); ?>
<?php $__env->startSection('modal-content'); ?>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Punto de control</th>
                    <td><?php echo e($check_point->name); ?></td>
                </tr>
                <tr>
                    <th>Sub Zona</th>
                    <td><?php echo e($check_point->sub_zones()->first()->name); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <?php echo makeTable(['Codigo respuesta','texto respuesta','totalizador','caudal','nivel freático','fecha reporte'],false,'table-log'); ?>

        </div>
    </div>
    <?php echo getAjaxTable2('check-point/dga-reports/'.$check_point->id,'table-log'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit'); ?>
    .
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/check-point/report/log.blade.php ENDPATH**/ ?>