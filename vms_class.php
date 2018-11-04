<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
header("Content-Type:text/html; charset=utf-8");

//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
vms_checkLogin() ;

vms_menu_page() ;

uncomplete_data($conn) ;

addV_form($conn) ; //新增義工的 form

function uncomplete_data($con)
{
	$sql = "SELECT * FROM volun_man" ;
	if(!$result = $con->query($sql))
	{
		echo 'volun_man query failed';
		exit ;
	}
	if($result->num_rows > 0)
	{
		echo "<center>\n" ;
		echo "<br><br><hr>\n<h2>更新未完整之義工資料</h2><br>\n" ;
		echo "<table border=\"2\" style=\"width: 800px\">\n" ;
		echo "<tbody>\n" ;
		echo "<tr><td>姓名</td><td>性別</td><td>地區</td><td>期別(填阿拉伯數字即可)</td><td>狀態</td><td>備註</td><td>執行</td></tr>\n" ;
		while ($row = $result->fetch_assoc())
		{
			if($row['sex'] == -1)
			{
				update_form($con, $row['id'], $row['name']) ;	
			}
		}
		echo "</table>\n" ;
		echo "</center>\n" ;
	}
}

function update_form($con, $id, $name)
{
	echo "<form action=\"vms_do_addV.php\" method=\"post\">" ;
	echo "<input type=\"hidden\" name=\"id\" value=\"" . $id . "\">" ;
	echo "<tr><td>" . $name . "</td>" ;
	echo "<td><select name=\"upd[" . $id . "][0]\"><option value=\"1\">男</option><option value=\"0\">女</option></select></td>" ;

	//location select menu
	echo "<td><select name=\"upd[" . $id . "][1]\">" ;
	print_loc_opt($con) ;
	echo "</select></td>" ;

	echo "<td><input type=\"text\" name=\"upd[" . $id . "][2]\" maxlength=\"10\"></td>" ;

	echo "<td><select name=\"upd[" . $id . "][3]\"><option value=\"1\">啟用</option><option value=\"0\">停用</option></select></td>" ;

	echo "<td><textarea name=\"upd[" . $id . "][4]\" cols=\"50\" rows=\"5\"></textarea></td>" ;

	echo "<td><input type=\"submit\" name=\"upd[" . $id . "][5]\" value=\"更新\"></td></tr>\n" ;
	echo "</form>\n" ;
}

function print_loc_opt($con)
{
	$sql = "SELECT * FROM class_location" ;
	if(!$result = $con->query($sql))
	{	
		echo 'class_location query failed';
		exit ;
	} else {
		if($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc())
			{
				echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>" ;
			}	
		}
	}
}

function addV_form($con)
{
	echo "<form action=\"vms_do_addV.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>新增義工資料</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>姓名</td><td>性別</td><td>地區</td><td>期別(請填阿拉伯數字)</td><td>狀態</td><td>備註</td></tr>\n" ;
	echo "<tr><td><input type=\"text\" name=\"Vname\" maxlength=\"20\"></td>" ;
	echo "<td><select name=\"Vsex\"><option value=\"1\">男</option><option value=\"0\">女</option></select></td>" ;

	//echo "<td><input type=\"text\" name=\"Vlocation\" maxlength=\"20\"></td>" ;
    //location select menu
    echo "<td><select name=\"Vlocation\">" ;
    print_loc_opt($con) ;
    echo "</select></td>" ;

	echo "<td><input type=\"text\" name=\"Vclass_num\" maxlength=\"20\"></td>" ;
	echo "<td><select name=\"Vstatus\"><option value=\"1\">啟用</option><option value=\"0\">停用</option></select></td>" ;
	echo "<td><textarea name=\"Vremark\" cols=\"50\" rows=\"5\"></textarea></td></tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"Vadd\" value=\"新增\">\n" ;
	echo "</center></form>\n" ;
}

?>
