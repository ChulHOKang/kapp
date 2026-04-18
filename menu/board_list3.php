<?php
	include_once('../tkher_start_necessary.php');

	$H_ID	= get_session("ss_mb_id");
	if( $H_ID !=''){
		if( isset($member['mb_email']) ) $H_EMAIL = $member['mb_email'];
		else $H_EMAIL = '';
		if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
		else $H_LEV	= 1;
	} else {
		$H_EMAIL = '';
		$H_LEV= 1;
	}
	connect_count($host_script, $H_ID, 0, $referer);	// log count
	/*
		board_list3.php : table-{$tkher['aboard_infor_table']}
		- query_ok_new.php
	*/
	$day = date("Y-m-d H:i:s");
	$pg_ = 'board_list3.php';
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
textarea {
	  width: 200px;
	  height: 50px;
	  padding: 0px;
	  border: 2px solid #ccc;
	  border-radius: 0px;
	  background-color: #000000;
	  font-family: Arial, sans-serif;
	  font-size: 12px;
	  color: #fff;
	}
	textarea:focus {
	  border-color: #007bff; /* Changes border color on focus */
	  outline: none; /* Removes default outline on focus */
	}

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
		boarder: 1px solid yellow;
	}
</style>

<script src="//code.jquery.com/jquery.min.js"></script>
<script>
$(function () {
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			switch(e.target.innerText){
				case 'User'    : title_func('make_id'); break;
				case 'info'    : title_func('no'); break;
				case 'board name': title_func('name'); break;
				case 'Date'    : title_func('in_date'); break;
				default        : title_func(''); break;
			}
		}, 250); // 약 300ms 대기 후 실행
	  
	});

	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer);
			switch(e.target.innerText){
				case 'User'    : title_wfunc('make_id'); break;
				case 'info'    : title_wfunc('no'); break;
				case 'board name': title_wfunc('name'); break;
				case 'Date'    : title_wfunc('in_date'); break;
				default        : title_wfunc(''); break;
			}
	});

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
<script language='javascript'>
<!--
	function fnclist_onclick(v) {
		var seli = document.kapp_aboard_Formfnclist.selectedIndex;
		var t = document.kapp_aboard_Formfnclist.options[seli].text;
		document.kapp_aboard_Formboard_type_name.value = t;
		document.kapp_aboard_Formsellist_index.value   = v;
	}
	function chkDescription(){
		document.kapp_aboard_FormchkByte.value = (document.kapp_aboard_Formmncontents.value).length;
	}
	function Update_title(){
		var seli = document.kapp_aboard_Formsellist.selectedIndex;
		if( seli < 0 ) {
			alert('Please select a bulletin board to change!'); return false;
		}
		var tnm = document.kapp_aboard_Formchgname.value;
		if( !tnm ) {
			alert(' Please enter your board name! '); return false;
		}
		var v = document.kapp_aboard_Formsellist.options[seli].value;
		var sel_v  = v.split("|");
		document.kapp_aboard_Formboard_no.value = sel_v[0];
		document.kapp_aboard_Formboard_gubun_value.value = sel_v[1];
		document.kapp_aboard_Formboard_nm.value = sel_v[2];

		var t = document.kapp_aboard_Formsellist.options[seli].text;
		var c = document.kapp_aboard_Formchgname.value;
		document.kapp_aboard_Formmode.value ='Update_nm_change';
		document.kapp_aboard_Formaction='query_ok_new.php';
		document.kapp_aboard_Formsubmit();
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
		var selStr = document.kapp_aboard_Formsellist
		var chgStr = document.kapp_aboard_Formchgname.value
		if (document.kapp_aboard_Formsellist.selectedIndex < 0) return
		if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0)	{
			alert('You used a special character.\nPlease re-enter it.');
			return false;
		}
		for ( j=0; j < document.kapp_aboard_Formsellist.options.length; j++ )	{
			if ( document.kapp_aboard_Formsellist.options[j].selected == true ) {
				var chkname = document.kapp_aboard_Formsellist.options[j].value
				var chkObjid = getObjid(chkname)
					document.kapp_aboard_Formsellist.options[j].text = chgStr
					if (document.kapp_aboard_Formmnhide.checked){
					  document.kapp_aboard_Formsellist.options[j].text = document.kapp_aboard_Formsellist.options[j].text + "<HIDDEN>"
						document.kapp_aboard_Formfunchelp.value += getObjid(document.kapp_aboard_Formsellist.options[j].value) + "!:" + getObjseq(document.kapp_aboard_Formsellist.options[j].value) + "!:" + getfname(document.kapp_aboard_Formsellist.options[j].text) + "!:" + document.kapp_aboard_Formmncontents.value + "!#";
					} else{
						document.kapp_aboard_Formmnhide.checked = false
						document.kapp_aboard_Formfunchelp.value += getObjid(document.kapp_aboard_Formsellist.options[j].value) + "!:" + getObjseq(document.kapp_aboard_Formsellist.options[j].value) + "!:" + getfname(document.kapp_aboard_Formsellist.options[j].text) + "!:" + document.kapp_aboard_Formmncontents.value + "!#";
					}
				isEdited = true
				return true
			}
		}
	}
	function New_Create() {

		var seli = document.kapp_aboard_Formfnclist.selectedIndex;
		if( seli < 0 ){
			alert("Select Board Type! board type seli: " + seli );
			return false;
		} else {
			var t = document.kapp_aboard_Formfnclist.options[seli].text;
			var v = document.kapp_aboard_Formfnclist.options[seli].value;
			document.kapp_aboard_Formboard_type_name.value = t;
			document.kapp_aboard_Formsellist_index.value   = v;
		}
	   if ( document.kapp_aboard_Formaboard_name.value === ""){
			alert (" Please enter your board name! ");
			document.kapp_aboard_Formaboard_name.focus();
			return;
		}
		if( v !=='3' && v !=='4' && v !=='5')
		{
			alert("board type error v: " + v );
			return false;
		}

		board_type_name = document.kapp_aboard_Formboard_type_name.value;
		sellist_index = document.kapp_aboard_Formsellist_index.value;
	   var optStr, newOpt, tstr, newOpt2
	   if ( document.kapp_aboard_Formaboard_name.value==""){
			alert (" Please enter your board name! ");
			document.kapp_aboard_Formaboard_name.focus();
			return;
		} else {
			var chgStr = document.kapp_aboard_Formaboard_name.value;
			if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0){
				alert('You used a special character that is not allowed. ');
				return ;
			}
			sellist_i = document.kapp_aboard_Formsellist.options.length;
			for (i=0;i<document.kapp_aboard_Formsellist.options.length; i++){
				bnm = document.kapp_aboard_Formsellist.options[i].text;
				if ( chgStr == bnm ){
					alert("It is an existing name. "+"\n"+ " Please change your name."); 
					document.kapp_aboard_Formaboard_name.focus();
					return false;
				}
			}
		}
		if ( !confirm("Create a bulletin board? " + chgStr)) return
		v = document.kapp_aboard_Formfnclist.options[seli].value;
		t = document.kapp_aboard_Formfnclist.options[seli].text;
		document.kapp_aboard_Formmode.value = "ADD_create_board_list3";
		document.kapp_aboard_Formaction = "query_ok_new.php";
		document.kapp_aboard_Formsubmit();
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
		var selind = document.kapp_aboard_Formsellist.selectedIndex
		var strAx = document.kapp_aboard_Formsellist.options[selind].value
		var strA  = strAx.split("|");
		document.kapp_aboard_Forminfor.value = strA[0];
		document.kapp_aboard_Formboard_no.value = strA[0];
		document.kapp_aboard_Formboard_gubun_value.value = strA[1];
		var funcind = "funchelp" + selind;
		var category = "D02"
		if( selind >= 0 && document.kapp_aboard_Formsellist.options[selind].text != ""){
			var grpname = strA[1];
			if (( grpname == "group") || (grpname == "groupend") ||  (getObjid(grpname) == "GSTR") || (getObjid(grpname) == "GEND")) {
				document.kapp_aboard_Formchgname.value = chkGroup(document.kapp_aboard_Formsellist.options[selind].text)
				document.kapp_aboard_Formmncontents.value = ""
				document.kapp_aboard_FormchkByte.value = "0";
			} else {
				document.kapp_aboard_Formchgname.value = getfname( document.kapp_aboard_Formsellist.options[selind].text )
				var valname = strA[1];
				if (valname.length>0) {
					var valnameA = valname.split("!:")
					var strA = ""
					strA += valnameA[0] + valnameA[1]
				}
				if( (valnameA[1] != 0) && (category != "V02")){ 
					var chkobjid = eval("document.kapp_aboard_Form" + strA + ".value")
					document.kapp_aboard_Formmncontents.value = eval("document.kapp_aboard_Form" + strA + ".value")
				}
				var strChgnm = document.kapp_aboard_Formchgname.value
				if( strChgnm.substring( strChgnm.indexOf("<")+1, strChgnm.indexOf(">")) == "HIDDEN"){
					document.kapp_aboard_Formmnhide.checked = true
					document.kapp_aboard_Formchgname.value = strChgnm.substring(0, strChgnm.indexOf("<"))
				} else{
					document.kapp_aboard_Formmnhide.checked = false
					document.kapp_aboard_Formchgname.value = getfname(document.kapp_aboard_Formsellist.options[selind].text)
				}
			}
			chkDescription()
			return true
		} else {
			document.kapp_aboard_Formchgname.value = ""
			document.kapp_aboard_Formmncontents.value = ""
			document.kapp_aboard_FormchkByte.value = "";
			document.kapp_aboard_Formsellist.selectedIndex=-1
			return false
		}
	}
	function Update_func(no, num){
			document.kapp_aboard_Formmode.value = "Update_func_run";
			document.kapp_aboard_Formno.value = no;
			document.kapp_aboard_Forminfor.value = no;
			document.kapp_aboard_Formpage.value = document.kapp_aboard_Formpage.value;
			var sel_r = eval( "document.kapp_aboard_Formgrant_read_"+num+".value");
			var sel_w = eval( "document.kapp_aboard_Formgrant_write_"+num+".value");
			var sel_m = eval( "document.kapp_aboard_Formgrant_memo_"+num+".value");
			var sel_s = eval( "document.kapp_aboard_Formskin_type_"+num+".value");
			var list_size_ = eval( "document.kapp_aboard_Formlist_size_"+num+".value");
			document.kapp_aboard_Formlist_size_.value  = list_size_;
			document.kapp_aboard_Formxread.value  = sel_r;
			document.kapp_aboard_Formxwrite.value = sel_w;
			document.kapp_aboard_Formxmemo.value  = sel_m;
			document.kapp_aboard_Formxskin.value  = sel_s;
			document.kapp_aboard_Formxfile_size.value  = eval( "document.kapp_aboard_Formfile_size_"+num+".value");
			document.kapp_aboard_Formaction='query_ok_new.php';
			var res = confirm(" Are you sure you want to change the bulletin board properties? ");
			if (res) { document.kapp_aboard_Formsubmit(); }
	}
	function Set_func(no, num){
			document.kapp_aboard_Forminfor.value = no;
			document.kapp_aboard_Formno.value = no;
			document.kapp_aboard_Formaction='board_list3_update.php'; 
			document.kapp_aboard_Formtarget='_blank';
			document.kapp_aboard_Formsubmit();
	}
	function Change_line_cnt( $line ){
		document.kapp_aboard_Formpage.value = 1;
		document.kapp_aboard_Formline_cnt.value = $line;
		document.kapp_aboard_Formaction='board_list3.php';
		document.kapp_aboard_Formsubmit();
	}
	function title_func(fld_code){       
		document.kapp_aboard_Formpage.value = 1;                
		document.kapp_aboard_Formline_cnt.value = document.kapp_aboard_Formline_cnt.value;
		document.kapp_aboard_Formfld_code.value= fld_code;           
		document.kapp_aboard_Formfld_code_asc.value= 'asc';
		document.kapp_aboard_Formmode.value='title_func';           
		document.kapp_aboard_Formtarget='_self';
		document.kapp_aboard_Formaction='board_list3.php';
		document.kapp_aboard_Formsubmit();                         
	} 
	function title_wfunc(fld_code){       
		document.kapp_aboard_Formpage.value = 1;
		document.kapp_aboard_Formfld_code.value= fld_code;
		document.kapp_aboard_Formfld_code_asc.value= 'desc';
		document.kapp_aboard_Formmode.value='title_wfunc';
		document.kapp_aboard_Formtarget='_self';
		document.kapp_aboard_Formaction='board_list3.php';
		document.kapp_aboard_Formsubmit();                         
	} 
	function page_move(thisform, $page, linkurl){
		thisform.page.value = $page;
		thisform.action= linkurl;
		thisform.submit();
	}
//-->
</script>

<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/include/css/dddropdownpanel.css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/dddropdownpanel.js"></script>

<body style='background-color:#fff;color:#000;' >
<?php
	include "../table_paging.php";
	$cur='C';
	include_once( KAPP_PATH_T_ . "/menu_run.php");

	if( isset($_POST['g_type']) ) $g_type = $_POST['g_type'];
	else if( isset($_GET['g_type']) ) $g_type = $_GET['g_type'];
	else $g_type= '';
	if( isset($_POST["sel_num"]) ) $sel_num= $_POST["sel_num"];
	else if( isset($_GET["sel_num"]) ) $sel_num= $_GET["sel_num"];
	else $sel_num ='';
	if( isset($_POST["memo"]) ) $memo = $_POST["memo"];
	else if( isset($_GET["memo"]) ) $memo = $_GET["memo"];
	else $memo ='';
	if( isset($_POST["mode"]) ) $mode = $_POST["mode"];
	else if( isset($_GET["mode"]) ) $mode = $_GET["mode"];
	else $mode ='';
	if( isset($_POST["sdata"]) ) $sdata = $_POST["sdata"];
	else if( isset($_GET["sdata"]) ) $sdata = $_GET["sdata"];
	else $sdata = '';
	if( isset($_POST['page']) ) $page= $_POST['page'];
	else if( isset($_GET['page']) )   $page= $_GET['page'];
	else $page = 1;
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ) $line_cnt = $_POST['line_cnt'];
	else if( isset($_GET['line_cnt']) && $_GET['line_cnt']!='' ) $line_cnt = $_GET['line_cnt'];
	else $line_cnt	= 10;
	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset( $_POST['fld_code_asc']) ) $fld_code_asc= $_POST['fld_code_asc'];
	else $fld_code_asc = '';
?>
<Form name='Aboard_List_Form' METHOD='POST' enctype="multipart/form-data" id="insert_form">
	<input type='hidden' name='xread' >
	<input type='hidden' name='xwrite' >
	<input type='hidden' name='xmemo' >
	<input type='hidden' name='xskin' >
	<input type='hidden' name='xfile_size' >
	<input type='hidden' name='list_size_' >

	<input type="hidden" name="run_pg"      value="<?=KAPP_URL_T_?>/menu/board_list3.php" >
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
	<input type='hidden' name='fld_code' value='<?=$fld_code?>' > 
	<input type="hidden" name='fld_code_asc' value='<?=$fld_code_asc?>' />

<?php if( $H_ID && $H_LEV > 1 ) { ?>
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
											  <option value="5">Standard Type</option>
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
									  <tr>
										<td style='background-color:#000000;color:yellow;height:30px;text-align:center;'>Board List</td></tr>
									  <tr>
										 <td valign="top">

								 <SELECT id="sellist" style="WIDTH: 200px" onChange="sellist_onclick()" name="sellist" size='10'>

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
	<?php }	?>
								   </SELECT>
										</td>
									  </tr>
									  <tr>
										<td height="24">Change Board Title<br>
										   <input class='boxstyle' id='chgname' onKeyDown='CheckKey1()' onBlur='btncfm_onclick()' maxlength='70' size='20' name='chgname' >
										   <input type='button' value="Name Change" onClick="Update_title()" style="border:1px solid black;background-color:red;color:white;width:100px;height:27px;border-radius:20px;" title='Change the board name.'>
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
	<div id="mypaneltab" class="ddpaneltab" ><span style="background-color:;color:yellow;"><a href="#" style='height:25px;color:yellow;'>&nbsp; &#9776; Board Create &nbsp;▼ &nbsp;</a></span>
	</div>
</div>

<?php } // H_ID check ?>

<!-- <link rel="stylesheet" href="../include/css/kancss.css" type="text/css"> -->
<table border='0' cellpadding='2' cellspacing='1' bgcolor='#cccccc' width='100%'>
	<tr>
		<td align='left' colspan='9'>
			<script type="text/javascript" src="../include/js/dropdowncontent.js"></script>
			<p align="left" style="margin-top: 0px">
				<a href="./" id="contentlink" rel="subcontent2">
					<font color='black' ><b>&#9776; Board Type [▼]</b></font>
				</a>
			</p>
		<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 210px; height: 100%px; padding: 4px;z-index:1000">
			<table border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='209'>
<?php
	if( $H_LEV > 1 ){
?>
				<tr>
				<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;
					<img src='../logo/left_icon.gif'>
					<a href="./board_list3.php?g_type=mylist" target='iframe_url'>&nbsp;
					<font color='blue'>My List</a>
				</td>
				</tr>
<?php
	}
?>
		<tr>
		<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;<img src='../logo/left_icon.gif'>
		<a href="board_list3.php?g_type=S" target='iframe_url'>Standard type</a><!-- 5:stdandard, 3:memo, 4:image -->
		</td>
		</tr>

		<tr>
		<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;<img src='../logo/left_icon.gif'>
		<a href="board_list3.php?g_type=M" target='iframe_url'>Memo type</a>
		</td>
		</tr>

		<tr>
		<td width='130' height='24' background='../logo/admin_submenu.gif'>&nbsp;<img src='../logo/left_icon.gif'>
		<a href="board_list3.php?g_type=I" target='iframe_url'>Image type</a>
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

	if( $g_type =='mylist' && isset($sdata) && $sdata!='' ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE make_id='$H_ID' and name like '%$sdata%'  $w ";
	} else if( $g_type =='mylist' ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE make_id='$H_ID' ";
	} else if( $sdata!='' ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		$ls = $ls . " WHERE name like '%$sdata%'  $w ";
	} else if( $g_type!='' ) {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
		if( $g_type =='S'){
			$ls = $ls . " WHERE movie='5' ";
		} else if( $g_type =='M') {
			$ls = $ls . " WHERE movie='3' ";
		} else if( $g_type =='I') {
			$ls = $ls . " WHERE movie='4' ";
		}
	} else {
		$ls = " SELECT * from {$tkher['aboard_infor_table']} ";
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
	$P_count = " page:" . $page . ", [total:" .$total_count. "]";
	if( $H_ID ) $P_count = $P_count . ", level:" . $H_LEV . "," .$member['mb_email'];
	else  $P_count = $P_count . ", Guest:";
?>
		<tr>
			<td bgcolor='#f4f4f4'  align='center' colspan=7><font color='black'>&nbsp;<?=$P_count?>&nbsp;&nbsp;&nbsp; Page line:
			<SELECT id='line_cnt' name='line_cnt' onChange="this.form.submit()" style='height:20;'>
<?php echo "<option value='$line_cnt' selected >$line_cnt</option>"; ?>
								<option value='5'>5</option>
								<option value='10'>10</option>
								<option value='15'>15</option>
								<option value='30'>30</option>
								<option value='50'>50</option>
								<option value='100'>100</option>
			</select>
			</td>
		</tr>
<table class='floating-thead' style="width:100%; table-layout:;">
<thead id='tit_et' width='100%'>
		<tr align='center'>
			<TH>no</TH>
<?php
	echo " <th title='User Sort click or doubleclick' >User</th> ";
	echo " <th title='info Sort click or doubleclick' >info</th> ";
	echo " <th title='board name Sort click or doubleclick' >board name</th> ";
	echo " <th title='Date Sort click or doubleclick' >Date</th> ";
?>
			
			<TH title='data count'>Data</TH>
			<TH>file size</TH>
			<TH>skin type</TH>
			<TH title="data read level">read</TH>
			<TH title="data write level">write</TH>
			<TH>memo</TH>
			<TH title='view line count'>line cnt</TH>
			<TH>CTL</TH>
		</tr>
 </thead>

<tbody width='100%' style='background-color:black;color:white;'>
<?php
	if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
	else $OrderBy	= " ORDER BY in_date desc, name ";
	$ls = $ls . $OrderBy;
	$ls = $ls . $SQL_limit;

	if( ($result = sql_query( $ls ) )==false ){
		$total_count = 0;
	}
	$line_no = 0;
	$i=1;
	while( $rs = sql_fetch_array( $result ) ) {
		$rsno = $rs['no'];
		$list_size = $rs['list_size'];
		$dateR = date('Y-m-d', $rs['in_date']);
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
?>
		  <tr>
				<td style='color:white;text-align:center;'><?=$i?></td>
				<td style='color:white;text-align:center;'><?=$rs['make_id']?></td>
			<td style='color:white;text-align:center;'>
				<a href="./index_bbs.php?infor=<?=$rsno?>" style='color:white;text-align:center;' target='_blank'><?=$rs['no']?></a></td>
			<td  style='color:white;text-align:left;' width='10%' title='make gubun:<?=$mk_gubun?>, board no:<?=$rsno?>:aboard_<?=$rs['table_name']?>'><img src="<?=KAPP_URL_T_?>/icon/default.gif">
				<a href="./index_bbs.php?infor=<?=$rsno?>" style='color:white;text-align:center;' target='_blank'><?=$rs['name']?></a></td>
			<td style='color:white;text-align:center;'><?=$dateR?></td>

			<td style='color:white;text-align:center;'><?=$board_cnt?></td>
			<td style='color:white;text-align:center;' title="upload file use and size:<?=$rs['fileup']?>">
				<input style='background-color:black;color:white;text-align:center;' type='text' name='file_size_<?=$line_no?>' value='<?=$rs['fileup']?>' title='upload file size change' size='1'>
			</td>
			<td style='color:white;text-align:center;'>
				<select name="skin_type_<?=$line_no?>" style='background-color:black;color:white;text-align:center;'>
					<option value="<?=$rs['movie']?>" selected ><?=$skin_?></option>
					<option value="5" >Standard Type</option>
					<option value="3" >Memo Type</option>
					<option value="4" >Image Type</option>
			  </select></td>
			<td style='color:white;text-align:center;'>
			<select name="grant_read_<?=$line_no?>" style='background-color:black;color:white;text-align:center;'>
				<option value="<?=$rs['grant_view']?>" selected ><?=$levR?></option>
				<option value="1" >Guest</option>
				<option value="2" >Member</option>
				<option value="3" >Only Me</option>
			<?php if( $H_LEV > 7 ) {  ?>
				<option value="8" >System</option>
			<?php }  ?>
			  </select>
			  <br>More than </td>
			<td style='color:white;text-align:center;'>
			<select name="grant_write_<?=$line_no?>" style='background-color:black;color:white;text-align:center;'>
				<option value="<?=$rs['grant_write']?>" selected ><?=$lev?></option>
				<option value="1" >Guest</option>
				<option value="2" >Member</option>
				<option value="3" >Only Me</option>
			<?php if( $H_LEV > 7 ) {  ?>
				<option value="8" >System</option>
			<?php }  ?>
			  </select>
			  <br>More than </td>
			<td style='color:white;text-align:center;'>
				<textarea name="grant_memo_<?=$line_no?>" style="border-style:;background-color:black;color:yellow;height:40px;width:15%px;"
				><?=$rs['memo']?></textarea></td>
			<td style='background-color:black;color:white;text-align:center;'>
				<input type='text' name='list_size_<?=$line_no?>' value='<?=$list_size?>' title='Change view line count' size='1'>
			</td>
		<?php
if( $H_LEV > 7 || isset($H_ID) && $rs['make_id']==$H_ID){
		?>
			<td style='color:white;text-align:center;'>
				<input type='button' value=" Change " onClick="Update_func('<?=$rsno?>','<?=$line_no?>')" style="border:1px solid black;background-color:red;color:white;width:100px;height:27px;border-radius:20px;" title='<?=$rsno?> - Confirm - Save the skin and read and write permissions.'>
			</td>

		<?php
} else {
		?>
			<td> ---
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

<?php
	paging("board_list3.php",$total_count,$page,$line_cnt, "document.Aboard_List_Form"); 
?> 
</form>
</body>
</html>
