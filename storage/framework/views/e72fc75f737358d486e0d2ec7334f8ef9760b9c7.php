
<?php $__env->startSection('modal-title','Serializar Menu'); ?>
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
                    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="dd-item" data-id="<?php echo e($m['id']); ?>">
                            <div class="dd-handle">
                                <span class="fas fa-<?php echo e($m['icon']); ?>"></span>&nbsp; <?php echo e($m['name']); ?>

                                <span class="label label-primary float-right"><?php echo e($m['position']); ?></span>
                            </div>
                            <?php if(count($m['children']) > 0): ?>
                                <ol class="dd-list">
                                    <?php $__currentLoopData = $m['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="dd-item" data-id="<?php echo e($child['id']); ?>">
                                            <div class="dd-handle">
                                                <span class="fas fa-<?php echo e($child['icon']); ?>"></span>&nbsp; <?php echo e($child['name']); ?>

                                                <span class="label label-primary float-right"><?php echo e($child['position']); ?></span>
                                            </div>
                                            <?php if(count($child['children']) > 0): ?>
                                                <ol class="dd-list">
                                                    <?php $__currentLoopData = $child['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="dd-item" data-id="<?php echo e($c['id']); ?>">
                                                            <div class="dd-handle">
                                                                <span class="fas fa-<?php echo e($c['icon']); ?>"></span>&nbsp; <?php echo e($c['name']); ?>

                                                                <span class="label label-primary float-right"><?php echo e($c['position']); ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ol>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="menu-serialization-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Json Menu</label>
            <textarea id="nestable-output" name="menu" class="form-control input-sm"></textarea>
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
    <?php echo makeValidation('#menu-serialization-form','/menuSerialization', "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/menu/serialization/index.blade.php ENDPATH**/ ?>