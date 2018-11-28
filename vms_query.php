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
print_page_start('VMS 統計', $js) ;

vms_checkLogin() ;

vms_menu_page() ;

$vtype_nameA = array() ;
$volun_man_nameA = array() ;
$vtype_nameA = get_vtype_name($conn) ;
$volun_man_nameA = get_volun_man_name($conn) ;

query_single_form($conn) ; //單個義工查詢
show_single_query($conn, $vtype_nameA) ;

query_all_form($conn) ; //全體查詢
show_all_query($conn, $vtype_nameA, $volun_man_nameA) ;

function get_vtype_name($con)
{
	$vtype_sql = "SELECT * FROM vtype" ;
	if(!$result = $con->query($vtype_sql))
	{
		echo 'vtype query failed';
	} else {
		if($result->num_rows > 0)
		{
			echo "<pre>\n" ;
			while ($row = $result->fetch_assoc()) {
				$vtypeA[$row['id']] = $row['name'] ;
				//echo $row['id'] . "     " . $row['name'] . "\n";
				//echo $vtypeA[$row['id']] . "     " . $row['name'] . "\n" ;
			}
			echo "</pre>" ;
		}
	}
	return $vtypeA ;
}

function get_volun_man_name($con)
{
	$v_sql = "SELECT * FROM volun_man" ;
	if(!$result = $con->query($v_sql))
	{
		echo 'volun_man_name query failed';
	} else {
		if($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc()) {
				$vlunA[$row['id']] = $row['name'] ;
			}
		}
	}
	return $vlunA ;
}

function query_single_form($con)
{
	echo "<form action=\"vms_query.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>單人義工參與工作查詢</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>姓名</td><td>起日</td><td>迄日</td></tr>\n" ;

	#echo "<tr><td><select name=\"volun_man_id\">" ;
	#print_volun_man_name_opt($con) ;
	#echo "</select></td>" ;

	echo "<td><input type=\"text\" name=\"volun_man_name\" maxlength=\"20\"</td>" ;
	echo "<td><input type=\"text\" id=\"sfrom\" readonly=\"readonly\" name=\"s_date\" maxlength=\"20\"</td>" ;
	echo "<td><input type=\"text\" id=\"sto\" readonly=\"readonly\" name=\"e_date\" maxlength=\"20\"</td>" ;

	echo "</tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"qsingle\" value=\"查詢\">\n" ;
	echo "</center></form>\n" ;
}

function show_single_query($con, $vtypeA)
{
	$button = $_POST['qsingle'] ;
	#$volun_man_id = $_POST['volun_man_id'] ;
	$volun_man_name = $_POST['volun_man_name'] ;
	$sdate = $_POST['s_date'] ;
	$edate = $_POST['e_date'] ;

	#if($button == null || $volun_man_id == null || $sdate == null || $edate == null)
	if($button == null || $volun_man_name == null || $sdate == null || $edate == null)
		return ;

	$volun_man_id = get_member_id_by_name($con, $volun_man_name) ;

	$sql = "SELECT * FROM volun_atten WHERE date BETWEEN '$sdate' AND '$edate' AND volun_man_id = '$volun_man_id' ORDER BY date" ;
	//echo $sql ;
	//exit;
	if(!$result = $con->query($sql))
	{
		echo 'query failed' ;
	} else {
		$member_name = get_member_name_by_id($con, $volun_man_id) ;
		if($result->num_rows > 0)
		{
		    echo "<center>\n" ;
			echo '<br><br><h3>義工：' . $member_name . '於&nbsp;&nbsp;' . $sdate . '&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;' . $edate . '&nbsp;&nbsp;共有&nbsp;' . $result->num_rows . '&nbsp;筆參與工作紀錄</h3><br>' ;

			echo "<table border=\"2\" style=\"width: 800px\">\n" ;
			echo "<tbody>\n" ;
			echo "<tr><td>工作群組</td><td>日期</td></tr>" ;
			while ($row = $result->fetch_assoc()) {	
				//echo "<tr><td>" . $row['vtype_id'] . "</td><td>" . $row['date'] . "</td></tr>" ;
				echo "<tr><td>" . $vtypeA[$row['vtype_id']] . "</td><td>" . $row['date'] . "</td></tr>" ;
			}
			echo "</table>\n" ;
			echo "</center>\n" ;
		} else {
		    echo "<center>\n" ;
			echo '<br><br><hr><h3>義工：' . $volun_man_id . '於&nbsp;&nbsp;' . $sdate . '&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;' . $edate . '&nbsp;&nbsp;間無工作紀錄</h3><br>' ;
			echo "</center>\n" ;
		}
	}
}

function get_member_id_by_name($con, $name)
{
	$sql = "SELECT id FROM volun_man WHERE name='$name'" ;
	if(!$result = $con->query($sql))
	{
		echo 'query name from volun_man failed' ;
		exit ;
	} else {
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc() ;
			return $row['id'] ;
		} else {
			echo 'no such name in volun_man' ;
			exit ;
		}
	}
}

function get_member_name_by_id($con, $id)
{
	$sql = "SELECT name FROM volun_man WHERE id=$id" ;
	if(!$result = $con->query($sql))
	{
		echo 'query name from volun_man failed' ;
		exit ;
	} else {
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc() ;
			return $row['name'] ;
		} else {
			echo 'no id in volun_man' ;
			exit ;
		}
	}
}

function query_all_form($con)
{
	echo "<form action=\"vms_query.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<br><br><hr>\n<h2>全體義工參與工作查詢</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 800px\">\n" ;
	echo "<tbody>\n" ;
	echo "<tr><td>起日</td><td>迄日</td></tr>\n" ;

	echo "</tr><td><input type=\"text\" id=\"afrom\" readonly=\"readonly\" name=\"s_date\" maxlength=\"20\"</td>" ;
	echo "<td><input type=\"text\" id=\"ato\" readonly=\"readonly\" name=\"e_date\" maxlength=\"20\"</td>" ;

	echo "</tr>\n" ;
	echo "</table>\n" ;
	echo "<br><br><input type=\"submit\" name=\"qall\" value=\"查詢\">\n" ;
	echo "</center></form>\n" ;
}

function show_all_query($con, $vtA, $vlA)
{
	$button = $_POST['qall'] ;
	$sdate = $_POST['s_date'] ;
	$edate = $_POST['e_date'] ;

	if($button == null || $sdate == null || $edate == null)
		return ;


	$sql = "SELECT * FROM volun_atten WHERE date BETWEEN '$sdate' AND '$edate' ORDER BY date" ;
	//echo $sql ;
	//exit;
	if(!$result = $con->query($sql))
	{
		echo 'query failed' ;
	} else {
		if($result->num_rows > 0)
		{
		    echo "<center>\n" ;
			echo '<br><br><h3>於&nbsp;&nbsp;' . $sdate . '&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;' . $edate . '&nbsp;&nbsp;共有&nbsp;' . $result->num_rows . '&nbsp;筆工作紀錄</h3><br>' ;
			echo "<table border=\"2\" style=\"width: 800px\">\n" ;
			echo "<tbody>\n" ;
			echo "<tr><td>姓名</td><td>工作群組</td><td>日期</td></tr>" ;
			while ($row = $result->fetch_assoc()) {	
				echo "<tr><td>" . $vlA[$row['volun_man_id']] . "</td><td>" . $vtA[$row['vtype_id']] . "</td><td>" . $row['date'] . "</td></tr>" ;
			}
			echo "</table>\n" ;
		} else {
			echo '<br>於&nbsp;&nbsp;' . $sdate . '&nbsp;&nbsp;&nbsp;~&nbsp;&nbsp;&nbsp;' . $edate . '&nbsp;&nbsp;間無紀錄' ;
		}
	}
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
	$v_sql = "SELECT * FROM volun_man" ;
	if(!$result = $con->query($v_sql))
	{
		echo 'volun_man_name query failed';
	} else {
		if($result->num_rows > 0)
		{
			while ($row = $result->fetch_assoc()) {
				echo "<option value=\"". $row['id'] . "\">" . $row['name'] . "</option>" ;
			}
		}
	}
}


?>
