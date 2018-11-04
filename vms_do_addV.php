<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

if(isset($_POST['Vadd']))
{
	doaddV($conn) ;
}

if(isset($_POST['upd']))
{
	$upd = $_POST['upd'] ;
	$id = $_POST['id'] ;
	doUpdA($conn, $upd, $id) ;
}

function doUpdA($con, $up, $id)
{
	//echo "<pre>" ;
	//echo "id -> " . $id . "\n" ;
	//echo "0 -> " . $up[$id][0] . "\n" ;
	//echo "1 -> " . $up[$id][1] . "\n" ;
	//echo "2 -> " . $up[$id][2] . "\n" ;
	//echo "3 -> " . $up[$id][3] . "\n" ;
	if($up[$id][5] != null)
	{
		doUpdB($con, $up[$id], $id) ;
		exit ;
	}
	//echo "</pre>" ;
}

function doUpdB($con, $up, $id)
{
	if($up[0] != null && $up[1] != null && $up[2] != null && $up[3] != null)
	{
		check_class($up[1], $up[2], $con) ;
		$s = "UPDATE volun_man SET sex=" . $up[0] . ", location=" . $up[1] . ", class_num=" . $up[2] . ", status=" . $up[3] ;
	} else {
		echo "更新失敗，請注意，除了備註欄之外，每個欄位都必須填寫" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
	}
	if($up[4] != null)
	{
		$s = $s . ", remark=\'" . $up[4] ;
	}
	$s = $s . " WHERE id=" . $id ;

	if(!$res = $con->query($s))
	{
		echo "更新失敗，請注意資料是否填寫錯誤" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
	} else {
		echo "學員資料更新成功" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
	}
}

function check_class($loc, $num, $con)
{
	$s = "SELECT * FROM class WHERE loc_id=" . $loc . " AND num=" . $num ;
	if(!$result = $con->query($s))
	{
		echo "失敗，無法查詢 class table" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
		exit ;
	} else {
		if($result->num_rows != 1)
		{
			echo "失敗，期別資料不存在或不正確" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
			exit ;
		}
	}
}

function doaddV($con)
{
	$Vname = $_POST['Vname'] ;
	$Vsex = $_POST['Vsex'] ;
	$Vlocation = $_POST['Vlocation'] ;
	$Vclass_num = $_POST['Vclass_num'] ;
	$Vstatus = $_POST['Vstatus'] ;
	$Vremark = $_POST['Vremark'] ;

	if($Vname != null && $Vsex != null && $Vlocation != null && $Vclass_num != null && $Vstatus != null)
	{
		check_class($Vlocation, $Vclass_num, $con) ;
		$sql = "INSERT INTO volun_man SET name='$Vname', sex=$Vsex, location=$Vlocation, class_num=$Vclass_num, status=$Vstatus" ;
		//echo $sql . "<br>" ;
		if($Vremark != null)
		{
			$sql = $sql . ", remark='$Vremark'" ;
			//echo $sql . "<br>" ;
		}
		if(!$res = $con->query($sql))
		{
			echo "執行新增義工資料失敗" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
		} else {
			echo "新增義工資料成功" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
		}
	} else {
		echo "填寫資料不完整, 新增義工資料失敗" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_class.php">' ;
		//vms_leave_page() ;
	}
}

	
?>
