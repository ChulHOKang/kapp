<?php
	include_once('../tkher_start_necessary.php');
	//$file_id = $_REQUEST['file_id'];
	$num    = $_REQUEST['num'];
	$query  = "SELECT * from {$tkher['webeditor_table']} where num = '$num' ";
	$result = sql_query( $query );
	$line   = sql_fetch_array($result);
	$book_name  = $line['book_name'];
	$doc_userid = $line['user'];
	$title   = $line['title'];
	$content = $line['content'];
	$in_dir  = substr($line['date'],0,7);
	$ff    = $line['up_file'];
	$afile = $line['align'];	//원본화일명칭.

	$fileDir = "./".$in_dir;
	$fullPath = $fileDir."/".$ff;
	$length = filesize($fullPath);

	header("Content-Type: application/octet-stream");
	header("Content-Length: $length");
	header("Content-Disposition: attachment; filename=".iconv('utf-8','euc-kr',$afile));
	header("Content-Transfer-Encoding: binary");

	$fh = fopen($fullPath, "r");
	fpassthru($fh);
	exit;
?>