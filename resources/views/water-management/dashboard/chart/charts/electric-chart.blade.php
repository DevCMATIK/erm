<script>
    function getDefaultChart(){
        let date = $('#date').val();
        var sensors  = $('.sensors_').serialize();

        $.getJSON('/getDataForChartElectric?date='+date+'&'+sensors, function (data) {
            var options = {
                chart: {
                    renderTo: 'chartDataContainer',
                    zoomType: 'x'
                },

                boost: {
                    useGPUTranslations: true
                },
                title: {
                    text:  '{{ $device->check_point->name }}'
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
                        stacking: 'normal',
                        dataLabels: {
                            enabled: false,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                        },
                        pointWidth: 30
                    }
                },
                tooltip: {
                    shared:true
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
