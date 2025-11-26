<?php
	include_once('../tkher_start_necessary.php');
	include "./infor.php";
	/*
		detail_delete_password.php : call - detailD.php
	*/
	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;
	
	if( isset($_POST['mode']) ) $mode =$_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode =$_REQUEST['mode'];
	else  $mode ='';

	if( isset($_POST['infor']) ) $infor =$_POST['infor'];
	else if( isset($_REQUEST['infor']) ) $infor =$_REQUEST['infor'];
	else  $infor ='';

	if( isset($_POST['page']) ) $page =$_POST['page'];
	else if( isset($_REQUEST['page']) ) $page =$_REQUEST['page'];
	else  $page ='';

	if( isset($_POST['list_no']) ) $list_no =$_POST['list_no'];
	else if( isset($_REQUEST['list_no']) ) $list_no =$_REQUEST['list_no'];
	else  $list_no ='';

	if( isset($_POST['call_pg']) ) $call_pg =$_POST['call_pg'];
	else if( isset($_REQUEST['call_pg']) ) $call_pg =$_REQUEST['call_pg'];
	else  $call_pg ='';

	if( isset($_POST['menu_mode']) ) $menu_mode =$_POST['menu_mode'];
	else if( isset($_REQUEST['menu_mode']) ) $menu_mode =$_REQUEST['menu_mode'];
	else  $menu_mode ='';
/*	if( isset($_POST['memo_no']) ) $memo_no =$_POST['memo_no'];
	else if( isset($_REQUEST['memo_no']) ) $memo_no =$_REQUEST['memo_no'];
	else  $memo_no ='';

	if( isset($_POST['board_name']) ) $board_name =$_POST['board_name'];
	else if( isset($_REQUEST['board_name']) ) $board_name =$_REQUEST['board_name'];
	else  $board_name ='';

	if( isset($_POST['call_pg']) ) $call_pg =$_POST['call_pg'];
	else if( isset($_REQUEST['call_pg']) ) $call_pg =$_REQUEST['call_pg'];
	else  $call_pg ='';
	if( isset($_POST['security']) ) $security	=$_POST['security'];
	else $security	='';
*/
	//m_(" --- mode: $mode, PHP_SELF:$PHP_SELF");// --- mode: , PHP_SELF:/contents/memo_password.php
	// --- mode: memo_deleteTT, PHP_SELF:/kapp/menu/memo_password.php
?>

<HTML>
 <HEAD>
  <TITLE> New Document </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>

<script>
	function cl(){
		window.close();
	}
	function op(){
			infor=document.pass_form.infor.value;
			alert('infor:'+infor);
			document.pass_form.action='detailD.php?infor='+infor;
			document.pass_form.target='_blank';
			document.pass_form.submit();
	}
	function pass_check(){
		var in_p = document.pass_form.security.value;
		if( in_p == "") {
			alert('Please enter a password!' ); return false;
		} else {
			document.pass_form.mode.value = 'check';
			document.pass_form.submit();
		}
	}
	function check_func(){
		get_email = document.pass_form.get_email.value;
		if( !get_email ) {
			alert('Please enter a email!');
			return false;
		}
		pass = document.pass_form.get_password.value;
		if( !pass ) {
			alert('Please enter a password!');
			return false;
		}
		pass_form.mode.value='check_delete';
		pass_form.submit();
		parent.window.opener.reload(true)
	}
	
	function back_func(){
		pass_form.mode.value='check_back';
		pass_form.submit();
	}
</script>

<?php
	if( $mode=='back' ){
			$rungo = $call_pg . "?infor=" . $infor . "&page=".$page;
			echo "<script>window.open( '$rungo' , '_top', ''); </script>";
			echo "<script>cl();</script>";
			exit;
	} else if( $mode=='check_back' ){
			echo "<script>cl();</script>";
			exit;
	} else if( $mode=='check_delete' ){
	

		/*
		$sql = " select * from {$tkher['aboard_memo_table']} where no=".$memo_no;
		$rt = sql_query( $sql );
		$rs = sql_fetch_array($rt);
		$pass = $rs['password'];
		
		if($pass == $security) {
			$sql = " delete from {$tkher['aboard_memo_table']} where no=".$memo_no." and password='$security' ";
			$rt = sql_query( $sql );
			m_(" delete OK! " . $call_pg);
			$rungo = $call_pg . "?infor=" . $infor . "&list_no=". $list_no . "&page=".$page;
			echo "<script>window.opener.location.reload();;</script>";
			echo "<script>window.close();</script>";
			exit;
		} else {
			m_("The password is incorrect. ");
		}*/
		//Record Find Error! email: solpakan59@gmail.com, password: modumoa
		$chkpass = " ";
		$get_email = $_POST['get_email'];
		$get_password = $_POST['get_password'];
		//if( $mf_infor[47] == 1 ) $chkpass = " and email='$get_email' and password='$get_password' ";
		if( $H_LEV > 7 ) $chkpass = " ";
		else if( $H_ID == $mf_infor[53] ) $chkpass = " ";	// 53:make_id board maker
		else if( $H_ID !== '' ) $chkpass = " and id='$H_ID' ";
		else if( $mf_infor[47] == 1 ) $chkpass = " and email='$get_email' and password='$get_password' ";
		$query="SELECT * from aboard_".$mf_infor[2]." where no=".$list_no." $chkpass ";
		//$mq =sql_query($query); //sql_fetch_array($mq);
		$rs =sql_fetch( $query ); 
		if( isset($rs['target']) ){
			$target = $rs['target'];
			$step   = $rs['step'];
			$re     = $rs['re'];
		}
		//$mn =sql_num_rows($mq);
		if( isset($rs['step']) ){ //if( $mn){
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
					//$query ="delete from kapp_aboard_memo where board_name='$a' and list_no=".$n;
					//$del_ok =sql_query($query);
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
					$query ="delete from kapp_aboard_memo where board_name='$a' and list_no=$n";
					$del_ok =sql_query($query);
				}
				$sql = "delete from aboard_".$mf_infor[2]." where ( target=$target and step=$step and re=$re) or (target=$target and re > $re) ";
				$del_ok =sql_query($sql);
			}
			
			m_("--- delete ok!");
			//echo "<script>alert('delete ok! '); location.href='listD.php?infor=$infor&page=$page&menu_mode=$menu_mode&search_choice=$search_choice&search_text=$search_text';</script>";
			echo "<script>cl();</script>";
			exit;


		} else {
			echo "query: " . $query;exit;
			m_("Record Find Error! email: $get_email, password: $get_password");
			//echo "<script>alert('Record Find Error! email:$get_email, password=$get_password );</script>";
			//echo "<script>location.href='listD.php?infor=$infor&page=$page&menu_mode=$menu_mode&search_choice=$search_choice&search_text=$search_text';</script>";
			echo "<script>cl();</script>";
			exit;
		}

	}

?>

 <BODY>
  	<form name='pass_form' action='<?=$PHP_SELF?>' method='post' >
		<input type='hidden' name='page' 		value='<?=$page?>' >
		<input type='hidden' name='call_pg' 	value='<?=$call_pg?>' >
		<input type='hidden' name='mode' 		value='<?=$mode?>' >
		<input type='hidden' name='infor' 		value='<?=$infor?>' >
		<input type='hidden' name='list_no' 	value='<?=$list_no?>' >
		<!-- <input type='hidden' name='memo_no' 	value='<?=$memo_no?>' >
		<input type='hidden' name='board_name'	value='<?=$board_name?>' > -->
		
		Please enter the password you entered at the time of creation.<br>
		email : <input type='text' name='get_email' ><br>
		password : <input type='password' name='get_password' size=10>
		<input type='button' value='Confirm' onclick='check_func();'>
		<input type='button' value='back' onclick='back_func()'>
</form>

 </BODY>
</HTML>
