<?php $__env->startSection('page-icon','cloud-upload-alt'); ?>
<?php $__env->startSection('page-title'); ?>
	Módulos de importación
    <a href="javascript:void(0);" class="btn btn-outline-secondary btn-xs" id="list-view"><i class="fal fa-2x fa-table"></i></a>
    <a href="javascript:void(0);" class="btn btn-outline-secondary btn-xs" id="item-view"><i class="fal fa-2x fa-boxes"></i></a>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
	<div id="import-view-content">

	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        $(document).ready(function(){
            $('#list-view').click();
        });
        $('#list-view').click(function(){
            $(this).removeClass('btn-outline-secondary').addClass('btn-primary');
            $('#item-view').removeClass('btn-primary').addClass('btn-outline-secondary');
            getViewImport('list');
        });

        $('#item-view').click(function(){
            $(this).removeClass('btn-outline-seconday').addClass('btn-primary');
            $('#list-view').removeClass('btn-primary').addClass('btn-outline-secondary');
            getViewImport('item');
        });

        function getViewImport(url)
        {

            $.get('/getImports/' + url, function(data){
                $('#import-view-content').html(data)
            });
        }
    </script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/import/show/index2.blade.php ENDPATH**/ ?>
