@extends('components.modals.form-modal')
@section('modal-title','Configurar Punto de Control : '.$sub_element->check_point->name)
@section('modal-content')
    <div class="alert alert-info">
        Puede indicar si mostrar o no un control en el dashboard con el boton <i class="fas fa-eye"></i>, <br>
        el icono <i class="fas fa-chart-bar"></i> indica cual sera el valor a mostrar como Barra. (solo se puede seleccionar 1)
    </div>
    <div class="row">
        <div class="col-xl-5">
            <ul class="list-group" id="sensors">
                @forelse($sub_element->sensors as $sensor)

                   @if(isset($sensor->sensor))


                        <li class="list-group-item" id="item_{{ $sub_element->id }}_{{ $sensor->sensor_id }}">
                            {{ $sensor->sensor->full_address }} - {{ $sensor->sensor->name }}
                            <a href="javascript:void(0)" id="a_{{ $sub_element->id }}_{{ $sensor->sensor_id }}"  class="float-right sensor_show" ><i class="fas @if($sensor->show_in_dashboard == 1) fa-eye text-primary @else fa-eye-slash text-dark @endif"></i></a>
                            @if($sensor->sensor->address->configuration_type == 'scale')
                                <a href="javascript:void(0)" id="e_{{ $sub_element->id }}_{{ $sensor->sensor_id }}"  class="float-right use_as_chart mr-2" ><i class="fas fa-chart-bar chart_icon @if($sensor->use_as_chart == 1) text-primary @else text-dark @endif"></i></a>
                                <a href="javascript:void(0)" id="c_{{ $sub_element->id }}_{{ $sensor->sensor_id }}_{{  ($sensor->no_chart_needed == 1)?0:1 }}"   class="float-right no_chart_needed  mr-2" ><i class="fas fa-chart-line chart_icon_not_needed @if($sensor->no_chart_needed == 1) text-primary @else text-dark @endif" ></i></a>
                                <a href="javascript:void(0)" id="r_{{ $sub_element->id }}_{{ $sensor->sensor_id }}" onclick="showRanges({{ $sensor->sensor_id }});"  class="float-right  mr-2" ><i class="fas fa-sliders-v-square text-dark"></i></a>
                            @else
                                <a href="javascript:void(0)" id="d_{{ $sub_element->id }}_{{ $sensor->sensor_id }}"  class="float-right use_as_chart_digital mr-2" ><i class="fas fa-sort chart_icon_digital @if($sensor->use_as_digital_chart == 1) text-primary @else text-dark @endif"></i></a>
                                @if($sensor->sensor->address->register_type_id == 9)
                                    <a href="javascript:void(0)" id="o_{{ $sub_element->id }}_{{ $sensor->sensor_id }}_{{  ($sensor->is_not_an_output == 1)?0:1 }}"  class="float-right is_not_an_output mr-2" ><i class="fas fa-check-square chart_icon_digital_output @if($sensor->is_not_an_output == 1) text-primary @else text-dark @endif"></i></a>
                                @endif
                            @endif
                        </li>
                    @endif
                @empty
                    <li class="list-group-item-info">
                        No ha cargado sensores al dispositivo.
                    </li>
                @endforelse
            </ul>
        </div>
        <div class="col-xl-7 border" id="sensor-ranges">

        </div>
    </div>
    <script>
        function showRanges(sensor) {
            $.get('/sensorRanges/'+sensor, function(data){
                $('#sensor-ranges').html(data);
            });
        }

        $('.use_as_chart').click(function(){
            let $this = $(this);
            let $icon = $this.find('i');

            $('.chart_icon').removeClass('text-primary text-dark').addClass('text-dark');
            $icon.removeClass('text-dark').addClass('text-primary');
            $.ajax({
                url : '/useAsChart',
                data : {
                    element : $this.attr('id')
                }
            })
        });

        $('.use_as_chart_digital').click(function(){
            let $this = $(this);
            let $icon = $this.find('i');

            $('.chart_icon_digital').removeClass('text-primary text-dark').addClass('text-dark');
            $icon.removeClass('text-dark').addClass('text-primary');
            $.ajax({
                url : '/useAsChart/digital',
                data : {
                    element : $this.attr('id')
                },
                success : function(data) {
                    $('#sensor-ranges').html(data);
                }
            })
        });

        $('.is_not_an_output').click(function(){
            let $this = $(this);
            let $icon = $this.find('i');

            if($icon.hasClass('text-dark')) {
                $icon.removeClass('text-dark').addClass('text-primary');
            } else {
                $icon.removeClass('text-primary').addClass('text-dark');
            }

            $.ajax({
                url : '/isNotAnOutput',
                data : {
                    element : $this.attr('id')
                },
                success : function(data) {
                    $('#sensor-ranges').html(data);
                }
            })
        });

        $('.no_chart_needed').click(function(){
            let $this = $(this);
            let $icon = $this.find('i');

            if($icon.hasClass('text-dark')) {
                $icon.removeClass('text-dark').addClass('text-primary');
            } else {
                $icon.removeClass('text-primary').addClass('text-dark');
            }
            $.ajax({
                url : '/chartNotNeeded',
                data : {
                    element : $this.attr('id')
                },
                success : function(data) {
                    $('#sensor-ranges').html(data);
                }
            })
        });




        $('.sensor_show').click(function(){
                let $this = $(this);
                let $icon = $this.find('i');
                let show;
                if ($this.find('i').hasClass('fa-eye')) {
                    $icon.removeClass('fa-eye text-primary').addClass('fa-eye-slash text-dark');
                    show = 0;
                } else {
                    $icon.removeClass('fa-eye-slash text-dark').addClass('fa-eye text-primary');
                    show = 1;
                }
                $.ajax({
                    url : '/sensorShowInDashboard',
                    data : {
                        show : show,
                        element : $this.attr('id')
                    }
                })
            });

        $(function () {
            $("#sensors").sortable({
                update: function(event, ui,parent) {
                    var items = $(this).sortable('toArray').toString();
                    console.log(items);
                    console.log($(this).attr('id'));
                    $.ajax({
                        url : '/subElement/updateSensors',
                        data : {
                            items : items,
                            group : {{ $sub_element->id }}
                        },
                        success : function()
                        {
                            toastr.success('Sensores reordenados');
                        }
                    });
                }
            });
        });
    </script>
@endsection
@section('modal-validation')

@endsection
@section('no-submit')
    .
@endsection
