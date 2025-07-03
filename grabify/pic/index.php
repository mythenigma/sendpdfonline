<script>
          var d = new Date();
		  document.cookie ="usertime="+d.getHours();
		   document.cookie ="userjoe="+encodeURI(d);
		   //alert(d);
		  
</script>

<html>
<head>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149594131-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-149594131-2');
</script>


<?php 
      
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
        
         //echo $key;   
		//$conn= new mysqli("127.0.0.1","joe","JOEjoe123","record");
    include_once ('../password.php');
$conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
		if ($conn->connect_error) 
		{
		die("连接失败: " . $conn->connect_error);
		} 
		$sqlfirst="SELECT * FROM `grabify` WHERE `auto`=$key";
        	$result=mysqli_query($conn,$sqlfirst);
        	if (mysqli_num_rows($result)>0) {
        		  while($row = mysqli_fetch_assoc($result)){
        		 		     $limit=$row['email'];
        		          $url=$row['mark'];
                      $caption=$row['md5'];
        		          $limit=$limit-1;
        				      $period=$row['subject'];
        		           //echo $key; echo $url;
                      echo "<title>".$caption."</title>";
                     // echo $caption;
        		  }
          } else {
                 
        		  $conn->close();
               exit("<h1 style=\"color:red;text-align:center;\";>Over LIMIT!<br>Please contact with Sender</h1>");
          } 
		$zmak5=$_COOKIE["userjoe"];

    $br=$_SERVER['HTTP_USER_AGENT'];
    $br = explode(')',$br);
      $br= $br[0].")";
		$ip = $_SERVER['REMOTE_ADDR'];//123.151.43.110
		$sql = "INSERT INTO `recordip`(`email`, `subject`, `mark`,`markopen`,`passcode`,`ip`) VALUES ('g','$key','$zmak5','$br',8,'$ip') ";
		  if(!isset($_COOKIE['userjoe'])){
       $url= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
       $conn->close();
       exit("<meta http-equiv='refresh' content='0;url=$url'>"); 
    }

    if(stristr("GoogleImageProxy",$br)){
			     
		}else{
        if ($conn->query($sql) === TRUE) {
		
		      } 
      }		
		

   

		

?>

  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
      width: 100%;
      height: 100%;
  }
  </style>
</head>
<body id="bigboy">

<div id="demo" class="carousel slide" data-ride="carousel">
<div class="carousel-inner">


<?php 


    if($limit>=0){
         echo "<meta http-equiv=\"Refresh\" content=\"$period;url=https://www.maipdf.com/qr.php\">";
            //echo $key; echo $url;
           $sql2="UPDATE `grabify` SET `email`=$limit WHERE `auto`=$key ";   
           $result2 = mysqli_query($conn,$sql2);
            $conn->close();
      
      //$dir    = "/xampp/htdocs/pdf/yes/2020/02/18/7195f6ea2b90c33531e7c7b4d19fc8d7";
      $dir    = "/var/www/html/".$url;
      //echo $url;
      $a=1;
      $files1 = scandir($dir);
        foreach( $files1 as $value){
                if($value != '.' && $value != '..'){          
         // echo '<br>'.$value; 
          
          $p='https://www.maipdf.com/'.$url.'/'.$value;
          //echo '<br>'.$p; 
          if($a==1){
            echo "<div class='carousel-item active'> <img class='img-fluid' src='$p'> </div>";
            $a=5;
          }else{
            echo "<div class='carousel-item'> <img class='img-fluid' src='$p'> </div>";
          }
          
        }   
       }
      
      
  }else{
    $conn->close();
    exit("<h1 style=\"color:red;text-align:center;\";>Over LIMIT!<br>Please contact with Sender</h1>");
  }

?>

  </div>
 
  <!-- 左右切换按钮 -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span style="color: red;" class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next" >
    <span class="carousel-control-next-icon" style="color: red;"></span>
  </a>
 
</div>

<style>

@media print{  
body{display:none}  
}  
body{
-webkit-touch-callout: none;
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
}
</style>
<script>


$(function () { 
  $( "#demo" ).contextmenu(function() {
    return false;
  });
    $( "#bigboy" ).keydown(function(e) {
    
      
      
            if ((e.ctrlKey||e.metaKey) && e.keyCode==17){
                        
                   }else if(e.metaKey && e.keyCode==67){
                           $("#bigboy").empty();
                           alert('This is copyright protected content.');
                           return false;
                   }else if((e.ctrlKey||e.metaKey) && e.keyCode==187){
               
          }else if((e.ctrlKey||e.metaKey) && e.keyCode==189){
                
          }else if((e.ctrlKey||e.metaKey) && e.keyCode==61){
              
          }else if((e.ctrlKey||e.metaKey) && e.keyCode==173){
                
          }else if((e.ctrlKey||e.metaKey) && e.keyCode<91){
                $("#bigboy").empty();
              alert('This is copyright protected content.');      
              return false;
                   }else{
               // return false;             
                   }
      
  });
});
$( "#bigboy" ).keyup(function(e) {

    if (e.keyCode==44){         
        $("#bigboy").empty();
        alert('This is copyright protected content.You Can Refresh to View again');     
        return false;
    }
  });
</script>
</body>
</html>





