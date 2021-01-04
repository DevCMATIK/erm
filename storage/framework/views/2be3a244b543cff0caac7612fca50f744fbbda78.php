<?php if($flow): ?>
    <div class="col-12"><h6 class="border-bottom font-weight-bolder pb-2">Caudal (LT/s)</h6></div>
    <?php if($flow['flow_percent'] != null): ?>
        <div class="col-4">
            <div class="js-easy-pie-chart color-info-900 mt-1 position-relative d-inline-flex align-items-center justify-content-center" data-percent="<?php echo e($flow['flow_percent']); ?>" data-piesize="80" data-linewidth="10" data-linecap="butt">
                <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                    <div class="number position-absolute pos-top pos-left pos-right pos-bottom d-flex align-items-center justify-content-center fw-500 fs-xl text-dark"><?php echo e(number_format($flow['flow_percent'] ,1)); ?>%</div>
                </div>
            </div>
            <p class="label text-center">FU</p>
        </div>
    <?php endif; ?>

    <div class="<?php if($flow['flow_percent']  != null): ?> col-8 <?php else: ?> col-12 <?php endif; ?>">
        <div class="ml-auto d-inline-flex align-items-center">
            <div class="d-inline-flex flex-column small ml-2">
                <span class="label">Hoy</span>
                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($flow['flow_today'] > 0)? number_format($flow['flow_today'] ,1) : 'N/A'); ?> </span>
                <span class="label mt-2">Ayer</span>
                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($flow['flow_yesterday'])? number_format($flow['flow_yesterday'] ,1) : 'N/A'); ?></span>
            </div>
            <div class="d-inline-flex flex-column small ml-4">
                <span class="label">Semana Pasada</span>
                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($flow['flow_lastWeek'])? number_format($flow['flow_lastWeek'] ,1) : 'N/A'); ?></span>
                <span class="label mt-2">Mes Pasado</span>
                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold"><?php echo e(($flow['flow_lastMonth'])? number_format($flow['flow_lastMonth'] ,1) : 'N/A'); ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/partials/kpi/flow-kpi.blade.php ENDPATH**/ ?>