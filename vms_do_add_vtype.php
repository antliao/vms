<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

$submit_b = $_POST['add_vtype'] ;

if($submit_b != null)
{
	doadd_vtype($conn) ;
}

function doadd_vtype($con)
{
	$vt_name = $_POST['vtype_name'] ;
	//$vt_sdate = $_POST['vtype_sdate'] ;
	//$vt_edate = $_POST['vtype_edate'] ;
	$vt_status = $_POST['vtype_status'] ;
	$vt_remark = $_POST['vtype_remark'] ;

	if($vt_name != null && $vt_status != null)
	{
		$sql = "INSERT INTO vtype SET name='$vt_name', status=$vt_status" ;
		if($vt_remark != null)
		{
			$sql = $sql . ", remark='$vt_remark'" ;
		}
		if(!$res = $con->query($sql))
		{
			echo "<br>" . $sql . "<br>" ; 
			echo "執行新增工作群組失敗" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		} else {
			echo "新增工作群組成功" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		}
	} else {
		echo "填寫資料不完整, 新增工作群組失敗" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
	}
}

	
?>
