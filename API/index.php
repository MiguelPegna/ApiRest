<?php
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'D:/xampp/htdocs/ligaff/API/php_error_api_log');

    require_once('../config/config.php');
    require_once('../config/helpers.php');
    require_once('../controllers/RoutesController.php');
    $index = new RoutesController();
    $index->index();
