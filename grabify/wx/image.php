<?php 
       date_default_timezone_set('Etc/Greenwich');
		if(isset($_GET['name'])){
		   $pnger= htmlspecialchars($_GET['name']);
		}else{
			$pnger='maitube';
		}

	  $arr = str_split($pnger);
       $i=0;
	    //echo $arr;
       foreach($arr as $value){
		 //  echo $value.
           $atype= ord($value)-64;
         if($atype==10){
           $atype=0;
         }
          $akey[$i]=$atype;
          $i++;
       }
	  
	   //exit();
        $key=implode("", $akey);
        
 
$servernameMai = "t.maitube.com";
$usernameMai =  "joe";
$passwordMai =  "JOEjoe123";
$dbnameMai =    "maipdf";
       $conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
		if ($conn->connect_error) 
		{
		die("连接失败: " . $conn->connect_error);
		} 
		$conn->query("set names 'utf8'");
		$zmak5=date("Y/m/d+H:i:s");
		$br=$_SERVER['HTTP_USER_AGENT'];
		$ip = $_SERVER['REMOTE_ADDR'];//123.151.43.110
		$sql = "INSERT INTO `recordip`(`email`, `subject`, `mark`,`markopen`,`passcode`,`ip`) VALUES ('g','$key','$zmak5','$br',8,'$ip') ";
		//exit($sql);
		if(stristr("GoogleImageProxy",$br)){
			
		}else{
        if ($conn->query($sql) === TRUE) {
		
		} else {
								         	
		}
      }		
		$conn->close();
		



$im = imagecreatetruecolor(1, 1);
$text_color = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 1, 5, 5,  'A ', $text_color);

// 设置内容类型标头 —— 这个例子里是 image/jpeg
header('Content-Type: image/jpeg');

// 输出图像
imagejpeg($im);

// 释放内存
imagedestroy($im);
?>

