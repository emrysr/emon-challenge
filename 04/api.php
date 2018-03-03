<?php
//CHALLENGE 4
header('Content-Type: application/json');
$id = 166913;//Llanberis Hydro
$start = strtotime("-1 week");
$end = time();

$redis = new Redis();
$redis->connect('localhost');

/**
 * return latest or data. else show error
 */
switch($_GET['q']){
    case 'history':
        $hashKeys = $redis->zRangeByScore($id, $start, $end);//get all the hash keys saved in the sorted set (timestamp is the score)
        foreach($hashKeys as $key){
            list($type, $site, $timestamp) = explode(':', $key);//get the timestamp from the hash key eg. sites:166913:1520032933
            $data[] = array($timestamp*1000, $redis->hGet($key, 'value'));//add the value and timestamp to the results set
        }
        echo json_encode($data, JSON_NUMERIC_CHECK);//output as json with numbers not quoted as strings
        break;
    case 'lastvalue':
        $hashKey = $redis->zRevRange($id, 0, 0);// get the last entry in the sorted set (location id is the sorted set's name)
        $data = $redis->hGetAll($hashKey[0]);//get all the keys and values for the hash
        echo json_encode($data);//display the whole hash as a json object
        break;
    default:
        echo json_encode(array('error'=>'No endpoint selected'));//show error if not properly requested
}

$redis->close();
