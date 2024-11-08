<?php
	include_once('../tkher_start_necessary.php');
	//$infor   = $_SESSION['infor'];
	$infor = $_POST['infor'];
	$page  = $_POST['page'];
	$list_no = $_POST['list_no'];
	$search_choice = $_POST['search_choice'];
	$search_text   = $_POST['search_text'];

	if( $_POST['mode'] !== "reply_funcTT") {
		m_("unusual approach");   //비 정상적 접근
		//header('Location: '.$url['root'].'bbs/modify_done.php');
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		exit;
	}

	$H_ID	= get_session("ss_mb_id");	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$H_NAME = $member['mb_name'];
	$H_NICK = $member['mb_nick'];
	$H_EMAIL = $member['mb_email'];
	//-------------------------------------------------------
	$url = array();
	//$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
	$url['root'] = KAPP_URL_T_ . '/'; // $url['root'] = 'http://'.$_SERVER['HTTP_HOST'].'/contents/'; 
	$home = $url['root'];
	//--------------------------------------------------------
	include_once('./infor.php');

	function special_chk ($input) { // 특수문자 제거. "'"만 제거한다.
		if (is_array($input)) { //m_("---1");
			return array_map('special_chk', $input); 
		} 
		else if (is_scalar($input)) { //m_("---2");
				return preg_replace("/'/i", "", $input); //return preg_replace("/[ #\/\\\:;,'\"`<>()]/i", "", $input);
		} 
		else { //m_("---3");
			return $input; 
		} 
	}


			//댓글.
	$subject = $_POST['subject'];
	$content = $_POST['content'];
	$content = special_chk( $content );
		//-------------------------------------------------------------------- file upload
		$upfile_name= $_FILES["fileA"]["name"];
		$upfile_size= $_FILES["fileA"]["size"];

		//$f_path		= $f_path . "../file/" . $H_ID;		// . "/"; 
		$upfile2	= "";
		$file_ext	= "";
		$f_path2	= "";

		if ( $upfile_size > 0 ) {

			$file_ext		= $_POST['file_ext'];
			$fileup_ynX	= $fileup_yn * 1000000; // fileup_yn = $mf_infor[3] 업로드 가능한 크기.
			if ( $upfile_size >  $fileup_ynX ) { 
				my_msg("$fileup_yn Mb Only uploaded below"); // $fileup_yn Mb 이하만 업로드 가능합니다 
				echo "<script>window.open('listD.php?infor=$infor&page=$page','_self','')</script>";
				exit;
			}
			$upfile_name	= $_FILES["fileA"]["name"];
			//------------------------------------- add cra 2018-06-19
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
			$upfile2 = $upfile_name;	//$H_ID . "_" . time() . $file_ext; //$ext_name;
			move_uploaded_file( $_FILES["file"]["tmp_name"], $f_path2 . "/" . $upfile2 );
			//exec ("chmod 777 bbs_image/$upfile2");
		} else {
			$upfile_name= '';
			$upfile_size= 0;
			$f_path2 = '';
			$file_ext = '';
		}
		//-------------------------------------------------------------------- file upload end

		$target = $_POST['target'];		//$target;		//target 셋팅(원본글의 target값을 저장)	
		$re 	= $_POST['re'] + 1;		//$re+1;		//re 셋팅 
		$step 	= $_POST['step'] + 1;	//$step+1;	    //step 셋팅(원본글의 step에서 +1을 하고 같은 값이 있을시 모두 +1증가) 
		
		$query ="select no from aboard_".$mf_infor[2]." where target=".$target." and step=".$step;
		
		$mq	=sql_query($query);

		if($mq){
			$query = "update aboard_".$mf_infor[2]." set step=step+1 where target=".$target." and step >= ".$step;
			$mq = sql_query($query);
		}
		$in_date = time();
		//답변글입력 
		
		//$context = $_POST[EditCtrl];
		$query="insert into aboard_".$mf_infor[2]." set
		infor = '$infor',
		id = '$H_ID',
		name = '$H_NICK',
		email = '$H_EMAIL',
		home = '$home',
		ip = '$ip',
		in_date = '$in_date',
		subject = '$subject',
		context = '$content',
		password = '".$_POST['password']."',
		file_name = '$upfile2',
		file_wonbon = '$upfile_name',
		file_size = '$upfile_size',
		file_type = '$file_ext',
		file_path = '$f_path2',
		cnt =0,
		target = $target,
		step = $step,
		re = $re,
		security = '".$_POST['security']."' ";

		$mq = sql_query($query);
		if( $mq ) {
			echo  "<script>alert('reply answer ok!')</script>";
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		} else {
			m_("error --- replyD check");
			//echo $query; exit;
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		}
?>
