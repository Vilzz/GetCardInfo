<?php
   
    function runQuery($sql){
        $pass = getenv('POSTGRES_PASS');
        $user = getenv('POSTGRES_USER');
        $conString = "host=localhost port=5432 dbname=helpers user='{$user}' password='{$pass}'";
        $db_conn = pg_connect($conString) or die("Can't connect to db: " . pg_last_error());
        $res = pg_query($sql) or die('Query error: ' . pg_last_error());
        $query_res = pg_fetch_all($res);
        pg_close($db_conn);
        return $query_res;
    }

    function getSeriesFromDB($lgotnum){
        $query="select lgot_code, series from lgots where lgot_num='{$lgotnum}'";
        $result = runQuery($query);
        return $result;
    }
    //Convert PAN num for necessary view format
    function createPAN($obj){
        $pan =  substr($obj->CARD_NUM,0,6).' '.substr($obj->CARD_NUM,6,2).' '.substr($obj->CARD_NUM,8,10).' '.substr($obj->CARD_NUM,18,1).' '.substr($obj->CARD_SER,2,2).'/'.substr($obj->CARD_SER,0,2).' '.substr($obj->CARD_SER,4,4);
        return $pan;
    }
    //Convert CHIP num for necessary view format
    function createCHIP($obj){
        $chipnum = substr($obj->SNR,6,2).substr($obj->SNR,4,2).substr($obj->SNR,2,2).substr($obj->SNR,0,2).'000000000000';
        return $chipnum;
    }
    
    function getSeries($lgotnumobj){
        if(count($lgotnumobj)>1){
            $k=0;
            foreach ($lgotnumobj as $key => $value){
                    $rs=getSeriesFromDB($value->CODE_L);
                    if (isset($rs[0]["series"])){
                        return $rs; 
                    }else{
                        $notfound[$k] = $rs[0]["series"];
                        $k++;  
                    }
            }
            return $notfound;
        }
    else {
        return getSeriesFromDB($lgotnumobj->CODE_L[0]);
    }
    }