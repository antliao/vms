<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

$add = $_POST['att_add'] ;

if($add != null)
{
	doaddVatt($conn) ;
}

function doaddVatt($con)
{
	$att_date = $_POST['att_date'] ;
	$vtype_name = $_POST['vtype_name'] ;
	$volun_man_name = $_POST['volun_man_name'] ;
	$stime_h = $_POST['stime_h'] ;
	$stime_m = $_POST['stime_m'] ;
	$etime_h = $_POST['etime_h'] ;
	$etime_m = $_POST['etime_m'] ;
	$att_status = $_POST['att_status'] ;
	$att_remark = $_POST['att_remark'] ;

	if($att_date != null && $vtype_name != null && $volun_man_name != null && $stime_h != null && $stime_m != null && $etime_h != null && $etime_m != null && $att_status != null)
	{
		$sql = "INSERT INTO volun_atten SET date='$att_date', vtype_name='$vtype_name', volun_man_name='$volun_man_name', stime_h=$stime_h, stime_m=$stime_m, etime_h=$etime_h, etime_m=$etime_m, status='$att_status'" ;
		//echo $sql . "<br>" ;
		//exit ;
		if($att_remark != null)
		{
			$sql = $sql . ", remark='$att_remark'" ;
			//echo $sql . "<br>" ;
		}
		if(!$res = $con->query($sql))
		{
			echo "執行義工簽到資料失敗" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		} else {
			echo "新增義工簽到資料成功" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		}
	} else {
		echo "填寫資料不完整, 新增義工簽到資料失敗" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		//vms_leave_page() ;
	}
}

	
?>
