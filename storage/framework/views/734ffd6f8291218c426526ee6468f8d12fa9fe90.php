<h5 class="p-2 bg-primary text-white mb-4">
    <?php echo e($sensor->name); ?> - <?php echo e($sensor->address->name); ?><?php echo e($sensor->address_number); ?>


    <a class="btn btn-xs btn-default float-right mx-1" href="/sensor-triggers?sensor_id=<?php echo e($sensor->id); ?>" target="_blank"><i class="fas fa-link"></i> Triggers</a>
    <a class="btn btn-xs btn-default float-right mx-1" href="/sensor-alarms?sensor_id=<?php echo e($sensor->id); ?>" target="_blank"><i class="fas fa-exclamation-triangle"></i> Alarmas</a>
    <a class="btn btn-xs btn-default float-right mx-1" href="/sensor-chronometers?sensor_id=<?php echo e($sensor->id); ?>" target="_blank"><i class="fas fa-clock"></i> Cronómetros</a>

</h5>
<script>
    function addScale()
    {
        let row = parseInt($('#last_row').val());
        let newRow = row + 1;
        $.get('/addNewScale/'+newRow, function(data) {
            $('#scales-div').append(data);
            $('#last_row').val(newRow);
        });
    }

    function deleteDisposition(sensor,disposition)
    {
        $.get('/deleteDisposition/'+disposition, function(data) {
            getScaleForm(sensor);
        });
    }

    function createLastAverage() {
        let average = $('#last_average').val();
        $.get('/createAverageForSensor/<?php echo e($sensor->id); ?>/'+average, function(data){
            getScaleForm(<?php echo e($sensor->id); ?>);
        });
    }
</script>

<form id="scale-form">
    <?php echo csrf_field(); ?>
    <div class="row m-2 pb-2">
        <div class="col-xl-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="enable" name="enabled"
                       <?php if($sensor->enabled ==1): ?> checked <?php endif; ?> >
                <label class="custom-control-label fs-xl" for="enable">Habilitar</label>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="alarm" name="has_alarm"
                       <?php if($sensor->has_alarm ==1): ?> checked <?php endif; ?> >
                <label class="custom-control-label fs-xl" for="alarm">Alarma</label>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="historial" name="historial"
                       <?php if($sensor->historial ==1): ?> checked <?php endif; ?> >
                <label class="custom-control-label fs-xl" for="historial">Historico</label>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" value="1" class="custom-control-input" id="fix_values_out_of_range" name="fix_values_out_of_range"
                       <?php if($sensor->fix_values_out_of_range == 1): ?> checked <?php endif; ?> >
                <label class="custom-control-label fs-xl" for="fix_values_out_of_range">Fix Values</label>
            </div>
        </div>
        <div class="col-xl-3">
            <?php if(isset($sensor->average) && optional($sensor->average)->last_average != null): ?>
                <p><small class="font-weight-bolder">Última Media: </small><?php echo e($sensor->average->last_average); ?></p>

            <?php else: ?>
                <div class="form-group">
                    <label class="form-label">Última Media</label>
                    <input type="text" class="form-control" id="last_average" onblur="createLastAverage()">
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row p-2 border-top">
        <div class="col-xl-4">
            <label class="custom-control custom-checkbox">
                <input type="checkbox"  class="custom-control-input" value="1" <?php if($sensor->fix_values === 1): ?> checked <?php endif; ?> name="fix_values">
                <span class="custom-control-label">Reparar valores erróneos</span>
            </label>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label class="form-label">Valor Mínimo</label>
                <input type="text" class="form-control" id="fix_min_value" name="fix_min_value" value="<?php echo e($sensor->fix_min_value); ?>">
            </div>
        </div>
        <div class="col-xl-4">
            <div class="form-group">
                <label class="form-label">Valor máximo</label>
                <input type="text" class="form-control" id="fix_max_value" name="fix_max_value" value="<?php echo e($sensor->fix_max_value); ?>">
            </div>
        </div>
    </div>
    <div class="row p-2">
        <div class="col-12 p-2" id="scales-div">
            <h6 class="text-primary border-bottom">Disposiciones <a href="javascript:void(0)" class="btn btn-info float-right btn-xs" onclick="addScale()">Agregar nueva</a></h6>
            <input type="hidden" id="last_row" value="1">

            <?php $__empty_1 = true; $__currentLoopData = $sensor->dispositions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disposition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($loop->last): ?>
                    <script>
                        $('#last_row').val(<?php echo e($loop->iteration); ?>);
                    </script>
                <?php endif; ?>
                    <div class="border p-2 my-1">
                        <h5> <?php echo e($disposition->name); ?>

                            <a href="javascript:void(0)" onclick="deleteDisposition(<?php echo e($sensor->id); ?>, <?php echo e($disposition->id); ?>)" class="btn btn-danger float-right btn-xs "><i class="fas fa-times"></i></a>
                            <a href="/testValue/<?php echo e($sensor->id); ?>/<?php echo e($disposition->id); ?>" <?php echo makeLinkRemote(); ?>  class="btn btn-info float-right btn-xs "><i class="fas fa-eye"></i></a>
                            <a href="/disposition-lines/<?php echo e($disposition->id); ?>" <?php echo makeLinkRemote(); ?>  class="btn btn-secondary float-right btn-xs "><i class="fas fa-chart-line"></i></a>
                        </h5>
                        <input type="hidden" name="row_id[]" id="row_<?php echo e($loop->iteration); ?>" value="<?php echo e($loop->iteration); ?>">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Nombre Disposicion</label>
                                    <input type="text" class="form-control" name="name[]" id="name_<?php echo e($loop->iteration); ?>" value="<?php echo e($disposition->name); ?>">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Escala</label>
                                    <select class="form-control" name="scale_id[]" id="scale_id_<?php echo e($loop->iteration); ?>">
                                        <?php $__currentLoopData = $scales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($scale->id == $disposition->scale_id): ?>
                                                <option value="<?php echo e($scale->id); ?>" selected><?php echo e($scale->name); ?></option>
                                                <?php else: ?>
                                                <option value="<?php echo e($scale->id); ?>"><?php echo e($scale->name); ?></option>
                                                <?php endif; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Unidad de Medida</label>
                                    <select name="unit_id[]" id="unit_id_<?php echo e($loop->iteration); ?>"  class="form-control">
                                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($unit->id == $disposition->unit_id): ?>
                                                <option value="<?php echo e($unit->id); ?>" selected><?php echo e($unit->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">N. Decimales</label>
                                    <input type="text" class="form-control" name="precision[]" id="precision_<?php echo e($loop->iteration); ?>" value="<?php echo e($disposition->precision ?? 0); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">



                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Minimo Ing.</label>
                                    <input type="text" class="form-control" name="sensor_min[]" id="scale_min_<?php echo e($loop->iteration); ?>" value="<?php echo e($disposition->sensor_min); ?>">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Maximo Ing.</label>
                                    <input type="text" class="form-control" name="sensor_max[]" id="scale_max_<?php echo e($loop->iteration); ?>" value="<?php echo e($disposition->sensor_max); ?>">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Minimo (Sensor)</label>
                                    <input type="text" class="form-control" name="scale_min[]" id="sensor_min_<?php echo e($loop->iteration); ?>" value="<?php echo e($disposition->scale_min); ?>">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label class="form-label">Valor Maximo (Sensor)</label>
                                    <input type="text" class="form-control" name="scale_max[]" id="sensor_max_<?php echo e($loop->iteration); ?>" value="<?php echo e($disposition->scale_max); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <script> addScale();</script>
            <?php endif; ?>


        </div>

    </div>
    <div class="form-group p-2">
        <button class="btn btn-primary float-right" type="submit">Guardar</button>
    </div>
</form>

<?php echo makeValidation('#scale-form','/storeSensorScale/'.$sensor->id, "getScaleForm(".$sensor->id.");"); ?>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/device/scale-form.blade.php ENDPATH**/ ?>