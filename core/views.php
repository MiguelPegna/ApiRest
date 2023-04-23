<?php
    class Views{
        function getView($controller, $view, $data=''){
            $controller = get_class($controller);
            $viewController = str_replace('Controller', '', $controller);
            //dep($viewController);
            if($viewController == 'Home'){
                $view = 'views/'. $view. '.php';
            }
            else{
                $view = 'views/'. $viewController. '/'. $view. '.php';
            }
            require_once($view);
        }
    }
?>