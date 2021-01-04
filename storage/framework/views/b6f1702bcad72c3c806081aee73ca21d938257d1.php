<?php if(isset($fullView) && $fullView == 'full'): ?>
    <div class="col-xl-12">
        <h6 class="d-block border-bottom font-weight-bolder pb-2"><?php echo e($kpi['check_point']); ?></h6>
    </div>
    <div class="col-xl-3">
        <div class="px-2 py-1 bg-success rounded overflow-hidden position-relative text-white mb-1 text-center " >
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    <?php echo e(($kpi['average_cost'] > 0 )?'$ '.$kpi['average_cost'] : 'N/A'); ?>

                                </span>
                    <small class="m-0 l-h-n font-weight-bolder fs-nano">Costo M<sup>3</sup> Promedio</small>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="px-2 py-1 bg-info rounded overflow-hidden position-relative text-white mb-1 text-center " >
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    <?php echo e(($kpi['last_hour_cost'] > 0 )?'$ '.$kpi['last_hour_cost'] : 'N/A'); ?>

                                </span>
                    <small class="m-0 l-h-n font-weight-bolder fs-nano">Costo M<sup>3</sup> hora Anterior</small>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="px-2 py-1 bg-info rounded overflow-hidden position-relative text-white mb-1 text-center " >
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    <?php echo ($kpi['last_hour_input'] > 0 )?$kpi['last_hour_input']  : ' N/A'; ?>

                                </span>
                                <span class="fs-nano">
                                    <?php echo ($kpi['last_hour_input'] > 0 )?'m<sup>3</sup>' : ' N/A'; ?>

                                </span>

                    <small class="m-0 l-h-n font-weight-bolder fs-nano">Aporte Hora Anterior</small>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="px-2 py-1 bg-info rounded overflow-hidden position-relative text-white mb-1 text-center " >
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                                <span class="text-white"  id="" >
                                    <?php echo ($kpi['last_hour_energy'] > 0 )?$kpi['last_hour_energy'].' kWh' : ' N/A'; ?>

                                </span>
                    <small class="m-0 l-h-n font-weight-bolder fs-nano">Consumo Hora Anterior</small>
                </h3>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="col-4">
        <h6 class="d-block border-bottom font-weight-bolder pb-2"><?php echo e($kpi['check_point']); ?></h6>
        <div class="ml-auto d-inline-flex align-items-center">
            <div class="d-inline-flex flex-column small ml-2">
                <span class="label">Costo M<sup>3</sup> Promedio</span>
                <span class="d-inline-block badge badge-success text-center fs-lg px-3 py-4  font-weight-bolder" style="min-width: 100%; max-width: 100%"><?php echo e(($kpi['average_cost'] > 0 )?'$ '.$kpi['average_cost'] : 'N/A'); ?></span>
            </div>
            <div class="d-inline-flex flex-column small ml-4">
                <span class="label mt-2">Ultima M<sup>3</sup> hora Anterior</span>
                <span class="d-inline-block badge badge-info text-center  px-3 py-2   fs-md font-weight-bold" style="min-width: 100%; max-width: 100%"><?php echo e(($kpi['last_hour_cost'] > 0 )?'$ '.$kpi['last_hour_cost'] : 'N/A'); ?></span>
                <span class="label mt-2">Aporte hora anterior</span>
                <span class="d-inline-block badge badge-info text-center  px-3 py-2  fs-md font-weight-bold" style="min-width: 100%; max-width: 100%"><?php echo ($kpi['last_hour_input'] > 0 )?$kpi['last_hour_input'].' <small>m<sup>3</sup></small>' : 'N/A'; ?></span>
                <span class="label mt-2">Consumo hora anterior</span>
                <span class="d-inline-block badge badge-info text-center  px-3 py-2  fs-md font-weight-bold" style="min-width: 100%; max-width: 100%"><?php echo ($kpi['last_hour_energy'] > 0 )?$kpi['last_hour_energy'].' <small>kWh</small>' : 'N/A'; ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/partials/kpi/cost-kpi.blade.php ENDPATH**/ ?>