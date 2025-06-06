<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");   //"ss_mb_id";
	connect_count('board_list3m', $H_ID, 1, $referer);	// log count
	/*  2021-08-12 
		board_list3m.php : mobile ver.
		board_list3.php : table : {$tkher['aboard_infor_table']} create
		
			- g5/pg/url_list_all.php : /g5/pg/ 에서 여기 /cratree/ 로 이동.

	*/
	$day = date("Y-m-d H:i:s");
	$pg_		= 'board_list3m.php';
	$target_	= $_POST['target_'];
	if( !$target_) $target_ = 'iframe_url';	//table_main
	$type_ = 'U';
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Link - App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/land25.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
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

</head> 

<?php
	$ss_mb_id		= get_session("ss_mb_id");   //"ss_mb_id";
	$ss_mb_level	= $member['mb_level'];    //get_session("ss_mb_level");   //"ss_mb_id";
	$H_ID				= $ss_mb_id;
	$H_LEV			= $ss_mb_level; 
	$g_type			= $_REQUEST["g_type"];
	$g_name_old	= $_REQUEST["g_name_old"];
	$g_name			= $_REQUEST["g_name"];
	$sel_num		= $_REQUEST["sel_num"];
	
	$gnm = $_REQUEST["g_name"];	//2018-07-13
	if( !$gnm ) {
		//$g_name = 'etc';
		//$g_num = 'etc';
		//$gg_user = 'etc';
		//$g_no = 'etc';
	} else {
		$aa = explode(':', $_REQUEST["g_name"]); 
		$g_name = $aa[0];
		$g_num = $aa[1];
		$gg_user = $aa[2];
		$g_no = $aa[3];
	}

	$memo			= $_REQUEST["memo"];
	$mode_up		= $_REQUEST["mode_up"];
	$mode_in		= $_REQUEST["mode_in"];
	$mode			= $_REQUEST["mode"];

	$sdata			= $_REQUEST["sdata"];
	$data			= $_REQUEST["sdata"];
	$page			= $_REQUEST['page'];

	if($mode == 'insert_group1') {
		$g_num = $H_ID . time();
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$ls = "select * from {$tkher['url_group_table']} where g_name='$g_name' and make_id='$H_ID' ";
		$result = sql_query( $ls);
		$rs = sql_num_rows($result);
		if($rs) {
			echo "<script>alert('\'$g_name\' Already exists. 이미 존재합니다');history.back();</script>";
		} else {
			$ls = "insert into {$tkher['url_group_table']} set g_name='$g_name', g_num='$g_num', make_id='$H_ID' ";
			$result = sql_query(  $ls );
			$url = "board_list3m.php";
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}

	else if($mode == 'update_group1') {
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		} else {
			$g_name = $_REQUEST['g_name'];
			$g_name_update = $_REQUEST['g_name_update'];
			$sql = "update {$tkher['url_group_table']} set g_name='$g_name_update' where g_name='$g_name' and make_id='$H_ID' ";
			$rs = sql_query(  $sql );
			$url = "board_list3m.php?g_name=".$g_name_update;
			echo "<script>window.open('$url', '_self', '');</script>";
		}
	}
	else if($mode == 'delete_g_name') {
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "delete from {$tkher['url_group_table']} where g_name='$g_name' and make_id='$H_ID'" );
	}
	else if($mode == 'insert_num') {
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login! Please!'); window.open('$url', '_self', '');</script>";
		}
		$result = sql_query( "select * from {$tkher['url_group_table']} where g_name='$g_name' and g_num='$num'" );
		$rs = sql_num_rows($result);
		if($rs) {
			echo "<script>alert('\'$g_name\' \'$num\' Item already exists');history.back();</script>";
		} else {
					$result = sql_query(  "insert into {$tkher['url_group_table']} set g_name='$g_name', g_num='$num'" );
			echo "<script>location.href('board_list3m.php?g_name=$g_name');</script>";
		}
		exit;
	}
	else if($mode == 'delete_link') {
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		} else {
			$num=$_POST['num'];
			$webnum=$_POST['webnum'];
			$g_name=$_POST['name'];
			$result = sql_query( "delete from {$tkher['aboard_infor_table']} where make_id='$H_ID' and seqno='$num'" );

			if($H_LEV > 7 ) $chkpass = " ";
			else $chkpass = " and user='$H_ID' ";

			$query="select * from webeditor where num='$webnum' $chkpass ";
			$mq=sql_query($query);
			$mn=sql_num_rows($mq);
			if($mn){
				$rs=sql_fetch_array($mq);
				$dir = substr($rs['date'],0,7);

				if( $rs['up_file'] != ""){
					$del_file = "../contents/webeditor/". $dir . "/" . $rs['up_file'];
					exec ("rm $del_file");
				}
				$result = sql_query( "delete from webeditor where num='$webnum'" );
			}
			echo "<script>location.href('board_list3m.php?g_name=$g_name');</script>";
		}
	}
	else if($mode == 'update_link') {
		$seq_no = $_REQUEST['seq_no'];
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$result	= 		$result = sql_query( "select * from {$tkher['aboard_infor_table']} where seqno='$seq_no'" );
		$rs		= sql_fetch_array($result);
		$title_	= $rs['name'];
		$table_name	= $rs['table_name'];
		$g_name	= $rs['name'];	// =job_group
		$lev	= $rs['job_level'];
		$jong	= $rs['jong'];
		$memo	= $rs['memo'];
	}
	else if($mode == 'insert_url_data') {
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$in_date  = date("Y-m-d H:i:s",time());

		$board_num  = 'U';
		$table_name = 'U';

		if( !$_REQUEST["sel_g_name"] ) {
			$g_name = 'etc';
		} else {
			$aa = explode(':', $_REQUEST["sel_g_name"]);
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
		//////////////////////////////////////////////////////////////////////////////////////////
		//$result = sql_query( "insert into {$tkher['aboard_infor_table']} set make_id='$H_ID', club_url='$from_session_url', user_name='$num', name='$g_name', job_group='$g_name', job_addr='$g_class', job_level='$job_label', jong='$jong', memo='$memo', ip='$ip', num='$table_name', in_date='$in_date', aboard_no='$board_num'" );
		
		
		$result = sql_query("select * from  {$tkher['aboard_infor_table']} where make_id='$H_ID' and user_name='$num' and job_addr='$g_class' ");
		$tot = sql_num_rows($result);
		if( $tot < 1 ) {
			$in_date = date("Y-m-d H:i:s");
			$sqlA = "insert into {$tkher['aboard_infor_table']} set make_id='$H_ID', club_url='$from_session_url', user_name='$num', name='$g_name', job_group='$g_name', job_addr='$g_class', job_level='$job_label', jong='$jong', memo='$memo', ip='$ip', num='$table_name', in_date='$in_date', aboard_no='$board_num' ";
			sql_query(  $sqlA ); 
		}
		$sql= " update g5_member set mb_point=mb_point+1 where mb_id = '$ss_mb_id' ";
		sql_query($sql);
		$memo='';
		$runpg = "link_list2_my.php";
		$rungo = "/cratree/r1_my.php?run=" . $runpg;
		echo "<script>location.href('board_list3m.php?g_name=$g_name');</script>";
	}
	if($mode_up == 'Save_encrypted_run') {
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Member Login IN! Please!'); window.open('/', '_self', '');</script>";
		}
		$link_ = $_REQUEST['sel_g_class'];
		$title_ = $_REQUEST['sel_num'];
		$str = $_REQUEST['memo'];
		$secret_key = $_REQUEST['form_psw'];
		//$memo = Encrypt($str, $secret_key, $link_secret_iv);
		//$encrypted_check = 'Link_Encrypted_OK';
	}
	else if($mode_up == 'Decryption_run') {
		if ( !$H_ID ) {
			$url = "board_list3m.php";
			echo "<script>alert('Please log in \n 로그인을 해주세요!'); window.open('/', '_self', '');</script>";
		}
		$link_ = $_REQUEST['sel_g_class'];
		$title_ = $_REQUEST['sel_num'];
		$encrypted = $_REQUEST['memo'];
		//$secret_key = $_REQUEST['form_psw'];
		//$memo = Decrypt($encrypted, $secret_key, $link_secret_iv);
	}
	else if ( $mode_up == 'update_link_run') {
		echo "<script>location.href('board_list3m.php?g_name=$g_name');</script>";
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
		location.href="board_list3m.php?mode=delete_g_name&g_name="+g_name;
	}

	function change_g_name_func(g_nm) {
		g_name = g_nm;

		var gg = g_nm.split(":");
		g_name2 = gg[0];
		g_num = gg[1];
		g_id = gg[2];
		g_no = gg[3];
		form = document.insert_form;
		form.g_name.value = gg[0];
		if ( !(form.mode.value == "update_link") ) {
			//form.mode.value = "";
			//document.insert_form.submit();
		} else {
			//if( confirm('Are you sure you want to change the group? \n 그룹을 변경하시겠습니까? '+g_name2) ) {
			//} else return false;
		}
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
	// treelist2_cranim_book.php, board_list3m.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
	function call_pg_select( link_, id, group, title_, jong, num, aboard_no, seqno) {
        if(jong=='M') link_='/t/menu/' + id + '/' + num + '_r1.htm'; // add M=menu
		
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
		document.coinview_form.action='/cratree/coin_add_sys.php';		
		 // coin_add.php는_run.html의 사용자소스에서 사용하고 시스템용과 분리한다.
		document.coinview_form.target='_blank';
		document.coinview_form.submit();
	}
	//------------ tree -------------
	function call_pg_selectT( link_, mid, group, title_, jong, num, aboard_no, seqno) {
		if ( link_.indexOf( 'contents_view_menu.php') >= 0 ) { 

			if( jong=='M' || jong=='T' || jong=='B') {
				link_='../tree_menu_guest.php?sys_pg=' + num + '&doc_num=' + aboard_no+ '&mid=' + mid+ '&link_=' + link_;
				// 실행 위치가 /cratree/coin_add_sys.php 여기 이므로 ../tree_menu_guest.php 주의.
			}
		}
		//alert('link:' + link_);
		document.coinview_form.link_.value =link_;
		document.coinview_form.mid.value   =mid;
		document.coinview_form.group.value =group;
		document.coinview_form.title_.value=title_;
		document.coinview_form.jong.value  =jong;
		document.coinview_form.num.value   =num;
		document.coinview_form.aboard_no.value =aboard_no;
		document.coinview_form.seqno.value =seqno;
   
        //if(jong=='M') document.coinview_form.action='./menu/cratree_coinadd_menu.php';
		//else document.coinview_form.action='/cratree/coin_add_sys.php';		
		//alert('jong:'+jong);

		document.coinview_form.action='/cratree/coin_add_sys.php';		
		 // coin_add.php는_run.html의 사용자소스에서 사용하고 시스템용과 분리한다.
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

	//-------------
	function init() {
		// board create type:
		for (var k=0 ; k < makeform.fnclist.options.length ; k++) {
			v=makeform.fnclist.options[k].value;
			//alert('v:'+v);
			if ( !getFuncMulti( getObjid( makeform.fnclist.options[k].value ) ) ){
				//makeform.fnclist.options[k].text += '*'
				//alert('111 v:'+v);
			} else {
				//alert('2222 v:'+v);
			}
		}
		
		for (var k=0 ; k < makeform.sellist.options.length ; k++) {

			var strAx = makeform.sellist.options[k].value
			var strA  = strAx.split("|")

			
			var fid = strA[1]		//makeform.sellist.options[k].value

			fid = fid.substring( 0, fid.indexOf("!") )

			if((fid != "GSTR") && (fid != "GEND")) {

				//게시판 종류를 가져와서 [] 속에 게시판명칭을 넣는다....'[통합게시판] 통합게시판6' 이렇게.....
				makeform.sellist.options[k].text = getFuncNameK(fid)+" "+makeform.sellist.options[k].text

				if (!getFuncMulti(fid)) {
					makeform.sellist.options[k].text = makeform.sellist.options[k].text.replace(/]/i,"*]")
					for (var j=0 ; j < makeform.fnclist.options.length ; j++)
						if (makeform.fnclist.options[j].value.indexOf(fid)>=0) {
							makeform.fnclist.options[j].disabled=true
							break;
						}
				}
			}
		}
	}
	function fnclist_onclick(v) {
		
		var seli = makeform.fnclist.selectedIndex;
		var t = makeform.fnclist.options[seli].text
		makeform.board_type_name.value=t;
		for (var k=0 ; k < makeform.fnclist.options.length ; k++)
		{
			if (makeform.fnclist.options[k].text != "" && makeform.fnclist.options[k].selected) {
				var fid = makeform.fnclist.options[k].value
				fid = fid.substring(0,fid.indexOf("!:"))
			} 
		}
	}
	// 메뉴설명 byte 체크
	function chkDescription(){
		//CheckStrLen(document.makeform.mncontents.value, 140, '메뉴설명');
		document.makeform.chkByte.value = (document.makeform.mncontents.value).length;
	}
	function update_title(){
		var seli = makeform.sellist.selectedIndex;
		if( seli < 0 ) {
			alert('Please select a bulletin board to change!'); return false;
		}
		var tnm = makeform.chgname.value;
		if( !tnm ) {
			alert(' Please enter your board name! '); return false;
		}

		var v = makeform.sellist.options[seli].value;
		var sel_v  = v.split("|");
		makeform.board_no.value = sel_v[0];

		var t = makeform.sellist.options[seli].text;
		var c = makeform.chgname.value;
		//alert('t:'+t+' , v: '+ v + ' , c:'+c); return; //t:[Memo] Memo-112A , v: 112|GCOM03! , c:Memo-112A
		makeform.mode.value='Update_Func';
		makeform.submit();
	}
	function CheckKey1(){
		if (event.keyCode == 13) {btncfm_onclick();return false}
	}
	function CheckKey2(){
		if (event.keyCode == 46) delAddList();
	}
	function btncfm_onclick() {
		var i,j,k
		var optStr
		var selStr = makeform.sellist
		var chgStr = makeform.chgname.value
	 
		if (makeform.sellist.selectedIndex < 0) return
	 
		//if(!CheckStrLen(makeform.chgname,18,"기능이름")){}
	 
		if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0)
			{
			alert('허용이 안 되는 특수문자를 사용하셨습니다.\n다시 입력하시기 바랍니다.')
			return false;
		}
		/*
			// selected 된 것과 같은 이름이 있는지?
			for (i=0;i<makeform.sellist.options.length;i++)
				{
				  if (chgStr == selStr.options[i].text)
				  {
					alert("이미 존재하는 이름입니다."+"\n"+ "이름을 변경한 후 사용하십시오.")
						return false;
				  }
				}
		*/
		for ( j=0; j < makeform.sellist.options.length; j++ )	{
			if ( makeform.sellist.options[j].selected == true ) {
				/* group의 시작(start) & 끝(end) 그룹이름 변경하기 */
				var chkname = makeform.sellist.options[j].value
				var chkObjid = getObjid(chkname)
				if ((chkname == "group") || (chkname == "groupend") ||  (chkObjid == "GSTR") || (chkObjid == "GEND")) {
					if (document.makeform.mnhide.checked) {
						alert("그룹메뉴에는 숨기기를 설정할 수 없습니다.")
						document.makeform.mnhide.checked = false
					}
					if ((chkname == "group") ||  (chkObjid == "GSTR"))	{
						start = j
						end = grpnum("start", j)
					}
					else if ((chkname == "groupend") || (chkObjid == "GEND")) {
						start = grpnum("end", j)
						end = j
					}
	 
					if ((start != null) && (end != null)){
						frealname = "["+ chgStr +"]"
						makeform.sellist.options[start].text = "-----" + frealname + " 시작-----"
						makeform.sellist.options[end].text = "-----" + frealname + " 끝-------"
					}
				}
				else {
					makeform.sellist.options[j].text = frealname + " " + chgStr
					if (document.makeform.mnhide.checked){
					  makeform.sellist.options[j].text = makeform.sellist.options[j].text + "<숨기기>"
						makeform.funchelp.value += getObjid(makeform.sellist.options[j].value) + "!:" + getObjseq(makeform.sellist.options[j].value) + "!:" + getfname(makeform.sellist.options[j].text) + "!:" + document.makeform.mncontents.value + "!#";
					}
					else{
						document.makeform.mnhide.checked = false
						makeform.funchelp.value += getObjid(makeform.sellist.options[j].value) + "!:" + getObjseq(makeform.sellist.options[j].value) + "!:" + getfname(makeform.sellist.options[j].text) + "!:" + document.makeform.mncontents.value + "!#";
					}
				}
				isEdited = true
				return true
			}
		}
	}
	//-------------------
	function Add2ListXXX(){
		
	   var optStr, newOpt, tstr, newOpt2
	   if ( makeform.fnclist.selectedIndex < 0){
			alert (" Please select a board type.");
			return;
		}
	   if ( makeform.aboard_name.value==""){
			alert (" Please enter your board name! ");
			makeform.aboard_name.focus();
			return;
		} else {
			var chgStr = makeform.aboard_name.value
			if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0){
				alert('You used a special character that is not allowed. ');//허용이 안 되는 특수문자를 사용하셨습니다.
				return ;
			}
			sellist_i = makeform.sellist.options.length; //alert("sellist_i:"+sellist_i);//sellist_i:12
			for (i=0;i<makeform.sellist.options.length;i++){
				bnm = makeform.sellist.options[i].text;
					//alert("make nm:"+chgStr+ " , sellist_nm:"+bnm);
				if (chgStr == bnm){
					alert("It is an existing name. "+"\n"+ " Please change your name."); //alert("이미 존재하는 이름입니다."+"\n"+ "이름을 변경한 후 사용하십시오.");
					makeform.aboard_name.focus();
					return false;
				}
			}
		}
		if (!confirm("Create a bulletin board?")) return
		
		var seli = makeform.fnclist.selectedIndex;

		v=makeform.fnclist.options[seli].value;
		t=makeform.fnclist.options[seli].text;
		
		makeform.sellist_index.value = seli;

		//	alert('seli:'+seli+' , v:'+v +' ,t:'+t); return false;
		//seli:0 , v:TCOM01!:0!:4!,4!,4!,7!,7!,0!,X!, ,t:General Type
		//seli:2 , v:GCOM03!:0!:3!,3!,3!,7!,7!,0!,X!, ,t:Memo Type
		
		document.makeform.new_insert.value = "create_first";	// 추가버턴.
		makeform.submit();
	}
	//==================
	function Add2List() {

	   if( makeform.sellist_index.value == ""){
			alert (" Please select a board type.");
			return;
		}
	   if( makeform.aboard_name.value==""){
			alert (" Please enter your board name! ");
			makeform.aboard_name.focus();
			return;
		} else {
			var chgStr = makeform.aboard_name.value
			if( chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0){
				alert('You used a special character that is not allowed. ');//허용이 안 되는 특수문자를 사용하셨습니다.
				return ;
			}
			/*
			sellist_i = makeform.sellist.options.length; //alert("sellist_i:"+sellist_i);//sellist_i:12
			for (i=0;i<makeform.sellist.options.length;i++){
				bnm = makeform.sellist.options[i].text;
					//alert("make nm:"+chgStr+ " , sellist_nm:"+bnm);
				if (chgStr == bnm){
					alert("It is an existing name. "+"\n"+ " Please change your name."); //alert("이미 존재하는 이름입니다."+"\n"+ "이름을 변경한 후 사용하십시오.");
					makeform.aboard_name.focus();
					return false;
				}
			}*/
		}
		if( !confirm("Create a bulletin board?")) return
		
		//	alert('seli:'+seli+' , v:'+v +' ,t:'+t); return false;
		//seli:0 , v:TCOM01!:0!:4!,4!,4!,7!,7!,0!,X!, ,t:General Type
		//seli:2 , v:GCOM03!:0!:3!,3!,3!,7!,7!,0!,X!, ,t:Memo Type
		
		document.makeform.action = "query_ok_new.php";	// 2024-05-02 
		document.makeform.mode.value = "create_list3m";	// 2024-05-02 
		document.makeform.new_insert.value = "create_firstM";	// 추가버턴.
		makeform.submit();
	}

	/*  /js/gethelp.js ------------------------------------ */
	function getFuncNameK(fid) {
		switch(fid) {
			case "TCOM01" : return "[General]"
			case "GCOM02" : return "[Standard]"
			case "GCOM03" : return "[Memo]"
			case "GCOM04" : return "[Image]"
			case "GCOM05" : return "[New1]"
			case "GCOM06" : return "[New2]"
			case "GCOM08" : return "[New3]"
			case "TCOM02" : return "[Line]"
			case "TCOM03" : return "[QnA]"
			default : return "[none]"
		}
	}
	/**/
	 
	function getObjid(str) {
		return str.substring(0,str.indexOf("!:"))
	}
	 
	function getObjseq(str) {
			if (str.length>0) {
				var strA = str.split("!:")
				return strA[1]
			}
	}
	function getfname(str) {
		if (str.indexOf("]") > 0) {
			frealname = str.substring(0, str.indexOf("]")+1)
			str = str.substr(str.indexOf("]")+2)
		}
		return str
	}

	function sellist_onclick() {

		var selind = makeform.sellist.selectedIndex
		
		var strAx = makeform.sellist.options[selind].value
		//alert(strAx);	// 189|GCOM02!
		var strA  = strAx.split("|")
		makeform.board_no.value = strA[0]
		
		//alert(strA[0])
		

		var funcind = "funchelp" + selind
		var category = "D02"
	 
		if (selind >= 0 && makeform.sellist.options[selind].text != "")
		{
			//var grpname = makeform.sellist.options[selind].value
			var grpname = strA[1]

			if (( grpname == "group") || (grpname == "groupend") ||  (getObjid(grpname) == "GSTR") || (getObjid(grpname) == "GEND")) {
				makeform.chgname.value = chkGroup(makeform.sellist.options[selind].text)
				document.makeform.mncontents.value = ""
				document.makeform.chkByte.value = "0";
			}
			else {

				makeform.chgname.value = getfname( makeform.sellist.options[selind].text )

				//var valname = makeform.sellist.options[selind].value
				var valname = strA[1]

				if (valname.length>0) {
					var valnameA = valname.split("!:")
					var strA = ""
					strA += valnameA[0] + valnameA[1]
				}
				if ((valnameA[1] != 0) && (category != "V02")){    //기존의 메뉴일 경우
					var chkobjid = eval("document.makeform." + strA + ".value")
					document.makeform.mncontents.value = eval("document.makeform." + strA + ".value")
				}
	 
			//선택된 항목의 이름이 (숨기기)되어있을 경우 checkbox의 V표시
				var strChgnm = makeform.chgname.value
				if (strChgnm.substring(strChgnm.indexOf("<")+1, strChgnm.indexOf(">")) == "숨기기"){
					document.makeform.mnhide.checked = true
					makeform.chgname.value = strChgnm.substring(0, strChgnm.indexOf("<"))
				}
				else{
					document.makeform.mnhide.checked = false

					makeform.chgname.value = getfname(makeform.sellist.options[selind].text)
				}
			}
			chkDescription()
			return true
		} else {
			makeform.chgname.value = ""
			document.makeform.mncontents.value = ""
			document.makeform.chkByte.value = "";
			makeform.sellist.selectedIndex=-1
			return false
		}
	}
	function edit_attr2(no, num)
	{ 

			makeform.xno.value = no;

			var sel_r = eval( "document.coinview_form.grant_read_"+num+".value");//coinview_form,insert_form_a
			var sel_w = eval( "document.coinview_form.grant_write_"+num+".value");
			var sel_m = eval( "document.coinview_form.grant_memo_"+num+".value");
			var sel_s = eval( "document.coinview_form.skin_type_"+num+".value");
			makeform.xread.value = sel_r;
			makeform.xwrite.value = sel_w;
			makeform.xmemo.value = sel_m;
			makeform.xskin.value = sel_s;

			makeform.mode.value = 'skin_update_func';

			makeform.action='board_list3_ok.php'; // board_create_pop_ok.php
			//var res = confirm(" Do you want to process bulletin board properties? \n 게시판 속성을 변경하시겠습니까?\n[주의] 변경합니다. ");
			var res = confirm(" Are you sure you want to change the bulletin board properties? ");
			if (res) { makeform.submit(); }
	}
	function edit_attr3(no, num)
	{ 
		//alert("no="+no+ ", num="+num);
			makeform.no.value = no;

			/*var sel_r = eval( "document.insert_form_a.grant_read_"+num+".value");
			var sel_w = eval( "document.insert_form_a.grant_write_"+num+".value");
			var sel_m = eval( "document.insert_form_a.grant_memo_"+num+".value");
			var sel_s = eval( "document.insert_form_a.skin_type_"+num+".value");
			makeform.xread.value = sel_r;
			makeform.xwrite.value = sel_w;
			makeform.xmemo.value = sel_m;
			makeform.xskin.value = sel_s;*/

			makeform.action='board_list3_update.php';
			makeform.target='_blank';
			//var res = confirm(" Do you want to process bulletin board properties?");
			//if (res) { makeform.submit(); }
			makeform.submit();
	}
	// board type
	function btypeF(n){
		makeform.sellist_index.value = n; //seli;
		alert('n:'+n);
		/*for(i=0;i<rr.length;i++){
			nm = rr[i].getAttribute("name");
			vn = rr[i].getAttribute("name").value;
			//alert('name:'+rr[i].getAttribute("name"));
			if(rr[i].getAttribute("name")=='btype') {
				alert('nm:'+nm + ', i:' + i+ ', value:' + vn);
				rr[i].setAttribute("onclick", "return(false);");
			}
		}    */
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

		<form name="makeform" method="post" action="board_list3_ok.php"><!-- /contents/board_create_pop_ok.php  -->
			<input type="hidden" name="no" 	        value="" >
			<input type="hidden" name="new_insert" 	value="" >
			<input type="hidden" name="insert" 		value="" >
			<input type="hidden" name="club_menu" 	value="" >
			<input type="hidden" name="funchelp" 	value="">
			<input type="hidden" name="mode" 		value="">
			<input type='hidden' name='board_type_name' value=''>
			<input type='hidden' name='board_gubun_value'  value='<?=$home_url?>'>
			<input type='hidden' name='sellist_index' >
			<input type='hidden' name='board_no' value=''>
			<input type='hidden' name='multy_menu_sel' >
			<input type='hidden' name='xno' >
			<input type='hidden' name='xread' >
			<input type='hidden' name='xwrite' >
			<input type='hidden' name='xmemo' >
			<input type='hidden' name='xskin' >



<!-- --------------------------------------------------------------------- -->
<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<!-- --------------------------------------------------------------------- -->
	
	<table>


	<?php
	$sel_g_name = $_POST['sel_g_name'];
	?>
			<tr>
				<td>
				<table>
					<tr>
						<td style='background-color:#000000;color:yellow;height:30px;text-align:center;' title=' Please select the type of board to be created! '>
						Type of board</td>
					</tr>
					<tr>
						<!-- <td valign="top" align="left" bgcolor="#f5f5f5">
							<select id="fnclist" style="WIDTH: 200px" onChange="fnclist_onclick(this.value)" multiple size="8" name="fnclist">
												  <option value="TCOM01!0!4!,4!,4!,7!,7!,0!,X!,"> General Type </option>
												  <option value="GCOM02!0!4!,4!,6!,7!,7!,0!,X!,"> Standard Type </option>
												  <option value="GCOM03!0!3!,3!,3!,7!,7!,0!,X!,"> Memo Type </option>
												  <option value="GCOM04!0!0!,4!,6!,7!,7!,0!,X!,"> Image Type </option>
							</select>
						</td> -->
						<!-- <div>board type</div>
						<input type="radio" name="btype" onclick="btypeF(0)">Standard<br>
						<input type="radio" name="btype" onclick="btypeF(1)">General<br>
						<input type="radio" name="btype" onclick="btypeF(2)">Memo<br>
						<input type="radio" name="btype" onclick="btypeF(3)">Image<br> -->

                                  <td height="15" align='left'>
									<p><label> <input type='radio' name='Btype' value="GCOM02!0!4!,4!,6!,7!,7!,0!,X!," onclick="btypeF(1)" style="border-style:;background-color:#666666;color:yellow;">Standard</p>
									<p><label> <input type='radio' name='Btype' value="GCOM03!0!3!,3!,3!,7!,7!,0!,X!," onclick="btypeF(2)">Memo</label></p>
									<p><label> <input type='radio' name='Btype' value="GCOM04!0!0!,4!,6!,7!,7!,0!,X!," onclick="btypeF(3)">Image</label></p>
                                  </td>

					</tr>
					<tr><!-- 666666 -->
						<td style='background-color:#000000;color:yellow;height:30px;text-align:center;'>Board Name:<input id='aboard_name' maxlength='70' size='10' name='aboard_name' ></td>
					</tr>

					<tr>
						<td align="middle">
						<?php if($H_ID) { ?>
							<input type='button' value='Create' onclick="javascript:Add2List()" title='After selecting the type and title, click the button to create a bulletin board' style="border-style:;background-color:#666666;color:yellow;"><!-- 타입과 타이틀을 선택후 버턴을 클릭하면 게시판이생성됩니다 -->
						<?php } ?>
						</td>
					</tr>


				</table>
				</td>

				<!-- <td>
				<table>
					<tr>
						<td align="middle">
							<input type='button' value='ADD->' onclick="javascript:Add2List()" title='After selecting the type and title, click the button to create a bulletin board' style="border-style:;background-color:#666666;color:yellow;">
					</tr>
				</table>
				</td> -->
			
				<!-- <td>
				<table  style='background-color:#666666;color:white;height:200px;text-align:center;'>
					<tr>
						<td style='background-color:#666666;color:white;height:30px;text-align:center;'>Board List</td></tr>
				
					<tr>
						<td valign="top">
<?php

						$where_ = " where make_id='" . $H_ID. "' " ;
						$sql = "select * from {$tkher['aboard_infor_table']} " . $where_ . " order by in_date desc";
						$result = sql_query($sql);
						$aaa = 0;

						$j=0;
						while($rs = sql_fetch_array($result)) {

							echo "<label style='background-color:cyan;'><input type='radio' id='sellist_tab2".$j."' name='sellist_tab2' value='".$rs['no']."' onClick=\"sellist_onclick('".$j."')\" title='".$j.", " .$rs['no'].", " .$rs[name]."' checked> ".$rs[name]." </label><br>";

							$j++;
						}
?>
						<input type='hidden' size='70' name='board_gubun_text' value='<?=$home_url?>'>
						</td>
					</tr>
<script> 
	init();
</script>
					<tr>
						<td>
						<input class='boxstyle' id='chgname' onKeyDown='CheckKey1()' onBlur='btncfm_onclick()' maxlength='70' size='10' name='chgname' >
						
						<input type='button' value="Change" onClick="update_title()" style="cursor:hand;" title='Change the board name.'>

						<input id='mnhide' onBlur='btncfm_onclick()' type='checkbox' align='absMiddle' name='mnhide' style="display:none; border:0;">
						<textarea id='mncontents' onKeyUp='chkDescription()' name='mncontents' rows='3' cols='60' onChange='chkDescription()' style="display:none;"></textarea>
						<input id='chkByte' readOnly size='4' value='0' name='chkByte' style="display:none;">
						</td>
					</tr>
				</table>
				</td> -->

			</tr>
	</table>
</div>

<!-- --------------------------------------------- -->

<div id="mypaneltab" class="ddpaneltab" >
<a href="#" ><span style="border-style:;background-color:;color:yellow;">Board Create</span> </a>
</div>

</div>

	</form>

<link rel="stylesheet" href="./include/css/kancss.css" type="text/css">

 
 <!-- 
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, board_list3m.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
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
			<script type="text/javascript" src="./include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="./" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Group View [▼]</b></font>
				</a> 
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">

			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
				/*if( $g_user or $H_ID ) {
					$sql = "select * from {$tkher['url_group_table']} where make_id='$H_ID' order by g_name ";
					$ttt = "my-list";
				}	else {
					$sql = "select * from {$tkher['url_group_table']} order by g_name ";
					$ttt = "all-list";
				}*/
?>
				<tr>
				<td width='130' height='24' background='/logo/admin_submenu.gif'>&nbsp;
					<img src='/logo/left_icon.gif'>
					<a href="./board_list3m.php?g_type=mylist" target='iframe_url'>&nbsp;
					<font color='blue'>URL <?=$ttt?></a>
				</td>
				</tr>

		<tr>
		<td width='130' height='24' background='/logo/admin_submenu.gif'>&nbsp;<img src='/logo/left_icon.gif'>
		<a href="board_list3m.php?g_type=G" target='iframe_url'>General type</a>
		</td>
		</tr>

		<tr>
		<td width='130' height='24' background='/logo/admin_submenu.gif'>&nbsp;<img src='/logo/left_icon.gif'>
		<a href="board_list3m.php?g_type=S" target='iframe_url'>Standard type</a>
		</td>
		</tr>

		<tr>
		<td width='130' height='24' background='/logo/admin_submenu.gif'>&nbsp;<img src='/logo/left_icon.gif'>
		<a href="board_list3m.php?g_type=M" target='iframe_url'>Memo type</a>
		</td>
		</tr>

		<tr>
		<td width='130' height='24' background='/logo/admin_submenu.gif'>&nbsp;<img src='/logo/left_icon.gif'>
		<a href="board_list3m.php?g_type=I" target='iframe_url'>Image type</a>
		</td>
		</tr>
	</TABLE>

		<div align="right"><a href="javascript:dropdowncontent.hidediv('subcontent2')">Hide </a></div>
		
		</DIV>

		<script type="text/javascript">
			dropdowncontent.init("searchlink", "left-bottom", 800, "mouseover")
			dropdowncontent.init("contentlink", "right-bottom", 800, "click")
		</script>
		</td>
	</tr>
		<!-- popup end ------------------------------------------------- -->
<?php
		$limite = 10; 
		$page_num = 10; 

		if($mode == 'search_rtn') {
			$sdata = $sel_num;
		}

		$w = " ";

		$w1= " ";

		$w2 = " ";

		if ( $g_name =='mylist' && $sdata ) {
				$ls = "SELECT table_name FROM {$tkher['aboard_infor_table']} WHERE make_id='$H_ID' and name like '%$sdata%' ";

		} else if ( $g_name =='mylist' ) {
				$ls = "SELECT table_name FROM {$tkher['aboard_infor_table']} WHERE make_id='$H_ID' $w1 ";
		} else if ( $sdata ) {
				$ls = "SELECT table_name FROM {$tkher['aboard_infor_table']} WHERE name like '%$sdata%' ";
		} else if ( $_REQUEST['g_type'] ) { // menu  $rs[movie]
				$ls = "SELECT table_name FROM {$tkher['aboard_infor_table']} WHERE movie='".$_REQUEST['g_type']."' ";

		} else{
			$ls = "SELECT table_name FROM {$tkher['aboard_infor_table']} ";
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
		else if( !$g_name ) $g_nameX = "page:" . $page . ", [count:" .$total. "]";
		else $g_nameX = "Group: " . $g_name;

		if( $H_ID ) $g_nameX = $g_nameX . $H_ID. ", level:" . $member['mb_level'] . "," .$member['mb_email'];
?>

		<tr>
			<td bgcolor='#f4f4f4'  align='center' colspan=7><font color='black'>&nbsp;<?=$g_nameX?><!--  [count:<?=$total?>] -->
			</td> 
		</tr>

<table class='floating-thead' width='100%'>
<thead  width='100%'>
		<tr style='color:black;' align='center'>
			<TH style='color:white;'>no</TH>
			<!-- <TH style='color:white;'>user</TH>
			<TH style='color:white;'>info</TH> -->
			<TH style='color:white;'>board name</TH>
			<!-- <TH style='color:white;'>data</TH>
			<TH style='color:white;'>file size</TH> -->
			<TH style='color:white;'>skin type</TH>
			<TH style='color:white;'>read</TH>
			<TH style='color:white;'>write</TH>
			<!-- <TH style='color:white;'>memo</TH> -->

<?php if( $H_ID && $H_LEV > 1 ) { ?>
			<TH>management</TH>
<?php } ?>
		</tr>

 </thead>
<tbody width='100%'>

		<?php
		
			if ( $g_name=='mylist' && $sdata ) {
				$ls = " SELECT * FROM {$tkher['aboard_infor_table']} ";
				$ls = $ls . " WHERE make_id='$H_ID' and name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY in_date desc, name ";
				$ls = $ls . " $limit ";
			} else if ( $g_name=='mylist' ) {
				$ls = " SELECT * FROM {$tkher['aboard_infor_table']} ";
				$ls = $ls . " WHERE make_id='$H_ID' $w1 ";
				$ls = $ls . " ORDER BY in_date desc, name ";
				$ls = $ls . " $limit ";
			} else if ( $sdata ) {
				$ls = " SELECT * FROM {$tkher['aboard_infor_table']} ";
				$ls = $ls . " WHERE name like '%$sdata%'  $w ";
				$ls = $ls . " ORDER BY in_date desc, name ";
				$ls = $ls . " $limit ";
			} else if ( $_REQUEST['g_type'] ) {
				$ls = " SELECT * FROM {$tkher['aboard_infor_table']} ";
				$ls = $ls . " WHERE movie='".$_REQUEST['g_type']."' ";
				$ls = $ls . " ORDER BY in_date desc ";
				$ls = $ls . " $limit ";
			} else{
				$ls = " SELECT * FROM {$tkher['aboard_infor_table']} ";
				$ls = $ls . " ";
				$ls = $ls . " ORDER BY in_date desc, name ";
				$ls = $ls . " $limit ";
			}
			$result = sql_query(  $ls );
			//echo "<br>sql:".$ls;
	$aaa = 0;
	$line = 0;
	$i=1;
			while ( $rs = sql_fetch_array( $result ) ) {
		$line=$limite*$page + $i - $limite;
		//$line++;

				if ( $rs[grant_view] == "0" ) $levR='Guest';
				else if ( $rs[grant_view] == "1" ) $levR='Member';
				else if ( $rs[grant_view] == "2" ) $levR='Only Me';
				else if ( $rs[grant_view] == "3" ) $levR='System';
				else $levR = '???';

				if ( $rs[grant_write] == "0" ) $lev='Guest';
				else if ( $rs[grant_write] == "1" ) $lev='Member';
				else if ( $rs[grant_write] == "2" ) $lev='Only Me';
				else if ( $rs[grant_write] == "3" ) $lev='System';
				else $lev='???';

				if ( $rs[movie] == "1" ) 		$skin_='General Type';
				else if ( $rs[movie] == "2" )	$skin_='Standard Type';
				else if ( $rs[movie] == "3" )	$skin_='Memo Type';
				else if ( $rs[movie] == "4" )	$skin_='Image Type';
				else $skin_='???';

				$query	= "select * from aboard_" . $rs[table_name] . " "; 
				$mq1	= sql_query($query);
				$board_cnt = sql_num_rows($mq1);

?>
			
		  <tr>
				<td style='background-color:#FFFFFF' align=center><?=$line?></td>
			<!-- <?php if ($H_LEV > 7 ) { ?>
				<td style='background-color:#FFFFFF' align=center><?=$line?> : <?=$rs[make_id]?></td>
			<?php } else {  ?>
				<td style='background-color:#FFFFFF' align=center><?=$line?></td>
			<?php } ?> -->
				<!-- <td style='background-color:#FFFFFF' align=center><?=$rs[make_id]?></td>
			<td style='background-color:#FFFFFF' align=center><?=$rs['no']?></td> -->
			<td width='10%' bgcolor="#FFFFFF" title='board no=<?=$rs['no']?>:aboard_<?=$rs[table_name]?>'>
				<a href="/contents/index.php?infor=<?=$rs['no']?>" target='_blank'><?=$rs[name]?></a></td>
			<!-- <td style='background-color:#FFFFFF' align=center><?=$board_cnt?></td>
			<td style='background-color:#FFFFFF' align=center title='upload file size:<?=$rs[fileup]?>'><?=$rs[fileup]?></td> -->
			<td bgcolor="#FFFFFF" align="center">
				<select name="skin_type_<?=$aaa?>">
					<option value="<?=$rs[movie]?>" selected ><?=$skin_?></option>
					<option value="1" >General Type</option>
					<option value="2" >Standard Type</option>
					<option value="3" >Memo Type</option>
					<option value="4" >Image Type</option>
			  </select></td>
			<td bgcolor="#FFFFFF" align="center">
			<select name="grant_read_<?=$aaa?>">
				<option value="<?=$rs[grant_read]?>" selected ><?=$levR?></option>
				<option value="0" >Guest</option>
				<option value="1" >Member</option>
				<option value="2" >Only Me</option>
			<?php if( $H_LEV > 7 ) {  ?>				
				<option value="3" >System</option>
			<?php }  ?>				
			  </select>
			  <br>More than </td>
			<td bgcolor="#FFFFFF" align="center">
			<select name="grant_write_<?=$aaa?>">
				<option value="<?=$rs[grant_write]?>" selected ><?=$lev?></option>
				<option value="0" >Guest</option>
				<option value="1" >Member</option>
				<option value="2" >Only Me</option>
			<?php if( $H_LEV > 7 ) {  ?>				
				<option value="3" >System</option>
			<?php }  ?>				
			  </select>
			  <br>More than </td>
			<!-- <td bgcolor="#FFFFFF" align="center">
				<textarea name="grant_memo_<?=$aaa?>" class="input01" cols="30" rows="2"><?=$rs[memo]?></textarea></td> -->
<?php if($H_ID){ ?>
			<td bgcolor="#FFFFFF" align="center">
				<input type='button' value="Confirm" onClick="edit_attr2('<?=$rs['no']?>','<?=$aaa?>')" style="cursor:hand;" title='Save the skin and read and write permissions.'>
				<input type='button' value="Set" onClick="edit_attr3('<?=$rs['no']?>','<?=$aaa?>')" style="cursor:hand;" title=' It makes detailed setting of bulletin board. '>
				<input type='button' value='Run' onclick="javascript:window.open('/contents/index.php?infor=<?=$rs['no']?>','_blank','')" style="cursor:hand;" title=' Run the bulletin board. '>
			</td>
<?php } ?>
		  </tr>


		<?php
			$aaa++;
			$i++;
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

if($page > $page_num) echo"[<a href=$PHP_SELF?page=$prev$search&sdata=$sdata&g_name=$g_name&g_type=$g_type >Prev</a>] ";
for($i = $first_page; $i <= $last_page; $i++)
{
	if($page == $i) echo" <b>$i</b> "; 
	else echo"[<a href=$PHP_SELF?page=$i$search&sdata=$sdata&g_name=$g_name&g_type=$g_type >$i</a>]";
}
$next = $last_page+1;
if($next <= $total_page) echo" [<a href=$PHP_SELF?page=$next$search&sdata=$sdata&g_name=$g_name&g_type=$g_type >Next</a>]";
?>
	</td>
  </tr>
</table>
</form>

</body>
</html>
