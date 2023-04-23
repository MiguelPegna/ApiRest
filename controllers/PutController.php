<?php
    require_once '../models/PutModel.php';
    class PutController{

        //Peticion PUT para actualizar registros
        static public function putData($table, $data, $id, $nameId){
            $model = new PutModel();
            $response = $model->updatePutData($table, $data, $id, $nameId);

            $return = new PutController();
            $return->putResponse($response);
            return;

        }//end method
        
        //respuesta de controlador mandando el json al API/services/get.php      
        static public function putResponse($response){
            if(!empty($response)){
                $json = [
                    'status' => 200,
                    'idReg' => $response,
                    'msg' => 'Data updated success in DB (◕‿◕)',
                    'method' => 'PUT'
                ];
            }
            else if($response ==0){
                $json = [
                    'status' => 400,
                    'msg' => 'Error: Column was\'t found or data aren\'t correct type for column in DB',
                    'method' => 'PUT'
                ];
                
            }  
            
            echo json_encode($json, http_response_code($json['status']));
        }//end method

    }//end class