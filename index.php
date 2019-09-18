<?php
ini_set('date.timezone', 'Europe/Samara');
include('helpers.php'); 
$catalog_in = "./input";
$catalog_out = "./out";
$outputfilename = 'soctrans-63-'.date('Y-m-d').'.csv';
$outfilehandle = fopen($catalog_out.'/'.$outputfilename, "a");
if ($handle = opendir($catalog_in)){
    while (false !== ($file = readdir($handle))){
        if ($file !== "." && $file !== "..") {
            $xml = simplexml_load_file($catalog_in.'/'.$file);
            for ($i=0;$i<count($xml);$i++){
                $pan = createPAN($xml->SocCard[$i]->CARD_NUM,$xml->SocCard[$i]->CARD_SER);
                $chipnum = createCHIP($xml->SocCard[$i]->SNR);
                $cardseries = getSeries($xml->SocCard[$i]->SocCardCategory);
                $num= getNum($xml->SocCard[$i]->CARD_NUM);         
                $code_l = '93'.$cardseries[0]['series'].$cardseries[0]['lgot_code'];
                if($pan !='' && $chipnum !='' && $cardseries !='' && $num !=''){
                    $linetocsv= array('P',$cardseries[0]['series'],$num,$chipnum,$code_l,$pan,'ADDED','ON',date('Y-m-d'));
                    $line =$i .'- P'.' '.$cardseries[0]['series'].' '.$num.' '.$chipnum.' '.$code_l.' '.$pan.'ADDED'.' '.'ON'.' '.date('Y-m-d');
                    fputcsv($outfilehandle, $linetocsv,"\t");
                    print($line);echo'<br>';
                }                
               };
             }
        }
    } else {
        echo "Каталог ввода не найден";
    }
fclose($outfilehandle);