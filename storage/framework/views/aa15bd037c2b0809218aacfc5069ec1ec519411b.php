
<?php $__env->startSection('page-title','Opciones de cuenta'); ?>
<?php $__env->startSection('page-icon','cog'); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-2 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" id="first-item" href="<?php echo e(route('userSettings.general')); ?>">
                        General
                    </a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="<?php echo e(route('userSettings.changePassword')); ?>">
                        Cambiar Contraseña
                    </a>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-ajax-content">
                        <!-- Content of tabs goes Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>


        $(document).ready(function(){
            getTabContent($('#first-item').attr('href'));

            $('.list-group-item').click(function (e) {
                e.preventDefault();
                let now_tab = e.target;
                getTabContent($(now_tab).attr('href'));
            });
        });

        function getTabContent(url) {
            $.get(url,function(data){
                $("#tab-ajax-content").html(data);
            });
        }
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/user/settings/index.blade.php ENDPATH**/ ?>