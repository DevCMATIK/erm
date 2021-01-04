
<?php $__env->startSection('page-title','Administrar Grupos'); ?>
<?php $__env->startSection('page-icon','cog'); ?>
<?php $__env->startSection('more-css'); ?>
    <?php echo includeCss('plugins/duallistbox/duallistbox.css'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/duallistbox/duallistbox.js'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-description'); ?>
    <?php echo makeLink('/groups','Administrar Grupos','fa-users', 'btn-primary float-right'); ?>

    <?php echo makeLink('/users','Administrar Usuarios','fa-user', 'btn-info float-right mr-1'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>

    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Administrar usuarios de grupo
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                       <div class="row">
                           <div class="col-md-3">
                               <ul class="list-group mb-6">
                                   <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                       <li class="list-group-item">
                                           <a href="javascript:void(0);" onclick="getUsersFromGroup(<?php echo e($group->id); ?>)" id="group_<?php echo e($group->id); ?>" class="group-item text-contrast">
                                               <i class="fas fa-users"></i>
                                               <?php echo e($group->name); ?>

                                           </a>
                                       </li>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                       <li class="list-group-item">No ha creado Grupos</li>
                                   <?php endif; ?>
                               </ul>
                           </div>
                           <div class="col-md-9" id="list-group-users">
                                <div class="alert alert-info">
                                    <strong>Nota:</strong>
                                    Seleccione un grupo para administrar los usuarios.
                                </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function getUsersFromGroup(group_id) {
            $('.group-item').removeClass('text-white').parent().removeClass('active text-white');
            $('#group_'+group_id).addClass('text-white').parent().addClass('active');
            getView('getUsersFromGroup/'+group_id,'#list-group-users');

        }
    </script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/manage/group/index.blade.php ENDPATH**/ ?>