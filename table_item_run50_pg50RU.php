<?php
	include_once('./tkher_start_necessary.php');
	/*
	  table_item_run50_pg50RU.php : app_pg50RU.php 에서 call , mode:Pg_Upgrade
	  - tkher_program_data_list.php 을 call 한다.
	  pg_curl_send() 추가 : 2023-08-03 : curl 실행한다. - https://ailinkapp.com/onlyshop/coupon/pg_curl_get_ailinkapp.php
	*/
	//$call_pg = $_POST['mode_call']; m_("call_pg:" . $call_pg); // app_pg50RU
	/* ---------------------------------------------------------------------------------------------------------------
	*  app_pg50RU.php 에서 'Save and Run' 버턴 클릭 후 이것을 실행한다.  mode.value = 'Pg_Upgrade';
	*  프로그램:table_item_run50_app_pg50RU.php : 프로그램 속성을 저장한 table10_pg 테이블을 update 생성한다. table_item_run50.php을 복사
	*  프로그램:table_item_run50.php : 프로그램 속성을 저장한 table10_pg 테이블을 생성한다.
	*  table_pg70_write.php와 다른점: item_array를 table10_pg테이블을 사용한다.
	*  table_item_run50.php : table_pg50.php
	*  table_item_run70.php : table_pg30.php , table_pg70.php , kan_table_pg30.php 에서 실행한다.  
	Data 등록 프로그램 - 같은 프로그램.
	https://appgenerator.net/t/table_item_run50.php
	https://appgenerator.net/t/tkher_program_run.php
	https://appgenerator.net/t/table_pg70_write.php
	---------------------------------------------------------------------------- */
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/appmaker.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<?php

	$H_ID		= get_session("ss_mb_id"); $H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$H_EMAIL   = $member['mb_email'];
	if( !$H_ID || $H_LEV < 2 )
	{
		$url="/";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$mode = $_POST['mode']; 
	$column_attribute = $_POST['column_attribute']; 

	if( $mode == 'Pg_Upgrade' ) { // 변경 일때 만 처리.
		$item_array		= $_POST['item_array']; //m_("column_attribute:$column_attribute, item_array:$item_array ");
		$tab_hnm		= $_POST['tab_hnm'];
		$tab_enm		= $_POST['tab_enm'];
		$item_cnt		= $_POST['item_cnt'];
		$group_code		= $_POST['group_code'];
		$group_name		= $_POST['group_name'];
		$pg_code		= $_POST['pg_code'];
		$pg_name		= $_POST['pg_name'];

		$iftype			= array();
		$if_data		= array();
		$popdata		= array(); // 컬럼이동식

		$popdata		= $_POST['popdata']; // add 2022-02-19
		$if_data		= $_POST['if_data'];
		$iftype			= $_POST['iftype'];
		
		$item			= $_POST['item_array'];

		$pop_data		= $_POST['pop_data']; // multy popup 전체 내용.
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

	$hostnameA = getenv('HTTP_HOST');
	$tabData['data'][][] = array();

	function PG_curl_send( $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $sys_link, $rel_data , $rel_type ){
		global $pg_code, $pg_name, $tab_enm, $tab_hnm, $tabData, $H_ID, $H_EMAIL, $group_code, $group_name, $hostnameA;      
		$cnt = 0;
		$tabData['data'][$cnt]['pg_code']  = $pg_code;
		$tabData['data'][$cnt]['pg_name']  = $pg_name;
		$tabData['data'][$cnt]['tab_enm']  = $tab_enm;
		$tabData['data'][$cnt]['tab_hnm']  = $tab_hnm;
		$tabData['data'][$cnt]['userid']     = $H_ID;
		$tabData['data'][$cnt]['group_code'] = $group_code;
		$tabData['data'][$cnt]['group_name'] = $group_name;

		$tabData['data'][$cnt]['host']       = $hostnameA;
		$tabData['data'][$cnt]['email']      = $H_EMAIL;

		$tabData['data'][$cnt]['item_cnt']   = $item_cnt;
		$tabData['data'][$cnt]['if_type']    = $iftype_db;
		$tabData['data'][$cnt]['if_data']    = $ifdata_db;
		$tabData['data'][$cnt]['popdata_db'] = $popdata_db;
		$tabData['data'][$cnt]['sys_link']   = $sys_link;
		$tabData['data'][$cnt]['relation_data']   = $rel_data;
		$tabData['data'][$cnt]['relation_type']   = $rel_type;
		$tabData['data'][$cnt]['item_array'] = $item_array;
		
		//$count = count($tabData['data']);	//m_( "--- count:" . $count ); // 10

		$key = 'appgenerator';
		$iv = "~`!@#$%^&*()-_=+";

		$sendData = encryptA( $tabData , $key, $iv);

//		$url_ = 'https://ailinkapp.com/onlyshop/coupon/pg_curl_get_ailinkapp.php'; // 전송할 대상 URL
		$url_ = 'https://ailinkapp.com/kapp/_Curl/pg_curl_get_ailinkapp.php'; // 전송할 대상 URL

		$curl = curl_init(); //$curl = curl_init( $url_ );
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);

		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);

		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		
		//echo curl_error($curl);
		//echo "curl --- response: " . $response;

		if( $response == false) {
			$_ms = "table30m curl 전송 실패 : " . curl_error($curl);
			echo 'curl 전송 실패 : ' . curl_error($curl);
			echo "<br>response: " . $response;
			//m_(" ------------ : " . $_ms);
		} else {
			//$_ms = 'table30m curl 응답 : ' . $response;
			//echo 'curl 응답 : ' . $response;
			//m_(" ============ :" . $_ms);
		}
		// ============ curl 응답 : --- count:10Error: Update failed{"message":"_api table data 전달 완료"}
		curl_close($curl);	//m_("curl end--------------- ms: email: " . $H_EMAIL); //exit();
	}
	//===================================================== function end

	$iftype_db="";
	$ifdata_db="";
	$popdata_db="";
			for( $i=0;$i<$item_cnt;$i++){
					$ifT	= $iftype[$i];
					$ifD	= $if_data[$i];
					$ifP	= $popdata[$i];
					$itemx  = explode("@", $item_array);
					$it		= $itemx[$i];
					$it_fld = explode("|", $it);

					$iftype_db = $iftype_db . "|" . $iftype[$i];
					$ifdata_db = $ifdata_db . "|" . $if_data[$i];
					$popdata_db = $popdata_db . "^" . $popdata[$i]; // 2022-02-19 add
			} // for

	if( $mode=="Pg_Upgrade" && $table10_pg > 0) {

		// 2022-02-19 pop_data 컬러 추가.
		$query = "UPDATE {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name',  item_cnt=$item_cnt, item_array='$item_array', if_type='$iftype_db', if_data='$ifdata_db', pop_data='$popdata_db' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		sql_query($query);

		$sys_pg_root	= $pg_code;
		$sys_subtit		= $pg_name;
		$sys_link		= "tkher_program_data_list.php?pg_code=" . $pg_code;
		//$pg_sys_link	= "https://" . $hostnameA . "/t/tkher_program_data_list.php?pg_code=" . $pg_code;
		$pg_sys_link	= KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $pg_code;
		$aboard_no		= $pg_code;
		$job_group		= "appgenerator";
		$job_name		= $pg_name;
		$jong = "P";

		//===========
		PG_curl_send( $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $pg_sys_link, $rel_data, $rel_type );
		//===========
		
		if( $mode=="Pg_Upgrade"){ // app_pg50RU.php call
			// 프로그램 업그레이드 보완 지급 포인트.
			coin_add_func( $H_ID, $config['kapp_comment_point'] );
			//tkher_config cf_write_point:3000=$config[cf_write_point], cf_comment_point=1000
			insert_point( $H_ID, $config['kapp_comment_point'], $sys_link, '@program_upgrade', $pg_name, $tab_hnm); 
			// 프로그램명,테이블명만 기록한이유:20자리로 내용을 줄여넣음. 포인트 지급내역 생성.

			$_SESSION['mode_session_ok']	= 'end';  // point 지급완료 확용. 1일 1번만 적용.
		}
		//m_( $mode . ", pg_code:" . $pg_code); //Pg_Upgrade, pg_code:dao_1694500050
		$_SESSION['pg_code']	= $pg_code; //2023-08-03 add

		//job_link_table_add($pg_code, $pg_name, $sys_link, $pg_code, $job_group, $job_name, $jong );
	} else {
		my_msg(" ERROR : mode:$mode "); // 프로그램 변경만 처리한다. ERROR : mode:pg_new_create2 
	}
	//m_("-------");
	//=============================================== //m_(" pg_code: ". $pg_code);
		$url = "tkher_program_data_list.php?pg_code=". $pg_code;
		echo "<script>window.open( '".$url."' , '_top', ''); </script>";
		exit;
	//=============================================
?>

