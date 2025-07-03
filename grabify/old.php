<script>
          var d = new Date();
		  document.cookie ="usertime="+d;
		  document.cookie ="userjoe="+d;
		  
</script>


<?php  
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
echo strlen($ip);
exit($ip);

if(!isset($_SERVER['HTTPS'])){
	
   $url= 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit();
}  
  //https://www.cnblogs.com/phpper/p/7191089.html
if(isset($_SERVER['QUERY_STRING'])){
    $key= $_SERVER["QUERY_STRING"]; 
}else{
   $key='ZZ';
}


  
    $key1=$key[0];
    if(strstr('ABCDEFGHIJ',$key1)){
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
       $typeA=implode("", $akey);
      // echo $typeA
        $conn= new mysqli("213.136.92.253","joe","JOEjoe123","record");
		if ($conn->connect_error) {
		die("Failded: " . $conn->connect_error);
		} ;
         $sql1= "SELECT `mark` AS `id` FROM `grabify` WHERE `auto`=$typeA";
     //write some insert function herer
          $result1 = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result1)>0){

           $maxid = mysqli_fetch_assoc($result1);
           $maxid= $maxid['id'];
           $conn->close();
          // echo $maxid;
           setcookie("website", $maxid, time()+3600);
           setcookie("id", $typeA, time()+3600);
		        $futureurl='a.php?site='.$maxid;
           header("Location: $futureurl");
		   exit();
       }
    }elseif(strstr('KLMNOPQRST',$key1)){
       $arr = str_split($key);
       $i=0;
       foreach($arr as $value){
           $atype= ord($value)-74;
         if($atype==10){
           $atype=0;
         }
          $akey[$i]=$atype;
          $i++;
       }
      $typeB=implode("", $akey);
       setcookie("id", $typeB, time()+3600);
      header("Location: b.php");
    }else{
      
    }


$x = 'AAAAA';
$x=$x+'A';
//echo $x;
 
?>  
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="手机定位追踪,ip获取,定位,追踪,邮件追踪,ip探寻,获取ip,grabify,获取ip的几种方法,track ip,IP tracker,tacking IP">
  <meta name="description" content="手机定位追踪等链接生成器Grabify IP Logger URLip获取,定位,追踪,邮件追踪,ip探寻,获取ip Shortener tracks IP address and locations. Track IP addresses, find IPs from Facebook,获取ip的几种方法, friends on other sites From MaiPDF">
   <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <meta name="Joe" content="MaiPDF">
  <title>手机定位追踪</title>

  <!-- Font Awesome Icons -->

   <link href="https://cdn.staticfile.org/font-awesome/5.13.1/css/all.min.css" rel="stylesheet" type="text/css">
  
  <!-- Plugin CSS -->
  <link href="https://www.maitube.club/pdf/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
<script src="https://www.maitube.club/pdf/vendor/jquery/jquery.min.js"></script>
  <!-- Theme CSS - Includes Bootstrap -->
  <link href="https://www.maitube.club/pdf/css/creative.min.css" rel="stylesheet">
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

</head>

<body id="page-top">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" style="color: Blue;" href="https://grabify.icu">Grabify.icu</a>
	 
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
       <!-- <span class="navbar-toggler-icon"></span>-->
		<span style="color: Red;"> <i class="fas  fa-th "></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
         
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://pdf.maitube.com">PDF</a>
           </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#email">邮件</a>
           </li>
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#url">URL</a>
           </li>
           
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://qr.maitube.com#pic">照片</a>
           </li>
        </ul>
      </div>
    </div>
  </nav>
 <section class="page-section" id="services">
    <div class="container">
      <h2 class="text-center mt-0">获取ip的几种方法</h2>
      <hr class="divider my-4">
      <div class="row">
  
        <div class="col-3 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#url">
            <i class="fas fa-4x fa-link text-primary mb-4"></i>
            <h3 class="h4 mb-2">链接</h3> 
        </a>
          </div>
        </div>
          <div class="col-3 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#email">
            <i class="fas fa-4x fa-envelope text-primary mb-4"></i>
            <h3 class="h4 mb-2">邮件</h3> 
        </a>
          </div>
        </div>
         <div class="col-3 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="https://qr.maitube.com#pic">
            <i class="fas fa-4x fa-images text-primary mb-4"></i>
            <h3 class="h4 mb-2">图片</h3>
            </a>  
          </div>
        </div>
         <div class="col-3 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="https://www.maipdf.com/pdf/boot.php">
             <i class="fas fa-4x fa-file-pdf text-primary mb-4"></i>
            <h3 class="h4 mb-2">PDF文档</h3> 
             </a>
          </div>
        </div>
      </div>
         <div class="row mt-5">
           <div class="col-6 text-center">
             <span  class="input-group-addon">搜索追踪码: </span>
             <input type="text" class="form-control" id="joeresult" value="">
            </div>
            <div class="col-6 text-center">
            
            <h5 class="text-center mb-0" id='resultlink'></h5>
            </div>
        </div>

<h5 class="text-center mb-5">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- horizon-328-70 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:628px;height:70px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="9447671499"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</h5>
    </div>
  </section>

  

<style>


.slider {
  -webkit-appearance: none;
  width: 37%;
  height: 25px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #f4623a;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #f4623a;
  cursor: pointer;
}
</style>  
  
 
  
  <section class="page-section" id="url">
    <div class="container">
      <h2 class="text-center mt-0">链接/二维码生成器</h2>
      <hr class="divider my-4">
        <span id="joehint" class="input-group-addon">输入完整的链接地址: </span>
          
		 <input type="text" class="form-control" id="webinput" value="https://">
         <h2 class="text-center mt-0">
             <input type="range" class="slider" id="myRange" value="1" max="100">
             <div id="rangeValue" style="font-size:0.375em;color:#f4623a;" >拖拽到底</div>
         </h2>
		 <h2 class="text-center mt-0">
		<button type="button" class="btn btn-primary btn-xl " style="text-transform: none;" onclick="makeCodeweb()">生成</button>
    
		</h2>
		 <div class="row">
          <div id='xingxi' class="col-12 col-md-6 text-left">
	        <p id='atype'></p>
            <p id='btypesay'></p>
            <p id='btype'></p>
         </div>
         <div class="col-12 col-md-5 text-center">
	      QR code to URL<br><div id="qrcodeweb" class="btn btn-default btn-xl"></div>
         </div> 
	     </div>
         <h5 class="text-center mb-1">
               
					 <li>输入需要被追踪的链接进行生成</li>
                      <li>然后将这个链接发送给他人阅读 </li>
					 <li>保存识别码和结果页面以便查询</li>			
				 
         
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- horizon-328-70 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:628px;height:70px"
     data-ad-client="ca-pub-9224406325142860"
     data-ad-slot="9447671499"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
    </div>
</section> 
</h5>



<section class="page-section" id="email">
    <div class="container">
      <h2 class="text-center mt-0">邮件追踪/隐藏图片</h2>
      <hr class="divider my-4">	 
         <h2 class="text-center mt-1">
             <input type="range" class="slider" id="myRange2" value="1" max="100">
             <div id="rangeValue2" style="font-size:0.375em;color:#f4623a;" >拖拽到底</div>
         </h2>
		 <h2 class="text-center mt-1">
		<button type="button" class="btn btn-primary btn-xl " style="text-transform: none;" onclick="makeCodeweb2()">生成</button>
    
		</h2>
         <h5 class="text-center mb-0" id='aer'></h5>
         <h5 class="text-center mb-0" id='bsay'></h5>
         <h5 class="text-center mb-0" id='ber'></h5>
		
  
    </div>
</section>  

<section class="page-section" id="howemail">
    <div class="container text-center ">
      <h2 class="text-center mt-0">如何在邮件中添加图片</h2>
      <hr class="divider my-4">
	  <p class="text-center">
         <h5 class="text-center mb-0" >Step One</h5>
        <img src="pic/step1.png" class="img-fluid"  style="height:257px;" alt="MaiPDF" />
        <h5 class="text-center mb-0" >Step Two</h5>
        <img src="pic/step2.png" class="img-fluid"  style="height:397px;" alt="MaiPDF" />
        <h5 class="text-center mb-0" >Step Three</h5>
        <img src="pic/step3.png" class="img-fluid"  style="height:357px;" alt="MaiPDF" />
      </p>
      <hr class="divider my-4">
    </div>
</section>  


  <!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
    	<a href='https://www.maipdf.com'><div class="small text-center ">MaiPDF Home</div></a>
      <div class="small text-center text-muted">Copyright &copy; 2020 - admin@maitube.com</div>
      <a href='ok/'><div class="small text-center ">Support by MaiTube</div></a>
    </div>
  </footer>

 
	
<script type="text/javascript" src="https://www.maitube.club/pdf/qrcode.min.js"></script>


<script>

//
//var web = document.getElementById("joeresult");
//document.getElementById("resultlink").innerHTML="Email Tracker: <br>"+"<a href=https://grabify.icu/mail/"+res[1]+" target=\"_blank\">https://grabify.icu/mail/"+res[1]+"</a>";

$("#joeresult").
	on("blur", function () {
		doCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			doCode();
		}
	});
function doCode () {		
	var resu = document.getElementById("joeresult");
     var resu=resu.value;
	document.getElementById("resultlink").innerHTML="Click Link to View Result: <br>"+"<a href=https://grabify.icu/"+resu+" target=\"_blank\">https://grabify.icu/"+resu+"</a>";
	
}
$('#myRange2').mousemove(function(){
  // $('#rangeValue').text($('#myRange').val());
     if($('#myRange2').val()==100){
       document.getElementById("rangeValue2").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue2").innerHTML="拖拽到底";
     }
});
document.getElementById("myRange2").addEventListener('touchend', function(){
     if($('#myRange2').val()==100){
       document.getElementById("rangeValue2").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue2").innerHTML="拖拽到底";
     }
  
});
document.getElementById("myRange2").addEventListener('touchmove', function(){
     if($('#myRange2').val()==100){
       document.getElementById("rangeValue2").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue2").innerHTML="拖拽到底";
     }
  
});
$('#myRange').mousemove(function(){
  // $('#rangeValue').text($('#myRange').val());
     if($('#myRange').val()==100){
       document.getElementById("rangeValue").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue").innerHTML="拖拽到底";
     }
});
document.getElementById("myRange").addEventListener('touchend', function(){
     if($('#myRange').val()==100){
       document.getElementById("rangeValue").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue").innerHTML="拖拽到底";
     }
  
});
document.getElementById("myRange").addEventListener('touchmove', function(){
     if($('#myRange').val()==100){
       document.getElementById("rangeValue").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue").innerHTML="拖拽到底";
     }
  
});
var qrcode2 = new QRCode(document.getElementById("qrcodeweb"), {
	width : 170,
	height : 170,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});

function makeCodeweb () {
	//alert(CryptoJS.MD5("Message"));	
	var web = document.getElementById("webinput");
     //alert(typeof web);
    if(web.value.length<10){
       alert('Seriously ?');
       return ;
    }
    if($('#myRange').val()==100){
        //('#myRange').val()=20;
    var ranger20 = document.getElementById("myRange");
    ranger20.value=20;
    document.getElementById("rangeValue").innerHTML="Drag Progress Bar to the End";
      }else{
       alert('Please Drag Progress bar to the End');
       return ;
     }
	qrcode2.makeCode(web.value);
     
      if (window.XMLHttpRequest)
    {
        
        xmlhttp=new XMLHttpRequest();
    }
    else
    {    
        //IE6, IE5 浏览器执行的代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)

        {
            var res=xmlhttp.responseText;
            var res = res.split(":");
         // <a href="somepage.htm?varName=' + wp + '">click me</a>
       $("#xingxi").fadeOut("slow");
	   var qd ="https://grabify.icu/"+res[1];
	   qrcode2.makeCode(qd);
            document.getElementById("atype").innerHTML="可追踪链接: <br>"+"<a href=https://grabify.icu/"+res[1]+" target=\"_blank\">https://grabify.icu/"+res[1]+"</a>";
            document.getElementById("btypesay").innerHTML="识别码: "+res[2];
            document.getElementById("btype").innerHTML="结果页面: <br>"+"<a href=https://grabify.icu/"+res[2]+" target=\"_blank\">https://grabify.icu/"+res[2]+"</a>";        //$("#xingxi").fadeOut("slow");
            $("#xingxi").fadeIn("slow");
        }
    }
    xmlhttp.open("GET","qrcode.php?i="+web.value,true);
    xmlhttp.send();


}
function makeCodeweb2 () {
	
	
    if($('#myRange2').val()==100){
    var ranger20 = document.getElementById("myRange2");
    ranger20.value=20;
    document.getElementById("rangeValue2").innerHTML="拖拽到底";
      }else{
       alert('拖拽到底');
       return ;
     }

     
      if (window.XMLHttpRequest)
    {
        
        xmlhttp=new XMLHttpRequest();
    }
    else
    {    
        //IE6, IE5 浏览器执行的代码
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)

        {
            var res=xmlhttp.responseText;
            //alert(res);
            var res = res.split(":");
            document.getElementById("aer").innerHTML="放入邮件的链接: <br>"+"<a href=https://grabify.icu/mail/"+res[1]+" target=\"_blank\">https://grabify.icu/mail/"+res[1]+"</a>";
            document.getElementById("bsay").innerHTML="识别码: "+res[2];
            document.getElementById("ber").innerHTML="结果页面: <br>"+"<a href=https://grabify.icu/"+res[2]+" target=\"_blank\">https://grabify.icu/"+res[2]+"</a>";   

        }
    }
    xmlhttp.open("GET","qrcode.php?i=mm",true);
    xmlhttp.send();


}

 

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
  
  <script src="https://www.maitube.club/pdf/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="https://www.maitube.club/pdf/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="https://www.maitube.club/pdf/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="https://www.maitube.club/pdf/js/creative.min.js"></script>

</body>

</html>
