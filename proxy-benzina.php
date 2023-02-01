<?php

$urlArea = "https://carburanti.mise.gov.it/ospzApi/search/area";
$urlZone= "https://carburanti.mise.gov.it/ospzApi/search/zone";


$myRegion = -1;
if ( $_GET['region'] == "" ) {
  //$myRegion = 9;
} else {
  $myRegion = $_GET['region'];
}

$myProvince = "";
if ( $_GET['province'] == "" ) {
  //$myProvince = "RM";
} else {
  $myProvince = $_GET['province'];
}

$myTown = "";
if ( $_GET['town'] == "" ) {
  //$myTown = "Fonte Nuova";
} else {
  $myTown = $_GET['town'];
}



if ( $_GET['radius'] == "" ) {
  $myRadius = 3;
} else {
  $myRadius = $_GET['radius'];
}



if ( $_GET['lat'] == "" ) {
  $myLat = 42.02263108084876;
} else {
  $myLat = $_GET['lat'];
}



if ( $_GET['lng'] == "" ) {
  $myLng = 12.63365339487791;
} else {
  $myLng = $_GET['lng'];
}



if ( $myTown !==   "") {
  $data =  '{
   "region" : "' . $myRegion . '",
   "province" : "' .  $myProvince . '",
   "town" : "' .  $myTown . '",
   "radius": ' . $myRadius . ',
   "priceOrder" :  "asc" ,
   "fuelType":  "1-1",
   "refuelingMode" : 1
  }';
  $url = $urlArea;
} else {
    $data = '{"points":[{"lat" : ' . $myLat . ' ,"lng": ' . $myLng . ' }],"fuelType":"1-1","priceOrder":"asc","radius": ' . $myRadius . '}';
    $url = $urlZone;
}



$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   'Content-Type: application/json',
   'Access-Control-Allow-Origin: *',
   'Access-Control-Allow-Credentials: true',
   'Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE',
   'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With, X-GIGYA-ID_TOKEN,  X-GIGYA-ID-TOKEN, apikey, *, expiration, json, fields, login_token, authorization, access_token, X-RESUME-TOKEN'
);

		header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
		header('Access-Control-Allow-Credentials: true');

//var_dump($headers);


curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

//echo $data  . "<br>";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

echo '{ <br>
     "sent" : {<br>
       "region" : "' . $_GET['region'] .  '",<br>
       "province" : "' . $_GET['province'] .  '",<br>
       "town" : "' . $_GET['town'] .  '",<br>
       "radius" : ' . $_GET['radius'] .  ',<br>
       "lat" : ' . $_GET['lat'] .  ',<br>
       "lng" : ' . $_GET['lng'] .  '<br>
     },
     "response" : ';

echo $resp;

echo '}';

?>

