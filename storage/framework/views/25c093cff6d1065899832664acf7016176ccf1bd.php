
<?php $__env->startSection('page-title','Data de Dispositivos'); ?>
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
            <h2>
                Dispositivos <span class="fw-300"><i>Status de la data historica</i></span>

            </h2>
            <div class="panel-toolbar">
                <a class="btn btn-primary btn-xs"  href="/syncDevices"><i class="fas fa-sync" ></i> Sincronizar Dispositivos</a>
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>


            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="panel-tag">
                    Puedes filtrar por sub zona y dispositivo usando subzona-dispositivo ej: coya-copa coya, coya-, copa coya, etc.
                </div>
                <div class="border bg-light rounded-top">
                    <div class="form-group p-2 m-0 rounded-top">
                        <input type="text" class="form-control form-control-lg shadow-inset-2 m-0" id="js_list_accordion_filter" placeholder="Filtrar dispositivos">
                    </div>
                    <?php
                        $script = '';
                    ?>
                    <div id="js_list_accordion" class="accordion accordion-hover accordion-clean">
                        <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $deviceCheck = 1;
                            ?>
                            <div class="card border-top-left-radius-0 border-top-right-radius-0">
                                <div class="card-header ">
                                    <a href="javascript:void(0);"
                                       class="card-title collapsed"
                                       data-toggle="collapse"
                                       data-target="#device_list_<?php echo e($device->id); ?>"
                                       aria-expanded="false"
                                       data-filter-tags="<?php echo e(strtolower($device->name)); ?> <?php $__currentLoopData = $device->check_point->sub_zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e(strtolower($sub_zone->name.'-'.$device->name.' ')); ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                                        <i class="fal fa-cog width-2 fs-xl"></i>
                                        <?php echo e($device->name); ?> <div class="ml-3" id="header_<?php echo e($device->id); ?>"></div>
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
                                <div id="device_list_<?php echo e($device->id); ?>" class="collapse"  data-parent="#js_list_accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                Click <a href="/backupDevice/<?php echo e($device->id); ?>" class="btn btn-primary btn-xs">AQUI</a> para comenzar la converson de este dispositvo completo, puedes hacer click en el icono <i class="fas fa-cog mx-2"> </i> de cada mes o sensor para hacerlo aun mas particionado.
                                                <br><br>
                                                <?php $__empty_1 = true; $__currentLoopData = $device->sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php if(optional($sensor->average)->last_average != null): ?>
                                                        <a href="/sensorAveragesBackup/<?php echo e($sensor->id); ?>" class="btn btn-primary btn-xs m-2"><?php echo e($sensor->full_address); ?></a>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <ul class="list-group">
                                            <?php $__currentLoopData = $device->data_checks->groupBy('month'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <?php

                                                    $monthCheck = 1;
                                                ?>
                                                <li class="list-group-item cursor-pointer" id="<?php echo e($device->id); ?>_month_<?php echo e($key); ?>" data-remote="true" href="#collapsed_<?php echo e($key); ?>" id="parent_<?php echo e($device->id); ?>" data-toggle="collapse" data-parent="#collapsed_<?php echo e($key); ?>">
                                                    <?php echo e(ucfirst(\Carbon\Carbon::createFromFormat('m',$key)->formatLocalized('%B %Y'))); ?>

                                                    <a href="/backupDeviceByMonth/<?php echo e($key); ?>/<?php echo e($device->id); ?>" class="float-right"><i class="fas fa-cog"></i></a>
                                                </li>
                                                <ul class="collapse list-group"  id="collapsed_<?php echo e($key); ?>">
                                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php

                                                            if($sensor->check == 0) {
                                                                $deviceCheck = 0;
                                                                $monthCheck = 0;
                                                            }
                                                        ?>
                                                        <li class="list-group-item pl-5">
                                                            <i class="fas fa-circle <?php if($sensor->check == 0 ): ?> text-danger <?php else: ?> text-success <?php endif; ?>"></i>
                                                            <?php echo e($sensor->address); ?>

                                                            <a href="/backupDeviceBySensor/<?php echo e($key); ?>/<?php echo e($device->id); ?>/<?php echo e($sensor->address); ?>" class="float-right text-dark"><i class="fas fa-cog"></i></a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                                    <?php if($monthCheck == 1): ?>
                                                    <?php
                                                        $script = $script . "$('#".$device->id."_month_".$key."').prepend('<i class=\"fa fa-circle text-success\"></i>');";
                                                    ?>
                                                    <?php else: ?>
                                                    <?php
                                                        $script = $script . "$('#".$device->id."_month_".$key."').prepend('<i class=\"fa fa-circle text-danger\"></i>');";
                                                    ?>
                                                    <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                <?php if($deviceCheck == 1): ?>
                                    <?php
                                        $script = $script . "$('#header_".$device->id."').html('<i class=\"fa fa-circle text-success\"></i>');";
                                    ?>
                                <?php else: ?>
                                    <?php
                                        $script = $script . "$('#header_".$device->id."').html('<i class=\"fa fa-circle text-danger\"></i>');";
                                    ?>
                                <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <span class="filter-message js-filter-message"></span>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>
        initApp.listFilter($('#js_list_accordion'), $('#js_list_accordion_filter'));
        $(document).ready(function(){
            <?php echo $script; ?>

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/data/index.blade.php ENDPATH**/ ?>