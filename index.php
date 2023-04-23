<?php
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'D:/xampp/htdocs/ligaff/php_error_log');

    require_once('config/config.php');
    require_once('config/helpers.php');

    $url = !empty($_GET['url']) ?  $_GET['url'] : 'home/home';
    $arrUrl = explode("/", $url);
    $controller = $arrUrl[0];
    $method = $arrUrl[0];
    $params = '';

    if(!empty($arrUrl[0]==='API')){
        header('location: API/index.php');
    }

    if(!empty($arrUrl[1])){
        if($arrUrl[1] != ''){
            $method = $arrUrl[1];
        }
    }

    if(!empty($arrUrl[2])){
        if($arrUrl[2] != ''){
            for($i=2; $i < count($arrUrl); $i++){
                $params.= $arrUrl[$i]. ',';
            }
            $params = trim($params. ',');
        }
    }

    require_once('core/autoload.php');
    require_once('core/load.php');