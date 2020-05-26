
<?php $__env->startSection('modal-title','Modificar columnas'); ?>
<?php $__env->startSection('modal-content'); ?>
    <?php echo includeCss(['plugins/nestable/nestable.css']); ?>

    <?php echo includeScript([
        'plugins/nestable/nestable.js',
        'plugins/jstree/jstree.js'
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?php
                $i = 1;
            ?>
            <div class="dd" id="fields-list">
                <ol class="dd-list">
                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="dd-item">
                            <div class="dd-handle"> <?php echo e(numToAlpha($i)); ?>

                            </div>
                        </li>
                        <?php $i++ ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </div>
        </div>
        <div class="col-md-10">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    <?php $x = 1; ?>
                    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="dd-item" data-id="<?php echo e($f); ?>">
                            <div class="dd-handle"> <?php echo e($f); ?>

                                <span class="label label-primary float-right"><?php echo e(numToAlpha($x)); ?></span>
                            </div>
                        </li>
                        <?php $x++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="import-serialization-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Json Fields</label>
            <textarea id="nestable-output" name="fields" class="form-control input-sm"></textarea>
        </div>

    </form>
    <script>
        // Nestable
        $(function() {
            function updateOutput(e) {
                var list   = e.length ? e : $(e.target);
                var output = list.data('output');

                output.val(window.JSON ? window.JSON.stringify(list.nestable('serialize')) :
                    'JSON browser support required for this demo.');
            };
            $('#nestable').nestable({ group: 1,maxDepth: 1 }).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#import-serialization-form','serializeImport/'.$import->id, "closeModal();"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','50'); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/import/serialization.blade.php ENDPATH**/ ?>