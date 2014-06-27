#!/usr/local/bin/php
<?php
while(1){
    $pid = getmypid();
    $msg = $pid." | ".date("h:i:s")."\n";
    echo $msg;
    file_put_contents("/tmp/pt_service.log",$msg,FILE_APPEND);
    sleep(1);    
}
