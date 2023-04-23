<?php
    //load

    $controllerFile = 'controllers/'. $controller. 'Controller.php';
    //dep($controllerFile);
    if(file_exists($controllerFile)){
        require_once($controllerFile);
        $controllerClass = $controller.'Controller';
        $controllerClass = new $controllerClass();
        if(method_exists($controllerClass, $method)){
            $controllerClass-> {$method}($params);
        }
        else{
            require_once('Controllers/ErrorController.php');
        }
    }
    else{
        require_once('Controllers/ErrorController.php');
    }
?>