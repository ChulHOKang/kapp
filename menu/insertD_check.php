<?php
	include_once('../tkher_start_necessary.php');
	/*
	  insertD_check.php - insertD.php
	*/
	include_once('./infor.php');

	if( !isset($infor) || $infor =='' ) {
		echo "<meta http-equiv='refresh' content=0;url='listD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		exit; 
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID = get_session("ss_mb_id");

	$grant_read	= $mf_infor[46];
	$grant_write= $mf_infor[47];
	if( $H_ID && $H_ID !=='' && $H_ID !=='Guest' ) {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
		$H_EMAIL= $member['mb_email'];  
	} else {
		if( $grant_write > 1 ){
			echo "<meta http-equiv='refresh' content=0;url='listD.php?infor=$infor&list_no=$list_no&page=$page'>";
			exit;
		} else {
			$H_NICK	= 'Guest';
			$H_NAME = 'Guest';
			$H_LEV	= 1;
			$H_ID	= 'Guest';  
			$H_EMAIL= $_POST['email'];
			$password= $_POST['password'];
		}
	}

	function special_chk ($input) { // 특수문자 제거. "'"만 제거한다.
		if( is_array($input)) { //m_("---1");
			return array_map('special_chk', $input); 
		} else if ( is_scalar($input)) { //m_("---2");
				return preg_replace("/'/i", "", $input); //return preg_replace("/[ #\/\\\:;,'\"`<>()]/i", "", $input);
		} else { //m_("---3");
			return $input; 
		} 
	}

	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page =1;
	if( isset($_POST['menu_mode']) ) $menu_mode	= $_POST['menu_mode'];
	else $menu_mode	= '';
	if( isset($_POST['subject']) ) $subject	= $_POST['subject'];
	else $subject	= '';
	if( isset($_POST['content']) ) $content	= $_POST['content'];
	else $content	= '';

	if( isset($_POST['tab_enm']) ) $tab_enm	= $_POST['tab_enm']; //$tab_enm = "aboard_".$mf_infor[2];
	else $tab_enm	= '';
	if( isset($_POST['tab_hnm']) ) $tab_hnm	= $_POST['tab_hnm']; //$tab_hnm = "aboard_".$mf_infor[1];
	else $tab_hnm	= '';

	//$content = special_chk( $content );
	$in_dateA	= date("Y-m-d H:i:s", time());
	$in_date	= time();

	$q = " INSERT INTO {$tkher['ap_bbs_table']} set infor=$infor, email='$H_EMAIL', subject='$subject', content='$content', reg_date=$in_date,  host='".KAPP_URL_T_."' ";
	$result = sql_query($q); //$result = $mysqli->query($q);
	if( $result){
		m_("ap_bbs - insert OK");

		$kapp_theme0 = '';
		$kapp_theme1 = '';
		$kapp_theme = $config['kapp_theme'];
		$kapp_theme = explode('^', $kapp_theme );
		//$kapp_theme0 = "https://fation.net/kapp";//$kapp_theme[0];
		$kapp_theme0 = $kapp_theme[0];
		$kapp_theme1 = $kapp_theme[1];
		if( $kapp_theme0 != '' ) { // Only if you want to share : 공유를 원 할 경우에만 
			$kapp_theme0 = $kapp_mainnet; //"https://fation.net/kapp"; // Share start server
			if( Ap_bbs_curl_send( $kapp_theme0, $infor, $H_EMAIL, $subject, $content, $in_date, $tab_enm, $tab_hnm, KAPP_URL_T_ ) ) {
				if( $kapp_theme1 ) Ap_bbs_curl_send( $kapp_theme1, $infor, $H_EMAIL, $subject, $content, $in_date, $tab_enm, $tab_hnm, KAPP_URL_T_ );
			}
			m_("ap_bbs_curl --- insert ok");			//return true;
		}

	} else {
		m_("ap_bbs - insert error");
		//echo "sql: " . $q; exit;
	}
	if( isset($_POST['password']) ) $pass= $_POST['password'];
	else $pass='';

	$fileup_yn	= $_POST['fileup_yn'];
	if( $fileup_yn > 0 ){
		$upfile_name	= $_FILES["fileA"]["name"];
		$upfile_size	= $_FILES["fileA"]["size"];
	} else{
		$upfile			= '';
		$upfile_name	= '';
		$upfile_size		= '';
	}
	$upfile2	= "";
	$file_ext	= "";
	$f_path2	= "";
	if( $fileup_yn > 0 && isset($upfile_name) && $upfile_name !== '' ) {
		$file_ext		= $_POST['file_ext'];
		$upload_file_size_limit	= $fileup_yn * 1000000; // fileup_yn = $mf_infor[3] upload limit size
		if( $upfile_size >  $upload_file_size_limit ) {
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
			exit; 
		}
		//if( $mf_infor[2] == 'kapp_Notice' || $mf_infor[2] == 'kapp_news' || $mf_infor[2] == 'kapp_qna' || $mf_infor[2] == 'kapp_free') $f_path1	= KAPP_PATH_T_ . "/file/";
		//else $f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53];
		$f_path1	= KAPP_PATH_T_ . "/file/" . $mf_infor[53]; // make_id
		$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];
		if( !is_dir($f_path1) ) {
			if( !@mkdir( $f_path1, 0755 ) ) {
				echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
				echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
				exit; 
			}
		}
		if( !is_dir($f_path2) ) {
			if( !@mkdir( $f_path2, 0755 ) ) {
				echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
				echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
				exit; 
			}
		}
		$upfile_name = str_replace(" ", "", $upfile_name);
		$upfile2 = $H_ID . "_" . time() ."_" . $upfile_name; // . $file_ext;
		move_uploaded_file( $_FILES["fileA"]["tmp_name"], $f_path2 . "/" . $upfile2 );
	}
	//if( isset($_POST['security']) ) $security = $_POST['security'];
	//else $security = '';
	//조회수,step값,re값 초기화
	$cnt=0;		$step=0;		$re=0;
	// 다음글 번호 구하기
	$query="select max(no) as no from aboard_".$mf_infor[2]; // $infor_2 는 $mf_infor[2] 와 같다.
	$mq = sql_query($query);
	$target = sql_num_rows( $mq );
	if( !$target ) $target=1;
	else {
		$rs = sql_fetch_array( $mq );
		$target = $rs['no']+1;
	}
	$query = "insert into aboard_".$mf_infor[2]." set
	infor = $infor,
	id = '$H_ID',
	name = '$H_NICK',
	email = '$H_EMAIL',
	home = '".KAPP_URL_T_."',
	ip = '$ip',
	in_date = $in_date,
	subject = '$subject',
	context = '$content',
	password = '$pass',
	file_name = '$upfile2',
	file_wonbon = '$upfile_name',
	file_size = '$upfile_size',
	file_type = '$file_ext',
	file_path = '$f_path2',
	cnt = 0,
	target = $target,
	step = 0,
	re = 0,
	security = '' ";
	$result = sql_query( $query );
	if( $result==false) {
		$_SESSION['writing_status'] = 'NO';
		echo "write---NO";
		m_("write Error, url:" . KAPP_URL_T_);
	} else {
		$_SESSION['writing_status'] = 'YES';
		echo "write---YES";
		m_("write OK, url:" . KAPP_URL_T_);
	}

	header('Location: listD.php?infor='.$infor.'&page='.$page.'&menu_mode='.$menu_mode);

?>
