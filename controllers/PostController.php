<?php
    require_once '../models/PostModel.php';
    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';

    class PostController{

        //Peticion POST para crear nuevos registros
        public static function postData($table, $data){
            $model = new PostModel();
            $response = $model->insertPostData($table, $data);
            $return = new PostController();
            $return->postResponse($response);
            //dep($response);return;

        }//end method
        
        public static function newUserData($table, $data, $suffix){
            if($data[$suffix.'_password'] && $data[$suffix.'_password']!=null){
                //se hashea el password para poder guardarlo en DB
                $passDB = password_hash($data[$suffix.'_password'], PASSWORD_DEFAULT);
                $data[$suffix.'_password']=$passDB;
                //envio de informacion para hacer registro de usuario
                $model = new PostModel();
                $response = $model->insertNewUser($table, $data, $suffix);
                $return = new PostController();
                $return->userResponse($response);
            }
            //registron con apps externas
            else{
                
            }

        }//end method

        public static function loginUser($table, $data, $suffix){
            //envio de informacion para hacer verificacion de datos
            $model = new PostModel();
            $response = $model->login($table, $data, $suffix);
            $return = new PostController();
            //return;
            $return->loginResponse($response);

        }//end method
        
        //respuesta de controlador mandando el json al API/services/get.php      
        static public function postResponse($response){
            if(!empty($response)){
                $json = [
                    'status' => 200,
                    'idReg' => $response,
                    'msg' => 'Data added success to DB (◕‿◕)',
                    'method' => 'POST'
                ];
            }
            else{
                $json = [
                    'status' => 400,
                    'msg' => $response,
                    'method' => 'POST'
                ];
                
            }             
            echo json_encode($json, http_response_code($json['status']));
        }//end method


        //respuesta al registro de usuarios
        static public function userResponse($response){
            if($response==0){  //0= registro de user no hecho
                $json = [
                    'status' => 400,
                    'msg' => 'Try with other email or do login',
                    'method' => 'POST'
                ];
            }
            else if($response==1){   //1 = registro de user hecho
                $json = [
                    'status' => 200,
                    'msg' => 'User registred with success now you can do login',
                    'method' => 'POST'
                ];
            }
            echo json_encode($json, http_response_code($json['status']));
        }//end method

        //respuesta al registro de usuarios
        static public function loginResponse($response){
            if($response==0){  //0= no se pudo iniciar sesion
                $json = [
                    'status' => 404,
                    'msg' => 'Error: Data no match with one registry in DB',
                    'method' => 'POST'
                ];
            }
            else if($response!=0){   //registro de user hecho //aqui se pondria las variables de session y permisos
                $json = [
                    'status' => 200,
                    'userData' => $response,  //Es un array con la infoDe usuario
                    'method' => 'POST'
                ];
            }
            echo json_encode($json, http_response_code($json['status']));
        }//end method

    }//end class