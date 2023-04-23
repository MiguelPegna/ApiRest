<?php
    require_once '../models/GetModel.php';
    class GetController{
        
        //metodo get sin where  --sin filtro
        public function getData($table, $select, $order, $mode, $start, $end){
            $model = new GetModel();
            $response = $model->selectData($table, $select, $order, $mode, $start, $end);
            $return = new GetController();
            $return->getResponse($response);
        }

        //metodo get con where  --con filtro
        public function getDataWhere($table, $select, $linkTo, $equalTo, $order, $mode, $start, $end){
            $model = new GetModel();
            $response = $model->selectDataWhere($table, $select, $linkTo, $equalTo, $order, $mode, $start, $end);
            $return = new GetController();
            $return->getResponse($response);

        }

        //metodo get con inner join sin where   --sin filtro
        public function getInnerJoinData($rel, $type, $select, $order, $mode, $start, $end){
            $model = new GetModel();
            $response = $model->selectInnerJoinData($rel, $type, $select, $order, $mode, $start, $end);
            $return = new GetController();
            $return->getResponse($response);
        }

        //metodo get con inner join con where   --con filtro
        public function getInnerJoinDataWhere($rel, $type, $select, $linkTo, $equalTo, $order, $mode, $start, $end){
            $model = new GetModel();
            $response = $model->selectInnerJoinDataWhere($rel, $type, $select, $linkTo, $equalTo, $order, $mode, $start, $end);
            $return = new GetController();
            $return->getResponse($response);
        }

        //metodo get para hacer busquedas sin inner join   --sin filtro
        public function getDataSearch($table, $select, $linkTo, $search, $order, $mode, $start, $end){
            $model = new GetModel();
            $response = $model->selectDataSearch($table, $select, $linkTo, $search, $order, $mode, $start, $end);
            $return = new GetController();
            $return->getResponse($response);
        }

        //metodo get para hacer busqueda con inner join   --con filtro
        public function getInnerJoinDataSearch($rel, $type, $select, $linkTo, $search, $order, $mode, $start, $end){
            $model = new GetModel();
            $response = $model->selectInnerJoinDataSearch($rel, $type, $select, $linkTo, $search, $order, $mode, $start, $end);
            $return = new GetController();
            $return->getResponse($response);
        }

        //metodo get seleccion de rangos    --sin filtro
        public function getDataRange($table, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo){
            $model = new GetModel();
            $response = $model->selectDataRange($table, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo);
            $return = new GetController();
            $return->getResponse($response);
        }

        //metodo get seleccion de rangos con inner join  --con filtro
        public function getInnerJoinDataRange($rel, $type, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo){
            $model = new GetModel();
            $response = $model->selectInnerJoinDataRange($rel, $type, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo);
            $return = new GetController();
            $return->getResponse($response);
        }



        //respuesta de controlador mandando el json al API/services/get.php      
        public function getResponse($response){
            if(!empty($response)){
                $json = [
                    'status' => 200,
                    'total' => count($response),
                    'result' => $response,
                    'method' =>'GET'
                ];
            }
            else{
                $json = [
                    'status' => 404,
                    'result' => 'Not Found',
                    'method' => 'GET'
                ];
                
            }  
            
            echo json_encode($json, http_response_code($json['status']));
        }

    }//end class