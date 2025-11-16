<?php
	include_once('./tkher_start_necessary.php');
	/*
		: app_pg50RU_update.php - table_item_run50_pg50RU.php copy, table_item_run50.php copy
		- call from: app_pg50RU.php , mode:Pg_Upgrade
		- call: tkher_program_data_list.php
		- pg_curl_send() : curl - /_Curl/pg_curl_get_ailinkapp.php
	*/
	//$call_pg = $_POST['mode_call']; m_("call_pg:" . $call_pg); // app_pg50RU
	/* ---------------------------------------------------------------------------------------------------------------
	*  app_pg50RU.php at 'Save and Run' click.  mode.value = 'Pg_Upgrade';
	*  - table10_pg table update. 
	*  프로그램:table_item_run50.php : 프로그램 속성을 저장한 table10_pg 테이블을 생성한다.
	*  table_pg70_write.php와 다른점: item_array를 table10_pg테이블을 사용한다.
	*  table_item_run50.php : table_pg50.php
	*  table_item_run70.php : table_pg30.php , table_pg70.php , kan_table_pg30.php 에서 실행한다.  
	Data 등록 프로그램 - 같은 프로그램.
	https://appgenerator.net/t/table_item_run50.php
	https://appgenerator.net/t/tkher_program_run.php
	https://appgenerator.net/t/table_pg70_write.php
	group_code: solpakanA_naver_1750725492, if_line: 1
	---------------------------------------------------------------------------- */
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/appmaker.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<?php
	$H_ID= get_session("ss_mb_id");
	if( !$H_ID || $H_ID =='' )	{
		m_("You need to login. ");
		$url="./";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$H_LEV=$member['mb_level'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_EMAIL   = $member['mb_email'];
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";
	if( isset($_POST['column_attribute']) ) $column_attribute = $_POST['column_attribute'];
	else $column_attribute = "";
	$hostnameA = KAPP_URL_T_;
	$tabData['data'][][] = array();
	if( isset($_POST['pg_codeS']) ) $pg_codeS = $_POST['pg_codeS'];
	else $pg_codeS = '';

	$iftype_db="";
	$ifdata_db="";
	$popdata_db="";
	$if_type = array();
	$if_data = array();
	$popdata = array();
	if( $mode == 'Pg_Upgrade' ) {
		$item_array		= $_POST['item_array']; 
		$tab_hnm		= $_POST['tab_hnm'];
		$tab_enm		= $_POST['tab_enm'];
		$item_cnt		= $_POST['item_cnt'];
		$group_code		= $_POST['group_code'];
		$group_name		= $_POST['group_name'];
		$pg_code		= $_POST['pg_code'];
		$pg_name		= $_POST['pg_name'];
		$popdata		= $_POST['popdata'];
		$if_data		= $_POST['if_data'];
		$if_type = $_POST['if_type'];
		$item			= $_POST['item_array'];
		$pop_data		= $_POST['pop_data'];
		$rel_data		= $_POST['rel_data']; 
		$rel_type		= $_POST['rel_type']; 
		$in_day			= date("Y-m-d H:i");
		$sqlPG			= "select * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$pg_code' ";
		$resultPG		= sql_query($sqlPG);
		$table10_pg	= sql_num_rows($resultPG);
	} else {
			m_(" The approach is wrong. mode: $mode");//pg_new_create2 
			exit;
	}
	for( $i=0;$i<$item_cnt;$i++){
			$ifT	= $if_type[$i];
			$ifD	= $if_data[$i];
			$ifP	= $popdata[$i];
			$itemx  = explode("@", $item_array);
			$it		= $itemx[$i];
			$it_fld = explode("|", $it);
			$iftype_db = $iftype_db . "|" . $if_type[$i];
			$ifdata_db = $ifdata_db . "|" . $if_data[$i];
			$popdata_db = $popdata_db . "^" . $popdata[$i]; 
			$query = "UPDATE {$tkher['table10_table']} SET if_type='$if_type[$i]', if_data='$if_data[$i]' WHERE tab_enm='$tab_enm' and fld_enm='$it_fld[1]' ";
			sql_query($query);
	}
	if( $mode=="Pg_Upgrade" && $table10_pg > 0) {
		$query = "UPDATE {$tkher['table10_pg_table']} SET item_cnt=$item_cnt, item_array='$item_array', if_type='$iftype_db', if_data='$ifdata_db', pop_data='$popdata_db' WHERE pg_code='$pg_code' ";
		sql_query($query);
		$query = "UPDATE {$tkher['table10_table']} SET if_type='$iftype_db' WHERE tab_enm='$tab_enm' and fld_enm='seqno' ";
		sql_query($query);
		$sys_pg_root	= $pg_code;
		$sys_subtit		= $pg_name;
		$sys_link		= "tkher_program_data_list.php?pg_code=" . $pg_code;
		$pg_sys_link	= KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $pg_code;
		$aboard_no		= $pg_code;
		$job_group		= "appgenerator";
		$job_name		= $pg_name;
		$jong = "P";
		$kapp_theme = $config['kapp_theme'];
		$kapp_theme = explode('^', $kapp_theme );
		if( isset($kapp_theme[0]) ){
			PG_curl_send( $kapp_theme[0], $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $pg_sys_link, $rel_data, $rel_type );
		}
		if( isset($kapp_theme[1]) ) {
			PG_curl_send( $kapp_theme[1], $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $pg_sys_link, $rel_data, $rel_type );
		}
		coin_add_func( $H_ID, $config['kapp_comment_point'] );// upgrade point get.
		insert_point( $H_ID, $config['kapp_comment_point'], $sys_link, '@program_upgrade', $pg_name, $tab_hnm); //포인트 지급내역 생성.
		$_SESSION['mode_session_ok']	= 'end';  // point 지급완료 확용. 1일 1번만 적용.
		$_SESSION['pg_code']	= $pg_code; 
		//job_link_table_add($pg_code, $pg_name, $sys_link, $pg_code, $job_group, $job_name, $jong );
	} else {
		m_(" ERROR : mode:$mode ");
	}
	$url = "tkher_program_data_list.php?pg_code=". $pg_code;
	echo "<script>window.open( '".$url."' , '_top', ''); </script>";
	exit;
?>

