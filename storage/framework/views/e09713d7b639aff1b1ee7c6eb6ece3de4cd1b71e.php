<div class="p-3 <?php echo e($bg ?? 'bg-primary-300'); ?> <?php echo e((isset($extraClasses))?implode(' ',$extraClasses):''); ?> rounded overflow-hidden position-relative text-white mb-g <?php if($value > 99999999 && $value < 1000000000): ?> pb-2 pt-4 <?php endif; ?> <?php if($value > 999999999): ?> pb-2 pt-5 <?php endif; ?>">
    <div class="">
        <h3 class="display-4 d-block l-h-n m-0 fw-500" <?php if($value > 99999999 && $value < 1000000000): ?> style="font-size:2.5em;" <?php endif; ?> <?php if($value > 999999999): ?> style="font-size:2.1em;" <?php endif; ?>>
            <?php echo e(number_format($value,0,',','.')); ?>

            <span class="fs-nano">
                    <?php echo e($measure); ?>

                </span>
            <small class="m-0 l-h-n"><?php echo e($title); ?></small>
        </h3>
    </div>
    <i class="fas <?php echo e($icon ?? 'fa-database'); ?> position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem "></i>
</div>
<?php /**PATH /shared/httpd/erm/resources/views/test/electric/partials/main-box.blade.php ENDPATH**/ ?>