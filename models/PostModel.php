<?php

    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';
    require_once '../controllers/PostController.php';

    require_once '../vendor/autoload.php';
    use Firebase\JWT\JWT;

    class PostModel extends Mysql{

        //peticion post para crear registro a tablas
        public function insertPostData($table, $data){
            $columns='';
            $params='';
            foreach($data as $key => $value){
                $columns .= $key. ',';
                $params .= ':'.$key. ',';
            }
            $columns = substr($columns, 0, -1);
            $params = substr($params, 0, -1);
            $sql="INSERT INTO $table($columns) VALUES($params)";
            $request = $this->insert($sql, $data);
            return $request;
            //dep($sql);return;
        }

        //peticion post para crear registro a tablas
        public function insertNewUser($table, $data, $suffix){
            //validar si el email no ha sido registrado a la DB
            $email = $data[$suffix.'_email'];
            $query="SELECT user_id FROM $table WHERE user_email = '$email';";            
            $idFind= $this->select($query);     
            
            //si la variable viene vacia se puede realizar el registro
            if(empty($idFind)){
                ///////
                $columns='';
                $params='';
                foreach($data as $key => $value){
                    $columns .= $key. ',';
                    $params .= ':'.$key. ',';
                }
                $columns = substr($columns, 0, -1);
                $params = substr($params, 0, -1);
                $sql="INSERT INTO $table($columns) VALUES($params)";
                $request = $this->insert($sql, $data);
                $request = 1;
            }
            else{
                $request = 0;
            }
            return $request;
            //dep($sql);return;
        }

        public function login($table, $data, $suffix){
            //validar si el email existe en DB
            $email = $data[$suffix.'_email'];
            $password = $data[$suffix.'_password'];

            $query="SELECT user_id, user_email, user_password FROM $table WHERE user_email = '$email';";            
            $userFind= $this->select($query);
            //si mail existe se comprueba que el password coincida con el de la DB
            if(!empty($userFind)){
                $id= $userFind['user_id'];
                $passDB= $userFind['user_password'];
                $equalPass = password_verify($password, $passDB);  //entrega bool 1=si coinciden, 0= no coinciden       
                //si la variable es true se puede iniciar sesion
                if($equalPass){
                    //generamos token para el uso de API
                    $token = $this->jwt($id, $email);
                    //instanciar JWT
                    $key = 'zaqplmnkoxsw';
                    $jwt = JWT::encode($token, $key, 'HS256');  //HS256 es el tipo de algoritmo jtw.io mas info
                    $data = [
                        $suffix.'_api_token' => $jwt,
                        $suffix.'_api_token_exp' => $token['exp']
                    ];
                    //se guardan los token generados en la DB
                    $columns='';
                    foreach($data as $key => $value){
                        //se genera SET de la consulta quedara Col1=Val1, Col2=Val2
                        $columns .= $key. "="."'".$value."'". ', ';
                    }
                    $columns = substr($columns, 0, -2);
                    $suffixId = $suffix.'_id';
                    $sql="UPDATE $table SET $columns WHERE $suffixId=$id";
                    $update = $this->tokensToDb($sql);
                    //Si se cumple el proceso se retorna el suo de metodo sessionData, 0=si no se cumplio
                    $sessionData = new PostModel();
                    $update ? $request=$sessionData->sessionData($table, $suffixId, $id, $suffix)  : $request=0;
                }
                else{
                    //se manda 0 si las contraseñas no son iguales
                    $request = 0;
                }
            }
            else{
                // se manda 0 si no se encuentra el email en la DB
                $request = 0;
            }
            return $request;
        }//end method

        public function sessionData($table, $suffixId, $id, $suffix){
            //Se consulta de nuevo el reg pero ahora se trae la info necesaria del user
            $sql="SELECT * FROM $table WHERE $suffixId=$id";
            $userInfo = $this->select($sql);
            unset($userInfo[$suffix.'_password']);  //se evita mandar el password quitandolo del array
            return $userInfo;                 
            
        }

    }//end class