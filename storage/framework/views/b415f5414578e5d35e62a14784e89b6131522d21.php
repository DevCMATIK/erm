<div class="col-xl-4 ">
    <div class="form-group">
        <label for="sub_zone_columns" class="form-label">Columnas</label>
        <select id="sub_zone_columns" class="form-control" name="sub_zone_columns" onchange="changeColumns(<?php echo e($subZone->id); ?>)" <?php if($subZone->configuration->block_columns == 1): ?> disabled <?php endif; ?>>
            <?php if($subZone->configuration): ?>
                <?php switch($subZone->configuration->columns):
                    case (1): ?>
                    <option value="1" selected>1 Columna</option>
                    <option value="2">2 Columnas</option>
                    <option value="3">3 Columnas</option>
                    <option value="4">4 Columnas</option>
                    <?php break; ?>
                    <?php case (2): ?>
                    <option value="1" >1 Columna</option>
                    <option value="2" selected>2 Columnas</option>
                    <option value="3">3 Columnas</option>
                    <option value="4">4 Columnas</option>
                    <?php break; ?>
                    <?php case (3): ?>
                    <option value="1" >1 Columna</option>
                    <option value="2">2 Columnas</option>
                    <option value="3" selected>3 Columnas</option>
                    <option value="4">4 Columnas</option>
                    <?php break; ?>
                    <?php case (4): ?>
                    <option value="1" >1 Columna</option>
                    <option value="2">2 Columnas</option>
                    <option value="3">3 Columnas</option>
                    <option value="4" selected>4 Columnas</option>
                    <?php break; ?>
                <?php endswitch; ?>
            <?php else: ?>
                <option value="1">1 Columna</option>
                <option value="2">2 Columnas</option>
                <option value="3">3 Columnas</option>
                <option value="4">4 Columnas</option>
            <?php endif; ?>
        </select>
    </div>
</div>
<div class="col-xl-6">
    <?php if($subZone->configuration->block_columns != 1): ?>
        <div class="alert alert-info mb-0 mt-2">
            Para configurar las columnas debe bloquearlas. Bloqueelas solo cuando haya definido el Layout de la pantalla de Control
        </div>
        <?php else: ?>
        <div class="alert alert-danger mb-0 mt-2">
            Desbloquear las columnas eliminara toda la configuracion de esta sub zona para el Dashboard.
        </div>
    <?php endif; ?>
    <div class="custom-control custom-switch form-control-lg mt-1 ">
        <input type="checkbox" class="custom-control-input form-control-lg main-control" name="block_columns" id="block_columns" value="1" <?php if($subZone->configuration->block_columns == 1): ?> checked <?php endif; ?>>
        <label class="custom-control-label" for="block_columns">Bloquear Columnas</label>
    </div>
</div>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/panel/partials/configuration.blade.php ENDPATH**/ ?>