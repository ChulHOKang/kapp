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
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
	$mode = $_POST[mode];
	$return_pg_code = $_POST[return_pg_code];
	$tab_enm = $_POST[tab_enm];
	$tab_hnm = $_POST[tab_hnm];
		$item_array = $_POST[item_array];

	//$f_path= TKHER_PATH_ . "/t/data/file/";
	$f_path= "./";

	$cnt=0;

if($mode == "Excel_Upload_mode") {

		//$if_type	= $_POST[if_type];
		//$item_cnt	= $_POST[item_cnt];
		$file_name	= $_FILES['file']['tmp_name'];
		$upday		= date("Y-m-d H:i:s");

		if ( $_FILES["file"]["error"] > 0){ 
			//echo "Return Code: " . $_FILES["file"]["error"] . "<br>";	// 에러가 있으면 어떤 에러인지 출력함
		} else { 

			$ext = explode(".", $_FILES["file"]["name"]);
			if( $ext[1] != 'csv' ) {
				m_(" $ext[0] . $ext[1] , Error File extension : csv not! "); 
				echo "<script>window.open( '".$return_pg_code."' , '_self',''); </script>";
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
					$item_cnt = count( $list ) -1;
					while ( ( $val = fgetcsv($handle, 4096, "," ) ) !== FALSE) {
						$cnt++;
						if( $cnt < 3 ) continue; 
						$SQL = "INSERT INTO " . $tab_enm . " SET ";

						//for ( $i=0; $list[$i] != ""; $i++ ){
						for ( $i=0; $i < $item_cnt; $i++ ){

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

    //m_(" data count:".$i); //data count:17
	$rungo = $_POST['return_pg_code'];
	//echo "cnt:" . $cnt . ", tab: " . $tab_enm . ", ".$rungo; //exit;
	echo "<script>window.open('$rungo','_self',''); </script>";
}
?>
<body bgcolor="#000000" text="yellow" topmargin="0" leftmargin="0">

<center><br>

<form name='form1' action='excel_upload_user.php' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
<input type='hidden' name='tab_enm'	value='<?=$tab_enm?>'>
<input type='hidden' name='tab_hnm'	value='<?=$tab_hnm?>'>
<input type='hidden' name='mode'		value='Excel_Upload_mode'>
<input type='hidden' name='return_pg_code'	value='<?=$return_pg_code?>'>

<input type='hidden' name='item_array'	value='<?=$item_array?>'>

<tr>
	<td align='center'><font color='blue'><?=$tab_hnm?> Excel File </font>: <input type="file" name="file" size="39" style='border:1 black solid;'></td>
	<td align=center>
	<!-- <input type=submit  name=xmode value='등록'> -->
	<input type='button'  value=' Save ' onclick='upload_func()'>
	&nbsp;</td>
</tr>

<?php
			
		//$SQL = "select * from table10_pg where userid='$H_ID' and pg_name='$tab_hnm' ";
		//$result = sql_query( $SQL );
		//$rsPG	= sql_fetch_array($result);
		//$total  = sql_num_rows($result);

		//$item_array		= '|fld_1|caid|CHAR|6@|fld_2|caname|CHAR|30@|fld_3|caorder|TINYINT|3@';    
		//$item_array = $_POST['item_array'];
			$list = array();
			$list = explode("@", $item_array);
			$item_cnt = count( $list ) -1;
			$total = $item_cnt;
			m_("total:$total");
		if( $total > 0 ){
			//$item_array = $rsPG[item_array];
			//$if_type	= $rsPG[if_type];
			//$tab_enm	= $rsPG[tab_enm];
			//$tab_hnm	= $rsPG[tab_hnm];
			//$item_cnt	= $rsPG[item_cnt];

			//$list = array();
			//$list = explode("@", $item_array);

				echo "
					<table border=1>
						<tr>
							<td colspan='$item_cnt' align=center>$tab_hnm( $tab_enm ) cnt:$total</td>
						</tr>
						<tr>
				";

			for( $i=0; $i < $item_cnt; $i++ ){
				$ddd  = $list[$i];
				$fld = explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
				$tit = $fld[2];	// title
				echo " <td>$tit</td> ";
			}
			echo " </tr> ";
			$SQL = "select * from $tab_enm ";
			$result = sql_query( $SQL );
			$total  = sql_num_rows($result);
			if( $total > 0 ){
				while ( $row = sql_fetch_array( $result) ) {
?>
					<tr>
<?php
					for( $i=0, $j=1; $i < $item_cnt; $i++,$j++){
						$ddd  = $list[$i];
						$fld = explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
						$fff = $fld[1];	// column name
						$data = $row[$fff];
						echo " <td>$data</td> ";
					}
?>
					</tr>
<?php
				}//while
				echo "</table>";
			}//if
		} else {
			echo "
				<tr>
					<td align=center> $tab_hnm Table is data no found &nbsp;</td>
				</tr>
			";
		}	// if( $total > 0 )
?>

<input type='hidden' name='item_cnt'		value='<?=$item_cnt?>'>

</form>
<script>
function upload_func(){
	form1.mode.value='Excel_Upload_mode';
	form1.submit();
}
</script>
