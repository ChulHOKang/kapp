<?php
/*
	: connect_count_search($call_pg ,$id, $ipcheck, $sdata) add
*/

	$from_session_url = KAPP_URL_;
	$kapp_cmop_nicknm ='K-APP';
	$kapp_comp_snm    ='';	// company
	$kapp_cmop_tel    ='';
	$kapp_cmop_htel   ='';    // manager
	$kapp_cmop_tel1   ='';    // 1 team
	$kapp_cmop_tel2   ='';    // 2 team
	$kapp_cmop_fax    ='';
	$kapp_cmop_sano   ='';
	$kapp_cmop_addr   ='';
	$kapp_cmop_mail   ='solpakan89@gmail.com';
	$kapp_cmop_Htitle = "[K-APP] : ".$kapp_cmop_tel." Mail:".$kapp_cmop_mail;
	$user_login_time = 6000000;

	$kapp_key = 'appgenerator';
	$kapp_iv = "~`!@#$%^&*()-_=+";
	$link_secret_iv = "#@$%^&*()_+=-";
	$send_mail = "solpakan@naver.com";
	$user_admin_pass = 'ad2457807';
	$id= "editor";	// admin
	$pw	= "Edi!))$35";

/* start program design. */
	$is_mobile = false;
	//$is_mobile = preg_match('/'.KAPP_MOBILE_AGENT.'/i', $_SERVER['HTTP_USER_AGENT']);
	if( $is_mobile ) {
		$menu1TWPer=15;
	} else {
		$menu1TWPer=36;
	}
	$menu1AWPer=100 - $menu1TWPer;
	$menu2TWPer=10;
	$menu2AWPer=50 - $menu2TWPer;
	$menu3TWPer=10;
	$menu3AWPer=33.3 - $menu3TWPer;
	$menu4TWPer=10;
	$menu4AWPer=25 - $menu4TWPer;
	$Xwidth='100%';
	$Xheight='100%';
	$Text_height='60px';

	/* 자동등록방지.  */
	$strT  = "abcdefghijklmnopqrstuvwxyz";
    $strT .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $strT .= "0123456789";
	$shuffled_str = str_shuffle($strT);
	$auto_char=substr($shuffled_str, 0, 6); // insertD.php, updateD.php, replyD.php

	function TAB_curl_send( $curl_snm, $tab_enm, $tab_hnm, $cnt , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ){
		// use: kapp_tabel_create.php , table30m_A.php
		global $H_ID, $H_EMAIL, $group_code, $group_name, $config, $kapp_iv, $kapp_key;
		$tabData['data'][][] = array();
		$tabData['data'][$cnt]['tab_enm']  = $tab_enm;
		$tabData['data'][$cnt]['tab_hnm']  = $tab_hnm;
		$tabData['data'][$cnt]['fld_enm']  = 'seqno';
		$tabData['data'][$cnt]['fld_hnm']  = 'seqno';
		$tabData['data'][$cnt]['fld_type'] = 'INT';
		$tabData['data'][$cnt]['fld_len']  = '10';
		$tabData['data'][$cnt]['disno']    = $cnt;
		$tabData['data'][$cnt]['userid']     = $H_ID;
		$tabData['data'][$cnt]['group_code'] = $group_code;
		$tabData['data'][$cnt]['group_name'] = $group_name;
		$tabData['data'][$cnt]['memo']       = $memo;
		$hostname = getenv('HTTP_HOST');
		$tabData['data'][$cnt]['host']       = KAPP_URL_T_; //$hostname;
		$tabData['data'][$cnt]['email']      = $H_EMAIL;
		$tabData['data'][$cnt]['sqltable']   = $item_list;
		$tabData['data'][$cnt]['if_line']    = $if_line;
		$tabData['data'][$cnt]['if_type']    = $if_type;
		$tabData['data'][$cnt]['if_data']    = $if_data;
		$tabData['data'][$cnt]['relation_data']    = $relation_data;
		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);
		$url_ = $curl_snm . '/_Curl/table_curl_get_ailinkapp.php'; 

		$curl = curl_init(); //$curl = curl_init( $url_ );
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE), 
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			echo ' TAB_curl_send curl Error : ' . curl_error($curl);
		} else {
			echo 'curl 응답 : ' . $response;
		}
		curl_close($curl);
		return $response;
	}
	function PG_curl_send( $curl_snm, $item_cnt , $item_array, $iftype_db, $ifdata_db, $popdata_db, $sys_link, $rel_data , $rel_type ){
		// use: kapp_tabel_create.php, app_pg50RC.php,  table30m_A.php
		global $pg_code, $pg_name, $tab_enm, $tab_hnm, $H_ID, $H_EMAIL, $group_code, $group_name, $hostnameA, $config, $kapp_iv,$kapp_key;      
		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['pg_code']  = $pg_code;
		$tabData['data'][$cnt]['pg_name']  = $pg_name;
		$tabData['data'][$cnt]['tab_enm']  = $tab_enm;
		$tabData['data'][$cnt]['tab_hnm']  = $tab_hnm;
		$tabData['data'][$cnt]['userid']     = $H_ID;
		$tabData['data'][$cnt]['group_code'] = $group_code;
		$tabData['data'][$cnt]['group_name'] = $group_name;
		$tabData['data'][$cnt]['host']       = KAPP_URL_T_;
		$tabData['data'][$cnt]['email']      = $H_EMAIL;
		$tabData['data'][$cnt]['item_cnt']   = $item_cnt;
		$tabData['data'][$cnt]['if_type']    = $iftype_db;
		$tabData['data'][$cnt]['if_data']    = $ifdata_db;
		$tabData['data'][$cnt]['popdata_db'] = $popdata_db;
		$tabData['data'][$cnt]['sys_link']   = $sys_link;
		$tabData['data'][$cnt]['relation_data']   = $rel_data;
		$tabData['data'][$cnt]['relation_type']   = $rel_type;
		$tabData['data'][$cnt]['item_array'] = $item_array;
		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);

		$url_ = $curl_snm . '/_Curl/pg_curl_get_ailinkapp.php'; // 전송할 대상 URL fation
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			//$_ms = "new program curl error : " . curl_error($curl);
			echo 'curl error PG_curl_send : ' . curl_error($curl);
		} else {
			//$_ms = 'new program app_pg50RC curl response : ' . $response;
		}
		curl_close($curl);
		return $response;
	} // function
	function TAB_curl_send_tabData( $curl_snm, $tabData ){
		// use: table_curl_get_ailinkapp.php
		global $kapp_iv, $kapp_key;

		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);
		$url_ = $curl_snm . '/_Curl/table_curl_get_ailinkapp.php'; 

		$curl = curl_init(); //$curl = curl_init( $url_ );
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			echo 'TAB_curl_send_tabData curl Error : ' . curl_error($curl);
		} else {
			echo 'TAB_curl_send_tabData curl 응답 : ' . $response;
		}
		curl_close($curl);
		return $response;
	}
	function PG_curl_send_tabData( $curl_snm, $tabData ){
		// use: pg_curl_get_ailinkapp.php
		global $kapp_iv, $kapp_key; 
		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);
		$url_ = $curl_snm . '/_Curl/pg_curl_get_ailinkapp.php'; // 전송할 대상 URL fation
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE), 
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			$_ms = "PG_curl_send_tabData curl error : " . curl_error($curl);
			echo 'PG_curl_send_tabData curl error : ' . curl_error($curl);
		} else {
			$_ms = 'new PG_curl_send_tabData curl response : ' . $response;
			echo 'PG_curl_send_tabData curl response: ' . $response;
		}
		curl_close($curl);
		return $response;
	} // function
	function Link_Table_curl_send_tabData( $kapp_theme, $tabData ){
		global $kapp_iv, $kapp_key;

		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);
		$url_ = $kapp_theme . '/_Curl/Link_Table_curl_get_ailinkapp.php';
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE), 
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			$_ms = "new Link_Table_curl_get_ailinkapp fail : " . curl_error($curl);
			echo 'curl : ' . $_ms;
		} else {
			$_ms = 'new Link_Table_curl_get_ailinkapp curl OK : ' . $response;
			echo 'curl : ' . $_ms;
		}
		curl_close($curl);
		return $response;
	}
	function job_link_table_add( $sys_pg_root, $sys_subtit, $sys_link, $aboard_no, $job_group, $job_name, $jong){
		global $H_ID, $H_EMAIL, $tkher;
		global $kapp_theme0;
		global $kapp_theme1;

		$ip = $_SERVER['REMOTE_ADDR'];
		$from_session_url = KAPP_URL_T_; //$_SERVER['HTTP_HOST'];
		$up_day  = date("Y-m-d-H:i:s");
		$result = sql_fetch("SELECT * from {$tkher['job_link_table']} where user_id='$H_ID' and user_name='$sys_subtit' and job_addr='$sys_link' ");
		//$tot = sql_num_rows($result);
		//if( $tot < 1 ) {
		if( !isset($result['user_id']) && !isset($result['user_name']) && !isset($result['job_arrd'])  ) {
			$up_day = date("Y-m-d H:i:s");
			$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID',  email='$H_EMAIL', job_name='$job_name', user_name='$sys_subtit', num='$sys_pg_root', aboard_no='$aboard_no', job_addr='$sys_link', jong='$jong', job_group='$job_group', club_url='$from_session_url', job_level='0', ip='$ip', up_day='$up_day' ";
			$ret = sql_query( $sqlA );
			$memo = 'tit:' . $sys_subtit . ', sys_pg:' .$sys_pg_root. ', aboard_no:' . $aboard_no;
			if( $ret ) {
				$kapp_theme0 = "https://fation.net/kapp"; //$kapp_theme[0];
				$kapp_theme1 = '';
				if( $kapp_theme0 ) {
					if( Link_Table_curl_send( $kapp_theme0, $sys_subtit, $sys_link, $jong, $from_session_url, $ip, $memo, $up_day ) ) {
						if( $kapp_theme1 ) Link_Table_curl_send( $kapp_theme1, $sys_subtit, $sys_link, $jong, $from_session_url, $ip, $memo, $up_day );
					}
				}
				m_("job_link_table --- insert ok");
				return true;
			} else {
				m_("my_func - job_link_table_add error ");
				//echo "my_func, job_link_table_add error sql: " .$sqlA; exit;
				return false;
			}
		}
		return false;
	}
	function Link_Table_curl_send( $kapp_theme, $sys_subtit, $sys_link, $jong, $kapp_server, $ip, $memo, $up_day ){
		global $H_ID, $H_EMAIL, $config, $kapp_iv, $kapp_key;

		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['link_title']  = $sys_subtit;
		$tabData['data'][$cnt]['link_url']    = $sys_link;
		$tabData['data'][$cnt]['link_type']   = $jong;
		$tabData['data'][$cnt]['host'] = KAPP_URL_T_;
		$tabData['data'][$cnt]['kapp_server'] = $kapp_server;
		$tabData['data'][$cnt]['email']       = $H_EMAIL;
		$tabData['data'][$cnt]['user_ip']     = $ip;
		$tabData['data'][$cnt]['memo']        = $memo;
		$tabData['data'][$cnt]['up_day']      = $up_day;
		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);
		
		$url_ = $kapp_theme . '/_Curl/Link_Table_curl_get_ailinkapp.php';
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE), 
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			$_ms = KAPP_URL_T_ .  ", Link_Table_curl_send fail : " . curl_error($curl);
			echo 'curl : ' . $_ms;
		} else {
			$_ms =KAPP_URL_T_ .  ', Link_Table_curl_send OK : ' . $response;
			//echo 'curl : ' . $_ms;
		}
		curl_close($curl);
		return $response;
	}
	function Sys_Menu_bom_curl_send_tabData( $kapp_theme, $tabData ){
		global $kapp_iv, $kapp_key;

		$sendData = encryptA( $tabData , $kapp_key, $kapp_iv);
		$url_ = $kapp_theme . '/_Curl/sys_menu_bom_curl_get_ailinkapp.php';
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE), 
			'iv' => $kapp_iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		echo curl_error($curl);
		if( $response == false) {
			$_ms = "Sys_Menu_bom_curl_send_tabData api Fail : " . curl_error($curl);
			echo 'curl : ' . $_ms;
		} else {
			$_ms = 'Sys_Menu_bom_curl_send_tabData api OK : ' . $response;
			//echo 'curl : ' . $_ms;
		}
		curl_close($curl);
		return $response;
	}
	/*
	// No use : column information - table30m_A.php 테이블 생성시 컬럼 정보 curl 처리를 보류함.
	function TAB_curl_move( $tab_enm, $tab_hnm, $fld_enm, $fld_hnm, $fld_type, $fld_len, $cnt, $memo, $Asqltable, $Aif_line, $Aif_type, $Aif_data, $Arelation_data ){
		global $tabData, $H_ID, $H_EMAIL, $group_code, $group_name;
		$tabData['data'][$cnt]['tab_enm']  = $tab_enm;
		$tabData['data'][$cnt]['tab_hnm']  = $tab_hnm;
		$tabData['data'][$cnt]['fld_enm']  = $fld_enm;
		$tabData['data'][$cnt]['fld_hnm']  = $fld_hnm;
		$tabData['data'][$cnt]['fld_type'] = $fld_type;
		$tabData['data'][$cnt]['fld_len']  = $fld_len;
		$tabData['data'][$cnt]['disno']    = $cnt;
		$tabData['data'][$cnt]['userid']     = $H_ID;
		$tabData['data'][$cnt]['group_code'] = $group_code;
		$tabData['data'][$cnt]['group_name'] = $group_name;
		$tabData['data'][$cnt]['memo']       = $memo;
		$hostname = KAPP_URL_T_; //getenv('HTTP_HOST');
		$tabData['data'][$cnt]['host']       = $hostname;
		$tabData['data'][$cnt]['email']      = $H_EMAIL;
		$tabData['data'][$cnt]['sqltable']   = $Asqltable;
		$tabData['data'][$cnt]['if_line']    = $Aif_line;
		$tabData['data'][$cnt]['if_type']    = $Aif_type;
		$tabData['data'][$cnt]['if_data']    = $Aif_data;
		$tabData['data'][$cnt]['relation_data']    = $Arelation_data;
	}*/
	function special_comma_chk ($input) { // 특수문자 제거. "'"만 제거한다.
		if( is_array($input)) {
			return array_map('special_chk', $input); 
		} else if ( is_scalar($input)) {
				return preg_replace("/'/i", "", $input); //return preg_replace("/[ #\/\\\:;,'\"`<>()]/i", "", $input);
		} else {
			return $input; 
		} 
	}

	function a_number_formatA($number_in_iso_format, $no_of_decimals=3, $decimals_separator='.', $thousands_separator='', $digits_grouping=3){
		if (!is_numeric($number_in_iso_format)){
			error_log("Warning! Wrong parameter type supplied in my_number_format() function. Parameter \$number_in_iso_format is not a number.");
			return false;
		}
		if (!is_numeric($no_of_decimals)){
			error_log("Warning! Wrong parameter type supplied in my_number_format() function. Parameter \$no_of_decimals is not a number.");
			return false;
		}
		if (!is_numeric($digits_grouping)){
			error_log("Warning! Wrong parameter type supplied in my_number_format() function. Parameter \$digits_grouping is not a number.");
			return false;
		}
		$no_of_decimals = $no_of_decimals * 1;
		// Explode the string received after DOT sign (this is the ISO separator of decimals)
		$aux = explode(".", $number_in_iso_format);
		// Extract decimal and integer parts
		$integer_part = $aux[0];
		$decimal_part = isset($aux[1]) ? $aux[1] : '';
		// Adjust decimal part (increase it, or minimize it)
		if ($no_of_decimals > 0){
			// Check actual size of decimal_part
			// If its length is smaller than number of decimals, add trailing zeros, otherwise round it
			if (strlen($decimal_part) < $no_of_decimals){
				$decimal_part = str_pad($decimal_part, $no_of_decimals, "0");
			} else {
				$decimal_part = substr($decimal_part, 0, $no_of_decimals);
			}
		} else {
			// Completely eliminate the decimals, if there $no_of_decimals is a negative number
			$decimals_separator = '';
			$decimal_part       = '';
		}
		// Format the integer part (digits grouping)
		if ($digits_grouping > 0){
			$aux = strrev($integer_part);
			$integer_part = '';
			for ($i=strlen($aux)-1; $i >= 0 ; $i--){
				if ( $i % $digits_grouping == 0 && $i != 0){
					$integer_part .= "{$aux[$i]}{$thousands_separator}";
				} else {
					$integer_part .= $aux[$i];
				}
			}
		}
		$processed_number = "{$integer_part}{$decimals_separator}{$decimal_part}";
		return $processed_number;
	}
	/* backup the db OR just a table */
	function backup_tables( $host, $user, $pass, $name, $tables = '*')
	{
		if($tables == '*')
		{
			$tables = array();
			$result = sql_query('SHOW TABLES');
			while($row = sql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		foreach($tables as $table)
		{
			$result = sql_query('SELECT * from ' . $table);
			$num_fields = sql_num_fields($result);
			$return.= 'DROP TABLE '.$table.';';
			$row2 = sql_fetch_row( sql_query('SHOW CREATE TABLE ' . $table) );
			$return.= "\n\n" . $row2[1] . ";\n\n";
			for ($i = 0; $i < $num_fields; $i++)
			{
				while($row = sql_fetch_row( $result ) )
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j < $num_fields; $j++)
					{
						$row[$j] = addslashes($row[$j]);
                        $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"' . $row[$j] . '"' ; } else { $return.= '""'; }
						if ($j < ($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
		fwrite($handle,$return);
		fclose($handle);
	}

	function coin_add_func($from_session_id, $point)
	{
		global $tkher;
		global $config;
		$sql= " update {$tkher['tkher_member_table']} set mb_point=mb_point+$point where mb_id = '$from_session_id' ";
		sql_query($sql);
	}
	function coin_minus_func($H_ID, $point)
	{
		global $tkher;
		global $config, $tkher_iurl, $from_session_id;
		$point = $config['kapp_write_point'];
		$sql= " update {$tkher['tkher_member_table']} set mb_point=mb_point-$point where mb_id = '$H_ID' ";
		$ok_sql = sql_query($sql);
		if( $ok_sql ) {
			$minus_point = 0 - $point;
			$rungo = $tkher_iurl . "/" . $_SERVER['SCRIPT_NAME'];
			insert_point_app( $from_session_id, $minus_point, $rungo, $_SERVER['SCRIPT_NAME'], $H_ID );
		}
	}
	function captcha_html_func($auto_char)
	{
		if( is_mobile())	$class .= ' m_captcha';
		$html = '';
		$html .= "\n".'<fieldset id="captcha" >';
		$html .= "\n".'<legend><label for="captcha_key">[<b> '.$auto_char.' </b>]</label></legend>';
		$html .= "\n" . '<input type="text" name="captcha_keyB" id="captcha_keyB" class="frm_input" value="" size="6" maxlength="6">';
		$html .= "\n".'</fieldset>';
		return $html;
	}

	function get_memberT( $email, $table, $fields='*')
	{
		global $tkher;
		return sql_fetch(" select $fields from {$table} where mb_email = TRIM('$email') ");
	}
	function get_urllink_memberA($mb_id, $fields='*')
	{
		global $tkher;
		return sql_fetch(" select $fields from {$tkher['tkher_member_table']} where mb_id = TRIM('$mb_id') ");
	}
	function get_urllink_memberE($mb_id, $fields='*')
	{
		global $tkher;
		return sql_fetch(" select $fields from {$tkher['tkher_member_table']} where mb_email = TRIM('$mb_id') ");
	}
	function urllink_member_set( $gid, $gemail, $gname, $gsajin, $sn, $table){
        global $tkher;
		global $member;
		$ip = $_SERVER['REMOTE_ADDR'];
		date_default_timezone_set("Asia/Seoul");
		$day = date("Y-m-d H:i:s");
		$sql = "SELECT * from {$table} where mb_email='$gemail' ";
		$result = sql_query( $sql );
		if( $rs = sql_fetch_array($result) ) {
			$member['mb_level'] = $rs['mb_level'];
			return $rs['mb_level'];
		} else{
			$sql_in = "insert into {$table} set mb_id='$gid', mb_email='$gemail', mb_name='$gname', mb_nick='$gid', mb_photo='$gsajin', mb_ip='$ip', mb_sn='$sn', mb_level='2', mb_point='3000', mb_datetime='$day'";
			$ret = sql_query( $sql_in );
			$member['mb_level'] = '2';
			return $member['mb_level'];
		}
	}
	function urllink_member_setA( $email, $gname, $gsajin, $sn, $table, $signup_point=3000){
        global $tkher;
		global $member;
		$ip = $_SERVER['REMOTE_ADDR'];
		date_default_timezone_set("Asia/Seoul");
		$day = date("Y-m-d H:i:s");
		$email_id = $email; // email을 id로 사용한다.
		$sql_in = "insert into {$table} set mb_id='$email_id', mb_email='$email', mb_name='$gname', mb_nick='$gname', mb_photo='$gsajin', mb_ip='$ip', mb_sn='$sn', mb_level='2', mb_point=".$signup_point.", mb_datetime='$day'";
		$ret = sql_query( $sql_in );
		if( $ret) {
			//m_("my_func --- member OK!"); echo "urllink_member_setA sql: " . $sql_in; exit;
		} else {
			m_("my_func - urllink_member_setA --- error!");
			echo "urllink_member_setA sql: " . $sql_in; exit;
		}
		$jtree_dir = KAPP_PATH_T_ . "/file/".$email_id;
		if ( !is_dir($jtree_dir) ) {
			if ( !@mkdir( $jtree_dir, 0777 ) ) {
				echo " Error: $jtree_dir : " . $email_id . " Failed to create directory., 디렉토리를 생성하지 못했습니다. ";
				m_("ERROR email id:" . $email_id . ", dir create OK : " . $jtree_dir);
				//exit;
			} else {
				m_("email id:" . $email_id . ", dir create OK : " . $jtree_dir);
			}
		}

	}
	function urllink_member_read( $gemail ){ // No use
        global $tkher;
		global $member;
		$sql = "SELECT * from {$tkher['tkher_member_table']} where mb_email='$gemail' ";
		$result = sql_query( $sql );
		$rs = sql_fetch_array( $result );
		$member['mb_level'] = $rs['mb_level'];
		$level = $rs['mb_level'];
		return $level;
	}
	function urllink_member_setX($gid, $gemail, $gname, $gsajin){
        global $tkher;
		global $member;
		$sql = "SELECT * from {$tkher['tkher_member_table']} where mb_email='$gemail' ";
		$result = sql_query( $sql );
		if( $rs = sql_fetch_array($result) ) {
			$member['mb_level'] = $rs['mb_level'];
			return $rs['mb_level'];
		} else{
			date_default_timezone_set("Asia/Seoul");
			$day = date("Y-m-d H:i:s");
			$sql_in = "insert into {$tkher['tkher_member_table']} set mb_id='$gid', mb_email='$gemail', mb_name='$gname', mb_nick='$gid', mb_photo='$gsajin', mb_level='2', mb_point='3000', mb_datetime='$day'";
			$ret = sql_query( $sql_in );
			$member['mb_level'] = '2';
			$level = $rs['mb_level'];
			return $level;
		}
	}
	function create_aboard_table_make_menu( $board_title, $mroot, $board_type, $max_num ){
		global $H_ID, $up_day, $sys_pg_root, $code_name, $board_num;
		$ip = $_SERVER['REMOTE_ADDR'];
		$in_date=time();
		$result = sql_query("select max(no) as no from aboard_infor ");
		$rs = sql_fetch_array( $result );
		$board_ = $rs['no'];
		if( !$board_ ) $board_num = 1;
		else $board_num = $board_ +1;
		$table_name = $max_num;
		$code_name	= $table_name;
		$xsys_pg 	= $table_name;
		$sys_subtit = $board_title;
		$sys_pg		= $xsys_pg;
		$query="create table aboard_".$table_name." (
		no int(11) NOT NULL auto_increment,
		infor int(11),
		id varchar(30),
		name varchar(30),
		email varchar(100),
		home varchar(200),
		ip varchar(15),
		in_date int(11),
		subject varchar(100),
		context text,
		html int(11),
		password varchar(10),
		file_name varchar(250),
		file_wonbon varchar(250),
		file_size int,
		file_type char(4),
		file_path varchar(200),
		cnt int(11),
		target int(11),
		step int(11),
		re int(11),
		security varchar(10),
		primary key(no) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$mq1 = sql_query( $query );
		if( !$mq1 ) {
			echo("<script>alert('Bulletin board table creation failed.  $board_num, $table_name ');</script>");
			exit;
		}
		$link_name = "";
		if( $mq1 ){
			$link_name		= KAPP_URL_T_ . '/bbs/index5.php?infor='.$board_num;
			$movie			= $board_type;
			$home_url 		= "GCOM05!";
			$fileup 		= 1;
			$grant_view	    = 0;	//0:all, 1:member, 2:user 3:system manager
			$grant_write	= 1;	//0:all, 1:member, 2:user 3:system manager
			$xlev			= "2";	// no use.
			$memo			= "";
			$job_link_type = 'A';
			$table_width	= "500";
			$list_size		= 20;
			$memo_gubun	    = 1;
			$ip_gubun		= 0;
			$html_gubun	    = 0;
			$imember		= $H_ID;
			$list_table_set			= "align=center border=0 cellpadding=1 cellspacing=0";
			$list_title_bgcolor		= "#ffffff";
			$list_title_font			= "#000000";
			$list_text_bgcolor		= "#FFFFFF";
			$list_text_font			= "#000000";
			$detail_table_set		= "align=center border=0 cellpadding=1 cellspacing=0";
			$detail_title_bgcolor	= "#FFFFFF";
			$detail_title_font		= "#c0c0c0";
			$detail_text_bgcolor	= "#ffffff";
			$detail_text_font		= "#000000";
			$detail_memo_bgcolor	= "#ffffff";
			$detail_memo_font		= "#000000";
			$input_table_set		= "align=center border=0 cellpadding=1 cellspacing=0";
			$input_title_bgcolor	= "#FFFFFF";
			$input_title_font		= "#000000";
			$icon_home			= "home.gif"; 
			$icon_prev			= "e_prev.gif";
			$icon_next			= "e_next.gif";
			$icon_insert		= "e_insert.gif";
			$icon_update		= "e_update.gif";
			$icon_delete		= "e_delete.gif";
			$icon_reply			= "e_reply.gif";
			$icon_list			= "e_list.gif";
			$icon_search_list	= "search_list.gif";
			$icon_search		= "search.gif";
			$icon_submit		= "e_submit.gif";
			$icon_new			= "new.gif";
			$icon_list_reply	= "list_reply.gif";
			$icon_memo			= "memo.gif";
			$icon_admin			= "e_admin.gif";
			$list_gubun			= 1;
			$connection_gubun	= 1;
			$top_html			= "";
			$bottom_html		= "";
			$title_color		= "#FFFFFF";
			$title_text_color	= "#000000";
			$security			= "0";
			$session_club_url = KAPP_URL_;
			$sys_pg_root		= $mroot;

			$query = "insert into {$tkher['aboard_infor_table']} set
			name      ='$board_title',
			table_name='$table_name',
			fileup    = $fileup,
			in_date   = $in_date,
			memo_gubun= $memo_gubun,
			ip_gubun  = $ip_gubun,
			html_gubun= $html_gubun,
			imember   ='$imember',
			home_url  ='$home_url',
			table_width='$table_width',
			list_table_set    ='$list_table_set',
			list_title_bgcolor='$list_title_bgcolor',
			list_title_font   ='$list_title_font',
			list_text_bgcolor ='$list_text_bgcolor',
			list_text_font    ='$list_text_font',
			list_size         = $list_size,
			detail_table_set  ='$detail_table_set',
			detail_title_bgcolor='$detail_title_bgcolor',
			detail_title_font   ='$detail_title_font',
			detail_text_bgcolor ='$detail_text_bgcolor',
			detail_text_font    ='$detail_text_font',
			detail_memo_bgcolor ='$detail_memo_bgcolor',
			detail_memo_font    ='$detail_memo_font',
			input_table_set     ='$input_table_set',
			input_title_bgcolor ='$input_title_bgcolor',
			input_title_font    ='$input_title_font',
			icon_home  ='$icon_home',
			icon_prev  ='$icon_prev',
			icon_next  ='$icon_next',
			icon_insert='$icon_insert',
			icon_update='$icon_update',
			icon_delete='$icon_delete',
			icon_reply ='$icon_reply',
			icon_list  ='$icon_list',
			icon_search_list='$icon_search_list',
			icon_search ='$icon_search',
			icon_submit ='$icon_submit',
			icon_new    ='$icon_new',
			icon_list_reply='$icon_list_reply',
			icon_memo   ='$icon_memo',
			icon_admin  ='$icon_admin',
			list_gubun  = $list_gubun,
			connection_gubun = $connection_gubun,
			top_html    ='$top_html',
			bottom_html ='$bottom_html',
			grant_view  = $grant_view,
			grant_write = $grant_write,
			movie       ='$movie',
			title_color='$title_color',
			title_text_color='$title_text_color',
			security ='$security',
			lev      ='$xlev',
			make_id  ='$H_ID',
			make_club='$session_club_url',
			sunbun   = 0,
			memo     ='$memo' ";
			$mq2 = sql_query($query);
			if( $mq2 ){
					$f_path1	= KAPP_PATH_T_ . "/file/" . $H_ID;
					$f_path2	= $f_path1 . "/aboard_".$table_name;
					if ( !is_dir($f_path1) ) {
						if ( !@mkdir( $f_path1, 0755 ) ) {
							echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. my_func -> create_aboard_table_make_menu()";
							m_(" Error: f_path1 : " . $f_path1 . " Failed to create directory. my_func -> create_aboard_table_make_menu()");
						}
					}
					if ( !is_dir($f_path2) ) {
						$oldumask = umask(0);
						mkdir($f_path2, 0775, true);
						umask($oldumask);
					}
			} else {
				echo "my_func : create_aboard_table_make_menu - sql: " . $query; exit;
			}
			return $link_name;
		} else return;
	}
	function create_aboard_table_make( $board_title, $mroot, $board_type ){
		global $table_name, $H_ID, $up_day, $sys_pg_root, $code_name;
		global $max_num;
		$ip = $_SERVER['REMOTE_ADDR'];
		$result = sql_query("SELECT * from aboard_admin ");
		$rs 	= sql_fetch_array( $result );
		$bbsname= $rs['bbsname'];	//tkher
		$in_date=time();
		$result = sql_query("select max(no) as no from {$tkher['aboard_infor_table']} ");
		$rs = sql_fetch_array( $result );
		$board_num = $rs['no'];
		if( !$board_num ) $board_num = 1;
		else $board_num = $board_num +1;
		$table_name = $bbsname . $H_ID . $board_num;
		$code_name	= $table_name;
		$xsys_pg 	= $table_name;
		$sys_subtit = $board_title;
		$sys_pg		= $xsys_pg;
		$query="create table aboard_$table_name (
		no int(11) NOT NULL auto_increment,
		infor int(11),
		id varchar(30),
		name varchar(30),
		email varchar(100),
		home varchar(200),
		ip varchar(15),
		in_date int(11),
		subject varchar(100),
		context text,
		html int(11),
		password varchar(10),
		file_name varchar(250),
		file_wonbon varchar(250),
		file_size int,
		file_type char(4),
		file_path varchar(200),
		cnt int(11),
		target int(11),
		step int(11),
		re int(11),
		security varchar(10),
		primary key(no) );";
		$mq1 = sql_query( $query );
		if( !$mq1 ) {
			echo("<script>alert('Bulletin board table creation failed.  $board_num, $table_name ');</script>");
		}
		$link_name = "";
		if( $mq1 ){
			$link_name		= '/t/bbs/index5.php?infor='.$board_num . "&inforT=".$table_name;
			$movie			= $board_type;
			$home_url 		= "GCOM05!";
			$fileup 			= "1";
			$grant_view	= "0";
			$grant_write	= "1";	//0:all, 1:member, 2:user 3:system manager
			$xlev				= "2";	// no use.
			$memo			= "";
			$job_link_type = 'A';
			$table_width	= "500";
			$list_size		= "20";
			$memo_gubun	= "1";
			$ip_gubun		= "0";
			$html_gubun	= "0";
			$imember		= $H_ID;
			$list_table_set			= "align=center border=0 cellpadding=1 cellspacing=0";
			$list_title_bgcolor		= "#ffffff";
			$list_title_font			= "#000000";
			$list_text_bgcolor		= "#FFFFFF";
			$list_text_font			= "#000000";
			$detail_table_set		= "align=center border=0 cellpadding=1 cellspacing=0";
			$detail_title_bgcolor	= "#FFFFFF";
			$detail_title_font		= "#c0c0c0";
			$detail_text_bgcolor	= "#ffffff";
			$detail_text_font		= "#000000";
			$detail_memo_bgcolor	= "#ffffff";
			$detail_memo_font		= "#000000";
			$input_table_set		= "align=center border=0 cellpadding=1 cellspacing=0";
			$input_title_bgcolor	= "#FFFFFF";
			$input_title_font		= "#000000";
			$icon_home			= "home.gif";
			$icon_prev			= "e_prev.gif";
			$icon_next			= "e_next.gif";
			$icon_insert		= "e_insert.gif";
			$icon_update		= "e_update.gif";
			$icon_delete		= "e_delete.gif";
			$icon_reply			= "e_reply.gif";
			$icon_list			= "e_list.gif";
			$icon_search_list	= "search_list.gif";
			$icon_search		= "search.gif";
			$icon_submit		= "e_submit.gif";
			$icon_new			= "new.gif";
			$icon_list_reply	= "list_reply.gif";
			$icon_memo			= "memo.gif";
			$icon_admin			= "e_admin.gif";
			$list_gubun			= "1";
			$connection_gubun	= "1";
			$top_html			= "";
			$bottom_html		= "";
			$title_color			= "#FFFFFF";
			$title_text_color	= "#000000";
			$security			= "0";
			$session_club_url = KAPP_URL_;
			$sys_pg_root		= $mroot;
			$query="insert into {$tkher['aboard_infor_table']} values('',
			'$board_title',
			'$table_name',
			'$fileup',
			'$in_date',
			'$memo_gubun',
			'$ip_gubun',
			'$html_gubun',
			'$imember',
			'$home_url',
			'$table_width',
			'$list_table_set',
			'$list_title_bgcolor',
			'$list_title_font',
			'$list_text_bgcolor',
			'$list_text_font',
			'$list_size',
			'$detail_table_set',
			'$detail_title_bgcolor',
			'$detail_title_font',
			'$detail_text_bgcolor',
			'$detail_text_font',
			'$detail_memo_bgcolor',
			'$detail_memo_font',
			'$input_table_set',
			'$input_title_bgcolor',
			'$input_title_font',
			'$icon_home',
			'$icon_prev',
			'$icon_next',
			'$icon_insert',
			'$icon_update',
			'$icon_delete',
			'$icon_reply',
			'$icon_list',
			'$icon_search_list',
			'$icon_search',
			'$icon_submit',
			'$icon_new',
			'$icon_list_reply',
			'$icon_memo',
			'$icon_admin',
			'$list_gubun',
			'$connection_gubun',
			'$top_html',
			'$bottom_html',
			'$grant_view',
			'$grant_write',
			'$movie',
			'$title_color',
			'$title_text_color',
			'$security',
			'$xlev',
			'$H_ID',
			'$session_club_url',
			'$rec_total',
			'$memo'
			)";
			$mq2=sql_query($query);
			$sql = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$session_club_url', user_name='$board_title', job_name='$board_title', job_addr='$link_name', job_level='2', job_group='aboard', job_group_code='$sys_pg_root', num='$table_name', up_day='$up_day', aboard_no='$board_num', jong='A'";
			sql_query( $sql );
			return $link_name;
		} else return;
	}

	function sql_data_seek($mq)
	{
		if( function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE)
			 mysqli_data_seek($mq,$seek);
		else mysql_data_seek($mq,$seek);
		return $mq;
	}
	function sql_fetch_row($result)
	{
		if( function_exists('mysqli_num_rows') && KAPP_MYSQLI_USE)	return mysqli_fetch_row($result);
		else	return mysql_fetch_row($result);
	}

//---------------------------------------------
function login_count( $call_pg ,$id){
	global $login_count_today, $login_count_total;
	$day = date("Y-m-d",time());

	$sql = "SELECT vs_count FROM {$tkher['visit_sum_table']} WHERE vs_date = '$day' ";
	$ret = sql_query( $sql );
	$cnt = $ret->num_rows;
	if( $ret->num_rows > 0 ) {
		$res = sql_fetch_array( $ret);
		$login_count_today = $res['vs_count'] +1;
		$sql = " update {$tkher['visit_sum_table']} set vs_count=vs_count+1 where vs_date = '".date("Y-m-d",time())."' ";
		$ret = sql_query( $sql );
		if( $ret ) {
			//m_("ok update ");
		} else {
			m_(" kapp_visit_sum error update ");
		}
	} else {
		$login_count_today = 1;
		$sql = " insert into {$tkher['visit_sum_table']} set vs_count=1, vs_date = '".date("Y-m-d",time())."' ";
		$ret = sql_query( $sql );
		if( !$ret ) {
			m_("visit_sum_table insert error ");
			exit;
		} else {
			//m_(" insert ok "); //echo "sql: " . $sql;
		}
	}
}
function connect_count($call_pg ,$id, $ipcheck, $_REFERER){
	global $tkher, $member;
		$ip = escape_trim($_SERVER['REMOTE_ADDR']); 
		$host	 = getenv("HTTP_HOST");
		$agent	 = getenv("HTTP_USER_AGENT");
		$Accept  = getenv("HTTP_ACCEPT");
		if( isset($_SERVER['HTTP_REFERER']) ) $_REFERER  = $_SERVER['HTTP_REFERER'];
		else $_REFERER  = '';
		$msg		= $ip . "|" . $agent . "|" . $Accept;
		$pattern = "/mobile/i";
		if( preg_match($pattern, $agent, $matches)){
			$type='mobile';
		} else{
			$type='pc';
		}
		$ipcode = "";
		$ipname = "";
		date_default_timezone_set("Asia/Seoul");
		$day = date("Y-m-d H:i:s");
		$ret = sql_query("INSERT into {$tkher['log_info_table']} SET url='$call_pg', name='$id', id='$id',ip='$ip', msg='$msg', type='$type' , country_cd='$ipcode', country_name='$ipname', uptime='$day', start_pg='$_REFERER', email='$id' " );
		return $ret;
}
function connect_count_search($call_pg ,$id, $ipcheck, $sdata){
	global $ipcode, $host;
		$ip  = $_SERVER['REMOTE_ADDR'];
		$host	 = $_SERVER['HTTP_HOST'];
		$sdata   = $_SERVER['SCRIPT_NAME'];
		$agent	 = getenv("HTTP_USER_AGENT");
		$Accept  = getenv("HTTP_ACCEPT");
		$msg		= "host:".$host.", ip:".$ip . "|" . $agent . "|" . $Accept;
		$pattern = "/mobile/i";
		if( preg_match($pattern, $agent, $matches)){
			$type='mobile';
		} else{
			$type='pc';
		}
		$ip_num = htol($ip);	//2342680517
		$ret = sql_query("SELECT * from ip_info where ipno1 <= $ip_num and ipno2 >= $ip_num " );
		$tot = sql_num_rows( $ret );
		$rs = sql_fetch_array( $ret );
		$ipcode = $rs['country_cd'];
		$ipname = $rs['country_name'];
		date_default_timezone_set("Asia/Seoul");
		$day = date("Y-m-d H:i:s");
		if( $id ) $user = $id;
		else $user = 'guest';
		sql_query("INSERT into {$tkher['log_info_table']} SET url='$host', name='$user', id='$user',ip='$ip', msg='$msg', type='$type' , country_cd='$ipcode', country_name='$ipname', uptime='$day', start_pg='$call_pg', click_url='$sdata' " );
		return $ipcode;
}

function htol($ipaddr) {
    $b = explode('.',$ipaddr);
    if (sizeof($b) == 4) {
        $c = ($b[0]*256*256*256) + ($b[1]*256*256) + ($b[2]*256) + ($b[3]*1);
        return $c;
    } else return;
}
function ltoh($addr) {
    $ahex = dec2hex($addr);
    for ($i = 0; $i < 8; $i++) {
        $ii[$i] = hexdec(substr($ahex, $i * 2, 2));
    }
    echo "$ii[0] $ii[1] $ii[2] $ii[3]";
}
function dec2hex($dec) {
    if($dec > 2147483648) {
        $result = dechex($dec - 2147483648);
        $prefix = dechex($dec / 268435456);
        $suffix = substr($result,-7);
        $hex = $prefix.str_pad($suffix, 7, "0000000", STR_PAD_LEFT);
    } else {
        $hex = dechex($dec);
    }
    return($hex);
}
function Encrypt($str, $secret_key='secret key', $secret_iv='secret iv')
{
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); //32->16
    return str_replace("=", "", base64_encode(
                 openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
    );
}
function Decrypt($str, $secret_key='secret key', $secret_iv='secret iv')
{
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); //32->16
    return openssl_decrypt(
            base64_decode($str), "AES-256-CBC", $key, 0, $iv
    );
}

	function Shorten_StringX($String, $MaxLen, $ShortenStr)  {
		$StringLen = strlen($String);
		for ($i = 0, $count = 0, $tag = 0; $i <= $StringLen && $count < $MaxLen; $i++ ) {
			$LastStr = substr($String, $i, 1);
			if ($LastStr == '<') $tag = 1;
			if ($tag && $LastStr == '>') { $tag = 0; continue; }
			if ($tag) continue;
			if ( ord($LastStr) > 127 ) { $count++; $i++; }
			$count++;
		}
		$gubun=substr($String,0,2);
		$RetStr = substr($String, 0, $i);

		if ($count<$MaxLen) return $RetStr;
		else return $RetStr .= $ShortenStr;

	}

	function html_symbolX($str)
	{
		return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
	}

	// TEXT 형식으로 변환
	function get_textR($str, $html=0, $restore=false)
	{
		$source = array();
		$target = array();

		$source[] = "<";
		$target[] = "&lt;";
		$source[] = ">";
		$target[] = "&gt;";
		$source[] = "\"";
		$target[] = "&#034;";
		$source[] = "\'";
		$target[] = "&#039;";

		if($restore) $str = str_replace($target, $source, $str);
		// 3.31	// TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
		if ($html == 0) {
			$str = html_symbolX($str);
		}
		if ($html) {
			$source[] = "\n";
			$target[] = "<br/>";
		}
		return str_replace($source, $target, $str);
	}
function get_text($str, $html=0, $restore=false)
{
    $source[] = "<";
    $target[] = "&lt;";
    $source[] = ">";
    $target[] = "&gt;";
    $source[] = "\"";
    $target[] = "&#034;";
    $source[] = "\'";
    $target[] = "&#039;";

    if($restore)  $str = str_replace($target, $source, $str);

    // TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
    if ($html == 0) {
        $str = html_symbol($str);
    }

    if ($html) {
        $source[] = "\n";
        $target[] = "<br/>";
    }

    return str_replace($source, $target, $str);
}
	function html_symbol($str)
	{
		return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
	}

	function gmail( $s_enm, $s_e, $mb_name, $mb_email, $subject, $content, $no){
		$mail = new PHPMailer(true);
		try {
			//Server settings
			$mail->SMTPDebug = 2; 
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';					// Specify main and backup SMTP servers GMAIL
			$mail->SMTPAuth = true;                         // Enable SMTP authentication
			$mail->Username = '';		// SMTP username
			$mail->Password = '';                      // SMTP password 2018-12-15 : 비밀번호 변경.
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;										// TCP port to connect to
			$mail->CharSet = 'utf-8';
			$mail->setFrom('', '');	// send e-mail 
			$mail->addAddress($mb_email, $mb_name);     // Add a recipient
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $content;
			$mail->send();
			echo 'Message has been sent';
		} catch (Exception $e) {
			echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			//Message could not be sent. Mailer Error: Message body emptyMessage could not be sent. Mailer Error: Message body empty
		}
		//---------------------------------------
	}

	function sendMail($EMAIL, $NAME, $SUBJECT, $CONTENT, $mailto){
		 $admin_email = $EMAIL;
		 $admin_name  = $NAME;
		 $header  = "Return-Path: ".$admin_email . " \r\n";
		 $header .= "From: ". $admin_name ." <".$admin_email."> \r\n";
		 $header .= "MIME-Version: 1.0 \r\n";
		 $header .= "X-Priority: 3 \r\n";
		 $header .= "X-MSMail-Priority: Normal \r\n";
		 $header .= "X-Mailer: FormMailer \r\n";
		 $header .= "Content-Transfer-Encoding: base64 \r\n";
		 $header .= "Content-Type: text/html;\n \t charset=utf-8";
		 $subject  = $SUBJECT;
		 $message = base64_encode($CONTENT);
		 flush();
		 @mail($mailto, $subject, $message, $header);
	}
	function my_msg($message) {
		echo "<script language='javascript'>alert('$message');</script>";
	}

	function my_back() {
		echo "<script language='javascript'>history.back();</script>";
	}

	function my_jump($url) {
		echo "<script language='javascript'>location.href( $url );</script>";
	}
	function id_jump($url) {
		echo "<script language='javascript'>location.href( $url );</script>";
	}
	function error_msg($msg) {
		echo "<script language='javascript'>alert( ' $msg ');</script>";
	}
	function error_msg2($msg) {
		echo "<script language='javascript'>alert('$msg');history.back();</script>";
	}

	######## 1~45 ###################
	function my_random() {
		$temp = range(1,45);
		shuffle($temp);
		for($i=0;$i<6;$i++) {
			$ran_num = $ran_num."+".$temp[$i];
		}
		return $ran_num;
	}

	####### 이미지 파일인지 확장자를 체크하여 반환 #######################
	function my_check_image($temp) {
		$ext_name = substr($temp, -3);
		if ($ext_name == "JPG" || $ext_name == "jpg" || $ext_name == "GIF" || $ext_name == "gif" || $ext_name == "PNG" || $ext_name == "png")
			 $check_image = 1;
		else $check_image = 0;
		return $check_image;
	}

	####### 이미지 파일인지 확장자를 체크하여 반환 #######################
	function my_check_image_size($temp1, $temp2) {
		$temp2 = $temp2 * 1000000;
		if ($temp1 <= $temp2) $check_size = 1;
		else $check_size = 0;

		######### 가짜 이미지 파일일 경우(확장자만 JPG나 GIF로 바꾼 경우)
		if (!$temp1) $check_size = 2;

		return $check_size;
	}

	####### 허용가능 파일인지 확장자를 체크하여 반환 #######################
	function my_check_file($temp) {
		$temp = strtolower($temp);
		$ext_name = substr($temp, -3);
		if ($ext_name == "zip" || $ext_name == "png" || $ext_name == "gif" || $ext_name == "jpg" || $ext_name == "txt" || $ext_name == "hwp" || $ext_name == "ppt" || $ext_name == "hwp" || $ext_name == "csv" || $ext_name == "xml" || $ext_name == "xls" || $ext_name == "doc" || $ext_name == "xlsx" || $ext_name == "pdf"  ) $check_file = 1;
		else $check_file = 0;
		return $check_file;
	}

	####### 이미지 파일인지 확장자를 체크하여 반환 #######################
	function my_check_file_size($temp1, $temp2) {
		$temp2 = $temp2 * 1000000;
		if ($temp1 <= $temp2) $check_size = 1;
		else $check_size = 0;

		######### 잘못된 모맷의 파일일 경우
		if (!$temp1) $check_size = 2;

		return $check_size;
	}

	####### 이미지를 포함한 게시판 리스트 ################################
	function my_bbs_list2($board, $title, $width, $limit, $t_cut, $c_cut, $title_width) {
		include "inc/dbcon.php";
		$t_result = mysql_query("select count(*) from $board",$mc);
		$t_num = mysql_result($t_result,0,0);
		echo "<table border=0 cellpadding=2 cellspacing=0 width=$width>
				<tr>
					<td colspan=2 width=$width height=20 bgcolor='#e1e1e1'><a href='bbs_list.php?board=$board'>▶ <b>$title</b> <font style='font-size:10px; font-family:arial'>[Total : $t_num]</font></a></td>
				</tr>
				<tr><td height=4></td></tr>";

		$width2 = $title_width-38;
		$result = mysql_query("SELECT * from $board order by no desc limit $limit",$mc);
		while ($rs = mysql_fetch_array($result)) {

			$rs['title'] = htmlspecialchars($rs['title']);
			$rs['contents'] = htmlspecialchars($rs['contents']);

			$rs['title']=cutstr($rs['title'], $t_cut);
			$rs['contents']=cutstr($rs['contents'], $c_cut);

			$date = date("m-d", $rs['uptime']);

			if (!$rs['image']) {
				$rs['image'] = "../no_image.gif";
			}

		echo "<tr>
				<td><img src='bbs_image/free/".$rs['image']."' width=50 height=50 border=1></td>
				<td valign=top>
					<table border=0 cellpadding=1 cellspacing=0>
						<tr><td width='$width2'><b><a href='bbs_view.php?board=$board&no=".$rs['no']."'>".$rs['title']."</a></b></td><td width=38 align=center><font style='font-size:10px; font-family:arial'>$date</font></td></tr>
						<tr><td colspan=2 width='$title_width'><a href='bbs_view.php?board=$board&no=".$rs['no']."'>".$rs['contents']."</a></td></tr>
					</table>
				</td>
			</tr>";
		} #while 끝

		echo "<tr><td height=4></td></tr>
			<tr><td colspan=2 height=1 bgcolor='#a0a0a0'></td></tr>
			</table>";
	}

	####### 단순 게시판 리스트 ##########################################
	function my_bbs_list($board, $title, $width, $limit, $cut) {
		include "inc/dbcon.php";
		$t_result = mysql_query("select count(*) from $board",$mc);
		$t_num = mysql_result($t_result,0,0);
		echo "<table border=0 cellpadding=2 cellspacing=0 width=$width>
				<tr>
					<td colspan=2 width=$width height=20 bgcolor='#e1e1e1'><a href='bbs_list.php?board=$board'>▶ <b>$title</b> <font style='font-size:10px; font-family:arial'>[Total : $t_num]</font></a></td>
				</tr>
				<tr><td height=4></td></tr>";

		$result = mysql_query("SELECT * from $board order by no desc limit $limit",$mc);
		while ($rs = mysql_fetch_array($result)) {
			$rs['title'] = htmlspecialchars($rs['title']);
			$rs['title']=cutstr($rs['title'], $cut);
			$date = date("m-d", $rs['uptime']);

		echo "<tr><td><a href='bbs_view.php?board=$board&no=".$rs['no']."'>".$rs['title']."</a></td><td width=30><font style='font-size:10px; font-family:arial'>$date</font></td></tr>";
		} # while 끝

		echo "</table>";
	}

	function my_bbs_list_no_title($board, $width, $limit, $cut) {
		include "inc/dbcon.php";
		require "bbs_func.php";
		echo "<table border=0 cellpadding=0 cellspacing=0 width=$width>";
		$result = mysql_query("SELECT * from $board order by no desc limit $limit",$mc);
		while ($rs = mysql_fetch_array($result)) {
			$rs['title'] = htmlspecialchars($rs['title']);
			$rs['title']=cutstr($rs['title'], $cut);
			$date = date("m-d", $rs['uptime']);

		echo "<tr><td><a href='bbs_view.php?board=$board&no=".$rs['no']."'>".$rs['title']."</a></td><td width=30><font style='font-size:10px; font-family:arial'>$date</font></td></tr>";
		} # while 끝

		echo "</table>";
	}
	function my_img_resize($img_width, $img_height, $my_width, $my_height) {
		if ($img_width >= $img_height) {
			if ($img_width > $my_width) {
				$rate = $my_width / ($img_width / 100);
				$fixed_width = $my_width;
				$fixed_height = ($rate / 100) * $img_height;
			}
			else {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
			if ($fixed_height > $my_height) {
				$rate = $my_height / ($fixed_height / 100);
				$fixed_height = $my_height;
				$fixed_width = ($rate / 100) * $fixed_width;
			}
			if ($img_width <= $my_width && $img_height <= $my_height) {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
		}
		if ($img_width < $img_height) {
			if ($img_height > $my_height) {
				$rate = $my_height / ($img_height / 100);
				$fixed_height = $my_height;
				$fixed_width = ($rate / 100) * $img_width;
			}
			else {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
			if ($fixed_width > $my_width) {
				$rate = $my_width / ($fixed_width / 100);
				$fixed_width = $my_width;
				$fixed_height = ($rate / 100) * $fixed_height;
			}
			if ($img_width <= $my_width && $img_height <= $my_height) {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
		}

		$temp[0] = $fixed_width;
		$temp[1] = $fixed_height;

		return $temp;
	}

	function my_today($input_time) {
		$temp_time = time();
		$sys_year = date("Y",$temp_time);
		$sys_month = date("m",$temp_time);
		$sys_day = date("d",$temp_time);
		$today1 = mktime(0,0,0,$sys_month,$sys_day,$sys_year);
		$today2 = mktime(23,59,59,$sys_month,$sys_day,$sys_year);
		# 픽업 시작일이 시스템 날짜상의 '오늘'에 해당하는지 체크
		if ($today1 < $input_time && $today2 > $input_time) $time_result=1;
		else $time_result=0;

		return $time_result;
	}

	function my_cutstr($String, $Num) {
		if(strlen($String) <= $Num) return $String;
		if(ord(substr($String, $Num-1, 1)) < 127) return substr($String, 0, $Num);
		$check_i = 0;
		for($i=0;$i<$Num;$i++) {
			if(ord(substr($String,$i,1))<127) $check_i++;
			else $i++;
		}
		if(($Num % 2 == 0) && ($check_i % 2 != 0) || ($Num % 2 != 0) && ($check_i % 2 == 0))
			return $String = substr($String,0, $Num-1);
		else return $String = substr($String,0, $Num);
	}

	function my_random_sort() {
		$temp = range(1,100);
		shuffle($temp);
		switch ($temp[0] % 3) {
			case 0 : $sort = "p_discount_rate"; break;
			case 1 : $sort = "p_bidder_num"; break;
			case 2 : $sort = "p_no"; break;
		}
		return $sort;
	}

	function my_pass_cnt($p_idx) {
		include "inc/dbcon.php";
		$pass_result = mysql_query("select pass_cnt from product_cnt where p_idx='$p_idx'",$mc);
		$pass_rs = mysql_fetch_array($pass_result);
		return $pass_rs['pass_cnt'];
	}
	function referer_check_url($url='')
	{
		global $tkher;
		if (!$url)
			$url = KAPP_URL;

		if (!preg_match("/^http['s']?:\/\/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			m_("Please follow the normal procedure. ". $url);  //제대로 된 접근이 아닌것 같습니다.
			echo "<script>window.open( '$url/tkher_register_.php' , '_self', ''); </script>";
			exit;
		}
	}
	function check_passwordA($pass, $hash)
	{
		$password = get_encrypt_stringA($pass);
		return ($password === $hash);
	}
	function get_encrypt_stringA($str){
		if(defined('KAPP_STRING_ENCRYPT_FUNCTION') && KAPP_STRING_ENCRYPT_FUNCTION) {
			$encrypt = call_user_func(KAPP_STRING_ENCRYPT_FUNCTION, $str);
		} else {
			$encrypt = sql_passwordA($str);
		}
		return $encrypt;
	}
	function sql_passwordA($value){
		$row = sql_fetch(" select password('$value') as pass ");
		return $row['pass'];
	}
	function insert_point_app($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0){
		global $config;
		global $tkher;
		global $is_admin;
		global $member;
		if( !$config['kapp_use_point']) { return 0; }
		if( $point == 0) { return 0; } 
		if( $mb_id == '') { return 0; }
		$mb = sql_fetch(" select mb_id, mb_point from {$tkher['tkher_member_table']} where mb_id = '$mb_id' ");
		if( !$mb['mb_id']) { return 0; }
		$mb_point = $mb['mb_point'];
		$po_mb_point = $mb_point + $point;
		$sql = " update {$tkher['tkher_member_table']} set mb_point = mb_point + $point where mb_id = '$mb_id' ";
		sql_query($sql);
		$po_expire_date = '9999-12-31';
		$po_expired = $expire;
		$day = date("Y-m-d H:i:s", time());
		$sql = " insert into {$tkher['point_table']}
					set mb_id         = '$mb_id',
						po_datetime   = '".$day."',
						po_title    = '" . $rel_table . "',
						po_content    = '" . $content . "',
						po_point      = $point,
						po_use_point  = 0,
						po_mb_point   = $po_mb_point,
						po_expired    = '$po_expired',
						po_expire_date= '$po_expire_date',
						po_rel_table  = '$rel_table',
						po_rel_id     = '$rel_id',
						po_rel_action = '$rel_action' ";
		$ret = sql_query($sql);
		if(!$ret) { m_("error - my_func"); echo "sql: " . $sql; exit;}
		return 1;
	}

function get_microtime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}
function sql_set_charset($charset, $link=null)
{
    global $tkher;
    if( !$link)
        $link = $tkher['connect_db'];
    if( function_exists('mysqli_set_charset') && KAPP_MYSQLI_USE)
        mysqli_set_charset( $link, $charset);
    else
        mysql_query(" set names {$charset} ", $link);
}
function sql_connect( $host, $user, $pass, $db=KAPP_MYSQL_DB)
{
    global $tkher;
    if( function_exists('mysqli_connect') && KAPP_MYSQLI_USE) {
        $link = mysqli_connect($host, $user, $pass, $db);
        if( mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connect($host, $user, $pass);
    }
    return $link;
}
function escape_trim($field)
{
    $str = call_user_func(KAPP_ESCAPE_FUNCTION, $field);
    return $str;
}
function clean_xss_tags($str)
{
    $str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);

    return $str;
}
function set_session($session_name, $value)
{
    if (PHP_VERSION < '5.3.0')
        session_register($session_name);
    $$session_name = $_SESSION[$session_name] = $value;
}
function get_session($session_name)
{
    return isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : '';
}
function set_cookie($cookie_name, $value, $expire)
{
    global $tkher;
    setcookie(md5($cookie_name), base64_encode($value), KAPP_SERVER_TIME + $expire, '/', KAPP_COOKIE_DOMAIN);
}
function get_cookie($cookie_name)
{
    $cookie = md5($cookie_name);
    if (array_key_exists($cookie, $_COOKIE))
        return base64_decode($_COOKIE[$cookie]);
    else
        return "";
}
function _token()
{
    return md5(uniqid(rand(), true));
}
function get_token()
{
    $token = md5(uniqid(rand(), true));
    set_session('ss_token', $token);
    return $token;
}
function check_token()
{
    set_session('ss_token', '');
    return true;
}
function is_utf8($str)
{
    $len = strlen($str);
    for($i = 0; $i < $len; $i++) {
        $c = ord($str[$i]);
        if ($c > 128) {
            if (($c > 247)) return false;
            elseif ($c > 239) $bytes = 4;
            elseif ($c > 223) $bytes = 3;
            elseif ($c > 191) $bytes = 2;
            else return false;
            if (($i + $bytes) > $len) return false;
            while ($bytes > 1) {
                $i++;
                $b = ord($str[$i]);
                if ($b < 128 || $b > 191) return false;
                $bytes--;
            }
        }
    }
    return true;
}
function utf8_strcut( $str, $size, $suffix='...' )
{
        $substr = substr( $str, 0, $size * 2 );
        $multi_size = preg_match_all( '/[\x80-\xff]/', $substr, $multi_chars );
        if ( $multi_size > 0 )
            $size = $size + intval( $multi_size / 3 ) - 1;

        if ( strlen( $str ) > $size ) {
            $str = substr( $str, 0, $size );
            $str = preg_replace( '/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str );
            $str .= $suffix;
        }
        return $str;
}
function convert_charset($from_charset, $to_charset, $str){
    if( function_exists('iconv') )
        return iconv($from_charset, $to_charset, $str);
    elseif( function_exists('mb_convert_encoding') )
        return mb_convert_encoding($str, $to_charset, $from_charset);
    else
        die("Not found 'iconv' or 'mbstring' library in server.");
}
function sql_real_escape_string($str, $link=null){
    global $tkher;
    if(!$link)
        $link = $tkher['connect_db'];
    return mysqli_real_escape_string($link, $str);
}
function referer_check($url=''){
    global $tkher;
    if (!$url)
        $url = KAPP_URL_T_;

    if (!preg_match("/^http['s']?:\/\/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
        alert("Please follow the normal procedure. ", $url);
		echo "<script>window.open( '$url/tkher_register_.php' , '_self', ''); </script>";
	}
}
function sql_free_result($result){
    if(function_exists('mysqli_free_result') && KAPP_MYSQLI_USE)
        return mysqli_free_result($result);
    else
        return mysql_free_result($result);
}
function sql_password($value){
    $row = sql_fetch(" select password('$value') as pass ");
    return $row['pass'];
}
function sql_fetch_arrayG($result){
    if(function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}
function sql_fetch($sql, $error=null, $link=null){
    global $tkher;
    if( !$link) $link = $tkher['connect_db'];
    $result = sql_query($sql, $error, $link);
    $row = sql_fetch_array($result);
    return $row;
}
function sql_select_db($db, $connect){
    global $tkher;
    if(function_exists('mysqli_select_db') && KAPP_MYSQLI_USE)
        return @mysqli_select_db($connect, $db);
    else
        return @mysql_select_db($db, $connect);
}

function sql_query( $sql, $error=null, $link=null){
    global $tkher;
    if(!$link) $link = $tkher['connect_db'];
    $sql = trim($sql); // Blind SQL Injection 취약점 해결
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql);
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);
    if( function_exists('mysqli_query') && KAPP_MYSQLI_USE) {
        if( $error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);
        }
    } else {
        if( $error) {
            $result = @mysql_query($sql, $link) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysql_query($sql, $link);
        }
    }
    return $result;
}
function sql_fetch_array($result){
    if( function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE)
        $row = @mysqli_fetch_assoc($result);
    else
        $row = @mysql_fetch_assoc($result);

    return $row;
}
function sql_num_rows($result){
    if( function_exists('mysqli_num_rows') && KAPP_MYSQLI_USE )
        return mysqli_num_rows($result);
    else
        return mysql_num_rows($result);
}

function is_admin($mb_id){
    global $config, $group, $board;
    if( !$mb_id) return;
    if( $config['kapp_admin'] == $mb_id) return 'super';
    if( isset($group['gr_admin']) && ($group['gr_admin'] == $mb_id)) return 'group';
    return '';
}
function insert_point($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0){
    global $config;
    global $tkher;
    global $is_admin;

    if( !isset($mb_id) || $mb_id == '') { return 0; }
	if( !$config['kapp_use_point']) { return 0; }
    if( $point == 0) { return 0; }
    $mb = sql_fetch(" select mb_id from {$tkher['tkher_member_table']} where mb_id = '$mb_id' ");
    $mb_point = get_point_sum($mb_id);
    if( $rel_table || $rel_id || $rel_action){
        $sql = " select count(*) as cnt from {$tkher['point_table']}
                  where mb_id = '$mb_id'
                    and po_rel_table = '$rel_table'
                    and po_rel_id = '$rel_id'
                    and po_rel_action = '$rel_action' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
            return -1;
    }
    $po_expire_date = '9999-12-31';
    if( $config['kapp_point_term'] > 0) {
        if( $expire > 0)
            $po_expire_date = date('Y-m-d', strtotime('+'.($expire - 1).' days', KAPP_SERVER_TIME));
        else
            $po_expire_date = date('Y-m-d', strtotime('+'.($config['kapp_point_term'] - 1).' days', KAPP_SERVER_TIME));
    }
    $po_expired = 0;
    if( $point < 0) {
        $po_expired = 1;
        $po_expire_date = KAPP_TIME_YMD;
    }
    $po_mb_point = $mb_point + $point;
    $sql = " insert into {$tkher['point_table']}
                set mb_id = '$mb_id',
                    po_datetime   = '".KAPP_TIME_YMDHIS."',
                    po_content    = '".addslashes($content)."',
                    po_point      = '$point',
                    po_use_point  = '0',
                    po_mb_point   = '$po_mb_point',
                    po_expired    = '$po_expired',
                    po_expire_date= '$po_expire_date',
                    po_title  = '$rel_table',
                    po_rel_table  = '$rel_table',
                    po_rel_id     = '$rel_id',
                    po_rel_action = '$rel_action' ";
    sql_query($sql);
    if( $point < 0) {
        insert_use_point($mb_id, $point);
    }
    $sql = " update {$tkher['tkher_member_table']} set mb_point = '$po_mb_point' where mb_id = '$mb_id' ";
    sql_query($sql);
    return 1;
}
function get_point_sum($mb_id){
    global $tkher, $config;
    $sql = " select sum(po_point) as sum_po_point
                from {$tkher['point_table']}
                where mb_id = '$mb_id' ";
    $row = sql_fetch($sql);
    return $row['sum_po_point'];
}
function get_member($mb_id, $fields='*')
{
    global $tkher;
    return sql_fetch(" select $fields from {$tkher['tkher_member_table']} where mb_id = TRIM('$mb_id') ");
}
function html_end(){
    global $html_process;
    return $html_process->run();
}
function add_stylesheet($stylesheet, $order=0)
{
    global $html_process;
    if(trim($stylesheet))
        $html_process->merge_stylesheet($stylesheet, $order);
}
function add_javascript($javascript, $order=0)
{
    global $html_process;

    if(trim($javascript))
        $html_process->merge_javascript($javascript, $order);
}

class html_process {
    protected $css = array();
    protected $js  = array();
    function merge_stylesheet($stylesheet, $order)
    {
        $links = $this->css;
        $is_merge = true;
        foreach($links as $link) {
            if($link[1] == $stylesheet) {
                $is_merge = false;
                break;
            }
        }
        if($is_merge)
            $this->css[] = array($order, $stylesheet);
    }
    function merge_javascript($javascript, $order)
    {
        $scripts = $this->js;
        $is_merge = true;
        foreach($scripts as $script) {
            if($script[1] == $javascript) {
                $is_merge = false;
                break;
            }
        }
        if($is_merge)
            $this->js[] = array($order, $javascript);
    }
    function run()
    {
        global $config, $tkher, $member;
		global $kapp_host;
        $tmp_sql = " select count(*) as cnt from {$tkher['login_table']} where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
        $tmp_row = sql_fetch($tmp_sql);

        if ($tmp_row['cnt']) {
            $tmp_sql = " update {$tkher['login_table']} set mb_id = '{$member['mb_id']}', lo_datetime = '".KAPP_TIME_YMDHIS."', lo_location = '{$kapp_host}', lo_url = '{$_SERVER['SCRIPT_NAME']}' where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
            sql_query($tmp_sql, FALSE);
        } else {
            $tmp_sql = " insert into {$tkher['login_table']} ( lo_ip, mb_id, lo_datetime, lo_location, lo_url ) values ( '{$_SERVER['REMOTE_ADDR']}', '{$member['mb_id']}', '".KAPP_TIME_YMDHIS."', '{$kapp_host}',  '{$_SERVER['SCRIPT_NAME']}' ) ";
            sql_query($tmp_sql, FALSE);
            sql_query(" delete from {$tkher['login_table']} where lo_datetime < '".date("Y-m-d H:i:s", KAPP_SERVER_TIME - (60 * $config['kapp_login_minutes']))."' ");
        }

        $buffer = ob_get_contents();
        ob_end_clean();
        $stylesheet = '';
        $links = $this->css;

        if(!empty($links)) {
            foreach ($links as $key => $row) {
                $order[$key] = $row[0];
                $index[$key] = $key;
                $style[$key] = $row[1];
            }
            array_multisort($order, SORT_ASC, $index, SORT_ASC, $links);
            foreach($links as $link) {
                if(!trim($link[1]))
                    continue;

                $link[1] = preg_replace('#\.css([\'\"]?>)$#i', '.css?ver='.KAPP_CSS_VER.'$1', $link[1]);

                $stylesheet .= PHP_EOL.$link[1];
            }
        }
        $javascript = '';
        $scripts = $this->js;
        $php_eol = '';
        unset($order);
        unset($index);
        if( !empty($scripts)) {
            foreach ($scripts as $key => $row) {
                $order[$key] = $row[0];
                $index[$key] = $key;
                $script[$key] = $row[1];
            }
            array_multisort($order, SORT_ASC, $index, SORT_ASC, $scripts);
            foreach($scripts as $js) {
                if(!trim($js[1]))
                    continue;
                $js[1] = preg_replace('#\.js([\'\"]?>)$#i', '.js?ver='.KAPP_JS_VER.'$1', $js[1]);
                $javascript .= $php_eol.$js[1];
                $php_eol = PHP_EOL;
            }
        }
        $buffer = preg_replace('#(</title>[^<]*<link[^>]+>)#', "$1$stylesheet", $buffer);
        $nl = '';
        if($javascript)
            $nl = "\n";
        $buffer = preg_replace('#(</head>[^<]*<body[^>]*>)#', "$javascript{$nl}$1", $buffer);
        return $buffer;
    }
}
function hyphen_hp_number($hp)
{
    $hp = preg_replace("/[^0-9]/", "", $hp);
    return preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $hp);
}
function login_url($url='')
{
    if (!$url) $url = KAPP_URL_T_;
    return urlencode(clean_xss_tags(urldecode($url)));
}
function https_url($dir, $https=true)
{
    if ($https) {
        if (KAPP_HTTPS_DOMAIN) {
            $url = KAPP_HTTPS_DOMAIN.'/'.$dir;
        } else {
            $url = KAPP_URL_T_.'/'.$dir;
        }
    } else {
        if (KAPP_DOMAIN) {
            $url = KAPP_DOMAIN.'/'.$dir;
        } else {
            $url = KAPP_URL_T_.'/'.$dir;
        }
    }
    return $url;
}
	function encryptA($_data, $_salt, $_iv) {
		$key = openssl_digest($_salt, 'sha256', true);
		$encrypt_jsonData = json_encode($_data);
		$encryptedData = openssl_encrypt($encrypt_jsonData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $_iv);
		return base64_encode($encryptedData);
	}
	function decryptA($_encryptedData, $_salt , $_iv) {
		$key = openssl_digest($_salt, 'sha256', true);
		$decryptedData = openssl_decrypt(base64_decode($_encryptedData), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $_iv);
		$encrypted_jsonData = json_decode($decryptedData);
		return $encrypted_jsonData;
	}

function is_mobile(){
    return preg_match('/'.KAPP_MOBILE_AGENT.'/i', $_SERVER['HTTP_USER_AGENT']);
}
function get_uniqid(){
    global $tkher;
    sql_query(" LOCK TABLE {$tkher['uniqid_table']} WRITE ");
    while (1){
        $key = date('ymdHis', time()) . str_pad((int)(microtime()*100), 2, "0", STR_PAD_LEFT);
        $result = sql_query(" insert into {$tkher['uniqid_table']} set uq_id = '$key', uq_ip = '{$_SERVER['REMOTE_ADDR']}' ", false);
        if ($result) break;
        usleep(10000); // 100분의 1초를 쉰다
    }
    sql_query(" UNLOCK TABLES ");
    return $key;
}

function iconv_utf8($str){
    return iconv('euc-kr', 'utf-8', $str);
}

function iconv_euckr($str){
    return iconv('utf-8', 'euc-kr', $str);
}

function check_device($device){
    global $is_admin;
    if ($is_admin) return;
    if ($device=='pc' && KAPP_IS_MOBILE) {
        alert('PC .', KAPP_URL_T_);
    } else if ($device=='mobile' && !KAPP_IS_MOBILE) {
        alert('mobile.', KAPP_URL_T_);
    }
}
function get_email_address($email)
{
    preg_match("/[0-9a-z._-]+@[a-z0-9._-]{4,}/i", $email, $matches);
    return $matches[0];
}

function check_string($str, $options)
{
    global $tkher;
    $s = '';
    for($i=0;$i<strlen($str);$i++) {
        $c = $str[$i];
        $oc = ord($c);
        // 한글
        if ($oc >= 0xA0 && $oc <= 0xFF) {
            if ($options & KAPP_HANGUL) {
                $s .= $c . $str[$i+1] . $str[$i+2];
            }
            $i+=2;
        }
        // 숫자
        else if ($oc >= 0x30 && $oc <= 0x39) {
            if ($options & KAPP_NUMERIC) {
                $s .= $c;
            }
        }
        // 영대문자
        else if ($oc >= 0x41 && $oc <= 0x5A) {
            if (($options & KAPP_ALPHABETIC) || ($options & KAPP_ALPHAUPPER)) {
                $s .= $c;
            }
        }
        // 영소문자
        else if ($oc >= 0x61 && $oc <= 0x7A) {
            if (($options & KAPP_ALPHABETIC) || ($options & KAPP_ALPHALOWER)) {
                $s .= $c;
            }
        }
        // 공백
        else if ($oc == 0x20) {
            if ($options & KAPP_SPACE) {
                $s .= $c;
            }
        }
        else {
            if ($options & KAPP_SPECIAL) {
                $s .= $c;
            }
        }
    }
    return ($str == $s);
}
function goto_url($url){
    $url = str_replace("&amp;", "&", $url);
	echo "<script> top.location.replace('$url'); </script>";//
    if( !headers_sent()){
        header('Location: '.$url);// 여기온다.
	} else {
		echo '<script>';
        echo 'location.replace("'.$url.'");';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
    }
    exit;
}

function pagingA($link, $total, $page, $size){
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;
	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>[First]</a><span>.</span>");
	} else {
		echo("<span>[Start].</span>");
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		echo("<a href='javascript:page_move($back_page)' >[Prev]</a><span>.</span>");
	} else {
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("<a href='javascript:void(0)' class=on>$i</a><span>.</span>"); }
		else         { echo("<a href='javascript:page_move($i)'>$i</a><span>.</span>"); }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'>[Next]</a><span>.</span>");
	}else { 
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
	}
	echo "</div>";
}

function getJsonText($jsontext) { // jsonText '\' 값 제거 
	return str_replace("\\\"", "\"", $jsontext);
}

?>
