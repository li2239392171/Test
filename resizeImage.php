<?php 		//固定类型缩略图
$filename="1469674635.jpg";
$src_image=imagecreatefromjpeg($filename);	//	生成画布资源
list($src_w,$src_h)=getimagesize($filename);	//得到原图片的宽和高
$scale=0.5;	//	缩放比例
$dst_w=ceil($src_w*$scale);		//进1取整
$dst_h=ceil($src_h*$scale);
$dst_image=imagecreatetruecolor($dst_w, $dst_h);	//创建新画布
imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);	//将画布重采样拷贝到目标画布上
header("content-type:image/jpeg");
imagejpeg($dst_image);
imagedestroy($src_image);
imagedestroy($dst_image);