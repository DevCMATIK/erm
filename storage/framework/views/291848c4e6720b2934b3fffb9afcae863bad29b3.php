
<?php $__env->startSection('page-title'); ?>
    <?php echo e('Resumen Energía: '.$zone->name); ?>

    <a href="/zone-resume-table/<?php echo e($zone->id); ?>" class="btn btn-primary btn-xs pull-right" target="_blank">Vista PowerBI</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-icon','bolt'); ?>
<?php $__env->startSection('page-content'); ?>
    <style>
        @media (max-width: 576px) {
            .main-box-number {
                font-size: 1.3em;
            }
            .box-label {
                font-size: 0.7em;
            }
            .main-box-icon {
                visibility: hidden;
            }
        }
    </style>
   <div class="row">
       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary-300',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + (is_numeric($item[key($item)]['today'])?$item[key($item)]['today']:0);
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo Hoy',
                'icon' => 'fa-bolt'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
       </div>
       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary-300',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + $item[key($item)]['yesterday'];
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo Ayer',
                'icon' => 'fa-bolt'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
       </div>

       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + $item[key($item)]['this-month']['consumption'];
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo este mes',
                'icon' => 'fa-calendar'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
       </div>
       <div class="col-lg-3 col-xl-3 col-md-6 col-sm-12">
           <?php echo $__env->make('water-management.dashboard.energy.components.main-box', [
                'bg' => 'bg-primary',
                'value' => $consumptions->reduce(function($carry,$item){
                                return $carry + $item[key($item)]['this-year']['consumption'];
                           }),
                'unit' => 'kWh',
                'title' => 'Consumo este año',
                'icon' => 'fa-calendar'
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
       </div>
   </div>

    <div class="row mt-4">
        <div class="col-12">
            <table class="table m-0 table-bordered table-light table-striped table-dark">
                <thead>
                <tr>
                    <th>Sub Zona</th>
                    <th>Hoy</th>
                    <th>Ayer</th>
                    <th>Este mes</th>
                    <th>Este año</th>

                </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $consumptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consumption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(key($consumption)); ?></td>
                            <td><strong><?php echo e((is_numeric($consumption[key($consumption)]['today']))?number_format($consumption[key($consumption)]['today'],1,',','.'):'0'); ?></strong> <span class="fs-nano">kWh</span></td>
                            <td><strong><?php echo e((is_numeric($consumption[key($consumption)]['yesterday']))?number_format($consumption[key($consumption)]['yesterday'],1,',','.'):'0'); ?></strong> <span class="fs-nano">kWh</span></td>
                            <td><strong><?php echo e((is_numeric($consumption[key($consumption)]['this-month']['consumption']))?number_format($consumption[key($consumption)]['this-month']['consumption'],1,',','.'):'0'); ?></strong> <span class="fs-nano">kWh</span></td>
                            <td><strong><?php echo e((is_numeric($consumption[key($consumption)]['this-year']['consumption']))?number_format($consumption[key($consumption)]['this-year']['consumption'],1,',','.'):'0'); ?></strong> <span class="fs-nano">kWh</span></td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript([
		   'plugins/highcharts/highcharts.js',
		   'plugins/highcharts/modules/exporting.js',
	   ]); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <?php echo includeScript('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/energy/resume.blade.php ENDPATH**/ ?>