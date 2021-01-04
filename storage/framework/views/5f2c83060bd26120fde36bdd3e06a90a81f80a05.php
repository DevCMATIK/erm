
<?php $__env->startSection('modal-title','Crear Trigger'); ?>
<?php $__env->startSection('modal-content'); ?>
    <?php echo includeCss('plugins/select2/select2.css'); ?>



    <form class="" role="form"  id="trigger-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="sensor_id" value="<?php echo e($sensor_id); ?>">
        <div class="form-group">
            <label class="form-label">Receptores</label>
            <select name="receptor_id" class="form-control select2">
                <option value="">Seleccione...</option>

                <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(count($device->sensors) > 0): ?>
                        <optgroup label="<?php echo e($device->check_point->sub_zones->first()->name); ?>-<?php echo e($device->name); ?>">
                            <?php $__currentLoopData = $device->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>"><?php echo e(strtoupper($s->full_address)); ?>-<?php echo e($s->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </optgroup>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php if($sensor->address->configuration_type == 'scale'): ?>
            <div class="form-group">
                <label class="form-label">Rango minimo</label>
                <input type="text" class="form-control"  name="range_min">
            </div>
            <div class="form-group">
                <label class="form-label">Rango Maximo</label>
                <input type="text" class="form-control"  name="range_max">
            </div>
            <div class="form-group">
                <label class="form-label">Comando a ejecutar cuando mayor que maximo</label>
                <select name="in_range" class="form-control">
                    <option value="1">Enviar 1</option>
                    <option value="0">Enviar 0</option>
                </select>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <strong>Nota: si solo indica valor "cuando es 1" no aplicará ningún cambio en cualquier otro caso</strong>
            </div>
            <div class="form-group">
                <label class="form-label">Cuando es uno</label>
                <input type="text" class="form-control"  name="when_one">
            </div>
            <div class="form-group">
                <label class="form-label">Cuando es Cero</label>
                <input type="text" class="form-control"  name="when_zero">
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label class="form-label">Ejecutar Cada</label>
            <select name="minutes" class="form-control">
                <option value="">Seleccione...</option>
                <option value="1">1 Minuto</option>
                <option value="5">5 Minutos</option>
                <option value="10">10 Minutos</option>
            </select>
        </div>
    </form>
    <?php echo includeScript('plugins/select2/select2.js'); ?>

    <script>

        function modelMatcher (params, data) {
            data.parentText = data.parentText || "";

            // Always return the object if there is nothing to compare
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do a recursive check for options with children
            if (data.children && data.children.length > 0) {
                // Clone the data object if there are children
                // This is required as we modify the object to remove any non-matches
                var match = $.extend(true, {}, data);

                // Check each child of the option
                for (var c = data.children.length - 1; c >= 0; c--) {
                    var child = data.children[c];
                    child.parentText += data.parentText + " " + data.text;

                    var matches = modelMatcher(params, child);

                    // If there wasn't a match, remove the object in the array
                    if (matches == null) {
                        match.children.splice(c, 1);
                    }
                }

                // If any children matched, return the new object
                if (match.children.length > 0) {
                    return match;
                }

                // If there were no matching children, check just the plain object
                return modelMatcher(params, match);
            }

            // If the typed-in term matches the text of this term, or the text from any
            // parent term, then it's a match.
            var original = (data.parentText + ' ' + data.text).toUpperCase();
            var term = params.term.toUpperCase();


            // Check if the text contains the term
            if (original.indexOf(term) > -1) {
                return data;
            }

            // If it doesn't contain the term, don't return anything
            return null;
        }
       $(document).ready(function(){
           $(".select2").select2({
               width: '100%' ,
               dropdownParent: $('.modal'),
               matcher: modelMatcher
           });
       });


    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#trigger-form','/sensor-triggers', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/device/sensor/trigger/create.blade.php ENDPATH**/ ?>