<?php	
	include_once('../tkher_start_necessary.php');

	$ip = $_SERVER['REMOTE_ADDR'];
	$infor   = $_POST['infor'];
	$page    = $_POST['page'];
	$list_no = $_POST['list_no'];

	$search_choice = $_POST['search_choice'];
	$search_text   = $_POST['search_text'];
	$menu_mode =$_POST['menu_mode'];


	if( $_POST['mode'] !== "detail_deleteTT") {
		m_("unusual approach");   //비 정상적 접근		//header('Location: '.$url['root'].'bbs/modify_done.php');
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page&menu_mode=$menu_mode&search_choice=$search_choice&search_text=$search_text'>";
		exit;
	}

	$H_ID	= get_session("ss_mb_id");
	if( $H_ID && $H_ID !=''){
		$H_LEV	= $member['mb_level'];  
		$H_NAME = $member['mb_name'];
		$H_NICK = $member['mb_nick'];
		$H_EMAIL = $member['mb_email'];
	} else {
		$H_LEV	= 1;  
		$H_NAME = 'Guest';
		$H_NICK = 'Guest Nick';
		$H_EMAIL = '';
	}

	include_once('./infor.php');

		if( $H_LEV > 7 ) $chkpass = " ";
		else if( $H_ID == $mf_infor[53] ) $chkpass = " ";	// 53:make_id board maker
		else $chkpass = " and id='$H_ID' ";

		$query="SELECT * from aboard_".$mf_infor[2]." where no=".$list_no." $chkpass ";
		$mq =sql_query($query);
		$rs =sql_fetch_array($mq);
		$target = $rs['target'];
		$step   = $rs['step'];
		$re     = $rs['re'];
		$mn =sql_num_rows($mq);
		if( $mn){
			if( $rs['step']=='0' and $rs['re']=='0' ){
				$query ="SELECT * from aboard_".$mf_infor[2]." where target=" . $target;
				$mq =sql_query($query);
				while( $rs =sql_fetch_array( $mq) ){
					$fnm =$rs['file_name'];
					$t = $rs['target'];
					$n = $rs['no'];		//m_("list_no:$list_no, fnm:$fnm ");
					if( $rs['file_name'] !== ""){
						$del_file = "../file/" . $mf_infor[53] . "/aboard_" . $mf_infor[2] . "/" . $rs['file_name'];
						exec ("rm $del_file");
					}
					$a = "aboard_" . $mf_infor[2];
					$query ="delete from aboard_memo where board_name='$a' and list_no=".$n;
					$del_ok =sql_query($query);
				}
				$sql = "delete from aboard_".$mf_infor[2]." where target=" . $target;
				$del_ok =sql_query($sql);
			} else if( $rs['re'] > 0 ){
				$query ="SELECT * from aboard_".$mf_infor[2]." where ( target=$target and step=$step and re=$re) or (target=$target and re > $re) ";

				$mq =sql_query($query);
				$mn =sql_num_rows($mq);	//m_(" record :$mn ");//  record :6 
				while( $rs =sql_fetch_array( $mq) ){
					$fnm=$rs['file_name'];
					$r = $rs['re'];
					$s = $rs['step'];
					$t = $rs['target'];
					$n = $rs['no'];
					if( $rs['file_name'] !== ""){
						$del_file = "../file/" . $mf_infor[53] . "/aboard_" . $mf_infor[2] . "/" . $rs['file_name'];
						exec ("rm $del_file");
					}
					$a = "aboard_" . $mf_infor[2];
					$query ="delete from aboard_memo where board_name='$a' and list_no=$n";
					$del_ok =sql_query($query);
				}
				$sql = "delete from aboard_".$mf_infor[2]." where ( target=$target and step=$step and re=$re) or (target=$target and re > $re) ";
				$del_ok =sql_query($sql);
			} else{
			}
			
			echo "<script>alert('delete ok! '); location.href='listD.php?infor=$infor&page=$page&menu_mode=$menu_mode&search_choice=$search_choice&search_text=$search_text';</script>";

		} else {
			//echo "<script>alert('Record Find Error! ');history.back(-1)</script>";
			echo "<script>location.href='listD.php?infor=$infor&page=$page&menu_mode=$menu_mode&search_choice=$search_choice&search_text=$search_text';</script>";
		}
?>