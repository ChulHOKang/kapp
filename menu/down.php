<?php
	include_once('../tkher_start_necessary.php');
	//include_once('../cratree/func/my_func.php');
	include "./infor.php";

//$file_id = $_REQUEST['file_id'];
$no = $_REQUEST[no];

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

//$fileDir = $in_dir;	//	"./".$in_dir;
$fullPath = $line['file_path'] . "/" . $line['file_name'];	//$fileDir."/".$ff;
$length = filesize($fullPath);

//$length = $line[file_size];	//filesize($fullPath);

//m_(" $fullPath : $length ,  --- no:$no, infor:$infor , $afile, $ff");
// ./file/dao/dao_1549071466.jpg : 1307087 ,  --- no:8, infor:115 , IMG_00263.jpg, dao_1549071466.jpg


header("Content-Type: application/octet-stream");
header("Content-Length: $length");
header("Content-Disposition: attachment; filename=".$afile);
//header("Content-Disposition: attachment; filename=".iconv('utf-8','euc-kr',$afile));
//header("Content-Disposition: attachment; filename=".iconv('euc-kr','utf-8',$afile));
header("Content-Transfer-Encoding: binary");

$fh = fopen($fullPath, "r");
fpassthru($fh);


exit;

?>