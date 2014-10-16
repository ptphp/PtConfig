<?php
define("PATH_PRO",dirname(__DIR__));
include PATH_PRO."/app/bootstrap.php";

#print_r($urls);
gen_handler($urls);