<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("vms_db_inc.php");
include("vms_common.php");
$id = $_POST['id'];
$pw = $_POST['pw'];
$status = 0 ;

if($id != null && $pw != null)
{
	$sql = "SELECT pw FROM vms_users WHERE name = '$id'" ;
	if(!$result = $conn->query($sql))
		echo 'query failed';

	if($result->num_rows == 1)
	{
		$row = $result->fetch_assoc() ;
		//echo $pw ;
		//echo $row['pw'] ;
		if($row['pw'] == $pw)
			$status = 1 ;
	}
}

if($status == 1)
{
	$_SESSION['username'] = $id;
	echo '登入成功!';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=vms_edit.php>';
}
else
{
	vms_leave_page() ;
}
	
?>
