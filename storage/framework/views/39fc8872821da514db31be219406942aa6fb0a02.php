<?php $__env->startSection('modal-title','Log de desconexiones'); ?>
<?php $__env->startSection('modal-content'); ?>
    <div class="row">
        <div class="col-xl-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Dispositivo</th>
                    <td><?php echo e($device->name); ?></td>
                </tr>
                <tr>
                    <th>Punto de Control</th>
                    <td><?php echo e($device->check_point->name); ?></td>
                </tr>
                <tr>
                    <th>Sub Zona</th>
                    <td><?php echo e($device->check_point->sub_zones()->first()->name); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 table-responsive">
           <?php echo makeTable(['Fecha de Inicio','Fecha de Término','Duración'],false,'table-log'); ?>

        </div>
    </div>
    <?php echo getAjaxTable2('offline-devices-log/'.$device->id,'table-log'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit'); ?>
    .
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/device/offline/log.blade.php ENDPATH**/ ?>