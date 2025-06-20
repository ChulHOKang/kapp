<?php
	include_once('../tkher_start_necessary.php');
	include "./infor.php";

$no = $_REQUEST['no'];

$query = "SELECT * from aboard_$mf_infor[2] where no = '$no' ";
$result = sql_query( $query );
$line = sql_fetch_array($result);

//$book_name = $line[book_name];
$doc_userid = $line['id'];
$title		= $line['subject'];
$content	= $line['context'];
$in_dir		= $line['file_path'];	//substr($line[in_date],0,7);
$ff			= $line['file_name'];
$afile		= $line['file_wonbon'];	//원본화일명칭.
$file_size	= $line['file_size'];

//$fileDir = $in_dir;	//	"./".$in_dir;
$fullPath = $line['file_path'] . "/" . $line['file_name'];	//$fileDir."/".$ff;

	header("Pragma: public");
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$afile");
//	header("Content-Disposition: attachment; filename=".iconv('utf-8','euc-kr',$afile));
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: $file_size");

	ob_clean();
	flush();
	readfile($fullPath);

exit;
?>