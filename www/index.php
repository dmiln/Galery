<?php

include 'resize.php';
$ni = "normalimages/";
$si = "smallimages/";
$cols = 3; // ���������� �������� � ������� ������� � ����������
$k = 0; //��������������� �������
$files = scandir($ni); // ���� �� ���������� ����������
$small = scandir($si);// ���� ���������

/*�������� �������������� ��������� ��������*/
for($j = 0; $j < count($small); $j++){
	if (($small[$j] != ".") &&  ($small[$j] != "..")){
        $a = /*$dir.*/$small[$j];
		if(!in_array($a, $files)){
			unlink($si.$a);
		}
	}
} 

/* ����� ������� */
echo "<table>"; // �������� �������
for ($i = 0; $i < count($files); $i++) { // ���������� ��� �����
	if (($files[$i] != ".") &&  ($files[$i] != "..")) { // ������� ������� � ������������ ����������
		if(($k % $cols) == 0){
			echo "<tr>"; // ��������� ����� ������
		}
		echo "<td>"; // �������� �������
		$path = /*$dir.*/$files[$i]; // �������� ���� � ��������
		$tmp = 'normalimages/'.$path;
		echo "<a href='showbig.php?name=$path'><img src='smallimages/$path'>";
		save($tmp);
		echo "</a>";
		echo "</td>"; // ��������� �������
		if ((($k+1) % $cols == 0) || (($i + 1) == count($files))){
			echo "</tr>";
		}
		$k++;
	}
}
echo "</table>"; // ��������� �������

?>