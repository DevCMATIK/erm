
<?php $__env->startSection('modal-title','Ordenar Zonas'); ?>
<?php $__env->startSection('modal-content'); ?>
    <?php echo includeCss(['plugins/nestable/nestable.css']); ?>

    <?php echo includeScript([
        'plugins/nestable/nestable.js',
        'plugins/jstree/jstree.js'
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="dd" id="nestable">
                <ol class="dd-list">
                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="dd-item border" data-id="<?php echo e($zone->id); ?>">
                            <div class="dd-handle">
                                 <?php echo e($zone->name); ?>

                                <span class="label label-primary float-right"><?php echo e($zone->position); ?></span>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="zone-serialization-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Json Menu</label>
            <textarea id="nestable-output" name="zone" class="form-control input-sm"></textarea>
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
            $('#nestable').nestable({ group: 1 , maxDepth: 3}).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#zone-serialization-form','/zoneSerialization', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/client/zone/serialize.blade.php ENDPATH**/ ?>