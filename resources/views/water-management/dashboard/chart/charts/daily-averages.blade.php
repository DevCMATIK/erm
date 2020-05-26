<script>
    function getDailyAveragesChart(){
        let date = $('#date').val();
        $.getJSON('/getDataForChartDailyAverage/{{ $device_id }}/{{ $sensor_id }}?date='+date, function (data) {
            var options3 = {
                chart: {
                    renderTo: 'chartDataContainer',
                    type: 'spline',
                    zoomType: 'x'
                },
                boost: {
                    useGPUTranslations: true
                },
                colors : ['#0a6ebd','#f1df46','#40f264'],
                title: {
                    text:  '{{ $device->name }} {{ $sensor->name }} '+data.title
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

                    title: {
                        text: data.unit
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color:'gray'
                        }
                    },
                    plotLines: data.plotLines,
                    min : data.min_value
                }
                ,
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: false,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        },
                        pointWidth: 30
                    }
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            symbolStroke: '#0960a5'
                        }
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y} '+data.unit+'<br>',
                    shared: true
                },

                credits: {
                    enabled: false
                },
                series : data.series
            };
            var chartData3 = new Highcharts.Chart(options3);

        });
    }

</script>
