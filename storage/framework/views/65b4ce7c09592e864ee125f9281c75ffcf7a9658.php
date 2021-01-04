
<?php $__env->startSection('page-title','Administrar Dashboards'); ?>
<?php $__env->startSection('page-icon','cog'); ?>
<?php $__env->startSection('page-content'); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xl-6">
                                <label class="form-label">Zonas</label>
                                <select class="form-control"  id="zone" onchange="getSubZones()">
                                    <option value="">Seleccione...</option>
                                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-xl-6" id="SubZoneContainer">
                                <label class="form-label">Sub Zonas</label>
                                <select class="form-control"  id="sub_zona">
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body" id="adminContainer">
                    <div class="alert alert-info">
                        Seleccione sub Zona para administrar los dispositivos.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getSubZones() {
            let zone = $('#zone').val();
            $.get('/getSubZonesCombo/'+zone, function(data){
                $('#SubZoneContainer').html(data);
            });
        }

        function getDataFromSubZone() {
            let subZone = $('#sub_zone').val();
            location.href = '/admin-panel/'+subZone;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/panel/index.blade.php ENDPATH**/ ?>