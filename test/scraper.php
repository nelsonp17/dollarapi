<?php

require __DIR__ . '/vendor/autoload.php';

$web = new \Spekulatius\PHPScraper\PHPScraper;
$web->go('https://monitordolarvenezuela.com/');

//echo $web->title();
//echo "<br><br>";
//$outline = $web->outline;
//$content = $web->outlineWithParagraphs;
//$content = $web->cleanOutlineWithParagraphs;
$content = $web->paragraphs; // precio
$array = [
    "BCV" => 0,
    "ParaleloVzla" => 0,
    "DolarToday" => 0,
    "MonitorDolarWeb" => 0,
    "EnParaleloVzlaVip" => 0,
    "Binance" => 0,
    "AIRTM" => 0
];
$i = 0;
foreach ($content as $key => $value) {
    
    if(strpos($value, "Bs = ") !== false){
        $value = str_replace("Bs = ", "", $value);
        $value = trim($value);
        //$value = floatval($value);
        //$value = (float)$value;
        switch($i){
            case 0:
            $array["BCV"] = $value;
            break;

            case 1:
            $array["ParaleloVzla"] = $value;
            break;

            case 2:
            $array["DolarToday"] = $value;
            break;

            case 3:
            $array["MonitorDolarWeb"] = $value;
            break;

            case 4:
            $array["EnParaleloVzlaVip"] = $value;
            break;

            case 5:
            $array["Binance"] = $value;
            break;

            case 6:
            $array["AIRTM"] = $value;
            break;
        }
        
        //echo "<br>" . var_dump($value) . "<br>";  
        ++$i;    
    }
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
echo json_encode($array);

// Filter using the ID
//echo $web->filter("//h1")->text();          // "Selector Tests (h1)"

// Select single string using first and chain `->text()`
//echo $web->filterFirst("//h1")->text();     // 'Selector Tests (h1)'

// Select as array using `filterTexts`:
//echo $web->filterTexts("//h1"); 


//$fil = $web->filter("//*[@id='promedios']")->html();
//$fil = $web->filter("//*[@class='row text-center']")->html();
//$fil = $web->filter("//*[@class='row text-center']")->html();
//$fil = $web->filter("//*[@class='col-12 col-sm-4 col-md-2 col-lg-2']");


//var_dump($fil);
/**
foreach ($fil as $key => $value) {
    var_export($value);
    break;
}
**/
// echo $fil;
//print_r($fil);