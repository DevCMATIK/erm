
<?php $__env->startSection('page-title','Administrar: '.$subZone->name); ?>
<?php $__env->startSection('page-icon','cog'); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row mb-2">
        <div class="col-xl-2">
            <?php echo makeLink('/admin-panel', 'Volver'); ?>

        </div>
    </div>

    <div class="row bg-white border p-3">
        <?php echo $__env->make('water-management.admin.panel.partials.configuration', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="row bg-white border p-3 mt-4">
        <div class="col-xl-12" id="columns-config">

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        getColumns(<?php echo e($subZone->id); ?>);
       function changeColumns(sub_zone)
       {
            let columns = $('#sub_zone_columns').val();
            $.ajax({
                method : 'get',
                url : '/admin-panel/changeColumns/'+sub_zone+'/'+columns,
                success : function () {
                   getColumns(sub_zone);
                }
            });
       }

       function getColumns(sub_zone)
       {
           $.ajax({
               method : 'get',
               url : '/admin-panel/getColumns/'+sub_zone,
               success : function (data) {
                   $('#columns-config').html(data);
               }
           });
       }
       $('#block_columns').click(function(){
           let checked;
           if($(this).prop("checked") === true){
               checked = 1;
           }
           else if($(this).prop("checked") === false){
               checked = 0
           }

           $.ajax({
               method : 'get',
               url : '/admin-panel/changeBlocked/<?php echo e($subZone->id); ?>/'+checked,
               success : function () {
                   location.reload();
               }
           });
       });


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/panel/admin.blade.php ENDPATH**/ ?>