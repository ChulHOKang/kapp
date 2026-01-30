<?php
	include_once('../tkher_start_necessary.php');

	$H_ID	= get_session("ss_mb_id");
	if( isset($H_ID) && $H_ID!='' ) {
		$H_LEV  = $member['mb_level'];
		$H_POINT= $member['mb_point'];
		$H_EMAIL= $member['mb_email'];
	} else {
		m_("my page login please");
		echo("<meta http-equiv='refresh' content='0; URL=../'>"); exit;
	}
	$ip     = $_SERVER['REMOTE_ADDR'];

	connect_count($host_script, $H_ID, 0, $referer);	// log count
	/*
		kapp_board_list.php : board_list3.php : table-{$tkher['aboard_infor_table']}
		- query_ok_new.php
	*/
	$day = date("Y-m-d H:i:s");
	$pg_ = 'kapp_board_list.php';
?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="../icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>

<style>
table { border-collapse: collapse; }
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }
	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
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

<?php
	if( isset($_POST['g_type']) ) $g_type = $_POST['g_type'];
	else if( isset($_REQUEST['g_type']) ) $g_type = $_REQUEST['g_type'];
	else $g_type= '';
	if( isset($_POST["sel_num"]) ) $sel_num= $_POST["sel_num"];
	else if( isset($_REQUEST["sel_num"]) ) $sel_num= $_REQUEST["sel_num"];
	else $sel_num ='';
	if( isset($_POST["memo"]) ) $memo = $_POST["memo"];
	else if( isset($_REQUEST["memo"]) ) $memo = $_REQUEST["memo"];
	else $memo ='';
	if( isset($_POST["mode"]) ) $mode = $_POST["mode"];
	else if( isset($_REQUEST["mode"]) ) $mode = $_REQUEST["mode"];
	else $mode ='';
	if( isset($_POST["sdata"]) ) $sdata = $_POST["sdata"];
	else if( isset($_REQUEST["sdata"]) ) $sdata = $_REQUEST["sdata"];
	else $sdata = '';
	if( isset($_POST['page']) ) $page= $_POST['page'];
	else if( isset($_REQUEST['page']) )   $page= $_REQUEST['page'];
	else $page = 1;
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ) $line_cnt = $_POST['line_cnt'];
	else $line_cnt	= 10;
	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
?>
<script language='javascript'>
<!--
	/*function init() {		// board create type:
		for (var k=0 ; k < makeform.fnclist.options.length ; k++) {
			v=makeform.fnclist.options[k].value;
		}
		for (var k=0 ; k < makeform.sellist.options.length ; k++) {
			var strAx = makeform.sellist.options[k].value
			var strA  = strAx.split("|")
			var fid = strA[1];
			fid = fid.substring( 0, fid.indexOf("!") )
			if((fid != "GSTR") && (fid != "GEND")) {
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
	}*/
	function fnclist_onclick(v) {
		var seli = makeform.fnclist.selectedIndex;
		var t = makeform.fnclist.options[seli].text;
		makeform.board_type_name.value = t;
		makeform.sellist_index.value   = v;
	}
	// 메뉴설명 byte 체크
	function chkDescription(){
		document.makeform.chkByte.value = (document.makeform.mncontents.value).length;
	}
	function Update_title(){ // board name update
		var seli = document.makeform.sellist.selectedIndex;
		if( seli < 0 ) {
			alert('Please select a bulletin board to change!'); return false;
		}
		var tnm = document.makeform.chgname.value;
		if( !tnm ) {
			alert(' Please enter your board name! '); return false;
		}
		var v = document.makeform.sellist.options[seli].value;
		var sel_v  = v.split("|");
		document.makeform.board_no.value = sel_v[0];
		document.makeform.board_gubun_value.value = sel_v[1];
		document.makeform.board_nm.value = sel_v[2];

		var t = document.makeform.sellist.options[seli].text;
		var c = document.makeform.chgname.value;
		document.makeform.mode.value ='Update_nm_change';
		document.makeform.action='query_ok_new.php';
		document.makeform.submit();
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
		if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0)	{
			alert('You used a special character.\nPlease re-enter it.');
			//허용이 안 되는 특수문자를 사용하셨습니다.\n다시 입력하시기 바랍니다.
			return false;
		}
		for ( j=0; j < makeform.sellist.options.length; j++ )	{
			if ( makeform.sellist.options[j].selected == true ) {
				/* group의 시작(start) & 끝(end) 그룹이름 변경하기 */
				var chkname = makeform.sellist.options[j].value
				var chkObjid = getObjid(chkname)
				makeform.sellist.options[j].text = chgStr
				if (document.makeform.mnhide.checked){
				  makeform.sellist.options[j].text = makeform.sellist.options[j].text + "<숨기기>"
					makeform.funchelp.value += getObjid(makeform.sellist.options[j].value) + "!:" + getObjseq(makeform.sellist.options[j].value) + "!:" + getfname(makeform.sellist.options[j].text) + "!:" + document.makeform.mncontents.value + "!#";
				} else{
					document.makeform.mnhide.checked = false
					makeform.funchelp.value += getObjid(makeform.sellist.options[j].value) + "!:" + getObjseq(makeform.sellist.options[j].value) + "!:" + getfname(makeform.sellist.options[j].text) + "!:" + document.makeform.mncontents.value + "!#";
				}
				isEdited = true
				return true
			}
		}
	}
	function New_Create() {

		var seli = makeform.fnclist.selectedIndex;
		if( seli < 0 ){
			alert("Select Board Type! board type seli: " + seli );//board type seli: 0
			return false;
		} else {
			var t = makeform.fnclist.options[seli].text;
			var v = makeform.fnclist.options[seli].value;
			makeform.board_type_name.value = t;
			makeform.sellist_index.value   = v; //t;
		}
	   if ( makeform.aboard_name.value === ""){
			alert (" Please enter your board name! ");
			makeform.aboard_name.focus();
			return;
		}
		if( v !=='3' && v !=='4' && v !=='5')
		{
			alert("board type error v: " + v );
			return false;
		}

		board_type_name = makeform.board_type_name.value;
		sellist_index = makeform.sellist_index.value;
	   var optStr, newOpt, tstr, newOpt2
	   if ( makeform.aboard_name.value==""){
			alert (" Please enter your board name! ");
			makeform.aboard_name.focus();
			return;
		} else {
			var chgStr = makeform.aboard_name.value;
			if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0){
				alert('You used a special character that is not allowed. ');
				return ;
			}
			sellist_i = makeform.sellist.options.length;
			for (i=0;i<makeform.sellist.options.length; i++){
				bnm = makeform.sellist.options[i].text;
				if ( chgStr == bnm ){
					alert("It is an existing name. "+"\n"+ " Please change your name.");
					makeform.aboard_name.focus();
					return false;
				}
			}
		}
		if ( !confirm("Create a bulletin board? " + chgStr)) return
		v = makeform.fnclist.options[seli].value;
		t = makeform.fnclist.options[seli].text;
		document.makeform.mode.value = "ADD_create_board_list3";
		document.makeform.action = "query_ok_new.php";
		makeform.submit();
	}
	function getFuncNameK(fid) {
		switch(fid) {
			case "TCOM01" : return "[General]"
			case "GCOM02" : return "[Standard]"
			case "GCOM03" : return "[Memo]"
			case "GCOM04" : return "[Image]"
			case "GCOM05!" : return "[Daum]"
			case "GCOM06" : return "[New2]"
			case "GCOM08" : return "[New3]"
			case "TCOM02" : return "[Line]"
			case "TCOM03" : return "[QnA]"
			default : return "[none]"
		}
	}
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
		var strA  = strAx.split("|");//$rsno|$home_url|$table_name
		makeform.board_no.value = strA[0]; // $rsno
		makeform.board_gubun_value.value = strA[1];
		var funcind = "funchelp" + selind;
		var category = "D02"
		if (selind >= 0 && makeform.sellist.options[selind].text != "")
		{
			var grpname = strA[1];
			if (( grpname == "group") || (grpname == "groupend") ||  (getObjid(grpname) == "GSTR") || (getObjid(grpname) == "GEND")) {
				makeform.chgname.value = chkGroup(makeform.sellist.options[selind].text)
				document.makeform.mncontents.value = ""
				document.makeform.chkByte.value = "0";
			}
			else {
				makeform.chgname.value = getfname( makeform.sellist.options[selind].text )
				var valname = strA[1];
				if (valname.length>0) {
					var valnameA = valname.split("!:")
					var strA = ""
					strA += valnameA[0] + valnameA[1]
				}
				if ((valnameA[1] != 0) && (category != "V02")){
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
			document.makeform.chgname.value = ""
			document.makeform.mncontents.value = ""
			document.makeform.chkByte.value = "";
			document.makeform.sellist.selectedIndex=-1
			return false
		}
	}
	function Update_func(no, num)
	{
			document.Board_List_Form.mode.value = "Update_func_my";
			document.Board_List_Form.no.value = no;
			document.Board_List_Form.infor.value = no;

			document.Board_List_Form.pageno.value = document.makeform.page.value;

			var sel_r = eval( "document.Board_List_Form.grant_read_"+num+".value");
			var sel_w = eval( "document.Board_List_Form.grant_write_"+num+".value");
			var sel_m = eval( "document.Board_List_Form.grant_memo_"+num+".value");
			var sel_s = eval( "document.Board_List_Form.skin_type_"+num+".value");
			document.Board_List_Form.xread.value  = sel_r;
			document.Board_List_Form.xwrite.value = sel_w;
			document.Board_List_Form.xmemo.value  = sel_m;
			document.Board_List_Form.xskin.value  = sel_s;
			document.Board_List_Form.pg.value  = "kapp_board_list.php";
			document.Board_List_Form.xfile_size.value  = eval( "document.Board_List_Form.file_size_"+num+".value");

			document.Board_List_Form.action='query_ok_new.php'; //'board_create_pop_ok.php';
			var res = confirm(" Are you sure you want to change the bulletin board properties? ");
			if (res) { document.Board_List_Form.submit(); }
	}
	function Set_func(no, num)
	{
			makeform.infor.value = no;
			makeform.no.value = no;
			makeform.action='board_list3_update.php';
			makeform.target='_blank';
			makeform.submit();
	}
	function page_move($page){
		document.makeform.page.value = $page;
		document.makeform.action='kapp_board_list.php';
		document.makeform.line_cnt.value = document.Board_List_Form.line_cnt.value;
		document.makeform.submit();
	}
	function Change_line_cnt( $line ){
		document.makeform.page.value = 1;
		document.makeform.line_cnt.value = document.Board_List_Form.line_cnt.value;
		document.makeform.action='kapp_board_list.php';
		document.makeform.submit();
	}
	function title_func(fld_code){       
		document.makeform.page.value = 1;                
		document.makeform.line_cnt.value = document.Board_List_Form.line_cnt.value;
		document.makeform.fld_code.value= fld_code;           
		document.makeform.mode.value='title_func';           
		document.makeform.action='kapp_board_list.php';
		document.makeform.submit();                         
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
<form name="makeform" method="post" action="query_ok_new.php">
			<input type="hidden" name="infor"       value="" >
			<input type="hidden" name="no" 	        value="" >
			<input type="hidden" name="new_insert" 	value="" >
			<input type="hidden" name="insert" 		value="" >
			<input type="hidden" name="club_menu" 	value="" >
			<input type="hidden" name="funchelp" 	value="">
			<input type="hidden" name="mode" 		value="">
			<input type='hidden' name='board_type_name'    value=''>
			<input type='hidden' name='board_gubun_value'  value=''>
			<input type='hidden' name='sellist_index' >
			<input type='hidden' name='board_no' value=''>
			<input type='hidden' name='board_nm' value=''>
			<input type='hidden' name='multy_menu_sel' >
			<input type='hidden' name='page' value="<?=$page?>" >
			<input type='hidden' name='line_cnt' value='' >
		<input type='hidden' name='fld_code' value='<?=$fld_code?>' > 

		<div id="mypanel" class="ddpanel">
		<div id="mypanelcontent" class="ddpanelcontent">
			<table border='0' bgcolor='#cccccc' width='100%'>
				<tr>
				   <td width="72%" valign="top" align="center">
					  <div id='menu_normal'>
						<table width="80%" border="0" cellspacing="0" cellpadding="0">
						   <tr>
							   <td valign="top" align="right" width="200">
								 <table cellspacing="0" cellpadding="0" width="200" border="0">
									<tr>
									  <td style='background-color:#000000;color:yellow;height:30px;text-align:center;' title=' Please select the type of board to be created! '>
										Type of board to add</font>
									  </td>
									</tr>
									<tr>
									  <td valign="top" align="left" bgcolor="#f5f5f5">
										 <select id="fnclist" style="WIDTH: 200px" onChange="fnclist_onclick(this.value)" multiple size="8" name="fnclist">
											  <option value="5">Standard Type</option> <!-- Daum Type -->
											  <option value="3">Memo Type</option>
											  <option value="4">Image Type</option>
										  </select>
									   </td>
									 </tr>
									 <tr>
										<td height="24">Board Name:<input id='aboard_name' maxlength='70' size='20' name='aboard_name' ></td>
									 </tr>
								 </table>
							   </td>
								<!-- ADD  -->
							   <td align="center">
								  <table cellspacing="0" cellpadding="0" width="100" align="center" border="0">
									<tr>
									  <td align="middle">
										 <input type='button' value='ADD->' onclick="javascript:New_Create()" title=' Create a bulletin board. Please select the type of bulletin board left! '>
									  </td>
									</tr>
								 </table>
								</td>
								<td valign="top" align="right" width="220">
									<table cellspacing="0" cellpadding="0" width="200" border="0">
									  <tr><!-- 666666 -->
										<td style='background-color:#000000;color:yellow;height:30px;text-align:center;'>Board List</td></tr>
									  <tr>
										 <td valign="top">

								 <select id="sellist" style="WIDTH: 200px" onChange="sellist_onclick()" name="sellist" size='10'>

	<?php
		$ls = "SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE make_id='$H_ID' ";
		$ls = $ls . " ORDER by in_date desc";
		$result = sql_query($ls);
		while($rs = sql_fetch_array($result)) {
			$rsno =$rs['no'];
			$home_url =$rs['home_url'];
			$table_name =$rs['table_name'];
	?>
			<option value="<?=$rsno?>|<?=$home_url?>|<?=$table_name?>"><?=$rs['name']?></option>
	<?php
		} // while
	?>
								   </select>


										</td>
									  </tr>
	 <script>
		//init();
	</script>
									  <tr>
										<td height="24">Change Board Title<br>
										   <input class='boxstyle' id='chgname' onKeyDown='CheckKey1()' onBlur='btncfm_onclick()' maxlength='70' size='20' name='chgname' >
										   <input type='button' value="Name Change" onClick="Update_title()" style="border:1px solid black;background-color:red;color:white;width:100px;height:27px;border-radius:20px;border:1 solid black;" title='Change the board name.'>
										   <input id='mnhide' onBlur='btncfm_onclick()' type='checkbox' align='absMiddle' name='mnhide' style="display:none; border:0;">
										   <textarea id='mncontents' onKeyUp='chkDescription()' name='mncontents' rows='3' cols='60' onChange='chkDescription()' style="display:none;"></textarea>
										   <input id='chkByte' readOnly size='4' value='0' name='chkByte' style="display:none;">

										 </td>
									   </tr>
								</table>
							  </td>
							 </tr>
						   </table>
						   </div>
						  </td>
						 </tr>

	</table>
	</div>
	<div id="mypaneltab" class="ddpaneltab"><a href="#"><span style="border-style:;background-color:;color:yellow;">Board Create</span></a></div>
</div>
</form>

<link rel="stylesheet" href="../include/css/kancss.css" type="text/css">
<table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
	<tr>
		<td align='left' colspan='9'>
			<script type="text/javascript" src="../include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="./" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Board Type [▼]</b></font>
				</a>
			</p>
			<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 600px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
	if( $H_LEV > 1 ){
?>
				<tr>
				<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;
					<img src='../logo/left_icon.gif'>
					<a href="./kapp_board_list.php?g_type=mylist" target='iframe_url'>&nbsp;
					<font color='blue'>My List</a>
				</td>
				</tr>
<?php
	}
?>
		<tr>
		<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;<img src='../logo/left_icon.gif'>
		<a href="kapp_board_list.php?g_type=S" target='iframe_url'>Standard type</a><!-- 5:stdandard, 3:memo, 4:image -->
		</td>
		</tr>

		<tr>
		<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;<img src='../logo/left_icon.gif'>
		<a href="kapp_board_list.php?g_type=M" target='iframe_url'>Memo type</a>
		</td>
		</tr>

		<tr>
		<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;<img src='../logo/left_icon.gif'>
		<a href="kapp_board_list.php?g_type=I" target='iframe_url'>Image type</a>
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
<?php
	$w = " ";
	$w1= " ";
	$w2= " ";
	$total_count = 0;
	$total_page  = 0;
	$start = 0;
	$last = 0;


	if( $g_type =='mylist' && isset($sdata) ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE make_id='$H_ID' and name like '%$sdata%'  $w ";
	} else if( $g_type =='mylist' ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE make_id='$H_ID' ";
	} else if( isset($sdata) ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE make_id='$H_ID' and name like '%$sdata%'  $w ";
	} else if( isset($g_type) ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		if( $g_type =='S'){		//$ls = $ls . " WHERE movie='1' || movie='2' || movie='5' ";
			$ls = $ls . " WHERE make_id='$H_ID' and movie='5' ";
		} else if( $g_type =='M') {
			$ls = $ls . " WHERE make_id='$H_ID' and movie='3' ";
		} else if( $g_type =='I') {
			$ls = $ls . " WHERE make_id='$H_ID' and movie='4' ";
		}
	} else {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE make_id='$H_ID' ";
	}
	if( ($result = sql_query( $ls ) )==false ){
		printf("Invalid query: %s\n", $ls);
		m_("board_list3 Select Error ");
		$total_count = 0;
	} else {
		$total_count = sql_num_rows($result);
		if( $total_count ) $total_page  = ceil($total_count / $line_cnt);
		else $total_page  =1;
		if( $page < 2) {
			$page = 1;
			$start = 0;
		} else {
			$start = ($page - 1) * $line_cnt;
		}
		$last = $line_cnt;
		if( $total_count < $last) $last = $total_count;
	}

	if( $total_count < $last) $last = $total_count;
	$SQL_limit	= "  limit " . $start . ", " . $last;

	$P_count = " page:" . $page . ", [count:" .$total_count. "]";
	if( $H_ID ) $P_count = $P_count . ", level:" . $H_LEV . "," .$member['mb_email'];
	else  $P_count = $P_count . ", Guest:";
?>
<Form name='Board_List_Form' method='post' >
	<input type='hidden' name='mode' >
	<input type='hidden' name='pageno' >
	<input type='hidden' name='no' >
	<input type='hidden' name='infor' >
	<input type='hidden' name='xread' >
	<input type='hidden' name='xwrite' >
	<input type='hidden' name='xmemo' >
	<input type='hidden' name='xskin' >
	<input type='hidden' name='xfile_size' >
	<input type='hidden' name='pg' >
		<tr>
			<td bgcolor='#f4f4f4'  align='center' colspan=7><font color='black'>&nbsp;<?=$P_count?>
							&nbsp;&nbsp;&nbsp; Page line:<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[this.selectedIndex].value);" style='height:20;'>
								<option value='10'  <?php if( $line_cnt=='10' )  echo " selected " ?> >10</option>
								<option value='15'  <?php if( $line_cnt=='15' )  echo " selected " ?> >15</option>
								<option value='30'  <?php if( $line_cnt=='30' )  echo " selected " ?> >30</option>
								<option value='50'  <?php if( $line_cnt=='50')   echo " selected " ?> >50</option>
								<option value='100' <?php if( $line_cnt=='100')  echo " selected " ?> >100</option>
							</select>
							</td>
		</tr>
<table class='floating-thead' width='100%'>
<thead  width='100%'>
		<tr style='color:black;' align='center'>
			<TH>no</TH>
			<TH style='color:white;' onclick="title_func('make_id')">user</TH>
			<TH style='color:white;' onclick="title_func('no')">info</TH>
			<TH style='color:white;' onclick="title_func('name')">board name</TH>
			<TH style='color:white;' title='data count'>data</TH>
			<TH style='color:white;'>file size</TH>
			<TH style='color:white;'>skin type</TH>
			<TH style='color:white;' title="data read level">read</TH>
			<TH style='color:white;' title="data write level">write</TH>
			<TH>memo</TH>
			<TH onclick="title_func('in_date')">Date</TH>
			<TH>exec</TH>
		</tr>
 </thead>

<tbody width='100%'>
<?php
	if( $fld_code!='' ) $OrderBy = " order by $fld_code ";    
	else $OrderBy	= " ORDER BY in_date desc, name ";
	$ls = $ls . $OrderBy;
	$ls = $ls . $SQL_limit;
	$line_no = 0;
	$line = 0;
	$i=1;
	$result = sql_query( $ls );
	while ( $rs = sql_fetch_array( $result ) ) {
		if ( $rs['grant_view'] == "1" ) $levR='Guest';
		else if ( $rs['grant_view'] == "2" ) $levR='Member';
		else if ( $rs['grant_view'] == "3" ) $levR='Only Me';
		else if ( $rs['grant_view'] == "8" ) $levR='System';
		else $levR = 'Guest';

		if ( $rs['grant_write'] == "1" ) $lev='Guest';
		else if ( $rs['grant_write'] == "2" ) $lev='Member';
		else if ( $rs['grant_write'] == "3" ) $lev='Only Me';
		else if ( $rs['grant_write'] == "8" ) $lev='System';
		else $lev='1';

		if ( $rs['movie'] == "5" )	$skin_='5.Standard Type';
		else if ( $rs['movie'] == "3" )	$skin_='3.Memo Type';
		else if ( $rs['movie'] == "4" )	$skin_='4.Image Type';
		else {
			$skin_ = '5.Standard Type'; // default
			$rs['movie'] = "5";
		}
		if( $rs['home_url']=='GCOM05!' ) $mk_gubun = 'Tree';
		else  $mk_gubun = 'Board';

		$query	= "SELECT * from aboard_" . $rs['table_name'] . " ";
		$mq1	= sql_query($query);
		$board_cnt = sql_num_rows($mq1);
		$rsno = $rs['no'];

?>

		  <tr>
				<td style='background-color:#FFFFFF' align='center'><?=$i?></td>
				<td style='background-color:#FFFFFF' align='center'><?=$rs['make_id']?></td>
			<td style='background-color:#FFFFFF' align='center'>
				<a href="./index_bbs.php?infor=<?=$rs['no']?>" target='_blank'><?=$rs['no']?></a></td>
			<td width='10%' bgcolor="#FFFFFF" title='make:<?=$mk_gubun?>, board no:<?=$rs['no']?>:aboard_<?=$rs['table_name']?>'>
				<a href="./index_bbs.php?infor=<?=$rsno?>" target='_blank'><?=$rs['name']?></a></td>
			<td style='background-color:#FFFFFF' align='center'><?=$board_cnt?></td><!-- data record count -->
			<td style='background-color:#FFFFFF' align='center' title="upload file use and size:<?=$rs['fileup']?>">
				<input type='text' name='file_size_<?=$line_no?>' value='<?=$rs['fileup']?>' title='upload file size change' size='1'>
			</td>
			<td bgcolor="#FFFFFF" align="center">
				<select name="skin_type_<?=$line_no?>">
					<option value="<?=$rs['movie']?>" selected ><?=$skin_?></option>
					<option value="5" >Standard Type</option>
					<option value="3" >Memo Type</option>
					<option value="4" >Image Type</option>
			  </select></td>
			<td bgcolor="#FFFFFF" align="center">
			<select name="grant_read_<?=$line_no?>">
				<option value="<?=$rs['grant_view']?>" selected ><?=$levR?></option>
				<option value="1" >Guest</option>
				<option value="2" >Member</option>
				<option value="3" >Only Me</option>
			<?php if( $H_LEV > 7 ) {  ?>
				<option value="8" >System</option>
			<?php }  ?>
			  </select>
			  <br>More than </td>
			<td bgcolor="#FFFFFF" align="center">
			<select name="grant_write_<?=$line_no?>">
				<option value="<?=$rs['grant_write']?>" selected ><?=$lev?></option>
				<option value="1" >Guest</option>
				<option value="2" >Member</option>
				<option value="3" >Only Me</option>
			<?php if( $H_LEV > 7 ) {  ?>
				<option value="8" >System</option>
			<?php }  ?>
			  </select>
			  <br>More than </td>
			<td bgcolor="#FFFFFF" align="center">
				<textarea name="grant_memo_<?=$line_no?>" class="input01" cols="30" rows="2"><?=$rs['memo']?></textarea></td>
			<td bgcolor="#FFFFFF" align="center"><?=date("Y/m/d", $rs['in_date'])?></td>
		<?php
if( isset($H_ID) && $H_LEV > 1){
		?>
			<td bgcolor="#FFFFFF" align="center">
				<input type='button' value="Change" onClick="Update_func('<?=$rsno?>','<?=$line_no?>')" style="cursor:hand;" title='<?=$rsno?> - Confirm - Save the skin and read and write permissions.'>
				<!-- <input type='button' value="Set" onClick="Set_func('<?=$rsno?>','<?=$line_no?>')" style="cursor:hand;" title='Set - It makes detailed setting of bulletin board. '> -->
				<input type='button' value='Run' onclick="javascript:window.open('index_bbs.php?infor=<?=$rsno?>','_blank','')" style="cursor:hand;" title=' Run the bulletin board. '>
			</td>

		<?php
} else {
		?>
			<td bgcolor="#FFFFFF" align="center">
				<input type='button' value='Run' onclick="javascript:window.open('index_bbs.php?infor=<?=$rsno?>','_blank','')" style="cursor:hand;" title=' Run the bulletin board. '>
			</td>
		<?php
}
		?>
		  </tr>
		<?php
			$line_no = $line_no +1;
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
		paging("kapp_board_list.php?id=$H_ID",$total_count,$page,$line_cnt);
?>
	</td>
  </tr>
</table>
</form>

</body>
</html>
<?php
function paging($link, $total, $page, $size){
	global $line;
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	//if($page>1) $first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	//else $first_page = 0;

	$last_page  = $first_page+($page_num-1);
	if( $last_page > $total_page) $last_page = $total_page;

	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>[First]</a><span>&nbsp;</span>");
	} else {
		echo("<span>[Start]&nbsp;</span>");
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		echo("<a href='javascript:page_move($back_page)' >[Prev]</a><span>&nbsp;</span>");
	} else {
		//echo("<img src=./include/img/btn/btn_prev.png width=30 title='Previous'>");
		//echo("<span>[Prev].</span>");
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("<a href='javascript:void(0)' class=on>$i</a><span>&nbsp;</span>"); }
		else { echo("<a href='javascript:page_move($i)' title='page:$i'>[$i]</a><span>&nbsp;</span>"); }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'>[Next]</a><span>&nbsp;</span>");
	}else {
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo("<span>[Next].</span>");
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
	}
	echo "</div>";
}

?>
