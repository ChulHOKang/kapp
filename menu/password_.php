<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
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
			document.pass_form.action='detailD.php?infor='+infor; //'detailTT.php?infor='+infor;
			document.pass_form.target='_blank';
			document.pass_form.submit();
	}
	function pass_check(infor){
		p = pass_form.pass.value;
		in_p=pass_form.security.value;
		//alert('OK pass -----------------infor:'+infor+' , in_p:'+in_p);
		//OK pass -----------------infor:112 , in_p:1111
		document.pass_form.pass.value = pass_form.security.value;
		document.pass_form.mode.value = 'check';
		document.pass_form.action='password_.php?infor='+infor;
		document.pass_form.submit();
	}
	function back_func(){
		//m=update_form.mode.value;
		//alert('m:-----------------');
		//history.back(-1);
		//cl();
		pass_form.mode.value='back';
		//infor = reply_form.infor.value;
		pass_form.action='password_.php';	//'board_data_listTT.php?infor' + infor;
		pass_form.submit();
	}
</script>

<?php
	include_once('../tkher_start_necessary.php');
	include "./infor.php";

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;

	
	if( isset($_REQUEST[list_no]) ) {
		$list_no = $_REQUEST['list_no'];
	} else {
		$infor = $_POST['infor'];
		$list_no = $_POST['list_no'];
		$page = $_POST['page'];
	}
	
	$mode=$_POST['mode'];
	//m_("list_no:$list_no, infor:$infor, $mode");
	//list_no:27, infor:112, 
	//list_no:27, infor:112, 
	if( $mode=='back' ){
			//$rungo = "detailTT.php?infor=" . $infor . "&list_no=". $old_no . "&page=".$page;
			//$rungo = "detailTT.php?infor=" . $infor . "&page=".$page;
			//$rungo = "list1_detail.php?infor=" . $infor . "&page=".$page."&list_no=".$list_no;
			$rungo = "detailD.php?infor=" . $infor . "&page=".$page."&list_no=".$list_no;
			echo "<script>window.open( '$rungo' , '_top', ''); </script>";
			echo "<script>cl();</script>";
			exit;
	}
	if( $mode=='check' ){
		$infor	=$_POST['infor'];
		$security=$_POST['security'];
		$pass	=$_POST['pass'];
		if( $_POST['security'] == $_POST['pass'] ){
			//echo "<script>op('$infor');</script>";
			$page=$_REQUEST['page'];
			//set_session($security,'');
			$_SESSION['security']=$security;
			//$rungo = "detailTT.php?infor=" . $infor . "&list_no=". $list_no . "&page=".$page."&security=".$security;
			//$rungo = "detailTT.php?infor=" . $infor . "&list_no=". $list_no . "&page=".$page;
			$rungo = "detailD.php?infor=" . $infor . "&list_no=". $list_no . "&page=".$page;
			echo "<script>window.open( '$rungo' , 'newA', ''); </script>";
			//echo "<script>op();</script>";
			echo "<script>cl();</script>";
			exit;
		}else{
			m_("password Error! Please re-enter. ");
		}
	} else {
		$query="SELECT * from aboard_".$mf_infor[2]." where no='$list_no'";
		$rt=sql_query($query);
		$rs=sql_fetch_array($rt);
		$pass=$rs[security];
	}

?>

 <BODY>
  	<form name='pass_form' action='password_.php' method='post' >
		<input type=hidden name='mode' value='' >
		<input type=hidden name='infor' value='<?=$infor?>' >
		<input type=hidden name='no' value='<?=$list_no?>' >
		<input type=hidden name='list_no' value='<?=$list_no?>' >
		<input type=hidden name='old_no' value='<?=$old_no?>' >
		<input type=hidden name='pass' value='<?=$pass?>' >
		<input type=hidden name='page' value="<?=$_REQUEST['page']?>" >
		This is a private article. Please enter your password.<br>
		<!-- 비공개 글입니다. 패스워드를 입력하여주십시오.  -->
		password : <input type='password' name='security' size=10>
		<input type=button value='Confirm' onclick='pass_check(<?=$infor?>)'>
		<input type=button value='back' onclick='back_func()'>
</form>

 </BODY>
</HTML>
