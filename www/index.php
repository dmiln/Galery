<?php

include 'resize.php';
$ni = "normalimages/";
$si = "smallimages/";
$cols = 3; // Количество столбцов в будущей таблице с картинками
$k = 0; //вспомогательный счетчик
$files = scandir($ni); // Берём всё содержимое директории
$small = scandir($si);// скан маленьких

/*удаление неиспользуемых маленьких картинок*/
for($j = 0; $j < count($small); $j++){
	if (($small[$j] != ".") &&  ($small[$j] != "..")){
        $a = /*$dir.*/$small[$j];
		if(!in_array($a, $files)){
			unlink($si.$a);
		}
	}
} 

/* Вывод галереи */
echo "<table>"; // Начинаем таблицу
for ($i = 0; $i < count($files); $i++) { // Перебираем все файлы
	if (($files[$i] != ".") &&  ($files[$i] != "..")) { // Текущий каталог и родительский пропускаем
		if(($k % $cols) == 0){
			echo "<tr>"; // Добавляем новую строку
		}
		echo "<td>"; // Начинаем столбец
		$path = /*$dir.*/$files[$i]; // Получаем путь к картинке
		$tmp = 'normalimages/'.$path;
		echo "<a href='showbig.php?name=$path'><img src='smallimages/$path'>";
		save($tmp);
		echo "</a>";
		echo "</td>"; // Закрываем столбец
		if ((($k+1) % $cols == 0) || (($i + 1) == count($files))){
			echo "</tr>";
		}
		$k++;
	}
}
echo "</table>"; // Закрываем таблицу

?>