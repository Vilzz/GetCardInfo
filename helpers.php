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
    function createPAN($card_num,$card_ser){
        $pan =  substr($card_num,0,6).' '.substr($card_num,6,2).' '.substr($card_num,8,10).' '.substr($card_num,18,1).' '.substr($card_ser,2,2).'/'.substr($card_ser,0,2).' '.substr($card_ser,4,4);
        return $pan;
    }
    //Convert CHIP num for necessary view format
    function createCHIP($card_snr){
        $chipnum = substr($card_snr,6,2).substr($card_snr,4,2).substr($card_snr,2,2).substr($card_snr,0,2).'000000000000';
        return $chipnum;
    }
    
    //Create lgot code and series to line and return as array
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
    //Create short num from pan  
    function getNum($pan){
        $short ='0'
             .(substr($pan,10,2) == '00' ? '13' : substr($pan,10,2))
             .substr($pan,8,2)
             .substr($pan,12,2)
             .substr($pan,15,3);
        return $short;
    }