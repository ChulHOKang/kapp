<?php 
  include_once('../tkher_start_necessary.php');
	 $_ID	= get_session("ss_mb_id"); 
	if( isset( $_ID) ) $H_ID	= get_session("ss_mb_id");   //"ss_mb_id";	//connect_count('ulist', $H_ID, 0);	// log count
	else $H_ID="";

	$H_EMAIL		= $member['mb_email'];

		$mode_insert=$_POST['mode_insert']; 
		$g_name=$_POST['g_name']; 
		$g_name_code=$_POST['g_name_code']; 

	   echo "g_name: " . $g_name . ", g_name_code:" . $g_name_code. ", mode_insert:" . $mode_insert;

	if( $mode_insert === 'insert_mode'){

		//$column = json_decode(getJsonTextX($_POST['column']), true);
		//$data = json_decode(getJsonTextX($_POST['data']), true);


		$tit=$_POST['title_nm']; 
		$url=$_POST['url_nm']; 
		$memo=$_POST['memo']; 
		$pw=$_POST['form_psw']; 

		Record_save($tit, $url, $memo, $pw);
	}



	//echo "tit: " . $tit . ", url:" . $url. ", memo:" . $memo. ", pw:" . $pw;

function Record_save($tit, $url, $memo, $pw) {
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
        echo "save OK!";
        //exit;
    }
    
}


?>