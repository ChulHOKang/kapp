<?php
	include_once('./tkher_start_necessary.php');
	/*--------------------------------------------------
	down_excel_file.php : file_name.xls 생성.
	down_csv_file.php : file_name.csv로 생성
	1. table10i_my.php, table10i.php : 테이블 리스트에서 콜하여 사용한다.
	2. tab_list_pg.php : 프로그램 목록 에서 콜하여 사용한다.
	---------------------------------------------------*/
	$ss_mb_id		= get_session("ss_mb_id");	//"ss_mb_id";
	$ss_mb_level	= $member['mb_level'];			//get_session("ss_mb_level");   //"ss_mb_id";
	$H_ID			= get_session("ss_mb_id");  
	$H_LEV			= $ss_mb_level;
	$from_session_id= get_session("ss_mb_id");  
	if( !$H_ID ) {
		my_msg("You need to login. ");
		$url="/";
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
	$mode = $_POST['mode'];
	$pg_name = $_POST['pg_name'];
	$pg_code = $_POST['pg_code'];
	$tab_enm = $_POST['tab_enm'];
	$tab_hnm = $_POST['tab_hnm'];
	if( $mode == 'Excel_mode_table10i' )	{
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and tab_enm='$tab_enm' ";
		$ddT = date("Y-m-d");
		$downfileT= $tab_hnm . "_" . $ddT;
	} else {
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_name='$pg_name' ";
		$ddT = date("Y-m-d");
		$downfileT= $pg_name . "_" . $ddT;
	}
	$resultPG	= sql_query($sqlPG);
	if( $resultPG ) $table10_pg = sql_num_rows($resultPG);
	else $table10_pg = 0;
	if( $table10_pg )	 {
		$rsPG		= sql_fetch_array($resultPG);
		$item_array = $rsPG['item_array'];
		$tab_enm	= $rsPG['tab_enm'];
		$tab_hnm	= $rsPG['tab_hnm'];
		$item_cnt	= $rsPG['item_cnt'];
		$list = array();
		$list = explode("@", $item_array);
	} else{
		my_msg("program no found!");
	}
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
	header('Content-Disposition: attachment;filename="'.$downfileT.'.xls"');
	header('Cache-Control: max-age=0');
			$SQL = "SELECT * from $tab_enm ";
			$result = sql_query( $SQL );
			if( $result ) $total = sql_num_rows($result);
			else $total = 0;
			if( $mode == 'Excel_mode_table10i' )	$pg_name = $tab_hnm;
?>
		<table border=1>
				<tr>
					<td colspan="<?=$item_cnt?>" align='center'><?=$pg_name?></td>
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
			while( $row = sql_fetch_array($result)  ) {
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
