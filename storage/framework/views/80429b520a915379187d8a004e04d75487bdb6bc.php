<?php $__env->startSection('modal-title','Modificar Reporte de email'); ?>
<?php $__env->startSection('modal-content'); ?>
    <form class="" role="form"  id="mail-report-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($mailReport->name); ?>">
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <select class="form-control" name="mail_id">
                <?php $__empty_1 = true; $__currentLoopData = $mails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if($mail->id == $mailReport->mail_id): ?>
                        <option value="<?php echo e($mail->id); ?>" selected><?php echo e($mail->name); ?></option>
                    <?php else: ?>
                        <option value="<?php echo e($mail->id); ?>"><?php echo e($mail->name); ?></option>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <option value="" disabled="disabled">No hay disponibles</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="accordion accordion-outline" id="js_demo_accordion-3">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#js_demo_accordion-3a" aria-expanded="true">
                        Frecuencia de ejecucion
                        <span class="ml-auto">
                            <span class="collapsed-reveal">
                                <i class="fal fa-minus fs-xl"></i>
                            </span>
                            <span class="collapsed-hidden">
                                <i class="fal fa-plus fs-xl"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div id="js_demo_accordion-3a" class="collapse show" data-parent="#js_demo_accordion-3">
                    <div class="card-body">
                        <div class="alert alert-info">
                            Importante!, Algunas de las frequencias requieren parametros Adicionales, utilice el campo "ejecutar en" para indicar estos parametros,
                            El parametro requerido aparece en cada opcion.
                        </div>
                        <div class="form-group">
                            <label class="form-label">Frecuencia</label>
                            <select class="form-control" name="frequency">
                                <?php switch($mailReport->frequency):
                                    case ('hourly'): ?>
                                    <option value="hourly" selected>Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    <?php break; ?>
                                    <?php case ('hourlyAt'): ?>
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt" selected>Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    <?php break; ?>
                                    <?php case ('dailyAt'): ?>
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt" selected>Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    <?php break; ?>
                                    <?php case ('weeklyOn'): ?>
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn" selected>Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    <?php break; ?>
                                    <?php case ('monthlyOn'): ?>
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn" selected>Mensual [Dia,Hora, ej: '29,20']</option>
                                    <?php break; ?>
                                <?php endswitch; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ejecutar En</label>
                            <input type="text" class="form-control" name="start_at" value="<?php echo e($mailReport->start_at); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#js_demo_accordion-3b" aria-expanded="false">
                        Grupos
                        <span class="ml-auto">
                            <span class="collapsed-reveal">
                                <i class="fal fa-minus fs-xl"></i>
                            </span>
                            <span class="collapsed-hidden">
                                <i class="fal fa-plus fs-xl"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div id="js_demo_accordion-3b" class="collapse" data-parent="#js_demo_accordion-3">
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="<?php echo e($group->id); ?>" <?php if(\App\Domain\WaterManagement\Report\MailReportGroup::where('mail_report_id',$mailReport->id)->where('group_id',$group->id)->first()): ?> checked <?php endif; ?> name="group_id[]">
                                <span class="custom-control-label"><?php echo e($group->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            No ha creado Grupos
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#js_demo_accordion-3c" aria-expanded="false">
                        Sensores
                        <span class="ml-auto">
                            <span class="collapsed-reveal">
                                <i class="fal fa-minus fs-xl"></i>
                            </span>
                            <span class="collapsed-hidden">
                                <i class="fal fa-plus fs-xl"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div id="js_demo_accordion-3c" class="collapse" data-parent="#js_demo_accordion-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <h5>Filtros Rapidos</h5>
                                <p>Sub Zonas</p>
                                <div id="js_list_accordion" class="accordion accordion-hover accordion-clean">
                                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card my-0 border-top-left-radius-0 border-top-right-radius-0 p-0">
                                            <div class="card-header ">
                                                <a href="javascript:void(0);"
                                                   class="card-title collapsed"
                                                   data-toggle="collapse"
                                                   data-target="#zone_list_<?php echo e($zone->id); ?>"
                                                   aria-expanded="false">
                                                    <?php echo e($zone->name); ?>

                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-chevron-up fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-chevron-down fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="zone_list_<?php echo e($zone->id); ?>" class="collapse"  data-parent="#js_list_accordion">
                                                <div class="card-body p-0">
                                                    <ul class="list-group p-0">
                                                        <?php $__currentLoopData = $zone->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="list-group-item cursor-pointer m-0 w-100 border-0" id="sub_zone_<?php echo e($sub_zone->id); ?>" data-remote="true" id="parent_<?php echo e($zone->id); ?>">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input filter-sensor" value="<?php echo e($sub_zone->id); ?>" name="sub_zone">
                                                                    <span class="custom-control-label"><?php echo e($sub_zone->name); ?></span>
                                                                </label>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <hr>
                                <p>Puntos de Control</p>
                                <?php $__currentLoopData = $checkPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $checkPoint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item check_points cursor-pointer" id="check_points_<?php echo e($checkPoint->id); ?>">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox"  class="custom-control-input filter-sensor" value="<?php echo e($checkPoint->id); ?>" name="check_point">
                                            <span class="custom-control-label"><?php echo e($checkPoint->name); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="col-xl-4">
                                <p>Tipos de Sensor</p>
                                <?php $__currentLoopData = $sensor_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item sensor_type cursor-pointer" id="sensor_type_<?php echo e($type->id); ?>">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox"  class="custom-control-input filter-sensor" value="<?php echo e($type->id); ?>" name="sensor_type">
                                            <span class="custom-control-label"><?php echo e($type->name); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <hr>
                                <p>Tipos de Registro</p>
                                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item address_type cursor-pointer" id="address_<?php echo e($address->id); ?>">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox"  class="custom-control-input filter-sensor" value="<?php echo e($address->id); ?>" name="address">
                                            <span class="custom-control-label"><?php echo e($address->name); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="col-xl-4" id="sensor-list">
                                <h5>Sensores seleccionados</h5>
                                <?php $__empty_1 = true; $__currentLoopData = $mailReport->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="list-group-item py-1 px-2">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" checked class="custom-control-input" value="<?php echo e($sensor->id); ?>" name="sensor_id[]">
                                            <span class="custom-control-label"><?php echo e($sensor->device->sub_element->first()->element->sub_zone->name); ?> -
                                            <?php echo e($sensor->device->name); ?> -
                                            <?php echo e($sensor->full_address); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p>No ha seleccionado sensores</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <script>
        $(document).ready(function(){


            $('.filter-sensor').on('click',function(e){
                $.get('/report/filterSensors',{
                    types : getTypesSelected(),
                    address : getAddressSelected(),
                    sub_zones : getSubZonesSelected(),
                    check_points : getCheckPointsSelected(),
                    mail_report : <?php echo e($mailReport->id); ?>,
                },function(data){
                    $('#sensor-list').html(data)
                })
            });



            function getAddressSelected()
            {
                let address = [];
                $.each($("input[name='address']:checked"), function(){
                    address.push($(this).val());
                });

                if(address.length > 0) {
                    return address.join(',');
                } else {
                    return '';
                }
            }

            function getTypesSelected()
            {
                let types = [];
                $.each($("input[name='sensor_type']:checked"), function(){
                    types.push($(this).val());
                });

                if(types.length > 0) {
                    return types.join(',');
                } else {
                    return '';
                }
            }
            function getSubZonesSelected()
            {
                let types = [];
                $.each($("input[name='sub_zone']:checked"), function(){
                    types.push($(this).val());
                });

                if(types.length > 0) {
                    return types.join(',');
                } else {
                    return '';
                }
            }

            function getCheckPointsSelected()
            {
                let types = [];
                $.each($("input[name='check_point']:checked"), function(){
                    types.push($(this).val());
                });

                if(types.length > 0) {
                    return types.join(',');
                } else {
                    return '';
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#mail-report-form','/mail-reports/'.$mailReport->id, "tableReload(); closeModal();"); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/report/edit.blade.php ENDPATH**/ ?>