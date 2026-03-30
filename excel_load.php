<?php
	include_once('./tkher_start_necessary.php');

	$H_ID= get_session("ss_mb_id");
	$H_LEV= $member['mb_level'];
	if( !$H_ID ) {
		m_("You need to login. ");
		$url="./";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="./icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>
<?php
	$mode = $_POST['mode'];
	$pg_call = $_POST['pg_call'];
	$page = $_POST['page'];
	$line_cnt = $_POST['line_cnt'];
	$tab_enm = $_POST['tab_enm'];
	$tab_hnm = $_POST['tab_hnm'];
	$f_path= KAPP_PATH_T_ . "/data/file/";
if( $mode == "Excel_Upload_mode") {
		$table_item_array = $_POST['table_item_array'];
		$if_type		= $_POST['if_type'];
		$item_cnt	= $_POST['item_cnt'];
		$file_name	= $_FILES['file']['tmp_name'];
		$upday		= date("Y-m-d H:i:s");
		if ( $_FILES["file"]["error"] > 0){ 
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			m_("error : " . $file_name);
		} else { 
			$ext = explode(".", $_FILES["file"]["name"]);
			if( $ext[1] != 'csv' ) {
				m_(" $ext[0] . $ext[1] , Error File extension : csv not! "); 
				echo "<script>window.open( '".$pg_call."' , '_self',''); </script>";
				exit;
			}
			echo "Upload: " . $_FILES["file"]["name"] . "<br>"; 
			echo "Type: " . $_FILES["file"]["type"] . "<br>"; 
			echo "Size: " . ($_FILES["file"]["size"]) . " Byte<br>"; 
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>"; 
				move_uploaded_file($_FILES["file"]["tmp_name"], $f_path . $_FILES["file"]["name"] );
				echo "Stored in: dup " . $f_path . $_FILES["file"]["name"]; 
				$csv_file1 = $f_path . $_FILES["file"]["name"];
				if (($handle = fopen($csv_file1, "r")) !== FALSE) {
					$list = array();
					$list = explode("@", $table_item_array);
					$cnt=0;
					while( ( $val = fgetcsv($handle, 4096, "," ) ) !== FALSE) {
						$cnt++;
						//if( $cnt < 3 ) continue; 
						$SQL = "INSERT INTO " . $tab_enm . " SET ";
						for( $i=0; $list[$i] != ""; $i++ ){
								$ddd = $list[$i];
								$fld = explode("|", $ddd);		//  36|fld_2|phone|2
								if( $i==($item_cnt-1) ) {	// last column
									if( $fld[0]=="INT" or $fld[0]=="BIGINT" or $fld[0]=="SMALLINT" or $fld[0]=="TINYINT" or $fld[0]=="MEDIUMINT" or $fld[0]=="DECIMAL" or $fld[0]=="FLOAT" or $fld[0]=="DOUBLE")
										 $SQL = $SQL . $fld[1] . " = '" . $val[$i] . "'  ";
									else $SQL = $SQL . $fld[1] . " = '" . iconv("euc-kr","utf-8",$val[$i]) . "'  ";
								}else{
									if( $fld[0]=="INT" or $fld[0]=="BIGINT" or $fld[0]=="SMALLINT" or $fld[0]=="TINYINT" or $fld[0]=="MEDIUMINT" or $fld[0]=="DECIMAL" or $fld[0]=="FLOAT" or $fld[0]=="DOUBLE")
										 $SQL = $SQL . $fld[1] . " = '" . $val[$i] . "', ";
									else $SQL = $SQL . $fld[1] . " = '" . iconv("euc-kr","utf-8",$val[$i]) . "', ";
								}
						}//for
						sql_query( $SQL );
						//printf("\n <br> sql-%s: %s \n", $i, $SQL);
						echo "<br> $cnt: sql: ".$SQL;
					}//while
				}//if
		}
		echo "<br> data count:".$cnt;
}
?>
<body bgcolor="#000000" text="yellow" topmargin="0" leftmargin="0">
<center><br>
<form name='form1' action='excel_load.php' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
	<input type='hidden' name='tab_enm'	value='<?=$tab_enm?>'>
	<input type='hidden' name='tab_hnm'	value='<?=$tab_hnm?>'>
	<input type='hidden' name='page'	value='<?=$page?>'>
	<input type='hidden' name='line_cnt' value='<?=$line_cnt?>'>
	<input type='hidden' name='pg_call'	 value='<?=$pg_call?>'>
	<input type='hidden' name='mode'	 value='Excel_Upload_mode'>
<TH>Register the CSV file as data.</TH>
<br>
<TH>
	<td align='center'><font color='blue'><?=$tab_hnm?> CSV File </font>: <input type="file" name="file" size="39" style='border:1 black solid;'></td>
	<td align='center'>
	<input type='button'  value=' Save ' onclick='upload_func();'>
	&nbsp;&nbsp;&nbsp;<input type='button' value='Return' onclick='back_func()' >
	&nbsp;</td>
</TH>
	<input type='hidden' name='table_item_array'	value='<?=$table_item_array?>'>
	<input type='hidden' name='if_type'		value='<?=$if_type?>'>
	<input type='hidden' name='item_cnt'	value='<?=$item_cnt?>'>
</form>
<script>
<!--
function back_func(){
	pg = document.form1.pg_call.value;
	document.form1.action=pg;
	document.form1.target='_self';
	document.form1.submit();
}
function upload_func(){
	val = document.form1.file.value;
	ret = image_ext_chk(val);
	if( ret == false ) {
		alert("error ret: False" );
		return false;
	} else {
		document.form1.mode.value='Excel_Upload_mode';
		document.form1.submit();
	}
}
function image_ext_chk(val) {
    var result = true;
    var f_len = val.length;
    var f_ext = val.lastIndexOf(".");
    var f_type = val.substring(f_ext+1, f_len).toLowerCase();
    if( f_type != "csv" ) {
		alert("Only .csv files are possible.");
        result = false;
    }
    return result;
}
//-->
 </script>
