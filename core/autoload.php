<?php
    //cargar el autoload para mandar a llamar las clases de manera mas comoda
    spl_autoload_register(function($class){
        if(file_exists('core/' .$class. '.php')){
            require_once('core/' .$class. '.php');
        }
    });
?>