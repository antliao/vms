<?php
//資料庫設定
//資料庫位置
$db_server = "localhost";

//資料庫名稱
$db_name = "vms_db";

//資料庫管理者帳號
$db_user = "root";

//資料庫管理者密碼
$db_passwd = "0930924982";


//對資料庫連線
$conn = new mysqli($db_server, $db_user, $db_passwd, $db_name) ;
if($conn->connect_error)
	die("無法對資料庫連線" . $conn->connect_error);

function cut_content($a,$b){
	$sub_content = mb_substr($a, 0, $b, 'UTF-8'); //擷取子字串
	return($sub_content) ;
	//echo $sub_content;  //顯示處理後的摘要文字
	//顯示 "......"
    //if (strlen($a) > strlen($sub_content)) echo "...";
}

function get_item(&$items, &$ix)
{
	$sql = "SELECT name,ix FROM yu_paper_item order by ix";
	$result = mysql_query($sql);
	while($row = mysql_fetch_row($result))
	{
		$items[] = $row[0] ;
		$ix[] = $row[1] ;
	}
}


function get_paper($p_id, $item)
{
	global $gmax ;
	$tmp_id = -1 ;
	$prev_id = -1 ;
	$next_id = -1 ;
	$get_flag = 0 ;
	$count = 0 ;
	$total = 0 ;
	$p_id_count = -1 ;

	$sql = "SELECT * FROM yu_article where id=$p_id and post_status='publish' and item_ix=$item";
	$result = mysql_query($sql);
	if(count($result) <= 0)
		return ;
	while($row = mysql_fetch_row($result))
	{
		echo "$row[4]" ;
	}
	
	//產生上一篇，下一篇，回上層的連結
	$sql = "SELECT id FROM yu_article where post_status='publish' and item_ix=$item order by id";
	$result = mysql_query($sql);
	//$total = count($result) ;
	$total = mysql_num_rows($result) ;
	while($row = mysql_fetch_row($result))
	{
		$count ++ ;
		if($row[0] == $p_id)
		{
			$get_flag = 1 ;
			$p_id_count = $count ;
			$prev_id = $tmp_id ;
		} else if($get_flag == 1)
		{
			$next_id = $row[0] ;
			break ;
		}
		$tmp_id = $row[0] ;
	}
	//echo "<br><br><center>\n" ;
	echo "<br><br>\n" ; 
	for($i=0;$i<35;$i++)
	{
		echo "&nbsp;" ;
	}
	echo "\n" ;

	if($prev_id != -1)
	{
		echo "<a href=\"sundon.php?item=$item&p_id=$prev_id\">上一篇</a>\n" ;
	} else {
		echo "上一篇\n" ;
	}
	echo "&nbsp;&nbsp;&nbsp;&nbsp;" ;

	$list_id = floor(($total - $p_id_count + 1)/$gmax) + 1 ;
	echo "<a href=\"sundon.php?item=$item&list_id=$list_id\">回上層</a>\n" ;
	echo "&nbsp;&nbsp;&nbsp;&nbsp;" ;

	if($last_pages > 0)
		$list_count = $list_count + 1 ;
	if($next_id != -1)
	{
		echo "<a href=\"sundon.php?item=$item&p_id=$next_id\">下一篇</a>\n" ;
	} else {
		echo "下一篇\n" ;
	}
	//echo "</center>\n" ;
}

function get_list($list_id, $item)
{
	global $gmax ;

	// 先得出此 item 中 pulbich 的文章有多少篇
	$sql0 = "SELECT id FROM yu_article where post_status='publish' and item_ix=$item order by id";
	$result = mysql_query($sql0);
	$paper_count = mysql_num_rows($result) ;
		
	if($paper_count <= 0)
		return ;
	// 每個 list 有 $gmax 篇文章
	// 每個 list 頁面最多顯示 $gmax 個 list link

	// 先計算共有多少 list
	$last_pages = $paper_count % $gmax ;
	$list_count = floor($paper_count / $gmax) ;
	if($last_pages > 0)
		$list_count = $list_count + 1 ;
		
	// 先計算共有多少 list 頁面(list_group)
	$last_list = $list_count % $gmax ;
	$list_group_count = floor($list_count/$gmax);
	if($last_list > 0)
		$list_group_count = $list_group_count + 1 ;

	// 若 list_id 小於等於 0 或是不屬於數字或超過 list count
	// 則將 list_id 設為第一個 list
	if(preg_match("/^[0-9]+$/i", $list_id))
	{
		if($list_id <= 0 || $list_id > $list_count)
			$list_id = 1 ;
	} else {
		$list_id = 1 ;
	}

	$first_pnum = ($list_id - 1)*$gmax ;
	$sql = "SELECT id, post_sum_title,post_sum_text,post_sum_img FROM yu_article where post_status='publish' and item_ix=$item order by id desc limit $first_pnum,$gmax";
	$result = mysql_query($sql);
		
	show_list_num($list_id, $list_count, $list_group_count,$item) ;
	echo "\t\t<div class=\"text\">\n" ;
	while($row = mysql_fetch_row($result))
	{
		echo "<div id=\"p_list\">\n" ;
		// 因為圖片 html 中可能會有 br，所以額外處理
		preg_match("/src=\"\S+/", $row[3], $matches) ;
		echo "<img $matches[0]>" ;

		echo "\t<div id=\"pltext\">\n" ;
		//echo "\t\t<div class=\"text\">\n" ;
		echo "\t\t\t<h2>$row[1]</h2>\n" ;

		$row[2] = cut_content($row[2], 80) ;
		echo "\t\t\t<p>$row[2]" ;
		echo "&nbsp\n" ;
		echo "<a href='sundon.php?item=$item&p_id=$row[0]'>...閱讀全文</a></p>\n" ;

		//echo "\t\t</div>\n" ;
		echo "\t</div>\n" ;
		echo "</div>\n" ;
		echo "<hr>\n" ;
	}
	echo "</div>\n" ;

	show_list_num($list_id, $list_count, $list_group_count,$item) ;
	//$tmp_remain = $list_id % $gmax ;
	//$list_group_index = floor($list_id / $gmax) ;
	//if($tmp_remain > 0)
	//	$list_group_index = $list_group_index + 1 ;
	//
	//echo "<br><br><div align=\"center\">\n" ;
	//$list_group_prev = $list_group_index - 1 ;
	//$list_num_prev = $list_group_prev * $gmax ;
	//$list_num = $list_group_index * $gmax - $gmax + 1 ;
	//if($list_group_index > 1)
	//	echo "<a href='sundon.php?list_id=$list_num_prev'>&lt;&lt;</a>&nbsp;&nbsp;" ;

	//for($i=0;$i<$gmax;$i++)
	//{
	//	$list_n = $list_num + $i ;
	//	if($list_n <= $list_count)
	//	{
	//		if($list_id != $list_n)
	//		{
	//			echo "<a href='sundon.php?list_id=$list_n'>$list_n</a>&nbsp;&nbsp;" ;
	//		} else {
	//			echo "$list_n&nbsp;&nbsp;" ;
	//		}
	//	}
	//}
	//$list_group_next = $list_group_index + 1 ;
	//$list_num_next = $list_group_next * $gmax - $gmax + 1 ;
	//if($list_group_index < $list_group_count)
	//	echo "&nbsp;&nbsp;<a href='sundon.php?list_id=$list_num_prev'>&gt;&gt;</a>" ;

	//echo "</div>\n" ;

}

function show_list_num($list_id, $list_count, $list_group_count,$item)
{
	global $gmax ;

	$tmp_remain = $list_id % $gmax ;
	$list_group_index = floor($list_id / $gmax) ;
	if($tmp_remain > 0)
		$list_group_index = $list_group_index + 1 ;
	
	echo "<br><br><div align=\"center\">\n" ;
	$list_group_prev = $list_group_index - 1 ;
	$list_num_prev = $list_group_prev * $gmax ;
	$list_num = $list_group_index * $gmax - $gmax + 1 ;
	if($list_group_index > 1)
		echo "<a href='sundon.php?item=$item&list_id=$list_num_prev'>&lt;&lt;</a>&nbsp;&nbsp;" ;

	for($i=0;$i<$gmax;$i++)
	{
		$list_n = $list_num + $i ;
		if($list_n <= $list_count)
		{
			if($list_id != $list_n)
			{
				echo "<a href='sundon.php?item=$item&list_id=$list_n'>$list_n</a>&nbsp;&nbsp;" ;
			} else {
				echo "$list_n&nbsp;&nbsp;" ;
			}
		}
	}
	$list_group_next = $list_group_index + 1 ;
	$list_num_next = $list_group_next * $gmax - $gmax + 1 ;
	if($list_group_index < $list_group_count)
		echo "&nbsp;&nbsp;<a href='sundon.php?item=$item&list_id=$list_num_prev'>&gt;&gt;</a>" ;

	echo "</div>\n" ;
}
?>
