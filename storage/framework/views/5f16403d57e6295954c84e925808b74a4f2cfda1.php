<?php $__env->startSection('modal-title','Receptores del email'); ?>
<?php $__env->startSection('modal-content'); ?>
   <div class="row">
       <div class="col">
           <table class="table table-striped">
               <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
               </thead>
               <tbody>
               <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($u->user->full_name); ?></td>
                    <td><?php echo e($u->user->email); ?></td>
                </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
           </table>
       </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit'); ?>
    .
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/mail/receptors.blade.php ENDPATH**/ ?>