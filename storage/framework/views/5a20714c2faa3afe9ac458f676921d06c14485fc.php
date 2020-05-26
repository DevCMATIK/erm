<div class="modal fade js-modal-messenger" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-left modal-sm">
        <div class="modal-content h-100">
            <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                <h4 class="text-white">Puntos de Control</h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body  h-100  p-4">
                <div class="row">
                    <div class="col">
                        <ul class="list-group w-100 rounded-0" >
                            <?php $__currentLoopData = $subZone->sub_elements->groupBy(function($q){
                           return $q->check_point_id;
                       }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if($sub->first()->check_point_id == $check_point): ?>
                                    <a class=" cursor-pointer list-group-item active text-white my-1"  href="/dashboard/detail/<?php echo e($sub->first()->check_point->id); ?>"  ><?php echo e($sub->first()->check_point->name); ?></a>
                                <?php else: ?>
                                    <a class="cursor-pointer list-group-item my-1 text-dark"   href="/dashboard/detail/<?php echo e($sub->first()->check_point->id); ?>"  ><?php echo e($sub->first()->check_point->name); ?></a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade js-modal-kpi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right modal-md">
        <div class="modal-content h-100">
            <div class="dropdown-header bg-primary d-flex align-items-center w-100 py-3">
                <h4 class="text-white">KPI</h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body  h-100  p-4">

              <div class="row">
                  <div class="col-12"><h6 class="border-bottom font-weight-bolder pb-2">Caudal</h6></div>
                  <div class="col-4">

                      <div class="js-easy-pie-chart color-info-900 mt-1 position-relative d-inline-flex align-items-center justify-content-center" data-percent="79" data-piesize="80" data-linewidth="10" data-linecap="butt">
                          <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-lg">
                              <div class="position-absolute pos-top pos-left pos-right pos-bottom d-flex align-items-center justify-content-center fw-500 fs-xl text-dark">78%</div>
                          </div>
                      </div>
                      <p class="label text-center">FU</p>
                  </div>
                  <div class="col-8">
                      <div class="ml-auto d-inline-flex align-items-center">
                          <div class="d-inline-flex flex-column small ml-2">
                              <span class="label">Hoy</span>
                              <span class="d-inline-block badge badge-info text-left p-1 px-3 width-10 fs-md font-weight-bold">12 <small>l/s</small></span>
                              <span class="label mt-2">Ayer</span>
                              <span class="d-inline-block badge badge-info text-left p-1 px-3 width-10 fs-md font-weight-bold">12 <small>l/s</small></span>
                          </div>
                          <div class="d-inline-flex flex-column small ml-4">
                              <span class="label">Semana Pasada</span>
                              <span class="d-inline-block badge badge-info text-left p-1 px-3 width-10 fs-md font-weight-bold">12 <small>l/s</small></span>
                              <span class="label mt-2">Mes Pasado</span>
                              <span class="d-inline-block badge badge-info text-left p-1 px-3 width-10 fs-md font-weight-bold">12 <small>l/s</small></span>
                          </div>
                      </div>
                  </div>
              </div>

                <div class="row mt-3">
                    <div class="col-12"><h6 class="border-bottom font-weight-bolder pb-2">Aportes (m<sup>3</sup>)</h6></div>
                    <div class="col-4">

                        <p class="text-primary font-weight-bolder text-center fs-xxl mt-3">500K</p>
                        <p class="label text-center mt-n1">Aporte Total</p>
                    </div>
                    <div class="col-8">
                        <div class="ml-auto d-inline-flex align-items-center">
                            <div class="d-inline-flex flex-column small ml-2">
                                <span class="label">Hoy</span>
                                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold">122 </span>
                                <span class="label mt-2">Ayer</span>
                                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold">122 </span>
                            </div>
                            <div class="d-inline-flex flex-column small ml-4">
                                <span class="label">Semana Pasada</span>
                                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold">122 </span>
                                <span class="label mt-2">Mes Pasado</span>
                                <span class="d-inline-block badge badge-info text-center p-1 px-3 width-10 fs-md font-weight-bold">1223</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/partials/navigation.blade.php ENDPATH**/ ?>