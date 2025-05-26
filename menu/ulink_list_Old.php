<?php
	include_once('../tkher_start_necessary.php');
	 $_ID	= get_session("ss_mb_id"); 
	if( isset( $_ID) ) $H_ID	= get_session("ss_mb_id");   //"ss_mb_id";	//connect_count('ulist', $H_ID, 0);	// log count
	else $H_ID="";

	/*  
		2021-04-08
		ulink_list.php, ulist.php : table : {$tkher['job_link_table']} 
		cratree_my_list_menu.php - inc menu_run.php - search call

	*/
	$day = date("Y-m-d H:i:s");
	$pg_		= 'ulink_list.php';
	$target_	= $_POST['target_'];
	if( !$target_) $target_ = 'iframe_url';	//table_main
	$type_ = 'U';
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="../icon/logo25a.jpg">
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
<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>

<link rel="stylesheet" type="text/css" href="../include/css/dddropdownpanel.css" />
<script type="text/javascript" src="../include/js/dddropdownpanel.js"></script>

</head> 

<?php
	$ss_mb_id		= get_session("ss_mb_id");
	$ss_mb_level	= $member['mb_level']; 
	$H_EMAIL	    = $member['mb_email'];
	$H_ID				= $ss_mb_id;
	$H_LEV			= $ss_mb_level; 
	$g_type			= $_REQUEST["g_type"];
	$g_name_old	= $_REQUEST["g_name_old"];
	$g_name			= $_REQUEST["g_name"];
	$sel_num		= $_REQUEST["sel_num"];
	$gnm = $_REQUEST["g_name"];	//2018-07-13
	if( !$gnm ) {
	} else {
		$aa = explode(':', $_REQUEST["g_name"]); 
		$g_name = $aa[0];
		$g_num = $aa[1];
		$gg_user = $aa[2];
		$g_no = $aa[3];
	}
	if( isset($_REQUEST["mode"]) ) 	$mode			= $_REQUEST["mode"];
	else if( isset($_POST["mode"]) )	$mode			= $_POST["mode"];
	else	$mode			= "";

	$memo			= $_REQUEST["memo"];
	$mode_up		= $_REQUEST["mode_up"];
	$mode_in		= $_REQUEST["mode_in"];
	$sdata			= $_REQUEST["sdata"];
	$data			= $_REQUEST["sdata"];
	$page			= $_REQUEST['page'];
	if($mode == 'insert_group1') {
		$g_num = $H_ID . time();
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$ls = "select * from {$tkher['url_group_table']} where g_name='$g_name' and user_id='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if($rs) {
			echo "<script>alert('\'$g_name\' Already exists. 이미 존재합니다');history.back();</script>";
		} else {
			$ls = "insert into {$tkher['url_group_table']} set g_name='$g_name', g_num='$g_num', user_id='$H_ID' ";
			$result = sql_query(  $ls );
			$url = "ulink_list.php";
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}
	else if($mode == 'update_group1') {
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		} else {
			$g_name = $_REQUEST['g_name'];
			$g_name_update = $_REQUEST['g_name_update'];
			$sql = "update {$tkher['url_group_table']} set g_name='$g_name_update' where g_name='$g_name' and user_id='$H_ID' ";
			$rs = sql_query(  $sql );
			$url = "ulink_list.php?g_name=".$g_name_update;
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}
	else if($mode == 'delete_g_name') {
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "delete from {$tkher['url_group_table']} where g_name='$g_name' and user_id='$H_ID'" );
	}
	else if($mode == 'insert_num') {
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Member Login! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "select * from {$tkher['url_group_table']} where g_name='$g_name' and g_num='$num'" );
		$rs = sql_num_rows($result);
		if($rs) {
			echo "<script>alert('\'$g_name\' \'$num\' Item already exists');history.back();</script>";
		} else {
					$result = sql_query(  "insert into {$tkher['url_group_table']} set g_name='$g_name', g_num='$num'" );
			echo "<script>location.href('ulink_list.php?g_name=$g_name');</script>";
		}
		exit;
	}
	else if($mode == 'delete_link') {
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		} else {
			$num=$_POST['num'];
			$webnum=$_POST['webnum'];
			$g_name=$_POST['name'];
			$result = sql_query( "delete from {$tkher['job_link_table']} where user_id='$H_ID' and seqno='$num'" );
			if($H_LEV > 7 ) $chkpass = " ";
			else $chkpass = " and user='$H_ID' ";
			$query="select * from webeditor where num='$webnum' $chkpass ";
			$mq=sql_query($query);
			$mn=sql_num_rows($mq);
			if($mn){
				$rs=sql_fetch_array($mq);
				$dir = substr($rs['date'],0,7);

				if( $rs['up_file'] != ""){
					//$del_file = "../contents/webeditor/". $dir . "/" . $rs['up_file'];
					//exec ("rm $del_file");
				}
				$result = sql_query( "delete from webeditor where num=$webnum" );
			}
			echo "<script>location.href('ulink_list.php?g_name=$g_name');</script>";
		}
	}
	else if($mode == 'update_link') {
		$seq_no = $_REQUEST['seq_no'];	

		//if ( !$H_ID ) {	$url = "ulink_list.php";echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";		}
		$result	= 		$result = sql_query( "select * from {$tkher['job_link_table']} where seqno=$seq_no" );
		$rs		= sql_fetch_array($result);
		if( $rs['job_name'] =='Note' ) { // add 2025-03-30
			$sql= " update {$tkher['job_link_table']} set view_cnt=view_cnt+1 where seqno = $seq_no ";
			sql_query($sql);
			$title_	= $rs['user_name'];
			$link_	= $rs['job_addr'];
			$g_name	= $rs['job_name'];	// =job_group
			$lev	= $rs['job_level'];
			$jong	= $rs['jong'];
			$memo	= $rs['memo'];
		}
	}
	else if($mode == 'insert_url_data') {
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$up_day  = date("Y-m-d H:i:s",time());

		$board_num = 'Note';
		$table_name = 'Note';
		$create_type = 'Note';
		if( !$_POST["sel_g_name"] ) { // $_REQUEST["sel_g_name"]
			$g_name = 'ETC';
			$g_name_code = 'ETC';
		} else {
			$aa = explode(':', $_POST["sel_g_name"]);
			$g_name = $aa[0];
			$g_num = $aa[1];
			$gg_user = $aa[2];
			$g_no = $aa[3];
		}
		$num		= $_REQUEST['sel_num'];
		$g_class	= $_REQUEST['sel_g_class'];  // url
		$gong_num = $_REQUEST['gong_num'];
		$memo		= $_REQUEST['memo'];
		$job_label	= $gong_num;	              
		$jong	= 'U';	                   //  tree가아닌 개별등록...
		$ip = $_SERVER['REMOTE_ADDR'];
		$result = sql_query("select * from {$tkher['job_link_table']} where user_id='$H_ID' and user_name='$num' and job_addr='$g_class' ");
		$tot = sql_num_rows($result);
		if( $tot < 1 ) {
			$up_day = date("Y-m-d H:i:s");
			$sqlA = "insert into {$tkher['job_link_table']} set user_id='$H_ID', club_url='$from_session_url', user_name='$num', job_name='$create_type', job_group='$g_name', job_group_code='$g_name_code', job_addr='$g_class', job_level='$job_label', jong='$jong', memo='$memo', ip='$ip', num='$create_type', aboard_no='$create_type', email='$H_EMAIL', up_day='$up_day' ";
			sql_query(  $sqlA ); 
		}
		$sql= " update kapp_member set mb_point=mb_point+1 where mb_id = '$ss_mb_id' ";
		sql_query($sql);
		$memo='';
		//$runpg = "link_list2_my.php";
		//$rungo = "/cratree/r1_my.php?run=" . $runpg;
		echo "<script>location.href('ulink_list.php?g_name=$g_name');</script>";
	}
	if($mode_up == 'Save_encrypted_run') {
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$link_ = $_REQUEST['sel_g_class'];
		$title_ = $_REQUEST['sel_num'];
		$str = $_REQUEST['memo'];
		$secret_key = $_REQUEST['form_psw'];
		$memo = Encrypt($str, $secret_key, $link_secret_iv);
		$encrypted_check = 'Link_Encrypted_OK';
	}
	else if($mode_up == 'Decryption_run') {
		/*if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Please login'); window.open('$url', '_self', '');</script>";
		}*/
		$link_ = $_REQUEST['sel_g_class'];
		$title_ = $_REQUEST['sel_num'];
		$encrypted = $_REQUEST['memo'];
		$secret_key = $_REQUEST['form_psw'];
		$memo = Decrypt($encrypted, $secret_key, $link_secret_iv);
	}
	else if ( $mode_up == 'update_link_run') {
		if ( !$H_ID ) {
			$url = "ulink_list.php";
			echo "<script>alert('Please log in'); window.open('$url', '_self', '');</script>";
		}
		$sel_g_name	= $_REQUEST['sel_g_name'];
		if( !isset($_POST["sel_g_name"]) ) {
			$g_name = 'ETC';
			$sel_g_name	= 'ETC';
		} else {
			$aa = explode(':', $_POST["sel_g_name"]);
			$g_name		= $aa[0];
			$g_num		= $aa[1];
			$gg_user	= $aa[2];
			$g_no		= $aa[3];
		}
		$title_		= $_REQUEST['sel_num'];		// title
		$seq		= $_REQUEST['seq_no'];
		$url_		= $_REQUEST['sel_g_class'];  // url
		$job_label	= $_REQUEST['job_label'];
		$gong_num	= $_REQUEST['gong_num'];
		$memo		= $_REQUEST['memo'];			// memo
		$sql = "update {$tkher['job_link_table']} set user_name='$title_', job_name='$g_name', job_addr='$url_', job_group='$g_name', job_group_code='$g_name', memo='$memo' where seqno='$seq' ";
		$result = sql_query(  $sql );
		$memo='';
		$title_='';
		echo "<script>location.href('ulink_list.php?g_name=$g_name');</script>";
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
		if(!form.sel_g_name.value) {
			alert('삭제할 그룹을 선택하세요');
			form.sel_g_name.focus();
			return;
		}
		g_name = form.sel_g_name.value;
		location.href="ulink_list.php?mode=delete_g_name&g_name="+g_name;
	}
	function change_g_name_func(g_nm) {
		g_name = g_nm;
		var gg = g_nm.split(":");
		g_name2 = gg[0];
		g_num = gg[1];
		g_id = gg[2];
		g_no = gg[3];
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
		if(!form.sel_g_name.value) {
		}
		if(!form.sel_num.value) {
			alert('Please enter a title \n 제목을 입력하세요!');
			form.sel_num.focus();
			return;
		}
		if(!form.sel_g_class.value) {
			alert('Enter URL \n URL을 입력하세요');
			form.sel_g_class.focus();
			return;
		}
		form.mode.value = 'insert_url_data';
		g_name		= form.sel_g_name.value;
		num			= form.sel_num.value;
		g_class		= form.sel_g_class.value;
		gong_num	= form.gong_num.value;
		form.submit();
	}
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, ulink_list.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
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
		//else document.coinview_form.action='/cratree/coin_add_sys.php';		
		//document.coinview_form.action='/cratree/coin_add_sys.php';		
        document.coinview_form.action='./cratree_coinadd_menu.php';
		 // coin_add.php는_run.html의 사용자소스에서 사용하고 시스템용과 분리한다.
		document.coinview_form.target='_blank';
		document.coinview_form.submit();
	}
	//------------ tree -------------
	function call_pg_selectT( link_, mid, group, title_, jong, num, aboard_no, seqno) {
		if ( link_.indexOf( 'contents_view_menu.php') >= 0 ) { 

			if( jong=='M' || jong=='T' || jong=='B') {
				link_='./tree_run.php?sys_pg=' + num + '&doc_num=' + aboard_no+ '&mid=' + mid+ '&link_=' + link_;
				//link_='../tree_menu_guest.php?sys_pg=' + num + '&doc_num=' + aboard_no+ '&mid=' + mid+ '&link_=' + link_;
				// 실행 위치가 /cratree/coin_add_sys.php 여기 이므로 ../tree_menu_guest.php 주의.
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
//		document.coinview_form.action='/cratree/coin_add_sys.php';		
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
	function contents_upd( seq_no, g_name, webnum, job_addr, memo, title ) {
		//alert("seqno: " + seq_no + ", " + g_name+ ", " + webnum + ", " + title + ", " + job_addr ); //seqno: 5, , Note, test 암호화 저장, 24c.kr
		form = document.insert_form;
		form.seq_no.value=seq_no;
		form.webnum.value=webnum;
		form.g_name.value=g_name;
		form.sel_g_class.value=job_addr; // url
		form.sel_num.value=title;
		form.form_psw.value='';
		form.memo.value=memo;
		
		form.mode.value = "update_link";
		//form.submit();
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

<body>
<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>
<form action='ulink_list.php' method='post' name='insert_form' >
	<input type='hidden' name='g_type'			value='<?=$g_type?>' > 
	<input type='hidden' name='g_name_old'	value='<?=$g_name?>' > 
	<input type='hidden' name='g_user'			value='<?=$g_user?>' > 
	<input type='hidden' name='mode_in'		value='' > 
	<input type='hidden' name='mode_up'		value='' > 
	<input type='hidden' name='seq_no'			value='<?=$_REQUEST['seq_no']?>' > 
	<input type='hidden' name='page'			value='<?=$page?>' > 
	<input type='hidden' name='mode'			value='<?=$mode?>' > 
	<input type='hidden' name='pg_'				value='<?=$pg_?>' > 
	<input type='hidden' name='target_'			value='<?=$target_?>' > 
	<input type='hidden' name='type_'			value='<?=$type_?>' > 
	<input type='hidden' name='data'			value='<?=$data?>' > 
	<input type='hidden' name='num'				value='' > 
	<input type='hidden' name='webnum'			value='' > 
	<input type='hidden' name='gong_num' value='0'>

<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<table border='0' bgcolor='#cccccc' width='100%'>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Group</td>
		<td bgcolor='#ffffff'>&nbsp; 
			<select name='sel_g_name' onchange="change_g_name_func(this.value);">
				<option value=''>Group URL</option>
				<option value='mylist'>mylist</option>
				<option value='ETC' <?php if($sel_g_name=='ETC') echo "selected"; ?>>ETC</option>
				<option value='program' <?php if($sel_g_name=='program') echo "selected"; ?>>program</option>
<?php
					$result = sql_query( "select no, g_num, g_name, user_id from {$tkher['url_group_table']} where user_id='$H_ID' order by g_name asc" );
					while($rs = sql_fetch_array($result)) {
						if($temp_g_name != $rs['g_name']) {
							$temp_g_name = $rs['g_name'];
?>
							<option value='<?=$rs['g_name']?>:<?=$rs['g_num']?>:<?=$rs['user_id']?>:<?=$rs['no']?>' <?php if($rs['g_name']==$g_name) echo "selected"; ?>><?=$rs['g_name']?></option>
<?php
						}
					}
?>
			</select>

				<input type='text' name='g_name' size='10' value=''> 
<?php 
		if ( $H_ID ) { 
?>
				&nbsp; &nbsp; 
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
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Title</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp; <input type='text' name='sel_num' size='20' value='<?=$title_?>' onKeyDown="check_enter()" >
			<?php if($H_ID) { ?>
				&nbsp;<input type='button'  onclick="javascript:search_func();" value='Search'>
			<?php } ?>

		</td>
	</tr>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; URL </td>
		<td bgcolor='#ffffff'>&nbsp; <input type='text' name='sel_g_class' size='70' maxlength='550'  value='<?=$link_?>'>
		</td>
	</tr>
	
	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Memo</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp; <textarea name="memo" rows="4" cols="50"><?=$memo?></textarea>

			<input type='hidden' name='encrypted_check' value=''>
			<br> &nbsp; Encryption key:<input type='password' name='form_psw' size='4' value='<?=$secret_key?>'> 
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
		<!-- <td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Title</td> -->
		<td bgcolor='#ffffff' colspan=2><font color='black'>&nbsp; 
			<!-- <input type='text' name='sel_num' size='20' value='<?=$title_?>' onKeyDown="check_enter()" > -->
<?php if($H_ID) { ?>
<?php 
				if ( $mode == 'update_link') { ?>			
					<input type='button'  onclick="javascript:contents_upd_run();" value='Save Changes' style="border-style:;background-color:blue;color:yellow;height:25;">
					<input type='button'  onclick="javascript:Cancle_run();" value='Cancel Change' style="border-style:;background-color:red;color:yellow;height:25;">
<?php		} else { ?>			
					<input type='button'  onclick="javascript:insert_url_func();" value='Save' style="border-style:;background-color:green;color:yellow;height:25;" title='Save the link.'> User:<?=$H_ID?>
<?php		} ?>			
<?php } ?> 
		</td>
	</tr>
	</form>
</table>
</div>
<div id="mypaneltab" class="ddpaneltab" >
<a href="#" ><span style="border-style:;background-color:;color:yellow;">Note Create</span> </a>
</div>
</div>
<link rel="stylesheet" href="../include/css/kancss.css" type="text/css">
 <!-- 
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, ulink_list.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
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
			<script type="text/javascript" src="../include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="./" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Group View [▼]</b></font>
				</a> 
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
				if( $g_user or $H_ID ) {
					$sql = "select * from {$tkher['url_group_table']} where user_id='$H_ID' order by g_name ";
					$ttt = "my-list";
				}	else {
					$sql = "select * from {$tkher['url_group_table']} order by g_name ";
					$ttt = "all-list";
				}
?>
				<tr>
				<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;
					<img src='../icon/left_icon.gif'>
					<a href="./ulink_list.php?g_type=mylist" target='iframe_url'>&nbsp;
					<font color='blue'>URL <?=$ttt?></a>
				</td>
				</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list.php?g_type=P" target='iframe_url'>Program list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list.php?g_type=U" target='iframe_url'>Note list</a><!-- <a href="ulink_list.php?g_type=D" target='iframe_url'>Note list</a> -->
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list.php?g_type=G" target='iframe_url'>Board list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list.php?g_type=T" target='iframe_url'>Link list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list.php?g_type=M" target='iframe_url'>Menu list</a>
		</td>
		</tr>
<?php
	$result = sql_query(  $sql );
	$j=0;
	while ( $rs = sql_fetch_array( $result )  ) {
?>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list.php?g_name=<?=$rs['g_name']?>:<?=$rs['user_id']?>" target='iframe_url'><?=$rs['g_name']?></a>
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
		if ( $g_name=='mylist' && $sdata ) {
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_id='$H_ID' and user_name like '%$sdata%' ";
		} else if ( $_REQUEST['g_type']=='M' ) { // menu
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE job_group='menu' ";
		} else if ( $_REQUEST['g_type']=='T' ) { // link T, U
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='T' or jong='U' ";
		} else if ( $_REQUEST['g_type']=='G' ) { // 게시판 A, [G, F]:tkher_bbs/bbs_listTT.php
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='G' or jong='A' or jong='F' ";
		} else if ( $_REQUEST['g_type']=='U' ) { // Note - U
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='U' ";
		} else if ( $_REQUEST['g_type']=='D' ) { // Note D, B:webeditor content
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='D' or jong='B' ";
		} else if ( $_REQUEST['g_type']=='P' ) {
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE jong='p' ";
		} else if ( $g_type=='mylist' or $g_name=='mylist' ) {
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_id='$H_ID' $w1 ";
		} else if ( $g_name && $sdata ) {
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') and user_name like '%$sdata%' $w ";
		} else if ( $g_name ) {
			//m_(" g_name :" . $g_name);
			//	$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') $w1 ";
				$ls = "SELECT job_addr from {$tkher['job_link_table']} ";
		} else if ( $sdata ) {
				$ls = "SELECT job_addr from {$tkher['job_link_table']} WHERE user_name like '%$sdata%' ";
		} else{
			$ls = "SELECT job_addr from {$tkher['job_link_table']} ";
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
			<!-- <TH>Group</TH> -->
			<TH>Title</TH>
			<!-- <TH>URL-Link </TH> -->
			<TH>Link Url</TH>
			<TH>type</TH>
			<!-- <TH>User</TH> -->
			<TH>View</TH>
			<TH>date</TH>
			<!-- <TH>lev</TH>-->
<?php if( $H_ID ) { ?>
			<TH>management</TH>
<?php } ?>
		</tr>
</thead>
<tbody width='100%'>
		<?php
			if ( $g_name=='mylist' && $sdata ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' and user_name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='P' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='P' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='D' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='D' or jong='B' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='G' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='G' or jong='A' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='T' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE jong='T' or jong='U' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type']=='M' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				//$ls = $ls . " WHERE jong='M' ";
				$ls = $ls . " WHERE job_group='menu' ";
				$ls = $ls . " ORDER BY up_day desc ";
				$ls = $ls . " $limit ";
			} else if ( $g_type=='mylist' or $g_name=='mylist' ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' $w1 ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_name && $sdata ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') and user_name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $g_name ) {
				//m_("--- g_name : " . $g_name );
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				//$ls = $ls . " WHERE user_id='$H_ID' and (job_name='$g_name' or job_group='$g_name') $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";	//jong, user_name ";
				$ls = $ls . " $limit ";
			} else if ( $sdata ) {
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " WHERE user_name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			} else{
				$ls = " SELECT * from {$tkher['job_link_table']} ";
				$ls = $ls . " ";
				$ls = $ls . " ORDER BY up_day desc, user_name ";
				$ls = $ls . " $limit ";
			}
		$result = sql_query(  $ls );
		while ( $rs = sql_fetch_array( $result ) ) {
			$sys_label	= $rs['job_name'];		//  분류
			$sys_name	= $rs['user_name'];		//  타이틀명 
			$rs_job_addr	= $rs['job_addr'];		//	프로그램명. or  Url 
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
			$url_ = substr($rs_job_addr, 0, 60);
			$td_bg = '#000000';

			if( $gubun == 'T' )	{
				$icon='../icon/berry.png'; $gubunT='T-Berry';$t_color='#9966CC';	$i_tit='T : Tree Link URL';
			} else if( $gubun == 'B' or    $gubun == 'D' or $rs['job_group'] == 'DOC' ){ 
				$icon='../icon/seed.png';  $gubunT='B-Seed';$t_color='cyan';			$i_tit='D or DOC : Document';
			} else if( $gubun == 'G' )	{ 
				$icon='../icon/pizza.png'; $gubunT='D-Pizza';$t_color='cyan';			$i_tit='B : Tree Document : Ebook';
			} else if( $gubun == 'P' )	{// Program List
				$icon='../icon/pcman1.png'; $gubunT='Program';$t_color='cyan';	$i_tit='P : Program';
			}
			else if( $gubun=='F' ){ $icon='../icon/land.png'; $gubunT='Land';$t_color='green';$i_tit='Board';}
			else if( $gubun=='G' ){ $icon='../icon/ship.png'; $gubunT='Ship';$t_color='green';$i_tit='Tree Board';}
			else if( $gubun=='U' ){ $icon='../icon/seed.png'; $gubunT='U-Leaf';$t_color='yellow';$i_tit='Link URL';}
			else if( $gubun=='A' ){ $icon='../icon/ship.png'; $gubunT='A-board';$t_color='yellow';$i_tit='A: A-Board';}
			else if( $gubun=='M' ){ $icon='../icon/land.png';$gubunT='BOM-Main';$t_color='yellow';$i_tit='M: Tree-M';}
			else if( $gubun=='N' ){ $icon='../icon/leaf.png';$gubunT='BOM-Note';$t_color='white';$i_tit='N: Tree-N';}
			else	$t_color='grace';
?>
				<tr valign="middle" align='left' width='30' height='20'> 
				  <td align='center' bgcolor='black' width='30' height='20' title='<?=$i_tit?>'><img src='<?=$icon?>' width='30' height='20'>
				  </td>
				  <!-- <td bgcolor='<?=$td_bg?>' align='left'  width='150' title='type:<?=$gubun?>'>
					<a href="javascript:call_pg_selectT( '<?=$rs_job_addr?>', '<?=$user_id?>', '<?=$sys_label?>', '<?=$sys_name?>','<?=$gubun?>','<?=$num?>','<?=$aboard_no?>', '<?=$seqno?>' )" style="border-style:;background-color:black;color:<?=$t_color?>;height:20;"  title='type:<?=$gubun?>'><?=$sys_label?></a>
				  </td> -->
<?php if( $rs['job_name']=='Note') { ?>
				  <td bgcolor='<?=$td_bg?>' align='left' title='<?=$memo?>'>
					<a href="javascript:contents_upd( '<?=$seqno?>', '<?=$sys_label?>', '<?=$num?>', '<?=$rs_job_addr?>', '<?=$memo?>', '<?=$sys_name?>' )" style="border-style:;background-color:black;color:<?=$t_color?>;height:20;" title='<?=$memo?>'><?=$sys_name?></a>
				  </td>
<?php } else {?>
				  <td bgcolor='<?=$td_bg?>' align='left' title='<?=$memo?>'>
					<a href="javascript:call_pg_select( '<?=$rs_job_addr?>', '<?=$user_id?>', '<?=$sys_label?>', '<?=$sys_name?>','<?=$gubun?>','<?=$num?>','<?=$aboard_no?>', '<?=$seqno?>' )" style="border-style:;background-color:black;color:<?=$t_color?>;height:20;" title='<?=$memo?>'><?=$sys_name?></a>
				  </td>
<?php }?>
				  <td style="border-style:;background-color:black;color:<?=$t_color?>;height:20;width:80px;" align='center'><?=$rs_job_addr?></td>
				  <td style="border-style:;background-color:black;color:<?=$t_color?>;height:20;" align='center'><?=$gubun ?></td>
				  <td style="border-style:;background-color:black;color:<?=$t_color?>;height:20;" align='center'><?=$rs['view_cnt'] ?></td>
				  <td style="border-style:;background-color:black;color:<?=$t_color?>;height:20;" align='center'><?=$rs['up_day'] ?></td>
			  <?php 
			  if ( $H_ID ) {
			  ?>
				  <td style="border-style:;background-color:black;color:<?=$t_color?>;height:25;" align='center'>
				  <?php 
				  if ( $gubun=='U' && ($H_ID==$rs['user_id'] or $H_LEV > 7) ) {
				  ?>
					  <input type='button' onclick="javascript:contents_del( '<?=$seqno?>', '<?=$g_name?>', '<?=$num?>' );" value='delete' style="border-style:;background-color:red;color:yellow;height:25;">
					  <input type='button' onclick="javascript:contents_upd( '<?=$seqno?>', '<?=$sys_label?>', '<?=$num?>', '<?=$rs_job_addr?>', '<?=$memo?>', '<?=$sys_name?>' );" value='Change' style="border-style:;background-color:blue;color:yellow;height:25;">
				<?php } else { ?>
						---
			<?php }  ?>
			  </td>
			<?php } ?> 
				</tr>
		<?php
			}	//-------- Loop
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
