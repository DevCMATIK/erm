<div class="row my-3">
    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12" id="">
        <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-secondary btn-xs active" onclick="tensionOptions('average');" data-toggle="tooltip" data-original-title="Potencia Líneas">
                <input type="radio" name="tensionOptions" value="average" checked="checked"> P. Líneas
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');" data-toggle="tooltip" data-original-title="Activa">
                <input type="radio" name="tensionOptions" value="detail" > Act
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');" data-toggle="tooltip" data-original-title="Reactiva">
                <input type="radio" name="tensionOptions" value="detail" > Reac
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="tensionOptions('detail');" data-toggle="tooltip" data-original-title="Aparente">
                <input type="radio" name="tensionOptions" value="detail" > Apa
            </label>
        </div>

        <?php echo $__env->make('test.electric.components.data-box',[
        'bg' => 'bg-danger-300',
        'value' => 52.4,
        'measure' => 'KW',
        'title' => 'P1',
        'mb' => 'mb-1'
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('test.electric.components.data-box',[
          'bg' => 'bg-danger-300',
          'value' => 54.4,
          'measure' => 'KW',
          'title' => 'P2',
          'mb' => 'mb-1'
      ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('test.electric.components.data-box',[
          'bg' => 'bg-danger-300',
          'value' => 60.4,
          'measure' => 'KW',
          'title' => 'P3',
          'mb' => 'mb-1'
      ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-lg-9 col-xl-9 col-md-9 col-sm-12" id="powerChartContainer">

    </div>
</div>

<script>

</script>
<?php /**PATH /shared/httpd/erm/resources/views/test/electric/sections/sub/power.blade.php ENDPATH**/ ?>