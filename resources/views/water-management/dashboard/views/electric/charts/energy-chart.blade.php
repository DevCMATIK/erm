<script>
    function getEnergyChartContainer(date){
        var sensors  = $('.energy-sensors').serialize();

        $.getJSON('/getEnergyChart/{{ $subZone->id }}?date='+date+'&sensors='+sensors, function (data) {
            var options = {
                chart: {
                    renderTo: 'energy-chart-container',
                    zoomType: 'x',
                    height: $('#energy-values-container').height() ,
                    animation : false
                },

                boost: {
                    useGPUTranslations: true
                },
                legend : {
                    enabled : true,
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 50,
                    floating: true
                },
                title: {
                    text:  data.title
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
                        dataLabels: {
                            enabled: false,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        },
                        pointWidth: data.pointWidth,
                        animation : false
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y} '+data.unit+'<br>',
                    shared: true
                },

                credits: {
                    enabled: false
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            symbolStroke: '#0960a5'
                        }
                    }
                },
                series : data.series
            };
            var chartData = new Highcharts.Chart(options);

        });
    }
</script>
