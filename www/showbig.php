<?php

$name = "normalimages/".$_GET['name'];
//echo "����� �������������� ��������: ".$name;
if(file_exists($name)){
		list ($width, $height, $type, $attr) = getimagesize($name);
		$w = $width;
		$h = $height;
		/* �������� ������� */
		if($type == 1){
			$im = @imagecreatefromgif($name);
		}elseif ($type == 2){
			$im = @imagecreatefromjpeg($name);
		}else if($type == 3){
			$im = @imagecreatefrompng($name);
		}
		
	}
	/* ���� �� ������� ������� ��������*/
if(!$im){
    /* ������� ������ ����������� */
    $im  = @imagecreatetruecolor($width, $height);
	$bgc = imagecolorallocate($im, 0, 0, 255);// ���
	$textcolor  = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, $width, $height, $bgc);
	/* ������� ��������� �� ������ */
	imagestring($im, 5, 5, 5, 'Error', $textcolor);
//���� �������, ��������� ������� ����
}else{
	$textcolor  = imagecolorallocate($im, 0, 0, 255);//����� �����
	imagestring($im, 5, 5, 5, 'Dima@', $textcolor);
}

if(function_exists('imagegif')){
		// ��� GIF
		header('Content-Type: image/gif');
		imagegif($im);
	}elseif(function_exists('imagejpeg')){
		// ��� JPEG
		header('Content-Type: image/jpeg');
		imagejpeg($im,NULL, 100);
	}elseif(function_exists('imagepng')){
		// ��� PNG
		header('Content-Type: image/png');
		imagepng($im);
	}else{
		imagedestroy($im);
		die('� ���� PHP ������� ��� ��������� �����������');
	}

?>