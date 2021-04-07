<script>
    Highcharts.setOptions({
        lang: {
            decimalPoint: ',',
            thousandsSep: '.'
        }
    });
    function renderChart()
    {
        $.getJSON('/zone-resume-chart/{{ $zone_id }}/data',getFilters(), function (data) {
            var options = {
                chart: {
                    type: 'column',
                    renderTo : 'chartContainer'
                },
                colors : ['#0a6ebd'],
                title: {
                    text: 'Consumo Energía (kWh)'
                },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        second: '%H:%M:%S',
                        minute: '%H:%M',
                        hour: '%H:%M',
                        day: '%Y<br/>%m-%d',
                        week: '%Y<br/>%m-%d',
                        month: '%Y-%m',
                        year: '%Y'
                    }
                },
                yAxis: {

                    min:0,
                    title: {
                        text: 'Energía Activa (kWh)'
                    },
                    stackLabels: {
                        enabled: false,
                        style: {
                            fontWeight: 'bold'
                        }
                    },
                    zIndex: 5
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: false,
                            color: false,
                            padding: 0,
                            style : {
                                textOutline : false
                            }
                        },
                        pointWidth: 30
                    }
                },
                tooltip: {
                    shared: true,
                    valueSuffix: ' kWh',
                },

                credits: {
                    enabled: false
                },
                series : data.series
            };
            var stackedChart = new Highcharts.Chart(options);

        });
    }


</script>
