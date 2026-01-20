<?php
	include_once('./tkher_db_lib.php');
	include './tkher_dbcon_Table.php';  
	/*---------------------------------------------------------------
	excel_download_user.php : excel data download.
	1. table10i.php : table list - call.
	2. tab_list_pg.php : 프로그램 목록 에서 콜하여 사용한다.
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
<TITLE>KAPP. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
	$mode = $_POST['mode'];
	$return_pg_code = $_POST['return_pg_code'];
	$pg_name = $_POST['pg_name'];
	$pg_code = $_POST['pg_code'];
	$tab_enm = $_POST['tab_enm'];
	$tab_hnm = $_POST['tab_hnm'];
	$ddT = date("Y-m-d");
	$downfileT= $tab_hnm . "_" . $ddT;	// 다운받을 화일 
	$table_item_array = $_POST['table_item_array'];
	$list = array();
	$list = explode("@", $table_item_array);
	$item_cnt = count( $list ) -1;
	//$excel_ok = $_REQUEST[excel_ok];
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
	header('Content-Disposition: attachment;filename="'.$downfileT.'.xls"');
	header('Cache-Control: max-age=0');

			$SQL = "select * from $tab_enm ";
			$result = sql_query( $SQL );
			$total = sql_num_rows($result);
			if( $mode == 'excel_create' )	$pg_name = $tab_hnm;
?>
		<table border=1>
				<tr>
					<td colspan="<?=$item_cnt?>" align=center><?=$pg_name?></td>
				</tr>
				<tr>
<?php
			for( $i=0, $j=1; $i < $item_cnt; $i++, $j++){
				$ddd  = $list[$i];
				$fld = explode("|", $ddd);
				$fff = $fld[2];	// title
				echo " <td>$fff</td> ";
			}
?>
				</tr>
<?php
		if( $total > 0 ){
			while( $row = sql_fetch_array($result)  ) {
?>
				<tr>
<?php
				for( $i=0, $j=1; $i < $item_cnt; $i++,$j++){
					$ddd  = $list[$i];
					$fld = explode("|", $ddd);
					$fff = $fld[1];	// column name
					$data = $row[$fff];
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
