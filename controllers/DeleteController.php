<?php
    require_once '../models/DeleteModel.php';
    class DeleteController{

        //Peticion PUT para actualizar registros
        static public function deleteData($table, $id, $nameId){
            $model = new DeleteModel();
            $response = $model->dropData($table, $id, $nameId);

            $return = new DeleteController();
            $return->deleteResponse($response);
            return;

        }//end method
        
        //respuesta de controlador mandando el json al API/services/get.php      
        static public function deleteResponse($response){
            if(!empty($response)){
                $json = [
                    'status' => 200,
                    'idReg' => $response,
                    'msg' => 'Data deleted success of DB (◕‿◕)',
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