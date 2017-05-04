<?php
/**
 * 验证码生成文件
 * 0-9，a-f随机四位生成
 */
	session_start();
	header("Content-type:image/jpeg");
	$rand = null;

	for($i=0;$i<4;$i++){ //生成4位随机验证码
		$rand.=dechex(rand(0,15));  //rand随机函数，dechex将十进制转化为十六进制的函数
	}

	$_SESSION['rand'] = $rand;//将随机生成的验证码赋给session，以便等下进行判断

  
	$im = imagecreate(60,22);
	$white = imagecolorallocate($im, 255,255,255);
	$color = imagecolorallocate($im, rand(0,40),rand(0,50),rand(0,100));
  
	for($i=0;$i<10;$i++){                   //在真彩图中随机画10条线

	$te2 = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255)); 
    imageline($im, rand(0,65), 0, rand(0,25), 25, $te2);

	}

	for($i=0;$i<500;$i++){                  //在真彩图中随机画500个点
	
	$te3 = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));
	imagesetpixel($im, rand(0,65), rand(0,25), $te3);
	}

	imagettftext($im, 15, rand(-5,5), rand(0,15), rand(17,21), $color, "../fonts/arial.ttf",$rand);
	imagejpeg($im);
	imagedestroy($im);
?>
