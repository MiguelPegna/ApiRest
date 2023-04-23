<?php
    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';
    require_once '../controllers/DeleteController.php';
    
    if(isset($_GET['id']) && isset($_GET['nameId'])){
        $id = $_GET['id'];
        $nameId = $_GET['nameId'];

        $columns = array($nameId);

        //validar campos del formulario con columnas en tabla
        $model = new Mysql();
        if(empty($model->verifyTable($table, $columns))){
            $json = [
                'status' => 400,
                'error' => 'Error: Fields in the form don\'t match or data aren\'t  correct type for columns in DB',
                'result' => 'Don\'t was possible added this data to DB (¯ ヘ ¯)'
            ];
            echo json_encode($json, http_response_code($json['status']));
            return;
        }
        //pedir respuesta al controlador si se cumple la existencia de tablas y columnas
        $response = new DeleteController();
        $response->deleteData($table, $id, $nameId);

    }