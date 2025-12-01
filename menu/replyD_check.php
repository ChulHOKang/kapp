<?php
	include_once('../tkher_start_necessary.php');
	/*
		replyD_check.php
	*/
	//$infor   = $_SESSION['infor'];
	//if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	include_once('./infor.php');

	if( isset($_POST['page']) ) $page  = $_POST['page'];
	if( isset($_POST['list_no']) ) $list_no = $_POST['list_no'];
	if( isset($_POST['search_choice']) ) $search_choice = $_POST['search_choice'];
	else $search_choice = "";
	if( isset($_POST['search_text']) ) $search_text   = $_POST['search_text'];
	else $search_text = "";
	if( isset($_POST['password']) ) $password = $_POST['password'];
	else $password = "";
	if( $_POST['mode'] !== "reply_funcTT") {
		m_("unusual approach");   //비 정상적 접근
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID	= get_session("ss_mb_id");
	$grant_read	= $mf_infor[46];
	$grant_write= $mf_infor[47];

	if( $H_ID && $H_ID !=='') {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
		$H_EMAIL = get_session("ss_mb_email"); 
	} else {
		if( $grant_write > 1 ){
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page'>";
			exit;
		} else {
			$H_ID	= 'Guest';  
			$H_NICK	= 'Guest';
			$H_NAME = 'Guest';
			$H_LEV	= 1;
			$H_EMAIL		= $_POST['email'];
			$password		= $_POST['password'];
		}
	}

	function special_chk( $input) { // 특수문자 제거. "'"만 제거한다.
		if ( is_array($input) ) {
			return array_map('special_chk', $input); 
		} else if( is_scalar($input) ) {
				return preg_replace("/'/i", "", $input); //return preg_replace("/[ #\/\\\:;,'\"`<>()]/i", "", $input);
		} else {
			return $input; 
		} 
	}
	$subject = $_POST['subject'];
	$content = $_POST['content'];	//$content = special_chk( $content );
		$upfile_name= $_FILES["fileA"]["name"];
		$upfile_size= $_FILES["fileA"]["size"];
		$upfile2	= "";
		$file_ext	= "";
		$f_path2	= "";
		if ( $upfile_size > 0 ) {
			$file_ext		= $_POST['file_ext'];
			$fileup_ynX	= $fileup_yn * 1000000; 
			if ( $upfile_size >  $fileup_ynX ) { 
				m_("$fileup_yn Mb Only uploaded below"); 
				echo "<script>window.open('listD.php?infor=$infor&page=$page','_self','')</script>";
				exit;
			}
			$upfile_name	= $_FILES["fileA"]["name"];
			$f_path1	= "../file/" . $mf_infor[53];
			$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];
			if ( !is_dir($f_path1) ) {
				if ( !@mkdir( $f_path1, 0755 ) ) {
					echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
					echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
				}
			}
			if ( !is_dir($f_path2) ) {
				if ( !@mkdir( $f_path2, 0755 ) ) {
					echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
					echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
				}
			}
			$upfile_name = str_replace(" ", "", $upfile_name);
			//$upfile2 = $upfile_name;	
			$upfile2 = $H_ID . "_" . time() ."_" . $upfile_name; // . $file_ext;
			move_uploaded_file( $_FILES["file"]["tmp_name"], $f_path2 . "/" . $upfile2 );
			//exec ("chmod 777 bbs_image/$upfile2");
		} else {
			$upfile_name= '';
			$upfile_size= 0;
			$f_path2 = '';
			$file_ext = '';
		}
		$target = $_POST['target'];
		$re 	= $_POST['re'] + 1;
		$step 	= $_POST['step'] + 1;	//$step+1;	    //step 셋팅(원본글의 step에서 +1을 하고 같은 값이 있을시 모두 +1증가) 
		$query  = "select no from aboard_".$mf_infor[2]." where target=".$target." and step=".$step;
		$mq	= sql_fetch( $query ); //$mq	=sql_query($query);
		if( isset($mq['no']) ){ //if($mq){
			$query = "update aboard_".$mf_infor[2]." set step=step+1 where target=".$target." and step >= ".$step;
			$mq = sql_query($query);
		}
		$in_date = time();
		//if( isset($_POST['security']) ) $security=$_POST['security'];
		//else $security='';
		$query = "insert into aboard_".$mf_infor[2]." set
		infor = $infor,
		id = '$H_ID',
		name = '$H_NICK',
		email = '$H_EMAIL',
		home = '".KAPP_URL_T_."',
		ip = '$ip',
		in_date = '$in_date',
		subject = '$subject',
		context = '$content',
		password = '".$password."',
		file_name = '$upfile2',
		file_wonbon = '$upfile_name',
		file_size = '$upfile_size',
		file_type = '$file_ext',
		file_path = '$f_path2',
		cnt =0,
		target = $target,
		step = $step,
		re = $re,
		security = '' ";
		$mq = sql_query($query);
		if( $mq ) {
			m_("reply answer ok!");
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
			//exit;
		} else {
			m_("error --- replyD check");			//echo $query; exit;
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		}
?>
