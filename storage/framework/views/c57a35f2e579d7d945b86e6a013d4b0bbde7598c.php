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
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/admin/device/sensor/disposition/newLine.blade.php ENDPATH**/ ?>