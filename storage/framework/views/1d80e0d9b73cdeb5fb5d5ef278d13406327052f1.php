<header class="page-header bg-info-900" role="banner">


    <!-- DOC: nav menu layout change shortcut -->
    <div class="pt-2 ">
        <span class="page-logo-link ml-2 text-white fs-xl font-weight-bolder"><?php echo e(config('app.name')); ?> <small>®</small></span> <br>

        <p class="page-logo-text text-white fs-sm">Efficient Resource Management</p>
    </div>
    <!-- DOC: mobile button appears during mobile width -->
    <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center mx-auto">
        <img src="<?php echo e(asset('images/logo-white.png')); ?>" alt="Cmatik" aria-roledescription="logo" style="height: 50px !important; margin-top: 5px;">
    </a>

    <div class="ml-auto d-flex">

        <div>
            <a href="#" data-toggle="dropdown" title="<?php echo e(Sentinel::getUser()->email); ?>" class="header-icon d-flex align-items-center justify-content-center ml-2">
                <img src="<?php if($avatar = \App\Domain\System\File\File::findByTableAndId('users',Sentinel::getUser()->id)): ?> <?php echo e(Storage::url($avatar->getFullPath())); ?> <?php else: ?> <?php echo e(asset('images/user.png')); ?> <?php endif; ?>" class="profile-image rounded-circle" alt="<?php echo e(Sentinel::getUser()->full_name); ?>">
                <!-- you can also add username next to the avatar with the codes below:
				<span class="ml-1 mr-1 text-truncate text-truncate-header hidden-xs-down">Me</span>
				<i class="ni ni-chevron-down hidden-xs-down"></i> -->
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                    <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                                            <span class="mr-2">
                                                <img src="<?php if($avatar = \App\Domain\System\File\File::findByTableAndId('users',Sentinel::getUser()->id)): ?> <?php echo e(Storage::url($avatar->getFullPath())); ?> <?php else: ?> <?php echo e(asset('images/user.png')); ?> <?php endif; ?>" class="rounded-circle profile-image" alt="Dr. Codex Lantern">
                                            </span>
                        <div class="info-card-text">
                            <div class="fs-lg text-truncate text-truncate-lg"><?php echo e(Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name); ?></div>
                            <span class="text-truncate text-truncate-md opacity-80"><?php echo e(Sentinel::getUser()->email); ?></span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider m-0"></div>

                <div class="dropdown-divider m-0"></div>
                <a href="#" class="dropdown-item" data-action="app-fullscreen">
                    <span data-i18n="drpdwn.fullscreen">Pantalla Completa</span>
                    <i class="float-right text-muted fw-n">F11</i>
                </a>
                <a href="#" class="dropdown-item" data-action="app-print">
                    <span data-i18n="drpdwn.print">Imprimir Pantalla</span>
                    <i class="float-right text-muted fw-n">Ctrl + P</i>
                </a>
                <a href="<?php echo e(route('userSettings.index')); ?>" class="dropdown-item">
                    <span data-i18n="drpdwn.print">Opciones de cuenta</span>
                </a>
                <div class="dropdown-divider m-0"></div>
                <a class="dropdown-item fw-500 pt-3 pb-3" href="/logout">
                    <span data-i18n="drpdwn.page-logout">Logout</span>
                    <span class="float-right fw-n">&commat;</span>
                </a>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /shared/httpd/erm/resources/views/layouts/sections/header-blank.blade.php ENDPATH**/ ?>