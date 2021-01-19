<?php $__env->startSection('page-title','Restaurar Data'); ?>
<?php $__env->startSection('page-icon','database'); ?>
<?php $__env->startSection('page-content'); ?>
    <?php if($message = \Illuminate\Support\Facades\Session::get('success')): ?>
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong><?php echo e($message); ?></strong>
        </div>
    <?php endif; ?>
    <div id="panel-2" class="panel">
        <div class="panel-hdr">
            <h2>Proceso de restauración de data</h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="panel-tag">
                    Debes indicar el Id de sensor y el rango de fechas, el sistema utilizará la disposición por defecto y el intervarlo fijado en la configuración del sensor.
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Id del sensor</label>
                            <input type="text" class="form-control" name="sensor_id" id="sensor_id">
                        </div>
                        <div class="form-group hide-before">
                            <label class="form-label">Fecha de inicio (yyyy-mm-dd)</label>
                            <input type="text" class="form-control datepicker" name="start_date" id="start_date">
                        </div>
                        <div class="form-group hide-before">
                            <label class="form-label">Fecha de término (yyyy-mm-dd)</label>
                            <input type="text" class="form-control datepicker" name="end_date" id="end_date">
                        </div>
                    </div>
                    <div class="col-6" id="sensor-data">
                        <div class="panel-tag">
                            <strong>Indique el id del sensor para continuar</strong>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <button  value="" class="btn btn-danger hide-before" id="delete-data">Eliminar Data</button>
                        <button value="" class="btn btn-primary hide-before" id="restore-data">Restaurar Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>

        $('#restore-data').on('click',function(){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var sensor_id = $('#sensor_id').val();
            if(start_date != '' && end_date != '') {
                Swal.fire({
                    title: "Eliminar Data",
                    text: "Realmente desea restaurar la data del sensor en el periodo indicado?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, restaurar"
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: "GET",
                            url: "/restore-data/begin-restore",
                            data: {
                                start_date : start_date,
                                end_date : end_date,
                                sensor_id : sensor_id
                            },
                            success: function success(data) {
                                toastr.info("Ha comenzado el proceso de restauración de data (ver horizon)");
                            },
                            error: function error(data) {
                                console.log(data.responseText);
                                var obj = jQuery.parseJSON(data.responseText);

                                if (obj.error) {
                                    toastr.error(obj.error);
                                    Swal.close();
                                }
                            }
                        });
                    } else {
                        Swal.close();
                    }
                });
            } else {
                toastr.error("Debe indicar Fecha de inicio y término");
            }
        });
        $('#delete-data').on('click',function(){
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var sensor_id = $('#sensor_id').val();
            if(start_date != '' && end_date != '') {
                Swal.fire({
                    title: "Eliminar Data",
                    text: "Realmente desea eliminar la data del sensor en el periodo indicado?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Si, eliminar"
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: "GET",
                            url: "/restore-data/delete",
                            data: {
                                start_date : start_date,
                                end_date : end_date,
                                sensor_id : sensor_id
                            },
                            success: function success(data) {
                                toastr.info("Ha comenzado el proceso de eliminación de data (ver horizon)");
                            },
                            error: function error(data) {
                                console.log(data.responseText);
                                var obj = jQuery.parseJSON(data.responseText);

                                if (obj.error) {
                                    toastr.error(obj.error);
                                    Swal.close();
                                }
                            }
                        });
                    } else {
                        Swal.close();
                    }
                });
            } else {
                toastr.error("Debe indicar Fecha de inicio y término");
            }

        });

        $('.hide-before').hide();

        $('#sensor_id').on('blur',function(){
            $.ajax({
                url : '/restore-data/get-sensor-data',
                method : 'GET',
                contentType : 'json',
                data: {sensor_id: $(this).val()},
                success : function(json) {
                    $('#sensor-data').html('');
                    $('#sensor-data').append('<p><strong>Sensor: </strong><br>'+json.name+'</p>');
                    $('#sensor-data').append('<p><strong>Dispositivo: </strong><br>'+json.device.name+'</p>');
                    $('#sensor-data').append('<p><strong>Address: </strong><br>'+json.full_address+'</p>');
                    $('#sensor-data').append('<p><strong>GRD ID: </strong><br>'+json.device.internal_id+'</p>');
                    $('#sensor-data').append('<p><strong>Intervalo: </strong><br>'+json.type.interval+'</p>');
                    $('.hide-before').show();
                },
                error : function(data){
                    $('.hide-before').hide();
                    $('#sensor-data').html('<div class="alert alert-danger">No se ha encontrado el sensor.</div>');
                }
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/data/restore.blade.php ENDPATH**/ ?>