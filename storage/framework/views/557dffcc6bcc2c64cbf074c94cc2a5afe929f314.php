<?php $__env->startSection('modal-title','Grupo: '.$group->name); ?>
<?php $__env->startSection('modal-content'); ?>

    <form action=""  role="form"  id="group-sub-zones-form">
        <?php echo csrf_field(); ?>
        <h5>Sub Zonas Asignadas al Grupo</h5>
        <table class="table table-bordered table-striped" id="table-generated">
            <thead>
            <tr>
                <th>Zona</th>
                <th>Sub Zonas</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input main-control" name="<?php echo e($zone->id); ?>" id="<?php echo e($zone->slug); ?>" value="<?php echo e($zone->slug); ?>">
                            <label class="custom-control-label" for="<?php echo e($zone->slug); ?>"><?php echo e($zone->name); ?></label>
                        </div>
                    <td>
                        <?php $__currentLoopData = $zone->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="<?php echo e($zone->slug); ?> custom-control-input"
                                               name="sub_zones[]"
                                               id="<?php echo e($zone->slug .$sub_zone->id); ?>"
                                               value="<?php echo e($sub_zone->id); ?>"
                                               <?php if($group->sub_zones->where('id',$sub_zone->id)->first()): ?>
                                               checked
                                            <?php endif; ?>
                                        >
                                        <label class="custom-control-label" for="<?php echo e($zone->slug.$sub_zone->id); ?>"><?php echo e($sub_zone->name); ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </form>
    <script>
        $('.main-control').change(function() {
            var id = this.id;
            if($(this).is(":checked")) {

                $('.'+id).prop('checked',true);
            }else {
                $('.'+id).prop('checked',false);
            }
            //'unchecked' event code
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>

    <?php echo makeValidation('#group-sub-zones-form','/groupSubZones/'.$group->id, "closeModal();"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','60'); ?>


<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/group/sub-zones.blade.php ENDPATH**/ ?>