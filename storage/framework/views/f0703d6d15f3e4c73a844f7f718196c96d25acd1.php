<?php $__env->startSection('page-title','Caudales autorizados por punto de control'); ?>
<?php $__env->startSection('page-icon','database'); ?>

<?php $__env->startSection('page-content'); ?>
    <form class="" role="form"  id="check-point-flows-form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        Puntos de control disponibles
                    </div>
                    <div class="card-body table-responsive">
                        <table class="datatable-demo  table table-bordered table-striped" id="check_points">
                            <thead>
                            <tr>
                                <th>Zona</th>
                                <th>Sub Zona</th>
                                <th>Punto de Control</th>
                                <th>Dispositivo</th>
                                <th>Caudal autorizado</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($device->check_point->sub_zones()->first()->zone->name); ?></td>
                                    <td><?php echo e($device->check_point->sub_zones()->first()->name); ?></td>
                                    <td><?php echo e($device->check_point->name); ?></td>
                                    <td><?php echo e($device->name); ?></td>
                                    <td>
                                        <input type="text" class="form-control" name="flows[]" value="<?php echo e(optional($device->check_point->authorized_flow)->authorized_flow); ?>">
                                        <input type="hidden" name="check_points[]" value="<?php echo e($device->check_point->id); ?>">
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
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/datatables/datatables.blunde.js'); ?>

    <?php echo getTableScript('check_points'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>

        $(document).ready(function()
        {
            let form = $("#check-point-flows-form");
            form.on('submit',function(e) {
                e.preventDefault();
                $('#check-point-flows-form .alert').remove();
                $.ajax({
                    url     : '/check-point-flows',
                    type    : 'POST',
                    data    : form.serialize(),
                    dataType: "json",
                    success : function ( json )
                    {
                        $('.form-control').removeClass('is-invalid').addClass('is-valid');
                        $('.error-tooltip').remove();
                        toastr.success( "Se ha completado correctamente el formulario." , "Formulario Completado!" );
                        form.prepend("<div class='alert alert-success alert-dismissible fade show'>"+json.success+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        location.href = '/check-point-flows';
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

<?php echo $__env->make('layouts.app-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/client/check-point/flow/index2.blade.php ENDPATH**/ ?>
