<?php
    class DB_conection{
        public $conect;

        public function __construct(){
            $connectionString = "mysql:host=".DB_HOST. 
                                             ";dbname=".DB_NAME.
                                             ";.DB_CHARSET.";
            
            try{
                $this->conect = new PDO($connectionString, DB_USER. DB_PASS);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conect->exec('set names utf8mb4');
                //echo 'Flipa en colores bien mogollón a todo gas chaval.. se ha hecho la conexión';
            }
            catch (Exception $e){
                $this->conect = 'Error vale verdi la vida mejor matate';
                echo "ERROR: ". $e->getMessage();
            }
        }

        public function conectar(){
            return $this->conect;
        }
    }

    //$prueba = new DB_conection();
?>