<script>
    function getTensionChartContainer(){
        let date = $('#date').val();

        var type = $('#tension-type').val();
        var options = $('#tension-options').val();
        if(options === 'average') {
            if(type === 'LL') {
                var sensor = $('#ll-avr').val();
            } else {
                if(type === 'LN') {
                    var sensor = $('#ln_avr').val();
                } else {
                    var sensor = $('#ll_avr').val();
                }
            }
        } else {
            if(type === 'LL') {
                var sensor = $('#ts').val();
            } else {
                if(type === 'LN') {
                    var sensor = $('#ts-ln').val();
                } else {
                    var sensor = $('#ts').val();
                }
            }
        }

        $.getJSON('/getTensionChart?sensors='+sensor+'&date='+date+'&type='+type+'&options='+options, function (data) {
            var options = {
                chart: {
                    renderTo: 'tension-chart-container',
                    zoomType: 'x',
                    height: $('#tension-values-container').height(),
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
            var chartData1 = new Highcharts.Chart(options);

        });
    }
</script>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/dashboard/views/electric/charts/tension-chart.blade.php ENDPATH**/ ?>