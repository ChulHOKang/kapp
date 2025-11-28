<?php
	include_once('../tkher_start_necessary.php');

	$infor = $_POST['infor'];
	$page  = $_POST['page'];
	$list_no = $_POST['list_no'];
	$search_choice = $_POST['search_choice'];
	$search_text   = $_POST['search_text'];
	include_once('./infor.php');

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

	if( $_POST['mode'] !== "update_funcTT") {
		m_("unusual approach");   //비 정상적 접근
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		exit;
	}
	//$subject = htmlspecialchars( $_POST['subject'] );
	$subject = $_POST['subject'];
	$content = $_POST['content'];


		if( $H_LEV > 7 ) $chkpass = " "; // admin
		else if( $H_ID ) $chkpass = " and id='$H_ID' "; // user
		else $chkpass = " and password='".$_POST['passwordG']."' "; // guest

		$query = "SELECT * from aboard_" .$mf_infor[2]. " where no=" .$list_no. " $chkpass ";
		$mq = sql_query($query);
		$mn = sql_num_rows($mq);
		$rs = sql_fetch_array($mq);
		if( !$mn){
			echo "<script>window.open('updateD.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
		} else {
			$file_ext	= "";
			$fileup_yn	= $_POST['fileup_yn'];
			if( $fileup_yn && $_FILES["fileA"]["name"] !=='' ){
				$upfile_name= $_FILES["fileA"]["name"];
				$upfile_size= $_FILES["fileA"]["size"];
				$file_extA = explode( ".", $upfile_name );
				$file_ext = "." . $file_extA[1]; // .zip
			} else{
				$upfile		= '';
				$upfile_name= '';
				$upfile_size= '';
			}
			$f_path1	= KAPP_PATH_T_ . "/file/".$mf_infor[53]; // 53:mid user
			$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];    // 2: board name
			if( $fileup_yn && $upfile_name !== '') {
				if( $upfile_size > ($fileup_yn * 1000000) ) { 
					m_("$fileup_yn Mb Only uploaded below");
					echo "<script>window.open('updateD.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
					exit;
				}
				$upfile_name= $_FILES["fileA"]["name"];
				if( !is_dir($f_path1) ) { 
					if( !@mkdir( $f_path1, 0755 ) ) {
						echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
						echo "<script>window.open('updateD.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
					}
				}
				if( !is_dir($f_path2) ) {
					if( !@mkdir( $f_path2, 0755 ) ) {
						echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
						echo "<script>window.open('updateD.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
					}
				}
			}
			if( $upfile_name !== '' && isset($rs['file_name']) ) {
				$del_ = $f_path2 . "/" . $rs['file_name'];
				exec ("rm $del_");
				move_uploaded_file($_FILES["fileA"]["tmp_name"], $f_path2 . "/" . $upfile_name );
				$query = "update aboard_".$mf_infor[2]." set subject='$subject', context='$content', file_name='$upfile_name', file_wonbon='$upfile_name',	file_size='$upfile_size', file_type='$file_ext', file_path='$f_path2', ip='$ip' where no=".$list_no." $chkpass ";
			} else if( $upfile_name !== '' && !isset($rs['file_name']) ){	// new.
				move_uploaded_file($_FILES["fileA"]["tmp_name"], $f_path2 . "/" . $upfile_name );
				$query = "update aboard_".$mf_infor[2]." set subject='$subject', context='$content', file_name='$upfile_name', file_wonbon='$upfile_name',	file_size='$upfile_size', file_type='$file_ext', file_path='$f_path2', ip='$ip' where no=".$list_no." $chkpass ";
			} else if( $upfile_name == '' && isset($rs['file_name']) ){
				$query = "update aboard_".$mf_infor[2]." set subject='$subject', context='$content', ip='$ip' where no=".$list_no . $chkpass;
			}
			$mq = sql_query( $query);
			if( $mq ) {
				echo  "<script>alert('update ok!')</script>";
				echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
			} else {
				m_("error --- updateD check");
				echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
			}
		}
		//var_dump($url);
		//header('Location: '.$url['root'].'bbs/modify_done.php');
		exit();
?>
