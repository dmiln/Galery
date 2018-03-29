<?php

$name = "normalimages/".$_GET['name'];
//echo "вывод полноразмерной картинки: ".$name;
if(file_exists($name)){
		list ($width, $height, $type, $attr) = getimagesize($name);
		$w = $width;
		$h = $height;
		/* Пытаемся открыть */
		if($type == 1){
			$im = @imagecreatefromgif($name);
		}elseif ($type == 2){
			$im = @imagecreatefromjpeg($name);
		}else if($type == 3){
			$im = @imagecreatefrompng($name);
		}
		
	}
	/* Если не удалось открыть картнику*/
if(!$im){
    /* Создаем пустое изображение */
    $im  = @imagecreatetruecolor($width, $height);
	$bgc = imagecolorallocate($im, 0, 0, 255);// фон
	$textcolor  = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, $width, $height, $bgc);
	/* Выводим сообщение об ошибке */
	imagestring($im, 5, 5, 5, 'Error', $textcolor);
//если открыли, добавляем водяной знак
}else{
	$textcolor  = imagecolorallocate($im, 0, 0, 255);//синий текст
	imagestring($im, 5, 5, 5, 'Dima@', $textcolor);
}

if(function_exists('imagegif')){
		// для GIF
		header('Content-Type: image/gif');
		imagegif($im);
	}elseif(function_exists('imagejpeg')){
		// для JPEG
		header('Content-Type: image/jpeg');
		imagejpeg($im,NULL, 100);
	}elseif(function_exists('imagepng')){
		// для PNG
		header('Content-Type: image/png');
		imagepng($im);
	}else{
		imagedestroy($im);
		die('В этом PHP сервере нет поддержки изображений');
	}

?>