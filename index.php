<?php
ini_set('date.timezone', 'Europe/Samara');
include('helpers.php'); 
$catalog_in = "./input";
$catalog_out = "./out";

if ($handle = opendir($catalog_in)){
    while (false !== ($file = readdir($handle))){
        if ($file !== "." && $file !== "..") {
            $xml = simplexml_load_file($catalog_in.'/'.$file);
            for ($i=0;$i<count($xml);$i++){
                $pan = createPAN($xml->SocCard[$i]);
                $chipnum = createCHIP($xml->SocCard[$i]);
                
                $cardseries = getSeries($xml->SocCard[$i]->SocCardCategory);

                print_r($cardseries);
                echo $i.'<br>';


                //$rs = getSeries($xml->SocCard[$i]->SocCardCategory->CODE_L);
                //$lg = '93'.$rs[0]['series'].$rs[0]['lgot_code'];
                //$line =$i.' P'.' '.$rs[0]['series'].' '.'0000000000'.' '.$chipnum.' '.$lg.' '.'-'.' '.'-'.' '.'-<br />';
                //$linetoscv= array('P',);
                //echo $line;
                // echo 'SocialCard - '.$pan.'<br />';
                // echo 'Chip - '.$chipnum.'<br />';
                // echo $xml->SocCard[$i]->CARD_SER.'<br />';
                // echo $xml->SocCard[$i]->SNR.'<br />';
                // echo $xml->SocCard[$i]->DT_CARD.'<br />';
                
                // echo $rs[0]['series'].'<br />';
                
                
               };
             }
        }
    } else {
        echo "Каталог ввода не найден";
    }