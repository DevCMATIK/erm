<?php $__env->startSection('more-css'); ?>
    <?php echo includeCss('plugins/datatables/datatables.blunde.css'); ?>

<?php $__env->stopSection(); ?>
<div class="row">
    <div class="col-xl-12">

        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Listado de módulos de importación
                </h2>
                <div class="panel-toolbar">`
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <table class="datatables-demo table table-striped table-bordered" id="table-generated">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Importaciones</th>
                            <th>Importar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $imports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $import): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($import->name); ?></td>
                                <td><?php echo e($import->description); ?></td>
                                <td><?php echo e($import->files_count); ?></td>
                                <td><a href="importFile/<?php echo e($import->slug); ?>" class="btn btn-primary btn-xs">Ir a importar</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/datatables/datatables.blunde.js'); ?>

    <?php echo getTableScript(); ?>

<?php $__env->stopSection(); ?>

<?php /**PATH /shared/httpd/erm/resources/views/system/import/show/table.blade.php ENDPATH**/ ?>