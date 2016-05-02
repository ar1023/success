<?php

	session_start();
	require('../dbconnect.php');
	require('../functions.php');

// 仮のログインユーザーデータ
$_SESSION['id'] = 1;
$_SESSION['time'] = time();

// ログイン判定
if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time() ) {
    $_SESSION['time'] = time();

    $sql = sprintf('SELECT * FROM members WHERE id=%d',
        m($db, $_SESSION['id'])
    );
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));

    // ログインしているのユーザーのデータ
    $member = mysqli_fetch_assoc($record);
} else {
    header('Location: signin.php');
    exit();
}

// コンテンツがPNG画像であることをブラウザにお知らせ 
header ('Content-Type: image/jpg');
 
// オリジナル画像のファイルパスを指定
$original_file = $member['picture_path'];
 
// getimagesize関数 オリジナル画像の横幅・高さを取得
list($original_width, $original_height) = getimagesize($original_file);
 
// サムネイルの横幅を指定
$thumb_width = 200;
 
// サムネイルの高さを算出 round関数で四捨五入
$thumb_height = round( $original_height * $thumb_width / $original_width );
 
// オリジナルファイルの画像リソース
$original_image = imagecreatefrompng($original_file);
 
// サムネイルの画像リソース
$thumb_image = imagecreatetruecolor($thumb_width, $thumb_height);
 
// サムネイル画像の作成
imagecopyresized($thumb_image, $original_image, 10, 10, 10, 10,
                 $thumb_width, $thumb_height,
                 $original_width, $original_height);
 
// サムネイル画像の出力
imagepng($thumb_image);
 
// 画像リソースを破棄
imagedestroy($original_image);
imagedestroy($thumb_image);

?>