<?php
	include_once('../tkher_start_necessary.php');
	/*
	  no use -
	  board_list3_update.php : board attribute set : Old ver 
	*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/_board_.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<link rel="stylesheet" href="../include/css/board.css" type="text/css">

<?php
	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	if( !$H_ID || $H_LEV < 2 ) {
		m_("Login Please!");
			$url='/';	//$PHP_SELF;
			echo("<meta http-equiv='refresh' content='0; URL=$url'>");
			exit;
	}

	//$infor = $_POST['infor'];
	//$list_no = $_POST['list_no'];
/*
	if( $_POST['infor'] ) {
		$no = $_POST['infor'];
		$infor = $_POST['infor'];
		$list_no = $_POST['list_no'];
	} else {
		$no = $_REQUEST['no'];
		$infor = $_REQUEST['no'];
	}*/

		if( isset($_REQUEST['infor']) ) $infor = $_REQUEST['infor'];
		else if( isset($_POST['infor']) ) $infor = $_POST['infor'];
		else $infor = '';
	//m_("infor:$infor, list_no:" . $_POST[list_no]);

	$query = "SELECT * from {$tkher['aboard_infor_table']} where no=$infor";
	$mq =sql_query( $query ); //	$mf=sql_fetch_array($mq);
	$mf =sql_fetch_row($mq);  //include "../inc/admin_login.php";
	$mf_1 = $mf[1]; // board name
		$list_no = $mf[0];
	//m_( $no . ", list_no:$list_no, $mf_1" . ", mf[48]: " . $mf[48]); //1, list_no:1, 개시판A, mf[48]: 5
/*
1 no, 2 name, 3 table_name, 4 fileup, 5 in_date, 6 memo_gubun, 7 ip_gubun, 8 html_gubun, 9 imember, 10 home_url, 
11 table_width, 12 list_table_set, 13 list_title_bgcolor, 14 list_title_font, 15 list_text_bgcolor, 16 list_text_font, 
17 list_size, 18 detail_table_set, 19 detail_title_bgcolor, 20 detail_title_font, 21 detail_text_bgcolor, 
22 detail_text_font, 23 detail_memo_bgcolor, 24 detail_memo_font, 25 input_table_set, 26 input_title_bgcolor, 
27 input_title_font, 28 icon_home, 29 icon_prev, 30 icon_next, 31 icon_insert, 32 icon_update, 33 icon_delete, 
34 icon_reply, 35 icon_list, 36 icon_search_list, 37 icon_search, 38 icon_submit, 39 icon_new, 40 icon_list_reply, 
41 icon_memo, 42 icon_admin, 43 list_gubun, 44 connection_gubun, 45 top_html, 46 bottom_html, 47 grant_view, 
48 grant_write, 49 movie, 50 title_color, 51 title_text_color, 52 security, // 여기까지 프로그램에서 사용중.
53 lev, 54 make_id, 55 make_club, 56 sunbun, memo

*/

?> 
<script>
  var color = '81C131';
  var colorback = 'ffffff';
  var valid_color = /[0-9a-fA-F]{6}/;


function callColorPickerX(tmpx,tmpy, target)
{
//  var x = event.screenX;
 // var y = event.screenY;

  x = x + tmpx;
  y = y + tmpy;
  showColorPicker(x,y, target);
  return;
}

function callColorPicker(tmpx,tmpy, target)
{
//	alert('-- callColorPicker tmpx:'+tmpx+' , tmpy:'+tmpy+' , target:'+target);
//  var x = event.screenX;
 // var y = event.screenY;

  var x = 100;
  var y = 20;

	x = 100;//x + tmpx;
	y = 50;	//y + tmpy;
	showColorPicker(x,y, target);
	return;
}

function showColorPicker(x,y, target)
{

	//alert('-- showColorPicker tmpx:'+x+' , tmpy:'+y+' , target:'+target);

//	var Selcol = showModalDialog("palbas.htm","","font-family:Verdana; font-size:12; dialogWidth:202px; dialogHeight:162px; dialogLeft:" + x + "px; dialogTop:" + y + "px; status:no; help:no; scroll:no");
//	$pg = "palbas.htm?tg=" + target;
	$pg = "palbas.php?tg=" + target;
	var Selcol = window.open($pg,"","font-family:Verdana; font-size:12; dialogWidth:202px; dialogHeight:162px; dialogLeft:" + x + "px; dialogTop:" + y + "px; status:no; help:no; scroll:no");
	
	//alert(' - Selcol:'+Selcol);
/*  if("undefined" != typeof(Selcol) && Selcol != "")
  {
		eval(target+".style.backgroundColor = '"+Selcol+"'");
		eval("document.update_form."+target+".value = '"+Selcol+"'");
  }*/
		eval(target+".style.backgroundColor = '"+Selcol+"'");
  return;
}
function set_type(v){
	if(v=='2') update_form.home_url.value='GCOM02!';
	else if(v=='3') update_form.home_url.value='GCOM03!';
	else if(v=='4') update_form.home_url.value='GCOM04!';
	else update_form.home_url.value='GCOM02!';
	/*if(v=='1') update_form.home_url.value='TCOM01!';
	else if(v=='2') update_form.home_url.value='GCOM02!';
	else if(v=='3') update_form.home_url.value='GCOM03!';
	else if(v=='4') update_form.home_url.value='GCOM04!';
	else if(v=='5') update_form.home_url.value='GCOM05!';*/
}

function back_func(infor, list_no){
	//alert('infor:' +infor+', '+list_no);
	document.update_form.list_no=list_no;
	document.update_form.action='list1_detail.php';
	document.update_form.submit();
}
function run_funcA(infor){
	//alert('infor:' +infor );
	document.update_form.infor=infor;
	//document.update_form.list_no=list_no;
	//document.update_form.target='_top';
	document.update_form.action='./index_bbs.php?infor='+infor;
	document.update_form.submit();
}

</script>

</head>

<body>
<?php
$cur='B';
include "../menu_run.php";
?>

<form name='update_form' method="POST" action='board_list3_update_query_ok.php' enctype="multipart/form-data" ><!-- /contents/query_ok.php -->
	<input type='hidden' name='table_name' value='<?=$mf[2]?>' >
	<input type="hidden" name="home_url" size="57" value='<?=$mf[9]?>'> 

	<input type='hidden' name='no' value='<?=$infor?>' >
	<input type='hidden' name='list_no' value='<?=$list_no?>' >
	<input type='hidden' name='infor' value='<?=$infor?>' >
  
  <!--<table ALIGN='center' border="0" width="637" height="1342" bgcolor="#F6F6F6" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0">-->
  
  <table ALIGN='center' border="0" width="637" bgcolor="#F6F6F6" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0">
    <tr>
      <td width="637" height="12" bgcolor="#FFFFFF" colspan="3">
        <table border="0" width="637" cellspacing="0" height="10" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0">
          <tr>
            <td width="3%" bgcolor="#FF9900" height="7">　</td>
            <td width="97%" bgcolor="#FFFFFF" height="7"><b>&nbsp;K-APP : Board attribute set</b></td> 
          </tr>
        </table>
        </td> 
    </tr>
    <tr>
      <td width="637" height="12" bgcolor="#FFFFFF" colspan="3">
      　</td>     
    </tr>
	<!--
    <tr>
      <td width="637" height="15" colspan="3" bgcolor="#FFFFFF">&nbsp;* 
      <font color="#006699">
      Create a skin [스킨만들기] :</font> 
	  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You can save the current bulletin board settings as a skin.
	  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;현재의 게시판 설정을 스킨으로 저장 하실수 있습니다.</td>
    </tr>
	 
    <tr>
      <td width="637" height="15" colspan="3" bgcolor="#FFFFFF">&nbsp;<font color="#FFFFFF">* 
      스킨만들기 : </font>스킨에 관련된 아이콘이나 이미지 파일은 <b> <font color="#FF6633">&quot;/aboard/skin/img/스킨명/&quot;</font>
      </b>디렉토리를 만드셔서</td>
    </tr>
    <tr>
      <td width="637" height="15" colspan="3" bgcolor="#FFFFFF">&nbsp;<font color="#FFFFFF">* 
      스킨만들기 : </font>넣어주시면 편하게 관리하실수 있습니다.</td>
    </tr>
	 
    <tr>
      <td width="637" height="15" colspan="3" bgcolor="#FFFFFF">&nbsp;*
      <font color="#006699">Applying Skins [스킨 적용] :</font> 
	  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Call up the skins and register them as bulletin board settings.
	  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;스킨을 불러와 게시판 설정으로 등록합니다.
	  </td>
    </tr> 
	
    <tr>
      <td width="637" height="4" colspan="3" bgcolor="#FFFFFF">　</td>
    </tr>
    <tr>
      <td width="637" height="4" colspan="3">　</td>
    </tr>-->
    <tr>
      <td width="29" height="1">　</td>
      <td width="572" height="1">

       <fieldset style="padding: 2; width:569; height:120">
        <legend><font color="#006699">< Basic settings ></font></legend>
          <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" bgcolor="#FFFFFF">
            <tr>
              <td width="23%" bgcolor="#F6F6F6" align="center">Table Name</td>
              <td width="77%" bgcolor="#66ffff">
				<a href='index_bbs.php?infor=<?=$mf[0]?>' target='_BLANK'><b><?=$mf[2]?> -> <font color=blue > Click Run</font></b></a></td>
            </tr>
             <tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">Board Name</td>
              <td width="81%" bgcolor="#FFFBEF"><input type="text" name="name" size="43" value='<?=$mf[1]?>'></td>
            </tr>

            <tr>
              <td width="29%" bgcolor="#F6F6F6" align="center" height="18">Board type</td><!-- 48:movie -->
              <td width="81%" bgcolor="#F6F6F6" height="18">
				  <select name='movie' onchange='set_type(this.value)'>
				  <!-- <option value='1' <?php if($mf[48] == "1") echo "selected"; ?>>general type</option> -->
				  <option value='2' <?php if($mf[48] == "2") echo "selected"; ?>>standard type</option>
				  <option value='3' <?php if($mf[48] == "3") echo "selected"; ?>>memo type</option>
				  <option value='4' <?php if($mf[48] == "4") echo "selected"; ?>>Image type</option>
				  <!-- <option value='5' <?php if($mf[48] == "5") echo "selected"; ?>>Daum type</option> -->
				  </select></td>
            </tr>

<?php
	if( $mf[3] > 0 ){
		$check_yes="checked";
		$check_no="";
		$up_filesize=$mf[3];
	}else{
		$check_yes="";
		$check_no="checked";
		$up_filesize=0;
	}
?>
            <!-- <tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">Attached file</td>
              <td width="81%" bgcolor="#FFFBEF">
				<input type="radio" value="1" name="fileup" <?=$check_yes?>> use&nbsp;
				<input type="radio" name="fileup" value="0" <?=$check_no?>> no use
				</td>
            </tr> -->
<?php //if( $mf[3] > 0 ){ ?>
            <tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">Attached file size</td>
              <td width="81%" bgcolor="#FFFBEF">
				<input type='text' name='upfilesize' value='<?=$up_filesize?>' size=1 > M
			  </td>
            </tr>
<?php //} ?>
<?php
	if($mf[5]){
		$check_yes="checked";
		$check_no="";
	}else{
		$check_yes="";
		$check_no="checked";
	}
?>
            <!-- <tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">Memo support</td>
              <td width="81%" bgcolor="#FFFBEF"><input type="radio" value="1" name="memo_gubun" <?=$check_yes?>> 
              use&nbsp; <input type="radio" value="0" name="memo_gubun" <?=$check_no?>> 
              no use</td>
            </tr> -->
			
<?php $check_yes="";$check_no="";?>
<?php
	if( $mf[6] ){ $check_yes="checked"; } else { $check_no="checked"; }
?>
            <!-- <tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">Show ip</td>
              <td width="81%" bgcolor="#FFFBEF"><input type="radio" value="1" name="ip_gubun" <?=$check_yes?>> use&nbsp;
              <input type="radio" value="0" name="ip_gubun" <?=$check_no?>> no use</td>
            </tr> -->
<?php $check_yes="";$check_no="";?>
<?php if( $mf[7]){ $check_yes="checked"; }else{ $check_no="checked";}?>
	<input type="hidden" value="0" name="html_gubun" > 
            <!--<tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">HTML Use</td>
              <td width="81%" bgcolor="#FFFBEF"><input type="radio" value="1" name="html_gubun" <?=$check_yes?>> 
              use&nbsp; <input type="radio" value="0" name="html_gubun" <?=$check_no?>> 
              no use</td>
            </tr>-->
<?php $check_yes="";$check_no="";?>
<?php if($mf[8]){ $check_yes="checked"; }else{ $check_no="checked";}?>
<!--
            <tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">i-Member연동</td>
              <td width="81%" bgcolor="#FFFBEF"><input type="radio" value="1" name="imember" <?=$check_yes?>> 연동함&nbsp;
              <input type="radio" value="0" name="imember" <?=$check_no?>> 연동안함 </td>
            </tr>
			-->
<?php $check_yes="";$check_no="";?>
<?php if($mf[42]){ $check_yes="checked"; }else{ $check_no="checked";}?>
          <!-- <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">List of Posts</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="radio" value="1" name="list_gubun" <?=$check_yes?>> Print&nbsp;
            <input type="radio" value="0" name="list_gubun" <?=$check_no?>> No Print</td>
          </tr> -->
<?php $check_yes="";$check_no="";?>
<?php if($mf[43]){$check_yes="checked";}else{$check_no="checked";}?>
          <!-- <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center" title='Print the comment.'>Related posts</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="radio" value="1" name="connection_gubun" <?=$check_yes?>> print&nbsp;
            <input type="radio" value="0" name="connection_gubun" <?=$check_no?>> no print</td>
          </tr> -->
<?php $check_yes="";$check_no="";?>
          </table>
          </fieldset>
      </td>
	  
      <td width="36" height="1">　</td>
    </tr>
	
	
    <tr>
      <td width="29" height="1">　</td>
      <td width="572" height="1">
      <fieldset style="padding: 2">
        <legend><font color="#006699">< authority ></font></legend>
        <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" bgcolor="#FFFFFF">
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center" >Read</td>
            <td width="81%" bgcolor="#FFFBEF">
            <select name="grant_view">				
<?php
			if( $mf[46] == '1' ) 	$vR = "Guest";
			else if ($mf[46] == '2' ) $vR = "Member";
			else if ($mf[46] == '3' ) $vR = "My";
			else if ($mf[46] == '8' ) $vR = "System Admin";
			else $vR = "Guest";
		  
?>	  
				<option value='<?=$mf[46]?>' selected ><?=$vR?></option>
				<option value='1'>Guest All</option>
				<option value='2'>Member</option>
				<option value='3'>Only Me</option>
<?php if( $H_LEV > 7) { ?>				
				<option value='8'>System Manager</option>
<?php } ?>				
				
			</select></td>
          </tr>
<?php
			if( $mf[47] == '1' ) 	$vW = "Guest";
			else if ($mf[47] == '2' ) $vW="Member";
			else if ($mf[47] == '3' ) $vW="My";
			else if ($mf[47] == '8' ) $vW="System Admin";
			else $vW = "Guest";
?>	  
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Write</td>
            <td width="81%" bgcolor="#FFFBEF">
            <select name="grant_write">			
				<option value='<?=$mf[47]?>' selected ><?=$vW?></option>
				<option value='1' >Guest All</option>
				<option value='2' >Member</option>
				<option value='3' >Only Me</option>
<?php if( $H_LEV > 7) { ?>				
				<option value='8' >System Manager</option>
<?php } ?>				
			</select></td>
          </tr>
			<tr>
              <td width="29%" bgcolor="#F6F6F6" align="center">Assign administrator</td>
              <td width="81%" bgcolor="#FFFBEF">
				<input type="text" value="<?=$mf[8]?>" name="imember" readonly>
				<!-- <input type=button value='Select' class=input onclick="window.open('admin_select.php', '', 'left=300, top=100, width=300, height=300, scrollbars=yes')"> Assign administrator.  --></td>
            </tr>
        </table>
      </fieldset></td>
      <!--<td width="36" height="148">　</td>-->
    </tr>
	
<?php if($mf[9] =='TCOM01!') { ?>	
    <tr>
      <td width="29" height="148">　</td>
      <td width="572" height="148">
      <fieldset style="padding: 2">
        <legend><font color="#006699">< List screen > : [general type only]</font></legend>
        <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" bgcolor="#FFFFFF">
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center" >Table properties</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="list_table_set" size="57" value="<?=$mf[11]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Title Background Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="title_color" size="12" value="<?=$mf[49]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(100, -190, 'title_color');">
					<tr><td id=title_color STYLE='background-color:<?=$mf[49]?>; height:18px; width:40'>
						<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR>
						</TABLE></td>
					<td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
						<IMG SRC='images/btn_down.gif'></td>
					</tr>
				</table>
			</TD></TR></TABLE>
			</td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Title Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<table><TR><TD>
			<input type="text" name="title_text_color" size="12" value="<?=$mf[50]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'title_text_color');">
				<tr><td id=title_text_color STYLE='background-color:<?=$mf[50]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
			</td>
          </tr>
		  <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Subject background color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<table><TR><TD>
			<input type="text" name="list_title_bgcolor" size="12" value="<?=$mf[12]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'list_title_bgcolor');">
				<tr><td id=list_title_bgcolor STYLE='background-color:<?=$mf[12]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
			</td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Subject Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<table><TR><TD>
			<input type="text" name="list_title_font" size="12" value="<?=$mf[13]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'list_title_font');">
				<tr><td id=list_title_font STYLE='background-color:<?=$mf[13]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
			</td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">context background color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<table><TR><TD>
			<input type="text" name="list_text_bgcolor" size="12" value="<?=$mf[14]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'list_text_bgcolor');">
				<tr><td id=list_text_bgcolor STYLE='background-color:<?=$mf[14]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
			</td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Context Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<table><TR><TD>
			<input type="text" name="list_text_font" size="12" value="<?=$mf[15]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'list_text_font');">
				<tr><td id=list_text_font STYLE='background-color:<?=$mf[15]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
			</td>
          </tr>
        </table>
      </fieldset></td>
      <td width="36" height="148">　</td>
    </tr>	
	
    <tr>
      <td width="29" height="127">　</td>
      <td width="572" height="127">
      <fieldset style="padding: 2">
        <legend><font color="#006699">< Reading Screen > : [general type only]</font></legend>
        <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" bgcolor="#FFFFFF">
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Table Attribute</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="detail_table_set" size="57" value="<?=$mf[17]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Subject background color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="detail_title_bgcolor" size="12" value="<?=$mf[18]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'detail_title_bgcolor');">
				<tr><td id=detail_title_bgcolor STYLE='background-color:<?=$mf[18]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>			
            </td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Subject Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="detail_title_font" size="12" value="<?=$mf[19]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'detail_title_font');">
				<tr><td id=detail_title_font STYLE='background-color:<?=$mf[19]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>			
            </td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Context background-color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="detail_text_bgcolor" size="12" value="<?=$mf[20]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'detail_text_bgcolor');">
				<tr><td id=detail_text_bgcolor STYLE='background-color:<?=$mf[20]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
            </td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Context Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="detail_text_font" size="12" value="<?=$mf[21]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'detail_text_font');">
				<tr><td id=detail_text_font STYLE='background-color:<?=$mf[21]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>			
            </td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Memo background-color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="detail_memo_bgcolor" size="12" value="<?=$mf[22]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'detail_memo_bgcolor');">
				<tr><td id=detail_memo_bgcolor STYLE='background-color:<?=$mf[22]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
            </td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Memo Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="detail_memo_font" size="12" value="<?=$mf[23]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'detail_memo_font');">
				<tr><td id='detail_memo'_font STYLE='background-color:<?=$mf[23]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
            </td>
          </tr>
<!-- <?php if($mf[42]){$check_yes="checked";}else{$check_no="checked";}?>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">List of Posts</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="radio" value="1" name="list_gubun" <?=$check_yes?>> Print&nbsp;
            <input type="radio" value="0" name="list_gubun" <?=$check_no?>> No Print</td>
          </tr>
<?php $check_yes="";$check_no="";?>
<?php if($mf[43]){$check_yes="checked";}else{$check_no="checked";}?>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center" title='Print the comment.'>Related posts</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="radio" value="1" name="connection_gubun" <?=$check_yes?>> print&nbsp;
            <input type="radio" value="0" name="connection_gubun" <?=$check_no?>> no print</td>
          </tr>
<?php $check_yes="";$check_no="";?> -->
        </table>
      </fieldset></td>
      <td width="36" height="127">　</td>
    </tr>
    <tr>
      <td width="29" height="12">　</td>
      <td width="572" height="12">
      　</td>
      <td width="36" height="12">　</td>
    </tr>
	
    <tr>
      <td width="29" height="49">　</td>
      <td width="572" height="49">
      <fieldset style="padding: 2">
        <legend><font color="#006699">< Write Screen > : [general type only]</font></legend>
        <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2">
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Table attribute</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="input_table_set" size="57" value="<?=$mf[24]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Subject background-color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="input_title_bgcolor" size="12" value="<?=$mf[25]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'input_title_bgcolor');">
				<tr><td id=input_title_bgcolor STYLE='background-color:<?=$mf[25]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
			</td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Subject Color</td>
            <td width="81%" bgcolor="#FFFBEF">
			<TABLE><TR><TD>
			<input type="text" name="input_title_font" size="12" value="<?=$mf[26]?>">
			</TD><TD>
				<table border='0' cellpadding='0' cellspacing='0' STYLE='table-layout:fixed;border:1 solid #808080; height:18px'
				 onclick="javascript:callColorPicker(0, -190, 'input_title_font');">
				<tr><td id=input_title_font STYLE='background-color:<?=$mf[26]?>; height:18px; width:40'>
				<TABLE CELLPADDING='0' CELLSPACING='0' BORDER='0' WIDTH='100%' HEIGHT='100%' STYLE='border:1 solid #FFFFFF'><TR><TD></TD></TR></TABLE>
				</td><td ALIGN='center' STYLE='width:15px; height:18px; background-color:#FFFFFF; border-left:1 solid #808080;'>
				<IMG SRC='images/btn_down.gif'>
				</td></tr>
				</table>
			</TD></TR></TABLE>
            </td>
          </tr>
          </table>
      </fieldset></td>
      <td width="36" height="49">　</td>
    </tr>
    <tr>
      <td width="29" height="12">　</td>
      <td width="572" height="12">
      　</td>
      <td width="36" height="12">　</td>
    </tr>
	<!--
    <tr>
      <td width="29" height="184">　</td>
      <td width="572" height="184">
      <fieldset style="padding: 2">
        <legend><font color="#006699">< Icon ></font></legend>
        <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" bgcolor="#FFFFFF">
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Home</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_home" size="57" value="<?=$mf[27]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Previous</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_prev" size="57" value="<?=$mf[28]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Next</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_next" size="57" value="<?=$mf[29]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Write</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_insert" size="57" value="<?=$mf[30]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Update</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_update" size="57" value="<?=$mf[31]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Delete</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_delete" size="57" value="<?=$mf[32]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Reply</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_reply" size="57" value="<?=$mf[33]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">List</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_list" size="57" value="<?=$mf[34]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Search</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_search" size="57" value="<?=$mf[36]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Search List</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_search_list" size="57" value="<?=$mf[35]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Insert</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_submit" size="57" value="<?=$mf[37]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">New article</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_new" size="57" value="<?=$mf[38]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Reply</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_list_reply" size="57" value="<?=$mf[39]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Memo</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_memo" size="57" value="<?=$mf[40]?>"></td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" align="center">Admin</td>
            <td width="81%" bgcolor="#FFFBEF">
            <input type="text" name="icon_admin" size="57" value="<?=$mf[41]?>"></td>
          </tr>
        </table>
      </fieldset></td>
      <td width="36" height="184">　</td>
    </tr>
	-->
    <tr>
      <td width="29" height="4">　</td>
      <td width="572" height="4">
      　</td>
      <td width="36" height="4">　</td>
    </tr>
    <tr>
      <td width="29" height="4">　</td>
      <td width="572" height="4">
      * Board <font color="#006699">Please fill in the HTML code to be included at the top and bottom of the bulletin board.</font></td>
      <td width="36" height="4">　</td>
    </tr>
    <tr>
      <td width="29" height="4">　</td>
      <td width="572" height="4">
      　</td>
      <td width="36" height="4">　</td>
    </tr>
    <tr>
      <td width="29" height="288">　</td>
      <td width="572" height="288">
      <fieldset style="padding: 2">
        <legend><font color="#006699">< Head / Bottom ></font></legend>
        <table border="0" cellpadding="0" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber3" height="124" bgcolor="#FFFFFF">

          <tr>
            <td width="29%" bgcolor="#F6F6F6" height="1" align="center">Head</td>
            <td width="81%" height="1">
            <textarea rows="9" name="top_html" cols="72"><?=$mf[44]?></textarea>
            </td>
          </tr>
          <tr>
            <td width="29%" bgcolor="#F6F6F6" height="66" align="center">Bottom</td>
            <td width="81%" height="66">
            <textarea rows="9" name="bottom_html" cols="72"><?=$mf[45]?></textarea></td>
          </tr>
        </table>
      </fieldset></td>
      <td width="36" height="288">　</td>
    </tr>

<?php } ?>			  

    <tr>
      <td width="29" height="12">　</td>
      <td width="572" height="12">
      　</td>
      <td width="36" height="12">　</td>
    </tr>
    <tr>
      <td width="29" height="12">　</td>
      <td width="572" height="12">
		  <p align="center">
			  <!-- <input type='hidden' name='no' value='<?=$mf[0]?>' > -->
			  <input type='hidden' name='old_name' value='<?=$mf[1]?>' >
			  <input type='hidden' name='update' value=''>
			  <input type='hidden' name='mode' value='aboard_update'>
		  <input type='submit' value='Change'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <!-- <input type='button' value='back' onclick="back_func('<?=$infor?>','<?=$list_no?>')"> -->
		  <input type='button' value='Run' onclick="run_funcA('<?=$infor?>')">
      </td>
      <td width="36" height="12">　</td>
    </tr>
    <tr>
      <td width="637" height="12" bgcolor="#FFFFFF" colspan="3">
        　</td>
    </tr>
    <tr>
      <td width="637" height="1" bgcolor="#c0c0c0" colspan="3"></td>
    </tr>
    <tr>
      <td width="637" height="18" colspan="3" bgcolor="#FFFFFF">
　</td>
    </tr>
    <tr>
      <td width="637" height="67" colspan="3" bgcolor="#FFFFFF">

<p align="center"></td>
    </tr>
  </table>
  </form>
</body>

</html>