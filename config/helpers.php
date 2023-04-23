<?php
    //regresa la url del proyecto
    function base_url() {
        return BASE_URL;
    }
    function url_full() {
        return URL_FULL;
    }

    function assets(){
        return BASE_URL. 'public/';
    }
    //muestra información formateada
    function dep($data){
        $format = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }

    //funcion para llamar ventanas modales del proyecto
    function getModal(string $nameModal, $data){
        $viewModal = "views/_templates/modals/{$nameModal}.php";
        require_once $viewModal;
    }
    //Elimina excesos de espacios entre palabras
    function strClean($strCadena){
        $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
        $string = trim($string);  //elimina espacios en blanco al inicio y al final
        $string = stripslashes($string);  // elimina \invertidas
        $string = str_ireplace('<script>', '', $string);
        $string = str_ireplace('</script>', '', $string);
        $string = str_ireplace('<script src>', '', $string);
        $string = str_ireplace('<script type=>', '', $string);
        $string = str_ireplace('SELECT * FROM', '', $string);
        $string = str_ireplace('DELETE FROM', '', $string);
        $string = str_ireplace('INSERT INTO', '', $string);
        $string = str_ireplace('SELECT COUNT(*) FROM', '', $string);
        $string = str_ireplace('DROP TABLE', '', $string);
        $string = str_ireplace("OR '1'='1'", '', $string);
        $string = str_ireplace('OR "1"="1"', '', $string);
        $string = str_ireplace('OR ´1´=´1´', '', $string);
        $string = str_ireplace('OR `1`=`1`', '', $string);
        $string = str_ireplace('is NULL; --', '', $string);
        $string = str_ireplace('is NULL; --', '', $string);
        $string = str_ireplace("LIKE '", '', $string);
        $string = str_ireplace('LIKE "', '', $string);
        $string = str_ireplace('LIKE ´', '', $string);
        $string = str_ireplace("OR 'a'='a'", '', $string);
        $string = str_ireplace('OR "a"="a"', '', $string);
        $string = str_ireplace('OR ´a´=´a´', '', $string);
        $string = str_ireplace('OR `a`=`a`', '', $string);
        $string = str_ireplace('--', '', $string);
        $string = str_ireplace('^', '', $string);
        $string = str_ireplace('[', '', $string);
        $string = str_ireplace(']', '', $string);
        $string = str_ireplace('==', '', $string);
        return $string;
    }

    
    //formato para valores moenetarios
    function formatMoney($cantidad){
        $cantidad = number_format($cantidad, 2, SPD, SPM);
        return $cantidad;
    }

?>