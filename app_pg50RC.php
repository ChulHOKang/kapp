<?php
	include_once('./tkher_start_necessary.php');
	/*
		ap_pg50RC.php    : table_pg50RC.php copy. : 
		:  PG_curl_send() 
		: create and update Separate.
		: PC:app_pg50RC.php
		: PC:app_pg50RU.php
		: app_pg50RC_Test.php :test pg
	*/
	$H_ID	= get_session("ss_mb_id");
	if( !$H_ID || $H_ID =='' )	{
		m_("You need to login. ");
		$url="./";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_LEV =$member['mb_level'];
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<?php
		if( isset($_POST['mode']) ) $mode		= $_POST['mode'];
		else  $mode = "";
		if( isset($_POST['seqno']) ) $seqno		= $_POST['seqno'];
		else  $seqno = "";
		if( isset($_POST['pg_code']) ) $pg_code		= $_POST['pg_code'];
		else  $pg_code = "";
		if( isset($_POST['pg_name']) ) $pg_name		= $_POST['pg_name'];
		else  $pg_name = "";
		if( isset($_POST['tab_enm']) ) $tab_enm		= $_POST['tab_enm'];
		else  $tab_enm = "";
		if( isset($_POST['tab_hnm']) ) $tab_hnm		= $_POST['tab_hnm'];
		else  $tab_hnm = "";
		if( isset($_POST['tab_hnmS']) ) $tab_hnmS		= $_POST['tab_hnmS'];
		else  $tab_hnmS = "";
		if( isset($_POST['pg_codeS']) ) $pg_codeS		= $_POST['pg_codeS'];
		else  $pg_codeS = "";
		if( isset($_POST['project_nmS']) ) $project_nmS		= $_POST['project_nmS'];
		else  $project_nmS = "";
		/* no use 
		if( $mode == "project_change" ){
			if( isset( $project_nmS) )	{
				$aaP= explode(':', $project_nmS);
				$p_code		= $aaP[0];
				$p_name		= $aaP[1];
				//$pg_codeS = $_POST['pg_codeS'];
				$tab_codeS = $_POST['tab_hnmS'];
				$aa				= explode(':', $tab_codeS);
				$t_code		= $aa[0];
				$t_name		= $aa[1];
				$SQL = " UPDATE {$tkher['table10_pg_table']} set group_code='" .$p_code. "', group_name='" .$p_name. "' where tab_enm='" .$t_code. "' ";
				//echo "sql: " . $SQL; exit;
				m_( $t_name  . " 테이블의 프로제트가 " .$p_name. " 으로 변경 되었습니다.");
				sql_query( $SQL );
				
			}
		}*/
?>
<link href="./include/css/admin.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0">
 
<SCRIPT language=JavaScript src="cra_func.js"></SCRIPT>
<script language="JavaScript"> 
<!--
 	var frealname	= ''
	var isEdited    = false
	var delList		= ''
	var smode		= false
	var start, end, grpStr
	function fnclist_onclick() {
		for (var k=0 ; k < makeform.fnclist.options.length ; k++)
		{
		 if (makeform.fnclist.options[k].text != "" && makeform.fnclist.options[k].selected) {
				var fid = makeform.fnclist.options[k].value
				fid = fid.substring(0,fid.indexOf("!:"))
		 }
		}
	}
	function getfname(str) {
		if (str.indexOf("]") > 0) {
			frealname = str.substring(0, str.indexOf("]")+1)
			str = str.substr(str.indexOf("]")+2)
		}
		return str
	}
	function Pg_Dup_Check()	{
		pg_name = document.makeform.pg_name.value;
		var item_cnt = makeform.pg_codeS.options.length; 
		for (i = 0; i < item_cnt; i++) {
				var str_val = makeform.pg_codeS.options[i].value;
				var pgnm = makeform.pg_codeS.options[i].text;
				if(pg_name == pgnm){
					alert("Program name is duplicate. Please use a different name!");
					document.makeform.pg_name.focus();
					return false;
				}
		}
		return true;
	}
	function k_func_ok(r,j, ok){
		return;
	}
	function r_func(r,qna){
		qna1 = qna.split('^');
		len = qna1.length;
		ss="";
		for(i=0;i<len;i++){
			rr = qna1[i].split('|');
			lenj = rr.length-2;
			ok = rr.length-1;
			ss+=" &#160; <p><form><div>"+(i+1)+". "+rr[0]+"</div> ";
			for(k=0,j=1; k < lenj; k++, j++){
				ss+=" &#160; <label><span><input type='radio' name='qna' onclick=\"k_func_ok('"+ rr[j] +"', "+j+", "+rr[ok]+")\" value="+ rr[j] +">" +j+'. '  + rr[j]+" &#160; </span></label><br>";
			}
		}
		ss+="</form></p>";
		here.innerHTML=ss;
	}
	function rr_func( ss, qna ){
		if(!ss) r_func('A', qna);
		else here.innerHTML = ss;
	}
	function column_list_onclickAA( j ){
		document.getElementById('column_list'+j).checked=true;
		ss = document.getElementById('column_list'+j).value;
		var test = ss.split('|');
		document.makeform.column_index.value = j;
		makeform.column_name_change.value = test[2];
		iftype = document.makeform["iftype[" + j + "]"].value;
		if_data = document.makeform["if_data[" + j + "]"].value;
		if(iftype==0)	document.makeform.ifcheck[0].checked=true;
		else if(iftype==1)	document.makeform.ifcheck[1].checked=true;
		else if(iftype==3)	document.makeform.ifcheck[2].checked=true;
		else if(iftype==5)	document.makeform.ifcheck[3].checked=true;
		else if(iftype==9)	document.makeform.ifcheck[4].checked=true; 
		else if(iftype==7)	document.makeform.ifcheck[6].checked=true; 
		else if(iftype==11)	document.makeform.ifcheck[5].checked=true; 
		else if(iftype==13)	document.makeform.ifcheck[7].checked=true; 
		else				document.makeform.ifcheck[0].checked=true;
		if( iftype == 11) {
			jj = if_data.split(":");
			document.makeform.column_attribute.value = jj[1];
			document.makeform.calc.value = jj[0];	 
		} else if( iftype == 13) { // Popup
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1]; 
		} else document.makeform.column_attribute.value = if_data;
	}
	function column_list_onclickA( ss, j ){
		var test = ss.split('|'); 
		document.makeform.column_index.value = j;
		makeform.column_name_change.value = test[2];

		iftype = document.makeform["iftype[" + j + "]"].value;
		if_data = document.makeform["if_data[" + j + "]"].value;
		if(iftype==0)	document.makeform.ifcheck[0].checked=true;
		else if(iftype==1)	document.makeform.ifcheck[1].checked=true;
		else if(iftype==3)	document.makeform.ifcheck[2].checked=true;
		else if(iftype==5)	document.makeform.ifcheck[3].checked=true;
		else if(iftype==9)	document.makeform.ifcheck[4].checked=true; 
		else if(iftype==7)	document.makeform.ifcheck[6].checked=true; 
		else if(iftype==11)	document.makeform.ifcheck[5].checked=true; 
		else if(iftype==13)	document.makeform.ifcheck[7].checked=true; 
		else				document.makeform.ifcheck[0].checked=true;
		if( iftype == 11) { // Formula
			jj = if_data.split(":");
			document.makeform.column_attribute.value = jj[1];
			document.makeform.calc.value = jj[0];	 
		} else if( iftype == 13) { // Popup
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1]; 
		} else document.makeform.column_attribute.value = if_data;
	}
function downItemA() {
	var j = document.makeform.column_index.value;
	if ( j < 0 ){
		alert(' Please select a column! ' );
		return false;
	}
	var colnm = document.getElementsByName('column_list');
	var colnm_value ='';
	var len = colnm.length;
    var tmpValue, tmpText
	var end_line = len -1;
	if (j == end_line ) {
		alert('end_line j:' + j);
		return false; 
	}
	if (j < 0 ) {
		alert(' Please select a column! ' );
		return false;
	}
		i = j*1 +1; // 중요.
		tmppopdataJ = document.makeform["popdata[" + j + "]"].value;
		tmpifdataJ = document.makeform["if_data[" + j + "]"].value;
		tmpiftypeJ = document.makeform["iftype[" + j + "]"].value;
		tmppopdataK = document.makeform["popdata[" + i + "]"].value;
		tmpifdataK = document.makeform["if_data[" + i + "]"].value;
		tmpiftypeK = document.makeform["iftype[" + i + "]"].value;
		document.makeform["popdata[" + i + "]"].value= document.makeform["popdata[" + j + "]"].value;
		document.makeform["if_data[" + i + "]"].value= document.makeform["if_data[" + j + "]"].value;
		document.makeform["iftype[" + i + "]"].value = document.makeform["iftype[" + j + "]"].value;
		document.makeform["popdata[" + j + "]"].value= tmppopdataK; 
		document.makeform["if_data[" + j + "]"].value= tmpifdataK;
        document.makeform["iftype[" + j + "]"].value = tmpiftypeK;
		tmpValueJ = colnm[j].value;
		tmpValueI = colnm[i].value;
		document.getElementById('column_list'+j).value = tmpValueI;
		document.getElementById('column_list'+i).value = tmpValueJ;
		tmpValueJ = document.getElementById('column_list'+j).value;
		tmpValueI = document.getElementById('column_list'+i).value;
	var str_array = '';
    for (k = 0; k < colnm.length; k++) {
		colnm_value = colnm[k].value;
		st = colnm_value.split('|'); 
		str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
		document.getElementById('columnR'+k).innerHTML = st[2];
	}
	makeform.item_array.value = str_array;
	document.getElementById('column_list'+i).checked=true;
	document.makeform.column_index.value = i;
}
function upItemA() {
	var j = document.makeform.column_index.value;
	if ( j < 0 ){
		alert(' Please select a column! ' );
		return false;
	}
	var colnm = document.getElementsByName('column_list');
	var colnm_value='';
	var len = colnm.length;

    var tmpValue, tmpText

	var top_line = 0;
	var end_line = len -1;
	if (j == top_line ) {
		alert('top_line j:' + j);
		return false;
	}
	if (j < 0 ) {
		alert(' Please select a column! ' );
		return false;
	}
	i = j*1 -1; 
	tmppopdataJ = document.makeform["popdata[" + j + "]"].value;
	tmpifdataJ = document.makeform["if_data[" + j + "]"].value; 
	tmpiftypeJ = document.makeform["iftype[" + j + "]"].value;
	tmppopdataK = document.makeform["popdata[" + i + "]"].value;
	tmpifdataK = document.makeform["if_data[" + i + "]"].value;
	tmpiftypeK = document.makeform["iftype[" + i + "]"].value;
	document.makeform["popdata[" + i + "]"].value= document.makeform["popdata[" + j + "]"].value;
	document.makeform["if_data[" + i + "]"].value= document.makeform["if_data[" + j + "]"].value;
	document.makeform["iftype[" + i + "]"].value = document.makeform["iftype[" + j + "]"].value;
	document.makeform["popdata[" + j + "]"].value= tmppopdataK;
	document.makeform["if_data[" + j + "]"].value= tmpifdataK;
	document.makeform["iftype[" + j + "]"].value = tmpiftypeK;
	tmpValueJ = colnm[j].value;
	tmpValueI = colnm[i].value;
	document.getElementById('column_list'+j).value = tmpValueI;
	document.getElementById('column_list'+i).value = tmpValueJ;
	tmpValueJ = document.getElementById('column_list'+j).value;
	tmpValueI = document.getElementById('column_list'+i).value; 
	var str_array = '';
    for (k = 0; k < colnm.length; k++) {
		colnm_value = colnm[k].value;
		st = colnm_value.split('|');
		str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
		document.getElementById('columnR'+k).innerHTML = st[2];
	}
	makeform.item_array.value = str_array;
	document.getElementById('column_list'+i).checked=true;
	document.makeform.column_index.value = i; 
} 
function del_func() {
	var tab = document.makeform.tab_hnmS.value;
	var pg = document.makeform.pg_name.value;
	if( !tab || !pg) {
		alert(' Please select a table or program! tab:'+tab +', pg:'+pg_name );
		return false;
	}
	var j = document.makeform.column_index.value;
	if( j == '' ) {
		alert(' Please select a column! ' );
		return false;
	}
	resp = confirm(' Are you sure you want to exclude columns?'); 
	if( !resp ) return false; 
	var colnm = document.getElementsByName('column_list');
	var item_cnt = colnm.length;
	var end_line = colnm.length-1;
	var colnm_value='';
	var str_array="";
	var chk = 0;
	for(var i=0, j=1; i < colnm.length; i++, j++){
			colnm_value = colnm[i].value;
		if( colnm[i].checked ){
			if( i == end_line ){
				document.makeform.column_name_change.value = '';
				document.makeform.column_attribute.value = '';
			} else {
				colnm[i].checked=false;
				colnm_value = colnm[j].value;
				st = colnm_value.split('|');
				document.makeform.column_name_change.value = '';//st[2];
				document.makeform.column_attribute.value = '';
			}
			chk = 1;
		}
		if( chk == 1){
			if( i == end_line ){
				document.makeform["if_data[" + i + "]"].value = '';
				document.makeform["iftype[" + i + "]"].value = '';
				document.makeform["popdata[" + i + "]"].value = '';
			} else {
				colnm_value = colnm[j].value;
				document.getElementById('column_list'+i).value = colnm_value;
				st = colnm_value.split('|');
				document.getElementById('columnR'+i).innerHTML = st[2];
				tmpifdataJ = document.makeform["if_data[" + j + "]"].value;
				tmpiftypeJ = document.makeform["iftype[" + j + "]"].value;
				tmppopdataJ = document.makeform["popdata[" + j + "]"].value;
				document.makeform["popdata[" + i + "]"].value = tmppopdataJ;
				document.makeform["if_data[" + i + "]"].value = tmpifdataJ;
				document.makeform["iftype[" + i + "]"].value = tmpiftypeJ;
			}
		}
	}	
	var kk = item_cnt -1;
	document.makeform.item_cnt.value = kk;
	fld_msg = document.getElementById('column_list'+kk).value;
	document.getElementById('column_list'+kk).value = '';
	document.getElementById('columnRX'+kk).innerHTML = '';
	document.makeform.column_index.value = '';
	var str_array = '';
    for (k = 0; k < kk; k++) {
		colnm_value = colnm[k].value;
		st = colnm_value.split('|');       //val:275|fld_2|job|CHAR|10
		str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
	}
	makeform.item_array.value = str_array;
	return;
}
function ifcheck_onclickA(r, seq) {
	if(document.makeform.pg_name.value == ""){
		alert("Create Program name");
		return;
	}
	alert("After creating the program, proceed with Program Upgrade!"); 
	return; 
} 
function Apply_button() {
	var selind = document.makeform.column_index.value;
	if ( selind < 0 ){
		alert(' Select column!');
		return;
	}
	var chgStr = document.makeform.column_attribute.value;
	if( !chgStr ) {
		alert(' Please enter a property! ' );
		return false;
	}
	var pg      = document.makeform.pg_codeS.value; 
	var tab     = document.makeform.tab_hnmS.value;
	var pg_name = document.makeform.pg_name.value;
	if( !tab ) {
		alert(' Please select a table! ' );
		return false;
	}
	if( !pg_name) {
		alert(' Please select or enter program name!' );
		document.makeform.pg_name.focus();
		return false;
	}
	var colnm = document.getElementsByName('column_list');
	var colnm_value = colnm[selind].value;
	var test = colnm_value.split('|');
	colnm_hnm = test[2];
	ii = document.makeform["iftype[" + selind + "]"].value;
	if(ii==1 || ii==3 || ii==5  || ii==7  || ii==9 ){ // 1:radio button, 3:check box, 5:listbox, 7:password, 9: attache file .
		if(ii==1) msg='1:radio button';
		else if(ii==3) msg='3:check box';
		else if(ii==5) msg='5:list box';
		if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("^")>=0 || chgStr.indexOf("%")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0 || chgStr.indexOf("$")>=0 || chgStr.indexOf("@")>=0 || chgStr.indexOf("&")>=0 || chgStr.indexOf("*")>=0 || chgStr.indexOf("~")>=0 || chgStr.indexOf("(")>=0 || chgStr.indexOf(")")>=0 || chgStr.indexOf("#")>=0 || chgStr.indexOf("!")>=0 || chgStr.indexOf("`")>=0 || chgStr.indexOf(";")>=0 )
		{
			alert(' You used a special character that is not allowed. \n Please enter it again.');// \n 허용이 안 되는 특수문자를 사용하셨습니다. \n 다시 입력하시기 바랍니다.
			return false;
		}
		document.makeform["if_data[" + selind + "]"].value = chgStr;
		document.makeform["iftype[" + selind + "]"].value = ii;
		alert(""+chgStr+" : OK set");
	} else {
		alert(' Please enter a property! 1:radio button or 3:check box or 5:listbox Only' );
		return false;
	}
}
function titlechange_btncfm_onclickA() {
	var chgStr = makeform.column_name_change.value;
	if( chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("^")>=0 || chgStr.indexOf("%")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0 || chgStr.indexOf("$")>=0 || chgStr.indexOf("@")>=0 || chgStr.indexOf("&")>=0 || chgStr.indexOf("*")>=0 || chgStr.indexOf("~")>=0 || chgStr.indexOf("(")>=0 || chgStr.indexOf(")")>=0 || chgStr.indexOf("#")>=0 || chgStr.indexOf("!")>=0 || chgStr.indexOf("`")>=0 || chgStr.indexOf(";")>=0 )
	{
		alert(' You used a special character that is not allowed. \n Please enter it again.');
		return false;
	}
	var j = document.makeform.column_index.value;
	if ( j < 0){
		alert(' Select column!');
		return;
	}
	var colnm_value = "";
	var colnm = document.getElementsByName('column_list');
	var test = "";
	var new_column = "";
	for(var i = 0, j=0; i < colnm.length; i++, j++){
		colnm_value = colnm[i].value;
		test = colnm_value.split('|');
		fld_hnm = test[2];
		if (chgStr == fld_hnm ) {
			alert("This name already exists.");
			return false;
		}
		if( colnm[i].checked ){
			new_column = test[0]+'|'+test[1]+'|'+chgStr+'|'+test[3]+'|'+test[4];
			document.getElementById('column_list'+j).value = new_column;
			var cnm = document.getElementById('column_list'+j).value;
			document.getElementById('columnR'+j).innerHTML = chgStr;
		}
	}	
	colnm = document.getElementsByName('column_list');
	str_array = "";
	for (i = 0; i < colnm.length; i++) {
		colnm_value = colnm[i].value;
		st = colnm_value.split('|');
		str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
	} 
	document.makeform.item_array.value = str_array;
	return;
}
function Save_and_Run(pg)
{
	pg_name = document.makeform.pg_name.value;
	if( !pg_name ) {
		alert(" Please enter the program name!");
		document.makeform.pg_name.focus();
		return false;
	}
	var tab_selind = makeform.tab_hnmS.selectedIndex; 
	var tab_val    = makeform.tab_hnmS.options[tab_selind].value;
	var tabnm      = makeform.tab_hnmS.options[tab_selind].text;
	if( !tab_selind && !tabnm) {
		alert(tab_selind+" :  Please select a table! ");
		document.makeform.pg_name.focus();
		return false;
	}
	var str_array="";
	var colnm = document.getElementsByName('column_list');
	var st = "";
	var item_cnt = colnm.length;
	for (i = 0; i < item_cnt; i++) {
		colnm_value = colnm[i].value;
		st = colnm_value.split('|');
		str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
	} 
	document.makeform.item_array.value = str_array;
	document.makeform.mode.value = 'pg_new_create2'; 
	document.makeform.mode_call.value = 'app_pg50RC';
	document.makeform.action='tkher_program_run.php';
	document.makeform.target='tab_pg_list';
	document.makeform.submit();
}
function Create_button(pg) {
	var p_selind = makeform.project_nmS.selectedIndex; 
	var p_val    = makeform.project_nmS.options[p_selind].value;
	var p_nm      = makeform.project_nmS.options[p_selind].text;
	if( p_nm=='1.Select Project' || p_nm=='' ){
		alert( p_selind+" : p_val: " + p_val + ", p_nm:" + p_nm + " Please select a project! ");
		return;
	}

	pg_name = document.makeform.pg_name.value;
	if( !pg_name ) {
		alert(" Please enter the program name!");
		document.makeform.pg_name.focus();
		return false;
	}
	var tab_selind = makeform.tab_hnmS.selectedIndex; 
	var tab_val    = makeform.tab_hnmS.options[tab_selind].value;
	var tabnm      = makeform.tab_hnmS.options[tab_selind].text;
	if( !tab_selind && !tabnm) {
		alert( tab_selind+" :  Please select a table! ");
		document.makeform.pg_name.focus();
		return false;
	}
	var str_array="";
	var colnm = document.getElementsByName('column_list');
	var st = "";
	var item_cnt = colnm.length;
	for (i = 0; i < item_cnt; i++) {
		colnm_value = colnm[i].value;
		st = colnm_value.split('|');
		str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
	} 

	if( pg == "app_pg50RC_Create") {
		if( !Pg_Dup_Check() ) return false;
		else document.makeform.dup_check.value = 1;
		alert(' OK : '+pg_name+ ', ' + document.makeform.dup_check.value);
		document.makeform.pg_make_set.value = "ok";
		document.makeform.item_array.value = str_array;
		document.makeform.mode.value = 'pg_new_create'; 
		document.makeform.mode_call.value = 'app_pg50RC';
		document.makeform.action='app_pg50RC.php'; 
		document.makeform.target='_self';
		document.makeform.submit();
	}
}
function Project_Update(mode){
	var p_selind = makeform.project_nmS.selectedIndex; 
	var p_val    = makeform.project_nmS.options[p_selind].value;
	var p_nm     = makeform.project_nmS.options[p_selind].text;
	if( p_nm=='1.Select Project' || p_nm=='' ){
		alert(p_selind+" : p_val: " + p_val + ", p_nm:" + p_nm + " Please select a project! ");
		return;
	} else {
		var tab_selind = makeform.tab_hnmS.selectedIndex; 
		var tab_val    = makeform.tab_hnmS.options[tab_selind].value;
		var tabnm      = makeform.tab_hnmS.options[tab_selind].text;
		if( tabnm == '1.Select table') {
			alert(tab_selind+" :  Please select a table! ");
			document.makeform.pg_name.focus();
			return false;
		}
		document.makeform.mode.value = mode; 
		document.makeform.mode_call.value = 'app_pg50RC_Test';
		document.makeform.action='app_pg50RC.php'; 
		document.makeform.target='_self';
		document.makeform.submit();
	}
}
function change_project_func(pnmS){
	var p_selind = document.makeform.project_nmS.selectedIndex; 
	var p_val    = document.makeform.project_nmS.options[p_selind].value;
	var p_nm     = document.makeform.project_nmS.options[p_selind].text;
}
	function change_table_func(tab) {
		tab = document.makeform.tab_hnmS.value;
		document.makeform.mode.value='SearchTAB';
		document.makeform.column_attribute.value='';
		document.makeform.action="app_pg50RC.php";
		document.makeform.submit();
	}
	function change_program_func(pg) { // no use= X
		pg = document.makeform.pg_codeS.value;
		document.makeform.mode.value='SearchPG';
		document.makeform.column_attribute.value='';
		document.makeform.action="app_pg50RC.php";
		document.makeform.target='table_main';//run_menu, '_self'; 
		document.makeform.submit();
		return;
	}
//-->
</script>

<?php
	$tabData['data'][][] = array(); // use: PG_curl_send() - my_func
	$hostnameA = getenv('HTTP_HOST');
	$dup_check = ''; 
	$pg_code= $H_ID . "_" . time();
	//$uid = explode('@', $H_ID);
	//$pg_code = $uid[0] . "_" . time();
	$_SESSION['pg_code'] = $pg_code;
	$mode_session= get_session("mode_session");
	if( isset($project_nmS) && $project_nmS !=='' ){
		$pcd_nm = explode(":", $project_nmS );
		if( isset($pcd_nm[0]) && $pcd_nm[0] !=='' ) $group_code	= $pcd_nm[0];
		else $group_code = '';	
		if( isset($pcd_nm[1]) && $pcd_nm[1] !=='' ) $group_name	= $pcd_nm[1]; 
		else $group_name= "";
	} else {
		$group_name= "";
		$group_code= "";
	}
	$fld_sel_type	= ""; 
	if( isset($_POST['column_attribute']) && $_POST['column_attribute'] !=='' ) $column_attribute = $_POST['column_attribute']; 
	else  $column_attribute = ""; 
	if( $mode == 'pg_new_create') {
			$rel_type = ""; 
			$rel_data = ""; 
			$pop_data = ""; 
			$if_data = ""; 
			$if_type = ""; 
			if( isset($_POST['item_array']) ) $item_array = $_POST['item_array']; 
			else  $item_array = ""; 
			if( isset($_POST['item_cnt']) ) $item_cnt = $_POST['item_cnt']; 
			else  $item_cnt = ""; 
			$in_day			= date("Y-m-d H:i");
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$group_code', group_name='$group_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$pg_code', pg_name='$pg_name', item_cnt=$item_cnt, item_array='$item_array', if_type='$if_type', if_data='$if_data', pop_data='$pop_data', relation_data='$rel_data', relation_type='', tab_mid='$H_ID', userid='$H_ID' ";
			$ret = sql_query($query);
			$sys_pg_root	= $pg_code;
			$sys_subtit		= $pg_name;
			$aboard_no		= $pg_code;
			$job_group		= "KAPP-Program";
			$job_name		= $pg_name;
			$jong			= "P";
			$pg_cd_nm = $pg_code . ":" . $pg_name;
			$sys_link = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $pg_code; 
			$kapp_theme0 = '';
			$kapp_theme1 = '';
			$kapp_theme = $config['kapp_theme'];
			$kapp_theme = explode('^', $kapp_theme );	//$n = sizeof($server_);
			$kapp_theme0 = $kapp_theme[0];
			$kapp_theme1 = $kapp_theme[1];
			job_link_table_add( $pg_code, $pg_name, $sys_link, $pg_code, $job_group, $job_name, $jong );
			insert_point_app( $H_ID, $config['kapp_write_point'], $sys_link, 'program_create@app_pg50RC', $pg_cd_nm, $tab_enm);
			$pg_sys_link	= KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $pg_code;
			
			if( isset($kapp_theme0) && $kapp_theme0 !=='' ){
				PG_curl_send( $kapp_theme0, $item_cnt , $item_array, $if_type, $if_data, $pop_data, $pg_sys_link, $rel_data, $rel_type );
			}
			if( isset($kapp_theme1) && $kapp_theme1 !=='' ) {
				PG_curl_send( $kapp_theme1, $item_cnt , $item_array, $if_type, $if_data, $pop_data, $pg_sys_link, $rel_data, $rel_type );
			}
			$url = "./tkher_program_run.php?pg_code=". $pg_code;
			echo "<script>window.open( '".$url."' , '_blank', ''); </script>";
	} else if( $mode_session == 'POPUP') { // pop window
		$pg_codeS_session	= get_session("pg_codeS");
		$pg_codeS = $pg_codeS_session;
		$if_line_session		= get_session("if_line");
		$iftype_db_session	= get_session("iftype_db");
		$pop_tabS_session	= get_session("pop_tabS");
		$tab_hnmS_session	= get_session("tab_hnmS");
		$item_array_session	= get_session("item_array");
		$tab_hnmS				= $tab_hnmS_session;
		$mode					= 'SearchPG';
		$aa						= explode(':', $pop_tabS_session);
		$column_attribute	= $aa[1]; 
		$at						= explode('|', $iftype_db_session);
		$j							= $if_line_session+1;
		$fld_sel_type			= $at[$j]; 
		$ar						= explode('@', $item_array_session); 
		$arr						= $ar[$if_line_session];
		$flda						= explode('|', $arr);
		$fld_sel					= $flda[1]; 
		set_session('mode_session',  '');
	} else if( $mode_session == 'Formula') {
		$pg_codeS_session	= get_session("pg_codeS");
		$pg_codeS			= $pg_codeS_session;
		$if_line_session	= get_session("if_line");
		$iftype_db_session	= get_session("iftype_db");
		$formula_data_session= get_session("formula_data");
		$tab_hnmS_session	= get_session("tab_hnmS");
		$item_array_session	= get_session("item_array");
		$tab_hnmS			= $tab_hnmS_session;
		$mode				='SearchPG';
		$at					= explode('|', $iftype_db_session);
		$fld_sel_type		= $at[$j]; 
		$calc				= explode(':', $formula_data_session);
		$column_attribute	= $calc[1];
		$at					= explode('|', $iftype_db_session);
		$j					= $if_line_session+1;
		$fld_sel_type		= $at[$j]; 
		$ar					= explode('@', $item_array_session);
		$arr				= $ar[$if_line_session];
		$flda				= explode('|', $arr);
		$fld_sel			= $flda[1]; 
		set_session('mode_session',  '');
	}
	if( $mode == 'SearchTAB' ){
		$aa				= explode(':', $tab_hnmS);
		$tab_enm		= $aa[0];
		$tab_hnm		= $aa[1];
		$sqlTAB		= "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_name='$tab_hnm' ";  // 프로그램목록에서 검색.
		$resultTAB		= sql_query($sqlTAB);
		$table10_tab	= sql_num_rows($resultTAB);
		$rsTAB			= sql_fetch_array($resultTAB);
		$item_cnt		= $rsTAB['item_cnt'];
		$item_array		= $rsTAB['item_array'];
		$if_type		= $rsTAB['if_type'];
		$if_data		= $rsTAB['if_data'];
		$pop_data		= $rsTAB['pop_data'];
		$rel_data		= $rsTAB['relation_data'];
		$group_code	    = $rsTAB['group_code'];  
		$group_name	    = $rsTAB['group_name'];  
		$project_nmS	= $group_code.":".$group_name;
	}
?>
<center>
<div id='menu_normal'>
   <table height='100%' cellspacing='0' cellpadding='4' width='300' border='1' class="c1"> 
		<form name="makeform" method="post" >
			<input type="hidden" name="sellist"	        value="" >
			<input type="hidden" name="mode"			value="" >
			<input type="hidden" name="mode_call"		value="" >
			<input type="hidden" name="pg_code"			value="<?=$pg_code?>">
			<input type="hidden" name="calc"			value="<?=$calc?>"> 
			<input type="hidden" name="rel_data"		value="<?=$rel_data?>"> 
			<input type="hidden" name="rel_type"		value="<?=$rel_type?>">
			<input type="hidden" name="dup_check"		value="<?=$dup_check?>" > 
		<tr><td align="center" <?php echo" title='New program creation order \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;">
New Program Creation (<?=$H_ID?>)<br>
	Project:<SELECT id='project_nmS' name='project_nmS' onchange="change_project_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:80%; height:30px;" <?php echo" title='Please select the table to use for the Project! ' "; ?> >

			<option value=''>1.Select Project</option>
<?php 
	if( isset( $project_nmS ) && $project_nmS !=="" ) {
		$pcd_nm = explode(":", $project_nmS );
	}
	$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by upday desc " ); 
	while( $rs = sql_fetch_array($result)) {
		if( $group_code == $rs['group_code']) $chk = " selected ";
		else $chk = "";
?>
		<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php echo $chk; ?> title='Project code: <?php echo $group_code;?>' ><?=$rs['group_name']?></option>
<?php
	}
?>
			</SELECT>
			<SELECT id='pg_codeS' name='pg_codeS' style="display:NONE;" >
<?php
			$result = sql_query( "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' order by upday desc " );
			while( $rs = sql_fetch_array($result)) {
?>
				<option value='<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>' ><?=$rs['pg_name']?></option>
<?php
			}
?>
			</SELECT>
</td></tr>

<tr><td align="center" <?php echo" title='New program creation order \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;">
			Table:&nbsp;
			<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:80%; height:30px;" <?php echo" title='Please select the table to use for the program! ' "; ?> >
					<option value=''>1.Select table</option>
<?php 
				if( $mode=='SearchTAB' || $mode=='pg_new_create') {
?>
					<option value="<?php echo $tab_hnmS ?>" selected ><?php echo $tab_hnm ?> </option>
<?php
				}
				$result = sql_query( "select tab_enm, tab_hnm from {$tkher['table10_table']} where userid='$H_ID' and fld_enm='seqno' order by upday desc " );
				while( $rs = sql_fetch_array($result)) {
?>
					<option value='<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>' title='Table code: <?=$rs['tab_enm']?>' ><?=$rs['tab_hnm']?></option>
<?php
				}
?>
			</select>
</td></tr>
<tr><td height="30" align="left" style="border-style:;background-color:#666666;color:cyan;" <?php echo" title='New program creation order \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> align='center'>
program name:<input type='text' id='pg_name' name='pg_name' value='<?=$pg_name?>' maxlength='200'  style="border-style:;background-color:black;color:yellow;height:25;width:120;" value='' <?php echo" title=' Enter the name of the program to be created and select the table! ' "; ?> >
<input type='button' value='Create' onClick="Create_button('app_pg50RC_Create')" style="border-style:;background-color:#666fff;color:yellow; height:25px;" title='program Create and duplicate check' >

</td></tr>
<tr><td valign="top">
<div id="here">
<?php
	$ss = "";
	if( $mode =='pg_new_create' or isset($table10_pg) or isset($table10_tab)  ){
		$itX = explode("@",$item_array);
		for( $i=0, $j=0; $i<$item_cnt; $i++, $j++){
			$it = explode("|",$itX[$i]);
			$ss = $ss . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. " )'><input type='radio' id='column_list".$j."' name='column_list' onclick='column_list_onclickA(this.value, " .$j. " )' value='".$it[0]."|".$it[1]."|".$it[2]."|".$it[3]."|".$it[4]."'><label id='columnR".$j."'>".$it[2]."</label></label><br>";
		} //for
	} else {
		if( isset($tab_enm) ) { 
			$sql = "SELECT * from {$tkher['table10_table']} where userid='".$H_ID."' and tab_enm='".$tab_enm."' order by disno asc";
			$result = sql_query($sql);
			$item_cnt=0;
			$item_array="";
			$j = 0;
			while($rsP = sql_fetch_array($result)) {
				if( $rsP['fld_enm'] =='seqno' ) { 
					$seqno = $rsP['seqno']; 
					$group_code = $rsP['group_code'];  
					$group_name = $rsP['group_name'];  
					continue; 
				} else {
					$item_array = $item_array . "|" . $rsP['fld_enm'] . "|" . $rsP['fld_hnm']  . "|" . $rsP['fld_type'] . "|" . $rsP['fld_len'] . "@";
					$if_type = $if_type . "|" . "0";
					$if_data = $if_data . "|" . "0";
					$pop_data = $pop_data . "^" . "";
				}
				$nm = $rsP['fld_hnm'];     //onclick='column_list_onclickAA(" .$j. " )' : When the function is added and the label is clicked, the radio button is turned on. 
				$ss = $ss . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. ")'><input type='radio' id='column_list".$j."' name='column_list' onclick='column_list_onclickA(this.value, " .$j. " )' value='".$rsP['seqno']."|".$rsP['fld_enm']."|".$rsP['fld_hnm']."|".$rsP['fld_type']."|".$rsP['fld_len']."'><label id='columnR".$j."'>".$rsP['fld_hnm']."</label></label><br>";

				$item_cnt++;
				$j++;
			} //while
		} //if( $tab_enm ) { 
	} //if( $table10_pg>0 or $table10_tab>0 ){ 
	$qna = "sequence of the work|Select Project and Table.|Enter program name.|Click Create button.|"; // 4:item cnt, ^:item add.
	echo "<script> rr_func(\"".$ss."\", \"".$qna."\");</script> "; // It is important to print the questionnaire on the first screen. 
?>
		</div>
</td></tr>
<tr>
 <td bgcolor="#666666" height="27">&nbsp;&nbsp; 
	<a href="javascript:downItemA()">
	<img height="21" style="height:24px;CURSOR: hand" title="Move column order down." src="./icon/bt_down_s01.gif"  border="0"></a>
	&nbsp;&nbsp;&nbsp;
	<a href="javascript:upItemA()" >
	<img height="21" style="height:24px;CURSOR: hand" title="Move the order of column up." src="./icon/bt_up_s01.gif" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="javascript:del_func()" >
	<img src="./icon/e_delete.gif" style="height:24px;CURSOR: hand" <?php echo "title='Delete column\n No columns are used in the program. \n Be careful when deleting columns!'";?> border="0" ></a>&nbsp;&nbsp;&nbsp;&nbsp; 
</td>
</tr>
<tr><td height="24" <?php echo "title='Enter the column name and click the button! ' "; ?> >
*Change column name<br>
   <input type='text' id='column_name_change' name='column_name_change' maxlength='200' size='15' style="border-style:;background-color:black;color:yellow;height:25;" value='' <?php echo "title=\" You can change the name of the column.\" "; ?>>
	<input type='button' value='Confirm' name='title_changeX'  onClick="titlechange_btncfm_onclickA()"  style="border-style:;background-color:green;color:white;height:25;" <?php echo "title=\" You can change the name of the column. \" "; ?> ><br>
	*Column attribute data<br>
   <input type='text' id='column_attribute' name='column_attribute' maxlength='200' size='28' style="border-style:;background-color:black;color:yellow;height:25;" value='<?=$column_attribute?>' <?php echo "title=\"  hobby:baseball:bootball:basketball:tennis:golf , Use delimiter ':' to separate.\" "; ?>>
   <!--  \n Yes - Hobbies:Baseball:Soccer:Basketball:Tennis:Golf, use the delimiter ':' to separate them. -->
   <input type='button' value='Apply Attribute' onclick='Apply_button();' style="border-style:;background-color:green;color:white;height:25;" <?php echo "title=\"hobby:baseball:bootball:basketball:tennis:golf , Use delimiter ':' to separate.\" "; ?> > 
		<br>
		<label class="container" title='Only one selectable button. ' >
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(0,0)" <?php if( !$fld_sel_type ) echo " checked "; ?> >For general input
		  <span class="checkmark"></span> 
		</label>
		<br>
		<label class="container" <?php echo "title='Radio button. ' "; ?> >
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(1,1)" <?php if( $fld_sel_type=='1') echo " checked "; ?>  >Radio
		  <span class="checkmark"></span>
		</label>
		<br>
		<label class="container"  <?php echo "title='Multiple selectable buttons. ' "; ?>>
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(3,2)" <?php if( $fld_sel_type=='3') echo " checked "; ?> >Checkbox
		  <span class="checkmark"></span>
		</label>
		<br>
		<label class="container"  <?php echo "title='Listbox.'"; ?>>
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(5,3)" <?php if( $fld_sel_type=='5') echo " checked "; ?> >Listbox
		  <span class="checkmark"></span>
		</label>
		<br>
		<label class="container"  <?php echo "title='Attached file.'"; ?>>
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(9,4)" <?php if( $fld_sel_type=='9') echo " checked "; ?> >Attached file
		  <span class="checkmark"></span>
		</label>
		<br><!-- Example: This is a column that calculates the amount when you enter the quantity and unit price. -->
		<label class="container" <?php echo "title='This column is calculated and output when data is registered.\n For example, if you enter quantity and unit price,\n it is a column that calculates the amount.' "; ?>>
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(11,5)" <?php if( $fld_sel_type=='11') echo " checked "; ?> >Formula <font color='blue'>[Setup]</font>
		  <span class="checkmark"></span>
		</label>
		<br>
		<label class="container" <?php echo "title=' Input method as password type!' "; ?>>
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(7,6)" <?php if( $fld_sel_type=='7') echo " checked "; ?> >PASSWORD
		  <span class="checkmark"></span>
		</label>
		<br>
		<label class="container" <?php echo "title='Click to open a pop-up window.' "; ?>>
		  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA(13,7)" <?php if( $fld_sel_type=='13') echo " checked "; ?> >POPUPWindow <font color='blue'>[Setup]</font>
		  <span class="checkmark"></span>
		</label>
		<input type='hidden' id='column_attribute_index' name='column_attribute_index' >
		<input type='hidden' id='column_index' name='column_index' >
		<input type='hidden' name='multy_menu_sel' >
		<input type='hidden' name='pg_make_set' >
		<input type='hidden' name='tab_enm'  value='<?=$tab_enm?>' >
		<input type='hidden' name='tab_hnm'  value='<?=$tab_hnm?>' >
		<input type='hidden' name='seqno'    value='<?=$seqno?>' >
		<input type='hidden' name='item_cnt' value='<?=$item_cnt?>' >
		<input type='hidden' name='if_line'  value='' >
		<input type='hidden' name='item_array' value='<?=$item_array?>' >
		<input type='hidden' name='if_typeT' value='<?=$if_type?>' >
		<input type='hidden' name='if_dataT' value='<?=$if_data?>' >
		<input type='hidden' name='pop_dataT' value='<?=$pop_data?>' >
<?php
	$iftypeR =array();
	$ifdataR =array();
	$popdataR =array();
	$itemR =array();
	$ifT	= "";	$ifD	= "";	$ifP	= "";
	if( isset($table10_pg) || isset($table10_tab) || isset($item_cnt) ) { // table select
			if( isset($if_type) ) $iftypeR = explode("|", $if_type );
			if( isset($if_data) ) $ifdataR = explode("|", $if_data );
			if( isset($pop_data) ) $popdataR= explode("^", $pop_data );
			if( isset($item_array) ) $itemR   = explode("@", $item_array );
			for( $i=0, $j=1;$i<$item_cnt;$i++, $j++){
				if( isset($iftypeR[$j]) ) $ifT	= $iftypeR[$j];
				if( isset($ifdataR[$j]) ) $ifD	= $ifdataR[$j];
				if( isset($popdataR[$j]) ) $ifP	= $popdataR[$j];
				$it		= $itemR[$i];
?>
				<input type='hidden' name="iftype[<?=$i?>]"  value='<?=$ifT?>' >
				<input type='hidden' name="if_data[<?=$i?>]" value='<?=$ifD?>' > 
				<input type='hidden' name="popdata[<?=$i?>]" value='<?=$ifP?>' > 
				<input type='hidden' name="iftypeA_<?=$i?>" value='<?=$ifT?>' >
				<input type='hidden' name="if_dataA_<?=$i?>" value='<?=$ifD?>' > 
<?php
				$ifT	= "";	$ifD	= "";	$ifP	= "";
			}			
	} else {
		// first run.
	}
?>
<br>
</td></tr>
<tr><td align="center" >
	<input type='button' value='Create' onClick="Create_button('app_pg50RC_Create')" style="border-style:;background-color:#666fff;color:yellow; height:25px;"  <?php echo "title='Created after duplicate check' "; ?> >

	<!-- <input type='button' value='Project Change' onClick="Project_Update('project_change')" style="border-style:;background-color:#666fff;color:yellow; height:25px;"  <?php echo " title='Change the table project' "; ?> > -->
	<!-- <input type='button' value='Save and Run' <?php echo "title='Save the column attribute information and run the program:$pg_name.' "; ?> onClick="Save_and_Run('table_item_run50')"  style="border-style:;background-color:green;color:white; height:25px;"> -->
</td></tr>
	<input type='hidden' name='group_code' value='<?=$group_code?>' >
	<input type='hidden' name='group_name' value='<?=$group_name?>' >
</form>
</table>
</div>
</body>
</html>
