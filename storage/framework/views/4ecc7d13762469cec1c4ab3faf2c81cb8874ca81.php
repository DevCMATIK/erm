
<?php $__env->startSection('modal-title','Crear Alarma para el sensor: '.$sensor->name); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="alarm-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div class="form-group">
            <label class="form-label">Rango Minimo (Valor a comparar en caso de variable Digital)</label>
            <input type="text" class="form-control" id="range_min" name="range_min" value="<?php echo e($alarm->range_min); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Rango Maximo</label>
            <input type="text" class="form-control" id="range_max" name="range_max" value="<?php echo e($alarm->range_max); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Opciones</label><br>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="1" name="is_active" <?php if($alarm->is_active == 1): ?> checked <?php endif; ?>>
                <span class="custom-control-label">Habilitada</span>
            </label>
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" value="1" name="send_email" <?php if($alarm->send_email == 1): ?> checked <?php endif; ?>>
                <span class="custom-control-label">Enviar Mail</span>
            </label>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <label class="form-label">Grupo</label><br>
                                <label class="custom-control custom-checkbox">

                                    <input type="checkbox" class="custom-control-input" value="<?php echo e($group->id); ?>" name="group_id[]" <?php if($alarm->notifications()->where('group_id',$group->id)->first()): ?> checked <?php endif; ?>>
                                    <span class="custom-control-label"><?php echo e($group->name); ?></span>
                                </label></td>
                            <td>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <select name="<?php echo e($group->id); ?>_mail_id" id="<?php echo e($group->id); ?>_mail_id" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php $__currentLoopData = $mails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(optional($alarm->notifications()->where('group_id',$group->id)->first())->mail_id == $mail->id): ?>
                                                <option value="<?php echo e($mail->id); ?>" selected><?php echo e($mail->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($mail->id); ?>"><?php echo e($mail->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="form-label">Recordatorio</label>
                                    <select name="<?php echo e($group->id); ?>_reminder_id" id="<?php echo e($group->id); ?>_reminder_id" class="form-control">
                                        <option value="">Seleccione...</option>
                                        <?php $__currentLoopData = $mails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(optional($alarm->notifications()->where('group_id',$group->id)->first())->reminder_id == $mail->id): ?>
                                                <option value="<?php echo e($mail->id); ?>" selected><?php echo e($mail->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($mail->id); ?>"><?php echo e($mail->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td>No ha creado grupos</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>

    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#alarm-form','/sensor-alarms/'.$alarm->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/alarm/edit.blade.php ENDPATH**/ ?>