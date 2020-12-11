<div class="row my-3">
    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-12">
        <div class="btn-group btn-group-xs btn-block mb-2 btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-secondary btn-xs active" onclick="streamOptions('average');" data-toggle="tooltip" data-original-title="Promedio">
                <input type="radio" name="streamOptions" value="average" checked="checked"> <i class="fas fa-chart-line"></i>
            </label>
            <label class="btn btn-outline-secondary btn-xs"  onclick="streamOptions('detail');" data-toggle="tooltip" data-original-title="Detalle">
                <input type="radio" name="streamOptions" value="detail" > <i class="fas fa-bars"></i>
            </label>
        </div>

        <?php echo $__env->make('test.electric.components.data-box',[
          'bg' => 'bg-warning-600',
          'value' => 284.4,
          'measure' => 'A',
          'title' => 'L1',
          'mb' => 'mb-1'
      ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('test.electric.components.data-box',[
          'bg' => 'bg-warning-600',
          'value' => 254.4,
          'measure' => 'A',
          'title' => 'L2',
          'mb' => 'mb-1'
      ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('test.electric.components.data-box',[
          'bg' => 'bg-warning-600',
          'value' => 295.4,
          'measure' => 'A',
          'title' => 'L3',
          'mb' => 'mb-1'
      ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-lg-9 col-xl-9 col-md-9 col-sm-12" id="streamChartContainer">

    </div>
</div>
<?php /**PATH /shared/httpd/erm/resources/views/test/electric/sections/sub/stream.blade.php ENDPATH**/ ?>