<?php                                 
	include_once('./tkher_start_necessary.php');

	if(isset($_POST['mb_id'])) $mb_id_post = $_POST['mb_id'];
	else $mb_id_post = null;
	$mb_id_text = getJsonText($mb_id_post);
	$mb_id = json_decode($mb_id_text, true);

	if(isset($_POST['mb_email'])) $mb_email_post = $_POST['mb_email'];
	else $mb_email_post = null;
	$mb_email_text = getJsonText($mb_email_post);
	$mb_email = json_decode($mb_email_text, true);

	if(isset($_POST['mb_nick'])) $mb_nick_post = $_POST['mb_nick'];
	else $mb_nick_post = null;
	$mb_nick_text = getJsonText($mb_nick_post);
	$mb_nick = json_decode($mb_nick_text, true);

	if(isset($_POST['mode'])) $mode = $_POST['mode'];
	else $mode = null;

	if($mode === 'check'){
		echo json_encode( exist_mb_id($mb_id, $mb_email, $mb_nick));
	}

	function exist_mb_id($reg_mb_id, $reg_mb_email, $reg_mb_nick)
	{
		global $tkher;

		$reg_mb_id = trim($reg_mb_id);
		$reg_mb_email = trim($reg_mb_email);
		$reg_mb_nick = trim($reg_mb_nick);

		$sql = " select count(*) as cnt from {$tkher['tkher_member_table']} where mb_id = '".$reg_mb_id."' ";
		$row = sql_fetch($sql);
		if( $row['cnt'] > 0) return "This is a member ID already in use."; //, 이미 사용중인 회원아이디 입니다.
		$sql = " select count(*) as cnt from {$tkher['tkher_member_table']} where mb_email = '$reg_mb_email' ";
		$row = sql_fetch($sql);
		if( $row['cnt'] > 0) return "This is a member E-mail already in use."; //, 이미 사용중인 E-mail 주소입니다.
		$sql = " select count(*) as cnt from {$tkher['tkher_member_table']} where mb_nick = '$reg_mb_nick' ";
		$row = sql_fetch($sql);
		if( $row['cnt'] > 0) return "This is a member Nickname already in use."; //, 이미 존재하는 닉네임입니다.
		return;
	}

?>