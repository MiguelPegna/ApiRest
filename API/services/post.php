<?php
    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';
    require_once '../controllers/PostController.php';

    if(isset($_POST)){
        $columns = array();
        $model = new Mysql();
        
        foreach(array_keys($_POST) as $key => $value){
            array_push($columns, $value);
        }
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

        //Peticion post para registrar usuarios
        if(isset($_GET['signup']) && $_GET['signup'] == true ){
            $suffix = $_GET['suffix'] ?? 'user';
            $register = new PostController();
            $register->newUserData($table, $_POST, $suffix);
        }
        //Peticion post para login de usuarios
        else  if(isset($_GET['login']) && $_GET['login'] == true ){
            $suffix = $_GET['suffix'] ?? 'user';          
            $register = new PostController();
            $register->loginUser($table, $_POST, $suffix);
        }
        else{
            //pedir respuesta al controlador si se cumple la existencia de tablas y columnas
            $response = new PostController();
            $response->postData($table, $_POST);
        }
    }