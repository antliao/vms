<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

add_vtype_form() ; //新增工作群組的 form

function add_vtype_form()
{
	echo "<form action=\"vms_do_add_vtype.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>新增工作群組</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>名稱</td><td>開始日期</td><td>結束日期</td><td>狀態</td><td>備註</td></tr>\n" ;
	echo "<tr><td><input type=\"text\" name=\"vtype_name\" maxlength=\"25\"</td>" ;
	echo "<td><input type=\"text\" name=\"vtype_sdate\" maxlength=\"25\"</td>" ;
	echo "<td><input type=\"text\" name=\"vtype_edate\" maxlength=\"25\"</td>" ;
	echo "<td><select name=\"vtype_status\"><option value=\"1\">啟用</option><option value=\"0\">停用</option></select></td>" ;
	echo "<td><textarea name=\"vtype_remark\" cols=\"50\" rows=\"5\"></textarea></td></tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"add_vtype\" value=\"新增\">\n" ;
	echo "</center></form>\n" ;
}

?>
