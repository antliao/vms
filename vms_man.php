<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
$js = '<script>
	$( function() {
		$( "#datepicker" ).datepicker({
			dateFormat: "yy-mm-dd"
		});
	} );
	</script>' ;
		#$( "#datepicker" ).datepicker();
print_page_start('VMS 義工管理', $js) ;

vms_checkLogin() ;

vms_menu_page() ;

			

add_atten_form($conn) ; //義工簽到的 form

add_vtype_form() ; //新增工作群組的 form

function add_vtype_form()
{
	echo "<form action=\"vms_do_add_vtype.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>新增工作群組</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>名稱</td><td>開始日期</td><td>結束日期</td><td>狀態</td><td>備註</td></tr>\n" ;
	echo "<tr><td><input type=\"text\" name=\"vtype_name\" maxlength=\"25\"></td>" ;
	echo "<td><input type=\"text\" name=\"vtype_sdate\" maxlength=\"25\" disabled></td>" ;
	echo "<td><input type=\"text\" name=\"vtype_edate\" maxlength=\"25\" disabled></td>" ;
	echo "<td><select name=\"vtype_status\"><option value=\"1\">啟用</option><option value=\"0\">停用</option></select></td>" ;
	echo "<td><textarea name=\"vtype_remark\" cols=\"50\" rows=\"5\"></textarea></td></tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"add_vtype\" value=\"新增\">\n" ;
	echo "</center></form>\n" ;
}

function add_atten_form($con)
{
	echo "<form action=\"vms_do_addVatt.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>義工簽到填寫</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>日期</td><td>組別</td><td>姓名(每個姓名間請以半形逗號分隔)</td><td>備註</td></tr>\n" ;
	echo "<tr><td><input type=\"text\" id=\"datepicker\" readonly=\"readonly\" name=\"att_date\" maxlength=\"20\"</td>" ;
	echo "<td><select name=\"vtype_id\">" ;
	print_vtype_name_opt($con) ;
	echo "</select></td>" ;

	echo "<td><textarea name=\"att_names\" cols=\"50\" rows=\"10\"></textarea></td>\n" ;
	echo "<td><textarea name=\"att_remark\" cols=\"50\" rows=\"10\"></textarea></td></tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"att_add\" value=\"新增\">\n" ;
	echo "</center></form>\n" ;
}

function print_vtype_name_opt($con)
{
	$vtype_sql = "SELECT * FROM vtype" ;
	if(!$result = $con->query($vtype_sql))
	{
		echo 'vtype query failed';
	} else {
		if($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc()) {
				echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>" ;
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
				echo "<option value=\"". $row['name'] . "\">" . $row['name'] . "</option>" ;
			}
		}
	}
}

function print_stime_h_opt()
{
	for($i=0; $i<24; $i++)
	{
		echo "<option value=\"$i\">$i</option>" ;
	}
}

function print_stime_m_opt()
{
	for($i=0; $i<60; $i=$i+10)
	{
		echo "<option value=\"$i\">$i</option>" ;
	}
}


function print_etime_h_opt()
{
	for($i=0; $i<24; $i++)
	{
		echo "<option value=\"$i\">$i</option>" ;
	}
}
function print_etime_m_opt()
{
	for($i=0; $i<60; $i=$i+10)
	{
		echo "<option value=\"$i\">$i</option>" ;
	}
}
	
?>
