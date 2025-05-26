<?php
	include_once('../tkher_start_necessary.php');
/*
사용 미완 - 검토 2024-04-16
*/
	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$H_NICK	= $member['mb_nick'];
	$from_session_id = $H_ID;
	$cranim_id  = $H_ID;
	$cranim_lev = $H_LEV;

	if( !$H_ID || $H_LEV < 2 ) {
		m_("Login Please!");
			$url='/';	//$PHP_SELF;
			echo("<meta http-equiv='refresh' content='0; URL=$url'>");
			exit;
	}
/* ---------------------------------------------------------------------------------
	board_create_pop.php : 사용 확인 OK. : 2024-01-22 call : /menu/board_list_admin.php 
	- 관리자용 ? 확인 필요. 사용 유무 ?
	call : run_menu.php에 등록한 메뉴.
	run : board_create_pop_ok.php에서 생성한다.
	작업내용 : job_link_table 와 aboard_info를 동시에 생성한다. job_link_table의 aboard_no = {$tkher['aboard_infor_table']}의 no는 값이 동일하다. 

	-------------------------------------------------------------------- 
*/
?>

<html>

<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Tkher system for special her. Tkher system is generator program.  Made in ChulHo Kang</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/land25.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
if( $H_LEV < 7 )
{
	//echo("<script> alert('접근 권한이 없습니다. 다시 로그인 하십시요');window.close(); </script>");
	echo "<script>alert(' Login Please! lev= $H_LEV'); history.go(-1);</script>";
	exit;

}
	//$array[] = 0;
	//echo "{$tkher['aboard_infor_table']} name=$text_name";

	if ($mode == "delete") {
		$mode = "insert";

   		$sql = "SELECT * from {$tkher['aboard_infor_table']} where make_club='$session_club_url' and make_id='$H_ID' and no='$board_no'";
   	    $result = sql_query($sql);
   	    $row = sql_fetch_array($result);

		$query	="delete from {$tkher['aboard_infor_table']} where make_club='$session_club_url' and make_id='$H_ID' and no='$board_no'";
		$mq1	=sql_query($query);
		$query	="drop table aboard_".$row['table_name'];
		$mq2	=sql_query($query);
		
		$query	="delete from {$tkher['job_link_table']} where make_club='$session_club_url' and make_id='$H_ID' and no='$board_no'";
		$mq3	=sql_query($query);

		if($mq1 and $mq2 and $mq3){echo("<script>alert('delete OK!')</script>");}

		///////////////////////////////  작업 대기   /////////////////////////

		/////////////////////////////////////////////////////////////////////

		echo("<meta http-equiv='refresh' content='0; URL=bbs_insert_member.php'>"); // D:\_appgenerator\og\moa\board\club_admin\bbs_insert_member.php - 2024-01-22 : 내용확인필요.

		//sql_query("delete from {$tkher['aboard_infor_table']} where name ='$text_name'");   

	}

?>

<link href="../include/css/admin_style1.css" rel="stylesheet" type="text/css">
<link rel='stylesheet' href='../t/include/css/kancss.css' type='text/css'><!-- 중요! -->

<SCRIPT language=JavaScript src="../include/js/board_func.js"></SCRIPT>

</head>

<body leftmargin="0" topmargin="0">

<script language="JavaScript"> 
<!--
 
var frealname = ''
var isEdited = false
var delList = ''
var smode=false
var start, end, grpStr
 
 
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
		//DB -> <option value='<?=$rsP['no']?>|<?=$rsP[home_url]?>'><?=$rsP[name]?></option>
//		alert(strA[0]);	//113
		
		var fid = strA[1]		//makeform.sellist.options[k].value
//		alert(strA[1]);	//GCOM02!:
		
//		fid = fid.substring( 0, fid.indexOf("!:") )
		fid = fid.substring( 0, fid.indexOf("!") )
//		alert(fid);
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

/*
//그룹핑이 제대로 되었는지 체크
//groupCnt<0 이면 그룹의 순서가 바뀐것. groupCnt>1 이면 그룹안에 그룹이 지정된 것
function UpdateYN() {
	var funcValue
	var groupCnt = 0
	var text
	for(i=0; i < makeform.sellist.options.length ; i++){
		text = chkGroup(makeform.sellist.options[i].text);
		funcValue = makeform.sellist.options[i].value;
		if ((funcValue == "group") || (getObjid(funcValue) == "GSTR"))
			groupCnt = groupCnt + 1
		else if ((funcValue == "groupend") || (getObjid(funcValue) == "GEND"))
			groupCnt = groupCnt - 1
 
		if (groupCnt < 0) {
			text = "[" + text + "] 그룹 지정이 잘못되었습니다.\n[" + text + "] 의 끝을 내려주세요.";
			alert(text);
			smode = false;
			break;
		}
		else if (groupCnt > 1) {
			text = "[" + text + "] 그룹 지정이 잘못되었습니다.\n그룹이 끝나기 전에 또 다른 그룹을 지정할 수 없습니다.";
			alert(text);
			smode = false;
			break;
		}
	}
}
 
function save(mode) {
	smode=mode
	makeform.selstr.value = "" + delList
 
	UpdateYN()  //그룹이 옳바른지 체크한다.
	if (smode) {
		if(makeform.sellist.options.length<1){
			alert("기능은 한 개 이상 선택하셔야 합니다.");return;
		}
		for(i=0; i < makeform.sellist.options.length ; i++)
			if ((makeform.sellist.options[i].value == "group") || (makeform.sellist.options[i].value == "groupend"))
				makeform.selstr.value += makeform.sellist.options[i].value + "!:0!:" + makeform.valgroup.value + "!:" + chkGroup(makeform.sellist.options[i].text) + "!#"
			else if ((getObjid(makeform.sellist.options[i].value) == "GSTR") || (getObjid(makeform.sellist.options[i].value) == "GEND"))
				makeform.selstr.value += makeform.sellist.options[i].value + "!:" + chkGroup(makeform.sellist.options[i].text) + "!#"
			else
				makeform.selstr.value += makeform.sellist.options[i].value + "!:" + getfname(makeform.sellist.options[i].text) + "!#"
 
		if (mode) {
			makeform.action = "mngfuncProcess.asp"
			makeform.target= "_self"
			makeform.submit()
		}
	}
}*/
 //<option value="GCOM01!:0!:4!,4!,4!,7!,7!,0!,X!,">[통합] 공지사항 </option>
 
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

/*
function Add2List_set(textx, valuex) {
   var optStr, newOpt, tstr, newOpt2, kkk

   if ( makeform.fnclist.selectedIndex < 0){
		alert ("Please select a board to create! ");return;
	}
	for (var k=0 ; k < makeform.fnclist.options.length ; k++)
	{
		if ( makeform.fnclist.options[k] != "" && makeform.fnclist.options[k].selected && !makeform.fnclist.options[k].disabled) {
    		var fnm = makeform.fnclist.options[k].text.substr( makeform.fnclist.options[k].text.indexOf("]")+2);
    		var fnm2 = makeform.fnclist.options[k].text.substr( makeform.fnclist.options[k].text.indexOf("]")+1);
			alert('fnm:'+fnm +'fnm2:'+fnm2); return false;
		   if (fnm.indexOf("*")>=0) {
				makeform.fnclist.options[k].disabled=true
				fnm = fnm.substring(0,fnm.length-1)
			}
 
			if ( makeform.fnclist.options[k].value == "group") {
				newOpt = document.createElement("OPTION")
				tstr = chkname( fnm )
				frealname = "["+fnm+"]"

				newOpt.text = "-----" + frealname + " 시작-----"
				newOpt.value = makeform.fnclist.options[k].value

				makeform.sellist.add( newOpt )
				makeform.sellist.selectedIndex = makeform.sellist.options.length-1
 
				newOpt2 = document.createElement("OPTION")
				newOpt2.text = "-----" + frealname + " 끝-------"
				newOpt2.value = "groupend"				 //makeform.fnclist.options[k].value

				makeform.sellist.add(newOpt2)
				makeform.sellist.selectedIndex = makeform.sellist.options.length-1

				makeform.chgname.value = tstr

				//makeform.board_gubun_value.value = newOpt.value
				//makeform.board_gubun_value.value = frealname
				//makeform.board_gubun_text.value = textx
			}
			else {
 
				if (makeform.sellist.length > 50) {
					//alert ("기능은 50개까지만 선택할 수 있습니다.");return;
				}
 
				newOpt = document.createElement("OPTION")

				tstr = chkname( fnm )

				frealname = "["+fnm+"]"
				newOpt.text = frealname+" "+tstr

				newOpt.value = makeform.fnclist.options[k].value

				makeform.sellist.add(newOpt)
				makeform.sellist.selectedIndex = makeform.sellist.options.length-1

				makeform.chgname.value = tstr

				makeform.sellist_index.value = k
				//makeform.board_gubun_value.value = newOpt.value
				//makeform.board_gubun_value.value = frealname
				makeform.board_gubun_text.value = newOpt.text

			}
		}
	}
	isEdited = true;
}
*/
 
function chkname(fname) {
	var cnt = 0
	for (i=0;i<makeform.sellist.options.length;i++)
	{
	    var compstr = getfname( makeform.sellist.options[i].text )
	    var srchidx = compstr.indexOf("(")
	    var laststr
	    if (srchidx > -1)
	  	 laststr = compstr.slice(0, srchidx)
	    else
	     laststr = compstr
 
	    if (fname == laststr)
	    {
	      cnt = cnt + 1
	    }
	}
	if (cnt > 0) fname += "("+cnt+")"
	return fname
}
 
function getfname(str) {
	if (str.indexOf("]") > 0) {
		frealname = str.substring(0, str.indexOf("]")+1)
		str = str.substr(str.indexOf("]")+2)
	}
	return str
}
 
// 보기항목 리스트에서 선택된 항목들....삭제
function delAddList() {
	var selind = 0
 
	//삭제할 기능이 선택됐는가..?
	selind = makeform.sellist.selectedIndex
	var strAx = makeform.sellist.options[selind].value
	var strA  = strAx.split("|")
	makeform.board_no.value = strA[0]
	
	//alert(strA[0])
	if (selind < 0)
	{
		alert("삭제 할 기능을 선택하십시오.")
		return;
	}
	var str = makeform.sellist.options[selind].value

	var tobjid = getObjid( makeform.sellist.options[selind].value)
	if ((tobjid == "") || (tobjid == "GSTR") ||(tobjid == "GEND") || (str == "group") || (str == "groupend")) {
		if (!confirm("'["+ makeform.sellist.options[selind].text  +"]' Are you sure you want to delete?")) return
		if ((str == "group") || (tobjid == "GSTR"))	{
			start = selind
			end = grpnum("start", selind)
		}
		else if ((str == "groupend") || (tobjid == "GEND")) {
			start = grpnum("end", selind)
			end = selind
		}
		var startStr = makeform.sellist.options[start].value
		var endStr = makeform.sellist.options[end].value
		if (startStr.length>0 && (startStr != "group") && (startStr != "groupend")) {
			var startStrA = startStr.split("!:")
			delList += "GSTR!:-"+startStrA[1]+"!:"+startStrA[2]+"!:"+chkGroup(makeform.sellist.options[start].text)+"!#"
		}
		if (endStr.length>0 && (endStr != "group") && (endStr != "groupend")) {
			var endStrA = endStr.split("!:")
			delList += "GEND!:-"+endStrA[1]+"!:"+endStrA[2]+"!:"+chkGroup(makeform.sellist.options[end].text)+"!#"
		}
			makeform.sellist.remove(start)
			//end index-1
			makeform.sellist.remove(end-1)
	}
	else {

		if (!confirm("'"+ makeform.sellist.options[selind].text +"'을(를) 삭제합니다. 저장되어 있는 데이터가 모두 없어집니다.\n삭제하시겠습니까?")) return
		if (str.length>0) {
			var strA = str.split("!:")
			delList += strA[0]+"!:-"+strA[1]+"!:"+strA[2]+"!:"+getfname(makeform.sellist.options[selind].text)+"!#"
		}
 
		if (!getFuncMulti(tobjid))
			for (var k=0 ; k < makeform.fnclist.options.length ; k++)
				if (makeform.fnclist.options[k].value.indexOf(tobjid)>=0) {
					makeform.fnclist.options[k].disabled=false
					break;
				}
            //resp = confirm('삭제하시겠습니까?');          

		makeform.sellist.remove(selind)
		var txt = makeform.chgname.value

		location.href='<?=$PHP_SELF?>?mode=delete&text_name='+txt+'&board_no='+strA[0];
		//window.location.href='query_ok.php?mode=aboard_delete&text_name='+txt;}

	}
 
	isEdited = true
	//sellist_onclick()
}
 
// 그룹의 이름 변경해주는 부분
function chkGroup(str){
		str = str.substring(str.indexOf("[")+1, str.indexOf("]"))
		return str
}
 
//	group의 시작 & 끝 index값 알아오기 & 변경
//	index : start & end
function grpnum(gbn, index){
	var i, j, selvalue, beforeval, nextval, endYN, startYN
	for ( i=0; i < makeform.sellist.options.length; i++)
	{
		var grpval = makeform.sellist.options[i].value
		if (gbn == "start")	{
			if ((grpval == "groupend") || (getObjid(grpval) == "GEND")) {
				startYN = "Y"
				for (j=index; j<makeform.sellist.options.length; j++) {
					if ((makeform.sellist.options[j].value == "groupend") || (getObjid(makeform.sellist.options[j].value) == "GEND")) {
						endYN = "Y";
						nextval = j;
						break;
					}
					else endYN = "N";
				}
			}
			selvalue = nextval
		}
		else if (gbn == "end") {
			if ((grpval == "group") || (getObjid(grpval) == "GSTR")) {
				endYN = "Y";
				for (j=index; j>=0; j--) {
					if ((makeform.sellist.options[j].value == "group") || (getObjid(makeform.sellist.options[j].value) == "GSTR") && (j != index)) {
						startYN = "Y";
						beforeval = j;
						if (chkGroup(makeform.sellist.options[j].text) == chkGroup(makeform.sellist.options[index].text)) {break;}
					}
					else startYN = "N"
				}
			}
			selvalue = beforeval
		}
	}
	if ((startYN=="N") || (endYN=="N")) {
		if (startYN=="N") alert(chkGroup(makeform.sellist.options[index].text) + " 그룹의 시작위치가 틀렸습니다.")
		else if (endYN=="N") alert(chkGroup(makeform.sellist.options[index].text) + " 그룹의 끝위치가 틀렸습니다.")
	}
	else if (chkGroup(makeform.sellist.options[index].text) == chkGroup(makeform.sellist.options[selvalue].text))
		return(selvalue)
	else
		alert(chkGroup(makeform.sellist.options[index].text) + "그룹의 시작과 끝이 옳바르지 않습니다.\n그룹사이에는 다른그룹을 지정할 수 없습니다.")
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
 
function sellist_onclick() {

	var selind = makeform.sellist.selectedIndex
	
	var strAx = makeform.sellist.options[selind].value
	//alert(strAx);	//58|GCOM06
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
 
function CheckKey1(){
	if (event.keyCode == 13) {btncfm_onclick();return false}
}
function CheckKey2(){
	if (event.keyCode == 46) delAddList();
}
 
function load1(form) {
     var url = form.Llist_1.options[form.Llist_1.selectedIndex].value;
     if (url != '') location.href = url;
     return false;
}
 
// Item 선택후 위쪽 이동.
function upItem() {
    var tmpValue, tmpText
    var selectIndex = makeform.sellist.selectedIndex;
 
    if (selectIndex > 0) {
        tmpValue = makeform.sellist[selectIndex -1].value;
        tmpText  = makeform.sellist[selectIndex -1].text;
        makeform.sellist[selectIndex-1].value = makeform.sellist[selectIndex].value;
        makeform.sellist[selectIndex-1].text  = makeform.sellist[selectIndex].text;
        makeform.sellist[selectIndex].value   = tmpValue;
        makeform.sellist[selectIndex].text    = tmpText;
 
        makeform.sellist.selectedIndex        = selectIndex-1;
    }
}
 
// Item 선택후 아래쪽 이동.
function downItem() {
    var tmpValue, tmpText
    var selectIndex = makeform.sellist.selectedIndex;
 
    if (selectIndex < (makeform.sellist.length - 1)  && selectIndex != -1) {
        tmpValue = makeform.sellist[selectIndex +1].value;
        tmpText  = makeform.sellist[selectIndex +1].text;
        makeform.sellist[selectIndex+1].value = makeform.sellist[selectIndex].value;
        makeform.sellist[selectIndex+1].text  = makeform.sellist[selectIndex].text;
        makeform.sellist[selectIndex].value   = tmpValue;
        makeform.sellist[selectIndex].text    = tmpText;
 
        makeform.sellist.selectedIndex        = selectIndex+1;
    }
}
 
// 메뉴설명 byte 체크
function chkDescription(){
	//CheckStrLen(document.makeform.mncontents.value, 140, '메뉴설명');
	document.makeform.chkByte.value = (document.makeform.mncontents.value).length;
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
 
function View_Layer(index) {
	if (index == 0) {
		makeform.all['menu_normal'].style.display="";
		makeform.all['menu_select'].style.display="none";
	} else {
		makeform.all['menu_normal'].style.display="none";
		makeform.all['menu_select'].style.display="";
	}
}
 
function edit_attr2(no, num)
{ 
		insert_form_x.xno.value = no;

		var sel_r = eval( "document.insert_form_a.grant_read_"+num+".value");
		var sel_w = eval( "document.insert_form_a.grant_write_"+num+".value");
		var sel_m = eval( "document.insert_form_a.grant_memo_"+num+".value");
		var sel_s = eval( "document.insert_form_a.skin_type_"+num+".value");
		insert_form_x.xread.value = sel_r;
		insert_form_x.xwrite.value = sel_w;
		insert_form_x.xmemo.value = sel_m;
		insert_form_x.xskin.value = sel_s;

		insert_form_x.action='board_create_pop_ok.php';
		//var res = confirm(" Do you want to process bulletin board properties? \n 게시판 속성을 변경하시겠습니까?\n[주의] 변경합니다. ");
		var res = confirm(" Are you sure you want to change the bulletin board properties? ");
		if (res) { insert_form_x.submit(); }
}
function edit_attr3(no, num)
{ 
		insert_form_x.no.value = no;

		/*var sel_r = eval( "document.insert_form_a.grant_read_"+num+".value");
		var sel_w = eval( "document.insert_form_a.grant_write_"+num+".value");
		var sel_m = eval( "document.insert_form_a.grant_memo_"+num+".value");
		var sel_s = eval( "document.insert_form_a.skin_type_"+num+".value");
		insert_form_x.xread.value = sel_r;
		insert_form_x.xwrite.value = sel_w;
		insert_form_x.xmemo.value = sel_m;
		insert_form_x.xskin.value = sel_s;*/

		insert_form_x.action='update.php';
		insert_form_x.target='_blank';
		//var res = confirm(" Do you want to process bulletin board properties?");
		//if (res) { insert_form_x.submit(); }
		insert_form_x.submit();
}
/*
function edit_menu()
{
	//var selStr = makeform.sellist
	var chgStr = makeform.chgname.value
	

	if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0){
		alert('허용이 안 되는 특수문자를 사용하셨습니다.\n다시 입력하시기 바랍니다.~')
		return ;
	}
	
	if(makeform.sellist.options.length > 0) {
		for(var i = 0; i < makeform.sellist.options.length; i++)
		{
			makeform.club_menu.value += makeform.sellist.options[i].value + makeform.sellist.options[i].text + "!,";
		}
	} else {
		alert('메뉴를 선택해 주십시오.');
		return;
	}
 
	var res = confirm("클럽 메뉴을 처리하시겠습니까?\n[주의] 등록 또는 변경합니다. ");
	if (res) {
		makeform.submit();
	}
}

function Add2ListXXX() {
	
   var optStr, newOpt, tstr, newOpt2
   if ( makeform.fnclist.selectedIndex < 0){
		alert (" Please select a board type.");return;
	}
   if ( makeform.aboard_name.value==""){
		alert (" Please enter your board name! ");
		makeform.aboard_name.focus();
		return;
	}
	if (!confirm("Create a bulletin board?")) return
	
	var seli = makeform.fnclist.selectedIndex;
	v=makeform.fnclist.options[seli].value;
	t=makeform.fnclist.options[seli].text;
	//	alert('seli:'+seli+' , v:'+v +' ,t:'+t); return false;
	//seli:0 , v:TCOM01!:0!:4!,4!,4!,7!,7!,0!,X!, ,t:General Type
	//seli:2 , v:GCOM03!:0!:3!,3!,3!,7!,7!,0!,X!, ,t:Memo Type
	
	for (var k=0 ; k < makeform.fnclist.options.length ; k++)
	{
		if ( makeform.fnclist.options[k] != "" && makeform.fnclist.options[k].selected && !makeform.fnclist.options[k].disabled) {
    		// '[통합] 통합게시판' 에서 fnm='통합게시판' 을 넣는다.
    		var fnm = makeform.fnclist.options[k].text.substr( makeform.fnclist.options[k].text.indexOf("]")+2);
    		var fnm2 = makeform.fnclist.options[k].text.substr( makeform.fnclist.options[k].text.indexOf("]")+1);
//			alert('fnm:'+fnm +'fnm2:'+fnm2); //return false;
			//fnm:tandard Typefnm2:Standard Type

		   if (fnm.indexOf("*")>=0) {
				makeform.fnclist.options[k].disabled=true
				fnm = fnm.substring(0,fnm.length-1)
			}
 
			if ( makeform.fnclist.options[k].value == "group") {
				newOpt = document.createElement("OPTION");
				tstr = chkname( fnm );
				frealname = "["+fnm+"]";

				newOpt.text = "-----" + frealname + " 시작-----"
				newOpt.value = makeform.fnclist.options[k].value

				makeform.sellist.add( newOpt )
				makeform.sellist.selectedIndex = makeform.sellist.options.length-1
 
				newOpt2 = document.createElement("OPTION")
				newOpt2.text = "-----" + frealname + " 끝-------"
				newOpt2.value = "groupend"				 //makeform.fnclist.options[k].value

				makeform.sellist.add(newOpt2)
				makeform.sellist.selectedIndex = makeform.sellist.options.length-1

				makeform.chgname.value = tstr

				//makeform.board_gubun_value.value = newOpt.value
				//makeform.board_gubun_value.value = frealname
				//makeform.board_gubun_text.value = textx
			}
			else {
 
				if (makeform.sellist.length > 50) {
					//alert ("기능은 50개까지만 선택할 수 있습니다.");return;
				}
 
				newOpt = document.createElement("OPTION")

				tstr = chkname( fnm );
			
//			alert('k:'+k + ' , : ' + newOpt.value+' , tstr:'+tstr+' , fnm:'+fnm); return false;
			//
			
				//<option value="GCOM01!:0!:4!,4!,4!,7!,7!,0!,X!,">[통합] 공지사항* </option>
				//	[공지사항*] 공지사항
				frealname = "["+fnm+"]"
				newOpt.text = frealname+" "+tstr

				newOpt.value = makeform.fnclist.options[k].value

				makeform.sellist.add(newOpt)
				makeform.sellist.selectedIndex = makeform.sellist.options.length-1

				makeform.chgname.value = tstr
				makeform.sellist_index.value = k
					
//				makeform.board_gubun_value.value = newOpt.value
//alert('k:'+k + ' , : ' + newOpt.value);
				document.makeform.new_insert.value = "create_first";	// 추가버턴.
				document.makeform.insert.value = "no";
				makeform.submit();
			}
		}
	}
	isEdited = true;
}
*/
function Add2List() {
	
   var optStr, newOpt, tstr, newOpt2
   if ( makeform.fnclist.selectedIndex < 0){
		alert (" Please select a board type.");return;
	}
   if ( makeform.aboard_name.value==""){
		alert (" Please enter your board name! ");
		makeform.aboard_name.focus();
		return;
	} else {
		var chgStr = makeform.aboard_name.value
		if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0){
	//		alert('You used a special character that is not allowed. \n 허용이 안 되는 특수문자를 사용하셨습니다.\n 다시 입력하시기 바랍니다.~')
			alert('You used a special character that is not allowed. ')
			return ;
		}
		sellist_i = makeform.sellist.options.length;
		//alert("sellist_i:"+sellist_i);//sellist_i:12
		for (i=0;i<makeform.sellist.options.length;i++){
			bnm = makeform.sellist.options[i].text;
				//alert("make nm:"+chgStr+ " , sellist_nm:"+bnm);
			if (chgStr == bnm){
				alert("It is an existing name. "+"\n"+ " Please change your name.")
//				alert("이미 존재하는 이름입니다."+"\n"+ "이름을 변경한 후 사용하십시오.")
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
/////////   적용버턴   ///////////////////////////////////////////////////////////////////////////////////
function edit_menu_multy()
{
	//var selStr = makeform.sellist
	var chgStr = makeform.chgname.value
	

	if (chgStr.indexOf('"')>=0 || chgStr.indexOf("'")>=0 || chgStr.indexOf("!#")>=0 || chgStr.indexOf("!%")>=0 || chgStr.indexOf("!:")>=0 || chgStr.indexOf("!,")>=0 || chgStr.indexOf("[")>=0 || chgStr.indexOf("]")>=0 || chgStr.indexOf("<")>=0 || chgStr.indexOf(">")>=0){
//		alert('You used a special character that is not allowed. \n 허용이 안 되는 특수문자를 사용하셨습니다.\n 다시 입력하시기 바랍니다.~')
		alert('You used a special character that is not allowed. ')
		return ;
	}
	
	if(makeform.sellist.options.length > 0) {
		for(var i = 0; i < makeform.sellist.options.length; i++)
		{
			makeform.club_menu.value += makeform.sellist.options[i].value + makeform.sellist.options[i].text + "!,";
		}
	} else {
		alert('Please select a board. ');
		return;
	}
 
	var res = confirm(" Do you want to process the Board Title Change. ");
	if (res) {
		var str_array = '';
		for(var i = 0; i < makeform.sellist.options.length; i++)
		{
			//makeform.club_menu.value += makeform.sellist.options[i].value + makeform.sellist.options[i].text + "!,";
			var str_val = makeform.sellist.options[i].value;

			//var str_txt = makeform.sellist.options[i].text;
			var str_txt = makeform.sellist.options[i].text.substr( makeform.sellist.options[i].text.indexOf("]")+2);
//			var str_txt = makeform.sellist.options[i].text.substr( makeform.sellist.options[i].text.indexOf("]")+1);

		   if (str_txt.indexOf("*")>=0) {
				//makeform.sellist.options[k].disabled=true
				str_txt = str_txt.substring(0,str_txt.length-1);
			}

//			str_array += str_val + '|' + str_txt + '|' + i + '||' 
			str_array += str_val + '|' + str_txt + '|' + i + ':';
			// sel : 113|GCOM02!|113|0:117|GCOM04!|117|1:118|GCOM04!|118|2:119|GCOM03!|119|3:120|TCOM01!|120|4:121|TCOM01!|121|5:116|GCOM01!|116|6:112|GCOM03!|112|7:115|GCOM04!|115|8:58|GCOM01!|58|9: 
		}
		//alert(' str_array= ' + str_array); return false;
		//메뉴를 선택해 주십시오. str_array= 113|GCOM06!|113|0:112|GCOM06!|112|1:115|GCOM06!|115|2:58|GCOM06|게시판3|3:
		document.makeform.multy_menu_sel.value = str_array;
		document.makeform.new_insert.value = "create_multy";	//적용버턴.
		document.makeform.insert.value = "no";
		makeform.submit();
	}
}


function grant_menu()
{
	var read_grant = "";
	var write_grant = "";
	var menu_intro = "";
 
	var right = 0;
 
	for(var i = 0; i < grantform.elements.length; i++)
	{
		if (grantform.elements[i].name == 'read_grant')
		{
			read_grant = read_grant + grantform.elements[i].value + ";";
		}
	}
 
	for(var i = 0; i < grantform.elements.length; i++)
	{
		if (grantform.elements[i].name == 'write_grant')
		{
			write_grant = write_grant + grantform.elements[i].value + ";";
		}
	}
 
	for(var i = 0; i < grantform.elements.length; i++)
	{
		if (grantform.elements[i].name == 'menu_intro')
		{
			menu_intro = menu_intro + grantform.elements[i].value + ";";
		}
	}
 
	grantform.read_grant2.value = read_grant;
	grantform.write_grant2.value = write_grant;
	grantform.menu_intro2.value = menu_intro;
 
	var res = confirm("클럽 메뉴 권한을 변경하시겠습니까?");
	if (res) {
		grantform.submit();
	}
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
//-->
</script>
<?php
$cur='B';
include "../menu_run.php";
$doc=$H_ID . time();
?>
<!--
<table width="800" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><br><br>User Board Management</td>
  </tr>
  
</table>-->
<p><?=$H_NICK?>:Manage your bulletin board : <?=$H_LEV?> </p>
<div id='menu_normal'>
   <table cellspacing='0' cellpadding='4' width='600' border='0' class="c1">
<!-- FORM 시작 -->
		<form name="makeform" method="post" action="board_create_pop_ok.php">
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
									   

            <!--<tr>
               <td align="center">&nbsp;</td>
            </tr>-->
			<tr>
               <td width="72%" valign="top" align="center">
                  <div id='menu_normal'>
                    <table width="80%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                           <td valign="top" align="right" width="200">
                             <table cellspacing="0" cellpadding="0" width="200" border="0">
                                <tr>
                                  <td bgcolor="#666666" height="30" align="center" title=' Please select the type of board to be created! '>
									<font color="#FFFFFF"><b>Type of board to add</b></font>
								  </td>
                                </tr>
                                <tr>
                                  <td valign="top" align="left" bgcolor="#f5f5f5">
								  
                                     <select id="fnclist" style="WIDTH: 200px" onChange="fnclist_onclick(this.value)" multiple size="8" name="fnclist">
                                          <!-- <option value="TCOM01!0!4!,4!,4!,7!,7!,0!,X!,"> General Type </option> -->
                                          <option value="GCOM02!0!4!,4!,6!,7!,7!,0!,X!,"> Standard Type </option>
                                          <option value="GCOM03!0!3!,3!,3!,7!,7!,0!,X!,"> Memo Type </option>
                                          <option value="GCOM04!0!0!,4!,6!,7!,7!,0!,X!,"> Image Type </option>
									  </select>
                                   </td>
                                 </tr>
                                 <tr>
                                    <td height="24">Board Title:<input id='aboard_name' maxlength=70 size=20 name='aboard_name' ></td>
                                 </tr>
                             </table>
                           </td>
						   
                            <!-- ADD  -->
                           <td align="center">
                              <table cellspacing="0" cellpadding="0" width="100" align="center" border="0">
                                <tr>
                                  <td align="middle">
									 <input type='button' value='ADD->' onclick="javascript:Add2List()" title=' Create a bulletin board. Please select the type of bulletin board left! '>
                                  </td>
                                </tr>
                             </table>
                            </td>
                            <td valign="top" align="right" width="220">
                                <table cellspacing="0" cellpadding="0" width="200" border="0">
                                  <tr>
                                    <td bgcolor="#666666" height="30" align="center">
										<font color="#FFFFFF" class="c1"><b>Board List</b></font></td></tr>
                                  <tr>
                                     <td valign="top">

                             <select id="sellist" style="WIDTH: 200px" onChange="sellist_onclick()" name="sellist" size='10'>

<?php
//	$sql = "SELECT * from {$tkher['aboard_infor_table']} order by sunbun asc";
	$where_ = " where make_id='" . $H_ID. "' " ;
	$sql = "SELECT * from {$tkher['aboard_infor_table']} " . $where_ . " order by in_date desc";
	$result = sql_query($sql);
	$aaa = 0;
	while($rsP = sql_fetch_array($result)) {
?>
		<option value='<?=$rsP['no']?>|<?=$rsP[home_url]?>'><?=$rsP[name]?></option>
<?php
	}
?>
                                       </select>

                                       <input type='hidden' size='70' name='board_gubun_text' value='<?=$home_url?>'>

									</td>
								  </tr>
<script> 
	init();
</script>
                                  <tr>
                                    <td height="24">Change Board Title<br>
                                       
									   <input class=boxstyle id='chgname' onKeyDown=CheckKey1(); onBlur=btncfm_onclick() maxlength=70 size=20 name='chgname' >
									   
									   <input type='button' value="Change" onClick="update_title()" style="cursor:hand;" title='Change the board name.'>
									   
									 

                                       <input id=mnhide onBlur=btncfm_onclick() type=checkbox align=absMiddle name=mnhide style="display:none; border:0;">
                                       <textarea id=mncontents onKeyUp=chkDescription() name=mncontents rows=3 cols=60 onChange=chkDescription() style="display:none;"></textarea>
                                       <input id=chkByte readOnly size=4 value=0 name=chkByte style="display:none;">
									   
                                     </td>
                                   </tr>
                            </table>
                          </td>
                         </tr>
                       </table>
                       </div>
                      </td>
                     </tr>
					 <!--
					<tr>
                      <td align="center" height="100">
					  <img src="./images/bt_register2.gif" border="0" onClick="edit_menu_multy()" style="cursor:hand;"> 
					  <input type='button' value="Confirm" onClick="edit_menu_multy()" style="cursor:hand;" title='Bulletin board titles are changed in a batch.'>
					  </td>
                    </tr>-->
		</form>
	</table>

	
	<form name='insert_form_x'  method="post" action="board_create_pop_ok.php">
          <input type='hidden' name='xupdate'	value='update_func'>
          <input type='hidden' name='xno'		value=''>
          <input type='hidden' name='no'		value=''>
          <input type='hidden' name='xread'		value=''>
          <input type='hidden' name='xwrite'	value=''>
          <input type='hidden' name='xmemo'		value=''>
          <input type='hidden' name='xskin'		value=''>
	</form>
<!-- <table width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	-->
	<table width="100%" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">

      <tr>
<?php if ($H_LEV > 7 ) { ?>
        <td width="5%" height="28" align="center" bgcolor="#EEEEEE"><strong>user</strong></td>
<?php } else {  ?>
        <td width="3%" height="28" align="center" bgcolor="#EEEEEE"><strong>no</strong></td>
<?php } ?>

        <td width="3%" height="28" align="center" bgcolor="#EEEEEE"><strong>infor</strong></td>
        <td width="12%" height="28" align="center" bgcolor="#EEEEEE"><strong>Board Name</strong></td>
        <td width="3%" height="28" align="center" bgcolor="#EEEEEE"><strong>data</strong></td>
        <td width="3%" height="28" align="center" bgcolor="#EEEEEE" title='upload file size'><strong>file size</strong></td>
        <td width="10%" align="center" bgcolor="#EEEEEE"><strong>Skin Type</strong></td>
        <td width="5%" align="center" bgcolor="#EEEEEE"><strong>Read permission</strong></td>
        <td width="5%" align="center" bgcolor="#EEEEEE"><strong>Write permission</strong></td>
        <td width="15%" align="center" bgcolor="#EEEEEE"><strong>Memo</strong></td>
        <td width="15%" align="center" bgcolor="#EEEEEE"><strong>Change</strong></td>
      </tr>

	<form name='insert_form_a'  method="post" action="board_create_pop_ok.php?c_idxno=7777">
          <input type='hidden' name='xupdateX' 	value='5'>
          <input type='hidden' name='xnoX' 		value=''>
          <input type='hidden' name='updateX' 	value='menu'>
<?php
	$where_ = "where make_id='" . $H_ID. "' " ;
	if( $H_LEV > 7 ) $sql = "SELECT * from {$tkher['aboard_infor_table']} order by in_date desc";
	else $sql = "SELECT * from {$tkher['aboard_infor_table']} " . $where_ . " order by in_date desc";
	$result = sql_query($sql); 
	$aaa = 0;
	$line = 0;
	while( $rsP = sql_fetch_array($result)) {
		$line++;
		if ( $rsP['grant_view'] == "0" ) $levR='Guest';
		else if ( $rsP['grant_view'] == "1" ) $levR='Member';
		else if ( $rsP['grant_view'] == "2" ) $levR='Only Me';
		else if ( $rsP['grant_view'] == "3" ) $levR='System';
		else $levR = '???';

		if ( $rsP['grant_write'] == "0" ) $lev='Guest';
		else if ( $rsP['grant_write'] == "1" ) $lev='Member';
		else if ( $rsP['grant_write'] == "2" ) $lev='Only Me';
		else if ( $rsP['grant_write'] == "3" ) $lev='System';
		else $lev='???';

		/*if ( $rsP['movie'] == "1" ) 		$skin_='General Type';
		else */
		if ( $rsP['movie'] == "5" )	$skin_='Standard Type';
		else if ( $rsP['movie'] == "3" )	$skin_='Memo Type';
		else if ( $rsP['movie'] == "4" )	$skin_='Image Type';
		else $skin_='???';

		//		if ( $rsP['grant_view'] == "0" ) {
?>
			<!--<tr>
				<td colspan="5" align="center" bgcolor="#FFFFFF" height="28"><?=$rsP[name]?></td>
			</tr>-->
<?php
//		}	else {
	
	
			$query	= "SELECT * from aboard_" . $rsP['table_name'] . " "; 
			$mq1	= sql_query($query);
			$board_cnt = sql_num_rows($mq1);
	
?>
		  <tr>
<?php if ($H_LEV > 7 ) { ?>
			<td style='background-color:#FFFFFF' align=center><?=$line?> : <?=$rsP['make_id']?></td>
<?php } else {  ?>
			<td style='background-color:#FFFFFF' align=center><?=$line?></td>
<?php } ?>
			<td style='background-color:#FFFFFF' align=center><?=$rsP['no']?></td>
			<td width='10%' bgcolor="#FFFFFF" title='board no=<?=$rsP['no']?>:aboard_<?=$rsP['table_name']?>'>
				<a href="../menu/index_bbs.php?infor=<?=$rsP['no']?>" target='_blank'><?=$rsP['name']?></a></td>
			<td style='background-color:#FFFFFF' align=center><?=$board_cnt?></td>
			<td style='background-color:#FFFFFF' align=center title='upload file size:<?=$rsP[fileup]?>'><?=$rsP[fileup]?></td>
			<td bgcolor="#FFFFFF" align="center">
				<select name="skin_type_<?=$aaa?>">
					<option value="<?=$rsP['movie']?>" selected ><?=$skin_?></option>
					<!-- <option value="1" >General Type</option> -->
					<option value="5" >Standard Type</option>
					<option value="3" >Memo Type</option>
					<option value="4" >Image Type</option>
			  </select></td>
			<td bgcolor="#FFFFFF" align="center">
			<select name="grant_read_<?=$aaa?>">
				<option value="<?=$rsP[grant_read]?>" selected ><?=$levR?></option>
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
				<option value="<?=$rsP['grant_write']?>" selected ><?=$lev?></option>
				<option value="0" >Guest</option>
				<option value="1" >Member</option>
				<option value="2" >Only Me</option>
<?php if( $H_LEV > 7 ) {  ?>				
				<option value="3" >System</option>
<?php }  ?>				
			  </select>
			  <br>More than </td>
			<td bgcolor="#FFFFFF" align="center">
				<textarea name="grant_memo_<?=$aaa?>" class="input01" cols="30" rows="2"><?=$rsP['memo']?></textarea></td>
			<td bgcolor="#FFFFFF" align="center">
				<input type='button' value="Confirm" onClick="edit_attr2('<?=$rsP['no']?>','<?=$aaa?>')" style="cursor:hand;" title='Save the skin and read and write permissions.'>
				<input type='button' value="Set" onClick="edit_attr3('<?=$rsP['no']?>','<?=$aaa?>')" style="cursor:hand;" title=' It makes detailed setting of bulletin board. '>
				<input type='button' value='Run' onclick="javascript:window.open('/contents/index.php?infor=<?=$rsP['no']?>','_blank','')" style="cursor:hand;" title=' Run the bulletin board. '>
			</td>
		  </tr>

<?php
		//}
		$aaa = $aaa +1;
	}	// while
?>
		  </form>
    </table>
<!--	
	</td>
  </tr>

</table>
-->
</body>
</html>
