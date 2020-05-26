@extends('components.modals.form-modal')
@section('modal-title','Modificar Reporte de email')
@section('modal-content')
    <form class="" role="form"  id="mail-report-form">
        @csrf
        @method('put')
        <div class="form-group">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $mailReport->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <select class="form-control" name="mail_id">
                @forelse($mails as $mail)
                    @if($mail->id == $mailReport->mail_id)
                        <option value="{{ $mail->id }}" selected>{{ $mail->name }}</option>
                    @else
                        <option value="{{ $mail->id }}">{{ $mail->name }}</option>
                    @endif

                @empty
                    <option value="" disabled="disabled">No hay disponibles</option>
                @endforelse
            </select>
        </div>

        <div class="accordion accordion-outline" id="js_demo_accordion-3">
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#js_demo_accordion-3a" aria-expanded="true">
                        Frecuencia de ejecucion
                        <span class="ml-auto">
                            <span class="collapsed-reveal">
                                <i class="fal fa-minus fs-xl"></i>
                            </span>
                            <span class="collapsed-hidden">
                                <i class="fal fa-plus fs-xl"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div id="js_demo_accordion-3a" class="collapse show" data-parent="#js_demo_accordion-3">
                    <div class="card-body">
                        <div class="alert alert-info">
                            Importante!, Algunas de las frequencias requieren parametros Adicionales, utilice el campo "ejecutar en" para indicar estos parametros,
                            El parametro requerido aparece en cada opcion.
                        </div>
                        <div class="form-group">
                            <label class="form-label">Frecuencia</label>
                            <select class="form-control" name="frequency">
                                @switch($mailReport->frequency)
                                    @case('hourly')
                                    <option value="hourly" selected>Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    @break
                                    @case('hourlyAt')
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt" selected>Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    @break
                                    @case('dailyAt')
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt" selected>Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    @break
                                    @case('weeklyOn')
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn" selected>Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn">Mensual [Dia,Hora, ej: '29,20']</option>
                                    @break
                                    @case('monthlyOn')
                                    <option value="hourly">Cada Hora</option>
                                    <option value="hourlyAt">Cada Hora [minutos, ej: 30]</option>
                                    <option value="dailyAt">Diaria [Hora, ej: '20']</option>
                                    <option value="weeklyOn">Semanal [Dia,Hora, ej: '1,14']</option>
                                    <option value="monthlyOn" selected>Mensual [Dia,Hora, ej: '29,20']</option>
                                    @break
                                @endswitch
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ejecutar En</label>
                            <input type="text" class="form-control" name="start_at" value="{{ $mailReport->start_at }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#js_demo_accordion-3b" aria-expanded="false">
                        Grupos
                        <span class="ml-auto">
                            <span class="collapsed-reveal">
                                <i class="fal fa-minus fs-xl"></i>
                            </span>
                            <span class="collapsed-hidden">
                                <i class="fal fa-plus fs-xl"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div id="js_demo_accordion-3b" class="collapse" data-parent="#js_demo_accordion-3">
                    <div class="card-body">
                        @forelse($groups as $group)
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="{{ $group->id }}" @if(\App\Domain\WaterManagement\Report\MailReportGroup::where('mail_report_id',$mailReport->id)->where('group_id',$group->id)->first()) checked @endif name="group_id[]">
                                <span class="custom-control-label">{{ $group->name }}</span>
                            </label>
                        @empty
                            No ha creado Grupos
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#js_demo_accordion-3c" aria-expanded="false">
                        Sensores
                        <span class="ml-auto">
                            <span class="collapsed-reveal">
                                <i class="fal fa-minus fs-xl"></i>
                            </span>
                            <span class="collapsed-hidden">
                                <i class="fal fa-plus fs-xl"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div id="js_demo_accordion-3c" class="collapse" data-parent="#js_demo_accordion-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <h5>Filtros Rapidos</h5>
                                <p>Sub Zonas</p>
                                <div id="js_list_accordion" class="accordion accordion-hover accordion-clean">
                                    @foreach($zones  as $zone)
                                        <div class="card my-0 border-top-left-radius-0 border-top-right-radius-0 p-0">
                                            <div class="card-header ">
                                                <a href="javascript:void(0);"
                                                   class="card-title collapsed"
                                                   data-toggle="collapse"
                                                   data-target="#zone_list_{{ $zone->id }}"
                                                   aria-expanded="false">
                                                    {{ $zone->name }}
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-chevron-up fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-chevron-down fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="zone_list_{{ $zone->id }}" class="collapse"  data-parent="#js_list_accordion">
                                                <div class="card-body p-0">
                                                    <ul class="list-group p-0">
                                                        @foreach($zone->sub_zones  as $sub_zone)
                                                            <li class="list-group-item cursor-pointer m-0 w-100 border-0" id="sub_zone_{{ $sub_zone->id }}" data-remote="true" id="parent_{{$zone->id}}">
                                                                <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input filter-sensor" value="{{ $sub_zone->id }}" name="sub_zone">
                                                                    <span class="custom-control-label">{{  $sub_zone->name }}</span>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>

                                <hr>
                                <p>Puntos de Control</p>
                                @foreach($checkPoints as $checkPoint)
                                    <div class="list-group-item check_points cursor-pointer" id="check_points_{{ $checkPoint->id }}">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox"  class="custom-control-input filter-sensor" value="{{ $checkPoint->id }}" name="check_point">
                                            <span class="custom-control-label">{{  $checkPoint->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-xl-4">
                                <p>Tipos de Sensor</p>
                                @foreach($sensor_types as $type)
                                    <div class="list-group-item sensor_type cursor-pointer" id="sensor_type_{{ $type->id }}">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox"  class="custom-control-input filter-sensor" value="{{ $type->id }}" name="sensor_type">
                                            <span class="custom-control-label">{{  $type->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                                <hr>
                                <p>Tipos de Registro</p>
                                @foreach($addresses as $address)
                                    <div class="list-group-item address_type cursor-pointer" id="address_{{ $address->id }}">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox"  class="custom-control-input filter-sensor" value="{{ $address->id }}" name="address">
                                            <span class="custom-control-label">{{  $address->name }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-xl-4" id="sensor-list">
                                <h5>Sensores seleccionados</h5>
                                @forelse($mailReport->sensors as $sensor)
                                    <div class="list-group-item py-1 px-2">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" checked class="custom-control-input" value="{{ $sensor->id }}" name="sensor_id[]">
                                            <span class="custom-control-label">{{ $sensor->device->sub_element->first()->element->sub_zone->name }} -
                                            {{ $sensor->device->name}} -
                                            {{ $sensor->full_address}}</span>
                                        </label>
                                    </div>
                                @empty
                                    <p>No ha seleccionado sensores</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <script>
        $(document).ready(function(){


            $('.filter-sensor').on('click',function(e){
                $.get('/report/filterSensors',{
                    types : getTypesSelected(),
                    address : getAddressSelected(),
                    sub_zones : getSubZonesSelected(),
                    check_points : getCheckPointsSelected(),
                    mail_report : {{ $mailReport->id }},
                },function(data){
                    $('#sensor-list').html(data)
                })
            });



            function getAddressSelected()
            {
                let address = [];
                $.each($("input[name='address']:checked"), function(){
                    address.push($(this).val());
                });

                if(address.length > 0) {
                    return address.join(',');
                } else {
                    return '';
                }
            }

            function getTypesSelected()
            {
                let types = [];
                $.each($("input[name='sensor_type']:checked"), function(){
                    types.push($(this).val());
                });

                if(types.length > 0) {
                    return types.join(',');
                } else {
                    return '';
                }
            }
            function getSubZonesSelected()
            {
                let types = [];
                $.each($("input[name='sub_zone']:checked"), function(){
                    types.push($(this).val());
                });

                if(types.length > 0) {
                    return types.join(',');
                } else {
                    return '';
                }
            }

            function getCheckPointsSelected()
            {
                let types = [];
                $.each($("input[name='check_point']:checked"), function(){
                    types.push($(this).val());
                });

                if(types.length > 0) {
                    return types.join(',');
                } else {
                    return '';
                }
            }
        });
    </script>
@endsection
@section('modal-validation')
    {!!  makeValidation('#mail-report-form','/mail-reports/'.$mailReport->id, "tableReload(); closeModal();") !!}
@endsection
