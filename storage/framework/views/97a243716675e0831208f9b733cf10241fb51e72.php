<h5>Proceso de Carga  <label class="float-right"><?php echo e($importFile->processed_count); ?>/<?php echo e($importFile->temps_count); ?> </label></h5>
<div class="progress m-t-10">
    <div class="progress-bar bg-info  progress-bar" style="width: <?php echo e($percentaje); ?>%; height:15px;" role="progressbar">
        <?php echo e($percentaje); ?>%
    </div>
</div>
<div class="note">
    <strong><?php echo e($percentaje); ?>% Completado.</strong>
</div>
<?php /**PATH /shared/httpd/erm/resources/views/system/import/import-file/progressBar.blade.php ENDPATH**/ ?>