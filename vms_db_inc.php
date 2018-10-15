<?php
//資料庫設定
//資料庫位置
$db_server = "localhost";

//資料庫名稱
$db_name = "vms_db";

//資料庫管理者帳號
$db_user = "root";

//資料庫管理者密碼
$db_passwd = "0930924982";


//對資料庫連線
$conn = new mysqli($db_server, $db_user, $db_passwd, $db_name) ;
if($conn->connect_error)
	die("無法對資料庫連線" . $conn->connect_error);

if(!$conn->set_charset("utf8"))
	die("can't set char: " . $conn->error);

?>
