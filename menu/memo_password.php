<?php
	include_once('../tkher_start_necessary.php');
	include "./infor.php";

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;
	
	$mode		=$_REQUEST['mode'];
	$infor		=$_REQUEST['infor'];
	$page		=$_REQUEST['page'];
	$table_name	=$_REQUEST['table_name'];
	$list_no	=$_REQUEST['list_no'];
	$memo_no	=$_REQUEST['memo_no'];

	//m_(" --- mode: $mode, PHP_SELF:$PHP_SELF");// --- mode: , PHP_SELF:/contents/memo_password.php
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
			
			//OK pass -----------------infor:112 , in_p:1111
			document.pass_form.mode.value = 'check';
	//		document.pass_form.action = 'memo_password.php';
			alert('OK pass ---------  in_p:'+in_p);//OK pass ---------  in_p:1111
			document.pass_form.submit();
		}
	}
	function check_func(){
		pass = document.pass_form.security.value;
		if( !pass ) {
			alert('Please enter a password!');
			return false;
		}
		//m=update_form.mode.value;
		//alert('m:-----------------');
		//history.back(-1);
		//cl();
		pass_form.mode.value='check_delete';
		//infor = document.pass_form.infor.value;
		//infor = reply_form.infor.value;
//		pass_form.action='password_.php';	//'board_data_listTT.php?infor' + infor;
//		document.pass_form.action='detailD.php';
		pass_form.submit();
	}
	
	function back_func(){
		//m=update_form.mode.value;
		//alert('m:-----------------');
		//history.back(-1);
		//cl();
		pass_form.mode.value='check_back';
		//infor = document.pass_form.infor.value;
		//infor = reply_form.infor.value;
//		pass_form.action='password_.php';	//'board_data_listTT.php?infor' + infor;
//		document.pass_form.action='detailD.php';
		pass_form.submit();
	}
</script>

<?php
	if( $mode=='back' ){
//			$rungo = "detailD.php?infor=" . $infor . "&no=". $old_no . "&page=".$page;
			$rungo = "detailD.php?infor=" . $infor . "&page=".$page;
			echo "<script>window.open( '$rungo' , '_blank', ''); </script>";
			echo "<script>cl();</script>";
			exit;
	} else if( $mode=='check_back' ){
		$infor		=$_REQUEST['infor'];
		$page		=$_REQUEST['page'];
		$list_no	=$_REQUEST['list_no'];
			//$rungo = "detailD.php?infor=" . $infor . "&list_no=". $list_no . "&page=".$page;
			//echo "<script>window.open( '$rungo' , 'newA', ''); </script>";
			echo "<script>cl();</script>";
			exit;
	} else if( $mode=='check_delete' ){
		$infor		=$_REQUEST['infor'];
		$security	=$_REQUEST['security'];
		$page		=$_REQUEST['page'];
		$table_name	=$_REQUEST['table_name'];
		$list_no	=$_REQUEST['list_no'];
		$memo_no	=$_REQUEST['memo_no'];
		
		//m_(" $security , $memo_no");
		$sql = " select * from {$tkher['aboard_memo_table']} where no=".$memo_no;
		$rt = sql_query( $sql );
		$rs = sql_fetch_array($rt);
		$pass = $rs['password'];
		
		if($pass == $security) {

			$sql = " delete from {$tkher['aboard_memo_table']} where no=".$memo_no." and password='$security' ";
			$rt = sql_query( $sql );

			$rungo = "detailD.php?infor=" . $infor . "&list_no=". $list_no . "&page=".$page;
			echo "<script>window.open( '$rungo' , 'newA', ''); </script>";
			//echo("<meta http-equiv='refresh' content='1; URL=$rungo'>");
//			echo("<meta http-equiv='refresh' content=0;url='board_list_memo.php?infor=$infor&del_admin=$del_admin'>"); 

			m_(" delete OK! ");
			echo "<script>cl();</script>";
			exit;
		} else {
			m_("The password is incorrect. ");
		}
	} else {
		//$query="select * from aboard_".$mf_infor[2]." where no='$no'";
		//$rt=sql_query($query);
		//$rs=sql_fetch_array($rt);
		//$pass=$rs[security];
	}

?>

 <BODY>
  	<form name='pass_form' action='<?=$PHP_SELF?>' method='post' >
		<input type='hidden' name='mode' 			value='<?=$mode?>' >
		<input type='hidden' name='infor' 		value='<?=$infor?>' >
		<input type='hidden' name='list_no' 		value='<?=$list_no?>' >
		<input type='hidden' name='memo_no' 		value='<?=$memo_no?>' >
		<input type='hidden' name='table_name'	value='<?=$table_name?>' >
		<input type='hidden' name='page' 			value='<?=$page?>' >
		
		Please enter the password you entered at the time of creation.<br>
		password : <input type='password' name='security' size=10>
		<input type='button' value='Confirm' onclick='check_func();'>
		<input type='button' value='back' onclick='back_func()'>
</form>

 </BODY>
</HTML>
