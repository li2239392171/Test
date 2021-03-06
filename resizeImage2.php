﻿<?php 		//多类型图片缩略图
$filename="1469674635.jpg";
$src_image=imagecreatefromjpeg($filename);	//	生成画布资源
list($src_w,$src_h,$imagetype)=getimagesize($filename);	//得到原图片的宽和高
$mime=image_type_to_mime_type($imagetype);
//echo $mime;//image/jpeg,image/gif
$createFun=str_replace("/", "createfrom", $mime);	//用变量代表不同类型的函数
$outFun=str_replace("/", null, $mime);
//$src_image=imagecreatefromjpeg($filename);	//	生成画布资源
$src_image=$createFun($filename);	//	此时$createFun()相当于imagecreatefromjpeg()!!!


$dst_50_image=imagecreatetruecolor(50, 50);
$dst_220_image=imagecreatetruecolor(220, 220);
$dst_350_image=imagecreatetruecolor(350, 350);
$dst_800_image=imagecreatetruecolor(800, 800);
imagecopyresampled($dst_50_image, $src_image, 0, 0, 0, 0, 50, 50, $src_w, $src_h);
imagecopyresampled($dst_220_image, $src_image, 0, 0, 0, 0, 220, 220, $src_w, $src_h);
imagecopyresampled($dst_350_image, $src_image, 0, 0, 0, 0, 350, 350, $src_w, $src_h);
imagecopyresampled($dst_800_image, $src_image, 0, 0, 0, 0, 800, 800, $src_w, $src_h);

//imagejpeg($dst_image);	//单类型写法
$outFun($dst_50_image,"uploads/image_50/".$filename);
$outFun($dst_220_image,"uploads/image_220/".$filename);
$outFun($dst_350_image,"uploads/image_350/".$filename);
$outFun($dst_800_image,"uploads/image_800/".$filename);

imagedestroy($src_image);
imagedestroy($dst_50_image);
imagedestroy($dst_220_image);
imagedestroy($dst_350_image);
imagedestroy($dst_800_image);