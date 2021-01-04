<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Seleccione un rango de fechas</label>
            <input type="text" class="form-control date-filter" name="date_filter" id="date_filter">
        </div>
    </div>
</div>

<?php echo $__env->make('water-management.dashboard.energy.sections.sub.stream', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('water-management.dashboard.energy.sections.sub.tension', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('water-management.dashboard.energy.sections.sub.power', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/energy/sections/energy.blade.php ENDPATH**/ ?>