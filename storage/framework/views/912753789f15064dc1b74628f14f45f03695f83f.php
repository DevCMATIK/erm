
<?php $__env->startSection('modal-title','Subir Archivo'); ?>
<?php $__env->startSection('modal-content'); ?>
    <?php echo includeCss(['plugins/dropzone/dropzone.css']); ?>

    <?php echo includeScript(['plugins/dropzone/dropzone.js']); ?>

    <form class="dropzone" action="/importFile/upload"  enctype="multipart/form-data" id="dropzoneForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" value="<?php echo e($slug); ?>" name="slug">
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#dropzoneForm").dropzone({
                method: 'POST',
                acceptedFiles : '.csv',
                queuecomplete : function(){
                    toastr.success('Se han cargado los archivos.');
                    location.reload()
                },
                error : function (response){
                    var messages = jQuery.parseJSON(response.responseText);
                    if(response.status == 401){
                        if(messages.error){
                            toastr.error(messages.error,'Error!');
                        }else{
                            toastr.error('Error al cargar los archivos','Error!');
                        }
                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('no-submit','Si no desea cargar archivos presione'); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/import/import-file/upload.blade.php ENDPATH**/ ?>