<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

$Vadd = $_POST['Vadd'] ;

if($Vadd != null)
{
	doaddV($conn) ;
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
		$sql = "INSERT INTO volun_man SET name='$Vname', sex=$Vsex, location='$Vlocation', class_num=$Vclass_num, status=$Vstatus" ;
		//echo $sql . "<br>" ;
		if($Vremark != null)
		{
			$sql = $sql . ", remark='$Vremark'" ;
			//echo $sql . "<br>" ;
		}
		if(!$res = $con->query($sql))
		{
			echo "執行新增義工資料失敗" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		} else {
			echo "新增義工資料成功" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		}
	} else {
		echo "填寫資料不完整, 新增義工資料失敗" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		//vms_leave_page() ;
	}
}

	
?>
