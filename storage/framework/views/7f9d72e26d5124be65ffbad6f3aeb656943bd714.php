<script>
    function getPowerChartContainer(){
        let date = $('#date').val();
        var sensors = $('#power-options').val();
        $.getJSON('/getPowerChart?&date='+date+'&sensors='+sensors, function (data) {
            var options = {
                chart: {
                    renderTo: 'power-chart-container',
                    zoomType: 'x',
                    height: $('#power-values-container').height() ,
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
            var chartData3 = new Highcharts.Chart(options);

        });
    }
</script>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/electric/charts/power-chart.blade.php ENDPATH**/ ?>