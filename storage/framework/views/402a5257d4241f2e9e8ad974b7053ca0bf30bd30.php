<script>
    function getDefaultChart(){
        let date = $('#date').val();
        let sensors  = $('.sensors').serialize();

        $.getJSON('/getDataForChart/<?php echo e($device_id); ?>/<?php echo e($sensor_id); ?>?date='+date+'&'+sensors, function (data) {
            var options = {
                chart: {
                    renderTo: 'chartDataContainer',
                    type: 'line',
                    zoomType: 'x'
                },
                boost: {
                    useGPUTranslations: true
                },
                colors : ['#0a6ebd'],
                title: {
                    text:  '<?php echo e($device->name); ?> <?php echo e($sensor->name); ?> '+data.title
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
                },
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
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br/>',
                    pointFormat: '{point.y} '+data.unit+'<br> {point.name}',
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
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/chart/charts/default.blade.php ENDPATH**/ ?>