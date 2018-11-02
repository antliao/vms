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
$addc = $_POST['att_add_c'] ;

if($add != null)
{
	doaddVatt($conn) ;
}

if($addc != null)
{
	doaddVatt_do($conn) ;
}

//add after confirmed
function doaddVatt_do($con)
{
	$attd = $_POST['attd'] ;
	$vtid = $_POST['vtid'] ;

	if($attd == null || $vtid == null)
	{
		echo "<pre>Wrong Data</pre>" ;
		exit ;
	}

	//insert the records only single name matched
	$oneL = $_POST['onelist'] ;
	$c = 0 ;
	if(isset($oneL))
	{
		$c = count($oneL) ;
	}
	//echo "<br>" ;
	for($i=0;$i<$c;$i++)
	{
		//echo $oneL[$i] . "<br>" ;
		do_insert_att($oneL[$i], $attd, $vtid, $con) ;
	}

	//insert the records multi names matched
	$mulL = $_POST['mullist'] ;
	$c = 0 ;
	if(isset($mulL))
	{
		$c = count($mulL) ;
	}
	echo "<br><pre>" ;
	for($i=0;$i<$c;$i=$i+2)
	{
		$j = $i + 1 ;
		if($mulL[$i] != null)
		{
			//echo $mulL[$i] ;
			//echo $mulL[$j] ;
			do_insert_att($mulL[$j], $attd, $vtid, $con) ;
		}
	}
	echo "</pre>" ;

	//insert the records no name matched
	$newL = $_POST['newlist'] ;
	$c = 0 ;
	if(isset($newL))
	{
		$c = count($newL) ;
	}
	echo "<br><pre>" ;
	for($i=0;$i<$c;$i++)
	{
		$id = do_insert_new($newL[$i], $con) ;
		if($id != -1)
		{
			//echo $id ;
			do_insert_att($id, $attd, $vtid, $con) ;
		} 
	}
	echo "</pre>" ;

	echo "新增義工簽到資料完成" ;
	echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;

}

function do_insert_new($name, $con)
{
	$sql = "INSERT INTO volun_man SET name='$name'" ;
	$r = -1 ;
	//echo $sql ;
	if(!$res = $con->query($sql))
	{
		echo "執行新增義工資料失敗" ;
		echo $sql ;
		return $r ;
	} else {
		$r = $con->insert_id ;
		return $r ;
	}
}

function do_insert_att($vid, $attd, $vtid, $con)
{
	$sql = "INSERT INTO volun_atten SET date='$attd', vtype_id=$vtid, volun_man_id=$vid" ;
	if(!$res = $con->query($sql))
	{
		echo '<pre>' ;
		echo '新增義工簽到至資料庫時，出現問題' ;
		echo $sql ;
		echo '</pre>' ;
	}
}

//add with batch method
function doaddVatt($con)
{
	$att_date = $_POST['att_date'] ;
	$vtype_id = $_POST['vtype_id'] ;
	$att_names = $_POST['att_names'] ;
	$att_remark = $_POST['att_remark'] ;
	$att_names = preg_replace("/\s/","",$att_names);

	if($att_date != null && $vtype_id != null && $att_names != null)
	{
		//echo '<pre>' . $att_names . '</pre>' ;
		//echo '<hr>' ;
		$att_names_h = check_attnames($att_names, $con) ;
		if($att_names_h == null)
		{
			echo 'parsing names failed' ;
			exit ;
		} else {
			echo '<pre>' ;
			print_confirm_att_names_forms($att_names_h, $att_date, $vtype_id, $att_remark) ;
			echo '</pre>' ;
		}
	}

}

function print_confirm_att_names_forms($att_names_hh, $att_d, $vt_id, $att_r)
{
	echo "<form action=\"vms_do_addVatt.php\" method=\"post\">" ;
	echo "<center>\n" ;
	echo "<h2>請確認以下資料是否正確以進行新增" . $att_d . "義工簽到</h2><br>" ;

	echo "<input type=\"hidden\" name=\"attd\" value=\"" . $att_d . "\">" ;
	echo "<input type=\"hidden\" name=\"vtid\" value=\"" . $vt_id . "\">" ;
	if($att_r != null)
		echo "<input type=\"hidden\" name=\"attr\" value=\"" . $att_r . "\">" ;

	echo "<br><br><hr>\n<h2>義工(學員資料無符合姓名)</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 600px\">\n" ;
	echo "<tbody>\n" ;
	$c = count($att_names_hh[0]) ;
	for($i=0; $i<$c; $i++)
	{
		echo "<tr>" ;
		echo "<td>" . $att_names_hh[0][$i] . "</td>" ;
		echo "<td><input type=\"checkbox\" checked=\"checked\" name=\"newlist[]\" value=\"" . $att_names_hh[0][$i] . "\"></td></tr>" ;
	}
	echo "</tbody></table>" ;

	echo "<br><br><hr>\n<h2>義工(學員資料一筆姓名符合)</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 600px\">\n" ;
	echo "<tbody>\n" ;
	$c = count($att_names_hh[1]) ;
	for($i=0; $i<$c; $i++)
	{
		echo "<tr>" ;
		echo "<td>" . $att_names_hh[1][$i][0] . "</td>" ;
		echo "<td><table border=\"1\" width=\"100%\"><tr><td>Dist</td><td>class</td><td><input type=\"checkbox\" checked=\"checked\" name=\"onelist[]\" value=\"" . $att_names_hh[1][$i][1] . "\"></td></tr></table></td></tr>" ;
		//echo "<td><input type=\"checkbox\" checked=\"checked\" name=\"onelist[]\" value=\"" . $att_names_hh[1][$i][1] . "\"></td></tr>" ;
		//echo "<tr><td>" . $att_names_hh[1][$i][0] . "</td><td>" . $att_names_hh[1][$i][1] . "</td><td>" . $att_names_hh[1][$i][2] . "</td></tr>" ;
	}
	echo "</tbody></table>" ;

	echo "<br><br><hr>\n<h2>義工(學員資料多筆姓名符合)</h2><br>\n" ;
	echo "<table border=\"2\" style=\"width: 600px\">\n" ;
	echo "<tbody>\n" ;
	$c = count($att_names_hh[2]) ;
	for($i=0; $i<$c; $i++)
	{
		$c2 = count($att_names_hh[2][$i]) ;
		$k = $i*2 ;
		$l = $k + 1 ;
		echo "<tr><td>" . $att_names_hh[2][$i][0] . "</td>" ;
		echo "<td>" ;
		for($j=1; $j<$c2; $j=$j+2)
		{
			echo "<table border=\"1\" width=\"100%\"><tr><td>Dist</td><td>class</td><td><input type=\"radio\" name=\"mullist[" . $l . "]\" value=\"" . $att_names_hh[2][$i][$j] . "\" checked></td></tr></table>" ;
			//echo "<table border=\"1\" width=\"100%\"><tr><td>Dist</td><td>class</td><td><input type=\"checkbox\" checked=\"checked\" name=\"mullist[" . $i . "]\" value=\"" . $att_names_hh[2][$i][$j] . "\"></td></tr></table>" ;
			//echo $att_names_hh[2][$i][$j] . "--->" . $att_names_hh[2][$i][$j+1] . "<br>" ;
		}
		echo "</td>" ;
		echo "<td><input type=\"checkbox\" checked=\"checked\" name=\"mullist[" . $k . "]\" value=\"" . $att_names_hh[2][$i][0] . "\"></td>" ;
		echo "</tr>" ;
	}
	echo "</tbody></table>" ;

	echo "<br><br><input type=\"submit\" name=\"att_add_c\" value=\"送出\">\n" ;
	echo "</form>" ;
}

function check_attnames($names, $con)
{
	$names_a = preg_split('/,/', $names);
	$m = count($names_a) ;
	$names_h = array() ;
	$du_count = -1 ;
	$si_count = -1 ;
	for($i=0; $i<$m; $i++)
	{
		$tmp = $names_a[$i] ;
		$s = "SELECT * FROM volun_man WHERE name = '$tmp'" ;
		if(!$result = $con->query($s))
		{
			echo 'query table volun_man failed';
			exit ;
		} else {
			if($result->num_rows == 0)
			{
				$names_h[0][] = $names_a[$i] ;
			}
			if($result->num_rows == 1)
			{
				$si_count++ ;
				$row = $result->fetch_assoc() ;
				$names_h[1][$si_count][] = $names_a[$i] ;
				$names_h[1][$si_count][] = $row['id'] ;
				$names_h[1][$si_count][] = $row['name'] ;
			}
			if($result->num_rows > 1)
			{
				$du_count++ ;
				$names_h[2][$du_count][] = $names_a[$i] ;
				while ($row = $result->fetch_assoc()) {
					$names_h[2][$du_count][] = $row['id'] ;
					$names_h[2][$du_count][] = $row['name'] ;
				}
			}
		}
	}
	return $names_h ;
}

//old one
//function doaddVatt($con)
//{
//	$att_date = $_POST['att_date'] ;
//	$vtype_name = $_POST['vtype_name'] ;
//	$volun_man_name = $_POST['volun_man_name'] ;
//	$stime_h = $_POST['stime_h'] ;
//	$stime_m = $_POST['stime_m'] ;
//	$etime_h = $_POST['etime_h'] ;
//	$etime_m = $_POST['etime_m'] ;
//	$att_status = $_POST['att_status'] ;
//	$att_remark = $_POST['att_remark'] ;
//
//	if($att_date != null && $vtype_name != null && $volun_man_name != null && $stime_h != null && $stime_m != null && $etime_h != null && $etime_m != null && $att_status != null)
//	{
//		$sql = "INSERT INTO volun_atten SET date='$att_date', vtype_name='$vtype_name', volun_man_name='$volun_man_name', stime_h=$stime_h, stime_m=$stime_m, etime_h=$etime_h, etime_m=$etime_m, status='$att_status'" ;
//		//echo $sql . "<br>" ;
//		//exit ;
//		if($att_remark != null)
//		{
//			$sql = $sql . ", remark='$att_remark'" ;
//			//echo $sql . "<br>" ;
//		}
//		if(!$res = $con->query($sql))
//		{
//			echo "執行義工簽到資料失敗" ;
//			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
//		} else {
//			echo "新增義工簽到資料成功" ;
//			echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
//		}
//	} else {
//		echo "填寫資料不完整, 新增義工簽到資料失敗" ;
//		echo '<meta http-equiv=REFRESH CONTENT=2;url="vms_man.php">' ;
//		//vms_leave_page() ;
//	}
//}

	
?>
