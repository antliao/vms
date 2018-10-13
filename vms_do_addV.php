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
	doaddV() ;
}

function doaddV()
{
	$Vname = $_POST['Vname'] ;
	$Vsex = $_POST['Vsex'] ;
	$Vclass = $_POST['Vclass'] ;
	$Vstatus = $_POST['Vstatus'] ;
	$Vremark = $_POST['Vremark'] ;

	if($Vname != null && $Vsex != null && $Vclass != null && $Vstatus != null)
	{
		$sql = "INSERT INTO vul_management SET name=\'$Vname\', sex=\'$Vsex\', class=\'$Vclass\', status=\'$Vstatus\'" ;
		if($Vremard != null)
		{
			$sql = $sql . ", remark=\"$Vremark\"" ;
		}
		if(!$res = $conn->query($sql))
		{
			echo "新增義工資料失敗" ;
			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		}
	} else {
		echo "新增義工資料失敗" ;
		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
		//vms_leave_page() ;
	}
}

	
?>
