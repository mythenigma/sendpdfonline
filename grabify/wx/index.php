<?php 
       date_default_timezone_set('Etc/Greenwich');


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

