
<?php $__env->startSection('modal-icon','fa-list-ol'); ?>
<?php $__env->startSection('modal-title','Serializar Sequiencia'); ?>
<?php $__env->startSection('modal-content'); ?>
    <?php echo printCss(['libs/nestable/nestable.css']); ?>

    <?php echo printScript([
        'libs/nestable/nestable.js',
        'libs/jstree/jstree.js'
    ]); ?>


        <div class="col-md-12">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    <?php $x = 1; ?>
                    <?php $__currentLoopData = $imports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $import): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="dd-item" data-id="<?php echo e($import->id); ?>">
                            <div class="dd-handle"> <?php echo e($import->name); ?></div>
                        </li>
                        <?php $x++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="queuedImport-serialization-form">
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
    <?php echo makeValidation('#queuedImport-serialization-form','serializeQueuedImport/'.$queue->id, "closeModal();"); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-width','50'); ?>

<?php echo $__env->make('layouts.modal.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/import/queue/serialization.blade.php ENDPATH**/ ?>