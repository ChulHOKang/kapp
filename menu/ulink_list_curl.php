<?php
	include_once('../tkher_start_necessary.php');
	 $_ID	= get_session("ss_mb_id"); 
	if( isset( $_ID) ){
		$H_ID	= get_session("ss_mb_id");    //"ss_mb_id";	//connect_count('ulist', $H_ID, 0);	// log count
		$_LEVEL	= get_session("ss_mb_level"); //m_($H_ID . ", _LEVEL: " . $_LEVEL);
	} else {
		$H_ID = "";
		$_LEVEL	= 0; 
		m_("login please!");
	}

	/*  
		ulink_list_curl.php table : {$tkher['job_link_table_curl']} 
		cratree_my_list_menu.php - inc menu_run.php - search call

	*/
	$up_day = date("Y-m-d H:i:s");
	$pg_		= 'ulink_list_curl.php';
	if( isset($_POST['target_']) ) $target_	= $_POST['target_'];
	else $target_ = 'iframe_url';	//table_main
	$type_ = 'U';
	$title_='';
	$secret_key = "";
	$link_	= "";
	$gg_user = "";
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/land.png">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
<!-- <script src="//code.jquery.com/jquery.min.js"></script> -->
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
	if( isset($member['mb_id']) && $member['mb_id'] !== "") {
		$ss_mb_level	= $member['mb_level']; 
		$H_EMAIL	    = $member['mb_email'];
		$H_ID				= $ss_mb_id;
		$H_LEV			= $ss_mb_level; 
	} else {
		$ss_mb_level	= ""; 
		$H_EMAIL	    = ""; 
		$H_ID				= ""; 
		$H_LEV			= ""; 
	}
		$g_name = "";
		$g_name_code = "";
		$sel_g_name = ":";
		$g_num = "";

	if( isset($_REQUEST["g_type"]) ) $g_type	= $_REQUEST["g_type"];
	else $g_type	= "";
	if( isset($_REQUEST["g_name_old"]) ) $g_name_old	= $_REQUEST["g_name_old"];
	else $g_name_old	= "";
	if( isset($_REQUEST["title_nm"]) ) $title_nm	= $_REQUEST["title_nm"];
	else $title_nm	= "";

	if( isset($_POST["sel_g_name"]) && $_POST["sel_g_name"] !=="" ) {
		$sel_g_name	= $_POST["sel_g_name"];
		$aa = explode(':', $_POST["sel_g_name"]); 
		$g_name = $aa[0];
		$g_num = $aa[1];
		$g_name_code = $g_num;
		if( isset($aa[2])) $gg_user = $aa[2];
		else $gg_user = $H_ID;
		if( isset($aa[3])) $g_no = $aa[3];
		else $g_no = "";
	} else {
		if( isset($H_ID) ) $gg_user = $H_ID;
		else $gg_user = "";
		$g_no = "";
	}
	
	if( isset($_REQUEST["g_name"]) ) $gnm = $_REQUEST["g_name"];
	if( isset($gnm) && $gnm !=="" ) {
		$aa = explode(':', $_REQUEST["g_name"]); 
		if( isset($aa[0]) ) $g_name = $aa[0];
		if( isset($aa[1]) ) $g_num = $aa[1];
		if( isset($aa[2]) ) $gg_user = $aa[2];
		if( isset($aa[3]) ) $g_no = $aa[3];
	}

	if( isset($_REQUEST["mode"]) ) 	$mode			= $_REQUEST["mode"];
	else if( isset($_POST["mode"]) )	$mode			= $_POST["mode"];
	else	$mode			= "";
	if( isset($_REQUEST["memo"]) ) 	$memo			= $_REQUEST["memo"];
	else	$memo			= "";
	if( isset($_REQUEST["mode_up"]) ) 	$mode_up			= $_REQUEST["mode_up"];
	else	$mode_up			= "";
	if( isset($_REQUEST["mode_in"]) ) 	$mode_in			= $_REQUEST["mode_in"];
	else	$mode_in			= "";
	if( isset($_REQUEST["sdata"]) ) 	$sdata			= $_REQUEST["sdata"];
	else	$sdata			= "";

	if( isset($_REQUEST["page"]) ) 	$page			= $_REQUEST["page"];
	else	$page			= "";

	$menu1TWPer=15;  
	$menu1AWPer=100 - $menu1TWPer;  
	$menu2TWPer=10;  
	$menu2AWPer=50 - $menu2TWPer;  
	$menu3TWPer=10;  
	$menu3AWPer=33.3 - $menu3TWPer;  
	$menu4TWPer=10;  
	$menu4AWPer=25 - $menu4TWPer;  
	$Xwidth='90%';  
	$Xheight='100%';  
	$Text_height='60px';  

?>
<script language='javascript'>
<!--
	function initA(){
		document.getElementById('upd_save_button').style.visibility = 'hidden'; 
		document.getElementById('upd_cancle').style.visibility = 'hidden'; 
	}
	function check_enter() { 
		if (event.keyCode == 13) { 
			g_name_code=insert_form.g_name_code.value;
			if(g_name_code =='') {
				alert('select project --- '); 
				document.insert_form.sel_g_name.focus();
			}
			else document.insert_form.memo.focus();
		} 

	}
	// 손대면 안되는 부분입니다. 2018-06-26 -----------------
	// treelist2_cranim_book.php, ulink_list.php, link_list2.php, webeditor_list2.php, tkbbs_list2.php
	function change_g_name_func(g_nm) {
		g_name = g_nm;
		var gg = g_nm.split(":");
		g_name2 = gg[0];
		g_num = gg[1];
		g_id = gg[2];
		g_no = gg[3];
		document.insert_form.g_name.value = gg[0]; 
		document.insert_form.g_name_code.value = gg[1]; 
		document.insert_form.g_name_update.value = gg[0]; 
	}
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
        document.coinview_form.action='./cratree_coinadd_menu.php';
		document.coinview_form.target='_blank';
		document.coinview_form.submit();
	}

//-->
</script>

 <script>
jQuery(document).ready(function ($) {

	$('a[href^="#"], .view_click').on('click', function( seq_no, g_name, webnum, kapp_server, memo, title, mid, H_ID) {
		//var seq_no = $("#insert_form").seq_no.val();
		//alert("Note Create click --- " );
	});
});
</script>

<body onload="initA()">
<?php
		$cur='B';
		include_once "../menu_run.php"; 
?>

<form id="insert_form" name='insert_form' method='post' enctype='multipart/form-data' >
	<input type='hidden' name='g_type'			value='<?=$g_type?>' > 
	<input type='hidden' name='g_name_old'	value='<?=$g_name?>' > 
	<input type='hidden' name='g_user'			value='<?=$gg_user?>' > 
	<input type='hidden' name='mode_in'		value='' > 
	<input type='hidden' name='mode_up'		value='' > 
	<input type='hidden' name='seq_no' id='seq_no'	value='<?=$_REQUEST['seq_no']?>' > 
	<input type='hidden' name='page'			value='<?=$page?>' > 
	<input type='hidden' name='mode'			value='<?=$mode?>' > 
	<input type='hidden' name='mode_insert'			value='insert_mode' > 
	<input type='hidden' name='pg_'				value='<?=$pg_?>' > 
	<input type='hidden' name='target_'			value='<?=$target_?>' > 
	<input type='hidden' name='type_'			value='<?=$type_?>' > 
	<input type='hidden' name='data'			value='<?=$sdata?>' > 
	<input type='hidden' name='num'				value='' > 
	<input type='hidden' name='webnum'			value='' > 
	<input type='hidden' name='gong_num' value='0'>
	<input type='hidden' id='g_name_code' name='g_name_code' value='<?=$g_name_code?>'>

<div id="mypanel" class="ddpanel">
<div id="mypanelcontent" class="ddpanelcontent">
<table border='0' bgcolor='#cccccc' width='100%'>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Project</td>
		<td bgcolor='#ffffff'>&nbsp; 
			<select name='sel_g_name' onchange="change_g_name_func(this.value);" title="select Project">
				<option value=''>Project select</option>
				<!-- <option value='ETC:ETC:<?=$H_ID?>:' <?php if($g_name_code=='ETC' || $g_name_code=='') echo "selected"; ?>>ETC</option> -->
<?php
				$result = sql_query( "select * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name asc" );
				while($rs = sql_fetch_array($result)) {
					if($temp_g_name != $rs['group_name']) {
						$temp_g_name = $rs['group_name'];
?>
						<option value='<?=$rs['group_name']?>:<?=$rs['group_code']?>:<?=$rs['userid']?>:<?=$rs['seqno']?>' <?php if($rs['group_name']==$g_name) echo "selected"; ?>><?=$rs['group_name']?></option>
<?php
						}
				}
?>
			</select>
			<input type='hidden' id='g_name' name='g_name' size='10' value='<?=$g_name?>' readonly> 
		</td>
	</tr>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; Title</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp; <input type='text' id='title_nm' name='title_nm' size='20' value='<?=$title_?>' onKeyDown="check_enter()" >
		</td>
	</tr>

	<tr>
		<td bgcolor='#f4f4f4' height='30'><font color='black'>&nbsp; URL </td>
		<td bgcolor='#ffffff'>&nbsp; <input type='text' id='url_nm' name='url_nm' size='70' maxlength='550'  value='<?=$link_?>'>
		</td>
	</tr>
	
	<tr>
		<td bgcolor='#f4f4f4'><font color='black'>&nbsp; Memo</td>
		<td bgcolor='#ffffff'><font color='black'>&nbsp;
		<textarea id="memo" name="memo" rows="4" cols="50"><?=$memo?></textarea>

			<input type='hidden' id='encrypted_check' name='encrypted_check' value='<?=$H_ID?>'>
			<br> &nbsp; Encryption key:<input type='password' id='form_psw' name='form_psw' size='4' value=''> 
				 &nbsp; <input type='button'  id='Save_encrypted' onclick="javascript:Save_encrypted();" value='Encryption' style="background-color:red;color:yellow;height:25;">
				 &nbsp; <input type='button'  id='Decryption' onclick="javascript:Decryption();" value='Decryption' style="background-color:blue;color:yellow;height:25;">
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
			<input type='button' id="upd_save_button" onclick="javascript:contents_upd_run();" value='Save Changes' style="background-color:blue;color:yellow;height:25;display:;">
			<input type='button' id="upd_cancle" onclick="javascript:Cancle_run();" value='Cancel Change' style="background-color:red;color:yellow;height:25;display:;">
<?php if( isset($H_ID) && $H_ID !== "") { ?>
<?php 
			if ( $mode == 'update_link') { ?>			
				<input id="upd_save_button" type='button'  onclick="javascript:contents_upd_run();" value='Save Changes' style="background-color:blue;color:yellow;height:25;">
				<input id="upd_cancle" type='button'  onclick="javascript:Cancle_run();" value='Cancel Change' style="background-color:red;color:yellow;height:25;">
<?php		} else { ?>			
				<!-- <input type='button'  onclick="javascript:insert_url_func();" value='Save' style="background-color:green;color:yellow;height:25;" title='Save the link.'> --> User:<?=$H_ID?>
<?php		} ?>			
				<input id="save_button" type="submit" value="Note Save" style="background-color:blue;color:yellow;height:25;" /><!-- curl run button -->
<?php } ?> 

		</td>
	</tr>
	</form>
</table>
</div>
<div id="mypaneltab" class="ddpaneltab" >
<a href="#" ><span style="background-color:;color:yellow;">Note Create</span> </a>
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
				<a href="javascript:void()" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Project List [▼]</b></font>
				</a> 
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
	if( isset($H_ID) && $H_LEV > 1 ) {
		$sql = "select * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name ";
		$ttt = "mylist";
		$tM = "mylist";
	} else {
		$sql = "select * from {$tkher['table10_group_table']} order by group_name ";
		$ttt = "ALL-List";
		$tM = "";
	}
?>
				<tr>
				<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;
					<img src='../icon/left_icon.gif'>
					<a href="./ulink_list_curl.php?g_type=<?=$tM?>" target='iframe_url'>&nbsp;
					<font color='blue'><?=$ttt?></a>
				</td>
				</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list_curl.php?g_type=P" target='iframe_url'>Program list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list_curl.php?g_type=N" target='iframe_url'>Note list</a>
		<!-- <a href="ulink_list_curl.php?g_type=D" target='iframe_url'>Note list</a> -->
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list_curl.php?g_type=G" target='iframe_url'>Board list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list_curl.php?g_type=T" target='iframe_url'>Link list</a>
		</td>
		</tr>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list_curl.php?g_type=M" target='iframe_url'>Menu list</a>
		</td>
		</tr>
<?php
	$result = sql_query( $sql );
	$j=0;
	while( $rs = sql_fetch_array( $result )  ) { //m_("nm: " .$rs['group_name']);
?>
		<tr>
		<td width='130' height='24' background='../icon/admin_submenu.gif'>&nbsp;<img src='../icon/left_icon.gif'>
		<a href="ulink_list_curl.php?g_name=<?=$rs['group_name']?>:<?=$rs['userid']?>" target='_top'><?=$rs['group_name']?></a>
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
		if( $mode == 'search_rtn') {
			$sdata = $title_nm;
		}
		//m_("1 mylist ---: " . $g_name . ", g_type: " . $g_type);//1 mylist ---: , g_type: my-list
		$ls = "SELECT kapp_server from {$tkher['job_link_table_curl']} ";
		$result = sql_query( $ls );
		$total = sql_num_rows($result);
		if(!$page) $page=1; 
		$total_page = intval(($total-1) / $limite)+1; 
		$first = ($page-1)*$limite; 
		$last = $limite; 
		if($total < $last) $last = $total;
		$limit = " limit $first,$last";
		if( $page == "1")
			$no = $total;
		else {
			$no = $total - ($page - 1) * $limite;
		}
		if( $sdata )  $g_nameX = "Search : " . $sdata;
		else if( !$g_name ) $g_nameX = " page:" . $page . ", [count:" .$total. "]";
		else $g_nameX = "Group: " . $g_name;
		if( $H_ID ) $g_nameX = $g_nameX . ", level:" . $member['mb_level'] . "," .$member['mb_email'];
?>
<table class='floating-thead' width='100%'>
<thead  width='100%'>
		<tr align='center'>
			<TH>icon</TH>
			<TH>User</TH>
			<!-- <TH>Server</TH> -->
			<TH>Title</TH>
			<TH>Url</TH>
			<TH>Type</TH>
			<TH>date</TH>
		</tr>
</thead>
<tbody width='100%'>
		<?php
		$ls = " SELECT * from {$tkher['job_link_table_curl']} ";
		$ls = $ls . " ";
		$ls = $ls . " ORDER BY up_day desc";
		$ls = $ls . " $limit ";
		$result = sql_query(  $ls );
		while ( $rs = sql_fetch_array( $result ) ) {
			$email	= $rs['email'];
			$link_title	= $rs['link_title'];
			$rs_kapp_server	= $rs['kapp_server'];
			$seqno		= $rs['seqno'];
			$gubun		= $rs['link_type'];
			$link_url  = $rs['link_url'];
			$memo       = $rs['memo'];
			$td_bg = '#000000';
			if( $gubun == 'T' )	{
				$icon='../icon/berry.png'; $gubunT='T-Berry';$t_color='white'; $i_tit='T : Link URL';
			} else if( $gubun == 'B' or    $gubun == 'D'){ 
				$icon='../icon/seed.png';  $gubunT='B-Seed';$t_color='cyan'; $i_tit='D or DOC : Document';
			} else if( $gubun == 'G' )	{ 
				$icon='../icon/pizza.png'; $gubunT='D-Pizza';$t_color='cyan'; $i_tit='B : Tree Document : Ebook';
			} else if( $gubun == 'P' )	{ // Program List
				$icon='../icon/pcman1.png'; $gubunT='Program';$t_color='cyan'; $i_tit='P : Program';
			}
			else if( $gubun=='F' ){
				$icon='../icon/land.png'; $gubunT='Land';$t_color='green';$i_tit='Board';}
			else if( $gubun=='A' ){
				$icon='../icon/ship.png'; $gubunT='A-board';$t_color='yellow'; $i_tit='A: T-ABoard';}
			else if( $gubun=='M' ){
				$icon='../icon/land.png'; $gubunT='BOM-Main';$t_color='yellow';$i_tit='M: Tree-Main';}
			else if( $gubun=='N' ){
				$icon='../icon/leaf.png'; $gubunT='BOM-Note';$t_color='yellow';$i_tit='N: Tree-Note';}
			else if( $gubun=='U' ){
				$icon='../icon/seed.png'; $gubunT='U-Leaf';  $t_color='white'; $i_tit='U: Link Note';}
			else $t_color='grace';
?>
				<tr> 
				  <td  bgcolor='black' width='30' ><img src='<?=$icon?>' width='30'></td>
				  <td  bgcolor='black' style="width:15%;color:<?=$t_color?>;"><?=$email?></td>
				  <!-- <td  bgcolor='black' style="width:15%;color:<?=$t_color?>;"><?=$rs_kapp_server?></td> -->
<?php		if( $rs['link_type']=='U' || $rs['link_type']=='N') { ?>
				  <td bgcolor='<?=$td_bg?>' title='<?=$memo?>'>
					<a href="#" style="background-color:black;color:<?=$t_color?>;"><?=$link_title?></a>
				  </td>
<?php		} else {?>
				  <td bgcolor='<?=$td_bg?>' title='<?=$memo?>'>
					<a href="#" style="background-color:black;color:<?=$t_color?>;"><?=$link_title?></a>
				  </td>
<?php		} ?>
				  <td style="background-color:black;color:<?=$t_color?>;width:80px;"><?=$link_url?></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:20px;"><?=$gubun?></td>
				  <td style="background-color:black;color:<?=$t_color?>;width:120px;"><?=$rs['up_day']?></td>
				</tr> 
<?php
		}//-------- Loop
?>
		  </td>
		</tr>
		<tr align="center"></tr>
</tbody>
</table>
<table width="100%"   bgcolor="#CCCCCC" >
  <tr>
    <td align="center" bgcolor="f4f4f4" >
<?php
if( isset($search) ) $search = $_REQUEST['search'];
else  $search = "";

$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
$last_page = $first_page+($page_num-1);
if($last_page > $total_page) $last_page = $total_page;
$prev = $first_page-1;

if( $page > $page_num) echo"[<a href=".$PHP_SELF."?page=".$prev."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >Prev</a>] ";
for($i = $first_page; $i <= $last_page; $i++)
{
	if($page == $i) echo" <b>$i</b> "; 
	else echo"[<a style='font-size:20px;font-weight:bold;' href=".$PHP_SELF."?page=".$i."&search=".$search."&sdata=".$sdata."&g_name=".$g_name."&g_type=".$g_type." >".$i."</a>]";
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
