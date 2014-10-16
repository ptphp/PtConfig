<?php
/**
 * Created by PhpStorm.
 * User: joseph
 * Date: 10/16/14
 * Time: 11:59 AM
 */

function parse_router_request(){
    $__R__ = isset($_GET['__R__'])?$_GET['__R__']:"/";
    return $__R__;
}

function check_is_view_handerl($router_file){
    return strpos($router_file,"view/") === 0;
}
function get_handler_class($handler_file){
    $t = str_replace(".php","",$handler_file);
    $tt = explode("/",$t);
    $handler_class = "";
    foreach($tt as $i){
        $handler_class .= "_".ucfirst($i);
    }
    return substr($handler_class,1);
}

function get_handler_method(){
    if(isset($_SERVER["REQUEST_METHOD"])){
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }else{
        return "get";
    }
}
function parse_router($router_request){
    global $urls;
    if(!array_key_exists($router_request,$urls)){
        $handler_file  = "";
        $handler_class = "";
        $is_view = 1;
    }else{
        $handler_file  = $urls[$router_request];
        $is_view = check_is_view_handerl($handler_file);
        if($is_view){
            $handler_class = "";
        }else{
            $handler_class = get_handler_class($handler_file);
        }

    }
    return  array(
        "handler_method"  => get_handler_method(),
        "handler_class"   => $handler_class,
        "handler_path"    => $handler_file,
        "router"          => $router_request,
        "view"            => $is_view,
    );
}

function get_handler_content($handler_class){
    return <<<handler
<?php

class $handler_class{
    function get(){
        echo "$handler_class";
    }
    function post(){

    }
}
handler;

}
function gen_handler($urls){
    foreach($urls as $router_request => $handler){
        $handler_file = PATH_APP."/".$handler;
        if(!file_exists($handler_file)){
            shell_exec("mkdir -p ".dirname($handler_file));
            shell_exec("touch  ".$handler_file);
            echo $handler_file.PHP_EOL;
            if(!check_is_view_handerl($handler)){
                $content = get_handler_content(get_handler_class($handler));
            }else{
                $content = $handler;
            }
            file_put_contents($handler_file,$content);
        }
    }

}