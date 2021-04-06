
<?php $__env->startSection('modal-title','Serializar Sensores'); ?>
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
                    <?php $__currentLoopData = $mailReport->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="dd-item border" data-id="<?php echo e($sensor->id); ?>">
                            <div class="dd-handle">
                                <span class="fas fa-circle}}"></span>&nbsp;<?php echo e($sensor->device->sub_element->first()->element->sub_zone->name); ?> -
                                <?php echo e($sensor->device->name); ?> -
                                <?php echo e($sensor->full_address); ?>

                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </div>
        </div>
    </div>

    <form class="my-5" role="form"  id="sensors-serialization-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Json Sensors</label>
            <textarea id="nestable-output" name="sensors" class="form-control input-sm"></textarea>
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
            $('#nestable').nestable({ group: 1 , maxDepth: 1}).on('change', updateOutput);
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#sensors-serialization-form','/mailReportSerialization/'.$mailReport->id, ""); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/report/serialize.blade.php ENDPATH**/ ?>