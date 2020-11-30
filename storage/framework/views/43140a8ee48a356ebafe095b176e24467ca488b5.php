<div class="p-2 <?php echo e($bg ?? 'bg-primary-300'); ?> <?php echo e((isset($extraClasses))?implode(' ',$extraClasses):''); ?> rounded overflow-hidden position-relative text-white <?php if(isset($mb)): ?> <?php echo e($mb); ?> <?php else: ?> mb-g <?php endif; ?> <?php if($value > 99999999 && $value < 1000000000): ?> pb-1 pt-2 <?php endif; ?> <?php if($value > 999999999): ?> pb-1 pt-3 <?php endif; ?>">
    <div class="">
        <h3 class="display-4 d-block l-h-n m-0 fw-900" <?php if($value > 99999999 && $value < 1000000000): ?> style="font-size:2.5em;" <?php endif; ?> <?php if($value > 999999999): ?> style="font-size:2.1em;" <?php endif; ?>>
            <?php echo e(number_format($value,1,',','.')); ?>

            <span class="fs-nano">
                    <?php echo e($measure); ?>

                </span>
            <small class="m-0 l-h-n fw-700"><?php echo e($title); ?></small>
        </h3>
    </div>
</div>

<?php /**PATH /shared/httpd/erm/resources/views/test/electric/components/data-box.blade.php ENDPATH**/ ?>