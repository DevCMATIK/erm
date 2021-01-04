<script>
    function getStreamChartContainer(){
        let date = $('#date').val();
        var type = $('#stream-options').val();
        if(type === 'average') {
            var sensor = $('#ss').val();
        } else {
            var sensor = $('#stream-sensors').val();
        }
        $.getJSON('/getStreamChart?sensors='+sensor+'&date='+date+'&type='+type, function (data) {
            var options = {
                chart: {
                    renderTo: 'stream-chart-container',
                    zoomType: 'x',
                    height: $('#stream-values-container').height() ,
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
                    y: 20,
                    floating: true
                },
                title: {
                    text:  'Corriente'
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
                    spline : {
                        animation : false
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: {point.y} '+data.unit+'<br>',
                    shared: true,
                    valueDecimals: 2,
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
            var chartData2 = new Highcharts.Chart(options);

        });
    }
</script>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/electric/charts/stream-chart.blade.php ENDPATH**/ ?>