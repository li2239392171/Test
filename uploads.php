<?php
	header('Content-type:text/html;charset=utf-8');
	//error_reporting(0);

	// var_dump($_FILES);

	// foreach ($_FILES as $v) {
	// 	var_dump($v);
	// }

	/**
	 * 构造上传文件信息
	 * @return array
	 */
	function buildInfo(){	//支持多文件和单文件混传！
		$i=0;
		foreach ($_FILES as $v) {	//	三维数组变二维
			if(is_string($v['name'])){
				//单文件
				//print_r($v['name']);
				$files[$i]=$v;
				$i++;
			}
			else
			{
				//多文件，构造格式！
				/**
				 * 遍历数组$v['name']只是作为计数器，
				 	取$key作为键值！
				 */
				foreach ($v['name'] as $key => $value) {	
					$files[$i]['name']=$v['name'][$key];
					$files[$i]['size']=$v['size'][$key];
					$files[$i]['tmp_name']=$v['tmp_name'][$key];
					$files[$i]['error']=$v['error'][$key];
					$files[$i]['type']=$v['type'][$key];
					$i++;
				}
			}			
		}
		return $files;
	}

	// $info=buildInfo();
	// var_dump($info);

	function uploadFile($path="uploads",$allowExt=array("gif","jpeg","png","jpg","wbmp"),$maxSize=2097152,$imgFlag=true){
		if(!file_exists($path)){
			mkdir($path,0777,true);
		}
		$i=0;
		$files=buildInfo();
		foreach ($files as $file) {
			if($file['error']===UPLOAD_ERR_OK){
				//检测文件的拓展名
				$ext=getExt($file['name']);
				if(!in_array($ext, $allowExt)){
					exit('非法文件类型');
				}
				if($imgFlag){
					if(!getimagesize($file['tmp_name'])){
						exit("不是真正的图片类型！");
					}
				}
				if($file['size']>$maxSize){
					exit('上传文件过大');
				}
				if(!is_uploaded_file($file['tmp_name'])){
					exit('不是通过HTTP POST方式上传上来的');
				}
				$filename=getUniName().".".$ext;
				$destination=$path."/".$filename;
				if(move_uploaded_file($file['tmp_name'], $destination)){
					$file['name']=$filename;
					unset($file['error'],$file['tmp_name'],$file['type']);	//清楚不需要的元素
					$uploadedFiles[$i]=$file;	//返回文件数组
					$i++;
				}
			}
			else{
				switch ($file['error']) {
					case 1:
						$mes="超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
						break;
					case 2:
						$mes="超过了表单设置上传文件的大小";			//UPLOAD_ERR_FORM_SIZE
						break;
					case 3:
						$mes="文件部分被上传";//UPLOAD_ERR_PARTIAL
						break;
					case 4:
						$mes="没有文件被上传";//UPLOAD_ERR_NO_FILE
						break;
					case 6:
						$mes="没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
						break;
					case 7:
						$mes="文件不可写";//UPLOAD_ERR_CANT_WRITE;
						break;
					case 8:
						$mes="由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
						break;
				}
				echo $mes;
			}
		}
		return $uploadedFiles;

	}

	$fileInfo=uploadFile();
	var_dump($fileInfo);


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


