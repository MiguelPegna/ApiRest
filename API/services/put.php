<?php
    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';
    require_once '../controllers/PutController.php';
    
    if(isset($_GET['id']) && isset($_GET['nameId'])){
        $id = $_GET['id'];
        $nameId = $_GET['nameId'];
        //capturar datos del formulario y pasarlos a un array
        $data = array();
        parse_str(file_get_contents('php://input'), $data);
        
        //separa propiedades del array
        $columns = array();
        $model = new Mysql();
        foreach(array_keys($data) as $key => $value){
            array_push($columns, $value);
        }
        //array_push($columns, $nameId);
        //$columns = array_unique($columns);

        //validar campos del formulario con columnas en tabla
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
        $response = new PutController();
        $response->putData($table, $data, $id, $nameId);

    }