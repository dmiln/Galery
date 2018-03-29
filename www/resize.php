<?php

/*Функция преобразования нормальной картинки к маленькой*/
function LoadImage($imgname)
{
	$max_h = 150;
	$max_w = 150;
	$file = basename($imgname);
	
	if(file_exists($imgname)){
		list ($width, $height, $type, $attr) = getimagesize($imgname);
		$w = $width;
		$h = $height;
		/* Пытаемся открыть */
		if($type == 1){
			$im = @imagecreatefromgif($imgname);
		}elseif ($type == 2){
			$im = @imagecreatefromjpeg($imgname);
		}else if($type == 3){
			$im = @imagecreatefrompng($imgname);
		}
	}
	
    /* Если не удалось открыть картнику*/
    if(!$im)
    {
        /* Создаем пустое изображение */
        $im  = @imagecreatetruecolor(380, 40);
        $bgc = imagecolorallocate($im, 255, 255, 0);//желтый фон
        $textcolor  = imagecolorallocate($im, 0, 0, 255);//синий текст
        imagefilledrectangle($im, 0, 0, 380, 40, $bgc);
        /* Выводим сообщение об ошибке */
        imagestring($im, 5, 5, 5, 'ERROR: ' . $imgname." - don't exists", $textcolor);
    }
	
	/*Задаем параметры для маленького изображения*/
	$ratio = $width / $height;// получаем соотношение сторон изображения
	if ( $ratio == 1 ) { // если стороны равны
		if ( $height > $max_h ) {
		$height = $width = min($max_w, $max_h);
		}
		else {
		$width = $max_w;
		$height = $max_h;
		}
	}
	else if ( $ratio > 1 ) { // если ширина больше высоты
		$height = ( $height * $max_w ) / $width;
		$width = $max_w;
	}
	else if ( $ratio < 1 ) { // если больше высота
		$width = ( $width * $max_h ) / $height;
		$height = $max_h;
	}
	
	/*заменяем исходную картинку на маленькую копию*/
	$small_image = @imagecreatetruecolor($max_w, $max_h);
	$bgc = imagecolorallocate($small_image, 128, 128, 128);//серый фон
	$textcolor  = imagecolorallocate($small_image, 255, 255, 0);//желтый текст
	imagefilledrectangle($small_image, 0, 0, $max_w, $max_h, $bgc);
	imagecopyresampled($small_image, $im, round(($max_w - $width) / 2), round(($max_h - $height) / 2), 0, 0, $width, $height, $w, $h);
    return $small_image;
	//return $file;
}

/*Функция вывода картинки на экран*/
function print_im($i){
	$file = basename($i);
	echo '<img src="/smallimages/' .$file.'">';
}

/*Сохранение большой картинки, как маленькой в новую папку*/
function save($i){
	$file = basename($i);
	$image = LoadImage($i);
	if(function_exists('imagegif')){
		// для GIF
		imagegif($image, $_SERVER['DOCUMENT_ROOT'].'/www/smallimages/'.$file);
	}elseif(function_exists('imagejpeg')){
		// для JPEG
		imagejpeg($image,$_SERVER['DOCUMENT_ROOT'].'/www/smallimages/'.$file);
	}elseif(function_exists('imagepng')){
		// для PNG
		imagepng($image,$_SERVER['DOCUMENT_ROOT'].'/www/smallimages/'.$file);
	}else{
		imagedestroy($image);
		die('В этом PHP сервере нет поддержки изображений');
	}
}

?>