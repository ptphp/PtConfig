<?php
/**
 * Created by PhpStorm.
 * User: joseph
 * Date: 10/16/14
 * Time: 1:01 PM
 */

define("PATH_PRO",dirname(__DIR__));
include PATH_PRO."/app/bootstrap.php";

$argv = $_SERVER['argv'];
if(count($argv) <= 1 ){
    die("no test file found");
}
$test_file = $argv[1];

if(!file_exists(PATH_PRO."/".$test_file)){
    die(PATH_PRO."/".$test_file." ==> not exists");
}

if(count($argv) <= 2 ){
    die("no test method found");
}

$test_method = $argv[2];

include PATH_PRO."/".$test_file;

if(strpos($test_method,":") > 0){
    $t = explode(":",$test_method);
    $test_class = $t[0];
    $test_function = $t[1];
    $test_obj = new $test_class();
    $test_obj->$test_function();
}else{
    $test_method();
}

echo PHP_EOL;
