
<?php $__env->startSection('modal-title','Modificar Punto de control'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="check-point-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($checkPoint->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Zonas</label>
            <select class="form-control m-b" name="zone_id" id="zone_id" onchange="getSubZones()">
                <option value="" disabled="" selected="" >Seleccione...</option>
                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if( $z->id == $checkPoint->sub_zones->first()->zone->id): ?>
                        <option value="<?php echo e($z->id); ?>" selected><?php echo e($z->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo e($z->id); ?>"><?php echo e($z->name); ?></option>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="row">
            <div class="col-lg-12" id="sub_zones_container">

            </div>
        </div>
    </form>

    <script>
        getSubZones();
        function getSubZones() {
            let zone = $('#zone_id').val();
            $.get('/getSubZones/'+zone+'/<?php echo e($checkPoint->id); ?>',function(data) {
                $('#sub_zones_container').html(data);
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#check-point-form','/check-points/'.$checkPoint->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/check-point/edit.blade.php ENDPATH**/ ?>