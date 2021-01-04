<div <?php if(isset($name)): ?> onclick="downloadVarData('<?php echo e($name); ?>','<?php echo e($sensor_name ?? 'null'); ?>',<?php if($name == 'ee-e-activa' || $name == 'ee-e-reactiva' || $name == 'ee-e-aparente'): ?> 'consumption-date' <?php else: ?> 'date-filter' <?php endif; ?> <?php echo e(')'); ?>" <?php endif; ?> class=" cursor-pointer p-2 <?php echo e($bg ?? 'bg-primary-300'); ?> <?php echo e((isset($extraClasses))?implode(' ',$extraClasses):''); ?> rounded overflow-hidden position-relative text-white <?php if(isset($mb)): ?> <?php echo e($mb); ?> <?php else: ?> mb-g <?php endif; ?> <?php if($value > 99999999 && $value < 1000000000): ?> pb-1 pt-2 <?php endif; ?> <?php if($value > 999999999): ?> pb-1 pt-3 <?php endif; ?>">
    <div class="">
        <h3 class="display-4 d-block l-h-n m-0 fw-900" <?php if($value > 99999999 && $value < 1000000000): ?> style="font-size:2.5em;" <?php endif; ?> <?php if($value > 999999999): ?> style="font-size:2.1em;" <?php endif; ?>>
            <div class="data-box-value" style="margin: 0; float: left; margin-right:5px;">
                <?php if($value < 0): ?> # <?php else: ?> <?php echo e($value); ?> <?php endif; ?>
            </div>
            <span class="fs-nano">
                    <?php echo e($unit); ?>

                </span>
            <small class="m-0 l-h-n fw-700"><?php echo e($title); ?></small>
        </h3>
    </div>
</div>

<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/energy/components/data-box.blade.php ENDPATH**/ ?>