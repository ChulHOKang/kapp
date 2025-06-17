<?php
	include_once('../tkher_start_necessary.php');

	$ss_mb_id	= get_session("ss_mb_id");
	$H_ID	= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$H_NAME = $member['mb_name'];
	$mode    = $_POST['mode'];

if( $mode=='memo_insertTT' ){	// memoD.php, board_data_listTT.php - detailD.php - memoTT.php 메모등록시에 처리한다. 2019-01-26
		$context    = $_POST['context'];
		$board_name = $_POST['board_name'];
		$list_no    = $_POST['list_no'];
		$password = $_POST['password'];
		if( !$H_NAME ) $H_NAME = 'Guest';
		if( !$H_ID ) $H_ID='Guest';
		$in_date = time(); // $in_day= date("Y-m-d H:i");

		$query = "insert into {$tkher['aboard_memo_table']} set board_name='$board_name', list_no=$list_no, name='$H_NAME', memo='$context', in_date='$in_date', password='$password', id='$H_ID' ";
		$mq = sql_query($query);
		if(!$mq){
			echo "detailD_memoD_write sql: " . $query;
			echo("<script>alert('memo Insert Error')</script>");
			exit;
		} else {
			m_("$call_pg - Memo OK");
		}
	if( isset($_POST['call_pg']) ) $call_pg = $_POST['call_pg'];
	else if( isset($_REQUEST['call_pg']) ) $call_pg = $_REQUEST['call_pg'];
	else $call_pg = ''; 

	echo "<meta http-equiv='refresh' content=0;url='".$call_pg."?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";

	//if( $call_pg == 'list1_detail')
	//	echo "<meta http-equiv='refresh' content=0;url='list1_detail.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
	//else
	//	echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
}
?>