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
                    renderTo : 'chartContainer'
                },
                colors : ['#FF6600','#0070C1','#FFD237'],
                title: {
                    text: 'Consumo Energía (kWh)'
                },
                boost: {
                    useGPUTranslations: true
                },
                legend: {
                    enabled: true,
                    align: 'center',
                    verticalAlign: 'bottom',
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
                yAxis: data.yAxis,
                plotOptions: {
                    column: {
                        stacking: 'percent',
                        dataLabels: {
                            enabled: false,
                            color: false,
                            padding: 0,
                            style : {
                                textOutline : false
                            }
                        },
                        pointWidth: 20,
                        animation: false
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y:,.2f} kWh<br>',
                    shared: true
                },

                credits: {
                    enabled: false
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            symbolStroke: '#0960a5'
                        },
                    }
                },
                series: data.series
            };
            var stackedChart = new Highcharts.Chart(options);

        });
    }


</script>
