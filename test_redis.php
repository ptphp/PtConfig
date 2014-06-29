<?php
$sep = ",";
$end_line = "\n";
$methods = "PING|SET|GET|INCR|LPUSH|LPOP|SADD|SPOP";
$methods_list = explode("|",$methods);
define(RE_RPS,"/(".$methods."): ([.\d]+) requests per second/");
$datas = array(100,200,500,1000,1500,5000);
$clients = array(10,100,500,1000);
$requests = array(100);
$redis_port="6379";
$redis_host = "127.0.0.1";
$tips = "with_aof";

foreach($requests as $request){
    $res = "";
    foreach($clients as $client){
        $res .= ben_by_client($datas,$client,$request);
    }
    $file_name = "by_client_{$redis_host}_{$redis_port}_requests_{$request}";

    if($tips){
        $file_name .="_".$tips;
    }

    file_put_contents($file_name .".csv",$res);
}
foreach($requests as $request){
    $res = "";
    foreach($datas as $data){
        $res .= ben_by_data($clients,$data,$request);
    }
    $file_name = "by_data_{$redis_host}_{$redis_port}_requests_{$request}";

    if($tips){
        $file_name .="_".$tips;
    }

    file_put_contents($file_name .".csv",$res);
}

function ben_by_client($datas,$clent = 10,$requests = 50){
    global $redis_host;
    global $redis_port;
    global $tips;
    $res = array();
    $_cmd = "redis-benchmark -q -h $redis_host -p $redis_port -c $clent -n $requests -d ";
    foreach($datas as $data){
        $cmd = $_cmd ." $data";
        echo $cmd.PHP_EOL;
        $content = shell_exec($cmd);
        echo $content;
        preg_match_all(RE_RPS,$content,$match,PREG_SET_ORDER);
        foreach($match as $row){
            $method = $row[1];
            $value =  $row[2];
            $res[$method][] = $value;
        }
    }

    global $sep;
    global $end_line;
    $csv = "Client:{$clent}\n";
    $csv .= $_cmd."\n";
    $csv .= $sep.implode($sep,$datas).$end_line;
    foreach($res as $key=>$v){
        $csv .=  $key.$sep.implode($sep,$v).$end_line;
    }
    return $csv."\n\n";

}

function ben_by_data($clients,$data = 10,$requests = 50){
    global $redis_host;
    global $redis_port;
    global $tips;
    $res = array();
    $_cmd = "redis-benchmark -q -h $redis_host -p $redis_port -d $data -n $requests -c ";
    foreach($clients as $client){
        $cmd = $_cmd ." $client";
        echo $cmd.PHP_EOL;
        $content = shell_exec($cmd);
        echo $content;
        preg_match_all(RE_RPS,$content,$match,PREG_SET_ORDER);
        foreach($match as $row){
            $method = $row[1];
            $value =  $row[2];
            $res[$method][] = $value;
        }
    }

    global $sep;
    global $end_line;
    $csv = "Data:{$data}\n";
    $csv .= $_cmd."\n";
    $csv .= $sep.implode($sep,$clients).$end_line;
    foreach($res as $key=>$v){
        $csv .=  $key.$sep.implode($sep,$v).$end_line;
    }

    return $csv."\n\n";
}






