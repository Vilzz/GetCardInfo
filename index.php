<?php 
$catalog_in = "./input";
$catalog_out = "./out";
//Convert PAN num for necessary view
function createPAN($obj){
    $pan =  substr($obj->CARD_NUM,0,6).' '.substr($obj->CARD_NUM,6,2).' '.substr($obj->CARD_NUM,8,10).' '.substr($obj->CARD_NUM,18,1).' '.substr($obj->CARD_SER,2,2).'/'.substr($obj->CARD_SER,0,2).' '.substr($obj->CARD_SER,4,4);
    return $pan;
}
//Convert CHIP num for necessary view
function createCHIP($obj){
    $chipnum = substr($obj->SNR,6,2).substr($obj->SNR,4,2).substr($obj->SNR,2,2).substr($obj->SNR,0,2).'000000000000';
    return $chipnum;
}
if ($handle = opendir($catalog_in)){
    while (false !== ($file = readdir($handle))){
        if ($file !== "." && $file !== "..") {
            $xml = simplexml_load_file($catalog_in.'/'.$file);
            for ($i=0;$i<count($xml);$i++){
                $pan = createPAN($xml->SocCard[$i]);
                $chipnum = createCHIP($xml->SocCard[$i]);
                echo 'SocialCard - '.$pan.'<br />';
                echo 'Chip - '.$chipnum.'<br />';
                echo $xml->SocCard[$i]->CARD_SER.'<br />';
                echo $xml->SocCard[$i]->SNR.'<br />';
                echo $xml->SocCard[$i]->DT_CARD.'<br />';
                echo $xml->SocCard[$i]->SocCardCategory->CODE_L.'<br />';
               };
             }
        }
    } else {
        echo "Каталог ввода не найден";
    }