<?php
include_once('../tkher_start_necessary.php');

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID	= get_session("ss_mb_id");	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL = $member['mb_email'];
	else $H_EMAIL = '';
/*
treebom_insert2_book_menu.php 에서 실행한다, : 20220509 보완함.
	- /contents/index.php and infor.php, board_data_listTT.php 에 $_SESSION['infor'] add : 21-07-05

*/
	if( isset($_REQUEST['infor']) )	$infor = $_REQUEST['infor'];
	else if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	else $infor = '';
	$_SESSION['infor'] = $infor;

	if( isset($_REQUEST['no']) ) $no = $_REQUEST['no'];
	else if( isset($_POST['no']) ) $no = $_POST['no'];
	else $no = '';
	if( isset($_REQUEST['list_no']) ) $list_no = $_REQUEST['list_no'];
	else if( isset($_POST['list_no']) ) $list_no = $_POST['list_no'];
	else $list_no = '';

	$_SESSION['list_no'] = $list_no;
	
	include "./infor.php";

	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page =1;

	if( isset($_REQUEST['menu_mode']) ) $menu_mode = $_REQUEST['menu_mode'];
	else if( isset($_POST['menu_mode']) ) $menu_mode = $_POST['menu_mode'];
	else $menu_mode ='';
	//https://tkher.com/contents/index.php?mid=&num=tkhernaverkan164&sys_pg=&sys_menu=&sys_submenu=&pg=&jong=&title_=&link_=&target_=&target_run=my_solpa_user_r&board=tkhernaverkan164

?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="../logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<script>
	function skin_run2( v, infor ){
		document.board_infor.infor.value=infor;
		document.board_infor.action=v;
		document.board_infor.submit();
	}
</script>

    <form name='board_infor' method="POST" action="">
            <input type='hidden' name='infor'		value='<?=$infor?>'>
            <input type='hidden' name='inforT'		value='<?=$infor?>'>
            <input type='hidden' name='list_no'		value='<?=$list_no?>'>
            <input type='hidden' name='page'		value='<?=$page?>'>
			<input type="hidden" name='menu_mode'	value='<?=$menu_mode?>' />
	</form>
<?php
	$movie = $mf_infor[48];
	//m_("infor:$infor, movie : $movie, 48:" . $mf_infor[48]);
	//infor:dao1622614184, movie : , 48:
		
	$tag = '_self';
	if( $mf_infor[48] == '1' || $mf_infor[48] == '2' || $mf_infor[48] == '5' ) { // 1:general old type, 2:standard, 5:Daum
		echo "<script> skin_run2('./listD.php?infor=$infor','$infor' ); </script>";
	}else if( $mf_infor[48] == '3' ) { // 3:memo type
		echo "<script> skin_run2('board_list_memo.php?infor=$infor','$infor' ); </script>";
	}else if( $mf_infor[48] == '4' ) { // 4:image list
		echo "<script> skin_run2('list1.php?infor=$infor','$infor' ); </script>";
	} else {
		echo "<script> skin_run2('./listD.php?infor=$infor','$infor' ); </script>";
	}
?>
</body>
</html>