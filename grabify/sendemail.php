




<?php 
//header("content-type:text/html; charset=utf-8");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
     
// sendoutemail('joe@malvyngroup.com','sdfasdfasdfasfd');

function sendoutemail($sendingemail,$zhuti){

    	$a=0;
    $mail = new PHPMailer(true); 
                          
try {



    $suiyi=99;
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'doc.maiimg.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
   


    $mail->Username = 'lot9@maitube.com';                 // SMTP username
    $mail->Password = 'JOEjoe123';                          
    //$mail->SMTPSecure = 'ssl';                            
    $mail->Port = 465;                                      
    $mail->CharSet='UTF-8';

   








	
   $suiyi=rand(1,107);

  if($suiyi==1){                            
    $mail->Username = 'maitube@189.cn'; 
    $mail->Password = 'JOEjoe123';
    $mail->Port = 587;  
    $mail->SMTPSecure = 'STARTTLS';  
    $mail->SMTPAuth = true; 
    $mail->Host = 'smtp.189.cn';              
  }elseif($suiyi==2){
      $mail->Username = 'maitube133@189.cn';
      $mail->Password = 'HAOhao123'; 
      $mail->Port = 587;  
      $mail->SMTPSecure = 'STARTTLS';  
      $mail->SMTPAuth = true; 
      $mail->Host = 'smtp.189.cn'; 
  }elseif($suiyi==3){
     $mail->Username = 'maitube173@189.cn';
     $mail->Password = 'JOEjoe123';
      $mail->Port = 587;  
    $mail->SMTPSecure = 'STARTTLS';  
    $mail->SMTPAuth = true; 
    $mail->Host = 'smtp.189.cn';

  }elseif($suiyi==4){
     $mail->Username = 'a0433681057@126.com';     
     $mail->Password = 'EYIPBNVOTKEKPYBS'; 
     $mail->SMTPSecure = 'ssl'; 
     $mail->Host = 'smtp.126.com';
     $mail->Port = 465;  
     $mail->SMTPAuth = true;     
  }elseif($suiyi==5){
     $mail->Username = '3095398979@qq.com';
     $mail->Password = 'lgefzivorrngdgag'; 
     $mail->SMTPSecure = 'ssl'; 
     $mail->Host = 'smtp.qq.com';
     $mail->Port = 465;   
     $mail->SMTPAuth = true;    
  }elseif($suiyi==6){
     $mail->Username = '3510064353@qq.com';
     $mail->Password = 'qslsurklyvcwdbaj'; 
     $mail->SMTPSecure = 'ssl'; 
     $mail->Host = 'smtp.qq.com';
     $mail->Port = 465;     
     $mail->SMTPAuth = true;  
  }else{
    $mail->Username = 'maitube9478@189.cn';
    $mail->Password = 'HAOhao123'; 
    $mail->Port = 587;  
      $mail->SMTPSecure = 'STARTTLS';  
      $mail->SMTPAuth = true; 
      $mail->Host = 'smtp.189.cn'; 
	
	
	
	$mail->Host = 'doc.maiimg.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'lot9@maitube.com';                 // SMTP username
    $mail->Password = 'JOEjoe123';                          
    $mail->SMTPSecure = '';                            
    $mail->Port = 587;  

    $mail->Username = 'freeman@doc.maiimg.com';                 // SMTP username
    $mail->Password = 'qweewq';                          
    $mail->SMTPSecure = 'ssl';                            
    $mail->Port = 465;                                    
    
  }



  $zhutifasong=explode('/', $zhuti);

	$shanchu= $zhutifasong[1].'/'.$zhutifasong[2].'/'.$zhutifasong[3].'/'.$zhutifasong[4].'/'.$zhutifasong[5];
  	$shanchupdf= $zhutifasong[1].'/'.$zhutifasong[2].'/'.$zhutifasong[3].'/'.$zhutifasong[4].'/';

	$zhutifasong=end($zhutifasong);
	
	$zhutifasong2=explode('.pdf', $zhutifasong);
	$zhutifasong=explode('.', $zhutifasong);
	if(sizeof($zhutifasong2)>1){
		//$shanchu= $zhutifasong[1].'/'.$zhutifasong[2].'/'.$zhutifasong[3].'/'.$zhutifasong[4].'/'.$zhutifasong[5];
		$shanchu= $shanchupdf.$zhutifasong2[0].'.pdf';
		$shanchu="https://qr.maitube.com/re.php?pdf=".$shanchu;
	}else{
		$shanchu="https://qr.maitube.com/re.php?p=".$shanchu;
	}


    if($sendingemail!='admin@maitube.com'){
      $zhutifasong[0]=$sendingemail;
    }
   if($sendingemail=='freeman@doc.maiimg.com'){
      $zhutifasong[0]='passwordForFile';
      $mail->addAddress('freeman@doc.maiimg.com');
    }
    $mail->setFrom($mail->Username, $zhutifasong[0]);
    

	$mail->AddBCC('chanzongfo@icloud.com');
    $mail->addAddress('412834749@qq.com');$mail->AddBCC('3510064353@qq.com'); 
	//$mailer->AddBCC("foo@gmail.com", "test");
	
     $mail->addReplyTo('admin@maitube.com', 'Information');    
     //date_default_timezone_set('etc/gmt-8');
    $datime=date("Y-m-d-H-i-s");
    
    $md=date("m/d");

    $newsubject=$zhutifasong[1].sizeof($zhutifasong1);
     
   //$newsubject=iconv("UTF-8", "GB2312", $newsubject);
   $mail->isHTML(true); 
   $mail->Subject = $newsubject.$zhutifasong[0];
    
  $zhutiti=$zhuti;
   $zhuti='https://pdf.maitube.com/pdf/'.$zhuti;


   $rich="<br>".$zhutiti."<br>"."https://qr.maitube.com/file2.php?y=$md<br>-------------<br>".$zhuti."<br>(".sizeof($zhutifasong2).")<br>";
   //$rich = $rich."<img src='$zhuti' alt='yyyy'>";
   $previewpicture="<img src='".$zhuti."'width='99%' height='auto' alt='xxx'>";
   //$track2="<img src='https://doc.maitube.com/pdf/yes/extra/2020/10/26/preview/流媒体市场咨询项目.pdf.jpg' alt='.'>";
   //$dibushan='<a href="'.$shnchu.''
   //$rich=$rich.$previewpicture.'<br>'.$shanchu;
   $rich=$previewpicture.$rich.'<br>'.'<br><br><br><a href="'.$shanchu.'">-----删____除------</a>'.$datime;
	
    $mail->Body=$rich;       
    $mail->AltBody ='sjdkf';

    $mail->send();

    $a=0;
    echo 'Message has been sent';
	 //sleep(1);$a=0;
    $a=1;
	} catch (Exception $e) {
		$a=0;
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}

	return $a;
}


function alertemail($sendingemail,$at,$bt,$attre){

	$a=0;
$mail = new PHPMailer(true); 
                          
try {

    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();   
    $mail->SMTPAuth = true;                                    // Set mailer to use SMTP
    


    $mail->Host = 'doc.maiimg.com';                    // Specify main and backup SMTP servers                              
    $mail->Username = 'lot10@maitube.com';                 // SMTP username
    $mail->Password = 'JOEjoe123';                          
   // $mail->SMTPSecure = 'ssl';                            
    $mail->Port = 465; 

    if(stristr($sendingemail, 'wasgmail')){
    	   $mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers                              
           $mail->Username = 'maipdfemailalert@gmail.com';                 // SMTP username
           $mail->Password = 'wofocibei';                          
           $mail->SMTPSecure = 'ssl';                            
           $mail->Port = 465; 
             $mail->Username = 'a0433681057@126.com';     
		     $mail->Password = 'EYIPBNVOTKEKPYBS'; 
		     $mail->SMTPSecure = 'ssl'; 
		     $mail->Host = 'smtp.126.com';
		     $mail->Port = 465;  
		     $mail->SMTPAuth = true; 
		   /*  $mail->Username = 'email@maipdf.com';     
		     $mail->Password = 'qweewq'; 
		     $mail->SMTPSecure = ''; 
		     $mail->Host = '13.251.125.241';
		     $mail->Port = 5555;  
		     $mail->SMTPAuth = false; */
    }


    $mail->CharSet='UTF-8';

    $mingzi='来自MaiTube的邮件提醒';
    $datime=date("Y-m-d-H-i-s");
    
    if($attre=='approve'){
    	$newsubject=$at.'已经验证了';
    	 $mingzi='MaiTube:验证了';
    }elseif($attre=='read'){
    	$newsubject=$at.'有新的阅读记录';
    	$mingzi='MaiTube:新增阅读记录';
    }elseif($attre=='maipdf'){
    	$newsubject=$at.':PDF已经添加了邮件提醒';
    	$mingzi='MaiTube:设置了PDF阅读记录';
    	$identifier2='joe'.$bt; $identifier3='thank you@'.$bt;
    	$identifier2=crypt($identifier2,'su'); 
		$at2="https://maiimg.com/dec/".$at."@pdf";	
    	$bt2 = "https://maitube.com/pdf/haha.php";
    	$bt3 = "https://maipdf.com/pdf/hahachange.php";
    }elseif($attre=='mairead'){
    	$newsubject=$at.':PDF有新的阅读行为';
    	$mingzi='MaiTube:MaiPDF新增阅读记录';
    	$identifier2='joe'.$at; 
		$identifier3='thank you@'.$at;
    	$identifier2=crypt($identifier2,'su');
    	//$at2="https://maifile.cn/pdf/".$at.".pdf";
    	$at2="https://maiimg.com/dec/".$at."@pdf";	
    	$bt2 = "https://maitube.com/pdf/haha.php";
    	$wenjianname=$bt;
    	$bt3 = "https://www.maipdf.com/pdf/hahachange.php";
    }elseif($attre=='enread'){
    	$newsubject=$at.':PDF has new reading behaviour';
    	$mingzi='MaiPDF has new read';
    	$identifier2='joe'.$at; $identifier3='thank you@'.$at;
    	$identifier2=crypt($identifier2,'su');
    	$at2="https://maipdf.com/doc/".$at.".maipdf";
    	$bt2 = "https://maipdf.com/pdf/haha.php";
    	$wenjianname=$bt;
    	$bt3 = "https://www.maipdf.com/pdf/hahachange.php";
    }else{
    	 $mingzi='来自MaiTube的邮件提醒';
         $newsubject=$at.'(已经添加了邮件提醒)';
    }
    $previewpicture="<img src='https://doc.maitube.com/bulk/400.jpeg'  width='504' height='678' alt='MaiTube'><br>";
    $previewpicture2="<br><img src='https://maitube.com/read/pic/wegroup.jpeg' width='504' height='678' alt='MaiTube'>";
    $at = "https://qr.maitube.com/img/".$at;
    $bt = "https://whatstheirip.tech/".$bt;
    $rich="<br>"."图片打开链接是: ".$at."<br><br>打开记录链接是: ".$bt."<br>".$datime."注意垃圾邮箱<br>谢谢您对MaiTube网站的支持<br>".$previewpicture.$previewpicture2;
    
    if($attre=='maipdf' || $attre=='mairead'||$attre=='vectorpdf' || $attre=='vectorread'){
    	$rich=$wenjianname."<br>"."<br>https://whatstheirip.tech/iplookup.php 可查看IP归属<br>PDF阅读链接是: ".$at2."<br><br>打开记录链接是: ".$bt2."<br><br><br>修改文件设置的链接是: https://maipdf.com/pdf/hahachange.php <br><br> 修改码：".$identifier2."<br>注意垃圾邮箱<br>谢谢您对MaiTube网站的支持<br>".$previewpicture.$previewpicture2.$identifier3;
    }
    if($attre=='enread'){
    	$rich=$wenjianname."<br>"."PDF link: ".$at2."<br><br>Open Record: ".$bt2."<br><br><br>File Change: https://maipdf.com/pdf/hahachange.php <br><br> ModificationCode：".$identifier2."<br>Mind your Spam<br>Thanks for your support to MaiPDF<br>";
    }


   // https://qr.maitube.com/blog/ad.jpeg
   
    $mail->setFrom($mail->Username,$mingzi);
    $mail->addAddress($sendingemail);
    $mail->AddBCC('3095398979@qq.com');	
    $mail->addReplyTo('admin@maitube.com', 'Information');  

	$mail->isHTML(true); 
    $mail->Subject = $newsubject;
    $mail->Body=$rich;       
    $mail->AltBody ='sjdkf';

    $mail->send();
   
    $a=0;
    echo 'Message has been sent';
	 //sleep(1);$a=0;
      //  $file=fopen("/var/www/html/register/mail.txt","a+");
       // fwrite($file, "$sendingemail ok  $datime\r\n");
       // fclose($file);
    $a=1;
	} catch (Exception $e) {
		$a=0;
        //$file=fopen("/var/www/html/register/mail.txt","a+");
        //fwrite($file, "$mail->Username siqiaoqiao  $datime \r\n");
       // fclose($file);
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}

      
	    return $a;
}



//testemail($big);
function testemail($big)
{

  $a=0;
$mail = new PHPMailer(true); 
                          
try {

    $mail->SMTPDebug = 4;                                 // Enable verbose debug output
    if(strstr($big['username'], '@hotmail.com')){	
	}else{
	$mail->isSMTP();
	}
	// Set mailer to use SMTP
    $mail->Host = $big['host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $big['username'];                // SMTP username
    $mail->Password = $big['emailpassoword'];                        
    $mail->SMTPSecure = $big['secure'];     

    //mama$mail->SMTPSecure = '';                         
    $mail->Port = $big['port'];                                   
   // $mail->CharSet='gb2312';
  






    $mail->setFrom($mail->Username, 'Maitube');
  //  if($type=1){
        $mail->addAddress('admin@maitube.com');
  //  }
     $mail->addReplyTo('admin@maitube.com', 'Information');    
     date_default_timezone_set('etc/gmt-8');
    $datime=date("Y-m-d-H-i-s");
   // $md=md5($sendingemail);
   $newsubject="Thank you For Testing"."<br>"."http://www.maitube.club";

   $newsubject=iconv("UTF-8", "GB2312", $newsubject);
   $mail->isHTML(true); 
   $mail->Subject = $newsubject;
   $rich="Please Continue your account/账号测试通过"."<br>";

   $rich=iconv("UTF-8", "GB2312", $rich);
  // $maitube=iconv("UTF-8", "GB2312", $maitube);
   // $rich=$rich.$maitube.$track;
  
    $mail->Body=$rich;       
    $mail->AltBody ='sjdkf';

    $mail->send();

    $a=0;
    echo 'Message has been sent';
   //sleep(1);$a=0;
    $a=1;
  } catch (Exception $e) {
    $a=0;
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
  }
//header("http://www.maitube.club/register/include.php");
  return $a;
   // echo "＜meta http-equiv=\"Refresh\" content=\"2；URL=www.baidu.com\"＞";
}
//sendoutemail('522609126@qq.com');＜meta http-equiv="Refresh" content="2；URL=http://www.net.cn/"＞  


?>





