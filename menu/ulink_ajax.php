<?php 
  include_once('../tkher_start_necessary.php');
  /*
	ulink_ajax.php : ulink_list.php 에서 콜 사용.
	$mode_insert === 'Encryption_data'
	$mode_insert === 'Decryption_data'
	$mode_insert === 'Group_insert'
	$mode_insert === 'Group_update'

  */
	 $H_ID	= get_session("ss_mb_id"); 
	if( $H_ID	!== ''){
		$H_EMAIL		= $member['mb_email'];
	} else {
		$H_ID="";
		echo "Login Please!"; 
		return false;
	}


	$mode_insert=$_POST['mode_insert'];  
	//echo "<br>mode_insert:" . $mode_insert;
	   //echo "g_name: " . $g_name . ", g_name_code:" . $g_name_code. ", mode_insert:" . $mode_insert;

		$memo =""; 
		$memoA =""; 

	if( $mode_insert == 'insert_mode'){

		$g_name=$_POST['g_name']; 
		$g_name_code=$_POST['g_name_code']; 

		$tit=$_POST['title_nm']; 
		$pw=$_POST['form_psw']; 
		
		//Record_save($tit, $url, $memo, $pw );
		$board_num = 'Note';
		$table_name = 'Note';
		$create_type = 'ulink_list note';

		$title_nm		= $_POST['title_nm'];
		$job_url	= KAPP_URL_T_ . "/menu/ulink_list.php";//$_REQUEST['url_nm'];  // url
		$url_nm	= $_POST['url_nm'];  // url
		$job_label = $_POST['gong_num'];
		$memo=$_POST['memo']; 
		$jong	= 'U';	                   //  tree가아닌 개별등록...
		$ip = $_SERVER['REMOTE_ADDR'];
		$up_day  = date("Y-m-d-H:i:s");
		$kapp_url = KAPP_URL_T_;
		//$result = sql_fetch("select * from {$tkher['job_link_table']} where user_id='$H_ID' and user_name='$title_nm' and job_addr='$job_url' ");
		//$tot = sql_num_rows($result);
		//if( isset($result['user_name']) && $result['user_name'] !== '' ) {
			$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$url_nm', user_name='$title_nm', job_name='$create_type', job_group='$g_name', job_group_code='$g_name_code', job_addr='$job_url', job_level='$job_label', jong='$jong', memo='$memo', ip='$ip', num='Note', aboard_no='$create_type', email='$H_EMAIL', up_day='$up_day' ";
			$ret = sql_query(  $sqlA ); 
			if( $ret ) {
				$kapp_theme0 = '';
				$kapp_theme1 = '';
				$kapp_theme = $config['kapp_theme'];
				$kapp_theme = explode('^', $kapp_theme );	//$n = sizeof($server_);
				$kapp_theme0 = "https://fation.net/kapp";//$kapp_theme[0];
				$kapp_theme1 = $kapp_theme[1];
				Link_Table_curl_send( $kapp_theme0, $title_nm, $job_url, $jong, $kapp_url, $ip, $memo, $up_day );
				//echo "<br>ulink_ajax ---OK send";
			}
		//}
		return;
		/*
		$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$from_session_url', user_name='$tit', job_name='Note', job_group='$g_name', job_group_code='$g_name_code', job_addr='$url', job_level='0', jong='U', memo='$memo', ip='$ip', num='Note', aboard_no='Note', email='$H_EMAIL', up_day='$up_day' ";
		$ret = 	sql_query(  $sqlA ); 
		if(!$ret) {
			echo json_encode("{$tkher['job_link_table']}   SQL:".$query);			//exit;
		} else {
			$jong ='U';
			Link_Table_curl_send( $tit, $url, $jong, $from_session_url, $ip, $memo, $up_day );
			echo "save OK!";
			return true;
		}*/

	} else if( $mode_insert === 'Encryption_data'){

		$memo =$_POST['memo']; 
		$pws    =$_POST['pws']; 
		$memoA= Encrypt($memo, $pws, $link_secret_iv);
		echo $memoA;

	} else if( $mode_insert === 'Decryption_data'){

		$memo =$_POST['memo']; 
		$pws    =$_POST['pws']; 
		$memoA = Decrypt($memo, $pws, $link_secret_iv);
		echo $memoA;

	} else if( $mode_insert === 'Group_insert'){

		$g_code =$_POST['g_code']; 
		$g_name=$_POST['g_name']; 
		$g_num = $H_ID . time();
		$ls = "select * from {$tkher['url_group_table']} where g_name='$g_name' and user_id='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if( $rs ) {
			echo $g_name . ", Already exists."; // 이미 존재합니다'
			return false;
		} else {
			$ls = "insert into {$tkher['url_group_table']} set g_name='$g_name', g_num='$g_num', user_id='$H_ID' ";
			$result = sql_query(  $ls );
			echo "group add OK!"; return;
		}

	} else if( $mode_insert === 'Group_update'){

		$g_code =$_POST['g_code']; 
		$g_name=$_POST['g_name']; 
		$sql = "update {$tkher['url_group_table']} set g_name='$g_name' where g_num='$g_code' and user_id='$H_ID' ";
		$rs = sql_query(  $sql );

		$sql = "update {$tkher['job_link_table']} set job_group='$g_name' where job_group_code='$g_code' and user_id='$H_ID' ";
		$rs = sql_query(  $sql );

		echo $g_name . ", Update OK!"; return;

	} else if( $mode_insert === 'view_click'){
		$seq_no =$_POST['seq_no']; 
		$sql= " update {$tkher['job_link_table']} set view_cnt=view_cnt+1 where seqno = $seq_no ";
		sql_query($sql);
		//echo " view cnt OK!"; return;
	}


	//echo  $mode_insert . " , memo:" . $memo . ", memoA:" . $memoA;
	//echo "tit: " . $tit . ", url:" . $url. ", memo:" . $memo. ", pw:" . $pw;

	function Record_save($tit, $url, $memo, $pw ) { // no use
		global $tkher;
		global $g_name, $g_name_code, $from_session_url, $H_ID, $H_EMAIL;
		$ip = $_SERVER['REMOTE_ADDR'];
		$up_day = date("Y-m-d H:i:s");
		$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$from_session_url', user_name='$tit', job_name='Note', job_group='$g_name', job_group_code='$g_name_code', job_addr='$url', job_level='0', jong='U', memo='$memo', ip='$ip', num='Note', aboard_no='Note', email='$H_EMAIL', up_day='$up_day' ";

		$ret = 	sql_query(  $sqlA ); 
		if(!$ret) {
			echo json_encode("{$tkher['job_link_table']}   SQL:".$query);
			//exit;
		} else {
			$jong ='U';
			$ret=Link_Table_curl_send( $tit, $url, $jong, $from_session_url, $ip, $memo, $up_day );
			if( $ret ) echo "save OK!";
			else  echo "Curl error --- save OK!";
			//exit;
		}
		
	}


?>