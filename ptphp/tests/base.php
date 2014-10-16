<?php
/**
 * Created by PhpStorm.
 * User: joseph
 * Date: 10/16/14
 * Time: 1:06 PM
 *
 *  php bin/test.php tests/base.php test_method
 *  php bin/test.php tests/base.php TestClass:test_function
 */

function test_method(){
    echo "test";
}

class TestClass{
    function test_function(){
        echo "Test:test";
    }
}