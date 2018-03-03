<?php
//CHALLENGE 4 - background script
//to be ran as script every 10 seconds
//bash example: while true ; do php -f background.php & sleep 10; done

/**
 * save the returned json into the db
 * @todo: error reporting
 */
$id = 166913;//Llanberis Hydro
$redis = new Redis();
$redis->connect('localhost');

$single_site_data_url = sprintf('http://emoncms.org/feed/aget.json?id=%s',$id);//create url based on location id
$returned = file_get_contents($single_site_data_url);//get the json from the emoncms feed
$json_a = json_decode($returned, true);//save the returned json into array
$timestamp = strtotime($json_a['time']);//use time in feed as redis index (epoc)
$hashKey = implode(':',array('sites',$id,$timestamp));//create the key used in the hash eg: sites:166913:1520032933
$success = $redis->hMSet($hashKey, $json_a);//save the json response data (now an array) as a hash value
$redis->zAdd($id, $timestamp, $hashKey);//save secondary index with the newly created hash's index as the value. timestamp as score 

//display something if watching output
echo $success ? "Saved @$timestamp" : "Not Saved @$timestamp";
$redis->close();