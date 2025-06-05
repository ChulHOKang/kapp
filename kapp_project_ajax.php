<?php 
  include_once('./tkher_start_necessary.php');
  /*
	ulink_ajax.php : ulink_list.php 에서 콜 사용.
	$mode_insert === 'Encryption_data'
	$mode_insert === 'Decryption_data'
	$mode_insert === 'Group_insert'
	$mode_insert === 'Group_update'

  */
	 $_ID	= get_session("ss_mb_id"); 
	if( isset( $_ID) ) $H_ID	= get_session("ss_mb_id");   //"ss_mb_id";	//connect_count('ulist', $H_ID, 0);	// log count
	else {
		$H_ID="";
		echo "Login Please!"; return false;
	}

	$H_EMAIL		= $member['mb_email'];

	$mode_insert =$_POST['mode_insert'];  //echo " mode_insert:" . $mode_insert . "<br>";
	   //echo "g_name: " . $g_name . ", g_name_code:" . $g_name_code. ", mode_insert:" . $mode_insert;

		$memo =""; 
		$memoA =""; 
	$day = date("Y-m-d H:i:s");

	if( $mode_insert === 'project_insert'){

		$g_code =$_POST['project_cd']; 
		$g_name =$_POST['project_nm']; 
		$g_memo =$_POST['memo']; 	//$pw = $_POST['form_psw']; 

		$ls = "select * from {$tkher['table10_group_table']} where group_name='$g_name' and userid='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if( $rs ) {
			echo $g_name . ", Already exists."; // 이미 존재합니다'
			return false;
		} else {
			$ls = "insert into {$tkher['table10_group_table']} set group_name='$g_name', group_code='$g_code', userid='$H_ID', upday='$day', memo='$g_memo' ";
			$result = sql_query(  $ls );
			echo "Project add OK!"; return;
		}
	} else if( $mode_insert === 'project_change'){

		$seq_no =$_POST['seq_no']; 
		$g_code =$_POST['project_cd']; 
		$g_name =$_POST['project_nm']; 
		$g_memo =$_POST['memo']; 	//$pw = $_POST['form_psw']; 
		$ls = "update {$tkher['table10_group_table']} set group_name='$g_name', memo='$g_memo' where seqno=$seq_no";
		$result = sql_query( $ls );

		$sql = "update {$tkher['table10_table']} set group_name='$g_name' where group_code='$g_code' and userid='$H_ID' ";
		$rs = sql_query(  $sql );

		$sql = "update {$tkher['table10_pg_table']} set group_name='$g_name' where group_code='$g_code' and userid='$H_ID' ";
		$rs = sql_query(  $sql );

		$sql = "update {$tkher['job_link_table']} set job_group='$g_name' where job_group_code='$g_code' and user_id='$H_ID' ";
		$rs = sql_query(  $sql );

		echo "Project Change OK!";
		return;
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
		$ls = "select * from {$tkher['table10_group_table']} where group_name='$g_name' and userid='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if( $rs ) {
			echo $g_name . ", Already exists."; // 이미 존재합니다'
			return false;
		} else {
			$ls = "insert into {$tkher['table10_group_table']} set group_name='$g_name', group_code='$g_num', userid='$H_ID' ";
			$result = sql_query(  $ls );
			echo "group add OK!"; return;
		}

	} else if( $mode_insert === 'Group_update'){

		$g_code =$_POST['g_code']; 
		$g_name=$_POST['g_name']; 
		$sql = "update {$tkher['table10_group_table']} set group_name='$g_name' where group_code='$g_code' and userid='$H_ID' ";
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