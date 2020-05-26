<h5 class="p-2 bg-primary text-white mb-6">
    <?php echo e($sensor->name); ?> - <?php echo e($sensor->address->name); ?><?php echo e($sensor->address_number); ?>

</h5>

<form id="label-form">
    <?php echo csrf_field(); ?>
    <div class="row border-bottom m-2 pb-2">
        <div class="col-xl-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="enable" name="enabled"
                    <?php if($sensor->enabled ==1): ?> checked <?php endif; ?> >
                <label class="custom-control-label fs-xl" for="enable">Habilitar</label>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="alarm" name="has_alarm"
                       <?php if($sensor->has_alarm ==1): ?> checked <?php endif; ?> >
                <label class="custom-control-label fs-xl" for="alarm">Alarma</label>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="historial" name="historial"
                       <?php if($sensor->historial ==1): ?> checked <?php endif; ?> >
                <label class="custom-control-label fs-xl" for="historial">Historico</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">Nombre</label>
        <input type="text" class="form-control" name="name" value="<?php echo e(optional($sensor->label)->name); ?>">
    </div>
    <div class="row p-2">
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">ON</label>
                <input type="text" class="form-control" name="on_label" value="<?php echo e(optional($sensor->label)->on_label); ?>">
            </div>
        </div>
        <div class="col-xl-6">
            <div class="form-group">
                <label class="form-label">OFF</label>
                <input type="text" class="form-control" name="off_label" value="<?php echo e(optional($sensor->label)->off_label); ?>">
            </div>
        </div>
    </div>
    <div class="form-group p-2 mb-6">
        <button type="submit" class="btn btn-primary float-right">Guardar</button>
    </div>
</form>
<?php echo makeValidation('#label-form','/storeSensorLabel/'.$sensor->id, "getBooleanForm(".$sensor->id.");"); ?>

<?php /**PATH /shared/httpd/water-management/resources/views/water-management/admin/device/boolean-form.blade.php ENDPATH**/ ?>