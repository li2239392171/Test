<?php 	//多类型图片缩略图函数封装
$filename="1469674199.jpg";

thumb($filename,"uploads/image_50/".$filename,50,50,true);
thumb($filename,"uploads/image_220/".$filename,220,220,true);
thumb($filename,"uploads/image_350/".$filename,350,350,false);
thumb($filename,"uploads/image_800/".$filename,1200,1200,true);

function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSourse=false,$scale=0.5){
	list($src_w,$src_h,$imagetype)=getimagesize($filename);
	if(is_null($dst_w)||is_null($dst_h)){
		$dst_w=ceil($src_w*$scale);
		$dst_h=ceil($src_h*$scale);
	}
	$mime=image_type_to_mime_type($imagetype);
	$createFun=str_replace("/", "createfrom", $mime);
	$outFun=str_replace("/", null, $mime);
	$src_image=$createFun($filename);
	$dst_image=imagecreatetruecolor($dst_w, $dst_h);
	imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

	if($destination&&!file_exists(dirname($destination))){
		mkdir(dirname($destination),0777,true);
	}
	$dstFilename=$destination==null?getUniName().".".getExt($filename):$destination;
	$outFun($dst_image,$dstFilename);
	imagedestroy($src_image);
	imagedestroy($dst_image);
	// echo $isReservedSourse;
	// var_dump(!$isReservedSourse);
	// exit;
	if(!$isReservedSourse){
		unlink($filename);	//删除文件
	}
	return $dstFilename;

}


/**
	 * 生成唯一字符串
	 * @return string
	 */
	function getUniName(){
		return md5(uniqid(microtime(true),true));
		//return md5(uniqid(microtime()));
	}

	/**
	 * 得到文件的扩展名
	 * @param string $filename
	 * @return string
	 */
	function getExt($filename){
		//explode将字符串打散为数组，end取最后一个值，strtolower将所有字符转换成小写
		return strtolower(end(explode(".",$filename)));


		//strrchr返回字符串最后出现的位置...substr从第二位起截取字符串
		//strtolower(substr(strrchr($filename, "."), 1));
		
		//strrpos()	查找字符串在另一字符串中最后一次出现的位置（对大小写敏感）。
		//return substr($filename, strrpos($filename, '.') + 1);

		/* 使用 pathinfo
		$path=pathinfo($filename);
		$filename=$path['extension'];
		return $filename;
		*/
	}