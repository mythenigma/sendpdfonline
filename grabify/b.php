<?php

if (!isset($_COOKIE["id"])){
   //exit('Sorry, Not Working');
    $key=75;
}else{
$key= $_COOKIE["id"];$keystring=$key;$key = (int)$key;
}
 //$conn= new mysqli("127.0.0.1","joe","JOEjoe123","record");
 include_once ('password.php');
$conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
		if ($conn->connect_error) {
		die("Failded: " . $conn->connect_error);
		} ;
$conn->set_charset("utf8mb4");

$sql1= "SELECT * FROM `grabify` WHERE `auto`=$key";
$sql = "SELECT `mark`,`markopen`,`ip` FROM `recordip` WHERE `email`= 'g' AND `subject` =$key ORDER BY `auto` DESC";
$result  = mysqli_query($conn, $sql);
$result1 = mysqli_query($conn, $sql1);
$maxid   = mysqli_fetch_assoc($result1);
$cishu   = $maxid['email'];
$shijian = $maxid['subject'];
$md5     = $maxid['md5'];
$maxid   = $maxid['mark'];//我不知道以后这里会不会出问题，我把id自己赋值给自己了
$maipdf  = 2;
if(strlen($md5)=='33'){
  $maipdf=1;
  //echo $maipdf;
}
//echo  $_SERVER['HTTP_HOST'];
$arr1 = str_split($keystring);
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
  $message="Result Below: ";
  echo "<script>var gaidizhi= 'no';var keykey= '$key'; </script>";
  if($maxid=='mm'){
    $maxid='Email Tracker';
   // $typeA="/email/".$typeA;
     if($maipdf==2){
        $typeA="Email Tracker : https://grabb.site/wx/".$typeA.'.png';
      }else{
         $typeA="Email Tracker : https://maipdf.cn/".$typeA;
      }
	  $message="Result Below: <br>Email TimeZone in Greenwich";
  }elseif($maxid[0]=='p'){
    $maxid='Photo Tracker';
    //$typeA="/email/".$typeA;
    $typeA="Images URL : https://maipdf.com/pic/".$typeA."<br>(".$cishu.") Left to open & Per Period ".$shijian." Seconds";
    //$message="Result Below: <br>Email TimeZone in Greenwich";
}elseif($maxid[1]=='x'){
    $maxid='图片分享';
    //$typeA="/email/".$typeA;
    $typeA="图片链接: https://qr.maitube.com/pic/".$typeA."<br>(".$cishu.")剩余打开次数&每次".$shijian."秒";
    //$message="Result Below: <br>Email TimeZone in Greenwich";
}else{
  //$typeA="Grabify.icu URL - https://grabify.icu/".$typeA;
   echo "<script>var gaidizhi='yes';</script>";
  if($maipdf==2){    
        $typeA="Grabify.icu URL - https://grabb.site/".$typeA;
      }else{
        $typeA="Grabify.icu URL - https://grabb.site/".$typeA;
      }
     
}



 // echo $maxid.$typeA;
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

   <link rel="stylesheet" href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/4.6.1/css/bootstrap.min.css">
  <script src="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/4.6.1/js/bootstrap.min.js"></script>

         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- 最新的 Bootstrap4 核心 JavaScript 文件 -->
      
<title>Grabify - Result Checking Page</title>



<!-- Google tag (gtag.js) GRABIFYICU-->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YWYV3VSCFH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YWYV3VSCFH');
</script>
</head>


<body>

    <div class="container"><div class="alert alert-danger">
        <h2 class="text-center">Grabify.icu - Result Checking Page</h2>
    </div></div>

  
     <div class="container">
     

     <table class="table table-dark table-hover">
       <thead class="text-center">
            <tr id="diyihang">
               <th>Original URL</th>
               <th><?php echo $maxid  ?><a href='#dibu'><button type="button" id="gai" class="btn btn-warning">Change</button></a></li>
               </th>
            </tr>
            <tr><th  colspan="2" id="laourl"><?php echo $typeA;?></th></tr>
            <tr><th>Tracking Page</th><th><?php echo 'https://grabify.icu/'.$typeB; ?></th></tr>
       </thead>
        <tbody>
        </tbody>
     </table>
     <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <ins class="adsbygoogle"
           style="display:block; text-align:center;"
           data-ad-layout="in-article"
           data-ad-format="fluid"
           data-ad-client="ca-pub-9224406325142860"
           data-ad-slot="4978213873"></ins>
      <script>
           (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
     </div>





    <div class="container">

        <h2 class="text-center" style="color:#f4623a;" id="resultmessage"><?php echo $message  ?></h2>
        

    <table class="table table-dark table-hover">
    <caption><div class="alert alert-warning">
	   Image Tracker with more than 10,000 will not be logged.<br>
       Grabify.icu  provides Geolocation info 
    </div>
    

  </caption>
    <?php
     
      //echo "<table class=\"table table-dark table-hover \">";
	  
	  echo "<thead>";
      echo "<tr><th>Time&Zone</th><th>Device/UserAgent</th><th>IP Address</th></tr><thead><tbody id='tablebody'>";
      if(mysqli_num_rows($result1)<1){
            echo "<div class='alert alert-warning text-center'>NO result at the moment</div>";
     }else{
      while($row = mysqli_fetch_assoc($result)) {
	   echo "<tr>";
	
	   foreach($row as $key=>$value){
     
         if($key=='ip'){
                echo "<td  class='$value ipdizhi' id='$value'>";
                  echo "<div onclick=\"ipzhuizong('$value')\" ontouchstart=\"ipzhuizong('$value')\">";
                   echo $value;
                  echo "<br>Show Details</div>";
                echo "</td>";
        
        	   }	else{
                echo "<td>";
                   echo $value;
                echo "</td>";
              }   

	   }	   
	   echo "</tr>";
      
    }
    echo "</tbody>";
    echo "</table>";
   }
    ?>
     <div class="row">
          <div id='xingxi' class="col-12 col-md-6 text-left">
              <input type="range" class="slider" id="myRange" value="1" max="100">
              <div id="rangeValue" style="font-size:0.875em;color:#f4623a;" >Drag Progress Bar to the End</div>
          </div>
          <div id='del' class="col-12 col-md-6 text-left">
            <button type="button" id="gai" class="btn btn-warning" onclick="deleterecord()">Delete Records</button>
          </div>
     </div>
      <div class="row" id="dibu">
          <div id='xiugai' class="col-12 col-md-6 text-left">
              <input type="text" class="form-control" id="webinput" value="https://">
          </div>
          <div id='gengxin' class="col-12 col-md-6 text-left">
            <button type="button" id="gai" class="btn btn-warning" onclick="changerecord1()">Change the URL</button>
          </div>
          <br><br>
     
     </div>
              

    </div>
<!-- Footer -->
  <footer class="bg-light py-5">
    <div class="container">
    	<a href='https://www.maipdf.com'><div class="small text-center ">MaiPDF Home</div></a>
      <div class="small text-center text-muted">Copyright &copy; 2025 - mythenigma@gmail.com</div>
    </div>

  </footer>
</body>

<style>
.slider {
  -webkit-appearance: none;
  width: 57%;
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
.blue
{
        color:red;
        font-weight:bold;
}
</style>  
</html>


<script>
 function ipzhuizong(tempip){
    //alert(this.id);
      console.log('running');
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function(){
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                var res=xmlhttp.responseText;
                console.log(tempip+res);
              //  document.getElementById(tempip).innerHTML=tempip+'<br>'+res;
            // document.getElementsByClassName(tempip)[0].innerHTML=tempip+'<br>'+res;
               var ipku = document.getElementsByClassName(tempip);
               var classnameCount = ipku.length;
                    console.log(classnameCount);
                    for (i = 0; i < classnameCount; i++) {
                      document.getElementsByClassName(tempip)[i].innerHTML=tempip+'<br>'+res; 
                    }
            }
        }
        xmlhttp.open("GET","c.php?i="+tempip,true);
        xmlhttp.send();
    }

setTimeout(zhaodizhi,2000);
function zhaodizhi(){
    var ipku = document.getElementsByClassName('ipdizhi');
    var classnameCount = ipku.length;
    var mydizhi = new Array();
    for (i = 0; i < classnameCount; i++) {
        temp = ipku[i].className.split(" ")
        mydizhi[i]=temp[0];
       //console.log(mydizhi[i]);
    }
    //var names = ["Mike","Matt","Nancy","Adam","Jenny","Nancy","Carl"];
    var uniqueNames = [];
    $.each(mydizhi, function(i, el){
        if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
    });
    
    //console.log(uniqueNames.length);
        for (i = 0; i < uniqueNames.length; i++) {
          var temp = uniqueNames[i];
        
          //setTimeout(ipzhuizong(temp),5000);
      
        //
    } 
//ipzhuizong('180.166.151.206');
}


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
function deleterecord(){
   //var re=$.cookie('id');
   //alert(re);
//alert('ALL Records has been Deleted');
   if($('#myRange').val()==100){
        //('#myRange').val()=20;
    var ranger20 = document.getElementById("myRange");
    ranger20.value=20;
    document.getElementById("rangeValue").innerHTML="Drag Progress Bar to the End";
      }else{
       alert('Please Drag Progress bar to the End');
       return ;
     }
//
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

            //tbodyhide
            $("#tablebody").hide();
            alert('ALL Records has been Deleted');
        }
    }
    //console.log("qrcode.php?del="+re);
    xmlhttp.open("GET","qrcode.php?del="+keykey,true);
    xmlhttp.send();
}

function changerecord1(){
//var re=$.cookie('id');
   var rer= document.getElementById('laourl').innerHTML;
   if(gaidizhi!='yes'){
    alert('Cannot Change Tracking Code for this type of Link');
    return;
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
    	var web = document.getElementById("webinput");
     //alert(typeof web);
    if(web.value.length<10){
       alert('Seriously ?');
       return ;
    }
       
   //
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

            //tbodyhide
            alert('URL has been Changed');
            document.getElementById("laourl").innerHTML="Updated URL: "+web.value;
           $("#diyihang").hide();
        }
    }
    xmlhttp.open("GET","qrcode.php?update="+web.value,true);
    xmlhttp.send();
}

function changerecord(){
  // var re=$.cookie('id');
   var rer= document.getElementById('laourl').innerHTML;
  //alert(rer);
    var n = rer.search('Email Tracker');
    var m = rer.search('Photo Tracker');
  if(n==15){
    alert('Cannot Change Tracking Code for Email');
    return;
   }
   if(m==15){
    alert('Cannot Change URL Code for Photo');
    return;
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
    	var web = document.getElementById("webinput");
     //alert(typeof web);
    if(web.value.length<10){
       alert('Seriously ?');
       return ;
    }
       
   //
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

            //tbodyhide
            alert('URL has been Changed');
            document.getElementById("laourl").innerHTML="Updated URL: "+web.value;
            $("#diyihang").hide();
        }
    }
    xmlhttp.open("GET","qrcode.php?update="+web.value,true);
    xmlhttp.send();
}
</script>





