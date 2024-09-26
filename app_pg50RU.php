<?php
	include_once('./tkher_start_necessary.php');
	/*
		app_pg50RU.php   : table_pg50RU.php을 Copy : 기존의 table_pg50R.php copy하여 backup 보관.
						 : 프로그램을 생성과 보완을 동시에 하던것을 생성 과 변경으로 분리함. 
						 : 생성(PC:app_pg50RC.php, Mobile:table_pg50RC.php) 부분과 
						 : 변경(PC:app_pg50RU.php, Mobile:table_pg50RU.php) 부분으로 분리함.
						 : table_item_run50.php call 하고 pg_curl_send() 추가 : 2023-08-03 - ailinkapp.com : pg_curl_get_ailinkapp.php 와 연동됨.
							- https://ailinkapp.com/onlyshop/coupon/pg_curl_get_ailinkapp.php

	*/
	$ss_mb_id	= get_session("ss_mb_id");
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if( !$H_ID || $H_LEV < 2 )
	{
		m_("You need to login. ");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$_SESSION['mode_session_ok']	= 'ok';  // 막으면 : point 지급완료 확인용. 1일 1번만 적용.
	$project_nmS = $_POST['project_nmS'];
	$pg_codeS    = $_POST['pg_codeS']; // pg_codeS:dao_1633396679:출고:dao_1633396679:출고:9999:출고
	$tab_hnmS    = $_POST['tab_hnmS'];
	$mode		 = $_POST['mode'];
	$lev		= $_POST['lev'];//m_("pg50 - lev:$lev"); // program level:3
	$seqno		= $_POST['seqno'];
	$tab_enm	= $_POST['tab_enm'];
	$tab_hnm	= $_POST['tab_hnm'];
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/land25.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<link href="./include/css/admin.css" rel="stylesheet" type="text/css">

<!-- <SCRIPT language=JavaScript src="cra_func.js"></SCRIPT> -->
<script language="JavaScript"> 
<!--
	var frealname	= ''
	var isEdited		= false
	var delList		= ''
	var smode		=false
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
	/*
	function titlechange_btncfm_onclickXX() {
		var selStr = makeform.column_list;
		var chgStr = makeform.column_name_change.value;
		if (makeform.column_list.selectedIndex < 0) return;
		// chgStr.indexOf("^")>=0 || '^' 만 가능하도록 한다.
		if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("%")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0 || chgStr.indexOf("$")>=0 || chgStr.indexOf("@")>=0 || chgStr.indexOf("&")>=0 || chgStr.indexOf("*")>=0 || chgStr.indexOf("~")>=0 || chgStr.indexOf("(")>=0 || chgStr.indexOf(")")>=0 || chgStr.indexOf("#")>=0 || chgStr.indexOf("!")>=0 || chgStr.indexOf("`")>=0 || chgStr.indexOf(";")>=0 )
		{
			alert(' You used a special character that is not allowed. \n Please enter it again.');
			// \n 허용이 안 되는 특수문자를 사용하셨습니다. \n 다시 입력하시기 바랍니다.
			return false;
		}
		// selected 된 것과 같은 이름이 있는지?
		for (i=0;i<makeform.column_list.options.length;i++) {
			  if (chgStr == selStr.options[i].text) {
				alert("This name already exists.")
					return false;
			  }
		}
		selStr.options[line].text = chgStr;
		return;
	}
	function titlechange_btncfm_onclickX() {
		var selStr = makeform.column_list;
		var chgStr = makeform.column_name_change.value;
		line = makeform.column_list.selectedIndex;

		if( line < 0 ) {
			alert(' Please select a column! ' );
			return false;
		}
		if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0)
			{
			alert(' You used a special character that is not allowed. Please re-enter..');
			// \n 허용이 안 되는 특수문자를 사용하셨습니다. 다시 입력하시기 바랍니다
			return false;
		}
		for (i=0;i<makeform.column_list.options.length;i++) {
			  if (chgStr == selStr.options[i].text) {
				alert(" This name already exists. Please use it after changing the name.");//
					return false;
			  }
		}
		selStr.options[line].text = chgStr;
		return;
	}*/
	//-----------------
	function upItem() {
		var tmpValue, tmpText
		var selectIndex = makeform.column_list.selectedIndex;
	 
		if (selectIndex > 0) {
			tmpValue = makeform.column_list[selectIndex -1].value;
			tmpText  = makeform.column_list[selectIndex -1].text;
			i = selectIndex -1;
			tmpiftype = document.makeform["iftype[" + i + "]"].value;
			tmpifdata = document.makeform["if_data[" + i + "]"].value;
			tmppopdata = document.makeform["popdata[" + i + "]"].value;

			document.makeform["popdata[" + i + "]"].value = document.makeform["popdata[" + selectIndex + "]"].value;
			document.makeform["if_data[" + i + "]"].value = document.makeform["if_data[" + selectIndex + "]"].value;
			document.makeform["iftype[" + i + "]"].value = document.makeform["iftype[" + selectIndex + "]"].value;

			document.makeform["popdata[" + selectIndex + "]"].value   = tmppopdata;
			document.makeform["if_data[" + selectIndex + "]"].value   = tmpifdata;
			document.makeform["iftype[" + selectIndex + "]"].value    = tmpiftype;

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
	//-------------------
	function downItem() {
		var tmpValue, tmpText
		var selectIndex = makeform.column_list.selectedIndex;
		if (selectIndex < (makeform.column_list.length - 1)  && selectIndex != -1) {
			tmpValue = makeform.column_list[selectIndex +1].value;
			tmpText  = makeform.column_list[selectIndex +1].text;
			i = selectIndex +1;

			tmppopdata = document.makeform["popdata[" + i + "]"].value; // add 2022-02-19
			tmpifdata = document.makeform["if_data[" + i + "]"].value;
			tmpiftype = document.makeform["iftype[" + i + "]"].value;

			document.makeform["popdata[" + i + "]"].value	= document.makeform["popdata[" + selectIndex + "]"].value;
			document.makeform["if_data[" + i + "]"].value	= document.makeform["if_data[" + selectIndex + "]"].value;
			document.makeform["iftype[" + i + "]"].value		= document.makeform["iftype[" + selectIndex + "]"].value;

			document.makeform["popdata[" + selectIndex + "]"].value		= tmppopdata;
			document.makeform["if_data[" + selectIndex + "]"].value		= tmpifdata;
			document.makeform["iftype[" + selectIndex + "]"].value		= tmpiftype;

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
		document.makeform.action="app_pg50RU.php";
		document.makeform.target='table_main'; // _top, 'runf_main';
		document.makeform.submit();
		//makeform.item_array.value = str_array;
	}

	function change_program_func(pg) {
		//alert('pg: '+pg); //pg: dao_1645837697:판매정보:dao_1645837697:판매정보:cccc:판매
		pn = pg.split(":");
		//pg = document.makeform.pg_codeS.value;
		//document.makeform.project_name.value = pn[5];
		document.makeform.mode.value='SearchPG';
		document.makeform.column_attribute.value='';
		document.makeform.action="app_pg50RU.php";
		document.makeform.target='_self';// run_menu, '_self'; , table_main
		document.makeform.submit();
		return;
	}
	function pg_dup_check()
	{
		pg_name = document.makeform.pg_name.value;
		var item_cnt = makeform.pg_codeS.options.length; 
		for (i = 0; i < item_cnt; i++) {
				var str_val = makeform.pg_codeS.options[i].value;
				var pgnm = makeform.pg_codeS.options[i].text;
				if(pg_name == pgnm){
					alert("Program name is duplicate. Please use a different name!");
					// \n 프로그램명이 중복입니다. 다른 명칭을 사용해주세요! pgnm:
					document.makeform.pg_name.focus();
					return false;
				}
		}
		return true;
	}
	/*
	//------------------ 설문지 용 ---
	function k_func(r,j){
		if(j==4) alert( j+":" +r +" : That's the right answer." );
		else  alert( j+":" + r+" : Wrong." );
	}*/
	//------------------ 문제 풀이용 ---
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
			lenj = rr.length-2; // 정답을 전달 경우. - 문제 풀이 형식. k_func_ok(,,)
			ok = rr.length-1;   // 정답을 전달 경우. - 문제 풀이 형식. - 정답번호. k_func_ok(,,ok=정답번호)
			ss+=" &#160; <p><form><div>"+(i+1)+". "+rr[0]+"</div> ";
			for(k=0,j=1; k < lenj; k++, j++){
				ss+=" &#160; <label><span><input type='radio' name='qna' onclick=\"k_func_ok('"+ rr[j] +"', "+j+", "+rr[ok]+")\" value="+ rr[j] +">" +j+'. '  + rr[j]+" &#160; </span></label><br>";
			}
		}
		ss+="</form></p>";
		here.innerHTML=ss;
	} 
	function rr_func( ss, qna ){
		//alert('rr:'+ ss );
		if(!ss) r_func('A', qna);
		else here.innerHTML = ss;
	}
	//------------------------------------
	/*
	   중요! 클릭위치가 button point에 정확하면 column_list_onclickA( ss, j )을 실행다음, column_list_onclickAA( j )을 실행한다.
	   그렇지 않으면 여기만 실행을 한다. 주의 해야한다! 
	   그래서 여기에 column_list_onclickAA( j )에 필요한 로직을 설정해야만 한다. 중요! 2024-01-03
	*/
	function column_list_onclickAA( j ){  // column_list_onclickA( ss, j )을 실행한 다음에 실행을 한다. 
		document.getElementById('column_list'+j).checked=true; //이붑분외 column_list_onclickA(ss,j)와동일함.
		ss = document.getElementById('column_list'+j).value;   //alert('ss:'+ss);//ss:|fld_1|상품코드|CHAR|20
		var test = ss.split('|'); 
		
		//alert('column_list_onclickAA - test1:'+test[1] + ', test3:'+test[3]);
		// column_list_onclickAA - test1:fld_5, test3:CHAR
		
		document.makeform.column_index.value = j;
		document.makeform.column_name_change.value = test[2];
		document.makeform.column_data_type.value   = test[3]; // 2024-01-03 add

		iftype  = document.makeform["iftype[" + j + "]"].value;
		if_data = document.makeform["if_data[" + j + "]"].value; //alert('if_data:'+if_data); //if_data:dao_1634976807:상품정보 iftype:1:if_data:공정1:공정2:공정3, if_data:fld_5 = fld_3 * fld_4:금액 = 수량 * 단가

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
			document.makeform.column_attribute.value = jj[1]; // 컬럼 조건 정의 
			document.makeform.calc.value = jj[0];	 
		} else if( iftype == 13) { // Popup
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1]; 
		} else  document.makeform.column_attribute.value = if_data; // 컬럼 조건 정의
	}
	//------------------------------------
	/*
	   중요! 클릭위치가 button point에 정확하면 column_list_onclickA( ss, j )을 실행다음, column_list_onclickAA( j )을 실행한다.
	   그렇지 않으면 여기를 실행하지 않는다. 주의 해야한다! 그래서 column_list_onclickAA( j )에서도 필요한 로직을 설정해야만 한다. 중요! 2024-01-03
	   이 함수는 필요 하지않다 column_list_onclickAA( j )여기에서 모든 처리하도록 한다.
	*/
	function column_list_onclickA( ss, j ){ 
		//alert( "column_list_onclickA j: "+ j+', ss: '+ ss ); //column_list_onclickA j: 4:rrA: |fld_5|성별|CHAR|2
		var test = ss.split('|');
		document.makeform.column_index.value = j;
		document.makeform.column_name_change.value = test[2];
		document.makeform.column_data_type.value   = test[3]; // 2024-01-03 add

		iftype = document.makeform["iftype[" + j + "]"].value;
		if_data = document.makeform["if_data[" + j + "]"].value;

		//alert( 'iftype:' + iftype+':if_data:'+ if_data );//iftype:1:if_data:공정1:공정2:공정3
		//document.getElementById(relation_key_old_+sel_num).value = Insert + : + : + :;
		//document.getElementById( ifcheck[+iftype+]).checked = true;
		//document.makeform["ifcheck[" + iftype + "]"].checked=true;
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
			document.makeform.column_attribute.value = jj[1]; // 컬럼 조건 정의 
			document.makeform.calc.value = jj[0];	 
		} else if( iftype == 13) { // Popup
				jj = if_data.split(":");
				document.makeform.column_attribute.value = jj[1]; 
		} else document.makeform.column_attribute.value = if_data; // 컬럼 조건 정의
	}

function downItemA() {
	var j = document.makeform.column_index.value;
	if ( j < 0 ){	// column 선택 확인.
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
		return false; // down은 마지막 컬럼이면 return false
	}
	if (j < 0 ) {
		alert(' Please select a column! ' );
		return false;
	}
		i = j*1 +1;
		tmppopdataJ = document.makeform["popdata[" + j + "]"].value; // 2022-02-19
		tmpifdataJ = document.makeform["if_data[" + j + "]"].value;  // 선택한 컬럼의 다음 컬럼 백업.
		tmpiftypeJ = document.makeform["iftype[" + j + "]"].value;   //alert( 'tmpifdataJ:' +tmpifdataJ + ' , tmpiftypeJ:'+tmpiftypeJ );

		tmppopdataK = document.makeform["popdata[" + i + "]"].value; // 2022-02-19
		tmpifdataK = document.makeform["if_data[" + i + "]"].value;  // 선택한 컬럼의 다음 컬럼 백업.
		tmpiftypeK = document.makeform["iftype[" + i + "]"].value;   //alert( 'tmpifdataK:' +tmpifdataK + ' , tmpiftypeK:'+tmpiftypeK );

		document.makeform["popdata[" + i + "]"].value= document.makeform["popdata[" + j + "]"].value; // 2022-02-19 add
		document.makeform["if_data[" + i + "]"].value= document.makeform["if_data[" + j + "]"].value; //선택한 컬럼의 내용을 다음컬럼 위치에 저장.
		document.makeform["iftype[" + i + "]"].value = document.makeform["iftype[" + j + "]"].value;

		document.makeform["popdata[" + j + "]"].value= tmppopdataK; // 2022-02-19
		document.makeform["if_data[" + j + "]"].value= tmpifdataK; //백업컬럼 내용을 선택한 컬럼위치에 저장
        document.makeform["iftype[" + j + "]"].value = tmpiftypeK;

		tmpValueJ = colnm[j].value;
		tmpValueI = colnm[i].value;  //alert( 'tmpValueJ:' +tmpValueJ + ' , tmpValueI:' +tmpValueI );

		document.getElementById('column_list'+j).value = tmpValueI;
		document.getElementById('column_list'+i).value = tmpValueJ;
		tmpValueJ = document.getElementById('column_list'+j).value;  //colnm[j].value;
		tmpValueI = document.getElementById('column_list'+i).value;  //alert( '-- tmpValueJ:' +tmpValueJ + ' , tmpValueI:' +tmpValueI );
	var str_array = '';
    for (k = 0; k < colnm.length; k++) {
		colnm_value = colnm[k].value;
		st = colnm_value.split('|');       //val:275|fld_2|작업공정|CHAR|10
		str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
		document.getElementById('columnR'+k).innerHTML = st[2];//컬럼 내용 화면출력.
	}
	makeform.item_array.value = str_array;
	document.getElementById('column_list'+i).checked=true;
	document.makeform.column_index.value = i; // click point set

}
//------------------
function upItemA() {
	var j = document.makeform.column_index.value;
	if ( j < 0 ){	// column 선택 확인.
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
	if (j < 0 ) {
		alert(' Please select a column! ' );
		return false;
	}
		i = j*1 -1;	//alert( 'j:' +j +' : len:'+len + ', i:' + i);
		tmppopdataJ = document.makeform["popdata[" + j + "]"].value; // 선택한 컬럼의 다음 컬럼 백업.
		tmpifdataJ = document.makeform["if_data[" + j + "]"].value; // 선택한 컬럼의 다음 컬럼 백업.
		tmpiftypeJ = document.makeform["iftype[" + j + "]"].value;	//alert( 'tmpifdataJ:' +tmpifdataJ + ' , tmpiftypeJ:'+tmpiftypeJ );

		tmppopdataK = document.makeform["popdata[" + i + "]"].value; // 선택한 컬럼의 다음 컬럼 백업.
		tmpifdataK = document.makeform["if_data[" + i + "]"].value; // 선택한 컬럼의 다음 컬럼 백업.
		tmpiftypeK = document.makeform["iftype[" + i + "]"].value;
		document.makeform["popdata[" + i + "]"].value= document.makeform["popdata[" + j + "]"].value; // 2022-02-19
		document.makeform["if_data[" + i + "]"].value= document.makeform["if_data[" + j + "]"].value; //선택한 컬럼의 내용을 다음컬럼 위치에 저장.
		document.makeform["iftype[" + i + "]"].value = document.makeform["iftype[" + j + "]"].value;

		document.makeform["popdata[" + j + "]"].value= tmppopdataK;  // 2022-02-19 add
		document.makeform["if_data[" + j + "]"].value= tmpifdataK; //백업컬럼 내용을 선택한 컬럼위치에 저장
        document.makeform["iftype[" + j + "]"].value = tmpiftypeK;

		tmpValueJ = colnm[j].value;
		tmpValueI = colnm[i].value;  //alert( 'tmpValueJ:' +tmpValueJ + ' , tmpValueI:' +tmpValueI );
		document.getElementById('column_list'+j).value = tmpValueI;
		document.getElementById('column_list'+i).value = tmpValueJ;
		tmpValueJ = document.getElementById('column_list'+j).value;//colnm[j].value;
		tmpValueI = document.getElementById('column_list'+i).value;//colnm[i].value;

	var str_array = '';
    for (k = 0; k < colnm.length; k++) {
		colnm_value = colnm[k].value;
		st = colnm_value.split('|');       //val:275|fld_2|작업공정|CHAR|10
		str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
		document.getElementById('columnR'+k).innerHTML = st[2];//컬럼 내용 화면출력.
	}
	makeform.item_array.value = str_array;
	document.getElementById('column_list'+i).checked=true;
	document.makeform.column_index.value = i; // click point set
} 
//-------------------
function del_func() {
	var pg = document.makeform.pg_codeS.value;
	var tab = document.makeform.tab_hnmS.value;
	if( !tab || !pg) {
		alert(' Please select a table or program! ' );
		return false;
	}
	//selind = makeform.column_list.selectedIndex;
	var j = document.makeform.column_index.value;
	if( j == '' ) {
		alert(' Please select a column! ' );
		return false;
	}
	resp = confirm(' Be careful when deleting columns! \n Are you sure you want to exclude columns?'); // \n 컬럼을 제외 하시겠습니까?
	if( !resp ) return false; 

	//var item_cnt = makeform.column_list.options.length;	 // table item 수.
	var colnm = document.getElementsByName('column_list');
	var item_cnt = colnm.length;  //alert('item_cnt:'+item_cnt); //연속삭제시 숫자 감소 변경됨

	var end_line = colnm.length-1;
	var colnm_value='';

	var str_array="";
	var chk = 0;
	//alert('colnm.length:'+ colnm.length);
	for(var i=0, j=1; i < colnm.length; i++, j++){
			colnm_value = colnm[i].value;
			//alert(i+':colnm_value:'+colnm_value);
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
				document.makeform["popdata[" + i + "]"].value = '';  //  2022-02-19 add
				document.makeform["if_data[" + i + "]"].value = '';
				document.makeform["iftype[" + i + "]"].value = '';
			} else {
				colnm_value = colnm[j].value;
				document.getElementById('column_list'+i).value = colnm_value;
				st = colnm_value.split('|');
				document.getElementById('columnR'+i).innerHTML = st[2];// 컬럼명출력.
				//--------------------------------------------------------
				tmppopdataJ = document.makeform["popdata[" + j + "]"].value;
				tmpifdataJ = document.makeform["if_data[" + j + "]"].value;
				tmpiftypeJ = document.makeform["iftype[" + j + "]"].value;

				document.makeform["popdata[" + i + "]"].value = tmppopdataJ;
				document.makeform["if_data[" + i + "]"].value = tmpifdataJ;
				document.makeform["iftype[" + i + "]"].value = tmpiftypeJ;
			}
			//alert(i+':st2:'+st[2]);
		} else {
			//colnm_value = colnm[i].value;
			//document.getElementById('column_list'+i).value = colnm_value; // 컬럼명출력.
			//st = colnm_value.split('|');
			//document.getElementById('columnR'+i).innerHTML = st[2];// 컬럼명출력.
		}
		//alert('---item_cnt:'+item_cnt + ', i:' +i +':colnm_value:'+colnm_value);
	}	
	var kk = item_cnt -1;
	document.makeform.item_cnt.value = kk;
	fld_msg = document.getElementById('column_list'+kk).value
	//alert('kk:'+kk + ', item_cnt:' + item_cnt + ', end line fld msg:' + fld_msg);

	document.getElementById('column_list'+kk).value = '';
	document.getElementById('columnRX'+kk).innerHTML = ''; // 컬럼 label 출력화면에서 제거..
	document.makeform.column_index.value = '';
    //------------------	
	var str_array = '';
    for (k = 0; k < kk; k++) {
		colnm_value = colnm[k].value;
		st = colnm_value.split('|');       //val:275|fld_2|작업공정|CHAR|10
		str_array += st[0] + '|' + st[1] + '|' + st[2] + '|' + st[3] + '@'; 
	}
	//alert('str_array:' +str_array);//str_array:277|fld_1|상품|CHAR@275|fld_2|작업공정K|CHAR@276|fld_3|작업자k|CHAR@279|fld_5|메모|TEXT@
	makeform.item_array.value = str_array;

	return;
}
//----------------------------------- add seq:2021-05-07 ----
function ifcheck_onclickA(r, seq) {// seq = radio button seq no. column attribute click

	var selind = document.makeform.column_index.value; // colunm index
	/* INT data type 도 radio button, checkbox, listbox 사용 가능 하도록 한다.  해제하면 사용을 못하게 막는다. 2024-01-03
	if( seq=='1' || seq=='2'|| seq=='3'){ // 2024-01-03
		if( document.makeform.column_data_type.value !== "CHAR" ) {
			alert("The data type must be CHAR. Please check! data type:" + document.makeform.column_data_type.value );
			// data type이 CHAR가 아니면 안됩니다. 확인하세요!
			document.makeform.column_attribute.value		= '';
			document.makeform["iftype[" + selind + "]"].value = 0;
			document.makeform.ifcheck[0].checked=true;
			return false;
		}
	} */
	if ( selind == '' ){	// column 선택 확인.
		alert(r+' : Please select a column! ' );
		document.makeform.ifcheck[seq].checked=false;
		return false;
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

	document.makeform.if_line.value = selind;	//column line 중요. table_popup.php에 전달.

	var colnm = document.getElementsByName('column_list');
	var colnm_value = colnm[selind].value; // column val=275|fld_2|작업공정|CHAR|10
	st = colnm_value.split('|');	//alert('colnm_value:'+colnm_value); //colnm_value:|fld_1|상품코드|CHAR|20
	document.makeform.if_column.value = st[1];
    /*
	listbox(sellist)를 radio button(colnm_value)으로 바꾸면서 변화된것으로 
	sellist를 column_list로 명칭을 변경하여 발생함.
	hidden 으로 추가함. sellist : 275|fld_2|작업공정|CHAR|10 -> table_popup.php에서 사용하므로 전달해야함.
	app_pg50RU, table_pg50RU.php -> colnm_value = 275|fld_2|작업공정|CHAR|10
	*/
	document.makeform.sellist.value = colnm_value;// 기존에 sellist:listbox에서 사용하던 것 hidden 추가.

	if( r == 0 )		{ msge="General Input"; } //msgh=" 일반입력 속성 ";
	else if( r == 1 )	{ msge="Radio Button"; }  //msgh=" 라디오버턴 속성 ";	
	else if( r == 3 )	{ msge="Check Box Button"; } //msgh=" 체크박스버턴 속성 ";	
	else if( r == 5 )	{ msge="List Box"; }         //msgh=" 리스트박스 속성 ";	
	else if( r == 7 )	{ msge="Password Type"; } //msgh=" 암호입력 속성 ";		
	else if( r == 9 )	{ msge="Attached file"; } //msgh=" 첨부화일 속성 ";		
	else if( r == 11 )	{ msge="Formula."; }      //msgh=" 계산식 속성 ";		
	else if( r == 13 )	{ msge="Pop-up Window"; } //msgh=" 팝업창 속성 ";		
	else				{ msge="General Input"; } //msgh=" 일반입력 속성 ";		

    var obj1 = document.makeform.ifcheck.value; 
	var obj2 = document.makeform.column_attribute.value;	 // 컬럼 조건 정의
    var obj3 = document.makeform.column_name_change.value; 

		if(r==0) { // General Input
				document.makeform.column_attribute.value		= '';
				document.makeform["iftype[" + selind + "]"].value = r;
		} else if( r==13)	{ // POPUP Window

				document.makeform["iftype[" + selind + "]"].value = r;
				document.makeform.action          = 'table_popupRM.php'; //최종 mobile:table_popupR.php,table_popup.php, old:table_popup_new.php
				document.makeform.mode.value      = ''; // popup seup go
				document.makeform.mode_call.value = 'app_pg50RU'; // table_item_run50R
				document.makeform.target          = '_self';      // table_main, tab_pg_list
				document.makeform.submit();
		} else if( r==11)	{ // Formula.
				document.makeform["iftype[" + selind + "]"].value = r;
				document.makeform.target          = '_self';
				document.makeform.action          = 'table_formulaM.php';
				document.makeform.mode.value      = 'run13';
				document.makeform.mode_call.value = 'app_pg50RU'; //document.makeform.mode_call.value = 'table_item_run50R';
				document.makeform.submit();
		} else if( r==1 || r==3 || r==5){	 // 1:라디오버턴,3:체크박스,5:리스트박스.
			if( !obj2 ) {
				alert(" Enter column processing items using delimiter ':' as in a:b:c:d"); // \n 컬럼처리 항목을 a:b:c:d: 와같이 구분자 ':'을 사용하여 입력하세요!
				document.makeform["iftype[" + selind + "]"].value = r;
				document.makeform.column_attribute.focus();
				return false;
			} else {
				//document.makeform["if_data[" + selind + "]"].value = obj2; // 막음 2022-02-19 확인필요.
				document.makeform["iftype[" + selind + "]"].value = r;
			}
		} else {	// r=9-첨부화일, r=7-password
				document.makeform.column_attribute.value		= '';
				document.makeform["iftype[" + selind + "]"].value = r;
		}
} 
//------------------------------
	function Apply_button() {
		//var selind = makeform.column_list.selectedIndex;
		var selind = document.makeform.column_index.value; // column position

		if ( selind < 0 ){	// column 선택 확인.
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
		//col_selind = selind - 1;
		var colnm_value = colnm[selind].value; // column val=275|fld_2|작업공정|CHAR|10
		var test = colnm_value.split('|'); //val:275|fld_2|작업공정|CHAR|10
		colnm_hnm = test[2];

		//ifselind = selind;
		ii = document.makeform["iftype[" + selind + "]"].value;

		if(ii==1 || ii==3 || ii==5 ){ // 1:radio button, 3:check box, 5:listbox, 만적용한다.
		    
			if(ii==1) msg='1:radio button';
			else if(ii==3) msg='3:check box';
			else if(ii==5) msg='5:list box';
			// chgStr.indexOf("^")>=0 || ----> '^' 만 가능하도록한다.
			if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("%")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0 || chgStr.indexOf("$")>=0 || chgStr.indexOf("@")>=0 || chgStr.indexOf("&")>=0 || chgStr.indexOf("*")>=0 || chgStr.indexOf("~")>=0 || chgStr.indexOf("#")>=0 || chgStr.indexOf("!")>=0 || chgStr.indexOf("`")>=0 || chgStr.indexOf(";")>=0 )
			{ // chgStr.indexOf("(")>=0 || chgStr.indexOf(")")>=0 ||  제거함. 2021-10-13
				alert(' You used a special character that is not allowed. \n Please enter it again.');
				// \n 허용이 안 되는 특수문자를 사용하셨습니다. \n 다시 입력하시기 바랍니다.
				return false;
			}
			document.makeform["if_data[" + selind + "]"].value = chgStr;
			document.makeform["iftype[" + selind + "]"].value = ii;	//alert( colnm_hnm + ' , ' + msg + ', label=' +chgStr );
		} else {
			alert(' Please enter a property! 1:radio button or 3:check box or 5:listbox Only' );// 1:radio button or 3:check box or 5:listbox 만적용한다.
			return false;
		}
	}
	function titlechange_btncfm_onclickA() {
		
		var chgStr = makeform.column_name_change.value;	//alert('chgStr:' + chgStr); return;
		// chgStr.indexOf("^")>=0 || '^' 만 가능하도록 한다.
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
		var test = "";
		var new_column = "";

		for(var i = 0, j=0; i < colnm.length; i++, j++){
			colnm_value = colnm[i].value;
			test = colnm_value.split('|'); //val:275|fld_2|작업공정|CHAR|10
			fld_hnm = test[2];
			// 같은 이름이 있는지?
			
			//alert('chgStr:'+chgStr+ ', fld_hnm:' + fld_hnm);

			if (chgStr == fld_hnm ) {
				alert("This name already exists.");
				return false;
			}
			if( colnm[i].checked ){
				new_column = test[0]+'|'+test[1]+'|'+chgStr+'|'+test[3]+'|'+test[4];
				//alert('new_column:' + new_column);
				//colnm[i].value = new_column;
				//document.getElementsByName('column_list'+i).value = new_column;
				document.getElementById('column_list'+j).value = new_column;
				var cnm = document.getElementById('column_list'+j).value;
				
				document.getElementById('columnR'+j).innerHTML = chgStr;//ㅋ컬럼변경내용 화면출력.
				//$("label").text(your value);
				//alert('cnm:' + cnm);
			}
		}	
		//alert('chgStr:' + chgStr);
		colnm = document.getElementsByName('column_list');		//alert('colnm.length:' + colnm.length);
		str_array = "";
		for (i = 0; i < colnm.length; i++) {
			colnm_value = colnm[i].value;
			st = colnm_value.split('|');//val:275|fld_2|작업공정|CHAR|10// seqno+enm+hnm+type+len
			str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
		} 
		//alert('item_array str_array:'+str_array);
		document.makeform.item_array.value = str_array;
		return;
	}
function Save_and_Run(pg)
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

	mode_session_ok = document.makeform.mode_session_ok.value;
	mode_session = document.makeform.mode_session.value;	//alert('mode_session: '+mode_session + ', mode_session_ok: ' + mode_session_ok);
	
	var colnm = document.getElementsByName('column_list');
	var st = "";	//var new_column = "";
	var item_cnt = colnm.length;	//var item_cnt = makeform.column_list.options.length; 
	var str_array= "";

	//중요! - 컬럼 순서변경, 컬럼명칭 변경, 컬럼 조건및 조건데이터 처리 에따른 item_array 재생성.18-09-11
	for (i = 0; i < item_cnt; i++) {
		colnm_value = colnm[i].value;
		st = colnm_value.split('|');  //val:275|fld_2|작업공정|CHAR|10// seqno+enm+hnm+type+len
		str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
	} 
	document.makeform.item_array.value = str_array;
	//document.makeform.mode.value = 'table10_pg_create';
	
	if( mode_session == "POPUP" || mode_session == "Formula") {
		if( mode_session_ok == 'end') {
			document.makeform.mode.value = 'Pg_Upgrade'; //'pg_update'; - 2023-09-18 변경. // upgrade 작업시 1일 1번만 point 지급
		} else {
			document.makeform.mode.value = 'Pg_Upgrade'; //point 지급:600
			//document.makeform.mode_session_ok.value = 'end'; // 중복지급 차단.
		}
	} else document.makeform.mode.value = 'Pg_Upgrade'; //'pg_update'; - 2023-09-18 변경.  // pg_new_create - 

	document.makeform.mode_call.value = 'app_pg50RU';    // table_pg50R, 'table_item_run50';
//	document.makeform.action='table_item_run50.php';     // curl 작업을 여기서 실행한다. tkher_program_run
	document.makeform.action='table_item_run50_pg50RU.php';     // 2023-09-18 새로 생성. table10 테아블 update 부분을 막았다. curl 작업을 여기서 실행한다. tkher_program_run

	//document.makeform.action='tkher_program_run.php';  //tkher_program_run
	document.makeform.target='_blank';//run_menu, _self 
	document.makeform.submit();
}
//--- 사용 하지않는다. --------
/*
function Create_button(pg)
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
	if( !pg_dup_check() ) return false;  // 프로그램명 중복 입니다.
	
	//var item_cnt = makeform.column_list.options.length; 
	var str_array="";
	var colnm = document.getElementsByName('column_list');
	var st = "";
	var item_cnt = colnm.length;
	for (i = 0; i < item_cnt; i++) {
		colnm_value = colnm[i].value;
		st = colnm_value.split('|');//val:275|fld_2|작업공정|CHAR|10// seqno+enm+hnm+type+len
		str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
	} 
	document.makeform.item_array.value = str_array;
	document.makeform.mode.value = 'pg_update'; // pg_new_create
	document.makeform.mode_call.value = 'app_pg50RU'; // table_pg50R, 'table_item_run50';
	//document.makeform.action='table_item_run50.php';  // tkher_program_run
	document.makeform.action='tkher_program_run.php';  // tkher_program_run
	document.makeform.target='tab_pg_list';
	document.makeform.submit();
}*/

	function change_project_func(cd){
		prj = cd.split(':');
		//index = document.makeform.project_nmS.selectedIndex;	//alert('index: ' + index );
		//nm = document.makeform.project_nmS.options[index].text;
		document.makeform.project_code.value = prj[0]; //nm;
		document.makeform.project_name.value = prj[1]; //vv = document.makeform.project_nmS.options[index].value;
		document.makeform.project_nmSX.value = cd;	//alert('cd: ' + cd + ', nm: ' + prj[1]+ ', vv: ' + vv);
		document.makeform.mode.value = "project_search";
		document.makeform.action ="app_pg50RU.php";
		document.makeform.submit();
		return;
	}
//-->
</script>

<body leftmargin="0" topmargin="0">

<?php
	$pg_code			= $H_ID . "_" . time();	//$multy_menu_sel	= $_REQUEST['multy_menu_sel'];
	$mode_session   = $_POST['mode_session']; //m_("mode: " . $mode . ", mode_session:" . $mode_session); //mode: project_search, mode_session:, mode: SearchPG, mode_session:
	$if_line_session= '';
	if( $_POST['mode_session'] == 'POPUP') {

		$if_line_session	= $_POST["if_line"];    //get_session("if_line");
		$j						= $if_line_session+1;
		$pg_codeS			= $_POST["pg_codeS"];   //$pg_codeS_session; // 2023-1005
		$tab_hnmS				= $_POST["tab_hnmS"]; //$tab_hnmS_session;
		$mode					= 'SearchPG';
		$aa						= explode(':', $_POST["pop_tabS"] );
		$column_attribute	= $aa[1]; 
		$at						= explode('|', $_POST["iftype_db"] );
		$fld_sel_type			= $at[$j]; 
		$ar						= explode('@', $_POST["item_array"] ); 
		$arr					= $ar[$if_line_session];
		$flda					= explode('|', $arr);
		$fld_sel				= $flda[1]; 
		$mode_session       = ''; set_session('mode_session',  '');

	} else if( $_POST['mode_session'] == 'Formula') {

		$if_line_session	= $_POST["if_line"];       //get_session("if_line");
		$j					= $if_line_session+1;
		$pg_codeS			= $_POST["pg_codeS"];      //$pg_codeS_session;
		$tab_hnmS			= $_POST["tab_hnmS"];      //$tab_hnmS_session;
		$mode				='SearchPG';
		$calc				= explode(':', $_POST["formula_data"] ); //$formula_data_session
		$column_attribute	= $calc[1];
		$at					= explode('|', $_POST["iftype_db"] ); //$iftype_db_session
		$fld_sel_type		= $at[$j]; 
		$ar					= explode('@', $_POST["item_array"] ); //$item_array_session
		$arr				= $ar[$if_line_session];
		$flda				= explode('|', $arr);
		$fld_sel			= $flda[1]; 
		$mode_session       = ''; set_session('mode_session',  '');
	}
	if( $mode == 'SearchPG' ){
		//m_("mode: " . $mode . ", pg_codeS:" . $pg_codeS); //mode: SearchPG, pg_codeS:dao_1633396679:출고:dao_1633396679:출고:9999:출고
		$aa         = explode(':', $pg_codeS);
		$pg_code    = $aa[0];
		$pg_name    = $aa[1];
		$tab_enm    = $aa[2];
		$tab_hnm    = $aa[3];
		$group_code	= $aa[4];
		$group_name	= $aa[5];
		$sqlPG			= "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$pg_code."' "; //"SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID'  and pg_code='$pg_code' ";
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
		$tab_hnmS		= $tab_enm . ":" . $tab_hnm;
	}	// mode search end
	$w		= '100%';
	$w2	= '300';

	$mode_session_ok = get_session("mode_session_ok");//m_("mode_session_ok: $mode_session_ok");
?>
<center>
<div id='menu_normal'>
   <table cellspacing='0' cellpadding='4' width='<?=$w2?>' border='1' class="c1"> 
		<form name="makeform" method="post" >
			<input type="hidden" name="sellist"	        value="" >
			<input type="hidden" name="program_level"	value="<?=$_POST['lev']?>" >
			<input type="hidden" name="mode"            value="" >
			<input type="hidden" name="mode_call"		value="" >
			<input type="hidden" name="pg_code"			value="<?=$pg_code?>">
			<input type="hidden" name="calc"            value="<?=$calc?>"> 
			<input type="hidden" name="pop_data"		value="<?=$pop_data?>"> 
			<input type="hidden" name="rel_data"        value="<?=$rel_data?>"> 
			<input type="hidden" name="rel_type"        value="<?=$rel_type?>"> 
			<input type="hidden" name="mode_session"    value=""> 
			<input type="hidden" name="mode_session_ok" value='<?=get_session("mode_session_ok")?>'> 
			<input type="hidden" name="project_nmSX"	value="<?=$_POST['project_nmS']?>"> <!-- project_nmSX -->
			<input type="hidden" name="project_code"	value="<?=$_POST['project_code']?>"> 
 <tr>
    <td height="30" style="border-style:;background-color:#666666;color:cyan;" 
	<?php //echo" title='Program Upgrade. \n 1:Select Project. \n 2:Select Program. \n 3:Select column. \n 4: Column attribute definition. \n 5:Click Save and RUN button.' "; 
		echo" title='Program Upgrade:app_pg50RU' "; 
	?>
	align='center'>Program Upgrade<br>
	<input type='hidden' name='project_name' value="<?=$_POST['project_name']?>" style="border-style:;background-color:#666666;color:yellow;width:130px; height:25px;" readonly>
		<!-- display:none; -->
	<input type='text' id='pg_name' name='pg_name' value='<?=$pg_name?>' maxlength='200'  style="display:none;border-style:;background-color:black;color:yellow;height:25;width:130;" value='' 
	<?php echo" title=' Enter the name of the program to be created and select the table! ' "; ?>>
		<!-- display:none; -->
		<!-- <input type='button' value='Create' onClick="Create_button('table_item_run50')" style="display:none;border-style:;background-color:#666fff;color:yellow; height:25px;" <?php echo "title='Program Upgrade. ' "; ?> title='table_pg50'> -->
<br><p align='left'>
	Project:<SELECT id='project_nmS' name='project_nmS' onchange="change_project_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:80%; height:30px;" <?php echo" title='Please select the table to use for the program! ' "; ?> >
<?php 
if( isset( $_POST['project_nmS'] ) ) {
	$pj = $_POST['project_nmS'];
	$pcd_nm = explode(":", $pj );//m_("pj: " . $pj . ", pcd_nm0:" . $pcd_nm[0] . ", pcd_nm1:" . $pcd_nm[1]); //pj: ksd39673976_16878342:ksd39673976
	//$pcd_nm = explode(":", $_POST['project_nmSX'] );//m_("pj: " . $pj . ", pcd_nm0:" . $pcd_nm[0] . ", pcd_nm1:" . $pcd_nm[1]); //pj: ksd39673976_16878342:ksd39673976
?>
			<option value="<?=$_POST['project_nmS']?>" selected ><?=$pcd_nm[1]?></option>
<?php
} else {
?>
			<option value=''>1.Select Project</option>
<?php
}
				$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by upday desc " ); // table10_group
				while( $rs = sql_fetch_array($result)) {
?>
					<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' title='Project code: <?php echo $rs['group_code'];?>' ><?=$rs['group_name']?></option>
<?php
				}
?>
			</select>
		<br>Program:
		<select name='pg_codeS' onchange="change_program_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:130px; height:25px;" <?php echo" title='Upgrade the program.' "; ?> >
<?php 
				if($mode=='SearchPG') {
?>
					<option value="<?php echo $pg_codeS ?>"  selected ><?php echo $pg_name ?> </option>
<?php
				} else {
?>
					<option value=''>Select Program</option>
<?php
				}
				$sql = "SELECT * from {$tkher['table10_pg_table']} where group_code='". $pcd_nm[0] ."' order by upday desc , pg_name ";
				$result = sql_query( $sql );
				while( $rs = sql_fetch_array($result)) {
?>
					<option value="<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php echo" title='Program code:$pg_codeS' "; ?> ><?=$rs['pg_name']?></option>
<?php
				}
?>
			</select></p>
</td>
</tr>
			  <tr>
				<td align="left" <?php echo" title='Program Upgrade \n 1:Select Project \n 2:Select Program \n 3:Select column \n 4: Column attribute definition \n 5:Click Save and RUN button'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;">Table to use in the program:
				<input type='hidden' name='tab_hnmS' value="<?=$tab_hnmS?>" ><?=$tab_enm?><br>
				<input type='text'   name='tab_hnm'  value="<?=$tab_hnm?>" style="border-style:;background-color:#666666;color:yellow;width:100%; height:27px;font-size:15px;" readonly >
				</td>
			  </tr>
			  <tr>
				 <td valign="top">
	<div id="here">
<?php
	$ss = "";
	$ckv = "";	//m_("if_line:" . $_POST["if_line"]);
	if( $table10_pg ){ 
			$itX = explode("@",$item_array);
			for( $i=0, $j=0; $i < $item_cnt; $i++, $j++){
				if( $_POST['mode_session'] == 'POPUP' || $_POST['mode_session'] == 'Formula' ) {
					if( $_POST["if_line"] == $j) $ckv = " checked "; 
					else $ckv = "";
				}
				$it = explode("|",$itX[$i]);	//라벨만을 변경해야 하므로 lavel이 2개있다 중요.
				$val = $it[0]."|".$it[1]."|".$it[2]."|".$it[3]."|".$it[4];
				$ss = $ss . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. " )'><input type='radio' ".$ckv." id='column_list".$j."' name='column_list' onclick='column_list_onclickA(this.value, " .$j. " )' value='".$it[0]."|".$it[1]."|".$it[2]."|".$it[3]."|".$it[4]."'><label title='".$val."' id='columnR".$j."'>".$it[2]."</label></label><br>";
			} //for
	} else {
		//m_("1370 table10_pg NULL : tab_enm: " . $tab_enm);
	} //if( $table10_pg>0 or $table10_tab>0 ){ 
	//  $qna = "프로그램의 작업에서 가능하지 않는 것은?|컬럼순서 변경|컬럼명 변경|컬럼삭제|컬럼추가";
	//	$qna = "What is not possible in the work of the program here?|Change column order|Change column name|Delete column|Add column|4^프로그램의 작업에서 가능하지 않는 것은?|컬럼순서 변경|컬럼명 변경|컬럼삭제|컬럼추가|4^프로그램의 작업순서가 아닌것은?|프로그램명설정-테이블선택-생성버턴|테이블선택-프로그램명설정-생성버턴|프로그램명설정-생성버턴|3";
	//  ^문제 부뉴, |문항 분류 마지막 숫자는 정답. 중요. 
	$qna = "sequence of the work|Select Project.|Select Program.|Select column.|Column attribute definition.|Click Save and RUN button.|4^작업순서|Project 선택|Program 선택|컬럼을 선택한다.|컬럼의 속성을 정의 한다.|Save and RUN 버턴 클릭.|4";
	echo "<script> rr_func(\"".$ss."\", \"".$qna."\");</script> "; // 최초화면에 설문지 출력 중요.
?>
		<!-- </select> -->
		</div>
		<!-- </table> -->
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
								<input type='button' value='Confirm' name='title_changeX'  onClick="titlechange_btncfm_onclickA()"  style="border-style:;background-color:green;color:white;height:25;" <?php echo "title=\" You can change the name of the column. \" "; ?> ><br>
							*Column attribute data<br>
							   <input type='text' id='column_attribute' name='column_attribute' maxlength='200' size='28' style="border-style:;background-color:black;color:yellow;height:25;" value='<?=$column_attribute?>' <?php echo "title=\"  hobby:baseball:bootball:basketball:tennis:golf , Use delimiter ':' to separate.\" "; ?>>
							   <!--  \n 입력예-취미:야구:축구:농구:테니스:골프 와 같이 구분자 ':' 를 사용하여 구분한다. -->
							   <input type='button' value='Apply Attribute' onclick='Apply_button();' style="border-style:;background-color:green;color:white;height:25;" <?php echo "title=\"hobby:baseball:bootball:basketball:tennis:golf , Use delimiter ':' to separate.\" "; ?> > 
<br>
<label class="container" <?php echo "title='Only one selectable button. ' "; ?> >
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
<br><!-- 예를들면 수량과 단가를 입력하면 금액을 계산하여주는 컬럼입니다. -->
<label class="container" <?php echo "title='table_formulaM.php \n This column is calculated and output when data is registered.\n For example, if you enter quantity and unit price,\n it is a column that calculates the amount.' "; ?>>
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
	   <!-- <textarea id=ifmsg name=ifmsg rows=3 cols=30 style="display:none;"></textarea> -->
		<input type='hidden' id='column_attribute_index' name='column_attribute_index' >
		<input type='hidden' id='column_index' name='column_index' ><!-- add 2021-05-01 -->
		<!-- <input type='hidden' name='multy_menu_sel' > --><!-- 2023-10-05 close -->
		<input type='hidden' name='tab_enm'  value='<?=$tab_enm?>' >
		<input type='hidden' name='seqno'      value='<?=$seqno?>' >
		<input type='hidden' name='item_cnt'   value='<?=$item_cnt?>' >
		<input type='hidden' name='if_line'    value="<?=$_POST['if_line']?>" >
		<input type='hidden' name='if_column'  value="<?=$_POST['if_column']?>" ><!-- 2023-10-10 add -->
		<input type='hidden' name='item_array' value='<?=$item_array?>' >
<?php
			if( $table10_pg > 0 ) { // table10_pg 테이블에 pg_code 가 존재하면.//			if( $table10_pg>0 || $table10_tab>0 ) {
					$iftypeR = explode("|", $if_type );
					$ifdataR = explode("|", $if_data );
					$itemR   = explode("@", $item_array );
					$popdataR= explode("^", $pop_data );               // add 2022-02-19
					for( $i=0, $j=1; $i < $item_cnt; $i++, $j++){
						$ifT	= $iftypeR[$j];
						$ifD	= $ifdataR[$j];
						$it		= $itemR[$i];
						$pop	= $popdataR[$j];  // add 2022-02-19
?>
						<input type='hidden' name="iftype[<?=$i?>]" value='<?=$ifT?>' >
						<input type='hidden' name="if_data[<?=$i?>]" value='<?=$ifD?>' > 
						<input type='hidden' name="popdata[<?=$i?>]" value='<?=$pop?>' > <!-- add 2022-02-19 -->
<?php
					}			
			} else {
				//my_msg("ERROR Fetch------------table10_pg:$table10_pg , table10_tab:$table10_tab ");//첫실행시에 온다.
			}
?>
					 </td>
				</tr>
				<tr>
                    <td align="center" >
						<input type='button' value='Save and Run' <?php echo "title='Save the column attribute information and run the program:$pg_name.' "; ?> onClick="Save_and_Run('table_item_run50')"  style="border-style:;background-color:green;color:white; height:25px;">
					</td>
                </tr>
						<input type='hidden' name='group_code' value="<?=$group_code?>" >
						<input type='hidden' name='group_name' value="<?=$group_name?>" >
						<input type='hidden' name='iftype_db'  value="<?=$_POST['iftype_db']?>" >
						<!-- 
						<input type='hidden' name='ifdata_db'  value='<?=$if_dataX?>' >
						<input type='hidden' name='popdata_db' value='<?=$pop_dataX?>' > -->
		</form>
	</table>
</div>
</body>
</html>
