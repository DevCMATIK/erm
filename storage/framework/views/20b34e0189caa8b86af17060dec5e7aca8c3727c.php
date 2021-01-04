<h6>
    Grilla : <?php echo e($checkPoint->name); ?>

</h6>
<?php echo includeCss(['plugins/nestable/nestable.css']); ?>

<?php echo includeScript([
    'plugins/nestable/nestable.js',
    'plugins/jstree/jstree.js'
]); ?>

<?php
    $blank_count = 1;
?>
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col">
                <div class="dd border p-2" id="nestable">
                    <ol class="dd-list " id="list-1">
                        <?php if(optional($checkPoint->grids)->first()): ?>
                            <?php $__currentLoopData = $checkPoint->grids()->where('column',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($grid->sensor_id === null): ?>
                                    <li class="dd-item border p-1" data-id="blank_<?php echo e($blank_count); ?>">
                                        <div class="dd-handle"></div>
                                    </li>
                                    <?php
                                        $blank_count++;
                                    ?>
                                <?php else: ?>
                                    <li class="dd-item" data-id="<?php echo e($grid->sensor->id); ?>">
                                        <div class="dd-handle"><?php echo e($grid->sensor->name); ?></div>
                                    </li>
                                <?php endif; ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <?php $__currentLoopData = $checkPoint->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $device->analogous_sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="dd-item" data-id="<?php echo e($sensor->id); ?>">
                                        <div class="dd-handle"><?php echo e($sensor->name); ?></div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ol>
                </div>

            </div>
            <div class="col">
                <div class="dd border p-2" id="nestable2">
                    <ol class="dd-list <?php if($checkPoint->grids()->where('column',2)->count() === 0): ?> dd-empty <?php endif; ?> " id="list-2">
                        <?php if(optional($checkPoint->grids)->first()): ?>
                            <?php $__currentLoopData = $checkPoint->grids()->where('column',2)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($grid->sensor_id === null): ?>
                                    <li class="dd-item border p-1" data-id="blank_<?php echo e($blank_count); ?>">
                                        <div class="dd-handle"></div>
                                    </li>
                                    <?php
                                        $blank_count++;
                                    ?>
                                <?php else: ?>
                                    <li class="dd-item" data-id="<?php echo e($grid->sensor->id); ?>">
                                        <div class="dd-handle"><?php echo e($grid->sensor->name); ?></div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>
            <div class="col">
                <div class="dd border p-2" id="nestable3" >
                    <ol class="dd-list <?php if($checkPoint->grids()->where('column',3)->count() === 0): ?> dd-empty <?php endif; ?>" id="list-3">
                        <?php if(optional($checkPoint->grids)->first()): ?>
                            <?php $__currentLoopData = $checkPoint->grids()->where('column',3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($grid->sensor_id === null): ?>
                                    <li class="dd-item border p-1" data-id="blank_<?php echo e($blank_count); ?>">
                                        <div class="dd-handle"></div>
                                    </li>
                                    <?php
                                        $blank_count++;
                                    ?>
                                <?php else: ?>
                                    <li class="dd-item" data-id="<?php echo e($grid->sensor->id); ?>">
                                        <div class="dd-handle"><?php echo e($grid->sensor->name); ?></div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<form class="my-5" role="form"  id="menu-serialization-form">
    <?php echo csrf_field(); ?>
    <input type="hidden" id="blank_count" value="<?php echo e($blank_count); ?>">
    <div class="form-group">
        <button type="submit" class="btn btn-primary" >Serializar</button>

        <button type="button" class="btn btn-info add-blank">Agregar espacio en blanco</button>
        <button type="button" class="btn btn-warning remove-blank">Remover espacio en blanco</button>
        <a href="javascript:void(0);"  onClick="resetGrid(<?php echo e($checkPoint->id); ?>)" class="btn btn-danger reset-grid">Reset</a>
    </div>
    <div class="form-group">
        <label class="form-label">Sensores</label>
        <textarea id="nestable-output" name="column1" readonly class="form-control input-sm"></textarea>
        <textarea id="nestable-output2" name="column2" readonly class="form-control input-sm"></textarea>
        <textarea id="nestable-output3" name="column3"  readonly class="form-control input-sm"></textarea>
    </div>

</form>

<h5>Reportar a DGA</h5>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class="label-form">Intervalo de reporte</label>
            <select name="dga_report" id="dga_report" class="form-control">
                <?php switch($checkPoint->dga_report):
                    case (1): ?>
                        <option value="null">No Reportar</option>
                        <option value="1" selected>Cada Hora</option>
                        <option value="2">1 vez al día</option>
                        <option value="3">1 vez al mes</option>
                        <option value="4">1 vez al año</option>
                    <?php break; ?>
                    <?php case (2): ?>
                        <option value="null">No Reportar</option>
                        <option value="1">Cada Hora</option>
                        <option value="2" selected>1 vez al día</option>
                        <option value="3">1 vez al mes</option>
                        <option value="4">1 vez al año</option>
                    <?php break; ?>
                    <?php case (3): ?>
                        <option value="null">No Reportar</option>
                        <option value="1">Cada Hora</option>
                        <option value="2">1 vez al día</option>
                        <option value="3" selected>1 vez al mes</option>
                        <option value="4">1 vez al año</option>
                    <?php break; ?>
                    <?php case (4): ?>
                        <option value="null">No Reportar</option>
                        <option value="1">Cada Hora</option>
                        <option value="2">1 vez al día</option>
                        <option value="3">1 vez al mes</option>
                        <option value="4" selected>1 vez al año</option>
                    <?php break; ?>
                    <?php default: ?>
                        <option value="null" selected>No Reportar</option>
                        <option value="1">Cada Hora</option>
                        <option value="2">1 vez al día</option>
                        <option value="3">1 vez al mes</option>
                        <option value="4">1 vez al año</option>
                    <?php break; ?>
                <?php endswitch; ?>

            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="form-label">Código de obra</label>
            <input type="text" class="form-control" id="work_code" value="<?php echo e($checkPoint->work_code); ?>">
        </div>
    </div>
</div>
<a href="javascript:void(0)" class="btn btn-primary mt-3" onclick="saveDga()">Guardar datos de reporte DGA</a>

<script>
   function saveDga()
   {
       var dga_report = $('#dga_report').val();
       var work_code = $('#work_code').val();
       $.get('/check-point/dga/<?php echo e($checkPoint->id); ?>?work_code='+work_code+'&dga_report='+dga_report,function(data){
           toastr.success('Datos reporte DGA actualizados.');
       });
   }

   $(document).ready(function(){


       $('.add-blank').click(function(e){
           var counter = $('#blank_count').val();
           $('#list-1').append('<li class="dd-item border p-1" data-id="blank_'+counter+'" id="blank_'+counter+'">\n' +
               '                                    <div class="dd-handle"></div>\n' +
               '                                </li>');
           var newCounter = (parseInt(counter) + parseInt('1'));
           $('#blank_count').val(newCounter);
       });

       $('.remove-blank').click(function(e){
           var counter = $('#blank_count').val();
           var oldCounter = parseInt(counter) - parseInt('1');
           $('#blank_'+oldCounter).remove();
           var newCounter = (parseInt(counter) - parseInt('1'));
           if(newCounter < 1) {
               newCounter = 1;
           }
           $('#blank_count').val(newCounter);
       });
       var updateOutput = function(e)
       {
           var list   = e.length ? e : $(e.target),
               output = list.data('output');
           if (window.JSON) {
               output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
           } else {
               output.val('JSON browser support required for this demo.');
           }
       };

       $('#nestable')
           .nestable({ group:1, maxDepth: 1})
           .on('change', updateOutput);
       $('#nestable2')
           .nestable({ group: 1, maxDepth: 1})
           .on('change', updateOutput);
       $('#nestable3')
           .nestable({ group: 1, maxDepth: 1})
           .on('change', updateOutput);
       updateOutput($('#nestable').data('output', $('#nestable-output')));
       updateOutput($('#nestable2').data('output', $('#nestable-output2')));
       updateOutput($('#nestable3').data('output', $('#nestable-output3')));
   });


</script>

<?php echo makeValidation('#menu-serialization-form','/CheckPointSensorsSerialization/'.$checkPoint->id, "showGrid(".$checkPoint->id.")"); ?>


<?php /**PATH /shared/httpd/erm/resources/views/client/check-point/grid/index.blade.php ENDPATH**/ ?>