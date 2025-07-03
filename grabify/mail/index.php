<?php 
       date_default_timezone_set('Etc/Greenwich');
		if(isset($_GET['i'])){
		 //  $key= htmlspecialchars($_GET['i']);
		}else{
		//	$key='maitube';
		}

       if(isset($_SERVER['QUERY_STRING'])){
            $key= $_SERVER["QUERY_STRING"]; 
        }else{
           $key='ZZ';
        }
		

      $arr = str_split($key);
       $i=0;
       foreach($arr as $value){
           $atype= ord($value)-64;
         if($atype==10){
           $atype=0;
         }
          $akey[$i]=$atype;
          $i++;
       }
        $key=implode("", $akey);
        
            
		$conn= new mysqli("127.0.0.1","joe","JOEjoe123","record");
		

		    $servernameMai = "121.37.25.53";
			$usernameMai =  "yesjoe2";
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
		if(stristr("GoogleImageProxy",$br)){
			
		}else{
        if ($conn->query($sql) === TRUE) {
			//echo "<meta http-equiv=\"Refresh\" content=\"0.1;url=https://www.maitube.com\">";	
			//	echo "这是个看看你在哪的小工具<br>注册用户可以显示任意网页";
				//echo "<meta http-equiv=\"Refresh\" content=\"5.1;url=https://www.maitube.com/index-old.php\">";	
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

