<?php

require_once 'Config.class.php';

$config = new Config();

$config->root_path = dirname(__FILE__);
$config->server_name = 'localhost';
$config->server_url = 'http://'.$config->server_name;
$config->app_root = '/Projekt-5';
$config->app_url = $config->server_url.$config->app_root;
$config->action_root = $config->app_root.'/app/ctrl.php?action=';
$config->action_url = $config->server_url.$config->action_root;
//& jest wskaźnikiem na zmienną
/*function out(&$param){
    if(isset($param)){
        echo $param;
    }
}*/
?>