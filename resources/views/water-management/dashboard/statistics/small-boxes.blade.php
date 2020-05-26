<div class="row">
    <div class="col-sm-4 col-xl-4">
        <div class="p-3 bg-warning rounded overflow-hidden position-relative text-white mb-g cursor-pointer" @if(Sentinel::getUser()->inGroup('cmatik')) onClick="redirectToOfflineDevices()" @else onclick="redirectToOfflineDev()" @endif>
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                    <span id="online-devices"></span>
                    <small class="m-0 l-h-n">Puntos de Control Offline</small>
                </h3>
            </div>
            <i class="fas fa-power-off position-absolute pos-right pos-bottom opacity-15 mb-2 mr-1" style="font-size:5rem"></i>
        </div>
    </div>
    <div class="col-sm-4 col-xl-4">
        <div class="p-3 bg-danger rounded overflow-hidden position-relative text-white mb-g cursor-pointer" onclick="redirectToAlarms()">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                    <span id="alarms-on" ></span>
                    <small class="m-0 l-h-n">Alarmas Activas</small>
                </h3>
            </div>
            <i class="fas fa-exclamation-triangle position-absolute pos-right pos-bottom opacity-15 mb-2 mr-1" style="font-size:5rem"></i>
        </div>
    </div>

    <div class="col-sm-4 col-xl-4">
        <div class="p-3 bg-info rounded overflow-hidden position-relative text-white mb-g">
            <div class="">
                <h3 class="display-4 d-block l-h-n m-0 fw-500" >
                    <span id="last-update" class="fs-xxl"></span>
                    <small class="m-0 l-h-n">Ultima Actualizacion.</small>
                </h3>
            </div>
            <i class="fas fa-calendar position-absolute pos-right pos-bottom opacity-15 mb-2 mr-1" style="font-size:5rem"></i>
        </div>
    </div>
</div>


