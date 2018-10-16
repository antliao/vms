<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//general start -- important
include("vms_db_inc.php");
include("vms_common.php");
$js = '<script>
	$( function() {
		$( "#sfrom" ).datepicker({
			dateFormat: "yy-mm-dd"
		}),
		$( "#sto" ).datepicker({
			dateFormat: "yy-mm-dd"
		}),
		$( "#afrom" ).datepicker({
			dateFormat: "yy-mm-dd"
		}),
		$( "#ato" ).datepicker({
			dateFormat: "yy-mm-dd"
		})
	} );
	</script>' ;
		#$( "#datepicker" ).datepicker();
print_page_start('VMS 統計', $js) ;

vms_checkLogin() ;

vms_menu_page() ;


query_single_form($conn) ; //單個義工查詢
query_all_form($conn) ; //全體查詢


function query_single_form($con)
{
	echo "<form action=\"vms_do_single_query.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>單人義工參與工作查詢</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>姓名</td><td>起日</td><td>迄日</td></tr>\n" ;

	echo "<tr><td><select name=\"volun_man_name\">" ;
	print_volun_man_name_opt($con) ;
	echo "</select></td>" ;

	echo "<td><input type=\"text\" id=\"sfrom\" readonly=\"readonly\" name=\"s_date\" maxlength=\"20\"</td>" ;
	echo "<td><input type=\"text\" id=\"sto\" readonly=\"readonly\" name=\"e_date\" maxlength=\"20\"</td>" ;

	echo "</tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"qsingle\" value=\"查詢\">\n" ;
	echo "</center></form>\n" ;
}

function query_all_form($con)
{
	echo "<form action=\"vms_do_single_query.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>全體義工參與工作查詢</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>起日</td><td>迄日</td></tr>\n" ;

	echo "</tr><td><input type=\"text\" id=\"afrom\" readonly=\"readonly\" name=\"s_date\" maxlength=\"20\"</td>" ;
	echo "<td><input type=\"text\" id=\"ato\" readonly=\"readonly\" name=\"e_date\" maxlength=\"20\"</td>" ;

	echo "</tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"qsingle\" value=\"查詢\">\n" ;
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
				echo "<option value=\"" . $row['name'] . "\">" . $row['name'] . "</option>" ;
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


?>
