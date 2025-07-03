

<?php 

   exit("<meta http-equiv='refresh' content='0;url=https://maipdf.com/qr.php#pic'>"); 
$str = 'This is a "sample string".';
            
   if(!empty($_FILES) ){
    $zmak5=date("Y/m/d+H:i:s");
    $identifier='Not';
    $year= date("Y");
    $month= date("m");
    $week=  date("d");

    $picplace=$_COOKIE["uploadid"];
    //$picplace=$content;
    setcookie("pl", $picplace, time()+3600,'/');

    $fileplace="/var/www/html/pdf/yes/".$year."/".$month."/".$week."/".$picplace."/";
    $url=$fileplace;
    		if (!is_dir($fileplace)){
    		  if (!mkdir($fileplace, 0777, true)) {
                  die('Failed to create folders...');
              }
    		}		
    		
    $pictures = $_FILES["filename"]["tmp_name"];
     move_uploaded_file($_FILES["file"]["tmp_name"], $fileplace. $_FILES["file"]["name"]);
      
}
		$beforelog='nogent';
		$ip = $_SERVER['REMOTE_ADDR'];
		$zmak5=date("Y/m/d+H:i:s");
		$content=$beforelog."~".$zmak5."~".$ip;
		$content=md5($content);
		//echo '<br><br><br><br><br><br><br>content: '.$content.'<br>';
		//echo '<br>cookie: '.$_COOKIE['uploadid'];
		//echo '<br>already'.$_COOKIE['upalready'];
		if(isset($_COOKIE['pl'])){

					$md=$_COOKIE['pl'];
				}else{
					
					$md='bad';
				}
				//echo $_COOKIE['upalready'].'*';
	     
	  // echo '<br>pl cookie: '.$_COOKIE['pl'];
       	
    if(isset($_COOKIE['uploadid']) && isset($_POST['caption']) &&isset($_POST['password'])){
				//$identifier= 'meiyou what is the file?';   
               if(isset($_POST['limit'])){
					$limit=	$_POST['limit'];
				}else{
					//exit('nononononononono');
					$limit=10;
				}
				if(isset($_POST['password'])){
				     $password=$_POST['password'];
				 }else{
					 $password=127;
				 }
                if(isset($_POST['caption'])){
				     $jieshao=$_POST['caption'];
                        //$subject= preg_replace("/(\r|\n)/","",$subject);
                      $jieshao=str_replace("'","",$jieshao);
                      $jieshao=str_replace('"','',$jieshao);
   
				 }else{
					 $jieshao='It is a Picture';
				 }


				    $year= date("Y");
                     $month= date("m");
                     $week=  date("d");
                     
                     //$md = $_COOKIE['upalready'];
                    $theplace="/var/www/html/pdf/yes/".$year."/".$month."/".$week."/".$md;
                    //echo 'md5: '.$md.'<br>';
                    $dir  = $theplace;

                    if(!is_dir($dir)){
							
                             $url= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
							 exit($dir);
                              //exit("<meta http-equiv='refresh' content='0;url=$url'>"); https://grabify.icu/qr.php#pic
                        
                    }
                    $conn= new mysqli("213.136.92.253","joe","JOEjoe123","record");
                    include_once ('password.php');
$conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
					if($conn->connect_error){
						die("CANNOT INSERT");
					}
                    $theplace="pdf/yes/".$year."/".$month."/".$week."/".$md;
                    $sqlinsert="INSERT INTO `grabify`(`email`,`subject`,`mark`,`md5`) VALUES($limit,$password,'$theplace','$jieshao')";
                     $result=mysqli_query($conn,$sqlinsert);
                        //setcookie("uploadid", "", time()-3600);
                        //setcookie("upalready", "", time()-3600);
                     $sqlnumber =" SELECT  `auto`  FROM  `grabify`  WHERE  `mark` LIKE  '%$md' ";
                     $sqlnumber =" SELECT  `auto`  FROM  `grabify`  WHERE  `mark` LIKE  '%$theplace%' ";
                    //$sqlnumber =" SELECT  `auto` FROM record.`grabify` WHERE `mark`='pdf/yes/2020/07/04/a7dc7c83399fc789390a94c9f3a3adfb' ";
                     //echo $sqlnumber;
                     	echo "<script>  $(\"#pic\").hide(); </script>";
                     $result1 = mysqli_query($conn, $sqlnumber);
                     //print_r($result1);
	                 $maxid = mysqli_fetch_assoc($result1);
	                // print_r($maxid);
	                 $identifier= $maxid['auto'];
	                 $conn->close();

				 }else{
                        
				 	$identifier= 'xxxxxxxxxxx';
				 	setcookie("uploadid", $content, time()+3600,'/');
                 }
	
         //echo 'identifier: '.$identifier;
?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="qr,qr pdf share,qr grabify,qr image,pdf expired">
  <meta name="description" content="Professional QR Maker,Better way to Grabify,MaiPDF share PDF with Free DRM solution ">
   <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <meta name="Joe" content="MaiPDF">
  <title>QR Code Generator | Share Track Your Pictures with QR Codes</title>

  <!-- Font Awesome Icons -->

<link href="https://cdn.staticfile.org/font-awesome/5.13.1/css/all.min.css" rel="stylesheet" type="text/css">
 
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
  <!-- Plugin CSS -->
  <link href="https://maipdf.com/pdf/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

  <!-- Theme CSS - Includes Bootstrap -->
  <link href="https://maipdf.com/pdf/css/creative.min.css" rel="stylesheet">
 <!-- Google Analytics -->
 <meta name="msvalidate.01" content="9696AEE47B216F6BE523F1C5D5119DB8" />
<!--   -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149594131-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-149594131-2');
</script>
<script src="https://maipdf.com/pdf/js/dropzone/dropzone.js"></script>
<script src="https://maipdf.com/pdf/js/dropzone/dropzone-amd-module.js"></script>
    <link rel="stylesheet" href="https://maipdf.com/pdf/js/dropzone/dropzone.css">
<link rel="stylesheet" href="https://maipdf.com/pdf/js/dropzone/basic.css">
</head>

<body id="page-top">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" style="color: Blue;" href="https://maipdf.com">MaiPDF QR</a>
	  
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
       <!-- <span class="navbar-toggler-icon"></span>-->
		
		<span style="color: Red;"> <i class="fas  fa-th "></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
         
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://maipdf.com/pdf/boot.php">Secure PDF</a>
           </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#wifi">WiFi</a>
           </li>
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#sms">SMS</a>
           </li>
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#url">URL</a>
           </li>
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#phone">Phone</a>
           </li>
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#pic">Images</a>
           </li>
        </ul>
      </div>
    </div>
  </nav>
 <section class="page-section" id="services">
    <div class="container">
      <h2 class="text-center mt-0">MaiPDF QR Code Generator</h2>
      <hr class="divider my-4">
      <div class="row">
	  
        <div class="col-3 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#wifi">
            <i class="fas fa-4x fa-wifi text-primary mb-4"></i>
            <h3 class="h4 mb-2">WiFi</h3>
            </a>
          </div>
        </div>
        <div class="col-3 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#sms">
            <i class="fas fa-4x fa-sms text-primary mb-4"></i>
            <h3 class="h4 mb-2">SMS</h3>
           </a>
          </div>
        </div>
        <div class="col-3 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#url">
            <i class="fas fa-4x fa-link text-primary mb-4"></i>
            <h3 class="h4 mb-2">URL</h3> 
        </a>
          </div>
        </div>
        <div class="col-3 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#phone">
             <i class="fas fa-4x fa-phone-alt text-primary mb-4"></i>
            <h3 class="h4 mb-2">Phone</h3> 
            </a> 
          </div>
        </div>
         <div class="col-3 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#pic">
            <i class="fas fa-4x fa-images text-primary mb-4"></i>
            <h3 class="h4 mb-2">Images</h3>
            </a>  
          </div>
        </div>
         <div class="col-3 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="https://maipdf.com/pdf/boot.php">
             <i class="fas fa-4x fa-file-pdf text-primary mb-4"></i>
            <h3 class="h4 mb-2">PDF</h3> 
        </a>
          </div>
        </div>
      </div>
	<h5 class="text-center mb-3">	
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2020 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:375px;height:90px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="8827112243"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</h5>
    </div>
  </section>
<section class="page-section" id="wifi">
    <div class="container">
      <h2 class="text-center mt-0">WiFi QR Code Generator</h2>
      <hr class="divider my-4">
                       <span class="input-group-addon">Wi-Fi SSID</span>
						<input type="text" class="form-control" id="myInput1" placeholder="Please Enter WiFI Name SSID">
					
						<span class="input-group-addon">Encryption(Default)</span>
						<input type="text" class="form-control" id="myInput2" value="WPA/WPA2">

						<span class="input-group-addon">Password</span>
						<input type="text" class="form-control" id="myInput3" placeholder="Enter Password For Your WiFi">
							
				        <h2 class="text-center">
					    <button type="button" class="btn btn-warning" onclick="makeCode()">Generate QR</button>
						</h2>
					<h2 class="text-center">
					   <div id="qrcode" class="btn btn-default btn-xl"></div>
					</h2>    
   

 <h5 class="text-center mb-3">	
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2020 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:375px;height:90px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="8827112243"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</h5>
    </div>
</section>
  
  
<section class="page-section" id="sms">
    <div class="container">
      <h2 class="text-center mt-0">SMS QR Code Generator</h2>
      <hr class="divider my-4">
        <span class="input-group-addon">Mobile Number</span>
			<input type="number" class="form-control" id="smsNumber" placeholder="Enter Mobile Phone Number">
			
			
			
			
			<div class="form-group">
              <label for="smsContent">SMS:</label>
			  <textarea class="form-control" rows="5" id="smsContent"></textarea>
			</div>
			<h2 class="text-center">
					    <button type="button" class="btn btn-warning" onclick="makeCode()">Generate QR</button>
			</h2>
			<h2 class="text-center">
				<br><div id="smsCode" class="btn btn-default btn-xl"></div>
			</h2>              
   

<h5 class="text-center mb-3">	
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2020 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:375px;height:90px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="8827112243"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</h5>
    </div>
</section>  
  
  
 <section class="page-section" id="phone">
    <div class="container">
      <h2 class="text-center mt-0">Phone QR Code Generator</h2>
      <hr class="divider my-4">
        <span class="input-group-addon">Phone Number</span>
		 <input type="text" class="form-control" id="telinput">
		 <h2 class="text-center">
		<button type="button" class="btn btn-warning" onclick="makeCodeweb()">Generate QR</button>
		</h2>
		 <h2 class="text-center">
	        <br> <div id="qrcodetel" class="btn btn-default btn-xl"></div>
	     </h2>      
   

 <h5 class="text-center mb-3">	
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2020 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:375px;height:90px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="8827112243"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</h5>
    </div>
</section>   
  
  <section class="page-section" id="url">
    <div class="container">
      <h2 class="text-center mt-0">URL QR Code Generator</h2>
      <hr class="divider my-4">
        <span class="input-group-addon">Enter Full URL</span>
		 <input type="text" class="form-control" id="webinput" value="https://">
		 <h2 class="text-center">
		<button type="button" class="btn btn-warning" onclick="makeCodeweb()">Generate QR</button>
		</h2>
		 <h2 class="text-center">
	     <br><div id="qrcodeweb" class="btn btn-default btn-xl"></div>
	     </h2>  
   

 <h5 class="text-center mb-3">	
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2020 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:375px;height:90px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="8827112243"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</h5>
    </div>
</section> 

<section class="page-section" id="pic">
    <div class="container">
      <h2 class="text-center mt-0">Images QR Code Generator</h2>
      <hr class="divider my-4">
     
		<div class="form-group">
          <label class="title" id="pleaseupload">Up to 9 pictures</label>
             <div id="dropz" class="dropzone" style="font-weight:900;border-style:dashed;border-width:5px;background-image: linear-gradient(#e66465, #9198e5);"> 
            </div>
         </div>
         <input type="hidden" name="file_id" ng-model="file_id" id="file_id"/>
      <form class="md-form" action="qr.php#picqrcoder" method="post" enctype="multipart/form-data">
		   <div class="row">  
							<div class="col-6 col-md-3 text-center">
							  <div class="mt-5">
								<i class="fas fa-2x fa-folder-open text-primary mb-4"></i>
								<h5 class="h5 mb-2">Number of opens</h5>
								<p class="text-muted mb-0"><input class="form-control"  type="text"  name="limit" placeholder="Integer Number to Read"></p>
							  </div>
							</div>
							<div class="col-6 col-md-3 text-center">
							  <div class="mt-5">
								<i class="fas fa-2x fa-hourglass-start text-primary mb-4"></i>
								<h5 class="h5 mb-2">Each Reading Time</h5>
								<p class="text-muted mb-0"><input class="form-control"  type="text"  name="password" placeholder="in (seconds)"></p>
							  </div>
							</div>
                            	<div class="col-6 col-md-3 text-center">
							  <div class="mt-5">
                                  <i class="fas fa-2x fa-edit text-primary mb-4"></i>
								<h5 class="h5 mb-2">Picture Describtion</h5>
								<p class="text-muted mt-1"><input class="form-control"  type="text"  name="caption" placeholder="Few Words"></p>
							  </div>
							</div>
                                <div class="col-6 col-md-3 text-center">
							  <div class="mt-5">
                                  <i class="fas fa-2x fa-paper-plane text-primary mb-4"></i>
								<h5 class="h5 mb-2">Making Up URL/QR</h5>
								<input type="submit" name="submit" value="Generate" class="btn btn-warning">
							  </div>
							</div>
						  </div>  
       
     </form>
<script>

var appElement = document.querySelector('div.inmodal');
    var myDropzone = new Dropzone("#dropz", {
        url: "qr.php",//文件提交地址
        method:"post",  //也可用put
        paramName:"file", //默认为file
        maxFiles:9,//一次性上传的文件数量上限
        maxFilesize: 50, //文件大小，单位：MB
        acceptedFiles: ".png,.jpg,.jpeg,.gif,image/*", //上传的类型
        addRemoveLinks:true,
        parallelUploads: 9,//一次上传的文件数量
        //previewsContainer:"#preview",//上传图片的预览窗口
       dictDefaultMessage:'Drag or Click to Upload',
        dictMaxFilesExceeded: "Max With 9 Files！",
        dictResponseError: 'Failed!',
        dictInvalidFileType: "only with *.pdf,*.png,*.jpeg。",
        dictFallbackMessage:"You have an Antique Browser",
        dictFileTooBig:"Reach Size Limit.",
        dictRemoveLinks: "Delete",
        dictCancelUpload: "Cancel",
		timeout: 192000,
        init:function(){
          
            this.on("addedfile", function(file) {
                //上传文件时触发的事件
                document.querySelector('div .dz-default').style.display = 'none';
            });
            this.on("success",function(file,data){
				document.getElementById("pleaseupload").innerHTML ="Good" ;
                 angular.element(appElement).scope().file_id = data.data.id;
            });
            this.on("error",function (file,data) {
                //上传失败触发的事件
                console.log('fail');
                var message = '';
        
                if (file.accepted){
                    $.each(data,function (key,val) {
                        message = message + val[0] + ';';
                    })
                    //控制器层面的错误提示，file.accepted = true的时候；
                    alert(message);
                }
            });
            this.on("removedfile",function(file){
                //删除文件时触发的方法
                var file_id = angular.element(appElement).scope().file_id;
                if (file_id){
                    $.post('/admin/del/'+ file_id,{'_method':'DELETE'},function (data) {
                        console.log('Result:'+data.message);
                    })
                }
                angular.element(appElement).scope().file_id = 0;
                document.querySelector('div .dz-default').style.display = 'block';
            });
          
        }
    });

</script>

 

    </div>
</section> 

<?php




			
				 
			/*					$identifier=$url.rand(0,100);
					$identifier=md5($identifier);
					$identifier=crypt($identifier,'pq');
					$day=date('Y-m-d');			
					$conn= new mysqli("213.136.92.253","joe","JOEjoe123","record");
					if($conn->connect_error){
						die("CANNOT INSERT");
					}
					
					if ($password<1){
						 $password=127;
					}
					if ($limit<1){
						 $limit=10;
					}
					
					$sql="INSERT INTO `picture` VALUES('$identifier','$url',$password,$limit,'$day')";
					//echo $sql;
					echo "<h5 class=\"text-center\">https://www.maipdf.com/re.php?email=".$identifier."</h5>";
					//$result=mysqli_query($conn,$sql);
					 $conn->close();		
       */

	  
?>

<section class="page-section" id="picqrcoder">
    <div class="container">
      <h2 class="text-center mt-0">QR Code For Pictures has Generated</h2>
      <hr class="divider my-4">
	   <?php  
	   	if($identifier!='xxxxxxxxxxx'){
	      
	      
	      $identifier= (string)$identifier;
          $arr1 = str_split($identifier);
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
		   echo "<h5 class='h5 mb-2 text-center'><span id='alei'>".$typeA."</span>*******<span id='blei'>".$typeB."</span></h5>";
		  // <h5 class="h5 mb-2">URL/QR</h5>
		   echo  "<script> $('#pic').hide(); var at='".$typeA."';var bt='".$typeB."';</script>";
	   	}else{

	   		 $typeA='Reader';
		     $typeB='Tracker';
	   		echo "<h5 class='h5 mb-2 text-center'><span id='alei'>"."Reader"."</span>*******<span id='blei'>"."Tracker"."</span></h5>";
	   		echo  "<script>  var at='Reader'; var bt='Tracker';</script>";
	   	}

	   ?>
        <h5 id='Copied'></h5>
		 <input type="text" class="form-control" id="webinputpic" value=<?php  echo "https://maipdf.com/pic/".$typeA; ?> >
		 <h2 class="text-center">
		<button type="button" class="btn btn-warning" onclick="myFunctionpic()">Copy Link</button>
		</h2>
		 

        <div class="row">
          <div id='xingxi' class="col-12 col-md-6 text-left">
	        <p id='atype'></p>
            <p id='btypesay'></p>
            <p id='btype'></p>
         </div>
         <div class="col-12 col-md-5 text-center">
	            QR code to URL<br><div id="qrcodewebpic" class="btn btn-default btn-xl"></div>
         </div> 
	     </div>

		
   

 <h5 class="text-center mb-3">	
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2020 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:375px;height:90px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="8827112243"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</h5>
    </div>
</section>  

  <!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
    	<a href='https://www.maipdf.com'><div class="small text-center ">MaiPDF Home</div></a>
      <div class="small text-center text-muted">Copyright &copy; 2020 - admin@maitube.com</div>
	  <a href='https://www.maipdf.com/js/'><div class="small text-center ">Support by MaiTube</div></a>
    </div>
  </footer>

 
	
<script type="text/javascript" src="https://maipdf.com/pdf/qrcode.min.js"></script>
<script>




document.getElementById("atype").innerHTML="Picture Link: <br>"+"<a href=https://maipdf.com/pic/"+at+" target=\"_blank\">https://maipdf.com/pic/"+at+"</a>";
 document.getElementById("btypesay").innerHTML="Tracking Code: "+bt;
 document.getElementById("btype").innerHTML="Tracking Link: <br>"+"<a href=https://grabify.icu/"+bt+" target=\"_blank\">https://grabify.icu/"+bt+"</a>";




var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 170,
	height : 170,
  colorDark : "#000000",
  colorLight : "#ffffff",
  correctLevel : QRCode.CorrectLevel.H
});
var smsCode = new QRCode(document.getElementById("smsCode"), {
	width : 170,
	height : 170,
  colorDark : "#000000",
  colorLight : "#ffffff",
  correctLevel : QRCode.CorrectLevel.H
});


function makeCode () {		
	var elText1 = document.getElementById("myInput1");
	var elText2 = document.getElementById("myInput2");
	var elText3 = document.getElementById("myInput3");
	var textnumber  =   document.getElementById("smsNumber");
	var textcontent  =  document.getElementById("smsContent");
	var smstotal = "smsto:"+textnumber.value+":"+textcontent.value;
	var elText =  "WIFI:S:"+elText1.value+";T:"+elText2.value+";P:"+elText3.value+";";
	qrcode.makeCode(elText);
	smsCode.makeCode(smstotal);
}
makeCode();
//makeSMS();

//SMS
$("#smsContent").
	on("blur", function () {
		makeCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCode();
		}
	});




$("#myInput3").
	on("blur", function () {
		makeCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCode();
		}
	});
</script>

<script>
var qrcode2 = new QRCode(document.getElementById("qrcodeweb"), {
	width : 170,
	height : 170,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});
var qrcodepic = new QRCode(document.getElementById("qrcodewebpic"), {
	width : 170,
	height : 170,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});
var codetel = new QRCode(document.getElementById("qrcodetel"), {
	width : 170,
	height : 170,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});
function makeCodeweb () {
	var tel = document.getElementById("telinput");
	var web = document.getElementById("webinput");
	var webpic = document.getElementById("webinputpic");
	qrcode2.makeCode(web.value);
	qrcodepic.makeCode(webpic.value);
	codetel.makeCode(tel.value);
}
makeCodeweb();
$("#webinput").
	on("blur", function () {
		makeCodeweb();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCodeweb();
		}
	});
 $("#webinputpic").
	on("blur", function () {
		makeCodeweb();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCodeweb();
		}
	});
$("#telinput").
	on("blur", function () {
		makeCodeweb();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCodeweb();
		}
	});
</script>

	   <script>
	  function myFunctionpic() {
  /* Get the text field */
 
  var copyText = document.getElementById("webinputpic");
  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  document.getElementById("Copied").innerHTML = "Copied";
}
	 </script> 



  <!-- Bootstrap core JavaScript -->
  <script src="https://maipdf.com/pdf/vendor/jquery/jquery.min.js"></script>
  <script src="https://maipdf.com/pdf/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="https://maipdf.com/pdf/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="https://maipdf.com/pdf/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="https://maipdf.com/pdf/js/creative.min.js"></script>

</body>

</html>
