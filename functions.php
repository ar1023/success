<?php 
    // 全体で頻繁に使用する関数

function m($db, $value) {
	return mysqli_real_escape_string($db, $value);
}
?>
