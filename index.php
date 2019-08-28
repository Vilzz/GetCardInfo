<?php 
$filename = "./GIVED_SOC_CARD_20190828120119.xml";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php 
    if (file_exists($filename)) {
        $xml = simplexml_load_file($filename);
        
        for ($i=0;$i<count($xml);$i++){
            echo $xml->SocCard[$i]->CARD_NUM.'<br/>';
            echo $xml->SocCard[$i]->CARD_SER.'<br/>';
            echo $xml->SocCard[$i]->SNR.'<br/>';
            echo $xml->SocCard[$i]->DT_CARD.'<br/>';
            echo $xml->SocCard[$i]->SocCardCategory->CODE_L.'<br/>';
            
        };
    } else {
        exit('Не удалось открыть файл {$filename}');
    }
    
    
    ?>
</body>

