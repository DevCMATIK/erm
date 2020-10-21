<?php echo includeCss(
    'css/bootstrap.css',
    'css/app.core.css',
    'css/app.icons.css',
    'plugins/toastr/toastr.css',
    'plugins/sweetalert2/sweetalert2.css'
);; ?>


<?php if (! empty(trim($__env->yieldContent('more-css')))): ?>
    <?php echo $__env->yieldContent('more-css'); ?>
<?php endif; ?>
<?php /**PATH /shared/httpd/erm/resources/views/components/html-helpers/core-css.blade.php ENDPATH**/ ?>