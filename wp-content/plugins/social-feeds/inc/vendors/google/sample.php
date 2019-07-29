<?php
require_once '../../config/bootstrap.php';
require_once 'googleapi.php';

$api = new GoogleApi($loader);
$ga_countries_data = $api->composeApi(array(
    'metrics'    => 'ga:visits',
    'dimensions' => 'ga:country'
));
$ga_source_data = $api->composeApi(array(
    'metrics'    => 'ga:visits',
    'dimensions' => 'ga:medium'
));
$ga_ref_data = $api->composeApi(array(
    'metrics'    => 'ga:visits',
    'dimensions' => 'ga:source,ga:medium',
    'filters' => 'ga:medium==referral',
    'sort'  => 'ga:visits',
    'max' => 24,
), false);
$ga_nvr_data = $api->composeApi(array(
    'metrics'    => 'ga:visits',
    'dimensions' => 'ga:visitorType'
));
?>
<html>
<head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
        google.load('visualization', '1', {'packages': ['geochart', 'corechart']});
        google.setOnLoadCallback(drawRegionsMap);
        google.setOnLoadCallback(drawPieChart);
        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ['Country', 'Visits'],
                <?=$ga_countries_data;?>
            ]);
            var options = {
                colors: ['white', '#b7aa73']
            };
            var chart = new google.visualization.GeoChart(document.getElementById('country_div'));
            chart.draw(data, options);
        };
        function drawPieChart(){
            var data = google.visualization.arrayToDataTable([
                ['Source', 'Visits'],
                <?=$ga_source_data;?>
            ]);
            var datareferral = google.visualization.arrayToDataTable([
                ['Source', 'Visits'],
                <?=$ga_ref_data;?>
            ]);
            var datanvr = google.visualization.arrayToDataTable([
                ['New Visitor', 'Returning Visitor'],
                <?=$ga_nvr_data;?>
            ]);
            var options = {
                pieHole: 0.4,
                legend: 'none',
                tooltipText: 'percentage',
                title: 'Traffic Sources'
            };
            var options1 = {
                pieHole: 0.4,
                legend: 'none',
                tooltipText: 'percentage',
                title: 'Referral'
            };
            var options2 = {
                is3D: true,
                legend: 'none',
                tooltipText: 'percentage',
                title: 'New vs. Returning'
            };
            var chart = new google.visualization.PieChart(document.getElementById('source_div'));
            chart.draw(data, options);
            var chart1 = new google.visualization.PieChart(document.getElementById('referral_div'));
            chart1.draw(datareferral, options1);
            var chart2 = new google.visualization.PieChart(document.getElementById('nvr_div'));
            chart2.draw(datanvr, options2);
        }
    </script>
</head>
<body>
<div id="country_div" style="width: 500px; height: 300px;"></div>
<div id="source_div" style="width: 500px; height: 300px;"></div>
<div id="referral_div" style="width: 500px; height: 300px;"></div>
<div id="nvr_div" style="width: 500px; height: 300px;"></div>
</body>
</html>