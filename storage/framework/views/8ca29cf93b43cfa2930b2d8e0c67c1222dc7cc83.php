<?php $__env->startSection('modal-title','Usuario: '.$user->full_name); ?>
<?php $__env->startSection('modal-content'); ?>
    <script>

        function getSubZones(user_id) {
            $.get('/userSubZones/detail/'+user_id, function(html) {
                $('#user-sub-zones').html(html);
            })
        }

    </script>
    <form action=""  role="form"  id="user-production-areas-form">
        <?php echo csrf_field(); ?>
        <h5>Areas de Produccion del usuario</h5>
        <div class="form-group">
            <?php $__currentLoopData = $productionAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productionArea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($user->inProductionArea($productionArea->id)): ?>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" checked="checked" class="custom-control-input" value="<?php echo e($productionArea->id); ?>" name="production_areas[]">
                        <span class="custom-control-label"><?php echo e($productionArea->name); ?></span>
                    </label>
                <?php else: ?>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="<?php echo e($productionArea->id); ?>" name="production_areas[]">
                        <span class="custom-control-label"><?php echo e($productionArea->name); ?></span>
                    </label>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"> Guardar Areas de Produccion</button>
        </div>
    </form>
    <hr>
    <div id="user-sub-zones">
        <h5>Sub Zonas Asignadas a usuario</h5>
        <?php if($user->production_areas()->count() > 0 ): ?>

            <script>getSubZones(<?php echo e($user->id); ?>);</script>
        <?php else: ?>
            <div class="alert alert-info">
                No ha asignado areas de produccion al usuario, seleccione almenos una para poder administrar sus zonas
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>

    <?php echo makeValidation('#user-production-areas-form','/userProductionAreas/'.$user->id, "getSubZones(".$user->id.")"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','60'); ?>
<?php $__env->startSection('no-submit'); ?>
    .
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/user/sub-zones/index2.blade.php ENDPATH**/ ?>
