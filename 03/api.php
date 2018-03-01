<?php
$id = 166913;//Llanberis Hydro
$start = strtotime("-1 week")*1000;
$end = time()*1000;
$interval = 3600;

$chart_data_url = sprintf('https://emoncms.org/feed/data.json?id=%s&start=%s&end=%s&interval=%s',$id,$start,$end,$interval);
$single_site_data_url = sprintf('http://emoncms.org/feed/aget.json?id=%s',$id);

/**
 * return latest or data
 */
//routing (ish)
switch($_GET['q']){
    case 'history':
        echo file_get_contents($chart_data_url);
        break;
    case 'lastvalue':
        echo file_get_contents($single_site_data_url);
        break;
    default:
        echo json_encode(array('error'=>'No endpoint selected'));
}