<?php
/**
 * Created by PhpStorm.
 * User: joseph
 * Date: 10/16/14
 * Time: 1:20 PM
 *
 */
function test_site(){
    echo file_get_contents("http://test.ptphp.net/");
}
function test_site1(){
    echo file_get_contents("http://test.ptphp.net/test");
}
function test_site11(){
    echo file_get_contents("http://test.ptphp.net");
    echo "\n";
    echo file_get_contents("http://test.ptphp.net/");
    echo "\n";
    echo file_get_contents("http://test.ptphp.net/test/dd/");
    echo "\n";
    echo file_get_contents("http://test.ptphp.net/test/dd/s");
}

function test_parse_router(){
    global $urls;
    $urls = array(
        "/"     => "view/default/index.php",
        "/test" => "handler/home/test.php"
    );
    $router = "/";
    $router_file = parse_router($router);
    var_dump($router_file);
    echo PHP_EOL;
    $router = "/test";
    $router_file = parse_router($router);
    var_dump($router_file);
    echo PHP_EOL;
    $router = "/test11";
    $router_file = parse_router($router);
    var_dump($router_file);
    echo PHP_EOL;
}

function test_check_is_view_handerl(){
    $router_file = "handler/home/test.php";
    $res = check_is_view_handerl($router_file);
    var_dump($res);
    $router_file = "view/default/test.php";
    $res = check_is_view_handerl($router_file);
    var_dump($res);
}

function test_gen_handler(){
    global $urls;
    $urls = array(
        "/test" => "handler/home/test.php",
        "/"     => "view/default/index.php"
    );
    gen_handler($urls);
}
function test_get_handler_content(){
    $handler_class = "Handler_Test";
    echo get_handler_content($handler_class);
}
function test_get_handler_class(){
    $handler_file = "handler/home/test.php";
    echo get_handler_class($handler_file);
}