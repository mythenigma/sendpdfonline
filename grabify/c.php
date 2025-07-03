<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
 //ini_set("display_errors", true);
 //ini_set("html_errors", false); 




if(isset($_GET['i'])){
          $ip= htmlspecialchars($_GET['i']);
          $type=1;
 }else{
	    //exit();
     // $ip = '134.201.250.155';
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} else {
    $ip = $_SERVER['REMOTE_ADDR']; 
}
      echo $ip;
      exit();
}






if (filter_var($ip, FILTER_VALIDATE_IP)) {
   // echo 'Valid IP address';
} else {
    exit();
}









$access_key = '527c8807d2014b359e2738825498a76e';  //mythenigma@gmail.com //522 Hao//joegar
//https://app.ipgeolocation.io/
//861eb31f96384b39bac524292d44c944
//$ curl 'https://api.ipgeolocation.io/ipgeo?apiKey=API_KEY&ip=8.8.8.8'

if(rand(1,100)>85){
  $access_key = '527c8807d2014b359e2738825498a76e';
}elseif(rand(1,100)>60){
   $access_key = '861eb31f96384b39bac524292d44c944';
}elseif(rand(1,100)>30){
   $access_key = 'd488ab42f7954512824e523c6cb6cdf6';
}else{
  $access_key = 'e1983249595b406f96ca9be051b710e8';
}


$ch = curl_init('https://api.ipgeolocation.io/ipgeo?apiKey='.$access_key.'&ip='.$ip);
//$ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$api_result = json_decode($json, true);
//echo $api_result['country_name'];

//echo $api_result['city'];
echo $api_result['continent_name'].'-'.$api_result['country_name'].'<br>'.$api_result['state_prov'].'<br>'.$api_result['city'].'<br>ISP: '.$api_result['isp'];

//print_r($api_result);
/*
MY_FUNCTION({"ip":"134.201.250.155","type":"ipv4","continent_code":"NA","continent_name":"North America","country_code":"US","country_name":"United States","region_code":"CA","region_name":"California","city":"Los Angeles","zip":"90012","latitude":34.0655517578125,"longitude":-118.24053955078125,"location":{"geoname_id":5368361,"capital":"Washington D.C.","languages":[{"code":"en","name":"English","native":"English"}],"country_flag":"http:\/\/assets.ipstack.com\/flags\/us.svg","country_flag_emoji":"\ud83c\uddfa\ud83c\uddf8","country_flag_emoji_unicode":"U+1F1FA U+1F1F8","calling_code":"1","is_eu":false}})
*/
?>