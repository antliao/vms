<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

			

addV_form() ; //新增義工的 form
add_atten_form($conn) ; //義工簽到的 form


function addV_form()
{
	echo "<form action=\"vms_do_addV.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>新增義工資料</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>姓名</td><td>性別</td><td>地區</td><td>期別</td><td>狀態</td><td>備註</td></tr>\n" ;
	echo "<tr><td><input type=\"text\" name=\"Vname\" maxlength=\"20\"</td>" ;
	echo "<td><select name=\"Vsex\"><option value=\"1\">男</option><option value=\"0\">女</option></select></td>" ;
	echo "<td><input type=\"text\" name=\"Vlocation\" maxlength=\"20\"</td>" ;
	echo "<td><input type=\"text\" name=\"Vclass_num\" maxlength=\"20\"</td>" ;
	echo "<td><select name=\"Vstatus\"><option value=\"1\">啟用</option><option value=\"0\">停用</option></select></td>" ;
	echo "<td><textarea name=\"Vremark\" cols=\"50\" rows=\"5\"></textarea></td></tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"Vadd\" value=\"新增\">\n" ;
	echo "</center></form>\n" ;
}

function add_atten_form($con)
{
	echo "<form action=\"vms_do_addVatt.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>義工簽到填寫</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>日期</td><td>組別</td><td>姓名</td><td>起時</td><td>起分</td><td>迄時</td><td>迄分</td></tr>\n" ;
	echo "<tr><td><input type=\"text\" name=\"att_date\" maxlength=\"20\"</td>" ;
	echo "<td><select name=\"vtype_name\">" ;
	print_vtype_name_opt($con) ;
	echo "</select></td>" ;

	echo "<td><select name=\"volun_man_name\">" ;
	print_volun_man_name_opt($con) ;
	echo "</select></td>" ;

	echo "<td><select name=\"stime_h\">" ;
	print_stime_h_opt() ;
	echo "</select></td>" ;

	echo "<td><select name=\"stime_h\"><option value=\"1\">啟用</option><option value=\"0\">停用</option></select></td>" ;
	echo "<td><textarea name=\"att_remark\" cols=\"50\" rows=\"5\"></textarea></td></tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"att_add\" value=\"新增\">\n" ;
	echo "</center></form>\n" ;
}

function print_vtype_name_opt($con)
{
	$vtype_sql = "SELECT name FROM vtype" ;
	if(!$result = $con->query($vtype_sql))
	{
		echo 'vtype query failed';
	} else {
		if($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc()) {
				echo "<option value=\"$row['name']\">$row['name']</option>" ;
			}
		}
	}
}

function print_volun_man_name_opt($con)
{
	$v_sql = "SELECT name FROM volun_man" ;
	if(!$result = $con->query($v_sql))
	{
		echo 'volun_man_name query failed';
	} else {
		if($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc()) {
				echo "<option value=\"$row['name']\">$row['name']</option>" ;
			}
		}
	}
}

function print_stime_h_opt()
{
	for($i=0; $i<23; $i++)
	{
		echo "<option value=\"$i\">$i</option>" ;
	}
}
	
?>
