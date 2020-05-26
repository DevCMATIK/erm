<nav class="navbar navbar-expand-lg navbar-light bg-light mb-6">
    <a class="navbar-brand mr-2 text-primary" href="/<?php echo e($entity); ?>"><i class="fal fa-<?php echo $__env->yieldContent('page-icon'); ?>"></i> <?php echo $__env->yieldContent('page-title'); ?> </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Arbol Completo
                </a>
                <div class="dropdown-menu">
                <?php $__empty_1 = true; $__currentLoopData = $navBar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($item['childs']): ?>
                            <div class="dropdown-multilevel">
                                <div class="dropdown-item"><?php echo e($item['name']); ?></div>
                                <div class="dropdown-menu">
                                    <a href="<?php echo e($item['url']); ?>" class="dropdown-item"><?php echo e($item['alter']); ?></a>
                                    <?php $__currentLoopData = $item['childs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($child1['childs']): ?>
                                            <div class="dropdown-multilevel">
                                                <div class="dropdown-item"><?php echo e($child1['name']); ?></div>
                                                <div class="dropdown-menu">
                                                    <a href="<?php echo e($child1['url'] ?? '#'); ?>" class="dropdown-item"><?php echo e($child1['alter']); ?></a>
                                                    <?php $__currentLoopData = $child1['childs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($child2['childs']): ?>
                                                            <div class="dropdown-multilevel">
                                                                <div class="dropdown-item" class="dropdown-item"><?php echo e($child2['name']); ?></div>
                                                                <div class="dropdown-menu">
                                                                    <a href="<?php echo e($child2['url'] ?? '#'); ?>" class="dropdown-item"><?php echo e($child2['alter']); ?></a>
                                                                    <?php $__currentLoopData = $child2['childs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <a href="<?php echo e($child3['url'] ?? '#'); ?>" class="dropdown-item"><?php echo e($child3['name']); ?></a>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <a href="<?php echo e($child2['url'] ?? '#'); ?>" class="dropdown-item"><?php echo e($child2['name']); ?></a>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <a href="<?php echo e($child1['url'] ?? '#'); ?>" class="dropdown-item"><?php echo e($child1['name']); ?></a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e($item['url']); ?>" class="dropdown-item"><?php echo e($item['name']); ?></a>
                        <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    sin registros.
                <?php endif; ?>
                </div>
            </li>
        </ul>
        <div class="float-right">
            <?php if (! empty(trim($__env->yieldContent('page-buttons')))): ?>
                <?php echo $__env->yieldContent('page-buttons'); ?>
            <?php endif; ?>
            <?php echo makeAddLink(); ?>

        </div>
    </div>
</nav>
<?php /**PATH /shared/httpd/water-management/resources/views/layouts/partials/navs/page-navbar.blade.php ENDPATH**/ ?>