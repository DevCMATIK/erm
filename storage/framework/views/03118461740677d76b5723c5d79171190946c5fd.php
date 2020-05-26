
<?php $__env->startSection('modal-title','Modificar Modulo de importacion'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="import-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control"  name="name" id="name" value="<?php echo e($import->name); ?>">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Offset</label>
                    <input type="text" class="form-control"  name="offset" id="offset" value="<?php echo e($import->offset); ?>">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-label">Encabezados</label>
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="ignore_header" <?php if($import->ignore_header == 1): ?> checked="checked" <?php endif; ?>>
                        <span class="custom-control-label">Ignorar</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="form-group">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo e($import->description); ?></textarea>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="form-label">Roles </label>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(in_array($r->slug,$import->entityRolesAsArray())): ?>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked value="<?php echo e($r->slug); ?>" name="roles[]">
                                        <span class="custom-control-label"><?php echo e($r->name); ?></span>
                                    </label>
                                <?php else: ?>
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<?php echo e($r->slug); ?>" name="roles[]">
                                        <span class="custom-control-label"><?php echo e($r->name); ?></span>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">
                Campos
                <span class="pull-right">
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm" onClick="addField()"><i class="fas fa-plus"></i> Agregar Campo</a>
                </span>
            </label>
            <div class="fields-list">
                <input type="text" class="form-control fields" placeholder="nombre del campo" name="fields[]" value="<?php echo e($fields[0]); ?>">
                <?php for($i=1;$i<count($fields);$i++): ?>
                    <div class="input-group fields">
                        <input type="text" class="form-control " placeholder="nombre del campo" name="fields[]" value="<?php echo e($fields[$i]); ?>">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-danger removeItem" onClick=" $(this).closest('div').remove();">X</button>
                    </span><br>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </form>
    <script>
        function addField(){
            $('.fields-list').append('<div class="input-group fields"><input type="text" class="form-control " placeholder="nombre del campo" name="fields[]"><span class="input-group-btn"><button type="button" onClick=" $(this).closest(\'div\').remove();" class="btn btn-danger removeItem">X</button></span><br></div>');
        }

    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#import-form','/imports/'.$import->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/import/edit.blade.php ENDPATH**/ ?>