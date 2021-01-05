<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo e(config('app.name')); ?> -  <?php echo $__env->yieldContent('page-title'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('page-title'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link rel="icon" href="<?php echo e(asset('images/logo-mini.png')); ?>" sizes="192x192" />
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- base css -->
    <?php echo $__env->make('components.html-helpers.core-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body>
<div class="page-wrapper">
    <div class="page-inner bg-gray-200">
        <div class="page-content-wrapper bg-transparent m-0 mt-5">

            <div class="flex-1 mt-5" style="background: url(<?php echo e(asset('images/pattern-1.svg')); ?>) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col col-md-6 col-lg-7 hidden-sm-down" >
                            <img src="<?php echo e(asset('images/main-logo.png')); ?>" alt="" width="100%" style="margin: 0px; margin-left: -100px;">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
                                <img src="<?php echo e(asset('images/main-logo.png')); ?>" alt="" class="d-sm-block d-md-none mx-auto" width="100%" style="margin-top: -110px; margin-left: auto;">

                            <div class="card p-4 rounded-plus bg-faded text-dark">
                                <div class="text-center fs-md">
                                    <?php echo $__env->yieldContent('page-title'); ?>
                                </div>
                               <?php echo $__env->yieldContent('auth-content'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-dark">
                        <?php echo e(\Carbon\Carbon::now()->year); ?> © <?php echo e(config('app.name')); ?> by&nbsp;<a href='https://www.cmatik.cl' class='text-dark opacity-40 fw-500' title='cmatik.cl' target='_blank'>cmatik.cl</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('components.html-helpers.core-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo includeScript('js/forms.js'); ?>

<?php echo $__env->yieldContent('validation'); ?>
</body>
</html>
<?php /**PATH /shared/httpd/erm/resources/views/auth/main.blade.php ENDPATH**/ ?>