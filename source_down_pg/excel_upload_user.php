<?php
	include_once('./tkher_db_lib.php');

	include './tkher_dbcon_Table.php';  

	/*---------------------------------------------------------------
	excel_upload_user.php : 사용자 서버에서 엑셀 화일로 데이터 일괄 생성.
	-----------------------------------------------------------------*/

	/*if( !get_session("login_id") ) {
		my_msg("You need to login. ");
		$url="/";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}*/
/*
   Data registration is batch-registered as an Excel file. : 사용자 서버에 데이터 등록을 엑셀 화일로 일괄 등록 합니다. 
*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>KAPP. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
	$pg_call = $_POST['return_pg_code'];
	$mode = $_POST['mode'];
	$return_pg_code = $_POST['return_pg_code'];
	$tab_enm = $_POST['tab_enm'];
	$tab_hnm = $_POST['tab_hnm'];
	$table_item_array = $_POST['table_item_array'];
	$f_path= "./";
	$cnt=0;

if( $mode == "Excel_Upload_mode") {
		$file_name	= $_FILES['file']['tmp_name'];
		$upday		= date("Y-m-d H:i:s");
		if( $_FILES["file"]["error"] > 0){ 
			echo "<br>Error: " . $_FILES["file"]["error"] . "<br>";	// 에러가 있으면 어떤 에러인지 출력함
		} else { 
			$ext = explode(".", $_FILES["file"]["name"]);
			if( count($ext) > 2) {
				m_( $_FILES["file"]["name"] . ", confirm `.csv` file name. $ext[0] , $ext[1]  , $ext[2], count: " . count($ext));
				echo "<script>window.open( '".$return_pg_code."' , '_self',''); </script>";
				return;
			}
			if( $ext[1] != 'csv' ) {
				m_(" $ext[0] . $ext[1] , Error File extension : csv not! "); 
				echo "<script>window.open( '".$return_pg_code."' , '_self',''); </script>";
				exit;
			}
			echo "Upload: " . $_FILES["file"]["name"] . "<br>"; 
			echo "Type: " . $_FILES["file"]["type"] . "<br>"; 
			echo "Size: " . ($_FILES["file"]["size"]) . " Byte<br>"; 
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>"; 
			move_uploaded_file( $_FILES["file"]["tmp_name"], $f_path . $_FILES["file"]["name"] );
			echo "Stored in: dup " . $f_path . $_FILES["file"]["name"]; 
			//Stored in: dup ./ABC_2026-03-30.csv
			$csv_file1 = $f_path . $_FILES["file"]["name"];
			if( ($handle = fopen( $csv_file1, "r")) != FALSE) {
				$list = array();
				$list = explode("@", $table_item_array);
				$item_cnt = count( $list ) -1;
				while( ( $val = fgetcsv($handle, 4096, "," ) ) != FALSE) {
					$cnt++;
					//if( $cnt < 3 ) continue; 
					$SQL = "INSERT INTO " . $tab_enm . " SET ";
					for( $i=0; $i < $item_cnt; $i++ ){
							$ddd = $list[$i];
							$fld = explode("|", $ddd);
							if( $i==($item_cnt-1) ) {	// last column 
								if( $fld[0]=="INT" || $fld[0]=="BIGINT" || $fld[0]=="SMALLINT" || $fld[0]=="TINYINT" || $fld[0]=="MEDIUMINT" or $fld[0]=="DECIMAL" || $fld[0]=="FLOAT" || $fld[0]=="DOUBLE")
									 $SQL = $SQL . $fld[1] . " = " . $val[$i] . "  ";
								else $SQL = $SQL . $fld[1] . " = '" . $val[$i] . "'  ";
								//else $SQL = $SQL . $fld[1] . " = '" . iconv("euc-kr","utf-8",$val[$i]) . "'  ";
							}else{
								if( $fld[0]=="INT" or $fld[0]=="BIGINT" or $fld[0]=="SMALLINT" or $fld[0]=="TINYINT" or $fld[0]=="MEDIUMINT" or $fld[0]=="DECIMAL" or $fld[0]=="FLOAT" or $fld[0]=="DOUBLE")
									 $SQL = $SQL . $fld[1] . " = " . $val[$i] . ", ";
								else $SQL = $SQL . $fld[1] . " = '" . $val[$i] . "', ";
								//else $SQL = $SQL . $fld[1] . " = '" . iconv("euc-kr","utf-8",$val[$i]) . "', ";
							}
					}//for
					sql_query( $SQL );
					//printf("\n <br> sql-%s: %s \n", $i, $SQL);
					echo "<br> $cnt: sql: ".$SQL;
				}//while
			}//if
		}
		echo "<br> data count:".$cnt; //exit; //data count:17

	$rungo = $_POST['return_pg_code'];
	//echo "<script>window.open('$rungo','_self',''); </script>";
}
?>
<body bgcolor="#000000" text="yellow" topmargin="0" leftmargin="0">

<center><br>

<form name='form1' action='excel_upload_user.php' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
	<input type='hidden' name='tab_enm'	value='<?=$tab_enm?>'>
	<input type='hidden' name='tab_hnm'	value='<?=$tab_hnm?>'>
	<input type='hidden' name='mode'		value='Excel_Upload_mode'>
	<input type='hidden' name='return_pg_code'	value='<?=$return_pg_code?>'>
	<input type='hidden' name='table_item_array'	value='<?=$table_item_array?>'>
	<input type='hidden' name='pg_call'	 value='<?=$pg_call?>'>
<tr>
	<td align='center'><font color='blue'><?=$tab_hnm?> Excel File </font>: <input type="file" name="file" size="39" style='border:1 black solid;'></td>
	<td align=center>
	<input type='button'  value=' Save ' onclick='upload_func()'>
	&nbsp;&nbsp;&nbsp;<input type='button' value='Return' onclick='back_func()' >
	&nbsp;&nbsp;</td>
</tr>

<input type='hidden' name='item_cnt' value='<?=$item_cnt?>'>
</form>

<script>
function back_func(){
	pg = document.form1.pg_call.value;
	document.form1.action=pg;
	document.form1.target='_self';
	document.form1.submit();
}
function upload_func(){
	form1.mode.value='Excel_Upload_mode';
	form1.submit();
}
</script>
