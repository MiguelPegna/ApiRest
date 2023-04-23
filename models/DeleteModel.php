<?php

    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';

    class DeleteModel extends Mysql{
        //peticion put para editar registros de tablas
        public function dropData($table, $id, $nameId){
            //validar la existencia del registro a actualizar verificando id
            $query="SELECT $nameId FROM $table WHERE $nameId=$id";
            $idFind= $this->select($query);         
            if(empty($idFind)){
                return null;
            }
            
            $sql="DELETE FROM $table WHERE $nameId = :$nameId;";
            $request = $this->delete($sql, $id, $nameId);
            return $request;
        }

    }//end class
