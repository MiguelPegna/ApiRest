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
            $model = get_class($this). 'Model';
            $routClass = 'Models/'. $model. '.php';

            if(file_exists($routClass)){
                require_once($routClass);
                $this->model = new $model();
            }
        }

        /*public function loadroute(){
            $method = get_class($this);
            $routeServ = 'routes/services'. $method. '.php';

            if(file_exists($routeServ)){
                require_once($routeServ);
                $this->model = new $method();
            }
        }*/
    }
?>