<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

init_default_data($conn) ;

function init_default_data($con)
{
	init_class_location($con) ;
	init_class($con) ;
	init_vtype($con) ;
}

function init_vtype($con)
{
	do_insert_vtype('2018聖淨土', $con) ;
	do_insert_vtype('紅樹林精進站', $con) ;
}

function do_insert_vtype($name, $con)
{
	$sql = "INSERT INTO vtype SET name='$name'" ;
	//echo $sql ;
	if(!$res = $con->query($sql))
	{
		echo "執行新增 vtype 失敗" ;
		echo $sql ;
	} 
}



function init_class($con)
{
	$taipei = 183 ;
	$taichun = 124 ;
	$kowshung = 114 ;
	for($i=1;$i<=$taipei; $i++)
	{
		do_insert_cl(1, $i, $con) ;
	}
	for($i=1;$i<=$taichun; $i++)
	{
		do_insert_cl(2, $i, $con) ;
	}
	for($i=1;$i<=$kowshung; $i++)
	{
		do_insert_cl(3, $i, $con) ;
	}
}

function do_insert_cl($loc, $num, $con)
{
	$sql = "INSERT INTO class SET loc_id=$loc, num=$num" ;
	if(!$res = $con->query($sql))
	{
		echo "執行新增 class 失敗" ;
		echo $sql ;
	} 
}


function init_class_location($con)
{
	do_insert_loc('台灣台北', $con) ;
	do_insert_loc('台灣台中', $con) ;
	do_insert_loc('台灣高雄', $con) ;
	do_insert_loc('日本橫濱', $con) ;
	do_insert_loc('美國夏威夷', $con) ;
	do_insert_loc('美國洛杉磯', $con) ;
	do_insert_loc('美國舊金山', $con) ;
	do_insert_loc('加拿大溫哥華', $con) ;
	do_insert_loc('加拿大多倫多', $con) ;
}

function do_insert_loc($name, $con)
{
	$sql = "INSERT INTO class_location SET name='$name'" ;
	//echo $sql ;
	if(!$res = $con->query($sql))
	{
		echo "執行新增 location 失敗" ;
		echo $sql ;
	} 
}

?>
