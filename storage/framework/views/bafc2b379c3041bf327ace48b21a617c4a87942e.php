<?php $__env->startSection('page-title','Nombres de puntos de control para home'); ?>
<?php $__env->startSection('page-icon','database'); ?>

<?php $__env->startSection('page-content'); ?>
    <form class="" role="form"  id="check-point-labels-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        Puntos de control disponibles
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Zona</th>
                                <th>Sub Zona</th>
                                <th>Punto de Control</th>
                                <th>Dispositivo</th>
                                <th>Nombre a mostrar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $data->sortBy('position'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($row['zone']); ?></td>
                                    <td><?php echo e($row['sub_zone']); ?></td>
                                    <td><?php echo e($row['check_point']); ?></td>
                                    <td><?php echo e($row['device_name']); ?></td>
                                    <td>
                                        <input type="text" class="form-control" name="labels[]" value="<?php echo e($row['label'] ?? $row['check_point']); ?>">
                                        <input type="hidden" name="check_points[]" value="<?php echo e($row['check_point_id']); ?>">
                                        <input type="hidden" name="devices[]" value="<?php echo e($row['device_id']); ?>">
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>

        $(document).ready(function()
        {
            let form = $("#check-point-labels-form");
            form.on('submit',function(e) {
                e.preventDefault();
                $('#check-point-labels-form .alert').remove();
                $.ajax({
                    url     : '/check-point-labels',
                    type    : 'POST',
                    data    : form.serialize(),
                    dataType: "json",
                    success : function ( json )
                    {
                        $('.form-control').removeClass('is-invalid').addClass('is-valid');
                        $('.error-tooltip').remove();
                        toastr.success( "Se ha completado correctamente el formulario." , "Formulario Completado!" );
                        form.prepend("<div class='alert alert-success alert-dismissible fade show'>"+json.success+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        location.href = '/check-point-labels';
                    },
                    error   : function ( response )
                    {
                        let messages = jQuery.parseJSON(response.responseText);
                        if(response.status === 401){
                            if(messages.error){
                                form.prepend("<div class='alert alert-danger alert-dismissible fade show'>"+messages.error+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                            }else{
                                form.prepend("<div class='alert alert-danger alert-dismissible fade show'>No se pudo completar la acción.<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                            }
                        }else if( response.status === 500) {
                            form.prepend("<div class='alert alert-danger alert-dismissible fade show'>Ha Ocurrido en el servidor.<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        }else{
                            handleFormErrors(messages);
                        }
                    }
                })
            });



        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/check-point/label/index2.blade.php ENDPATH**/ ?>
