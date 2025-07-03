<?php






      $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
      if(strlen($ip)<1){
       $ip = $_SERVER['REMOTE_ADDR'];
      }
$datime=date("Y.m.d.H.i.s");


$spiders=array("182.90.255.54","123.170.33.14","223.98.176.216","39.155.155.106","106.55.202.33","157.148.40.30","106.55.200.29","157.148.40.57","112.249.154.7","111.36.171.160","120.245.30.136","106.55.202.206","106.55.200.24","157.255.11.80","58.35.209.200","47.94.38.84","113.96.223.239","111.60.1.56","112.116.105.17","72.14.199.164","66.249.74.58","61.151.202.84","74.67.10.61","101.22.165.90","47.99.157.110","101.22.165.90","183.208.136.125","70.186.197.153","111.30.23.191","39.107.59.89","113.96.223.240","113.96.221.178","61.151.178.150","113.96.219.105","47.93.128.189","58.251.98.105","61.129.11.211","47.57.141.145","111.20.218.2");
   if(in_array($ip,$spiders)){
	   exit('spider');
   }else{
	   echo $ip.'Welcome to MaiPDF';
   }



function cidr_match($ip, $range){
    list ($subnet, $bits) = explode('/', $range);
    if ($bits === null) {
        $bits = 32;
    }
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
    return ($ip & $mask) == $subnet;
}



$ipcloud = array('131.0.72.0/22','172.64.0.0/13','104.24.0.0/14','104.16.0.0/13','162.158.0.0/15','198.41.128.0/17','197.234.240.0/22','188.114.96.0/20','190.93.240.0/20','108.162.192.0/18','141.101.64.0/18','173.245.48.0/20', '103.21.244.0/22', '103.22.200.0/22', '103.31.4.0/22');

foreach ($ipcloud as $IP) {
    if (cidr_match($ip, $IP) == true) {
        exit('CloudFlare'); 
    }
}








   if(isset($_GET["pic"])){
      $pic=htmlspecialchars($_GET['pic']);
    }else{
      $pic='no';
    }
     $br=$_SERVER['HTTP_USER_AGENT'];
       if(stristr($br,'jssdk') ){
		  exit('whitespider');
	  }
	  if(stristr($br,'bot') || stristr($br,'google') ){
		  exit('spider');
	  }
     $br1= explode(')',$br);
     $br1= $br1[0].")";
     if(isset($_COOKIE['userjoe'])){
       $zmak5=$_COOKIE['userjoe'];
     }else{
       $zmak5=date("Y/m/d+H:i:s");
     }
	 
$servernameMai = "109.205.178.67";
$usernameMai =  "yesjoe";
$passwordMai =  "JOEjoe123";
$dbnameMai =    "maipdf";
 $conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
	if($conn->connect_error){
		die("contact it for issue");
	}
  // $sql = "INSERT INTO `recordip`(`email`, `subject`, `mark`,`markopen`,`passcode`,`ip`) VALUES ('g','$key','$zmak5','$br',8,'$ip') ";
  if(stristr($pic,'.')){//说明来的是ip地址
    $sql="SELECT `md5` FROM `block` WHERE `attr`='bad' AND `ip`='$pic' LIMIT 1";
    $res=mysqli_query($conn,$sql);
  if ($res->num_rows>0){
    $checker='this is very hot';
  }else{
    $checker='ok';
  }
    $conn->close();
    exit($checker);
  }
     $email=htmlspecialchars($_GET['md5']);
     $shijian=htmlspecialchars($_GET['shijian']);


// $connTmaitube = new mysqli("t.maitube.com", "joe", "JOEjoe123", "maipdf");
// $sqltempin = "INSERT INTO `records`(`email`, `subject`, `mark`,`markopen`,`passcode`,`ip`,`add`) VALUES ('$email','Succed','$shijian','$br',64888990,'$ip',3) ";
//mysqli_query($connTmaitube,$sqltempin);
//$connTmaitube->close();



  if($pic =='yes' ){
    $sqlrecord = "INSERT INTO `recordip`(`email`, `subject`, `mark`,`markopen`,`passcode`,`ip`) VALUES ('l','$email','$shijian','$br1',8,'$ip') ";
          $result2=mysqli_query($conn,$sqlrecord);
          $conn->close();
          exit('good');
  }else{
	  
	 $md5ofemail ='202303';
     $sqlrecord = "INSERT INTO `records`(`email`, `subject`, `mark`,`markopen`,`passcode`,`ip`,`add`) VALUES ('$email','Succed','$shijian','$br',64888990,'$ip','$md5ofemail') ";
     $sqlwhite="SELECT `md5` FROM `block` WHERE `attr`='user' AND `md5`='$email' LIMIT 1";
     $res=mysqli_query($conn,$sqlwhite);
  	
	
	
	
	if (isset($_COOKIE['maigua'])){
		$maigua= $_COOKIE['maigua']; 
		if($maigua[0]!='g' && $maigua[0]!='q'){ 
			include_once ('/var/www/html/sendemail.php');	
			echo "<div style=\"display:none;\">";			
              sendoutemail('freeman@doc.maiimg.com',$maigua.'*'.$maigua[0].'*'.$email);  
		    echo "</div>" ;
      }
	}
     if($pic<100000){
	//	 $sql2="UPDATE `pdf` SET `limit`=$pic WHERE `mdemail`='$email' ";
		// $file=fopen("list.txt","a+");
		// fwrite($file, "$sql2 \r\n\r\n");
		// fclose($file);
		  $sql2="UPDATE `pdf` SET `limit`=$pic WHERE `mdemail`='$email' "; 
		  mysqli_query($conn,$sql2);
          $result2=mysqli_query($conn,$sqlrecord);
       }else{
		   $pic='Unlimited';
	   }
  	if (isset($_GET["yj"])){
      $yj=htmlspecialchars($_GET['yj']);
	  $doctitle=htmlspecialchars($_GET['dtitle']);
	 
	  $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
      if(preg_match($regex, $yj)){
        include_once ('/var/www/html/sendemail.php');
	//	   echo "<div style=\"display:none;\">";
      if($shijian[0]=='joehuang'){
	    $doctitle=$doctitle.'.pdf  '.'<br>IP 地址 ：'.$ip."<br>浏览器信息：".$br."---<br>".$shijian."<br><br>该文件还有".$pic." 次数可以阅读<br>";  
		alertemail($yj,$email,$doctitle,'mairead');
	 }else{			 
		
		$doctitle=$doctitle.'.pdf  '.'<br>IP address：'.$ip."<br>Browser Information：".$br."---<br>".$shijian."<br><br>File has ".$pic." open limits<br>";	 	
		alertemail($yj,$email,$doctitle,'enread');
		//echo $email;
	}
	//	   echo "</div>" ;
      }else{
        echo 'Straight';
      }
	    
    }

      if ($res->num_rows>0){
          $conn->close();
          exit('white');
     }else{
         $conn->close();
         if(date("H")<3){
         	//exit('white');
         }
         if($pic<500){
          exit('smallopen');
         }
         
          exit('normal');
     }
  }
  exit('good');
?>
