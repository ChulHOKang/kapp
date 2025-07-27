<?php
	include_once('../tkher_start_necessary.php');

	/*
	list1_update_check.php - call:list1_detail_update.php
	mode: list1_update_check
	*/
	$infor = $_POST['infor'];
	$page  = $_POST['page'];
	$list_no = $_POST['list_no'];
	$search_choice = $_POST['search_choice'];
	$search_text   = $_POST['search_text'];

	if( $_POST['mode'] !== "List1_Update_Check") {
		m_("unusual approach");   //비 정상적 접근
		echo "<meta http-equiv='refresh' content=0;url='list1_detail.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		exit;
	}
	$subject = htmlspecialchars( $_POST['subject'] );
	$context = $_POST['context'];

	$H_ID	= get_session("ss_mb_id");
	$H_LEV	= $member['mb_level'];
	$ip = $_SERVER['REMOTE_ADDR'];
				$upfile_name= $_FILES["fileA"]["name"];
				$upfile_nameA= $_POST['up_fileA'];
//m_("upfile_name=" . $upfile_name . ", upfile_nameA: " . $upfile_nameA); exit;
//upfile_name=girl_body.png, upfile_nameA: C:\fakepath\girl_body.png
	if( isset($_POST['security']) ) $security = $_POST['security'];
	else $security='';

	include_once('./infor.php');

		if( $H_LEV > 7 ) $chkpass = " "; // admin
		else if( $H_ID ) $chkpass = " and id='$H_ID' "; // user
		else $chkpass = " and password='".$_POST['passwordG']."' "; // guest

		$query = "SELECT * from aboard_" .$mf_infor[2]. " where no=" .$list_no. " $chkpass ";
		$mq = sql_query($query);
		$mn = sql_num_rows($mq);
		$rs = sql_fetch_array($mq);
		if( !$mn){
			echo "<script>window.open('list1_detail_update.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
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
				echo "<br>Error ---";
				exit;
			}
			$f_path1	= KAPP_PATH_T_ . "/file/".$mf_infor[53]; // 53:mid user
			$f_path2	= $f_path1 . "/aboard_".$mf_infor[2];    // 2: board name
			///home1/kappsystem/public_html/kapp/file/crakan59_gmail/aboard_crakan59_gmail1750060517
			if( $fileup_yn && $upfile_name !== '') {	//$upfile_name
				if( $upfile_size > ($fileup_yn * 1000000) ) { 
					m_("$fileup_yn Mb Only uploaded below"); // $fileup_yn Mb 이하만 업로드 가능합니다 
					echo "<script>window.open('list1_detail_update.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
					//echo "<script>window.open('listD.php?infor=$infor&page=$page','_self','')</script>";
					exit;
				}
				$upfile_name= $_FILES["fileA"]["name"];
				if( !is_dir($f_path1) ) { 
					if( !@mkdir( $f_path1, 0755 ) ) {
						echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
						echo "<script>window.open('list1_detail_update.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
						//echo "<script>history.go(-1); </script>";exit;
					}
				}
				if( !is_dir($f_path2) ) {
					if( !@mkdir( $f_path2, 0755 ) ) {
						echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
						echo "<script>window.open('list1_detail_update.php?infor=$infor&list_no=$list_no','_self','')</script>";exit;
						//echo "<script>history.go(-1); </script>";exit;
					}
				}
			}
			if( $upfile_name !== '' && isset($rs['file_name']) ) { // old file delete and new file create
				$del_ = $f_path2 . "/" . $rs['file_name'];
				exec ("rm $del_");	//m_("del: $del_");
				move_uploaded_file($_FILES["fileA"]["tmp_name"], $f_path2 . "/" . $upfile_name );
				$query = "update aboard_".$mf_infor[2]." set subject='$subject', context='$context', file_name='$upfile_name', file_wonbon='$upfile_name',	file_size='$upfile_size', file_type='$file_ext', file_path='$f_path2', ip='$ip' where no=".$list_no." $chkpass ";
			} else if( $upfile_name !== '' && !isset($rs['file_name']) ){	// new.
				move_uploaded_file($_FILES["fileA"]["tmp_name"], $f_path2 . "/" . $upfile_name );
				$query = "update aboard_".$mf_infor[2]." set subject='$subject', context='$context', file_name='$upfile_name', file_wonbon='$upfile_name',	file_size='$upfile_size', file_type='$file_ext', file_path='$f_path2', ip='$ip' where no=".$list_no." $chkpass ";
			} else if( $upfile_name == '' && isset($rs['file_name']) ){
				$query = "update aboard_".$mf_infor[2]." set subject='$subject', context='$context', ip='$ip' where no=".$list_no . $chkpass;
			}
			$mq = sql_query( $query);
			if( $mq ) {
				m_('update ok!');
				echo "<meta http-equiv='refresh' content=0;url='list1_detail.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
			} else {
				m_("error --- list1_detail_update check");
				echo "<meta http-equiv='refresh' content=0;url='list1_detail.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
			}
		}
		//var_dump($url);
		//header('Location: '.$url['root'].'bbs/modify_done.php');
		//echo "<meta http-equiv='refresh' content=0;url='index_bbs.php?infor=$infor'>";
		exit;
		//exit();
?>
