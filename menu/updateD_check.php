<?php
	include_once('../tkher_start_necessary.php');

	$infor = $_POST['infor'];
	$page  = $_POST['page'];
	$list_no = $_POST['list_no'];
	$search_choice = $_POST['search_choice'];
	$search_text   = $_POST['search_text'];

	$subject = $_POST['subject'];
	$content = $_POST['content'];
	if( $_POST['mode'] !== "update_funcTT") {
		m_("unusual approach");   //비 정상적 접근
		//header('Location: '.$url['root'].'bbs/modify_done.php');
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&search_choice=$search_choice&search_text=$search_text'>";
		exit;
	}

	$H_ID	= get_session("ss_mb_id");	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];

	$H_NAME = $member['mb_name'];
	$H_NICK = $member['mb_nick'];
	$H_EMAIL = $member['mb_email'];
	//----------------------------------------------------------------------------------------
	$url = array();
	$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
	$url['root'] = $http . $_SERVER['HTTP_HOST'] . '/contents/'; // $url['root'] = 'http://'.$_SERVER['HTTP_HOST'].'/contents/'; 
	//-----------------------------------------------------------------------------------------
	//$infor   = $_SESSION['infor'];
	//include "https://appgenerator.net/contents/infor.php";
	include_once('./infor.php');
		// 관리자일경우에는 패스워드를 체크 안하고 수정이 가능함.
		if($H_LEV > 7 ) $chkpass = "";
		else if( $H_ID ) $chkpass = " and id='$H_ID' ";
		else $chkpass = " and password='".$_POST['passwordG']."' ";
		//else $chkpass = " and password='$password' ";
		//////////////////////////////////////////////////////////
		//$list_no = $_POST['list_no'];
		//m_("query_ok_new -------- list_no :$list_no");
		$query = "SELECT * from aboard_" .$mf_infor[2]. " where no=" .$list_no. " $chkpass ";
		$mq = sql_query($query);
		$mn = sql_num_rows($mq);
		$rs = sql_fetch_array($mq);

		if(!$mn){
			//echo"$query";
			echo "<script>alert(' Please check. '); history.go(-1);</script>";
		} else {
			
			$upfile2	= "";
			$file_ext	= "";
			//-------------------------------------------------------------------- file upload
			$fileup_yn	= $_POST['fileup_yn'];
			if( $fileup_yn ){
				$upfile_name= $_FILES["fileA"]["name"];
				$upfile_size= $_FILES["fileA"]["size"];
				$file_extA = explode( ".", $upfile_name );
				$file_ext = "." . $file_extA[1]; // .zip
			} else{
				$upfile		= '';
				$upfile_name= '';
				$upfile_size= '';
			}
			$f_path1	= "../file/".$mf_infor[53]; // 53:mid user
			$f_path2	= "../file/".$mf_infor[53]."/aboard_".$mf_infor[2]; // 2: board name

			if ( $fileup_yn && $upfile_name !== '') {	//$upfile_name

				//$file_ext		= $_POST['file_ext'];

				$fileup_ynX	= $fileup_yn * 1000000; // fileup_yn = $mf_infor[3] 업로드 가능한 크기.
				if ( $upfile_size >  $fileup_ynX ) { 
					my_msg("$fileup_yn Mb Only uploaded below"); // $fileup_yn Mb 이하만 업로드 가능합니다 
					echo "<script>window.open('listD.php?infor=$infor&page=$page','_self','')</script>";
					exit;
				}
				$upfile_name	= $_FILES["fileA"]["name"];

				if ( !is_dir($f_path1) ) {
					if ( !@mkdir( $f_path1, 0755 ) ) {
						echo " Error: f_path1 : " . $f_path1 . " Failed to create directory. ";
						echo "<script>history.go(-1); </script>";exit;
						//echo "<script>window.open('updateD.php?infor=$infor','_self','')</script>";exit;
					}
				}
				if ( !is_dir($f_path2) ) {
					if ( !@mkdir( $f_path2, 0755 ) ) {
						echo " Error: f_path2 : " . $f_path2 . " Failed to create directory. ";
						echo "<script>history.go(-1); </script>";exit;
						//echo "<script>window.open('updateD.php?infor=$infor','_self','')</script>";exit;
					}
				}
				$upfile2 = $upfile_name;	//$H_ID . "_" . time() . $file_ext; //$ext_name;
				move_uploaded_file($_FILES["file"]["tmp_name"], $f_path2 . "/" . $upfile2 );
				//exec ("chmod 777 bbs_image/$upfile2");
			}
			if( $upfile_name !== '' ) {	// 새로운 파일이 있으면 삭제한다.
				$del_ = $f_path2 . "/" . $rs['file_name'];	//"file/". $rs['id'] . "/" . $rs['file_name'];
				//m_("del_:$del_");
				exec ("rm $del_");
			} else {	// 첨부화일이 없으면 엤것을 그대로.
				$upfile_name = $rs['file_wonbon'];
				$upfile2     = $rs['file_name'];
				$file_extA = explode( ".", $upfile_name );
				$file_ext = "." . $file_extA[1]; // .zip
			}
			//-------------------------------------------------------------------- file upload end
			$security_yn = $_POST['security_yn'];
			if( $security_yn ) $security = $_POST['security'];
			else $security='';
			//------------------------------------------------
		
			$subject = $_POST['subject'];
			$subject = htmlspecialchars( $subject );//			$rs[title] = htmlspecialchars($rs[title]);
			$nameA   = $_POST['nameA'];

			$query = "update aboard_".$mf_infor[2]." set
			ip='$ip',
			subject='$subject',
			context='$content',
			file_name = '$upfile2',
			file_wonbon = '$upfile_name',
			file_size = '$upfile_size',
			file_type = '$file_ext',
			file_path = '$f_path2',
			security = '$security'
			where no=".$list_no." $chkpass "; //echo "sql: ".$query; exit;
			$mq = sql_query($query);
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
