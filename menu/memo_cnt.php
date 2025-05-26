<?php
function memo_count($board,$no){
	global $tkher;
	$board_name ="aboard_" . $board;
	$query      ="select no from {$tkher['aboard_memo_table']} where board_name='$board_name' and list_no=".$no;
	$mq =sql_query($query);
	$mn =sql_num_rows($mq);
	$memo_cnt="";
	if($mn){ $memo_cnt="($mn)";}
	else { $memo_cnt="(0)";}
	return $memo_cnt;
}
?>