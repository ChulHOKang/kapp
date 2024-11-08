<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");   //"ss_mb_id";
	$H_EMAIL= $member['mb_email'];
	connect_count($host_script, $H_ID, 0,$referer);	// log count
	/*
		2021-04-08
		ulist.php : table-job_link_table
		cratree_my_list_menu.php - inc menu_run.php - search call

	*/
	$day = date("Y-m-d H:i:s");
	$target_	= $_POST['target_'];
	if( !$target_) $target_ = 'iframe_url';	//table_main
	$type_ = 'U';
	$from_session_url = $_SERVER['HTTP_HOST'];
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<style>
table { border-collapse: collapse; }
/*th { background: #cdefff; height: 32px; } */
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }

	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		/*flex-direction: row;*/							/* row, row-reverse, column, column-reverse */
		/*flex-wrap: nowrap;*/							/* nowrap, wrap, wrap-reverse */
		justify-content: space-between;		/* flex-start, flex-end, center, space-between, space-around */
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
		align-items: center;							/* flex-start, flex-end, center, baseline, stretch */
		height:25px;

	}
	.item {
		background-color: gold;
		boarder: 1px solid gray;
	}
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script>
$(function () {
  $('table.floating-thead').each(function() {
    if( $(this).css('border-collapse') == 'collapse') {
      $(this).css('border-collapse','separate').css('border-spacing',0);
    }
    $(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
  });
  $(window).scroll(function() {
    var scrollTop = $(window).scrollTop(),
      scrollLeft = $(window).scrollLeft();
    $('table.floating-thead').each(function(i) {
      var thead = $(this).find('thead:last'),
        clone = $(this).find('thead:first'),
        top = $(this).offset().top,
        bottom = top + $(this).height() - thead.height();

      if( scrollTop < top || scrollTop > bottom ) {
        clone.hide();
        return true;
      }
      if( clone.is('visible') ) return true;
      clone.find('th').each(function(i) {
        $(this).width( thead.find('th').eq(i).width() );
      });
      clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
    });
  });
});
</script>
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/ui.js"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/common.js"></script>
</head>

<?php
	$url = "ulist.php";
	$ss_mb_id		= get_session("ss_mb_id");   //"ss_mb_id";
	$ss_mb_level	= $member['mb_level'];    //get_session("ss_mb_level");   //"ss_mb_id";
	$H_ID			= $ss_mb_id;
	$H_LEV			= $ss_mb_level;
	$g_type			= $_REQUEST["g_type"];
	$g_name_old		= $_POST["g_name_old"];
	$g_name			= $_POST["g_name"];
	$sel_num		= $_POST["sel_num"];
	$gnm = $_POST["g_name"];	//2018-07-13
	if( !$gnm ) {
	} else {
		$aa = explode(':', $_POST["g_name"]);
		$g_name = $aa[0];
		$g_num = $aa[1];
		$gg_user = $aa[2];
		$g_no = $aa[3];
	}
	$memo			= $_POST["memo"];
	$mode_up		= $_POST["mode_up"];
	$mode_in		= $_POST["mode_in"];
	$mode			= $_POST["mode"];
	$sdata			= $_POST["sdata"];
	$data			= $_POST["sdata"];
	$page			= $_POST['page'];
	//m_( $mode . ", g_type:". $g_type .", g_name:" . $gnm.", num:". $sel_num );
	//insert_url_data, g_type:, g_name:, num:moado.net DB
	//, g_type:, g_name:, num:sel_num

	if( $mode == 'insert_group1') {
		$g_num = $H_ID . time();
		if ( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$ls = "SELECT * from {$tkher['url_group_table']} where g_name='$g_name' and user_id='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if($rs) {
			echo "<script>alert('\'$g_name\' Already exists. 이미 존재합니다');history.back();</script>";
		} else {
			$ls = "insert into {$tkher['url_group_table']} set g_name='$g_name', g_num='$g_num', user_id='$H_ID' ";
			$result = sql_query( $ls );
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}
	else if($mode == 'update_group1') {
		if ( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		} else {
			$g_name = $_POST['g_name'];
			$g_name_update = $_POST['g_name_update'];
			$sql = "update {$tkher['url_group_table']} set g_name='$g_name_update' where g_name='$g_name' and user_id='$H_ID' ";
			$rs = sql_query(  $sql );
			$url = "ulist.php?g_name=".$g_name_update;
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}
	else if( $mode == 'delete_g_name') {
		if( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "delete from {$tkher['url_group_table']} where g_name='$g_name' and user_id='$H_ID'" );
	}
	else if( $mode == 'insert_num') {
		if( !$H_ID ) {
			echo "<script>alert('Member Login! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "SELECT * from {$tkher['url_group_table']} where g_name='$g_name' and g_num='$num'" );
		$rs = sql_num_rows($result);
		if( $rs) {
			echo "<script>alert('\'$g_name\' \'$num\' Item already exists');history.back();</script>";
		} else {
					$result = sql_query(  "insert into {$tkher['url_group_table']} set g_name='$g_name', g_num='$num'" );
			echo "<script>location.href('ulist.php?g_name=$g_name');</script>";
		}
		exit;
	}
	/*else if( $mode == 'delete_link') {
		if( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		} else {
			$num=$_POST['num'];
			$webnum=$_POST['webnum'];
			$g_name=$_POST['name'];
			$result = sql_query( "delete from {$tkher['job_link_table']} where user_id='$H_ID' and seqno='$num'" );
			if($H_LEV > 7 ) $chkpass = " ";
			else $chkpass = " and user='$H_ID' ";
			$query="SELECT * from {$tkher['webeditor_table']} where num='$webnum' $chkpass ";
			$mq=sql_query($query);
			$mn=sql_num_rows($mq);
			if($mn){
				$rs=sql_fetch_array($mq);
				$dir = substr($rs['date'],0,7);

				if( $rs['up_file'] != ""){
					$del_file = "../contents/webeditor/". $dir . "/" . $rs['up_file'];
					exec ("rm $del_file");
				}
				$result = sql_query( "delete from {$tkher['webeditor_table']} where num='$webnum'" );
			}
			echo "<script>location.href('ulist.php?g_name=$g_name');</script>";
		}
	}*/
	else if($mode == 'update_link') {
		$seq_no = $_POST['seq_no'];
		if ( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$result	= 		$result = sql_query( "select * from {$tkher['job_link_table']} where seqno='$seq_no'" );
		$rs		= sql_fetch_array($result);
		$title_	= $rs['user_name'];
		$link_	= $rs['job_addr'];
		$g_name	= $rs['job_name'];	// =job_group
		$lev	= $rs['job_level'];
		$jong	= $rs['jong'];
		$memo	= $rs['memo'];
	}
	else if( $mode == 'insert_url_data') {
		if( !$H_ID || $H_LEV < 2) {
			echo "<script>alert('Member Login! Please!'); window.open('/', '_self', '');</script>";
		}
		$up_day  = date("Y-m-d H:i:s",time());

		$board_num  = 'U';
		$table_name = 'Ulist single';
		if( !$_POST["sele_group_"] ) {
			$g_name = 'etc';
		} else {
			$aa = explode(':', $_POST["sele_group_"]);
			$g_name = $aa[0];
			$g_num = $aa[1];
			$gg_user = $aa[2];
			$g_no = $aa[3];
		}
		$num		= $_POST['sel_num'];
		$Post_url_	= $_POST['url_link_'];  // url
		$gong_num = $_POST['gong_num'];
		$memo		= $_POST['memo'];
		$job_label	= $gong_num;
		$jong	= 'U';	                   //  tree가아닌 개별등록...
		$ip = $_SERVER['REMOTE_ADDR'];
		$job_group = $g_name;
		/*
		$result = sql_query("SELECT * from  {$tkher['job_link_table']} where user_id='$H_ID' and user_name='$num' and job_addr='$Post_url_' ");
		$tot = sql_num_rows($result);
		if( $tot < 1 ) {
			$up_day = date("Y-m-d H:i:s");
			$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', email='$H_EMAIL', club_url='$from_session_url', user_name='$num', job_name='$g_name', job_group='$g_name', job_addr='$Post_url_', job_level='$job_label', jong='$jong', memo='$memo', ip='$ip', num='$table_name', up_day='$up_day', aboard_no='$board_num' ";
			sql_query(  $sqlA );
		}*/
		//$sql= " update g5_member set mb_point=mb_point+1 where mb_id = '$ss_mb_id' ";
		//sql_query($sql);
		//insert_url_func g_class:https://u07031000-l20-002.iwinv.kr/webmysql/phpMyAdmin/index.php?route=/sql&server=1&db=ledsignart&table=kapp_sys_menu_bom&pos=0
		//m_( "b_num:".$board_num . ", num:". $num. ", url:". $Post_url_. ", t_nm:". $table_name. ", j_g:". $job_group. ", gnm:". $g_name. ", j:". $jong);

		//Warning: mysqli_num_rows() expects parameter 1 to be mysqli_result, bool given in /home1/ledsignart/public_html/kapp/include/lib/my_func.php on line 1768

//sql: insert into set user_id='dao', email='crakan59@gmail.com', job_name='mylist', user_name='Title moado.net DB', num='U', aboard_no='Ulist single', job_addr='https://u07031000-l20-002.iwinv.kr/webmysql/phpMyAdmin/index.php', jong='U', job_group='mylist', club_url='moado.net', job_level='0', ip='180.228.134.144', up_day='2024-05-08 16:03:44'

		
		job_link_table_add( $board_num, $num, $Post_url_, $table_name, $job_group, $g_name, $jong );
		insert_point_app( $H_ID, $config['kapp_write_point'], $Post_url_, 'url_link@ulist_admin', $g_name, $table_name);
		echo "<script>location.href('ulist.php?g_name=$g_name');</script>";
	}
	if( $mode_up == 'Save_encrypted_run') {
		if( !$H_ID ) {
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$link_ = $_POST['url_link_'];
		$title_ = $_POST['sel_num'];
		$str = $_POST['memo'];
		$secret_key = $_POST['form_psw'];
		$memo = Encrypt($str, $secret_key, $link_secret_iv);
		$encrypted_check = 'Link_Encrypted_OK';
	}
	else if($mode_up == 'Decryption_run') {
		if( !$H_ID ) {
			echo "<script>alert('Please login'); window.open('/', '_self', '');</script>";
		}
		$link_ = $_POST['url_link_'];
		$title_ = $_POST['sel_num'];
		$encrypted = $_POST['memo'];
		$secret_key = $_POST['form_psw'];
		$memo = Decrypt($encrypted, $secret_key, $link_secret_iv);
	}
	else if ( $mode_up == 'update_link_run') {
		if( !$H_ID ) {
			echo "<script>alert('Please log in'); window.open('/', '_self', '');</script>";
		}
		$sele_group_	= $_POST['sele_group_'];
		if( !$_POST["sele_group_"] ) {
			$g_name = 'etc';
		} else {
			$aa = explode(':', $_POST["sele_group_"]);
			$g_name		= $aa[0];
			$g_num		= $aa[1];
			$gg_user	= $aa[2];
			$g_no		= $aa[3];
		}
		$title_		= $_POST['sel_num'];		// title
		$seq		= $_POST['seq_no'];
		$url_		= $_POST['url_link_'];  // url
		$job_label	= $_POST['job_label'];
		$gong_num	= $_POST['gong_num'];
		$memo		= $_POST['memo'];			// memo
		$sql = "update job_link_table set user_name='$title_', job_name='$g_name', job_addr='$url_', job_group='$g_name', memo='$memo' where seqno='$seq' ";
		$result = sql_query(  $sql );
		$memo='';
		$title_='';
		echo "<script>location.href('ulist.php?g_name=$g_name');</script>";
	}
?>
<script language='javascript'>
<!--
	function insert_group1_func() {
		form = document.insert_form;
		if(!form.g_name.value) {
			alert('Please enter group name to add ');
			form.g_name.focus();
			return;
		}
		form.mode.value = 'insert_group1';
		document.insert_form.submit();
	}
	function update_group2_func() {
		form = document.insert_form;
		if(!form.g_name_update.value) {
//			alert('Please enter the group name to be changed \n 변경할 그룹명칭을 입력하세요');
			alert('Please enter the group name to be changed ');
			form.g_name_update.focus();
			return false;
		}
		g_name_update = form.g_name_update.value;
		if( confirm( 'Do you want to change it? ' + g_name_update ) ) {
			form.mode.value	= 'update_group1';
			document.insert_form.submit();
		}
		else return false;;
	}
	function check_enter() { if (event.keyCode == 13) { search_func(); } }
	function delete_g_name_func() {
		form = document.insert_form;
		if(!form.sele_group_.value) {
			alert('삭제할 그룹을 선택하세요');
			form.sele_group_.focus();
			return;
		}
		g_name = form.sele_group_.value;
		location.href="ulist.php?mode=delete_g_name&g_name="+g_name;
	}
	function change_g_name_func(g_nm) {
		g_name = g_nm;
		var gg = g_nm.split(":");
		g_name2 = gg[0];
		g_num = gg[1];
		g_id = gg[2];
		g_no = gg[3];
		document.insert_form.g_name.value = gg[0];
		document.insert_form.g_name_update.value = gg[0];
	}
	function search_func() {
		form = document.insert_form;
		if(!form.sel_num.value) {
//			alert('Enter the subject name to search and press the search button worm! \n 검색할 제목명을 입력하시고 검색버턴울 눌러주세요! ');
			alert('Enter the subject name to search and press the search button worm! ');
			form.sel_num.focus();
			return;
		}
		form.mode.value="search_rtn";
		form.submit();
	}
	function insert_url_func() {
		form = document.insert_form;
		if(!form.sele_group_.value) {
		}
		if(!form.sel_num.value) {
			alert('Please enter a title');
			form.sel_num.focus();
			return;
		}
		if(!form.url_link_.value) {
			alert('Enter URL');
			form.url_link_.focus();
			return;
		}
		form.mode.value = 'insert_url_data';
		g_name		= form.sele_group_.value;
		num			= form.sel_num.value;
		g_class		= form.url_link_.value;
		gong_num	= form.gong_num.value;
		form.submit();
	}
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, ulist.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
	function call_pg_select( link_, id, group, title_, jong, num, aboard_no, seqno) {
        //if(jong=='M') link_='/t/menu/' + id + '/' + num + '_r1.htm'; // add M=menu
		document.coinview_form.link_.value =link_;
		document.coinview_form.mid.value   =id;
		document.coinview_form.group.value =group;
		document.coinview_form.title_.value=title_;
		document.coinview_form.jong.value  =jong;
		document.coinview_form.num.value   =num;
		document.coinview_form.aboard_no.value =aboard_no;
		document.coinview_form.seqno.value =seqno;
        //if(jong=='M') document.coinview_form.action='./menu/cratree_coinadd_menu.php';
		//else document.coinview_form.action='./cratree_coinadd_menu.php';
		//document.coinview_form.action='./cratree_coinadd_menu.php';
        document.coinview_form.action='./cratree_coinadd_menu.php';
		 // coin_add.php는_run.html의 사용자소스에서 사용하고 시스템용과 분리한다.
		document.coinview_form.target='_blank';
		document.coinview_form.submit();
	}
	//------------ tree -------------
	function call_pg_selectT( link_, mid, group, title_, jong, num, aboard_no, seqno) {
		if ( link_.indexOf( 'contents_view_menu.php') >= 0 ) {

			if( jong=='M' || jong=='T' || jong=='B') {
				//link_='../tree_menu_guest.php?sys_pg=' + num + '&doc_num=' + aboard_no+ '&mid=' + mid+ '&link_=' + link_;
				link_='./tree_run.php?sys_pg=' + num + '&doc_num=' + aboard_no+ '&mid=' + mid+ '&link_=' + link_;
				// 실행 위치가 /cratree_coinadd_menu.php 여기 이므로 ../tree_menu_guest.php 주의.
			}
		}
		document.coinview_form.link_.value =link_;
		document.coinview_form.mid.value   =mid;
		document.coinview_form.group.value =group;
		document.coinview_form.title_.value=title_;
		document.coinview_form.jong.value  =jong;
		document.coinview_form.num.value   =num;
		document.coinview_form.aboard_no.value =aboard_no;
		document.coinview_form.seqno.value =seqno;
		document.coinview_form.action='./cratree_coinadd_menu.php';
		document.coinview_form.target='_blank';
		document.coinview_form.submit();
	}
	function contents_del( num, g_name, webnum ) {
		if( confirm('Are you sure you want to delete? '+num) ) {
			insert_form.mode.value='delete_link';
			insert_form.num.value=num;
			insert_form.webnum.value=webnum;
			insert_form.g_name.value=g_name;
			insert_form.submit();
		}
	}
	function contents_upd( seq_no, g_name, webnum ) {
		form = document.insert_form;
		form.seq_no.value=seq_no;
		form.webnum.value=webnum;
		form.g_name.value=g_name;
		form.mode.value = "update_link";
		form.submit();
	}
	function contents_upd_run() {
		form = document.insert_form;
		seq_no=form.seq_no.value;
		if( confirm('Do you want to change '+seq_no ) ) {
			form.mode_up.value = "update_link_run";
			form.mode.value = "";
			form.submit();
		}
	}
	function Cancle_run() {
		window.open('/','_top','');
	}
	function Save_encrypted() {
		form = document.insert_form;
		memo=form.memo.value;
		if( !memo ) { alert(' Please enter your memo! '); return false; }
		psw=form.form_psw.value;
		if( !psw ) { alert(' Please enter your passkey! '); return false; }
		//if( confirm('Do you want to encrypt and save the note? passkey='+psw + ' \n If you forget your passkey, you will not be able to recover it. \n 메모를 암호화하여 저장하시겠습니까? \n 암호키를 잊어버리면 복구가불가능합니다. ') ) {
		if( confirm('Do you want to encrypt and save the note? passkey='+psw + ' \n If you forget your passkey, you will not be able to recover it. ') ) {

			if ( !(form.mode.value == "update_link") ) form.mode.value = "";
			form.mode_up.value = "Save_encrypted_run";
			form.submit();
		}
	}
	function Decryption() {
		form = document.insert_form;
		memo = form.memo.value;
		if( !memo ) { alert(' Please enter your memo! '); return false; }
		psw=form.form_psw.value;
		if( !psw ) { alert(' Please enter your passkey! '); return false; }

		if ( !(form.mode.value == "update_link") ) form.mode.value = "";
		form.mode_up.value = "Decryption_run";
		form.submit();
	}
//-->
</script>
<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/include/css/dddropdownpanel.css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/dddropdownpanel.js"></script>
<body>
<?php
		$cur='B';
		include_once( KAPP_PATH_T_ . "/menu_run.php");
?>
<form action='ulist.php' method='post' name='insert_form' >
	<input type='hidden' name='g_type'			value='<?=$g_type?>' >
	<input type='hidden' name='g_name_old'	value='<?=$g_name?>' >
	<input type='hidden' name='g_user'			value='<?=$g_user?>' >
	<input type='hidden' name='mode_in'		value='' >
	<input type='hidden' name='mode_up'		value='' >
	<input type='hidden' name='seq_no'			value='<?=$_POST['seq_no']?>' >
	<input type='hidden' name='page'			value='<?=$page?>' >
	<input type='hidden' name='mode'			value='<?=$mode?>' >
	<input type='hidden' name='pg_'				value='<?=$url?>' >
	<input type='hidden' name='target_'			value='<?=$target_?>' >
	<input type='hidden' name='type_'			value='<?=$type_?>' >
	<input type='hidden' name='data'			value='<?=$data?>' >
	<input type='hidden' name='num'				value='' >
	<input type='hidden' name='webnum'			value='' >
<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<table border='0' bgcolor='#cccccc' width='100%'>
	<?php
	$sele_group_ = $_POST['sele_group_'];
	?>
	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Group</td>
		<td bgcolor='#ffffff'>&nbsp;
			<select name='sele_group_' onchange="change_g_name_func(this.value);">
				<option value=''>Group URL</option>
				<option value='mylist'>mylist</option>
				<option value='program' <?php if($sele_group_=='program') echo "selected"; ?>>program</option>
<?php
					$result = sql_query( "select no, g_num, g_name, user_id from {$tkher['url_group_table']} where user_id='$H_ID' order by g_name asc" );
					while( $rs = sql_fetch_array($result)) {
						if( $temp_g_name != $rs['g_name']) {
							$temp_g_name = $rs['g_name'];
?>
							<option value='<?=$rs['g_name']?>:<?=$rs['g_num']?>:<?=$rs['user_id']?>:<?=$rs['no']?>' <?php if( $rs['g_name']==$g_name) echo "selected"; ?>><?=$rs['g_name']?></option>
<?php
						}
					}
?>
			</select>

<?php
		if( $H_ID ) {
?>
				&nbsp; &nbsp;
				<input type='text' name='g_name' size='10' value=''>
				<input type='button' onclick="javascript:insert_group1_func();" value='Group-Insert'>
				&nbsp; &nbsp;
<?php
				if( $H_LEV > 7 or $H_ID == $gg_user) {
?>
					<input type='text' name='g_name_update' size='10' value='<?=$g_name?>' >
					<input type='button' value='Group-Update' onclick="javascript:update_group2_func();">
<?php
				}
		} else {
?>
				You can register after login.
<?php
		}
?>
		</td>
	</tr>
	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; URL </td>
		<td bgcolor='#ffffff'>&nbsp;
			<input type='text' name='url_link_' size='70' maxlength='550'  value='<?=$link_?>'>
					&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Memo</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp;
			<input type='text' name='memo' size='70' maxlength='255' value='<?=$memo?>'> &nbsp;&nbsp;&nbsp;
			<input type='hidden' name='encrypted_check' value=''>
			<br> &nbsp; Encryption key:<input type='password' name='form_psw' size='4' value=''>
				 &nbsp; <input type='button'  onclick="javascript:Save_encrypted();" value='Encryption' style="border-style:;background-color:red;color:yellow;height:25;">
				 &nbsp; <input type='button'  onclick="javascript:Decryption();" value='Decryption' style="border-style:;background-color:blue;color:yellow;height:25;">
			<br> &nbsp; Encrypt and save notes.
			<br> &nbsp; The encryption key is not stored and should be remembered.
			<br> &nbsp; If you forget the key, the memo can not be decrypted.
			<!--<br> &nbsp; 메모를 암호화하여저장합니다. <br> &nbsp; 암호키는 저장되지않으며 잘기억해두어야합니다.
			<br> &nbsp; 키를 잊어버리면 메모는 복호화가 불가능합니다.-->
		</td>
	</tr>
	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Title</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp;
			<input type='hidden' name='gong_num' value='0'>
			<input type='text' name='sel_num' size='20' value='<?=$title_?>' onKeyDown="check_enter()" >
<?php if($H_ID) { ?>
			<!-- update 일때 값을가져온다. -->
				&nbsp;<input type='button'  onclick="javascript:search_func();" value='Search'>
<?php if ( $mode == 'update_link') { ?>
			<input type='button'  onclick="javascript:contents_upd_run();" value='Save Changes' style="border-style:;background-color:blue;color:yellow;height:25;">
			<input type='button'  onclick="javascript:Cancle_run();" value='Cancel Change' style="border-style:;background-color:red;color:yellow;height:25;">
<?php } else { ?>
			<input type='button'  onclick="javascript:insert_url_func();" value='Save' style="border-style:;background-color:green;color:yellow;height:25;" title='Save the link.'>
			<!-- <a onclick="javascript:insert_url_func();" style="border-style:;background-color:green;color:yellow;height:25;" title='Save the link.'>Save</a> -->
			User:<?=$H_ID?>
<?php } ?>
<?php } ?>
		</td>
	</tr>
	</form>
</table>
</div>
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/kancss.css" type="text/css">
<div id="mypaneltab" class="ddpaneltab" >
<a href="#" ><span style="border-style:;background-color:;color:yellow;">URL link registration</span> </a>
</div>
</div>

 <!-- 
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, ulist.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
 -->
<form name='coinview_form' method='post' >
	<input type='hidden' name='table_name'	value='' >
	<input type='hidden' name='mid'			value='' >
	<input type='hidden' name='seqno'		value='' >
	<input type='hidden' name='link_'		value='' >
	<input type='hidden' name='title_'		value='' >
	<input type='hidden' name='group'		value='' >
	<input type='hidden' name='jong'		value='' >
	<input type='hidden' name='num'			value='' >
	<input type='hidden' name='aboard_no'	value='' >
<table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
	<tr>
		<td align='left' colspan='9'>
			<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="./ulist.php" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Group View [▼]</b></font>
				</a>
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
				if( $g_user or $H_ID ) {
					$sql = "SELECT * from {$tkher['url_group_table']} where user_id='$H_ID' order by g_name ";
					$ttt = "my-list";
				}	else {
					$sql = "SELECT * from {$tkher['url_group_table']} order by g_name ";
					$ttt = "all-list";
				}
?>
				<tr>
				<td width='130' height='24' background='<?=KAPP_URL_T_?>/icon/admin_submenu.gif'>&nbsp;
					<img src='<?=KAPP_URL_T_?>/icon/left_icon.gif'>
					<a href="./ulist.php?g_type=mylist" target='iframe_url'>&nbsp;
					<font color='blue'>URL <?=$ttt?></a>
				</td>
				</tr>
		<tr>
		<td width='130' height='24' background='<?=KAPP_URL_T_?>/icon/admin_submenu.gif'>&nbsp;<img src='<?=KAPP_URL_T_?>/icon/left_icon.gif'>
		<a href="ulist.php?g_type=P" target='iframe_url'>Program list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='<?=KAPP_URL_T_?>/icon/admin_submenu.gif'>&nbsp;<img src='<?=KAPP_URL_T_?>/icon/left_icon.gif'>
		<a href="ulist.php?g_type=D" target='iframe_url'>Note list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='<?=KAPP_URL_T_?>/icon/admin_submenu.gif'>&nbsp;<img src='<?=KAPP_URL_T_?>/icon/left_icon.gif'>
		<a href="ulist.php?g_type=G" target='iframe_url'>Board list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='<?=KAPP_URL_T_?>/icon/admin_submenu.gif'>&nbsp;<img src='<?=KAPP_URL_T_?>/icon/left_icon.gif'>
		<a href="ulist.php?g_type=T" target='iframe_url'>Link list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='<?=KAPP_URL_T_?>/icon/admin_submenu.gif'>&nbsp;<img src='<?=KAPP_URL_T_?>/icon/left_icon.gif'>
		<a href="ulist.php?g_type=M" target='iframe_url'>Menu list</a>
		</td>
		</tr>
<?php
//https://moado.net/kapp/menu/icon/Uleaf.png
	$result = sql_query(  $sql );
	$j=0;
	while ( $rs = sql_fetch_array( $result )  ) {
?>
		<tr>
		<td width='130' height='24' background='<?=KAPP_URL_T_?>/icon/admin_submenu.gif'>&nbsp;<img src='<?=KAPP_URL_T_?>/icon/left_icon.gif'>
		<a href="ulist.php?g_name=<?=$rs['g_name']?>:<?=$rs['user_id']?>" target='iframe_url'><?=$rs['g_name']?></a>
		</td>
		</tr>
<?php
	}
?>
			</TABLE>
		<div align="right"><a href="javascript:dropdowncontent.hidediv('subcontent2')">Hide </a></div>
		</DIV>
		<script type="text/javascript">
			dropdowncontent.init("searchlink", "left-bottom", 800, "mouseover")
			dropdowncontent.init("contentlink", "right-bottom", 800, "click")
		</script>
		</td>
	</tr>
<?php
		$limite = 10;
		$page_num = 10;
		if($mode == 'search_rtn') {
			$sdata = $sel_num;
		}
		$urlT='http://127';			// mylist에만 다나온다.
		$url9='http://192';			// mylist에만 다나온다.
		$w = " ";
		$w1= " ";
		$w2 = " ";
		//m_("g_name: " . $g_name . ", " . $_REQUEST['g_type'] );
		if( $g_name=='mylist' && $sdata ) {
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE user_id='$H_ID' and user_name like '%$sdata%' ";
		} else if( $_REQUEST['g_type'] =='mylist' ) { // all
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} ";
		} else if( $_REQUEST['g_type']=='M' ) { // menu
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE job_group='menu' ";
		} else if( $_REQUEST['g_type']=='T' ) { // link T, U
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE jong='T' or jong='U' ";
		} else if( $_REQUEST['g_type']=='G' ) { // 게시판 A, [G, F]:tkher_bbs/bbs_listTT.php
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE jong='G' or jong='A' or jong='F' ";
		} else if( $_REQUEST['g_type']=='D' ) { // Note D, B:webeditor content
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE jong='D' or jong='B' ";
		} else if( $_REQUEST['g_type']=='P' ) {
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE jong='p' ";
		} else if( $g_type=='mylist' or $g_name=='mylist' ) {
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE user_id='$H_ID' $w1 ";
		} else if( $g_name && $sdata ) {
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') and user_name like '%$sdata%' $w ";
		} else if( $g_name ) {
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') $w1 ";
		} else if( $sdata ) {
				$ls = "SELECT job_addr FROM {$tkher['job_link_table']} WHERE user_name like '%$sdata%' ";
		} else{
			$ls = "SELECT job_addr FROM {$tkher['job_link_table']} ";
		}
		$result = sql_query( $ls );
		$total = sql_num_rows($result);
		if(!$page) $page=1;
		$total_page = intval(($total-1) / $limite)+1;
		$first = ($page-1)*$limite;
		$last = $limite;
		if($total < $last) $last = $total;
		$limit = " limit $first,$last";
		if ($page == "1")
			$no = $total;
		else {
			$no = $total - ($page - 1) * $limite;
		}
		if( $sdata )  $g_nameX = "Search : " . $sdata;
		else if( !$g_name ) $g_nameX = " page:" . $page . ", [count:" .$total. "]";
		else $g_nameX = "Group: " . $g_name;
		if( $H_ID ) $g_nameX = $g_nameX . ", level:" . $member['mb_level'] . "," .$member['mb_email'];
?>
		<tr>
			<td bgcolor='#f4f4f4'  align='center' colspan=7><font color='black'>&nbsp;<?=$g_nameX?><!--  [count:<?=$total?>] -->
			</td>
		</tr>
<table class='floating-thead' width='100%'>
<thead  width='100%'>
		<tr align='center'>
			<TH>icon</TH>
			<TH>Group</TH>
			<TH>Title</TH>
			<!-- <TH>URL-Link </TH> -->
			<TH>view</TH>
			<!-- <TH>type</TH>-->
			<!-- <TH>User</TH> -->
			<!-- <TH>date</TH> -->
			<!-- <TH>lev</TH>-->
<?php if( $H_ID ) { ?>
			<TH>management</TH>
<?php } ?>
		</tr>
</thead>
<tbody width='100%'>
		<?php
			if ( $g_name=='mylist' && $sdata ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' and user_name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='mylist' ) { // all 
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='P' ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='P' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='D' ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='D' or jong='B' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='G' ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='G' or jong='A' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='T' ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='T' or jong='U' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='M' ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				//$ls = $ls . " WHERE jong='M' ";
				$ls = $ls . " WHERE job_group='menu' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='mylist' or $g_name=='mylist' ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' $w1 ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_name && $sdata ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') and user_name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_name ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";	//jong, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $sdata ) {
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else{
				$ls = " select * from {$tkher['job_link_table']} ";
				$ls = $ls . " ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			}
			$result = sql_query(  $ls );
			while ( $rs = sql_fetch_array( $result ) ) {
			$sys_label	= $rs['job_name'];		//  분류
			$sys_name	= $rs['user_name'];		//  타이틀명
			$sys_pgname	= $rs['job_addr'];		//	프로그램명.
			$sys_group	= $rs['job_group'];		//  프로그램 그룹.
			$view_cnt	= $rs['view_cnt'];		//
			$num		= $rs['num'];				//  생성번호.
			$unit		= $rs['price'];			//  단가
			$user_id	= $rs['user_id'];			//  작성자id
			$seqno		= $rs['seqno'];			//  작성자id
			$lev		= $rs['job_level'];		//  lev
			$gubun		= $rs['jong'];		//  lev
			$aboard_no  = $rs['aboard_no'];
			$memo       = $rs['memo'];
			$lev = $rs['job_level'];
			$url_ = substr($sys_pgname, 0, 60);
			$td_bg = '#000000';
			if( $gubun == 'T' )	{
				$icon=KAPP_URL_T_ . '/icon/berry.png'; $gubunT='T-Berry';$t_color='white'; //#9966CC
				$i_tit='T : Tree Link URL';
			} else if( $gubun == 'B' or $gubun == 'D' or $rs['job_group'] == 'DOC' )	{
				$icon=KAPP_URL_T_ . '/icon/seed.png'; $gubunT='B-Seed';$t_color='blue';// Doc
				$i_tit='D or DOC : Document';
			} else if( $gubun == 'G' or $gubun == 'A')	{
				$icon=KAPP_URL_T_ . '/icon/pizza.png'; $gubunT='D-Pizza';$t_color='blue';
				$i_tit='B : Tree Document : Ebook';
			} else if( $gubun == 'P' )	{// Program List
				$icon=KAPP_URL_T_ . '/icon/pcman1.png'; $gubunT='Program';$t_color='blue';
				$i_tit='P : Program';
			}
			else if( $gubun=='M' ){ $icon=KAPP_URL_T_ . '/icon/land.png';   $gubunT='Land';    $t_color='blue';  $i_tit='Board';} // F->M
			else if( $gubun=='U' ){ $icon=KAPP_URL_T_ . '/icon/leaf.png';   $gubunT='U-Leaf';  $t_color='yellow';$i_tit='Link URL';}
			else if( $gubun=='A' ){ $icon=KAPP_URL_T_ . '/icon/seedX.png';  $gubunT='A-board'; $t_color='yellow';$i_tit='A: A-Board';}
			//else if( $gubun=='G' ){ $icon=KAPP_URL_T_ . '/icon/ship.png';   $gubunT='Ship';    $t_color='blue';  $i_tit='Tree Board';}
			//else if( $gubun=='M' ){ $icon=KAPP_URL_T_ . '/icon/Uleaf.png';  $gubunT='one-Line';$t_color='yellow';$i_tit='M: A-Board';}
			else { $icon=KAPP_URL_T_ . '/icon/Uleaf.png'; $t_color='white'; $i_tit='else jong:'.$gubun;}
?>
				<tr valign="middle" align='left' width='30' height='20'>
				  <td align='center' bgcolor='black' width='30' height='20' title='<?=$i_tit?>'><img src='<?=$icon?>' width='30' height='20'></td>
				  <td bgcolor='<?=$td_bg?>' align='left'  width='150' title='XXX'>
					<a href="javascript:call_pg_selectT( '<?=$sys_pgname?>', '<?=$user_id?>', '<?=$sys_label?>', '<?=$sys_name?>','<?=$gubun?>','<?=$num?>','<?=$aboard_no?>', '<?=$seqno?>' )" style="border-style:;background-color:black;color:<?=$t_color?>;height:20;"  title='type:<?=$gubun?>, Tcolor:<?=$t_color?>, gT:<?=$gubunT?>'><?=$sys_label?></a></td>
				  <td bgcolor='<?=$td_bg?>' align='left' title='<?=$memo?>'>
					<a href="javascript:call_pg_select( '<?=$sys_pgname?>', '<?=$user_id?>', '<?=$sys_label?>', '<?=$sys_name?>','<?=$gubun?>','<?=$num?>','<?=$aboard_no?>', '<?=$seqno?>' )" style="border-style:;background-color:black;color:<?=$t_color?>;height:20;" title='<?=$memo?>'><?=$sys_name?></a></td>
				  <td style="border-style:;background-color:black;color:<?=$t_color?>;height:20;width:80px;" align='center'><?=$view_cnt?></td>
				  <!-- <td style="border-style:;background-color:black;color:<?=$t_color?>;height:20;" align='center'><?=$rs[up_day] ?></td> -->
			  <?php
			  if ( $H_ID ) {
			  ?>
				  <td style="border-style:;background-color:black;color:<?=$t_color?>;height:25;" align='center'>
				  <?php
				  if ( $H_ID==$rs['user_id'] or $H_LEV > 7 ) {
				  ?>
					  <!-- <input type='button' onclick="javascript:contents_del( '<?=$seqno?>', '<?=$g_name?>', '<?=$num?>' );" value='delete' style="border-style:;background-color:red;color:yellow;height:25;"> -->
					  <input type='button' onclick="javascript:contents_upd( '<?=$seqno?>', '<?=$g_name?>', '<?=$num?>' );" value='Change' style="border-style:;background-color:blue;color:yellow;height:25;">
				<?php } else { ?>
						---
			<?php }  ?>
			  </td>
			<?php } ?>
				</tr>
		<?php
			}	//Loop
		?>
		  </td>
		</tr>
		<tr align="center"></tr>
</tbody>
</table>
<table width="100%"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
$last_page = $first_page+($page_num-1);
if($last_page > $total_page) $last_page = $total_page;
$prev = $first_page-1;

if($page > $page_num) echo"[<a href=".$PHP_SELF."?page=".$prev."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >Prev</a>] ";
for($i = $first_page; $i <= $last_page; $i++)
{
	if($page == $i) echo" <b>$i</b> ";
	else echo"[<a href=".$PHP_SELF."?page=".$i."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >".$i."</a>]";
}
$next = $last_page+1;
if($next <= $total_page) echo" [<a href=".$PHP_SELF."?page=".$next."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >Next</a>]";
?>
	</td>
  </tr>
</table>
</form>
</body>
</html>
