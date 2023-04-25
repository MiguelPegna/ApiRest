<?php
    class Controllers{
        //public $routes;
        public $views;
        public $model;
        
        public function __construct(){
            $this->views = new Views();
            $this->loadModel();

            //$this->routes = new Routes();
            //$this->loadroute();
        }

        public function loadmodel(){
            $mainClass = get_class($this);  //obtiene el nombre principal de la clase del controlador
            $model = get_class($this). 'Model';  //A la clase principal se le agrega la cadena Model
            $model = str_replace('Controller', '', $model);   //Removemos la palabra Controller del nombre de clase principal
            $modelFileName =  str_replace('Controller', 'Model', $mainClass);  //Reemplazamos la palabra controller por model para poder trabajar con el Modelo del controlador
            $routClass = 'Models/'. $modelFileName. '.php';  //de declara la ruta del archivo del modelo

            //Se instancian los metodos del modelo
            if(file_exists($routClass)){
                require_once($routClass);
                $this->model = new $model();
            }
        }

    }
?>