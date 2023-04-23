<?php

    //$routesArr = $_GET['url'];
    $routesArr = explode('/', $_SERVER['REQUEST_URI']);
    $routesArr = array_filter($routesArr);
    //dep($routesArr);
    
    //no peticiones
    if(empty($routesArr[2])){
        $json = [
            'status' => 404,
            'result' => 'Not Found'
        ];

        echo json_encode($json, http_response_code($json['status']));
        return; 
    }

    //con peticiones
    if($routesArr[2]!='' && isset($_SERVER['REQUEST_METHOD'])){
        $table= explode('?', $routesArr[2])[0];
        //peticion GET
        if($_SERVER['REQUEST_METHOD']== 'GET'){
            include('services/get.php');
        }

        //peticion POST
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            include('services/post.php');
        }

        //peticion PUT
        if($_SERVER['REQUEST_METHOD']== 'PUT'){
            include('services/put.php');
        }

        //peticion DELETE
        if($_SERVER['REQUEST_METHOD']== 'DELETE'){
            include('services/delete.php');
        }
    }