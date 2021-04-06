
<?php $__env->startSection('modal-title','Lineas de disposición'); ?>

<?php $__env->startSection('modal-content'); ?>
    <script>
        $(document).ready(function(){

        });
        function addLine()
        {

            $.get('/addNewLine', function(data) {
                $('#disposition-lines-form').append(data);
            });
        }

        function deleteLine(line)
        {
            $.get('/deleteLineInDisposition/'+line, function(data) {
                $('#dline-'+line).remove();
                toastr.success('Linea eliminada');
            });
        }
    </script>
    <h5>Disposicion actual: <?php echo e($disposition->name); ?></h5>
    <a href="javascript:void(0);" class="btn btn-primary float-right" onclick="addLine()">Agregar Linea</a><br><br><br>
    <form class="" role="form"  id="disposition-lines-form">
        <?php echo csrf_field(); ?>
        <?php $__empty_1 = true; $__currentLoopData = $disposition->lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border p-2 my-1" id="dline-<?php echo e($line->id); ?>">
                <a href="javascript:void(0);" class="btn btn-danger btn-sm float-right" onclick="deleteLine(<?php echo e($line->id); ?>)"><i class="fas fa-times"></i></a><br><br><br>
                <div class="row">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Gráfico</label>
                            <select name="chart[]" class="form-control">
                                <?php switch($line->chart):
                                    case ('default'): ?>
                                        <option value="default" selected>Por Defecto</option>
                                        <option value="averages">Promedios</option>
                                        <option value="daily-averages">Promedios Diarios</option>
                                    <?php break; ?>
                                    <?php case ('averages'): ?>
                                        <option value="default">Por Defecto</option>
                                        <option value="averages" selected>Promedios</option>
                                        <option value="daily-averages">Promedios Diarios</option>
                                    <?php break; ?>
                                    <?php case ('daily-averages'): ?>
                                        <option value="default">Por Defecto</option>
                                        <option value="averages">Promedios</option>
                                        <option value="daily-averages" selected>Promedios Diarios</option>
                                    <?php break; ?>
                                <?php endswitch; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Color</label>
                            <select name="color[]" class="form-control">
                                <?php switch($line->color):
                                    case ('green'): ?>
                                    <option value="green" selected>Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue">Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    <?php break; ?>
                                    <?php case ('red'): ?>
                                    <option value="green">Verde</option>
                                    <option value="red" selected >Roja</option>
                                    <option value="blue">Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    <?php break; ?>
                                    <?php case ('blue'): ?>
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" selected>Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    <?php break; ?>
                                    <?php case ('yellow'): ?>
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow" selected>Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    <?php break; ?>
                                    <?php case ('black'): ?>
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black" selected>Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange">Naranja</option>
                                    <?php break; ?>
                                    <?php case ('gray'): ?>
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow" >Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray" selected>Ploma</option>
                                    <option value="orange">Naranja</option>
                                    <?php break; ?>
                                    <?php case ('orange'): ?>
                                    <option value="green">Verde</option>
                                    <option value="red">Roja</option>
                                    <option value="blue" >Azul</option>
                                    <option value="yellow">Amarilla</option>
                                    <option value="black">Negra</option>
                                    <option value="gray">Ploma</option>
                                    <option value="orange" selected>Naranja</option>
                                    <?php break; ?>
                                <?php endswitch; ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Valor</label>
                            <input type="text" class="form-control" name="value[]"  value="<?php echo e($line->value); ?>">
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Nombre de la Línea</label>
                            <input type="text" class="form-control" name="text[]" value="<?php echo e($line->text); ?>">
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="border p-2 my-1">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Gráfico</label>
                            <select name="chart[]" class="form-control">
                                <option value="default">Por Defecto</option>
                                <option value="averages">Promedios</option>
                                <option value="daily-averages">Promedios Diarios</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Color</label>
                            <select name="color[]" class="form-control">
                                <option value="green">Verde</option>
                                <option value="red">Roja</option>
                                <option value="blue">Azul</option>
                                <option value="yellow">amarilla</option>
                                <option value="black">Negra</option>
                                <option value="gray">Ploma</option>
                                <option value="orange">Naranja</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Valor</label>
                            <input type="text" class="form-control" name="value[]" >
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label class="form-label">Nombre de la Línea</label>
                            <input type="text" class="form-control" name="text[]">
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </form>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('modal-validation'); ?>
    <?php echo makeValidation('#disposition-lines-form','/disposition-lines/'.$disposition->id, " "); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.modals.form-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/device/sensor/disposition/index.blade.php ENDPATH**/ ?>