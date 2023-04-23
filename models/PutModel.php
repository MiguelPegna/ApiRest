<?php

    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';

    class PutModel extends Mysql{
        //peticion put para editar registros de tablas
        public function updatePutData($table, $data, $id, $nameId){
            //validar la existencia del registro a actualizar verificando id
            $query="SELECT $nameId FROM $table WHERE $nameId=$id";
            $idFind= $this->select($query);         
            if(empty($idFind)){
                return null;
            }
            
            $set='';
            foreach($data as $key => $value){
                $set .= $key. '= :'. $key. ',';
            }
            $set = substr($set, 0, -1);

            $sql="UPDATE $table SET $set WHERE $nameId = :$nameId;";
            $request = $this->update($sql, $data, $id, $nameId);
            return $request;
        }

    }//end class
