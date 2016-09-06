<html>
<head>
<meta charset="utf-8">
<title>菜鸟教程(runoob.com)</title>
</head>
<body>

<?php
	// 允许上传的图片后缀
	$allowedExtS=array("gif","jpg","jpeg","png");
	$temp=explode(".",$_FILES['file']['name']);
	$extension=end($temp);	// 获取文件后缀名

	if((($_FILES['file']['type']=="image/gif")||
		($_FILES['file']['type']=="image/jpg")||
		($_FILES['file']['type']=="image/jpeg")||
		($_FILES['file']['type']=="image/png"))&&
		($_FILES['file']['size']<2000000)&&
		in_array($extension,$allowedExtS)
		)
	{
		if($_FILES["file"]["error"]){
			echo "错误：".$_FILES['file']['error']."<br>";
		}
		else{
			echo "上传文件名：".$_FILES['file']['name']."<br>";
			echo "文件类型：".$_FILES['file']['type']."<br>";
			echo "文件大小：".($_FILES['file']['size']/1024)."KB <br>";
			echo "文件临时存储位置：".$_FILES['file']['tmp_name']."<br>";

			// 判断当期目录下的 upload 目录是否存在该文件
			// 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
			if(file_exists(iconv("UTF-8","gb2312", "upload/".$_FILES['file']['name']))){
				echo "文件已存在！";
			}
			else{

				// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
				$t=time();

				move_uploaded_file($_FILES['file']['tmp_name'],iconv("UTF-8","gb2312", "upload/".$_FILES['file']['name']));		//避免文件名中午乱码
				echo "文件存储在：upload/".$_FILES['file']['name'];

				//move_uploaded_file($_FILES['file']['tmp_name'],"upload/".$t.".".$extension);
				//echo "文件存储在：upload/".$t.".".$extension;
			}
		}
	}
	else{
		echo "文件格式非法！";
	}
	
?>

</body>
</html>