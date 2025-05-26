<?php
	include_once('../tkher_start_necessary.php');

	/*
	  insertD_check.php - insertD.php
	*/
	$H_ID = get_session("ss_mb_id"); $ip = $_SERVER['REMOTE_ADDR'];
	if( $H_ID ) {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
		$H_EMAIL= $member['mb_email'];  
	} else {
		$H_LEV	= 0;  
		$H_NAME	= '';  
		$H_NICK	= '';  
		$H_EMAIL= '';  
	}

	if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	else {
		echo "<script>history.back(-1);</script>"; exit;
	}

	include_once('./infor.php');

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

	$content = special_chk( $content );
	$in_dateA	= date("Y-m-d H:i:s", time());
	$in_date	= time();

	$q = " INSERT INTO {$tkher['ap_bbs_table']} set infor=$infor, email='$H_EMAIL', subject='$subject', content='$content', reg_date='$in_date', host='".KAPP_URL_T_."' ";
	$result = sql_query($q); //$result = $mysqli->query($q);
	if( $result){
		m_("ap_bbs - insert OK");
	} else {
		m_("ap_bbs - insert error");
		echo "sql: " . $q; exit;
	}
	//----------------------------------------------------------------------

		$fileup_yn	= $_POST['fileup_yn'];
		if( $fileup_yn > 0 ){
			//$upfile			= $_POST['fileA']; // null
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
		if( $fileup_yn > 0 && $upfile_name !== "" ){
			$file_ext		= $_POST['file_ext'];
			$fileup_ynX	= $fileup_yn * 1000000; // fileup_yn = $mf_infor[3] 업로드 가능한 크기.
			if ( $upfile_size >  $fileup_ynX ) { 
				m_("$fileup_yn Mb Only uploaded below"); // $fileup_yn Mb 이하만 업로드 가능합니다 
				echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";
				exit;
			}
			$f_path1			= KAPP_PATH_T_ . "/file/" . $mf_infor[53];	// 53:maker id.
			$f_path2			= $f_path1 . "/aboard_".$mf_infor[2]; // 2: board name
			if ( !is_dir($f_path1) ) { // contents + userid Dir error
				if ( !@mkdir( $f_path1, 0755 ) ) {
					echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
					m_(" Error: f_path1 : " . $f_path1 . " Failed to create directory. ");
					echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";exit;
				}
			}
			if ( !is_dir($f_path2) ) { // contents + userid + board name Dir error
				if ( !@mkdir( $f_path2, 0755 ) ) {
					echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
					m_(" Error: f_path2 : " . $f_path2 . " Failed to create directory. ");
					echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";exit;
				}
			}
			$upfile2 = $upfile_name;	//$H_ID . "_" . time() . $file_ext; //$ext_name;
			move_uploaded_file( $_FILES["fileA"]["tmp_name"], $f_path2 . "/" . $upfile2 );
		}

		if( isset($_POST['security']) ) $security = $_POST['security'];
		else $security = '';
		
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
		if(!$H_ID) { // 비회원 작성. 비번 관리. ???
			$H_ID   = 'Guest'; 
			$pass   = $_POST['password'];
			$H_NICK = $_POST['nameA'];
		} else $pass='';

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
		security = '$security' ";
		$result = sql_query( $query );

//----------------------------------------------------------------------
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
