<?php
	include_once('./tkher_start_necessary.php');
	/*
		kapp_pg_Upgrade.php : app_pg50RU.php copy:
		: kapp_column_change_ajax.php
		: app_pg50RU_update.php - table_item_run50_pg50RU.php copy, table_pg50RU.php Copy : table_pg50R.php copy.
		: PG_curl_send() - call: pg_curl_get_ailinkapp.php
		: program_list3.php - call : upgrade
		: column attribute - 1:radio. 3:checkbox. 5:listbox. 7:password. 9:Attached file. 11:calc. 13:popup
		: create - PC: app_pg50RC.php, Mobile:table_pg50RC.php
		: update - PC: app_pg50RU.php, Mobile:table_pg50RU.php
*/
	$H_ID	= get_session("ss_mb_id");
	if( !$H_ID || $H_ID =='' ){
		m_("You need to login. ");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$H_LEV =$member['mb_level'];
	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";
	if( !isset($_SESSION['mode_session_ok']) ) $_SESSION['mode_session_ok']= 'ok';

	if( $mode=='Project_Search' ) {
		$project_nmS = $_POST['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	} else if( isset($_POST['project_nmS']) ) {
		$project_nmS = $_POST['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	} else {
		$project_nmS = '';
		$project_name= "";
		$project_code= "";
	}
	if( $mode == 'pg_codeS_Search' ) {
		$pg_codeS =$_POST['pg_codeS'];
		$pg_ = explode(":", $pg_codeS);
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
		$tab_enm = $pg_[2];
		$tab_hnm = $pg_[3];
		$tab_hnmS = $tab_enm .':'. $tab_hnm;
	} else if( isset($_POST['pg_codeS'])  && $_POST['pg_codeS'] !='') {
		$pg_codeS =$_POST['pg_codeS'];
		$pg_ = explode(":", $pg_codeS);
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
		$tab_enm = $pg_[2];
		$tab_hnm = $pg_[3];
		$tab_hnmS = $tab_enm .':'. $tab_hnm;
	} else {
		$pg_codeS = '';
		$pg_code = '';
		$pg_name = '';
		$tab_hnmS ='';
		$tab_enm='';
		$tab_hnm = '';
	}
	if( isset($_POST['pop_tabS']) ) $pop_tabS = $_POST['pop_tabS'];
	else $pop_tabS = '';
	if( isset($_POST['seqno']) ) $seqno = $_POST['seqno'];
	else $seqno = '';
	if( isset($_POST['mode_session']) && $_POST['mode_session'] !=='' ) $mode_session   = $_POST['mode_session'];
	else if( isset($_SESSION['mode_session']) && $_SESSION['mode_session'] !=='' ) $mode_session   = $_SESSION['mode_session'];
	else $mode_session   = '';
	if( isset($_POST['item_array']) && $_POST['item_array'] !=='') $post_item_array   = $_POST['item_array'];
	else $post_item_array   = '';
	if( isset($_POST['if_column']) && $_POST['if_column'] !=='' ) $if_column   = $_POST['if_column'];
	else $if_column   = '';
	if( isset($_POST['iftype_db']) && $_POST['iftype_db'] !=='') $iftype_db = $_POST['iftype_db'];
	else $iftype_db = '';
	$if_line_session= 0; $j=0;
	$fld_sel_type	 = '';
	$pg_name = '';
	$column_attribute = ''; 

	if( isset($_POST['if_line']) ) $if_line = $_POST['if_line'];
	else $if_line = '';
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/land25.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<link href="./include/css/admin.css" rel="stylesheet" type="text/css">
<script src="//code.jquery.com/jquery.min.js"></script>
<script language="JavaScript"> 
<!--
	var frealname	= ''
	var isEdited		= false
	var delList		= ''
	var smode		=false
	var start, end, grpStr

	function fnclist_onclick() {
		for (var k=0 ; k < makeform.fnclist.options.length ; k++){
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

	function upItem() {
		var tmpValue, tmpText
		var selectIndex = makeform.column_list.selectedIndex;
	 
		if (selectIndex > 0) {
			tmpValue = makeform.column_list[selectIndex -1].value;
			tmpText  = makeform.column_list[selectIndex -1].text;
			i = selectIndex -1;
			tmpiftype = document.makeform["if_type[" + i + "]"].value;
			tmpifdata = document.makeform["if_data[" + i + "]"].value;
			tmppopdata = document.makeform["popdata[" + i + "]"].value;

			document.makeform["popdata[" + i + "]"].value = document.makeform["popdata[" + selectIndex + "]"].value;
			document.makeform["if_data[" + i + "]"].value = document.makeform["if_data[" + selectIndex + "]"].value;
			document.makeform["if_type[" + i + "]"].value = document.makeform["if_type[" + selectIndex + "]"].value;
			document.makeform["popdata[" + selectIndex + "]"].value   = tmppopdata;
			document.makeform["if_data[" + selectIndex + "]"].value   = tmpifdata;
			document.makeform["if_type[" + selectIndex + "]"].value    = tmpiftype;

			makeform.column_list[selectIndex-1].value = makeform.column_list[selectIndex].value;
			makeform.column_list[selectIndex-1].text  = makeform.column_list[selectIndex].text;
			makeform.column_list[selectIndex].value   = tmpValue;
			makeform.column_list[selectIndex].text    = tmpText;
			makeform.column_list.selectedIndex        = selectIndex-1;
		}
		var obj = document.getElementById("column_list");
		var str_array = '';
		for (i = 0; i < obj.length; i++) {
				var str_val = makeform.column_list.options[i].value;
				var str_txt = makeform.column_list.options[i].text;
				st = str_val.split("|");
				str_array += st[0] + '|' + st[1] + '|' + str_txt +  '|' + st[3] + '@'; 
		}
		makeform.item_array.value = str_array;
	}
	function downItem() {
		var tmpValue, tmpText
		var selectIndex = makeform.column_list.selectedIndex;
		if (selectIndex < (makeform.column_list.length - 1)  && selectIndex != -1) {
			tmpValue = makeform.column_list[selectIndex +1].value;
			tmpText  = makeform.column_list[selectIndex +1].text;
			i = selectIndex +1;

			tmppopdata = document.makeform["popdata[" + i + "]"].value;
			tmpifdata = document.makeform["if_data[" + i + "]"].value;
			tmpiftype = document.makeform["if_type[" + i + "]"].value;

			document.makeform["popdata[" + i + "]"].value	= document.makeform["popdata[" + selectIndex + "]"].value;
			document.makeform["if_data[" + i + "]"].value	= document.makeform["if_data[" + selectIndex + "]"].value;
			document.makeform["if_type[" + i + "]"].value		= document.makeform["if_type[" + selectIndex + "]"].value;
			document.makeform["popdata[" + selectIndex + "]"].value		= tmppopdata;
			document.makeform["if_data[" + selectIndex + "]"].value		= tmpifdata;
			document.makeform["if_type[" + selectIndex + "]"].value		= tmpiftype;

			makeform.column_list[selectIndex+1].value = makeform.column_list[selectIndex].value;
			makeform.column_list[selectIndex+1].text  = makeform.column_list[selectIndex].text;
			makeform.column_list[selectIndex].value   = tmpValue;
			makeform.column_list[selectIndex].text    = tmpText;
			makeform.column_list.selectedIndex        = selectIndex+1;
		}
		var obj = document.getElementById("column_list");
		var str_array = '';
		for (i = 0; i < obj.length; i++) {
				var str_val = makeform.column_list.options[i].value;
				var str_txt = makeform.column_list.options[i].text;
				st = str_val.split("|");
				str_array += st[0] + '|' + st[1] + '|' + str_txt +  '|' + st[3] + '@'; 
		}
		makeform.item_array.value = str_array;
	}
	function cut_Space(str){
		var index, len
		while(true){
			index = str.indexOf(" ")
			if (index == -1)
				break;
			len = str.length
			str = str.substring(0, index) + str.substring((index+1), len)
		}
		return str
	}
	function item_del() {
		pg = document.makeform.pg_codeS.value;
		tab = document.makeform.tab_hnmS.value;
		if( !tab && !pg) {
			alert(' Please select a table or program! ' );
			return false;
		}
		selind = makeform.column_list.selectedIndex
		if( selind < 0 ) {
			alert(' Please select a column! ' );
			return false;
		}
		resp = confirm(' Are you sure you want to exclude columns?'); // \n 컬럼을 제외 하시겠습니까?
		if( !resp ) return false; 
		var selind = 0
		selind = makeform.column_list.selectedIndex
		var item_cnt = makeform.column_list.options.length;	 // table item 수.
		var str_array="";
		for (i = selind+1; i < item_cnt; i++) {
				makeform.column_list[i-1].value = makeform.column_list[i].value;
				makeform.column_list[i-1].text  = makeform.column_list[i].text;
		} 
		makeform.column_list[item_cnt-1].value ="";
		makeform.column_list[item_cnt-1].text  = "";
		makeform.column_list.options.length = makeform.column_list.options.length -1;
		makeform.item_cnt.value = makeform.column_list.options.length;
		return true;
	}
	function change_table_func(tab) {
		tab = document.makeform.tab_hnmS.value;
		document.makeform.mode.value='SearchTAB';
		document.makeform.column_attribute.value='';
		document.makeform.action="kapp_pg_Upgrade.php";
		document.makeform.target='table_main';
		document.makeform.submit();
	}

	function pg_dup_check()
	{
		pg_name = document.makeform.pg_name.value;
		var item_cnt = makeform.pg_codeS.options.length; 
		for (i = 0; i < item_cnt; i++) {
				var str_val = makeform.pg_codeS.options[i].value;
				var pgnm = makeform.pg_codeS.options[i].text;
				if(pg_name == pgnm){
					alert("Program name is duplicate. Please use a different name!"); // \n 프로그램명이 중복입니다. 다른 명칭을 사용해주세요! pgnm:
					document.makeform.pg_name.focus();
					return false;
				}
		}
		return true;
	}
	function k_func_ok(r,j, ok){
		if(j==ok) alert( j+":" +r +" : That's the right answer." );
		else  alert( j+":" + r+" : Wrong." );
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
		document.makeform.column_attribute.value = '';
		document.getElementById('column_list'+j).checked=true;
		ss = document.getElementById('column_list'+j).value;
		var col_attr = ss.split('|'); 
		document.makeform.column_index.value = j;
		document.makeform.column_name_change.value = col_attr[2];
		document.makeform.column_data_type.value   = col_attr[3];
		if_type  = document.makeform["if_type[" + j + "]"].value;
		if_data = document.makeform["if_data[" + j + "]"].value;
		switch( if_type ) {
			case '0':
				document.makeform.ifcheck[0].checked=true;
				break;
			case '1':
				document.makeform.ifcheck[1].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case '3':
				document.makeform.ifcheck[2].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case '5':
				document.makeform.ifcheck[3].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case '7':
				document.makeform.ifcheck[6].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case '9': // add file
				document.makeform.ifcheck[4].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case '11': // Calculation formula 
				document.makeform.ifcheck[5].checked=true;
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1];
				document.makeform.calc.value = jj[0];	 
				break;
			case '13': // popup window
				document.makeform.ifcheck[7].checked=true;
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1]; 
				break;
			default:
				document.makeform.ifcheck[0].checked=true;
				break;
		}
	}
	function column_list_onclickA( ss, j ){ 
		document.makeform.column_attribute.value = '';
		var col_attr = ss.split('|'); //val:|fld_1|fld1|VARCHAR|15
		document.makeform.column_index.value = j;
		document.makeform.column_name_change.value = col_attr[2];
		document.makeform.column_data_type.value   = col_attr[3];
		if_type = document.makeform["if_type[" + j + "]"].value;
		if_data = document.makeform["if_data[" + j + "]"].value;
		document.makeform.col_attr_old.value = if_type; 
		switch( if_type ){
			case 0:
				document.makeform.ifcheck[0].checked=true;
				break;
			case 1:
				document.makeform.ifcheck[1].checked=true;
				break;
			case 3:
				document.makeform.ifcheck[2].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case 5:
				document.makeform.ifcheck[3].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case 7: // Password
				document.makeform.ifcheck[6].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case 9: // attache file
				document.makeform.ifcheck[4].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
			case 11: // Formula
				document.makeform.ifcheck[5].checked=true;
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1];
				document.makeform.calc.value = jj[0];	 
				break;
			case 13: // Popup
				document.makeform.ifcheck[7].checked=true;
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1]; 
				break;
			default :
				document.makeform.ifcheck[0].checked=true;
				document.makeform.column_attribute.value = if_data;
				break;
		}
	}

	function downItemA() {
		var j = document.makeform.column_index.value;
		if ( j < 0 ){
			alert(' Please select a column! ' );
			return false;
		}
		var colnm = document.getElementsByName('column_list');
		var colnm_value='';
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
		i = j*1 +1;
		tmppopdataJ = document.makeform["popdata[" + j + "]"].value;
		tmpifdataJ = document.makeform["if_data[" + j + "]"].value;
		tmpiftypeJ = document.makeform["if_type[" + j + "]"].value;

		tmppopdataK = document.makeform["popdata[" + i + "]"].value;
		tmpifdataK = document.makeform["if_data[" + i + "]"].value;
		tmpiftypeK = document.makeform["if_type[" + i + "]"].value;

		document.makeform["popdata[" + i + "]"].value= document.makeform["popdata[" + j + "]"].value;
		document.makeform["if_data[" + i + "]"].value= document.makeform["if_data[" + j + "]"].value;
		document.makeform["if_type[" + i + "]"].value = document.makeform["if_type[" + j + "]"].value;
		document.makeform["popdata[" + j + "]"].value= tmppopdataK;
		document.makeform["if_data[" + j + "]"].value= tmpifdataK;
		document.makeform["if_type[" + j + "]"].value = tmpiftypeK;

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
		document.makeform.column_index.value = i; // click point set

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
			return false; // down은 마지막 컬럼이면 return false
		}
		if( j < 0 ) {
			alert('upItemA Please select a column! ' );
			return false;
		}
		i = j*1 -1;
		tmppopdataJ = document.makeform["popdata[" + j + "]"].value;
		tmpifdataJ = document.makeform["if_data[" + j + "]"].value;
		tmpiftypeJ = document.makeform["if_type[" + j + "]"].value;

		tmppopdataK = document.makeform["popdata[" + i + "]"].value;
		tmpifdataK = document.makeform["if_data[" + i + "]"].value;
		tmpiftypeK = document.makeform["if_type[" + i + "]"].value;
		document.makeform["popdata[" + i + "]"].value= document.makeform["popdata[" + j + "]"].value;
		document.makeform["if_data[" + i + "]"].value= document.makeform["if_data[" + j + "]"].value;
		document.makeform["if_type[" + i + "]"].value = document.makeform["if_type[" + j + "]"].value;
		document.makeform["popdata[" + j + "]"].value= tmppopdataK;
		document.makeform["if_data[" + j + "]"].value= tmpifdataK;
		document.makeform["if_type[" + j + "]"].value = tmpiftypeK;

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
		var pg = document.makeform.pg_codeS.value;
		var tab = document.makeform.tab_hnmS.value;
		if( !tab || !pg) {
			alert(' Please select a table or program! ' );
			return false;
		}
		var j = document.makeform.column_index.value;
		if( j == '' ) {
			alert('del_func Please select a column! ' );
			return false;
		}
		resp = confirm(' Be careful when deleting columns! \n Are you sure you want to exclude columns?'); // \n 컬럼을 제외 하시겠습니까?
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
					document.makeform.column_name_change.value = '';
					document.makeform.column_attribute.value = '';
				}
				chk = 1;
			}
			if( chk == 1){
				if( i == end_line ){
					document.makeform["popdata[" + i + "]"].value = '';
					document.makeform["if_data[" + i + "]"].value = '';
					document.makeform["if_type[" + i + "]"].value = '';
				} else {
					colnm_value = colnm[j].value;
					document.getElementById('column_list'+i).value = colnm_value;
					st = colnm_value.split('|');
					document.getElementById('columnR'+i).innerHTML = st[2];
					tmppopdataJ = document.makeform["popdata[" + j + "]"].value;
					tmpifdataJ = document.makeform["if_data[" + j + "]"].value;
					tmpiftypeJ = document.makeform["if_type[" + j + "]"].value;
					document.makeform["popdata[" + i + "]"].value = tmppopdataJ;
					document.makeform["if_data[" + i + "]"].value = tmpifdataJ;
					document.makeform["if_type[" + i + "]"].value = tmpiftypeJ;
				}
			} else {
				//colnm_value = colnm[i].value;
			}
		}	
		var kk = item_cnt -1;
		document.makeform.item_cnt.value = kk;
		fld_msg = document.getElementById('column_list'+kk).value
		document.getElementById('column_list'+kk).value = '';
		document.getElementById('columnRX'+kk).innerHTML = ''; 
		document.makeform.column_index.value = '';
		var str_array = '';
		for (k = 0; k < kk; k++) {
			colnm_value = colnm[k].value;
			st = colnm_value.split('|');
			str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
		}
		makeform.item_array.value = str_array;
		return;
	}
	function ifcheck_onclickA( r, seq) {
		col_attr_old = document.makeform.col_attr_old.value; // old attribute
		if( col_attr_old=='') col_attr_old=0;

		var column_index = document.makeform.column_index.value; // colunm index
		var selind = column_index;
		var if_line = document.makeform.if_line.value; // formula set and back colunm index
		//alert("ifcheck_onclickA r: " + r + ", column_index: " + column_index + ", if_line: " + if_line);
		//ifcheck_onclickA r: 13, column_index: 1, if_line: 0

		if( column_index == '' ){
			var selind = document.makeform.if_line.value; // formula set and back colunm index
			if( selind == '' ) {
				alert(r+' : Please select a column! column_index = selind:' +selind );
				document.makeform.ifcheck[seq].checked=false;
				return false;
			}
		}
		var pg = document.makeform.pg_codeS.value; 
		var tab = document.makeform.tab_hnmS.value;
		var pg_name = document.makeform.pg_name.value;
		
		if( !pg_name) {
			alert(' Please select or enter program name!' );
			document.makeform.pg_name.focus();
			return false;
		}
		if( !tab ) {
			alert(' Please select a table!' );
			return false;
		}
		document.makeform.if_line.value = selind;
		var colnm = document.getElementsByName('column_list');
		var colnm_value = colnm[selind].value; 

		st = colnm_value.split('|');
		var col_len = st[4];
		var new_column = st[0]+"|"+st[1]+"|"+st[2]+"|"+st[3]+"|" + "255";
		document.makeform.if_column.value = st[1];
		document.makeform.sellist.value = new_column;

		var obj1 = document.makeform.ifcheck.value; 
		var obj2 = document.makeform.column_attribute.value;
		var obj3 = document.makeform.column_name_change.value; 

		switch( r ) {
			case 0: //	msge="General Input";
				document.makeform.column_attribute.value		= '';
				document.makeform["if_type[" + selind + "]"].value = r;
				break;
			case 1: 
				if( st[3] == 'TEXT' || st[3] == 'DATE'  || st[3] == 'TIME' || st[3] == 'DATETIME' || st[3] == 'PASSWORD' ){
					alert( st[3] + ", type cannot be set" );
					document.makeform["if_type[" + selind + "]"].value = 0;
					document.makeform.column_attribute.value = '';
					document.makeform.ifcheck[col_attr_old].checked=true;
					return false;
				} else  {
					document.makeform["if_type[" + selind + "]"].value = r;
					if( !obj2 ) {
						document.makeform.column_attribute.focus();
						alert(" Enter column processing items using delimiter ':' as in a:b:c:d");	// \n 컬럼처리 항목을 a:b:c:d: 와같이 구분자 ':'을 사용하여 입력하세요!
					}
				}
				break;
			case 3: //	Check Box Button 
				if( st[3] == 'CHAR' || st[3] == 'VARCHAR') {
					document.makeform["if_type[" + selind + "]"].value = r;
					if( !obj2 ) {
						document.makeform.column_attribute.focus();
						alert(" Enter column processing items using delimiter ':' as in a:b:c:d");
					}
				} else {
					alert( st[3] + ", type cannot be set" );
					document.makeform["if_type[" + selind + "]"].value = 0;
					document.makeform.column_attribute.value = '';
					document.makeform.ifcheck[col_attr_old].checked=true;
					return false;
				}
				break;
			case 5: //	msge="List Box";
				if( st[3] == 'TEXT' || st[3] == 'DATE'  || st[3] == 'TIME' || st[3] == 'DATETIME' || st[3] == 'PASSWORD' ) {
					alert( st[3] + ", type cannot be set" );
					document.makeform["if_type[" + selind + "]"].value = 0;
					document.makeform.column_attribute.value = '';
					document.makeform.ifcheck[col_attr_old].checked=true;
					return false;
				} else {
					document.makeform["if_type[" + selind + "]"].value = r;
					if( !obj2 ) {
						document.makeform.column_attribute.focus();
						alert(" Enter column processing items using delimiter ':' as in a:b:c:d");
					}
				}
				break;
			case 7: //	msge="Password Type";
				if( st[3] == 'CHAR' || st[3] == 'VARCHAR'){
					document.makeform.column_attribute.value = 'Password';
					document.makeform["if_type[" + selind + "]"].value = r;
				} else {
					alert( st[3] + ", type cannot be set" );
					document.makeform["if_type[" + selind + "]"].value = 0;
					document.makeform.column_attribute.value = '';
					document.makeform.ifcheck[col_attr_old].checked=true;
					return false;
				}
				break;
			case 9: // add file msge="Attached file";
				if( st[3] == "CHAR" || st[3] == "VARCHAR" ){
					if( col_len < 100 ) { // The column length is small. 컬럼의 길이가 작습니다.
						alert("colnm: " + st[1] + ", col_len: " + col_len + ", The column length is small. The length of column "+st[1]+" was set to 255.");
						column_length_change( st[1], col_len, st[3] ); //colnm_value: |fld_2|fld2|VARCHAR|15, A 컬럼의 길이를 255로 설정 하였습니다.
					}
					document.makeform.column_attribute.value = 'Attached file';
					document.makeform["if_type[" + selind + "]"].value = r;
				} else {
					alert( st[3] + ", Numeric type cannot be set" );
					document.makeform.column_attribute.value = '';
					document.makeform.ifcheck[col_attr_old].checked=true;
					return false
				}
				break;
			case 11: // Calculation formula msge="Formula.";
				if( st[3]=='INT' || st[3]=='FLOAT' || st[3]=='DOUBLE' || st[3]=='TINYINT' || st[3]=='SMALLINT' || st[3]=='MEDIUMINT' || st[3]=='BIGINT' || st[3]=='DECIMAL' ){
					document.makeform["if_type[" + selind + "]"].value = r;
					document.makeform.target          = '_self';
					document.makeform.action          = 'kapp_formula.php'; //table_formulaM.php
					document.makeform.mode.value      = 'run13';
					document.makeform.mode_call.value = 'kapp_pg_Upgrade';
					document.makeform.submit();
				} else {
					alert( st[3] + ", You cannot set the text type" );
					document.makeform.ifcheck[col_attr_old].checked=true;
					return false;
				}
				break;
			case 13: // popup window msge="Pop-up Window";
				document.makeform["if_type[" + selind + "]"].value = r;
				document.makeform.action          = 'table_popupRM.php';
				document.makeform.mode.value      = '';
				document.makeform.mode_call.value = 'kapp_pg_Upgrade';
				document.makeform.target          = '_self';
				document.makeform.submit();
				break;
			default:
				alert("error default r: " + r);
				msge="General Input";
				break;
		}
	} 
	function column_length_change( fld_enm, fld_len, fld_type) { // title click run
		if( fld_type == 'CHAR' || fld_type == 'VARCHAR' || fld_type == 'TEXT') {
			var pgS = document.makeform.pg_codeS.value; 
			var tabS= document.makeform.tab_hnmS.value;
			var tab = tabS.split(':');
			tab_enm = tab[0];
			var pg = pgS.split(':'); 
			pg_enm = pg[0];
			jQuery(document).ready(function ($) {
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: 'kapp_column_change_ajax.php',
						data: {
							"mode": 'column_change',
							"pg_enm": pg_enm,
							"tab_enm": tab_enm,
							"fld_enm": fld_enm,
							"fld_len": fld_len,
							"fld_type": fld_type
								
						},
					success: function(data) {
						//console.log(data);
						alert("OK --- " + tab_enm);
						//location.replace(location.href);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" 올바르지 않습니다.-- kapp_column_ajax.php");
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						return;
					}
				});
			});
		} else {
			alert(' ERROR - Data type is not string! The image name must be a string and must be at least 100 characters long.');
			return false; //이미지 이름은 문자열이어야 합니다 그리고 길이기 충분하게 100이상이어야합니다
		}
	}
	function Apply_button() {
		var selind = document.makeform.column_index.value; // column position
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
		var col_attr = colnm_value.split('|');
		colnm_hnm = col_attr[2];
		ii = document.makeform["if_type[" + selind + "]"].value;
		if( ii==1 || ii==3 || ii==5 || ii==7|| ii==9  ){ // 1:radio button, 3:check box, 5:listbox, 7:pass, 9: attache file 만적용한다.
			if(ii==1) msg='1:radio button';
			else if(ii==3) msg='3:check box';
			else if(ii==5) msg='5:list box';
			if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("%")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0 || chgStr.indexOf("$")>=0 || chgStr.indexOf("@")>=0 || chgStr.indexOf("&")>=0 || chgStr.indexOf("*")>=0 || chgStr.indexOf("~")>=0 || chgStr.indexOf("#")>=0 || chgStr.indexOf("!")>=0 || chgStr.indexOf("`")>=0 || chgStr.indexOf(";")>=0 )
			{
				alert(' You used a special character that is not allowed. \n Please enter it again.');
				// \n 허용이 안 되는 특수문자를 사용하셨습니다. \n 다시 입력하시기 바랍니다.
				return false;
			}
			document.makeform["if_data[" + selind + "]"].value = chgStr;
			document.makeform["if_type[" + selind + "]"].value = ii;	//alert( colnm_hnm + ' , ' + msg + ', label=' +chgStr );
			alert(' OK! ' );

		} else {
			alert(' Please enter a property! 1:radio button or 3:check box or 5:listbox Only' );// 1:radio button or 3:check box or 5:listbox 만적용한다.
			return false;
		}
	}
	function titlechange_btncfm_onclickA() {
		var chgStr = makeform.column_name_change.value;
		if( chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("%")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0 || chgStr.indexOf("$")>=0 || chgStr.indexOf("@")>=0 || chgStr.indexOf("&")>=0 || chgStr.indexOf("*")>=0 || chgStr.indexOf("~")>=0 || chgStr.indexOf("(")>=0 || chgStr.indexOf(")")>=0 || chgStr.indexOf("#")>=0 || chgStr.indexOf("!")>=0 || chgStr.indexOf("`")>=0 || chgStr.indexOf(";")>=0 )
		{
			alert(' You used a special character that is not allowed. \n Please enter it again.');
			// \n 허용이 안 되는 특수문자를 사용하셨습니다. \n 다시 입력하시기 바랍니다.
			return false;
		}

		var j = document.makeform.column_index.value;
		if ( j < 0){	// column 선택 확인.
			alert(' Select column!');
			return;
		}

		var colnm_value = "";
		var colnm = document.getElementsByName('column_list');
		var col_attr = "";
		var new_column = "";

		for(var i = 0, j=0; i < colnm.length; i++, j++){
			colnm_value = colnm[i].value;
			col_attr = colnm_value.split('|'); //val:275|fld_2|작업공정|CHAR|10
			fld_hnm = col_attr[2];
			// 같은 name check?
			if (chgStr == fld_hnm ) {
				alert("This name already exists.");
				return false;
			}
			if( colnm[i].checked ){
				new_column = col_attr[0]+'|'+col_attr[1]+'|'+chgStr+'|'+col_attr[3]+'|'+col_attr[4];
				document.getElementById('column_list'+j).value = new_column;
				var cnm = document.getElementById('column_list'+j).value;
				document.getElementById('columnR'+j).innerHTML = chgStr;//ㅋ컬럼변경내용 화면출력.
			}
		}	
		colnm = document.getElementsByName('column_list');
		str_array = "";
		for (i = 0; i < colnm.length; i++) {
			colnm_value = colnm[i].value;
			st = colnm_value.split('|');//val:275|fld_2|작업공정|CHAR|10// seqno+enm+hnm+type+len
			str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
		} 
		document.makeform.item_array.value = str_array;
		return;
	}
	function Save_and_Run( pg)
	{
		pg_name = document.makeform.pg_name.value;
		if( !pg_name ) {
			alert(" Please select a program! ");
			document.makeform.pg_name.focus();
			return false;
		}
		var pg_codeS = document.makeform.pg_codeS.value;
		if( !pg_codeS ) {
			alert(" Please select a program! ");
			document.makeform.pg_name.focus();
			return false;
		}
		var mode_session_ok = document.makeform.mode_session_ok.value;
		var mode_session = document.makeform.mode_session.value;
		var colnm = document.getElementsByName('column_list');
		var st = "";
		var item_cnt = colnm.length;
		var str_array= "";

		for( i = 0; i < item_cnt; i++) {
			colnm_value = colnm[i].value;
			st = colnm_value.split('|');
			str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
		} 
		document.makeform.item_array.value = str_array;
		
		if( mode_session == "POPUP" || mode_session == "Formula") {
			if( mode_session_ok == 'end') {
				document.makeform.mode.value = 'Pg_Upgrade';
			} else {
				document.makeform.mode.value = 'Pg_Upgrade';
			}
		} else document.makeform.mode.value = 'Pg_Upgrade';
		document.makeform.mode_call.value = 'kapp_pg_Upgrade'; //'kapp_pg_Upgrade.php'
		document.makeform.action='app_pg50RU_update.php'; //'app_pg50RU_update.php'
		document.makeform.target='_blank';
		document.makeform.submit();
	}

	// no use
	function sendDataToPHP( projectnmS, pnmdataS ) {
		fetch('<?=KAPP_URL_T_?>/kapp_save_session.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ projectnmS: projectnmS, pnmdataS: pnmdataS }),
		})
		.then(response => response.json())
		.then(data => {
			console.log('Success:', data);
		})
		.catch((error) => {
			console.error('Error:', error);
		});
	}
	function change_project_func(pnmS){
		if( pnmS == '') {
			alert('Select Project!');
			return false;
		}
		//sendDataToPHP('project_nmS', pnmS);
		document.makeform.mode.value='Project_Search';
		document.makeform.action="kapp_pg_Upgrade.php";
		document.makeform.submit();
	}
	function change_program_func(pnmS){
		if( pnmS == '') {
			alert('Select Program!');
			return false;
		}
		//sendDataToPHP('pg_codeS', pnmS);
		document.makeform.mode.value='pg_codeS_Search';
		document.makeform.action="kapp_pg_Upgrade.php";
		document.makeform.submit();
	}
//-->
</script>
<body leftmargin="0" topmargin="0">
<?php
	if( $mode_session == 'POPUP') {
		if( isset($_POST['if_line']) && $_POST['if_line'] !== 0 ) $if_line_session	= $_POST['if_line'];
		$j= $if_line_session+1;
		$mode					= 'pg_codeS_Search';
		$aa						= explode(':', $pop_tabS );
		if( isset( $aa[1]) &&  $aa[1] !=='' ) $column_attribute	= $aa[1]; 
		else  $column_attribute = ''; 
		$at						= explode('|', $iftype_db );
		if( isset( $at[$j]) && $at[$j] !=='' ) $fld_sel_type	= $at[$j]; 
		else  $fld_sel_type	 = '';
		$ar						= explode('@', $post_item_array ); 
		if( isset( $ar[$if_line_session]) && $ar[$if_line_session] !=='' ) $arr = $ar[$if_line_session];
		else  $arr = '';
		$flda = explode('|', $arr);
		if( isset( $flda[1]) && $flda[1] !=='' ) $fld_sel = $flda[1]; 
		else  $fld_sel = '';; 
		set_session('mode_session',  '');
	} else if( $mode_session == 'Formula') {
		if( isset( $_POST['if_line']) && $_POST['if_line'] !== 0 ) $if_line_session	= $_POST['if_line'];
		$j	 = $if_line_session+1;
		$mode				='pg_codeS_Search';
		if( isset($_POST['formula_data']) && $_POST['formula_data'] !=='' ) $calc = explode(':', $_POST['formula_data'] );
		else $calc = array();
		if( isset( $calc[1]) && $calc[1] !=='' ) $column_attribute	= $calc[1];
		else $column_attribute	= '';
		$at = explode('|', $iftype_db );
		if( isset( $at[$j]) && $at[$j] !=='' ) $fld_sel_type= $at[$j]; 
		else $fld_sel_type= '';

		$ar= explode('@', $post_item_array );
		if( isset($ar[$if_line_session]) ) $arr = $ar[$if_line_session];
		else $arr = '';
		$flda				= explode('|', $arr);
		if( isset($flda[1]) && $flda[1] !=='' ) $fld_sel= $flda[1]; 
		else  $fld_sel =''; 
		set_session('mode_session',  '');
	}
	if( $mode=='pg_codeS_Search' ){
			$sqlPG			= "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$pg_code."' ";
			$resultPG		= sql_query($sqlPG);
			$table10_pg	= sql_num_rows($resultPG);
			$rsPG			= sql_fetch_array($resultPG);
			$seqno			= $rsPG['seqno'];
			$item_cnt		= $rsPG['item_cnt'];
			$item_array		= $rsPG['item_array'];
			$if_type		= $rsPG['if_type'];
			$if_data		= $rsPG['if_data'];
			$pop_data		= $rsPG['pop_data'];
			$rel_data		= $rsPG['relation_data'];
			$rel_type		= $rsPG['relation_type'];
			$tab_enm		= $rsPG['tab_enm'];
			$tab_hnm		= $rsPG['tab_hnm'];
			$tab_hnmS		= $tab_enm . ":" . $tab_hnm;
			$group_code		= $rsPG['group_code'];
			$group_name		= $rsPG['group_name'];
			$project_nmS	= $group_code .":". $group_name;
			$pg_name		= $rsPG['pg_name'];
			$pg_codeS		= $pg_code.":".$pg_name.":".$tab_enm.":".$tab_hnm.":".$group_code.":".$group_name;
	}
	$mode_session_ok = get_session("mode_session_ok");
	$sellist = get_session("sellist");
	$sel_col= explode('|', $sellist);
	if( isset($sel_col[1]) ) $formula_column = $sel_col[1];
	else $formula_column = '';	
?>
<center>
<div id='menu_normal'>
	<Form METHOD='POST' name='makeform' enctype="multipart/form-data">
			<input type="hidden" name="sellist"	        value="" >
			<input type="hidden" name="mode"      id="mode" value="<?=$mode?>" >
			<input type="hidden" name="mode_call" id="mode_call" value="" >
			<input type="hidden" name="pg_code"   id="pg_code" value="<?=$pg_code?>">
			<input type="hidden" name="calc"            value="<?=$calc?>"> 
			<input type="hidden" name="pop_data"		value="<?=$pop_data?>"> 
			<input type="hidden" name="rel_data"        value="<?=$rel_data?>"> 
			<input type="hidden" name="rel_type"        value="<?=$rel_type?>"> 
			<input type="hidden" name="mode_session"    value=""> 
			<input type="hidden" name="mode_session_ok" value='<?=$mode_session_ok?>'> 
			<input type="hidden" name="project_nmSX"	value="<?=$project_nmS?>"> <!-- project_nmSX -->
			<input type="hidden" name="project_code"	value="<?=$project_code?>"> 
			<input type="hidden" name="col_attr_old"	value=""> 
 <table cellspacing='0' cellpadding='4' width='390' border='1' class="c1"> 
 <tr>
    <td height="30" style="font-size:21px;background-color:#666666;color:cyan;text-align:center;" title='kapp_pg_Upgrade.php'>Program Upgrade<br>
	<input type='hidden' name='project_name' value="<?=$project_name?>" readonly >
	<input type='text' id='pg_name' name='pg_name' value='<?=$pg_name?>' style="display:none;" ><br>

		Project:<SELECT id='project_nmS' name='project_nmS' onchange="change_project_func(this.value);" style="background-color:#666666;color:yellow;width:50%; height:30px;">
<?php 
		if( $mode=='Project_Search' || isset( $_POST['project_nmS']) ) echo "<option value='$project_nmS' selected >$project_name</option>";
		else echo "<option value=''>1.Select Project</option>";

		$result= sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " ); 
		while( $rs = sql_fetch_array($result)) {
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php if( $project_code==$rs['group_code']) echo ' selected '; ?> ><?=$rs['group_name']?></option>
<?php	} ?>
		</SELECT>

		
		<br>Program:<SELECT id='pg_codeS' name='pg_codeS' onchange="change_program_func(this.value);" style="background-color:#666666;color:yellow;width:45%; height:30px;" >
<?php
		echo "<option value=''>2.Select program</option>";
		if( $mode=='pg_codeS_Search' ) echo "<option value='".$pg_codeS."' selected >".$pg_name."</option>";

		$result= sql_query( "SELECT * from {$tkher['table10_pg_table']} where group_code='$project_code' and userid='$H_ID' " );
		while( $rs = sql_fetch_array($result)) {
?>
			<option value="<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php if( $pg_code==$rs['pg_code']) echo " selected ";?> title="pg_code:<?=$rs['pg_code']?>" ><?=$rs['pg_name']?></option>
<?php   } ?>
		</SELECT>

</td>
</tr>
			  <tr>
				<td align="left" <?php echo" title='Program Upgrade \n 1:Select Project \n 2:Select Program \n 3:Select column \n 4: Column attribute definition \n 5:Click Save and RUN button'  "; ?> style="font-size:21px;background-color:#666666;color:cyan;width:100%; height:20px;">use table:
				<input type='hidden' name='tab_hnmS' value="<?=$tab_hnmS?>" ><?=$tab_enm?><br>
				<input type='text'   name='tab_hnm'  value="<?=$tab_hnm?>" title="tab_hnmS:<?=$tab_hnmS?>" style="border-style:;background-color:#666666;color:yellow;width:100%; height:27px;font-size:15px;" readonly >
				</td>
			  </tr>
			  <tr>
				 <td valign="top">
	<div id="here" style="font-size:18px;">
<?php
	$ss = "";
	$ckv = "";	
	if( $mode=='pg_codeS_Search' ){
			$itX = explode("@", $item_array);
			for( $j=0; $j < $item_cnt; $j++){
				if( $mode_session == 'POPUP' || $mode_session == 'Formula' ) {
					if( $if_line_session == $j) $ckv = " checked "; 
					else $ckv = "";
				}
				$it = explode("|", $itX[$j] );
				$val = $itX[$j];
				$ifd = explode("|", $if_data );
				$tit_val = $j . " - " . $val . " : " . $ifd[$j+1]; 
				$ss = $ss . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. " )'><input type='radio' ".$ckv." id='column_list".$j."' name='column_list' onclick='column_list_onclickA( this.value, " .$j. " )' value='".$val."'><label title='".$tit_val."' id='columnR".$j."'>" .$it[2]. "</label></label><br>";
			} //for
	}
	$qna = "sequence of the work|Select Project.|Select Program.|Select column.|Column attribute definition.|Click Save and RUN button.|4";
	echo "<script> rr_func(\"".$ss."\", \"".$qna."\");</script> "; // job remark
?>
		</div>
				 </td>
			   </tr>
			   <tr>
				 <td bgcolor="#666666" height="27">&nbsp;&nbsp; 
					<a href="javascript:downItemA()"><img src="./icon/bt_down_s01.gif" style="height:24px;CURSOR: hand" title="Move column order down." border="0" style='height:24px;'></a>
					&nbsp;&nbsp;&nbsp;
					<a href="javascript:upItemA()" ><img src="./icon/bt_up_s01.gif" style="height:24px;CURSOR: hand" title="Move the order of column up." border="0" style='height:24px;'></a>&nbsp;&nbsp;&nbsp;&nbsp; <!-- 컬럼삭제는 신중히하세요! -->
					<a href="javascript:del_func()" ><img src="./icon/e_delete.gif" style="height:24px;CURSOR: hand" <?php echo "title='Delete column\n No columns are used in the program. \n Be careful when deleting columns!'";?> border="0" ></a>&nbsp;&nbsp;&nbsp;&nbsp; <!-- 컬럼삭제는 신중히하세요! -->
				</td>
			  </tr>
			  <tr>
				<td height="24" <?php echo "title='Enter the column name and click the button! ' "; ?> >
				*Change column name<br>
					<input type='hidden' name='column_data_type' value=''>
					<input type='text' id='column_name_change' name='column_name_change' maxlength='200' size='15' style="border-style:;background-color:black;color:yellow;height:25;" value='' <?php echo "title=\" You can change the name of the column.\" "; ?>>
					<input type='button' value='Confirm' name='title_changeX'  onClick="titlechange_btncfm_onclickA()"  style="border-style:;background-color:green;color:white;height:25;" <?php echo "title=\" You can change the name of the column. \" "; ?> >
<div style="font-size:18px;">
<br>*Column attribute data<br>
<label class="container" <?php echo "title='Only one selectable button. ' "; ?> >
  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA( 0,0)" <?php if( !isset($fld_sel_type) ) echo " checked "; ?> >For general input
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
  <input type="radio" name="ifcheck" onclick="ifcheck_onclickA( 9,4)" <?php if( $fld_sel_type=='9') echo " checked "; ?> >Attached file
  <span class="checkmark"></span>
</label>
<br><!-- 예를들면 수량과 단가를 입력하면 금액을 계산하는 컬럼입니다. -->
<label class="container" <?php echo "title='kapp_formula.php \n This column is calculated and output when data is registered.\n For example, if you enter quantity and unit price,\n it is a column that calculates the amount.' "; ?>>
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
</div>
<br>

   <input type='text' id='column_attribute' name='column_attribute' maxlength='200' size='28' style="border-style:;background-color:black;color:yellow;height:25;" value='<?=$column_attribute?>' <?php echo "title=\"  hobby:baseball:bootball:basketball:tennis:golf , Use delimiter ':' to separate.\" "; ?>>
   <input type='button' value='Apply Attribute' onclick='Apply_button();' style="border-style:;background-color:green;color:white;height:25;" <?php echo "title=\"hobby:baseball:bootball:basketball:tennis:golf , Use delimiter ':' to separate.\" "; ?> > 
<br>
		<input type='hidden' id='column_attribute_index' name='column_attribute_index' >
		<input type='hidden' id='column_index' name='column_index' >
		<input type='hidden' name='tab_enm'  value='<?=$tab_enm?>' >
		<input type='hidden' name='seqno'      value='<?=$seqno?>' >
		<input type='hidden' name='item_cnt'   value='<?=$item_cnt?>' >
		<input type='hidden' name='if_line'    value="<?=$if_line_session?>" >
		<input type='hidden' name='if_column'  value="<?=$if_column?>" >
		<input type='hidden' name='item_array' value='<?=$item_array?>' >
<?php
			if( isset($table10_pg) && $table10_pg !==''  ) {
					if( isset($if_type) && $if_type!=='' ) $iftypeR = explode("|", $if_type );
					else $iftypeR = "";
					if( isset($if_data) && $if_data!=='' ) $ifdataR = explode("|", $if_data );
					else $ifdataR = "";
					if( isset($item_array) && $item_array!=='' ) $itemR   = explode("@", $item_array );
					else $itemR   = "";
					if( isset($pop_data) && $pop_data!=='' ) $popdataR= explode("^", $pop_data ); 
					else $popdataR= "";

					for( $i=0, $j=1; $i < $item_cnt; $i++, $j++){
						if( isset($iftypeR[$j]) && $iftypeR[$j] !=='' ) $ifT = $iftypeR[$j];
						else $ifT	= "";
						if( isset($ifdataR[$j]) && $ifdataR[$j] !=='' ) $ifD = $ifdataR[$j];
						else $ifD	= "";
						if( isset($itemR[$i]) && $itemR[$j] !=='' ) $it= $itemR[$i];
						else $it		=  "";
						if( isset($popdataR[$j]) && $popdataR[$j] !=='' ) $pop= $popdataR[$j];
						else $pop	= "";
?>
						<input type='hidden' name="if_type[<?=$i?>]" value='<?=$ifT?>' >
						<input type='hidden' name="if_data[<?=$i?>]" value='<?=$ifD?>' > 
						<input type='hidden' name="popdata[<?=$i?>]" value='<?=$pop?>' >
<?php
					}			
			}
?>
					 </td>
				</tr>
				<tr>
                    <td align="center" >
						<input type='button' value='Save and Run' <?php echo "title='Save the column attribute information and run the program:$pg_name.' "; ?> onClick="Save_and_Run( 'table_item_run50')"  style="border-style:;background-color:green;color:white; height:25px;">
					</td>
                </tr>
						<input type='hidden' name='group_code' value="<?=$group_code?>" >
						<input type='hidden' name='group_name' value="<?=$group_name?>" >
						<input type='hidden' name='iftype_db'  value="<?=$iftype_db?>" >
		</form>
	</table>
</div>
</body>
</html>
