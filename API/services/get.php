<?php
    
    require_once '../controllers/GetController.php';
    //require_once 'put.php';  //se llama el archivo put
    //$table= explode('?', $routesArr[2])[0];
    $select = $_GET['select'] ?? '*';       //recibe el nombre de tabla o tablas select=nomTable
    $order = $_GET['order'] ?? null;        //recibe el nombre de columna para ordenar order=nom_column -- ORDER BY
    $mode = $_GET['mode'] ?? null;          //recibe el modo para ordenar mode=ASC o mode=DESC
    $start = $_GET['start'] ?? null;        //start = 1er valor  -- LIMIT 
    $end = $_GET['end'] ?? null;            //end = ultimo valor -- LIMIT
    $filterTo = $_GET['filterTo'] ?? null;  //filterTo = nom Colum para seleccionar rango
    $inTo = $_GET['inTo'] ?? null;          //IN valores del in para indicar rango

    $response = new GetController();

    //respuestas del  controlador

    //Consultas con Sentencia where//
    if(isset($_GET['linkTo']) && isset($_GET['equalTo']) && !isset($_GET['rel']) && !isset($_GET['type'])){
        $linkTo = $_GET['linkTo'];          //recibe nombre de columna para usar WHERE  linkTo=nom_column
        $equalTo = $_GET['equalTo'];        //recibe el valor de columna para usar WHERE equalTo=val_column   --tiene que ser valor exacto
        
        $response->getDataWhere($table, $select, $linkTo, $equalTo, $order, $mode, $start, $end);
    }
    //Consultas con sentencia inner join sin Where//
    else if(isset($_GET['rel']) && isset($_GET['type']) && $table=='relations' && !isset($_GET['linkTo']) && !isset($_GET['equalTo'])){
        $rel = $_GET['rel'];     //Indica las tablas con las que se hara relacion
        $type = $_GET['type'];   //buscar coincidencias con nombre de columnas de las tablas a relacionar en singular

        $response->getInnerJoinData($rel, $type, $select, $order, $mode, $start, $end);
    }
    //Consultas con sentencias inner join y Where//
    else if(isset($_GET['rel']) && isset($_GET['type']) && $table=='relations' && isset($_GET['linkTo']) && isset($_GET['equalTo'])){
        $rel = $_GET['rel'];
        $type = $_GET['type'];
        $linkTo = $_GET['linkTo'];
        $equalTo = $_GET['equalTo'];
        $response->getInnerJoinDataWhere($rel, $type, $select, $linkTo, $equalTo,  $order, $mode, $start, $end);
    }
    //Consultas de busqueda sin inner join
    else if(empty($_GET['rel']) && empty($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['search'])){
        $linkTo = $_GET['linkTo'];
        $search = $_GET['search'];
        $response->getDataSearch($table, $select, $linkTo, $search, $order, $mode, $start, $end);
    }
    //consultas de busqueda con sentencias inner join  WHERE y like//
    else if(isset($_GET['rel']) && isset($_GET['type']) && $table=='relations' && isset($_GET['linkTo']) && isset($_GET['search'])){
        $rel = $_GET['rel'];
        $type = $_GET['type'];
        $linkTo = $_GET['linkTo'];
        $search = $_GET['search'];
        $response->getInnerJoinDataSearch($rel, $type, $select, $linkTo, $search, $order, $mode, $start, $end);
    }
    //Consultas con sentencia RANGE//
    else if(empty($_GET['rel']) && empty($_GET['type']) && isset($_GET['linkTo']) && isset($_GET['since']) && isset($_GET['till'])){
        $linkTo = $_GET['linkTo']; //Columna de referencia
        $since = $_GET['since'];  //BETWEEN valor inicial
        $till = $_GET['till'];    //BETWEEN valor final
        $response->getDataRange($table, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo);
    }
    //Consultas con sentencias RANGE e INNER JOIN//
    else if(isset($_GET['rel']) && isset($_GET['type']) && $table=='relations' && isset($_GET['linkTo']) && isset($_GET['since']) && isset($_GET['till']) ){
        $rel = $_GET['rel'];
        $type = $_GET['type'];
        $linkTo = $_GET['linkTo'];
        $since = $_GET['since'];
        $till = $_GET['till'];
        $response->getInnerJoinDataRange($rel, $type, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo);
    }
    //consulta select * all columns
    else{
        $response->getData($table, $select, $order, $mode, $start, $end);
    }


    