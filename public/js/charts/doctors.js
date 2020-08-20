const chart = Highcharts.chart('container', {

    chart: {
        type: 'column'
    },
    title: {
        text: 'Médicos más activos'
    },
    xAxis: {
        categories: [],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Citas atendidas'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: []
});

let $start, $end;

function fetchData() {

    const startDate = $startDate.val();
    const endDate = $endDate.val();

    // Fetch Api
    const url = `/charts/doctors/column/data?startDate=${startDate}&endDate=${endDate}`;

    fetch(url)
        .then(function(response) {
            return response.json();
        }).then(function(data) {

            console.log(data.series);
            chart.xAxis[0].setCategories(data.categories);
            if (chart.series.length > 0) {
                chart.series[1].remove();
                chart.series[0].remove();
            }

            chart.addSeries(data.series[0]); //Atendida
            chart.addSeries(data.series[1]); //Cancelada

        });
}

// llamamos a fetchData una vez que ha cargado la página
$(function() {
    $startDate = $('#startDate');
    $endDate = $('#endDate');

    fetchData();

    $startDate.change(fetchData);
    $endDate.change(fetchData);

});