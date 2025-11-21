<?php 
  include_once('../tkher_start_necessary.php');
	  /*
		ulink_ajax.php : ulink_list.php 에서 콜 사용.
		$mode_insert == 'Encryption_data'
		$mode_insert == 'Decryption_data'
		$mode_insert == 'Group_insert'
		$mode_insert == 'Group_update'
		$mode_insert == 'insert_mode'  
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
	$memo =""; 
	$memoA =""; 
	if( $mode_insert == 'insert_mode'){
		$pw=$_POST['form_psw']; 
		$job_ = 'Link Note';
		$create_type = 'Note'; // fix 

		$title_nm		= $_POST['title_nm'];
		$sys_subtit		= $_POST['title_nm'];
		$job_url	= KAPP_URL_T_ . "/menu/ulink_list.php";
		$sys_link	= KAPP_URL_T_ . "/menu/ulink_list.php";
		$url_nm	= $_POST['url_nm']; 
		$job_label = $_POST['gong_num'];
		$memo		= $_POST['memo'];
		$jong	= 'U';	                   //  tree가아닌 개별등록...
		$ip = $_SERVER['REMOTE_ADDR'];
		$up_day  = date("Y-m-d-H:i:s");
		$kapp_url = KAPP_URL_T_;
		$g_name=$_POST['g_name']; 
		$g_name_code=$_POST['g_name_code']; 

		$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$url_nm', user_name='$title_nm', job_name='$create_type', job_group='$g_name', job_group_code='$g_name_code', job_addr='$job_url', job_level='$job_label', jong='$jong', memo='$memo', ip='$ip', num='Note', aboard_no='$job_', email='$H_EMAIL', up_day='$up_day' ";
		$ret = sql_query(  $sqlA ); 

		$kapp_theme0 = '';
		$kapp_theme1 = '';
		$kapp_theme = $config['kapp_theme'];
		$kapp_theme = explode('^', $kapp_theme );
		$kapp_theme0 = $kapp_theme[0]; //$kapp_mainnet; //"https://fation.net/kapp";//$kapp_theme[0];
		$kapp_theme1 = $kapp_theme[1];
		if( $ret ) {
			if( $kapp_theme0 ) {
				$kapp_theme0 = $kapp_mainnet; //"https://fation.net/kapp";//$kapp_theme[0];
				if( Link_Table_curl_send( $kapp_theme0, $sys_subtit, $sys_link, $jong, $url_nm, $ip, $memo, $up_day ) ) {
					if( $kapp_theme1 ) Link_Table_curl_send( $kapp_theme1, $sys_subtit, $sys_link, $jong, $url_nm, $ip, $memo, $up_day );
				}
			}		//m_("job_link_table --- insert ok");
		}
	} else if( $mode_insert == 'Encryption_data'){
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
			echo $g_name . ", Already exists.";
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
	}
	function Record_save($tit, $url, $memo, $pw ) { // no use
		global $tkher;
		global $g_name, $g_name_code, $from_session_url, $H_ID, $H_EMAIL;
		$ip = $_SERVER['REMOTE_ADDR'];
		$up_day = date("Y-m-d H:i:s");
		$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$from_session_url', user_name='$tit', job_name='Note', job_group='$g_name', job_group_code='$g_name_code', job_addr='$url', job_level='0', jong='U', memo='$memo', ip='$ip', num='Note', aboard_no='Note', email='$H_EMAIL', up_day='$up_day' ";
		$ret = 	sql_query(  $sqlA ); 
		if(!$ret) {
			//echo json_encode("{$tkher['job_link_table']}   SQL:".$query);			//exit;
		} else {
			$jong ='U';
			$ret=Link_Table_curl_send( $tit, $url, $jong, $from_session_url, $ip, $memo, $up_day );
			if( $ret ) echo "curl save OK!";
			else  echo "Curl error --- save OK!";			//exit;
		}
	}
?>