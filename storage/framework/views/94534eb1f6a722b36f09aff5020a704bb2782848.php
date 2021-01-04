
<?php $__env->startSection('modal-title','Crear Punto de control'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="check-point-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="type" value="<?php echo e($type); ?>">
        <div class="form-group border-bottom">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="form-group">
            <label class="form-label">Zonas</label>
            <select multiple class="form-control m-b" name="zone_id" id="zone_id" onchange="getSubZones()">
                <option value="" disabled="" selected="" >Seleccione...</option>
                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($z->id); ?>"><?php echo e($z->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="row">
            <div class="col-lg-12" id="sub_zones_container">

            </div>
        </div>
    </form>

    <script>
        function getSubZones() {
            let zone = $('#zone_id').val();
            $.get('/getSubZones/'+zone,function(data) {
                $('#sub_zones_container').html(data);
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#check-point-form','/check-points', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/check-point/create.blade.php ENDPATH**/ ?>