<?php
	include_once('./tkher_db_lib.php');

	include './tkher_dbcon_Table.php';  

	/*---------------------------------------------------------------
	excel_download_user.php : 사용자 서버에서 엑셀 화일로 다운로드.
	-----------------------------------------------------------------*/
	/*if( !get_session("login_id") ) {
		my_msg("You need to login. ");
		$url="/";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}*/
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

<!-- 
1. table10i.php : 테이블 리스트에서 콜하여 사용한다.
2. tab_list_pg.php : 프로그램 목록 에서 콜하여 사용한다.
-->

<?php
	$mode = $_POST['mode'];
	$return_pg_code = $_POST['return_pg_code'];
	$pg_name = $_POST['pg_name'];
	$pg_code = $_POST['pg_code'];
	$tab_enm = $_POST['tab_enm'];
	$tab_hnm = $_POST['tab_hnm'];
	/*
	if( $mode == 'excel_create' )	{ // excel_create, Excel_mode_table10i
		//$sqlPG = "select * from table10_pg where userid='$H_ID' and tab_enm='$tab_enm' ";
		$sqlPG = "select * from table10_pg where tab_enm='$tab_enm' ";
		$ddT = date("Y-m-d");
		$downfileT= $tab_hnm . "_" . $ddT;	// 다운받을 화일 
	} else {
		$sqlPG = "select * from table10_pg where userid='$H_ID' and pg_name='$pg_name' ";
		$ddT = date("Y-m-d");
		$downfileT= $pg_name . "_" . $ddT;	// 다운받을 화일 
	}
	$resultPG	= sql_query($sqlPG);
	$table10_pg = sql_num_rows($resultPG);
	$rsPG		= sql_fetch_array($resultPG);
	if( $table10_pg )	 {
		$item_array = $rsPG[item_array];
		$tab_enm	= $rsPG[tab_enm];
		$tab_hnm	= $rsPG[tab_hnm];
		$item_cnt	= $rsPG[item_cnt];

		$list = array();
		$list = explode("@", $item_array);

	} else{
		my_msg("program no found!");
	}*/

	$ddT = date("Y-m-d");
	$downfileT= $tab_hnm . "_" . $ddT;	// 다운받을 화일 
	$table_item_array = $_POST['table_item_array'];

	$list = array();
	$list = explode("@", $table_item_array);

	$item_cnt = count( $list ) -1;

	//$excel_ok = $_REQUEST[excel_ok];

	///////////////////////////////////////////////////////////////////////// 엑셀얻기 시작
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
	header('Content-Disposition: attachment;filename="'.$downfileT.'.xls"');
	header('Cache-Control: max-age=0');
	///////////////////////////////////////////////////////////////////////// 엑셀얻기 끝


			$SQL = "select * from $tab_enm ";
			$result = sql_query( $SQL );
			$total = sql_num_rows($result);
			if( $mode == 'excel_create' )	$pg_name = $tab_hnm; // excel_create, Excel_mode_table10i
?>
		<table border=1>
				<tr>
					<td colspan="<?=$item_cnt?>" align=center><?=$pg_name?></td>
				</tr>

				<tr>
<?php
			for( $i=0, $j=1; $i < $item_cnt; $i++, $j++){
				$ddd  = $list[$i];
				$fld = explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
				$fff = $fld[2];	// title
				echo " <td>$fff</td> ";
			}
?>
				</tr>
<?php
		if( $total > 0 ){

//					my_msg("item_array:$item_array");
			while( $row = sql_fetch_array($result)  ) {
?>
				<tr>
<?php
				for( $i=0, $j=1; $i < $item_cnt; $i++,$j++){
					$ddd  = $list[$i];
					$fld = explode("|", $ddd);		// 구분자='|' 를 각가가 분류 : 36|fld_2|전화폰|2
					$fff = $fld[1];	// column name
					$data = $row[$fff];
//					my_msg("ddd:$ddd, data:$data");
					echo " <td>$data</td> ";
				}
?>
				</tr>
<?php
			}  // while
		}else{
?>
				<tr>
					<td colspan="10" class="no-data">No data.</td>
				</tr>
<?php
		}
?>

		</table>

</body>
</html>
