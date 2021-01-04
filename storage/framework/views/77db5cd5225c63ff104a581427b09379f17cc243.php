
<?php $__env->startSection('page-title','Importando: '.$importFile->file); ?>
<?php $__env->startSection('page-icon','file-excel-o'); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        $(document).ready(function(){
            $.ajax({
                url     : '/importTemps/<?php echo e($importFile->id); ?>',
                type    : 'GET',
                dataType: "json",
                success : function ( json )
                {
                    showProcesar();
                },
                error   : function ( response )
                {
                    if(response.status == 401){
                        let messages = jQuery.parseJSON(response.responseText);
                        if(messages.error){
                            $('#import-content').html('<div class="alert alert-danger"><h5><strong>Error.</strong></h5><p>'+messages.error+'</p></div>');
                            $('#import-content').after('<a href="/importFile/<?php echo e($importFile->import->slug); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> Volver</a>');
                        }else{
                            toastr.error('Error al procesar la planilla','Error!');
                        }
                    }
                }
            });
        });

        function showProcesar(){
            $.get('/importFile/process/<?php echo e($importFile->id); ?>', function(data){
                $('#import-content').html(data);
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card  ">
                <div class="card-header bg-primary text-white">
                    Cargar Planilla: <?php echo e($importFile->file); ?>

                </div>
                <div class="card-body" id="import-content">
                    <h5><i class="fa fa-spinner fa-spin"></i> Checking file Status...</h5>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/system/import/import-file/import.blade.php ENDPATH**/ ?>