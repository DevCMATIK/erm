<div class="form-group">
    <input type="text"
           class="form-control column_name"
           id="column_name_<?php echo e($subZone->id); ?>_<?php echo e($i); ?>"
           placeholder="Nombre Columna Ej: Pozos"
           <?php if($element = $subZone->elements()->where('column',$i)->first()): ?>
             value="<?php echo e($element->name); ?>"
            <?php endif; ?>
    >
</div>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/panel/partials/column.blade.php ENDPATH**/ ?>