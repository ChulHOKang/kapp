<?php

/*
17-09-20 : 메일발송 sendMail 추가
2021-01-27 : connect_count_search($call_pg ,$id, $ipcheck, $sdata) add
*/

//$from_session_url = "urllinkcoin.com";
$from_session_url = KAPP_URL_;
//$urllinkcoin_my_ip = "125.184.157.150";
//125.184.157.158
$urllinkcoin_my_ip = "125.184.157.158";
//$nicknm ='LinkCoin';
//$host = "tkher.com";
$nicknm ='AppGenerator';
$host = "appgenerator.net";
$snm    ='TKHER SYSTEM';
$tel    ='070-8259-5509';     // 홈페이지
$htel   ='010-7542-8567';    // 대표이사님
$tel1   ='070-8259-5509';     // 인쇄광고
$tel2   ='070-8259-5509';     // 마케팅팀-블로그
$fax    ='070-8259-5509';    //'0303-0799-1659';
$sano   ='605-14-31853';
$addr   ='부산시 동구 진시장로24-62호';
//$mail   ='2672415@naver.com';
$mail   ='crakan89@gmail.com';	//@naver.com';
$Htitle = "[K-App SYSTEM] : ".$tel." Mail:".$mail;

$user_login_time = 6000;
$upload_file_size_limit = 6 * 1000000;	// reply.php, replyTT.php, insert.php
$bbs_make_level = 1;	// add : 2018-06-25, 2018-06-28: 8에서 1로

//$Kakao_APP_KEY = "cd5a2a04d70b1eec352180e85c8cec47"; // ?
//$Kakao_APP_KEY = "0912c63a7fe3712a7dc1096471dfc0c6"; // javascript key 24c
//$Kakao_APP_KEY = "f1a7cbcada566d6cc0a9fd088f6ec69c"; // appgenerator, https://developers.kakao.com/console/app/652064 2024-04-01 사용 안함
//$Kakao_APP_KEY = "60917fc8a9568fe86042ce78782bac18"; // shop 2024-04-01 교체 //32자
//$Kakao_APP_KEY = "60917fc8a9568fe86042ce78782bac18"; // kapp_config 사용

/* point +, - : add 2021-03-23 중요. */
$dn_add_point = 10;     // 소스를 다운할때 생성자의 id에 포인트를 지급 한다.
$dn_minus_point = 1000; // 소스를 다운할때 사용자의 id에 포인트를 감소 한다.

/* start program design 중요. */
	$menu1TWPer=15;
	$menu1AWPer=100 - $menu1TWPer;
	$menu2TWPer=10;
	$menu2AWPer=50 - $menu2TWPer;
	$menu3TWPer=10;
	$menu3AWPer=33.3 - $menu3TWPer;
	$menu4TWPer=10;
	$menu4AWPer=25 - $menu4TWPer;

	$Xwidth='100%';
	$Xheight='100%';

	/* 자동등록방지.  */
	$strT  = "abcdefghijklmnopqrstuvwxyz";
    $strT .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $strT .= "0123456789";



	function special_comma_chk ($input) { // 특수문자 제거. "'"만 제거한다.
		if( is_array($input)) { //m_("---1");
			return array_map('special_chk', $input); 
		} else if ( is_scalar($input)) { //m_("---2");
				return preg_replace("/'/i", "", $input); //return preg_replace("/[ #\/\\\:;,'\"`<>()]/i", "", $input);
		} else { //m_("---3");
			return $input; 
		} 
	}

	function a_number_formatA($number_in_iso_format, $no_of_decimals=3, $decimals_separator='.', $thousands_separator='', $digits_grouping=3){
		// Check input variables
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


		// Prepare variables
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
		//$link = mysql_connect($host,$user,$pass);
		//mysql_select_db($name,$link);
		//get all of the tables
		if($tables == '*')
		{
			$tables = array();
			//$result = mysql_query('SHOW TABLES');
			//while($row = mysql_fetch_row($result))
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

		//cycle through
		foreach($tables as $table)
		{
//			$result = mysql_query('SELECT * from '.$table);
//			$num_fields = mysql_num_fields($result);
			$result = sql_query('SELECT * from ' . $table);
			$num_fields = sql_num_fields($result);

			$return.= 'DROP TABLE '.$table.';';
//			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$row2 = sql_fetch_row( sql_query('SHOW CREATE TABLE ' . $table) );
			$return.= "\n\n" . $row2[1] . ";\n\n";

			for ($i = 0; $i < $num_fields; $i++)
			{
//				while($row = mysql_fetch_row($result))
				while($row = sql_fetch_row( $result ) )
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j < $num_fields; $j++)
					{
						$row[$j] = addslashes($row[$j]);
//						$row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                        $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"' . $row[$j] . '"' ; } else { $return.= '""'; }
						if ($j < ($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}

		//save file
		$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
		fwrite($handle,$return);
		fclose($handle);
	}

	function coin_add_func($from_session_id, $point)
	{   // $config['kapp_write_point'] = 3000 당분간 , tkher_config table에 설정. upgrade:$config['kapp_comment_point'] = 1500
		global $tkher;
		global $config;
		//$point = $config['kapp_write_point'];
		$sql= " update {$tkher['tkher_member_table']} set mb_point=mb_point+$point where mb_id = '$from_session_id' ";
		sql_query($sql);
	}
	function coin_minus_func($H_ID, $point)
	{   // $config['kapp_download_point'] = 3000
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
		//	function insert_point_app($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0){
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

	function job_link_table_add( $sys_pg_root, $sys_subtit, $sys_link, $aboard_no, $job_group, $job_name, $jong ){
		global $H_ID, $H_EMAIL, $tkher;
				/*
				jong :  T: Link Tree
						U: Url Link.
						B: Tree Note
						D: Single Note
						F: Single Board. : BBS Single Board. Old.
						A: Aboard. : Single Board. New. : board_create_pop.php.
						P: Program.
				*/
		$ip = $_SERVER['REMOTE_ADDR'];
		$from_session_url = KAPP_URL_; //$_SERVER['HTTP_HOST'];
		$up_day  = date("Y-m-d-H:i:s");
		$result = sql_query("SELECT * from {$tkher['job_link_table']} where user_id='$H_ID' and user_name='$sys_subtit' and job_addr='$sys_link' ");
		$tot = sql_num_rows($result);
		if( $tot < 1 ) {
			$up_day = date("Y-m-d H:i:s");
			$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID',  email='$H_EMAIL', job_name='$job_name', user_name='$sys_subtit', num='$sys_pg_root', aboard_no='$aboard_no', job_addr='$sys_link', jong='$jong', job_group='$job_group', club_url='$from_session_url', job_level='0', ip='$ip', up_day='$up_day' ";
			$ret = sql_query( $sqlA );
			//insert_point_app( $H_ID, $config['kapp_write_point'], $sys_link, 'program_create@app_pg50RC', $pg_name, $tab_hnm);
			$memo = 'tit:' . $sys_subtit . ', sys_pg:' .$sys_pg_root. ', aboard_no:' . $aboard_no;
			//$job_name = 'mylist'
			if( $ret ) {
				Link_Table_curl_send( $sys_subtit, $sys_link, $jong, $from_session_url, $ip, $memo, $up_day );
				return true;
			} else {
				echo "my_func, job_link_table_add error sql: " .$sqlA; exit;
				//sql: insert into set user_id='dao', email='crakan59@gmail.com', job_name='mylist', user_name='moado.net DB Title', num='U', aboard_no='Ulist single', job_addr='https://u07031000-l20-002.iwinv.kr/webmysql/phpMyAdmin/index.php?route=/sql&server=1&db=ledsignart&table=kapp_sys_menu_bom&pos=0', jong='U', job_group='', club_url='moado.net', job_level='0', ip='180.228.134.144', up_day='2024-05-08 15:51:31'
			}
		}

	}
	//Curl job link table error
	function Link_Table_curl_send( $sys_subtit, $sys_link, $jong, $kapp_server, $ip, $memo, $up_day ){
		global $H_ID, $H_EMAIL, $config;

		$tabData['data'][][] = array();
		$cnt = 0;
		$tabData['data'][$cnt]['link_title']  = $sys_subtit; // $job_name = 'mylist'
		$tabData['data'][$cnt]['link_url']    = $sys_link;
		$tabData['data'][$cnt]['link_type']   = $jong;
		$tabData['data'][$cnt]['kapp_server'] = $kapp_server;
		$tabData['data'][$cnt]['email']       = $H_EMAIL;
		$tabData['data'][$cnt]['user_ip']     = $ip;
		$tabData['data'][$cnt]['memo']        = $memo;
		$tabData['data'][$cnt]['up_day']      = $up_day;
		
		//$count = count($tabData['data']);	//m_( "--- count:" . $count ); // 10

		$key = 'appgenerator';
		$iv = "~`!@#$%^&*()-_=+";

		$sendData = encryptA( $tabData , $key, $iv);

		$url_ = $config['kapp_theme'] . '/_Curl/Link_Table_curl_get_ailinkapp.php';
		
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $url_);
		curl_setopt( $curl, CURLOPT_POST, true);

		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'tabData' => json_encode( $sendData , JSON_UNESCAPED_UNICODE),
			'iv' => $iv
		));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		
		echo curl_error($curl);

		//echo "Link_Table_curl_send --- response: " . $response;

		if( $response == false) {
			$_ms = "new Link_Table_curl_get_ailinkapp fail : " . curl_error($curl);
			echo 'curl : ' . $_ms;	//m_(" ------------ : " . $_ms);
		} else {
			$_ms = 'new Link_Table_curl_get_ailinkapp curl OK : ' . $response;
			//echo 'curl : ' . $_ms;	//m_(" ============ :" . $_ms);
		}
		curl_close($curl);

		//m_("curl end--------------- ms: email: " . $H_EMAIL); //exit();
		return $response;
	}
	// tkher_star_necessary 에서사용. Kakao Login 시 member table 등록 여부 확인 -----------------
	function get_memberT( $email, $table, $fields='*')
	{
		global $tkher;
		return sql_fetch(" select $fields from {$table} where mb_email = TRIM('$email') ");
	}
	// tkher_star_necessary 에서사용.-----------------
	function get_urllink_memberA($mb_id, $fields='*')
	{
		global $tkher;
		return sql_fetch(" select $fields from {$tkher['tkher_member_table']} where mb_id = TRIM('$mb_id') ");
	}
	function get_urllink_memberE($mb_id, $fields='*')
	{ // email login 2025-05-18 add 
		global $tkher;
		return sql_fetch(" select $fields from {$tkher['tkher_member_table']} where mb_email = TRIM('$mb_id') ");
	}
	//--------------------------------------------- 21-04-4 add.
	function urllink_member_set( $gid, $gemail, $gname, $gsajin, $sn, $table){
		// 2021-06-24 add $sn
        global $tkher;
		global $member;
		$ip = $_SERVER['REMOTE_ADDR'];

			date_default_timezone_set("Asia/Seoul");
			$day = date("Y-m-d H:i:s");

		//$sql = "SELECT * from urllink_member where mb_email='$gemail' ";
		$sql = "SELECT * from {$table} where mb_email='$gemail' ";
		$result = sql_query( $sql );
		if( $rs = sql_fetch_array($result) ) {
			$member['mb_level'] = $rs['mb_level'];
			return $rs['mb_level'];
		} else{
			// insert into {$tkher['uniqid_table']} set
			// insert into {$tkher['tkher_member_table']} set
			$sql_in = "insert into {$table} set mb_id='$gid', mb_email='$gemail', mb_name='$gname', mb_nick='$gid', mb_photo='$gsajin', mb_ip='$ip', mb_sn='$sn', mb_level='2', mb_point='3000', mb_datetime='$day'";
			$ret = sql_query( $sql_in );
			$member['mb_level'] = '2';
			return $member['mb_level'];
		}
	}
	// tkher_start_necessary use ---------- gname = nickname, sn : Kakao_login 2024-01-25 보완.
	function urllink_member_setA( $email, $gname, $gsajin, $sn, $table, $signup_point=3000){
		// 2021-06-24 add $sn:Goole or Kakao,
		// id는 email에서 분리한 id를 사용한다. 중복가능성이 있지만 프로그램생성을 위해 일단 사용한다. : 2021-07-03
        global $tkher;
		global $member;
		$ip = $_SERVER['REMOTE_ADDR'];

		date_default_timezone_set("Asia/Seoul");
		$day = date("Y-m-d H:i:s");

		//$emailA = explode('@', $email);
		$email_id = $email; // email을 id로 사용한다.

		$sql_in = "insert into {$table} set mb_id='$email_id', mb_email='$email', mb_name='$gname', mb_nick='$gname', mb_photo='$gsajin', mb_ip='$ip', mb_sn='$sn', mb_level='2', mb_point=".$signup_point.", mb_datetime='$day'";
		$ret = sql_query( $sql_in );
		if( $ret) {
			//m_("my_func --- member OK!"); echo "urllink_member_setA sql: " . $sql_in; exit;
		} else {
			m_("my_func - urllink_member_setA --- error!");
			echo "urllink_member_setA sql: " . $sql_in; exit;
		}
		//------------------------------------- 2021-11-23: album_insert.php작업중 보완. , tkher_register_form_update.php 멤버등록시 사용한다.
		//$jtree_dir = "../cratree/".$mb_id;
		//$jtree_dir = $tkher_p . "/cratree/".$email_id;
		//$jtree_dir = KAPP_PATH_ . "/cratree/".$email_id;
		$jtree_dir = KAPP_PATH_T_ . "/file/".$email_id;
		//m_(" my_func --- jtree_dir:") . $jtree_dir;
		// my_func --- jtree_dir:/home1/solpakanurl/public_html/cratree/solpakan89
		if ( !is_dir($jtree_dir) ) {
			if ( !@mkdir( $jtree_dir, 0777 ) ) {
				echo " Error: $jtree_dir : " . $email_id . " Failed to create directory., 디렉토리를 생성하지 못했습니다. ";
				m_("ERROR email id:" . $email_id . ", dir create OK : " . $jtree_dir);
				//exit;
			} else {
				//echo " $jtree_dir : " . $email_id . " Created directory., 디렉토리를 생성 OK";
				///var/www/html/t/file/kim19260716@gmail.com : kim19260716@gmail.com Created directory., 디렉토리를 생성 OK
				m_("email id:" . $email_id . ", dir create OK : " . $jtree_dir);
				//email id:kim19260716, dir create OK : /home1/solpakanurl/public_html/t/file/kim19260716
			}
		}

	}
	//--------------------------------------------- 21-04-4 add.
	function urllink_member_read( $gemail ){ // 사용하는데가 없다.
        global $tkher;
		global $member;
		$sql = "SELECT * from {$tkher['tkher_member_table']} where mb_email='$gemail' ";
		$result = sql_query( $sql );
		$rs = sql_fetch_array( $result );
		$member['mb_level'] = $rs['mb_level'];
		$level = $rs['mb_level'];
		return $level;
	}
	//--------------------------------------------- 21-04-4 add.
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
			//insert into {$tkher['uniqid_table']} set
			$sql_in = "insert into {$tkher['tkher_member_table']} set mb_id='$gid', mb_email='$gemail', mb_name='$gname', mb_nick='$gid', mb_photo='$gsajin', mb_level='2', mb_point='3000', mb_datetime='$day'";
			$ret = sql_query( $sql_in );
			$member['mb_level'] = '2';
			$level = $rs['mb_level'];
			return $level;
		}
	}
	//--------------------------------------------- 2022-05-09 보완 /t/include/lib 이동으로 my_func.php
	function create_aboard_table_make_menu( $board_title, $mroot, $board_type, $max_num ){

		global $H_ID, $up_day, $sys_pg_root, $code_name, $board_num;

		$ip = $_SERVER['REMOTE_ADDR'];
		$in_date=time();

		$result = sql_query("select max(no) as no from aboard_infor ");
		$rs = sql_fetch_array( $result );
		$board_ = $rs['no'];
		if( !$board_ ) $board_num = 1;
		else $board_num = $board_ +1;

		//$table_name = $bbsname . $H_ID . $board_num;
		$table_name = $max_num; // $max_num = $H_ID . (time() + $j);	//$max_num - 중요 : 게시판 테이블명으로 사용됨.	//$board_num  = $max_num;
		$code_name	= $table_name;	// job_link_table - aboard_no.
		$xsys_pg 	= $table_name;	//$_POST[xsys_pg];	// tree_code

		$sys_subtit = $board_title;	//$_POST[sys_subtit];
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
		//printf("sql:%s", $query);
		$mq1 = sql_query( $query );
		if( !$mq1 ) {
			echo("<script>alert('Bulletin board table creation failed.  $board_num, $table_name ');</script>");
			//echo("<script>history.back();</script>");
			//게시판 테이블 생성에 실패 했습니다. 112, tkher112
			exit;
		}
		$link_name = "";
		if( $mq1 ){

			$link_name		= KAPP_URL_T_ . '/bbs/index5.php?infor='.$board_num;
			$movie			= $board_type;// '5':Daum type, "2";// 1:general,2:standard,3:memo,4:image gallery
			$home_url 		= "GCOM05!";	// GCOM05 : Daum Type, GCOM02!:standard
			$fileup 		= 1;
			$grant_view	    = 0;	//0:all, 1:member, 2:운영자 3:system manager
			$grant_write	= 1;	//0:all, 1:member, 2:운영자 3:system manager
			$xlev			= "2";	// no use.
			$memo			= "";
			$job_link_type = 'A';	// /t/bbs/index5.php 에서 구분하여 처리한다.
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
			/*
			$icon_home			= KAPP_URL_T_ . "/icon/home.gif";
			$icon_prev			= KAPP_URL_T_ . "/icon/e_prev.gif";
			$icon_next			= KAPP_URL_T_ . "/icon/e_next.gif";
			$icon_insert		= KAPP_URL_T_ . "/icon/e_insert.gif";
			$icon_update		= KAPP_URL_T_ . "/icon/e_update.gif";
			$icon_delete		= KAPP_URL_T_ . "/icon/e_delete.gif";
			$icon_reply			= KAPP_URL_T_ . "/icon/e_reply.gif";
			$icon_list			= KAPP_URL_T_ . "/icon/e_list.gif";
			$icon_search_list	= KAPP_URL_T_ . "/icon/search_list.gif";
			$icon_search		= KAPP_URL_T_ . "/icon/search.gif";
			$icon_submit		= KAPP_URL_T_ . "/icon/e_submit.gif";
			$icon_new			= KAPP_URL_T_ . "/icon/new.gif";
			$icon_list_reply	= KAPP_URL_T_ . "/icon/list_reply.gif";
			$icon_memo			= KAPP_URL_T_ . "/icon/memo.gif";
			$icon_admin			= KAPP_URL_T_ . "/icon/e_admin.gif"; */
			$icon_home			= "home.gif";     //KAPP_URL_ . "/contents/icon/home.gif";
			$icon_prev			= "e_prev.gif";   //KAPP_URL_ . "/contents/icon/e_prev.gif";
			$icon_next			= "e_next.gif";   //KAPP_URL_ . "/contents/icon/e_next.gif";
			$icon_insert		= "e_insert.gif"; //KAPP_URL_ . "/contents/icon/e_insert.gif";
			$icon_update		= "e_update.gif"; //KAPP_URL_ . "/contents/icon/e_update.gif";
			$icon_delete		= "e_delete.gif"; //KAPP_URL_ . "/contents/icon/e_delete.gif";
			$icon_reply			= "e_reply.gif";  //KAPP_URL_ . "/contents/icon/e_reply.gif";
			$icon_list			= "e_list.gif";       //KAPP_URL_ . "/contents/icon/e_list.gif";
			$icon_search_list	= "search_list.gif"; //KAPP_URL_ . "/contents/icon/search_list.gif";
			$icon_search		= "search.gif";      //KAPP_URL_ . "/contents/icon/search.gif";
			$icon_submit		= "e_submit.gif";     //KAPP_URL_ . "/contents/icon/e_submit.gif";
			$icon_new			= "new.gif";          //KAPP_URL_ . "/contents/icon/new.gif";
			$icon_list_reply	= "list_reply.gif";   //KAPP_URL_ . "/contents/icon/list_reply.gif";
			$icon_memo			= "memo.gif";         //KAPP_URL_ . "/contents/icon/memo.gif";
			$icon_admin			= "e_admin.gif";      //KAPP_URL_ . "/contents/icon/e_admin.gif";

			$list_gubun			= 1;			// detail page - reply print
			$connection_gubun	= 1;						// reply display necessary:1
			$top_html			= "";
			$bottom_html		= "";
			$title_color		= "#FFFFFF";		// #81C131
			$title_text_color	= "#000000";		// #FFFFFF  new change kang.ho.
			$security			= "0";	// 비밀글 사용:1, 비밀글 사용안함:0
			$session_club_url = KAPP_URL_;
			$sys_pg_root		= $mroot;	//_POST[sys_pg_root];	// 게시판 공개레벨을 최상위 의 공개를 따름.
//no, name, table_name, fileup, in_date, memo_gubun, ip_gubun, html_gubun, imember, home_url, table_width, list_table_set, list_title_bgcolor, list_title_font, list_text_bgcolor, list_text_font, list_size, detail_table_set, detail_title_bgcolor, detail_title_font, detail_text_bgcolor, detail_text_font, detail_memo_bgcolor, detail_memo_font, input_table_set, input_title_bgcolor, input_title_font, icon_home, icon_prev, icon_next, icon_insert, icon_update, icon_delete, icon_reply, icon_list, icon_search_list, icon_search, icon_submit, icon_new, icon_list_reply, icon_memo, icon_admin, list_gubun, connection_gubun, top_html, bottom_html, grant_view, grant_write, movie, title_color, title_text_color, security, lev, make_id, make_club, sunbun, memo

//			$query = "insert into aboard_infor values('',

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
			if( $mq2 ){ // 게시판 첨부화일 저장 디렉토리 생성. : 2022-02-04 add
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
	}// function create_aboard_table end.
	//--------------------------------------------- 19-02-23 add.
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
		$code_name	= $table_name;	// job_link_table - aboard_no.
		$xsys_pg 	= $table_name;	//$_POST[xsys_pg];	// tree_code
		$sys_subtit = $board_title;	//$_POST[sys_subtit];
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
			$movie			= $board_type;	//"2";			// 1:general, 2:standard, 3:memo, 4:image gallery
			$home_url 		= "GCOM05!";	// GCOM02!:standard
			$fileup 			= "1";
			$grant_view	= "0";	//0:all, 1:member, 2:운영자 3:system manager
			$grant_write	= "1";	//0:all, 1:member, 2:운영자 3:system manager
			$xlev				= "2";	// no use.
			$memo			= "";
			$job_link_type = 'A';	// index.php 에서 구분하여 처리한다.
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
			$list_gubun			= "1";			// detail page - reply print
			$connection_gubun	= "1";						// reply display necessary:1
			$top_html			= "";
			$bottom_html		= "";
			$title_color			= "#FFFFFF";		// #81C131
			$title_text_color	= "#000000";		// #FFFFFF  new change kang.ho.
			$security			= "0";	// 비밀글 사용:1, 비밀글 사용안함:0
			$session_club_url = KAPP_URL_;
			$sys_pg_root		= $mroot;	//_POST[sys_pg_root];	// 게시판 공개레벨을 최상위 의 공개를 따름.
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

			/////////////    job_link_table    ///////////////////////////////////////////////////
			$sql = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$session_club_url', user_name='$board_title', job_name='$board_title', job_addr='$link_name', job_level='2', job_group='aboard', job_group_code='$sys_pg_root', num='$table_name', up_day='$up_day', aboard_no='$board_num', jong='A'";
			sql_query( $sql );
			return $link_name;
		} else return;
	}// function create_aboard_table end.
	//------------------------------------------------
	/*
	function bbs_create_func(){	// old BBS tree create.
		// 정리중. 미완성 - 중요.
		global $up_day, $code_name, $tkgroup;
			$s_result = sql_query( "select name from admin_tkher_bbs where name='$code_name' and tkgroup='$tkgroup' " );
			$g = sql_num_rows( $s_result );
			if( $g > 0 ) {
				$check = 'Y';
				my_msg("It already exists. \\n ERROR group:$tkgroup, code:$code_name  이미 존재합니다.");
				echo "<script>window.open( 'bbs_linktree_make_add.php' , 'url_link_bbstree_solpa_user_r',''); </script>";
				exit;
			} else {
				my_msg("Create a board. \\n 게시판 $tkgroup, $code_name 을 생성합니다.");
				$check = '1';
			}
			if ( $check ) {
				sql_query( "insert into admin_tkher_bbs set tkgroup='$tkgroup', name='$code_name', make_userid='$H_ID', bbs_level='$lev', top3='$comment', comment='$comment', uptime='$up_day', club_url='$xsys_pg', memo='$sys_memoX' " );
				$sql = "CREATE TABLE $code_name (`no` int(11) NOT NULL primary key auto_increment,
					  `num`       int(11) NOT NULL default '0',
					  `idx`         int(11) NOT NULL default '0',
					  `title`        varchar(50) default NULL,
					  `comment_cnt` int(4) default NULL,
					  `usr_id`      varchar(20) default NULL,
					  `usr_name` varchar(20) default NULL,
					  `usr_pwd`   varchar(255) default NULL,
					  `usr_email`  varchar(80) default NULL,
					  `hit`           int(5) default NULL,
					  `uptime`     int(11) default NULL,
					  `contents`  text,
					  `gubun` varchar(5) default NULL,
					  `url` varchar(250) default NULL,
					  `image` varchar(250) default NULL,
					  `upfile` varchar(250) default NULL)";

					$comment_table = $code_name."_comment";
					$sql_comment = "create table $comment_table (`no` int(11) not null primary key auto_increment,
					`co_idx` int(11) not null default '0',
					`id`       varchar(20) default NULL,
					`name`  varchar(20) default NULL,
					`source` int(11) default NULL,
					`uptime` int(11) default NULL,
					`comment` text)";

					####### 파일 업로드를 가능하게 할려면 bbs_image 와 bbs_pds 의 퍼미션을 777로 해야 됨
					exec("mkdir ../../../tkher_bbs/bbs_image/$code_name");
					exec("chmod 755 -R ../../../tkher_bbs/bbs_image/$code_name");
					exec("mkdir ../../../tkher_bbs/bbs_pds/$code_name");
					exec("chmod 755 -R ../../../tkher_bbs/bbs_pds/$code_name");

				$result = sql_query( $sql );
				if ($result) {
					$co_result = sql_query( $sql_comment );
					if($co_result) {
					}
				} else {
					echo "<script>alert('Failed to create comment board \\n 코멘트 게시판 생성 실패'); window.open( 'bbs_linktree_make_add.php' , 'url_link_bbstree_solpa_user_r','');</script>"; exit;
				}

		}
	}// BBS tree end.
	*/

	//  sql add ---------------------------------------------------------------
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
		$ret = sql_query( $sql );	//	$cnt = sql_num_rows( $ret );
		$cnt = $ret->num_rows;		//m_("row: " . $ret->num_rows);
		if( $ret->num_rows > 0 ) {	//m_(" select OK cnt:" . $cnt);
			$res = sql_fetch_array( $ret);			//m_("vs_count: " . $res['vs_count']);
			$login_count_today = $res['vs_count'] +1;
			$sql = " update {$tkher['visit_sum_table']} set vs_count=vs_count+1 where vs_date = '".date("Y-m-d",time())."' ";
			$ret = sql_query( $sql );	//echo "sql: " . $sql; exit;
			if( $ret ) {
				//m_("ok update ");
			} else {
				m_(" kapp_visit_sum error update ");
			}
		} else {	//m_(" select error cnt: " . $cnt);
			$login_count_today = 1;
			$sql = " insert into {$tkher['visit_sum_table']} set vs_count=1, vs_date = '".date("Y-m-d",time())."' ";
			$ret = sql_query( $sql );
			if( !$ret ) {
				m_(" insert error ");
				echo "sql: " . $sql; exit;
			} else {
				//m_(" insert ok "); //echo "sql: " . $sql;
			}
		}
}
//------------ add : 2018-12-20 : ip를 숫자로 출력한다. -------------------------
function connect_count($call_pg ,$id, $ipcheck, $_REFERER){
	global $tkher, $member;
		$ip = escape_trim($_SERVER['REMOTE_ADDR']); //$ip  = $_SERVER['REMOTE_ADDR'];

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
		/*
		$ip_num = htol($ip);	//2342680517
		$ret = sql_query("SELECT * from ip_info where ipno1 <= $ip_num and ipno2 >= $ip_num " );
		$tot = sql_num_rows( $ret );
		$rs  = sql_fetch_array( $ret );
		$ipcode = $rs['country_cd'];
		$ipname = $rs['country_name'];
		*/

		$ipcode = "";
		$ipname = "";

		date_default_timezone_set("Asia/Seoul");
		$day = date("Y-m-d H:i:s");
		//if( $id ) $user = $id;
		//else $user = 'guest';

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

# str_pad -- Pad a string to a certain length with another string
# (http://www.php.net/manual/en/function.str-pad.php)
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

//-----------------------------------------------------------------------
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
$link_secret_iv = "#@$%^&*()_+=-";	// enc, dec key : 중요.
//----------------------------------------------------------------------------
//$send_mail = "2672415@naver.com, solpakan@naver.com"; //OK
$send_mail = "solpakan@naver.com"; //OK
$user_admin_pass = 'ad2457807';
//$send_mail = "2672415@naver.com";
$id		= "editor";	// 관리자 로그인 아이디
$pw	= "Edi!))$35";	// 관리자 로그인 암호

// 3.31
// HTML SYMBOL 변환
// &nbsp; &amp; &middot; 등을 정상으로 출력
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
		// 3.31
		// TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
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
// &nbsp; &amp; &middot; 등을 정상으로 출력
function html_symbol($str)
{
    return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
}

// 정상..............
function gmail( $s_enm, $s_e, $mb_name, $mb_email, $subject, $content, $no){
	/*
	주의할점은 받는사람이나 참조를 추가할 때 ,로 구분하여 한번만 함수를 부르는 것이 아니라
	$mail->addAddress(),$mail->addCC();를 여러번 호출하여 사용하면 된다.
	원래는 php의 mail() 함수를 사용하였으나
	google에서 인증되지 않은 메일서버라 하여
	몇일 전부터 보내지지 않아
	google 메일 계정을 매개로 보내는 방법을 찾은 것이다.
	*/
	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	try {
		//Server settings
		$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		$mail->isSMTP();											 // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';						// Specify main and backup SMTP servers GMAIL
		$mail->SMTPAuth = true;                              // Enable SMTP authentication
		$mail->Username = 'crakan89@gmail.com';		// SMTP username
		$mail->Password = 'Gma!))$35';                      // SMTP password 2018-12-15 : 비밀번호 변경.
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;										// TCP port to connect to
		$mail->CharSet = 'utf-8';
		$mail->setFrom('crakan89@gmail.com', 'TkHer');	//보내는 e-mail 고정하도록한다. 2018-06-16
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

# number_format()
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
	//exit;
//}

	######## 랜덤으로 1~45 사이의 숫자 추출하여 반환 ###################
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

	######## 이미지 자동 리사이즈 ######################################
	function my_img_resize($img_width, $img_height, $my_width, $my_height) {
		# ( x/100 * $img_width = $my_width) 축소 비율은 이렇게 구하면 되는지 모르겠다..

		# width 값이 크거나 같을 경우
		if ($img_width >= $img_height) {
			# width 값이 기준 사이즈보다 클 경우
			if ($img_width > $my_width) {
				$rate = $my_width / ($img_width / 100); # ( x/100 * $img_width = $my_width)을 변형 시킨거..
				$fixed_width = $my_width;
				$fixed_height = ($rate / 100) * $img_height;
			}
			else {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
			# 수정한 height 값이 기준 사이즈보다 클 경우
			if ($fixed_height > $my_height) {
				$rate = $my_height / ($fixed_height / 100);
				$fixed_height = $my_height;
				$fixed_width = ($rate / 100) * $fixed_width;
			}
			# width, height 값이 모두 기준 사이즈보다 같거나 작을 경우
			if ($img_width <= $my_width && $img_height <= $my_height) {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
		}

		# height 값이 클 경우
		if ($img_width < $img_height) {
			# height 값이 기준 사이즈보다 클 경우
			if ($img_height > $my_height) {
				$rate = $my_height / ($img_height / 100);
				$fixed_height = $my_height;
				$fixed_width = ($rate / 100) * $img_width;
			}
			else {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
			# 수정한 width 값이 기준 사이즈보다 클 경우
			if ($fixed_width > $my_width) {
				$rate = $my_width / ($fixed_width / 100);
				$fixed_width = $my_width;
				$fixed_height = ($rate / 100) * $fixed_height;
			}
			# width, height 값이 모두 기준 사이즈보다 같거나 작을 경우
			if ($img_width <= $my_width && $img_height <= $my_height) {
				$fixed_width = $img_width;
				$fixed_height = $img_height;
			}
		}

		$temp[0] = $fixed_width;
		$temp[1] = $fixed_height;

		return $temp;
	}

	# 입력된 시간이 오늘인지
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

	// 문자열 자르기
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
	// 리퍼러 체크
	function referer_check_url($url='')
	{
		//alert('referer_check --------');
		/**/
		// 제대로 체크를 하지 못하여 주석 처리함
		global $tkher;

		if (!$url)
			$url = KAPP_URL;

		if (!preg_match("/^http['s']?:\/\/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
			m_("Please follow the normal procedure. ". $url);  //제대로 된 접근이 아닌것 같습니다.
			echo "<script>window.open( '$url/tkher_register_.php' , '_self', ''); </script>";
			exit;
		}
		/*  alert : 제대로 된 접근이 아닌것 같습니다. url:http://urllinkcoin.com/t */
	}
	function check_passwordA($pass, $hash)
	{
		$password = get_encrypt_stringA($pass);

		return ($password === $hash);
	}
	/* function check_passwordAA($pass, $hash)
	{
		if($pass === $hash) return true;
		else return false;
	} */
	function get_encrypt_stringA($str){
		if(defined('KAPP_STRING_ENCRYPT_FUNCTION') && KAPP_STRING_ENCRYPT_FUNCTION) {
			$encrypt = call_user_func(KAPP_STRING_ENCRYPT_FUNCTION, $str);
		} else {
			$encrypt = sql_passwordA($str);
		}

		return $encrypt;
	}
	function sql_passwordA($value){
		// mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
		// mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
		$row = sql_fetch(" select password('$value') as pass ");

		return $row['pass'];
	}
	function insert_point_app($mb_id, $point, $content='', $rel_table='', $rel_id='', $rel_action='', $expire=0){
		global $config;
		global $tkher;
		global $is_admin;
		global $member;

		if( !$config['kapp_use_point']) { return 0; } // 포인트 사용을 하지 않는다면 return
		if( $point == 0) { return 0; } // 포인트가 없다면 업데이트 할 필요 없음
		if( $mb_id == '') { return 0; }// 회원아이디가 없다면 업데이트 할 필요 없음

		$mb = sql_fetch(" select mb_id, mb_point from {$tkher['tkher_member_table']} where mb_id = '$mb_id' ");
		if( !$mb['mb_id']) { return 0; }
		$mb_point = $mb['mb_point'];
		$po_mb_point = $mb_point + $point;

		// 포인트 UPDATE
		$sql = " update {$tkher['tkher_member_table']} set mb_point = mb_point + $point where mb_id = '$mb_id' ";
		sql_query($sql);

		// 포인트 건별 생성
		$po_expire_date = '9999-12-31';
		$po_expired = $expire; // 0
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
		//else { m_("OK - my_func"); echo "sql: " . $sql; exit;} // error - my_func
		//sql: insert into tkher_point set mb_id = 'dao', po_datetime = '2024-01-24 17:11:28', po_content = 'contents_view_menuD.php?num=dao1703728026', po_point = 100, po_use_point = 0, po_mb_point = 5341586, po_expired = 0, po_expire_date= '9999-12-31', po_rel_table = 'viewer@cratree_coinadd_menu', po_rel_id = 'dao', po_rel_action = 'GPT3'
		//sql: insert into tkher_point set mb_id = 'dao', po_datetime = '2024-01-24 17:01:37', po_content = 'contents_view_menuD.php?num=dao1703728027', po_point = 100, po_use_point = 0, po_mb_point = 5341486, po_expired = 0, po_expire_date= '9999-12-31', po_rel_table = 'viewer@cratree_coinadd_menu', po_rel_id = '', po_rel_action = ''
		return 1;
	}
	///////////////////////////////////////////////////////////////

// DB 연결
// 마이크로 타임을 얻어 계산 형식으로 만듦
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
        // 연결 오류 발생 시 스크립트 종료
        if( mysqli_connect_errno()) {
            die('Connect Error: '.mysqli_connect_error());
        }
    } else {
        $link = mysql_connect($host, $user, $pass);
    }
    return $link;
}
// Warning: mysqli_num_rows() expects parameter 1 to be mysqli_result, bool given in 

// DB 선택
// 결과값에서 한행 연관배열(이름으로)로 얻는다.
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
// 세션변수 생성 
function set_session($session_name, $value)
{
    if (PHP_VERSION < '5.3.0')
        session_register($session_name);
    // PHP 버전별 차이를 없애기 위한 방법
    $$session_name = $_SESSION[$session_name] = $value;
    //$session_name = $_SESSION[$session_name] = $value;
}
// 세션변수값 얻음
function get_session($session_name)
{
    return isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : '';
}


// 쿠키변수 생성
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
// 토큰 생성
function _token()
{
    return md5(uniqid(rand(), true));
}


// 불법접근을 막도록 토큰을 생성하면서 토큰값을 리턴
function get_token()
{
    $token = md5(uniqid(rand(), true));
    set_session('ss_token', $token);

    return $token;
}


// POST로 넘어온 토큰과 세션에 저장된 토큰 비교
function check_token()
{
    set_session('ss_token', '');
    return true;
}


// 문자열에 utf8 문자가 들어 있는지 검사하는 함수
// 코드 : http://in2.php.net/manual/en/function.mb-check-encoding.php#95289
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


// UTF-8 문자열 자르기
// 출처 : https://www.google.co.kr/search?q=utf8_strcut&aq=f&oq=utf8_strcut&aqs=chrome.0.57j0l3.826j0&sourceid=chrome&ie=UTF-8
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

/*
-----------------------------------------------------------
    Charset 을 변환하는 함수
-----------------------------------------------------------
iconv 함수가 있으면 iconv 로 변환하고
없으면 mb_convert_encoding 함수를 사용한다.
둘다 없으면 사용할 수 없다.
*/
function convert_charset($from_charset, $to_charset, $str){
    if( function_exists('iconv') )
        return iconv($from_charset, $to_charset, $str);
    elseif( function_exists('mb_convert_encoding') )
        return mb_convert_encoding($str, $to_charset, $from_charset);
    else
        die("Not found 'iconv' or 'mbstring' library in server.");
}
// mysqli_real_escape_string 의 alias 기능을 한다.
function sql_real_escape_string($str, $link=null){
    global $tkher;
    if(!$link)
        $link = $tkher['connect_db'];
    return mysqli_real_escape_string($link, $str);
}
function referer_check($url=''){
	//alert('referer_check --------');
    /**/
    // 제대로 체크를 하지 못하여 주석 처리함
    global $tkher;
    if (!$url)
        $url = KAPP_URL_T_;

    if (!preg_match("/^http['s']?:\/\/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER'])){
        alert("Please follow the normal procedure. ", $url);
		echo "<script>window.open( '$url/tkher_register_.php' , '_self', ''); </script>";
	}
    /*  alert : 제대로 된 접근이 아닌것 같습니다. url:http://urllinkcoin.com/t */
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
    //$row = @sql_fetch_arrayG($result) or die("<p>$sql<p>" . mysqli_errno() . " : " .  mysqli_error() . "<p>error file : $_SERVER['SCRIPT_NAME']");
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
    $sql = preg_replace("#^select.*from.*[\s\(]+union[\s\)]+.*#i ", "select 1", $sql); // union의 사용을 허락하지 않습니다.
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*where.*`?information_schema`?.*#i", "select 1", $sql);

    if( function_exists('mysqli_query') && KAPP_MYSQLI_USE) {
        if( $error) {
            $result = @mysqli_query($link, $sql) or die("<p>$sql<p>" . mysqli_errno($link) . " : " .  mysqli_error($link) . "<p>error file : {$_SERVER['SCRIPT_NAME']}");
        } else {
            $result = @mysqli_query($link, $sql);	//echo "sql: " . $sql; exit;
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

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
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

function is_admin($mb_id){ // admin ?
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
	if( !$config['kapp_use_point']) { return 0; } // $config['kapp_use_point'] == 1 이면 포인트 관리를 사용
    if( $point == 0) { return 0; }                // 포인트가 없다면 업데이트 할 필요 없음
    $mb = sql_fetch(" select mb_id from {$tkher['tkher_member_table']} where mb_id = '$mb_id' ");
    $mb_point = get_point_sum($mb_id); // 회원포인트
    if( $rel_table || $rel_id || $rel_action){ // 이미 등록된 내역이라면 건너뜀
        $sql = " select count(*) as cnt from {$tkher['point_table']}
                  where mb_id = '$mb_id'
                    and po_rel_table = '$rel_table'
                    and po_rel_id = '$rel_id'
                    and po_rel_action = '$rel_action' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
            return -1;
    }
    // 포인트 건별 생성
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
    if( $point < 0) { // 포인트를 사용한 경우 포인트 내역에 사용금액 기록
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
function html_end(){ // HTML 마지막 처리 
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

        // 현재접속자 처리
        $tmp_sql = " select count(*) as cnt from {$tkher['login_table']} where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
        $tmp_row = sql_fetch($tmp_sql);

        if ($tmp_row['cnt']) {
            //$tmp_sql = " update {$tkher['login_table']} set mb_id = '{$member['mb_id']}', lo_datetime = '".KAPP_TIME_YMDHIS."', lo_location = '{$tkher['lo_location']}', lo_url = '{$tkher['lo_url']}' where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
            $tmp_sql = " update {$tkher['login_table']} set mb_id = '{$member['mb_id']}', lo_datetime = '".KAPP_TIME_YMDHIS."', lo_location = '{$kapp_host}', lo_url = '{$_SERVER['SCRIPT_NAME']}' where lo_ip = '{$_SERVER['REMOTE_ADDR']}' ";
            sql_query($tmp_sql, FALSE);
        } else {
            //$tmp_sql = " insert into {$tkher['login_table']} ( lo_ip, mb_id, lo_datetime, lo_location, lo_url ) values ( '{$_SERVER['REMOTE_ADDR']}', '{$member['mb_id']}', '".KAPP_TIME_YMDHIS."', '{$tkher['lo_location']}',  '{$tkher['lo_url']}' ) ";
            $tmp_sql = " insert into {$tkher['login_table']} ( lo_ip, mb_id, lo_datetime, lo_location, lo_url ) values ( '{$_SERVER['REMOTE_ADDR']}', '{$member['mb_id']}', '".KAPP_TIME_YMDHIS."', '{$kapp_host}',  '{$_SERVER['SCRIPT_NAME']}' ) ";
            sql_query($tmp_sql, FALSE);

            // 시간이 지난 접속은 삭제한다
            sql_query(" delete from {$tkher['login_table']} where lo_datetime < '".date("Y-m-d H:i:s", KAPP_SERVER_TIME - (60 * $config['kapp_login_minutes']))."' ");

            // 부담(overhead)이 있다면 테이블 최적화
            //$row = sql_fetch(" SHOW TABLE STATUS FROM `$mysql_db` LIKE '$tkher['login_table']' ");
            //if ($row['Data_free'] > 0) sql_query(" OPTIMIZE TABLE $tkher['login_table'] ");
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
	//복호화 ---
	function decryptA($_encryptedData, $_salt , $_iv) {
		$key = openssl_digest($_salt, 'sha256', true);
		$decryptedData = openssl_decrypt(base64_decode($_encryptedData), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $_iv);
		$encrypted_jsonData = json_decode($decryptedData);
		return $encrypted_jsonData;
	}

function is_mobile(){
    return preg_match('/'.KAPP_MOBILE_AGENT.'/i', $_SERVER['HTTP_USER_AGENT']);
}
// key make
function get_uniqid(){
    global $tkher;
    sql_query(" LOCK TABLE {$tkher['uniqid_table']} WRITE ");
    while (1){ // 년월일시분초에 100분의 1초 두자리를 추가함 (1/100 초 앞에 자리가 모자르면 0으로 채움)
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
        alert('PC 전용 게시판입니다.', KAPP_URL_T_);
    } else if ($device=='mobile' && !KAPP_IS_MOBILE) {
        alert('모바일 전용 게시판입니다.', KAPP_URL_T_);
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

function pagingA($link, $total, $page, $size){ // paging() pagingA()로 적용함.
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);
	/*
	$temp		= $page%$size;
	if($temp=="0"){
		$a=$size-1;
		$b=$temp;
	}else{
		$a=$temp-1;
		$b=$size-$temp;
	}
	$start	= $page-$a;
	$end		= 10;//$page+$b;
	*/
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;

	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>[First]</a><span>.</span>");
	} else {
		echo("<span>[Start].</span>");
		//echo("<img src=./include/img/btn/b_first_silver.gif border=0 height=30 title='First'>");
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		//echo("<a href='javascript:page_move($back_page)' ><img src=./include/img/btn/btn_prev.png width=30 title='previous'></a>");
		echo("<a href='javascript:page_move($back_page)' >[Prev]</a><span>.</span>");
	} else {
		//echo("<img src=./include/img/btn/btn_prev.png width=30 title='Previous'>");
		//echo("<span>[Prev].</span>");
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("<a href='javascript:void(0)' class=on>$i</a><span>.</span>"); }
		else         { echo("<a href='javascript:page_move($i)'>$i</a><span>.</span>"); }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'>[Next]</a><span>.</span>");
		//echo("<a href='javascript:page_move($next_page)'><img src=./include/img/btn/btn_next.png width=30 title='B Next Page'></a>");
	}else { 
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo("<span>[Next].</span>");
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
		//echo("<img src=./include/img/btn/b_last_silver.gif border=0 height=30 title='Last'>");
	}
	echo "</div>";
}

function getJsonText($jsontext) { // jsonText '\' 값 제거 
	return str_replace("\\\"", "\"", $jsontext);
}

?>
