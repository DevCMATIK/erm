<?php if($user->production_areas->count() > 0): ?>
    <h5>Sub Zonas Asignadas a usuario</h5>
    <form class="" role="form"  id="user-sub-zones-form">
        <?php echo csrf_field(); ?>
        <div class="card-datatable">
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
                                <input type="checkbox" class="custom-control-input main-control" name="<?php echo e($zone['slug']); ?>" id="<?php echo e($zone['slug']); ?>" value="<?php echo e($zone['slug']); ?>">
                                <label class="custom-control-label" for="<?php echo e($zone['slug']); ?>"><?php echo e($zone['name']); ?></label>
                            </div>
                        <td>
                            <?php $__currentLoopData = $sub_zones->where('zone_id',$zone['id']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="<?php echo e($zone['slug']); ?> custom-control-input"
                                                   name="sub_zones[]"
                                                   id="<?php echo e($zone['slug'] .$sub_zone['id']); ?>"
                                                   value="<?php echo e($sub_zone['id']); ?>"
                                                   <?php if($user->sub_zones->where('id',$sub_zone['id'])->first()): ?>
                                                        checked
                                                       <?php endif; ?>
                                            >
                                            <label class="custom-control-label" for="<?php echo e($zone['slug'].$sub_zone['id']); ?>"><?php echo e($sub_zone['name']); ?></label>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"> Guardar SubZonas</button>
        </div>
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
    </form>
    <?php echo makeValidation('#user-sub-zones-form','/userSubZones/'.$user->id, ""); ?>

<?php else: ?>
    <div class="alert alert-info">
        No ha asignado areas de produccion al usuario, seleccione almenos una para poder administrar sus zonas
    </div>
<?php endif; ?>
<?php /**PATH /shared/httpd/erm/resources/views/user/sub-zones/partials/sub-zones.blade.php ENDPATH**/ ?>