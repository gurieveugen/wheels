<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

echo ini_get('disable_functions');


$args = array('test it');
echo mail('tatarinfamily@gmail.com,gurievcreative@gmail.com,gurievinvest@gmail.com', 'debug', print_r($args, true));
echo mail('gurievcreative@gmail.com', 'debug', print_r($args, true));
echo mail('gurievinvest@gmail.com', 'debug', print_r($args, true));

phpinfo();