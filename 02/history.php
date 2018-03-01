<?php
$id = 166913;//Llanberis Hydro
$start = strtotime("-1 week")*1000;
$end = time()*1000;
$interval = 3600;

$chart_data_url = sprintf('https://emoncms.org/feed/data.json?id=%s&start=%s&end=%s&interval=%s',$id,$start,$end,$interval);
$single_site_data_url = sprintf('http://emoncms.org/feed/aget.json?id=%s',$id);

$historical = file_get_contents($chart_data_url);
$latest = file_get_contents($single_site_data_url);

/**
 * return latest and data
 */
$array['data'] = json_decode($historical);
$array['latest'] = json_decode($latest);

echo json_encode($array, JSON_NUMERIC_CHECK);