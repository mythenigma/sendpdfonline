

<?php  
//header("Location: http://ifread.com");

$key1='';
if($_SERVER['HTTP_HOST']=='grabifyicu.com'|| $_SERVER['HTTP_HOST']=='www.grabifyicu.com'){
        exit("Please go to the site from Search Engine");
 }
session_start();
 
if(isset($_SESSION['views']))
{
    $_SESSION['views']=$_SESSION['views']+1;
}
else
{
    $_SESSION['views']=1;
}
if($_SESSION['views']>85){
  exit();
}


  //https://www.cnblogs.com/phpper/p/7191089.html
if(isset($_SERVER['REQUEST_URI'])&& $_SERVER['REQUEST_URI'] !== '/'){
  //exit($_SERVER['REQUEST_URI']);
    $key= $_SERVER["REQUEST_URI"]; 

  
  
   if(stristr($key,'.png')){
	   
	   $key=explode('/',$key);
	   $key = $key[2];
	   $key=explode('.',$key);
	   $pnger= $key[1];
	   $futureurl='https://grabb.site/wx/image.php?name='.$pnger;
	  header("Location: $futureurl");
		        exit();

   }
  
    //exit($_SERVER['REQUEST_URI']);
  
  
  if($key=='AJACAID'){
	  exit('banned');
  }
    
    $key=explode('&',$key);
    $key=$key[0];
    $key=explode('=',$key);
    $key=$key[0];
    $key=explode('?',$key);
    $key=$key[0];
    $key=explode('%20',$key);
    $key=$key[0];
    $key=explode('/',$key);
    $key=$key[1];

}else{
   $key='ZZ';
}

//echo $key;
  
  if(strlen($key>1)){
		 $key1 = $key[0];
	 }
    if($key1 && stristr('ABCDEFGHIJ',$key1)){
      exit('page 404```"'.$key1."'");
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
       // $conn= new mysqli("127.0.0.1","joe","JOEjoe123","record");
        include_once ('password.php');
$conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
		if ($conn->connect_error) {
		die("Failded: " . $conn->connect_error);
		} 
         $sql1= "SELECT `mark` AS `id` FROM `grabify` WHERE `auto`=$typeA";
     //write some insert function herer
          $result1 = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result1)>0){

           $maxid = mysqli_fetch_assoc($result1);
           $maxid = $maxid['id'];
           $conn->close();
          // echo $maxid;
           setcookie("website", $maxid, time()+3600);
           setcookie("id", $typeA, time()+3600);
		       // $futureurl='a.php?site='.$maxid;  $futureurl='a.php?site=Loading';
           // header("Location: $futureurl");
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
      header("Location: b.php");exit();
    }else{
      //echo $_SERVER['HTTP_HOST'];
      if($_SERVER['HTTP_HOST']=='grabifyicu.com'|| $_SERVER['HTTP_HOST']=='www.grabifyicu.com'){
        header("Location: https://whatstheirip.tech/");
      }
    }



?>  
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
   <link rel="icon" href="favicon.ico" type="image/x-icon" />
 
  <title>Grabify IP Logger - Advanced Version</title>

<meta name="keywords" content="link tracking, URL tracking, IP tracking, Grabify, track clicks, track user behavior, monitor link interactions, track referral traffic, track email links">
<meta name="description" content="Grabify allows you to track and monitor clicks on your links, providing detailed information such as IP addresses and user behavior. Perfect for link tracking, referral traffic, and email link monitoring.">

  <!-- Bootstrap core JavaScript -->
  <script src="https://maipdf.com/pdf/vendor/jquery/jquery.min.js"></script>
  <script src="https://maipdf.com/pdf/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="https://maipdf.com/pdf/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="https://maipdf.com/pdf/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="https://maipdf.com/pdf/js/creative.min.js"></script>
<meta http-equiv='content-language' content='en-gb'>
<link href="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Plugin CSS -->
  <link href="https://maipdf.com/pdf/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
  <!-- Theme CSS - Includes Bootstrap <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>-->
  <link href="https://maipdf.com/pdf/css/creative.min.css" rel="stylesheet">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9224406325142860" crossorigin="anonymous"></script>
<!-- Google tag (gtag.js) GRABIFYICU-->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YWYV3VSCFH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YWYV3VSCFH');
</script>
<script>
          var d = new Date();
      document.cookie ="usertime="+d;
      document.cookie ="userjoe="+d;
      
</script>

</head>

<body id="page-top">
  <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" style="color: Blue;" href="https://grabify.icu">Advanced Grabify Version</a>
	 
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
       <!-- <span class="navbar-toggler-icon"></span>-->
		<span style="color: Red;"> <i class="fas fa-th"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
         
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://www.maipdf.com/pdf/boot.php">PDF</a>
           </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#email">Email</a>
           </li>
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#url">URL</a>
           </li>
           
           <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="https://maipdf.com/qr.php#pic">Images</a>
           </li>
    
        </ul>
      </div>
    </div>
  </nav>
 <section class="page-section" id="services">
    <div class="container">
      <h1 class="text-center mt-0">Ways To Track & Logger an IP</h1>
      <hr class="divider my-4"><small>Grabify is a free web-based IP grabbing/URL shortening tool. (IP grabbing just as it implies simply means getting/grabbing peoples IP addresses. )</small>
     <a href="#findanip">
      <div class="alert alert-info text-center">
          <strong>Your IP address: </strong> <span id='ipaddress'></span>
      </div>
     </a> 
       <h5 class="text-center mb-0" id='resultlink'></h5>
      <div class="row">
  
        <div class="col-4 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#url">
            <i class="fas fa-2x fa-link text-primary mb-4"></i>
            <h6 class="h6 mb-2">URL<br><small>tracker</small></h6> 
           </a>
          </div>
        </div>
		    <div class="col-4 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="https://privnote.chat">
            <i class="fa fa-file-tex fa-2x text-primary mb-4"></i>
			<i class="fa fa-file-text fa-2x text-primary mb-4" ></i>
            <h6 class="h6 mb-2">PrivNotes<br><small>Self-Destruct</small></h6> 
           </a>
          </div>
        </div>
          <div class="col-4 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="#email">
            <i class="fas fa-2x fa-envelope text-primary mb-4"></i>
            <h6 class="h6 mb-2">Email<br><small>tracker</small></h6> 
        </a>
          </div>
        </div>
         <div class="col-4 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="qr.php#pic">
            <i class="fas fa-2x fa-images text-primary mb-4"></i>
            <h5 class="h5 mb-2">Images</h5>
            </a>  
          </div>
        </div>
         <div class="col-4 col-md-2 text-center">
          <div class="mt-5">
          	<a class="nav-link js-scroll-trigger" href="https://www.maipdf.com/pdf/boot.php">
             <i class="fas fa-2x fa-file-pdf text-primary mb-4"></i>
            <h5 class="h5 mb-2">PDF</h5> 
             </a>
          </div>
        </div>
      </div>
   


    

      
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
    <div class="container text-center">
      <h2 class="text-center mt-0">URL/QR Tracker Generator</h2>
      <hr class="divider my-4">
        <span id="joehint" class="input-group-addon"> Enter Full URL: <small>
		
		
		<a class="btn btn-xl js-scroll-trigger" style="text-transform: none;" href="#grainstruct">Instruction.</a>
		
		</small></span>
          
		 <input type="text" class="form-control" id="webinput" value="https://">
         <h2 class="text-center mt-1">
             <input type="range" class="slider" id="myRange" value="1" max="100">
             <div id="rangeValue" style="font-size:0.375em;color:#f4623a;" >Drag Progress Bar to the End</div>
         </h2>
		 <h2 class="text-center mt-1">
		<button type="button" class="btn btn-primary btn-xl " style="text-transform: none;" onclick="makeCodeweb()">Generate Tracking URL/QR</button>
    
		</h2>
		 <h5 id="loadingdot" style="display:none;"><div class="spinner-grow text-muted"></div><div class="spinner-grow text-primary"></div><div class="spinner-grow text-success"></div><div class="spinner-grow text-info"></div><div class="spinner-grow text-warning"></div><div class="spinner-grow text-danger"></div><div class="spinner-grow text-secondary"></div><div class="spinner-grow text-dark"></div><div class="spinner-grow text-light"></div></h5>	
     
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
	   
	     <a class="btn btn-primary btn-xl js-scroll-trigger" style="text-transform: none;" href="ok/blasze.html">Intro More</a>
                <ul id="grainstruct">
					 <li>Enter a URL that you want Grabify.icu to track</li>
                        <li>Give the link which generated  to the client</li>
					 <li>Check Result on Tracking Link</li>
					
				 </ul>
	 <p class="text-center">
		 <h5 class="mb-4">Step1:Select the URL</h5>	
			  <img src="https://grabify.icu/ok/top.png" class="img-fluid"  style="height:257px;">
			 
               <h5 class="mb-4">Step 2: Enter a link to the web page you want others to see, I will just fill in one here. Then pull the progress bar to the end and click "Generate"</h5>	
			  <img src="https://grabify.icu/ok/howto.png" class="img-fluid"  style="height:257px;">
               <h5 class="mb-4">Step 3: At this time, you will see the information in the picture, "New Grabify Link" and "Tracking Link". After these two links are opened, you will quickly understand their function, the first link It is for sending to others. After they click on it, they will go directly to the URL entered in the previous step. The second link is for you to view the record yourself.</h5>	
                <img src="https://grabify.icu/ok/instruct.png" class="img-fluid"  style="height:257px;">
    <h5 class="mb-4">Step 4: On this page, you can click "Show Details" to view the location information. You can also copy this ip address and go to a website you are familiar with for further inquiries and sharing. Of course, you can also delete these records or modify the link address in the second step.</h5>	
                <img src="https://grabify.icu/ok/result.png" class="img-fluid"  style="height:257px;">
            </p>
    </div>
</section> 

<section class="page-section" id="email">
    <div class="container">
      <h2 class="text-center mt-0">Email Tracker/Invisible Image</h2>
      <h6 class="text-center mt-0"><a href="ok/trackemail.html">(Logic Behind)</a></h6>
      <hr class="divider my-4">	 
         <h2 class="text-center mt-1">
             <input type="range" class="slider" id="myRange2" value="1" max="100">
             <div id="rangeValue2" style="font-size:0.375em;color:#f4623a;" >Drag Progress Bar to the End</div>
         </h2>
		 <h2 class="text-center mt-1">
		<button type="button" class="btn btn-primary btn-xl " style="text-transform: none;" onclick="makeCodeweb2()">Generate Email Tracking Link</button>
    
		 </h2>
		
		  <h5 class="text-center mb-0" >Copy*Paste below icon image into Emails
              <br><img src="pic/step1.png" id="tpng" class="text-center"  style="height:15px;width:15px;border-style:solid;outline:red dotted thick;" alt="MaiPDF" />
          </h5>
		  
		  <h5 class="text-center mb-0" >Step Two</h5>
		
		
         <h5 class="text-center mb-0" id='aer'></h5>
         <h5 class="text-center mb-0" id='bsay'></h5>
         <h5 class="text-center mb-0" id='ber'></h5>
		
  
    </div>
</section>  

<section class="page-section" id="howemail">
    <div class="container text-center ">
      <h2 class="text-center mt-0">Check the information of an IP</h2>


  <div class="alert alert-success text-center">
      <strong id="ipbackinfo"></strong>
  </div>
   <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
    <div class="input-group"> 
      <input type="text" id="findanip" class="form-control" placeholder="192.10.10.10" aria-label="findanip"> <button id="findanipbutton" class="btn btn-primary btn-lg" type="button">Check IP</button>   
      </div>     
  </div>




      <hr class="divider my-4">
      <a href="ok/grabify.html">Grabify</a>
    </div>



<div class="card bg-light text-dark">
<div class="card-body">

</div></div>


<h6>Grabify link or URL is a tool that offers IP tracking services. It allows you to create a link that, when clicked, will track the IP address of the user who clicked the link. The link can be customized to look like any other link, such as a shortened URL, and can be shared with the user through any platform, such as social media or messaging apps. Once the user clicks the link, their IP address and other information can be viewed on the Grabify website. However, it's important to note that using IP tracking tools without the user's consent can be a violation of privacy and may be illegal in some jurisdictions.</h6>



    
</section>  


  <!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
    	<a href='https://maipdf.com'><div class="small text-center ">MaiPDF Home</div></a>
      <a href="https://iplogger.icu/iplogger.html" class="link-info">intro</a>
      <a href="ok/iplooktool.html" class="link-info">ip</a>
      <a href="ok/drm.html" class="link-info">d</a><a href="ok/Offline DRM TimeLimited Access and Expiration Dates.html" class="link-info">oD</a>
      <a href="ok/fenceview.html" class="link-info">f</a>
<a href="ok/Cloud Share vs. Offline Version - Choosing the Right Option for Your PDFs.html" class="link-info">C</a>
<a href="ok/whycreatesite.html" class="link-info">y</a>
<a href="ok/alternative_spypig.html" class="link-info">s</a>
      <a href="https://maifile.cn/description/list.php" class="link-info">list</a>


      <div class="small text-center text-muted">Copyright &copy; 2026 - mythenigma@gmail.com</div>
    
    </div>
  </footer>


	
<script type="text/javascript" src="https://www.maipdf.com/pdf/qrcode.min.js"></script>


<script>



function isValidIPold(ip) {
  // Regular expression to match an IP address
  const ipPattern = /^([0-9]{1,3}\.){3}[0-9]{1,3}$/;

  // Check if the string matches the IP address pattern
  if (!ipPattern.test(ip)) {
    return false;
  }

  // Split the IP address into its components
  const ipComponents = ip.split('.');

  // Check each component of the IP address
  for (let i = 0; i < ipComponents.length; i++) {
    const component = parseInt(ipComponents[i], 10);
    if (component < 0 || component > 255) {
      return false;
    }
  }

  // If all checks pass, the IP address is valid
  return true;
}


function isValidIP(ip) {
  // Regular expressions for IPv4 and IPv6
  const ipv4Pattern = /^([0-9]{1,3}\.){3}[0-9]{1,3}$/;
  const ipv6Pattern = /^([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}$|^([0-9a-fA-F]{1,4}:){1,7}:$|^([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}$|^([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}$|^([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}$|^([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}$|^([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}$|^[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})$|^:((:[0-9a-fA-F]{1,4}){1,7}|:)$|^fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}$|^::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9])?[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9])?[0-9])$|^([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9])?[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9])?[0-9])$/;

  // Check if the IP matches IPv4 pattern
  if (ipv4Pattern.test(ip)) {
    const parts = ip.split('.');
    return parts.every(part => {
      const num = parseInt(part, 10);
      return num >= 0 && num <= 255;
    });
  }

  // Check if the IP matches IPv6 pattern
  if (ipv6Pattern.test(ip)) {
    return true;
  }

  // If neither pattern matches, return false
  return false;
}
          var ipbutton = document.getElementById('findanipbutton');
          ipbutton.addEventListener('click', function(event) {
      let i = document.getElementById("findanip").value;
      document.getElementById("findanip").value='';
    if(isValidIP(i)){
      fetch('https://grabify.icu/c.php?i='+i)
      .then(response => response.text())
      .then(data => {
              document.getElementById('ipbackinfo').innerHTML=i+':<br>'+data;
        //alert(data);
        })
        .catch(error => {
        console.error('Error fetching data:', error);
        });
      }else{
        alert('Not An IP');
      return;
      }
      
        
        
   });





fetch('https://grabify.icu/c.php')
      .then(response => response.text())
      .then(data => {
              document.getElementById('ipaddress').innerHTML=data+' <br>click for more details';

              document.getElementById('findanip').value=data;
        //alert(data);
        })
        .catch(error => {
        console.error('Error fetching data:', error);
        });











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
     //var resu=resu.value;
	  //document.getElementById("resultlink").innerHTML="Click Link to View Result: <br>"+"<a href=https://grabify.icu/"+resu+" target=\"_blank\">https://grabify.icu/"+resu+"</a>";
	
}



$('#myRange2').mousemove(function(){
  // $('#rangeValue').text($('#myRange').val());
     if($('#myRange2').val()==100){
       document.getElementById("rangeValue2").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue2").innerHTML="Drag Progress Bar to the End";
     }
});
document.getElementById("myRange2").addEventListener('touchend', function(){
     if($('#myRange2').val()==100){
       document.getElementById("rangeValue2").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue2").innerHTML="Drag Progress Bar to the End";
     }
  
});
document.getElementById("myRange2").addEventListener('touchmove', function(){
     if($('#myRange2').val()==100){
       document.getElementById("rangeValue2").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue2").innerHTML="Drag Progress Bar to the End";
     }
  
});
$('#myRange').mousemove(function(){
  // $('#rangeValue').text($('#myRange').val());
     if($('#myRange').val()==100){
       document.getElementById("rangeValue").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue").innerHTML="Drag Progress Bar to the End";
     }
});
document.getElementById("myRange").addEventListener('touchend', function(){
     if($('#myRange').val()==100){
       document.getElementById("rangeValue").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue").innerHTML="Drag Progress Bar to the End";
     }
  
});
document.getElementById("myRange").addEventListener('touchmove', function(){
     if($('#myRange').val()==100){
       document.getElementById("rangeValue").innerHTML="You're Good to Go";
      }else{
      document.getElementById("rangeValue").innerHTML="Drag Progress Bar to the End";
     }
  
});
var qrcode2 = new QRCode(document.getElementById("qrcodeweb"), {
	width : 170,
	height : 170,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});




async function makeCodeweb() {
	   document.getElementById("btypesay").innerHTML='<h3><div class="spinner-grow text-muted"></div><div class="spinner-grow text-primary"></div><div class="spinner-grow text-success"></div><div class="spinner-grow text-info"></div><div class="spinner-grow text-warning"></div><div class="spinner-grow text-danger"></div><div class="spinner-grow text-secondary"></div><div class="spinner-grow text-dark"></div><div class="spinner-grow text-light"></div></h3>';
	var web = document.getElementById("webinput");
    if(web.value.length<10){
       alert('Seriously ?');
       return ;
    }
	
	 let  filterstrings = ['porn','redtube','81ea'];
     let  regex = new RegExp( filterstrings.join( "|" ), "i");  
      if(regex.test(web.value)){
        alert('Seriously ?'); return 0;
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
	 const data = new FormData();
	 data.append('i', web.value);
	 const response = await fetch("qrcode.php", {
		method: "POST",
		body: data
	  });
	 try {
	    const res = await response.text().then(text => text.trim());
		continuewithcode(res);
		 
	  }catch (error) {
       return ;
      }
}
async function continuewithcode(res){
	if (res.includes("Reachable")) {
				alert('Please Enter an Valid URL');
				return ;
			}
		
	   res = res.split(":");
	   $("#xingxi").fadeOut("slow");
	   var qd ="https://grabb.site/"+res[1];
	   qrcode2.makeCode(qd);
	   document.getElementById("atype").innerHTML="New Grabify Link: <br>"+"<a href=https://grabb.site/"+res[1]+" target=\"_blank\">https://grabb.site/"+res[1]+"</a>";
       document.getElementById("btypesay").innerHTML="Tracking Code: "+res[2];
       document.getElementById("btype").innerHTML="Tracking Link: <br>"+"<a href=https://grabify.icu/"+res[2]+" target=\"_blank\">https://grabify.icu/"+res[2]+"</a>";        //$("#xingxi").fadeOut("slow");
       $("#xingxi").fadeIn("slow");
}



async function continuewithcode2(res){
	if (res.includes("Reachable")) {
				alert('Please Enter an Valid URL');
				return ;
			}
		
	  res = res.split(":");
			document.getElementById("tpng").src = "https://grabb.site/wx/"+res[1]+".png";
            document.getElementById("aer").innerHTML="Email Tracker: <br>"+"<a href=https://grabb.site/wx/"+res[1]+".png target=\"_blank\">https://grabb.site/wx/"+res[1]+".png</a>";
            document.getElementById("bsay").innerHTML="Tracking Code: "+res[2];
            document.getElementById("ber").innerHTML="Tracking Link: <br>"+"<a href=https://grabify.icu/"+res[2]+" target=\"_blank\">https://grabify.icu/"+res[2]+"</a>";   

}

async function  makeCodeweb2() {
	document.getElementById("bsay").innerHTML="<h5>grabify.icu is Generating the tracking link......</h5>";
    if($('#myRange2').val()==100){
    var ranger20 = document.getElementById("myRange2");
    ranger20.value=20;
    document.getElementById("rangeValue2").innerHTML="Drag Progress Bar to the End";
      }else{
       alert('Please Drag Progress bar to the End');
       return ;
     }
     const data = new FormData();
	 data.append('i', 'mm');
	 const response = await fetch("qrcode.php", {
		method: "POST",
		body: data
	  });
	 try {
	    const res = await response.text().then(text => text.trim());
		 continuewithcode2(res);
		 
	  }catch (error) {
       return ;
      }
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




</body>

</html>
