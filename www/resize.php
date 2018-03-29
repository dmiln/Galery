<?php

/*������� �������������� ���������� �������� � ���������*/
function LoadImage($imgname)
{
	$max_h = 150;
	$max_w = 150;
	$file = basename($imgname);
	
	if(file_exists($imgname)){
		list ($width, $height, $type, $attr) = getimagesize($imgname);
		$w = $width;
		$h = $height;
		/* �������� ������� */
		if($type == 1){
			$im = @imagecreatefromgif($imgname);
		}elseif ($type == 2){
			$im = @imagecreatefromjpeg($imgname);
		}else if($type == 3){
			$im = @imagecreatefrompng($imgname);
		}
	}
	
    /* ���� �� ������� ������� ��������*/
    if(!$im)
    {
        /* ������� ������ ����������� */
        $im  = @imagecreatetruecolor(380, 40);
        $bgc = imagecolorallocate($im, 255, 255, 0);//������ ���
        $textcolor  = imagecolorallocate($im, 0, 0, 255);//����� �����
        imagefilledrectangle($im, 0, 0, 380, 40, $bgc);
        /* ������� ��������� �� ������ */
        imagestring($im, 5, 5, 5, 'ERROR: ' . $imgname." - don't exists", $textcolor);
    }
	
	/*������ ��������� ��� ���������� �����������*/
	$ratio = $width / $height;// �������� ����������� ������ �����������
	if ( $ratio == 1 ) { // ���� ������� �����
		if ( $height > $max_h ) {
		$height = $width = min($max_w, $max_h);
		}
		else {
		$width = $max_w;
		$height = $max_h;
		}
	}
	else if ( $ratio > 1 ) { // ���� ������ ������ ������
		$height = ( $height * $max_w ) / $width;
		$width = $max_w;
	}
	else if ( $ratio < 1 ) { // ���� ������ ������
		$width = ( $width * $max_h ) / $height;
		$height = $max_h;
	}
	
	/*�������� �������� �������� �� ��������� �����*/
	$small_image = @imagecreatetruecolor($max_w, $max_h);
	$bgc = imagecolorallocate($small_image, 128, 128, 128);//����� ���
	$textcolor  = imagecolorallocate($small_image, 255, 255, 0);//������ �����
	imagefilledrectangle($small_image, 0, 0, $max_w, $max_h, $bgc);
	imagecopyresampled($small_image, $im, round(($max_w - $width) / 2), round(($max_h - $height) / 2), 0, 0, $width, $height, $w, $h);
    return $small_image;
	//return $file;
}

/*������� ������ �������� �� �����*/
function print_im($i){
	$file = basename($i);
	echo '<img src="/smallimages/' .$file.'">';
}

/*���������� ������� ��������, ��� ��������� � ����� �����*/
function save($i){
	$file = basename($i);
	$image = LoadImage($i);
	if(function_exists('imagegif')){
		// ��� GIF
		imagegif($image, $_SERVER['DOCUMENT_ROOT'].'/www/smallimages/'.$file);
	}elseif(function_exists('imagejpeg')){
		// ��� JPEG
		imagejpeg($image,$_SERVER['DOCUMENT_ROOT'].'/www/smallimages/'.$file);
	}elseif(function_exists('imagepng')){
		// ��� PNG
		imagepng($image,$_SERVER['DOCUMENT_ROOT'].'/www/smallimages/'.$file);
	}else{
		imagedestroy($image);
		die('� ���� PHP ������� ��� ��������� �����������');
	}
}

?>