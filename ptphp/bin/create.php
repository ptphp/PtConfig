<?php
/**
 * Created by PhpStorm.
 * User: joseph
 * Date: 10/16/14
 * Time: 10:12 AM
 */


$dirs = array(
    "bin",
    "etc",
    "app",
    "app/config",
    "webroot",
    "data",
    "tests"
);

$files = array(
    "webroot/index.php",
    "app/config/setting.php",
    "app/config/url.php",
    "etc/nginx_develop.conf",
    "etc/nginx_product.conf",
    "fabfile.py"
);
$root = dirname(__DIR__)."";
$url_prefix = "https://raw.githubusercontent.com/ptphp/PtConfig/master/ptphp";

function _mkdir($path){
    shell_exec("mkdir -p ".$path);
}
function create_file($file){
    global $root,$url_prefix;
    if(!file_exists($root."/".$file)){
        _mkdir(dirname($root."/".$file));
        shell_exec("wget ".$url_prefix.'/'.$file." -O ".$root."/".$file);
    }
}
function create_files(){
    global $files;
    foreach($files as $file){
        create_file($file);
    }
}
function create_dirs(){
    global $dirs,$root;

    foreach($dirs as $dir){
        $path = $root."/".$dir;
        echo $path.PHP_EOL;
        _mkdir($path);
    }
}

function create_pro(){
    create_dirs();
    create_files();
}

create_pro();