<?php

    require_once '../core/DB_conection.php';
    require_once '../core/mysql.php';

    class GetModel extends Mysql{

        ////////////////////////////
        //peticiones get sin where// --sin filtro
        ////////////////////////////
        public function selectData($table, $select, $order, $mode, $start, $end){
            //consulta sin ORDERBY ni LIMIT
            $sql="SELECT $select FROM $table";
            //consulta con orderBy pero sin LIMIT
            if($order != null && $mode != null && $start==null && $end==null){
                $sql="SELECT $select FROM $table ORDER BY $order $mode";
            }
            //consulta con ORDERBY y LIMIT
            if($order != null && $mode != null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table ORDER BY $order $mode LIMIT $start, $end";
            }
            //consulta con LIMIT pero sin ORDERBY
            if($order == null && $mode == null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table LIMIT $start, $end";
            }

            $request = $this->select_all($sql);
            return $request;
        }

        ////////////////////////////
        //peticiones get con where//  --con filtro
        ////////////////////////////
        public function selectDataWhere($table, $select, $linkTo, $equalTo, $order, $mode, $start, $end){
            $linkToArr = explode(',', $linkTo);
            $equalToArr = explode('_', $equalTo);
            $linkToTxt = '';

            if(count($linkToArr)>1){
                foreach($linkToArr as $key =>$value){
                    if($key >0){
                        $linkToTxt .= 'AND '.$value. ' = :'. $value.' ';
                    }
                }
            }

            //consulta Where sin ORDERBY ni LIMIT
            $sql="SELECT $select FROM $table WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt";
            
            //Consulta WHERE con ORDERBY sin LIMIT
            if($order != null && $mode != null && $start==null && $end==null){
                $sql="SELECT $select FROM $table WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt ORDER BY $order $mode";
            }  

            //Consulta WHERE con ORDERBY y LIMI
            if($order != null && $mode != null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt ORDER BY $order $mode LIMIT $start, $end";
            } 

            //Consulta WHERE con LIMIT pero sin ORDERBY
            if($order == null && $mode == null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt LIMIT $start, $end";
            } 
            $request = $this->select_filter($sql, $linkToArr, $equalToArr);
            return $request;
        }

        ///////////////////////////////////////
        //peticiones get INNER JOIN sin Where//  --sin filtro
        ///////////////////////////////////////
        public function selectInnerJoinData($rel, $type, $select, $order, $mode, $start, $end){
            $relArr = explode(',', $rel);
            $typeArr = explode(',', $type);
            $innerJoinTxt = '';

            if(count($relArr)>1){
                foreach($relArr as $key =>$value){          
                    if($key > 0){
                        $innerJoinTxt.= 'INNER JOIN '. $value.' ON '. $relArr[0]. '.'. $typeArr[0].'_'. $typeArr[$key]. ' = '. $value. '.'. $typeArr[$key]. '_id'. ' ';
                    }
                }
                //consulta INNER JOIN sin ORDERBY ni LIMIT
                $sql="SELECT $select FROM $relArr[0] $innerJoinTxt";

                //consulta INNER JOIN con orderBy pero sin LIMIT
                if($order != null && $mode != null && $start==null && $end==null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt ORDER BY $order $mode";
                }
                //consulta INNER JOIN con ORDERBY y LIMIT
                if($order != null && $mode != null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt ORDER BY $order $mode LIMIT $start, $end";
                }
                //consulta INNER JOIN con LIMIT pero sin ORDERBY
                if($order == null && $mode == null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt LIMIT $start, $end";
                }

                $request = $this->select_all($sql);
                return $request;
            }
            return null;
        }


        ///////////////////////////////////////
        //peticiones get INNER JOIN con Where//  --con filtro
        ///////////////////////////////////////
        public function selectInnerJoinDataWhere($rel, $type, $select, $linkTo, $equalTo, $order, $mode, $start, $end){
            //Organizar filtros
            $linkToArr = explode(',', $linkTo);
            $equalToArr = explode('_', $equalTo);
            $linkToTxt = '';

            if(count($linkToArr)>1){
                foreach($linkToArr as $key =>$value){
                    if($key >0){
                        $linkToTxt .= 'AND '.$value. ' = :'. $value.' ';
                    }
                }
            }

            //Oranizar relaciones
            $relArr = explode(',', $rel);
            $typeArr = explode(',', $type);
            $innerJoinTxt = '';

            if(count($relArr)>1){
                foreach($relArr as $key =>$value){
                    if($key > 0){
                        $innerJoinTxt.= 'INNER JOIN '. $value.' ON '. $relArr[0]. '.'. $typeArr[0].'_'. $typeArr[$key]. ' = '. $value. '.'. $typeArr[$key]. '_id'. ' ';
                    }
                }
                //consulta INNER JOIN sin ORDERBY ni LIMIT
                $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt";

                //consulta INNER JOIN con orderBy pero sin LIMIT
                if($order != null && $mode != null && $start==null && $end==null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt ORDER BY $order $mode";
                }
                //consulta INNER JOIN con ORDERBY y LIMIT
                if($order != null && $mode != null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt ORDER BY $order $mode LIMIT $start, $end";
                }
                //consulta INNER JOIN con LIMIT pero sin ORDERBY
                if($order == null && $mode == null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0]= :$linkToArr[0] $linkToTxt LIMIT $start, $end";
                }

                $request = $this->select_filter($sql, $linkToArr, $equalToArr);
                return $request;
            }
            else{
                return null;
            }
        }

        /////////////////////////////////////////////
        //peticiones get de busqueda sin inner join//
        /////////////////////////////////////////////
        public function selectDataSearch($table, $select, $linkTo, $search, $order, $mode, $start, $end){
            //organizar filtros
            $linkToArr = explode(',', $linkTo);
            $searchArr = explode('_', $search);
            $linkToTxt = '';

            if(count($linkToArr)>1){
                foreach($linkToArr as $key =>$value){
                    if($key >0){
                        $linkToTxt .= 'AND '.$value. ' = :'. $value.' ';
                    }
                }
            }
            
            //consulta sin ORDERBY ni LIMIT
            $sql="SELECT $select FROM $table WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt";
            
            //consulta con orderBy pero sin LIMIT
            if($order != null && $mode != null && $start==null && $end==null){
                $sql="SELECT $select FROM $table WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt ORDER BY $order $mode";
            }
            //consulta con ORDERBY y LIMIT
            if($order != null && $mode != null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt ORDER BY $order $mode LIMIT $start, $end";
            }
            //consulta con LIMIT pero sin ORDERBY
            if($order == null && $mode == null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table  WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt LIMIT $start, $end";
            }
            $request = $this->select_filter_search($sql, $linkToArr, $searchArr);
            return $request;
        }

        ///////////////////////////////////////
        //peticiones get INNER JOIN con Where//
        ///////////////////////////////////////
        public function selectInnerJoinDataSearch($rel, $type, $select, $linkTo, $search, $order, $mode, $start, $end){
            //Organizar filtros
            $linkToArr = explode(',', $linkTo);
            $searchArr = explode('_', $search);
            $linkToTxt = '';

            if(count($linkToArr)>1){
                foreach($linkToArr as $key =>$value){
                    if($key >0){
                        $linkToTxt .= 'AND '.$value. ' = :'. $value.' ';
                    }
                }
            }

            //Oranizar relaciones
            $relArr = explode(',', $rel);
            $typeArr = explode(',', $type);
            $innerJoinTxt = '';

            if(count($relArr)>1){
                foreach($relArr as $key =>$value){
                    if($key > 0){
                        $innerJoinTxt.= 'INNER JOIN '. $value.' ON '. $relArr[0]. '.'. $typeArr[0].'_'. $typeArr[$key]. ' = '. $value. '.'. $typeArr[$key]. '_id'. ' ';
                    }
                }
                //consulta INNER JOIN sin ORDERBY ni LIMIT
                $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt";
                //consulta INNER JOIN con orderBy pero sin LIMIT
                if($order != null && $mode != null && $start==null && $end==null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt ORDER BY $order $mode";
                }
                //consulta INNER JOIN con ORDERBY y LIMIT
                if($order != null && $mode != null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt ORDER BY $order $mode LIMIT $start, $end";
                }
                //consulta INNER JOIN con LIMIT pero sin ORDERBY
                if($order == null && $mode == null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkToArr[0] LIKE '%$searchArr[0]%' $linkToTxt LIMIT $start, $end";
                }

                $request = $this->select_filter_search($sql, $linkToArr, $searchArr);
                return $request;
            }
            else{
                return null;
            }
        }//endMethod

        ///////////////////////////////////////////////////
        //peticiones get seleccion de rangos con filtros //  --con filtro
        ///////////////////////////////////////////////////
        public function selectDataRange($table, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo){
            $filter ='';
            if($filterTo != null && $inTo != null){
                $filter ='AND '.$filterTo. ' IN ('.$inTo.');';
            }
            //consulta sin ORDERBY ni LIMIT
            $sql="SELECT $select FROM $table WHERE $linkTo BETWEEN '$since' AND '$till' $filter";
            //consulta con orderBy pero sin LIMIT
            if($order != null && $mode != null && $start==null && $end==null){
                $sql="SELECT $select FROM $table WHERE $linkTo BETWEEN '$since' AND '$till' $filter ORDER BY $order $mode";
            }
            //consulta con ORDERBY y LIMIT
            if($order != null && $mode != null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table WHERE $linkTo BETWEEN '$since' AND '$till' $filter ORDER BY $order $mode LIMIT $start, $end";
            }
            //consulta con LIMIT pero sin ORDERBY
            if($order == null && $mode == null && $start!=null && $end!=null){
                $sql="SELECT $select FROM $table WHERE $linkTo BETWEEN '$since' AND '$till' $filter LIMIT $start, $end";
            }

            $request = $this->select_all($sql);
            return $request;
        }//end method

        ////////////////////////////////////////////////////////////////
        //peticiones get seleccion de rangos con filtros e inner join //   --con filtro
        ////////////////////////////////////////////////////////////////
        public function selectInnerJoinDataRange($rel, $type, $select, $linkTo, $since, $till, $order, $mode, $start, $end, $filterTo, $inTo){
            $filter ='';
            if($filterTo != null && $inTo != null){
                $filter ='AND '.$filterTo. ' IN ('.$inTo.');';
            }

            //Oranizar relaciones
            $relArr = explode(',', $rel);
            $typeArr = explode(',', $type);
            $innerJoinTxt = '';

            if(count($relArr)>1){
                foreach($relArr as $key=>$value){
                    if($key >0){
                        $innerJoinTxt.= 'INNER JOIN '. $value.' ON '. $relArr[0]. '.'. $typeArr[0].'_'. $typeArr[$key]. ' = '. $value. '.'. $typeArr[$key]. '_id'. ' ';
                    }
                }

                //consulta sin ORDERBY ni LIMIT
                $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkTo BETWEEN '$since' AND '$till' $filter";
                //consulta con orderBy pero sin LIMIT
                if($order != null && $mode != null && $start==null && $end==null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkTo BETWEEN '$since' AND '$till' $filter ORDER BY $order $mode";
                }
                //consulta con ORDERBY y LIMIT
                if($order != null && $mode != null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkTo BETWEEN '$since' AND '$till' $filter ORDER BY $order $mode LIMIT $start, $end";
                }
                //consulta con LIMIT pero sin ORDERBY
                if($order == null && $mode == null && $start!=null && $end!=null){
                    $sql="SELECT $select FROM $relArr[0] $innerJoinTxt WHERE $linkTo BETWEEN '$since' AND '$till' $filter LIMIT $start, $end";
                }

                $request = $this->select_all($sql);
                return $request;
            }
            else{
                return null;
            }
        }//end method
  

    }//end class


    //verificar existencia de tablas y columnas
            /*
            $verifyTable = $this->verifyTable($table, $select);
            if(empty($verifyTable)){
                return null;
            }
            */