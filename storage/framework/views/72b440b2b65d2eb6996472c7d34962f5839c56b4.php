<?php $__env->startSection('page-title','TestView'); ?>
<?php $__env->startSection('page-icon','key'); ?>
<?php $__env->startSection('page-content'); ?>
    <style>
        .progress-bar-vertical {
            width: 80%;
            margin: auto;
            min-height: 140px;
            display: flex;
            align-items: flex-end;
            border-radius: 5px !important;
        }

        .progress-bar-vertical .progress-bar {
            width: 100%;
            height: 0;
            -webkit-transition: height 0.6s ease;
            -o-transition: height 0.6s ease;
            transition: height 0.6s ease;
        }
    </style>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-block  has-popover rounded-plus mb-1 px-2 py-1 text-center" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="120,6l/s" data-template='<div class="popover bg-primary-500 border-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header bg-transparent"></h3><div class="popover-body text-white text-center"></div></div>' data-original-title="Caudal autorizado" id="d_1">
                        <h2 class=" mb-0 text-success">
                            <span class="font-weight-bolder " style=" font-size: 0.9em !important;">1111,25</span>
                            <span class="fs-nano text-dark">l/s</span>
                        </h2>
                        <span  class="font-weight-bold text-dark  fs-nano">Caudal</span>
                        <span  class="font-weight-bold text-muted hidden-sm-up  fs-nano"> (Autorizado 120,61 l/s)</span>
                    </div>
                    <div class="d-block  rounded-plus mb-1 px-2 py-1 text-center" id="d_2">
                        <h2 class=" mb-0 text-success">
                            <span class="font-weight-bolder " style=" font-size: 0.9em !important;">123,25</span>
                            <span class="fs-nano text-dark">mt</span>
                        </h2>
                        <span  class="font-weight-bold text-dark  fs-nano">Otro</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('body').popover(
                {
                    selector: '.has-popover'
                });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/erm/resources/views/test/view.blade.php ENDPATH**/ ?>