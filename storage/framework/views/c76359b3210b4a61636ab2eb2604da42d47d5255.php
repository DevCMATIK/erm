<script>
    function getAveragesChart(){
        let date = $('#date').val();
        $.getJSON('/getDataForChartAverage/<?php echo e($device_id); ?>/<?php echo e($sensor_id); ?>?date='+date, function (data) {
            var options2 = {
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
                exporting: {
                    buttons: {
                        contextButton: {
                            symbolStroke: '#0960a5'
                        }
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
                    shared: false
                },

                credits: {
                    enabled: false
                },
                series : data.series
            };
            var chartData2 = new Highcharts.Chart(options2);

        });
    }

</script>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/dashboard/chart/charts/averages.blade.php ENDPATH**/ ?>