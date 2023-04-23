<?php 

    class Mysql extends DB_conection{
        public $conexion;
        public $strQuery;
        public $arrVal;

        function __construct(){
            $this->conexion = new DB_conection();
            $this->conexion = $this->conexion->conectar();
        }

        public function verifyTable($table, array $columns){
            $database = DB_NAME;
            //validar existencia de tablas
            $verify = $this->conexion->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name='$table'")->fetchall(PDO::FETCH_OBJ);
            if(empty($verify)){
                return null;
            }
            else{
                //validar solicitud de columnas totales *
                //if($columns[0]=='*'){
                if($columns==null){
                    array_shift($columns); //quitar el primer elemento del arreglo [0]

                }
                //validar existencia de columnas en la tabla
                $sum=0;
                foreach($verify as $key => $value){
                    $sum += in_array($value->item, $columns);
                }
                return $sum == count($columns) ? $verify : null;
            }
        }

        //Consultas para el proyecto
        //insertar un registro
        public function insert(string $query, array $valuesArr){
            $this->strQuery = $query;
            $this->arrVal = $valuesArr;
            $insert = $this->conexion->prepare($this->strQuery);
            foreach($this->arrVal as $key => $value){
                if($key >0){
                    $insert->bindParam(":".$key, $this->arrVal[$key], PDO::PARAM_STR);
                }
            }
            try{
                $resInsert = $insert->execute($this->arrVal);
                if($resInsert){
                    $lastInsert = $this->conexion->lastInsertId();
                }
                else{
                    $lastInsert =0;
                }
            }catch(PDOException $e){
                return null;
            }
            return $lastInsert;
        }

        //Buscar un registro
        public function select(string $query){
            $this->strQuery = $query;
            $result = $this->conexion->prepare($this->strQuery);
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        //devuelve todos los registros
        public function select_all(string $query){
            $this->strQuery = $query;
            $result = $this->conexion->prepare($this->strQuery);
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;

        }

        //devuelve todos los registros con enlace con parametros--Consulta API
        public function select_filter(string $query, array $linkToArr, array $equalToArr){
            $this->strQuery = $query;
            $result = $this->conexion->prepare($this->strQuery);
            foreach($linkToArr as $key => $value){
                $result->bindParam(":".$value, $equalToArr[$key], PDO::PARAM_STR);
            }
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }

        //devuelve todos los registros haciendo busqueda con parametros--Consulta API
        public function select_filter_search(string $query, array $linkToArr, array $searchArr){
            $this->strQuery = $query;
            $result = $this->conexion->prepare($this->strQuery);
            foreach($linkToArr as $key => $value){
                if($key >0){
                    $result->bindParam(":".$value, $searchArr[$key], PDO::PARAM_STR);
                }
            }
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }

        //actualiza registros
        public function update(string $query, array $data, int $id, string $nameId){
            $this->strQuery = $query;
            $this->arrVal = $data;
            $update = $this->conexion->prepare($this->strQuery);
            foreach($this->arrVal as $key => $value){
                if($key >0){
                    $update->bindParam(":".$key, $this->arrVal[$key], PDO::PARAM_STR);
                }
            }
            $update->bindParam(":".$nameId, $id, PDO::PARAM_STR);
            try{
                $update->execute();
            }catch(PDOException $e){
                return 0;
            }
            return $id;
        }

        //guardar tokens para uso de api en DB
        public function tokensToDB(string $query){
            $this->strQuery = $query;
            $update = $this->conexion->prepare($this->strQuery);
            $resExecute = $update->execute();
            return $resExecute;
        }

        //eliminar registros
        public function delete(string $query, int $id, string $nameId){
            $this->strQuery = $query;
            $drop = $this->conexion->prepare($this->strQuery);
            $drop->bindParam(":".$nameId, $id, PDO::PARAM_STR);
            try{
                $drop->execute();
            }catch(PDOException $e){
                return null;
            }
            return $id;
        }

        //generar token de autentificacion
        public function jwt(int $id, string $email){
            //generar token
            $time = time();
            $token = [
                'iat' => $time,     //tiempo en que inicia el token
                'exp' => $time + 84600,   //segundos en un dia
                'data' => [
                    'id' => $id,
                    'email' => $email
                ]
            ];
            return $token;
        }
   }
?>