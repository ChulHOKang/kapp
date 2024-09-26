<?php
	include_once('./tkher_start_necessary.php');

	$ss_mb_id		= get_session("ss_mb_id");	//"ss_mb_id";
	$ss_mb_level	= $member['mb_level'];			//get_session("ss_mb_level");   //"ss_mb_id";
	$H_ID			= get_session("ss_mb_id");  
	$H_LEV			= $ss_mb_level;
	$from_session_id= get_session("ss_mb_id");  
	if( !$H_ID ) {
		my_msg("You need to login. ");
		$url="./";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<?php
	m_("mode:". $mode);
	$mode = $_POST['mode'];
	$tab_enm = $_POST['tab_enm'];
	$tab_hnm = $_POST['tab_hnm'];
	$f_path= KAPP_PATH_T_ . "/data/file/";
if($mode == "Excel_Upload_mode") {
		$item_array = $_POST['item_array'];
		$if_type		= $_POST['if_type'];
		$item_cnt	= $_POST['item_cnt'];
		$file_name	= $_FILES['file']['tmp_name'];
		$upday		= date("Y-m-d H:i:s");
		if ( $_FILES["file"]["error"] > 0){ 
			echo "Return Code: " . $_FILES["file"]["error"] . "<br>";	// 에러가 있으면 어떤 에러인지 출력함
			m_("error : " . $file_name);
		} else { 
			$ext = explode(".", $_FILES["file"]["name"]);
			if( $ext[1] != 'csv' ) {
				m_(" $ext[0] . $ext[1] , Error File extension : csv not! "); 
				echo "<script>window.open( 'table10i.php' , '_self',''); </script>";
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
					$list = explode("@", $item_array);
					$cnt=0;
					while ( ( $val = fgetcsv($handle, 4096, "," ) ) !== FALSE) {
						$cnt++;
						if( $cnt < 3 ) continue; 
						$SQL = "INSERT INTO " . $tab_enm . " SET ";
						for ( $i=0; $list[$i] != ""; $i++ ){
								$ddd = $list[$i];
								$fld = explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
								if( $i==($item_cnt-1) ) {	//마지막 컬럼 확인.
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
						printf("\n <br> sql-%s: %s \n", $i, $SQL);
					}//while
				}//if
		}
		echo " data count:".$i;
}
?>
<body bgcolor="#000000" text="yellow" topmargin="0" leftmargin="0">
<center><br>
<form name='form1' action='excel_load.php' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
<input type='hidden' name='tab_enm'	value='<?=$tab_enm?>'>
<input type='hidden' name='tab_hnm'	value='<?=$tab_hnm?>'>
<input type='hidden' name='mode'	value='Excel_Upload_mode'>
<TH>Register the CSV file as data.</TH><!-- 엑셀 화일을 데이터로 등록합니다. -->
<br>
<TH>
	<td align='center'><font color='blue'><?=$tab_hnm?> CSV File </font>: <input type="file" name="file" size="39" style='border:1 black solid;'></td>
	<td align='center'>
	<input type='button'  value=' Save ' onclick='upload_func();'>
	&nbsp;</td>
</TH>
<?php
		$SQL = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_name='$tab_hnm' ";
		$result = sql_query( $SQL );
		if( $result ){
			$rsPG	= sql_fetch_array($result);
			$item_array = $rsPG['item_array'];
			$if_type	= $rsPG['if_type'];
			$tab_enm	= $rsPG['tab_enm'];
			$tab_hnm	= $rsPG['tab_hnm'];
			$item_cnt	= $rsPG['item_cnt'];
			$list = array();
			$list = explode("@", $item_array);
			$SQLT = "SELECT * from $tab_enm ";
			$resultT = sql_query( $SQLT );
			$total  = sql_num_rows($resultT);
				echo "
					<table border=1>
						<tr>
							<td colspan='$item_cnt' align=center>$tab_hnm( $tab_enm ) data:$total</td>
						</tr>
				";
			for( $i=0; $i < $item_cnt; $i++ ){
				$ddd  = $list[$i];
				$fld = explode("|", $ddd);
				$tit = $fld[2];
				echo " <td>$tit</td> ";
			}
			if( $total > 0 ){
				echo "
						</tr>
						<tr>
				";
				while ( $row = sql_fetch_array( $resultT) ) {
?>
					<tr>
<?php
					for( $i=0, $j=1; $i < $item_cnt; $i++,$j++){
						$ddd  = $list[$i];
						$fld = explode("|", $ddd);		// 36|fld_2|전화폰|2
						$fff = $fld[1];
						$data = $row[$fff];
						echo " <td>$data</td> ";
					}
?>
					</tr>
<?php
				}//while
			}//if
				echo "</table>";
		} else {
			echo "
				<tr>
					<td align='center'> $tab_hnm Table is data no found &nbsp;</td>
				</tr>
			";
		}
			echo "<br>
				<TH><input type='button' value='Return' onclick='history.back(-1)' ></YH>
			";
?>
<input type='hidden' name='item_array'	value='<?=$item_array?>'>
<input type='hidden' name='if_type'		value='<?=$if_type?>'>
<input type='hidden' name='item_cnt'	value='<?=$item_cnt?>'>
</form>
<script>
<!--
function upload_func(){
	//alert("upload func");
	val = form1.file.value;
	//alert("val:" + val);
	ret = image_ext_chk(val);
	if( ret == false ) {
		alert("error ret: False" );
		return false;
	} else {
		//alert("ret: T" );
		form1.mode.value='Excel_Upload_mode';
		form1.submit();
	}
}
function image_ext_chk(val) {
    var result = true;
    var f_len = val.length;
    var f_ext = val.lastIndexOf(".");
    var f_type = val.substring(f_ext+1, f_len).toLowerCase();
    if( f_type != "csv" ) {
		alert("Only .csv files are possible."); //.csv file 만 가능합니다.
        result = false;
    }
    return result;
}
//-->
 </script>
