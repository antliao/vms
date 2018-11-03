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

?>
