<div class="col-12"><h6 class="border-bottom font-weight-bolder pb-2">Aportes (m<sup>3</sup>)</h6></div>
<div class="col-4">

    <p class="text-primary font-weight-bolder text-center fs-xxl mt-3"><?php echo e(shortBigNumbers($totalizer['total'])); ?></p>
    <p class="label text-center mt-n1">Aporte Total</p>
</div>
<div class="col-8">
    <div class="ml-auto d-inline-flex align-items-center">
        <div class="d-inline-flex flex-column small ml-2">
            <span class="label">Hoy</span>
            <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($totalizer['today'] > 0 )?$totalizer['today'] : 'N/A'); ?></span>
            <span class="label mt-2">Ayer</span>
            <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($totalizer['yesterday'] > 0 )?$totalizer['yesterday'] : 'N/A'); ?></span>
        </div>
        <div class="d-inline-flex flex-column small ml-4">
            <span class="label">Semana Pasada</span>
            <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($totalizer['lastWeek'] > 0 )?$totalizer['lastWeek'] : 'N/A'); ?></span>
            <span class="label mt-2">Mes Pasado</span>
            <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($totalizer['lastMonth'] > 0 )?$totalizer['lastMonth'] : 'N/A'); ?></span>
        </div>
    </div>
</div>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/partials/kpi/totalizer-kpi.blade.php ENDPATH**/ ?>