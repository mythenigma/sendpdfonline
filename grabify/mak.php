
<?php 
//header("Location: http://ifread.com");
 // echo '5678';
ini_set("display_errors", true);
         ini_set("html_errors", true); 
session_start();
 
if(isset($_SESSION['views']))
{
    $_SESSION['views']=$_SESSION['views']+1;
}
else
{
     $_SESSION['views']=1;
}


if($_SESSION['views']>90){
  exit();
}
if($_SESSION['views']<2 ){
  //echo $_SERVER['HTTP_REFERER'];
  exit('no ses');
}
$sessionView = (int)$_SESSION['views'];

  $type=0;
  if(isset($_GET['i'])){
          $key= htmlspecialchars($_GET['i']);
          if(stristr($key, 'grabify') ){
              exit('Failed');
          }
		  
		 if($key !='mm'){ 
		  $headers = @get_headers($key);
		/*  if($headers || strpos( $headers[7], '200')) {
			 // exit('Goooder url');
				$type=1;
			} else {
				print_r($headers);
				exit('The Enterted URL is not Reachable:The Enterted URL is not Reachable:The Enterted URL is not Reachable');
			}  */
		 }
		  $type=1;
          
    }elseif(isset($_GET['del'])){
         $key= htmlspecialchars($_GET['del']);
         //$key = (int)$key;
         $type=2;
    }elseif(isset($_GET['update'])){
         $newurl= htmlspecialchars($_GET['update']);
        if(stristr($newurl, 'grabify') ){
                      exit('Failed');
                  }
         $key= $_COOKIE["id"];$keystring=$key;$key = (int)$key;
         $type=3;
    }else{
       exit('Failed');
    }


   //$conn= new mysqli("127.0.0.1","joe","JOEjoe123","record");
   include_once ('password.php');
   $conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
		if ($conn->connect_error) {
		   die("连接失败: " . $conn->connect_error);
        } 
         if($type==2){
            $sqldel= "DELETE FROM `recordip` WHERE `subject`='$key'";
            $result1 = mysqli_query($conn, $sqldel);
            $conn->close();
            exit('Good');
         }
         if($type==3){
            $sqlupdate= "UPDATE `grabify` SET `mark`='$newurl',`subject`=$sessionView  WHERE `auto`=$key ";
            $resultupdate = mysqli_query($conn, $sqlupdate);
           // $conn->close();
            exit('Good');
         }
           if($type==1){



                 $zmak5=date("Y/m/d+H:i:s").$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'];
                 $zmak5=md5($zmak5);
                  if(isset($_GET['v'])) {
                    $cn=1;
                    $zmak5=$zmak5.'1';
                  }else{
                    $cn=2;
                  }
              
                 $sql2 = "INSERT INTO `grabify`( `email`,`subject`,`mark`,`md5`) VALUES ($sessionView,$cn,'$key','$zmak5') ";
				// echo $sql2;  
				 
                 $result1 = mysqli_query($conn, $sql2);
                 $sql1= "SELECT `auto` AS `id` FROM `grabify` WHERE `md5`='$zmak5'";
                 $result1 = mysqli_query($conn, $sql1);
                 $maxid = mysqli_fetch_assoc($result1);
                 $maxid= $maxid['id'];
                 $conn->close();
       
              $arr1 = str_split($maxid);
              $i=0;
             foreach($arr1 as $value){
                $value = (int)$value;
               if($value==0){
                 $value=10;
               }
                $arrayA[$i]= chr(64+$value);
                $arrayB[$i]= chr(64+10+$value);
                 $i++;
              }
              //print_r($arrayA);print_r($arrayB);
              $typeA=implode("", $arrayA);
              $typeB=implode("", $arrayB);
              echo $maxid.':'.$typeA.':'.$typeB;
        }
?>

