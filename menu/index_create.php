<?php
	include_once('../tkher_start_necessary.php');

	$H_ID  = get_session("ss_mb_id");	
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level']; //$H_LEV	= $member['mb_level'];
	else $H_LEV = 0;
	$ip    = $_SERVER['REMOTE_ADDR'];

	if( !$H_ID || $H_LEV < 2 ) {
		m_(" login please! ");
		echo "<script>window.open( './' , '_top', ''); </script>";
		exit;
	}
	/* sys_menu_bom ERROR sys_pg:solpakan@naver.com1712299750, tit:tree_first
		index_create.php 
		call : cratreebook_make_create_menu.php <- cratreebook_make_menu.php
		run : cratreebook_make_create_menu.php : note tree create.
		menu list : index.php <- cratree_my_list_menu.php
	*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang, Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="../logo/logo25a.jpg">
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> 
<meta name='keywords' content='appgenerator, tee menu, app generator, app make, app maker, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> 
<meta name='description' content='appgenerator, tee menu, app generator, app make, app maker, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> 

<meta name="robots" content="ALL">

<style>  
.HeadTitle01AX{display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;font-size:22px;background:#d01c27;color:#fff;border-radius:5px;}  

.HeadTitle01AX a.on{background:#d01c27;color:#000;}  
</style>  
<!-- 

<style>  
body, td, TEXTAREA { font-size: 12pt}
INPUT, select { font-size: 12pt; height:21pt}
a 		{text-decoration:none; color:#000000; }
a:hover 	{text-decoration:underline; color:7B90FA; }

.en tr 		td.na		{ font-size: 12pt}
.en tr 		td.img		{ font-size: 12pt;}
.en tr 		td.img img	{ border:#7B90FA 1px solid;}
.en tr 		td		{ font-size: 12pt}

* {  box-sizing: border-box;}  
.header2A {width:100%;  height:50px;  float: left;  border: 0px solid red;  padding: 0px;}  
.menu1Area{width:100%;  height:60px;  float: left;  padding: 0px;  border: 0px solid #DEDEDE;  background-color:#FAFAFA;}  
.menu2T{padding-top:3px; width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FAFAFA;}  
.menu2A {width:25%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE; background-color:#FAFAFA;} 
.data2A {width:25%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}  
.input1A { padding:0px;}  
.mainA {width:100%;  float: left; padding:15px; border:1px solid red;}  
.menu1T {padding-top:0px; width:<?=$menu1TWPer?>%; height:30px; float:left; padding:6px; border:1px solid #DEDEDE;background-color:#FAFAFA;}  
.menu1A {width:<?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 0px;}  
.data1A {width:<?=$menu1AWPer?>%; height:30px; float:left;padding:6px;border:1px solid #DEDEDE; background-color:#FFFFFF;}  
radio1A {width:<?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 6px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}  
.ListBox1A {width: <?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE; background-color:#FFFFFF;}  
.File1A {  width: <?=$menu1AWPer?>%;  height:30px;  float: left;  padding: 2px;  border: 1px solid #DEDEDE;background-color:#FFFFFF;}  
.menu4T {padding-top:3px; width:10%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE;background-color:#FAFAFA;}  
.input4A {width:15%;  height:30px;  float:left;  padding:0px; border:1px solid #DEDEDE;  background-color:#FFFFFF;}  
.menu4B {width: 15%; height:30px; float:left; padding:0px; border:0px solid #DEDEDE;  background-color:#FAFAFA;}  
.data4A {width:15%; height:30px; float:left; padding:4px; border:1px solid #DEDEDE; background-color:#FFFFFF;}  
.main4A {width:100%;  float: left;  padding: 15px;  border: 1px solid #DEDEDE;}  
.blankA {border-top:0px;	width: 100%;    float: left;	height: 1px;	padding: 0px;	border: 1px solid #FFFFFF;background-color:#FFFFFF;}  
.blankB {width:100%;  height: 1px;  padding: 1px;  float: left;  border: 1px solid #FFFFFF;  background-color:#FFFFFF;}  
.viewSubjX{margin-top:1px;	width:100%;height:35px;	line-height:32px;border-top:3px solid #d01c27;	text-align:center;background:#fafafa;border-bottom:1px solid #dedede;overflow:hidden;font-size:18px;color:#69604f;}  
.viewSubjX span{font-size:22px;color:#171512; vertical-align:baseline; }  
.HeadTitle02AX{display:inline-block;	margin:0 1px;	height:35px;	line-height:35px;	padding:0 20px;	font-size:25px;	background:#d01c27;	color:#ffffff;	border-radius:5px;}  
.HeadTitle01AX{display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;font-size:22px;background:#d01c27;color:#fff;border-radius:5px;}  
.HeadTitle01AX a.on{background:#d01c27;color:#fff;}  
.HeadTitle01A{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  
.HeadTitle02A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  
.HeadTitle01A a{display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;	font-size:22px;background:#dedcdf;color:#000;border-radius:5px;}  
.HeadTitle01A a.on{background:#d01c27;color:#fff;}  
.Btn_List01A{width:64px;height:33px;display:inline-block;line-height:33px;	text-align:center;color:#fff;font-size:14px;background:#d01d27;	margin-right: 10px;	}  
.Btn_List02A{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  
.Btn_List03A{width:104px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  
.Btn_List04A{width:114px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;	font-size:14px;	background:#d01d27;	margin-right:10px;	}  
.viewHeader{width:100%;height:auto;overflow:hidden;position:relative;text-align:right;}  
.viewHeader span{position:absolute;left:0;top:12px;font-size:14px;color:#686868;}  
.boardView{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}  
.boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}  
</style>  
 -->
 <!-- 
<link rel="stylesheet" href="/t/include/css/common.css" type="text/css" />
<script type="text/javascript" src="/t/include/js/ui.js"></script>

<style>
body, td, tr { font-size:12pt;font-family:굴림체;}
a:link, a:visited, a:active {text-decoration:no; color:black;}
a:hover { color:green}
</style>
 -->
<script language=javascript>
<!--
	function Menu_List(Anum) {
			location.href='index.php'; // index_list.php - 'cratree_my_list_menu.php';
	}
function Create_sendform( fm, target_ ){ 
	//alert( document.sys_bom.sys_subtit.value + ' , cratree_book_make target_:' + target_); // return false; // cratree_book_make sendform --- target_:

	var tit = document.sys_bom.sys_subtit.value;
	if( !tit ){
		alert("Please enter a title"); 
		document.sys_bom.sys_subtit.focus(); 
		return false;
	} else {
		if( confirm('Are you sure you want to create? ') ) { //f.action="admin_treebom_new2_book.php";//신규 검색기능 추가 treebom_insert2.php를 변경하여 검색기능 추가 한것.
			//if( target_ ) document.sys_bom.target = target_;
			document.sys_bom.action="cratreebook_make_create_menu.php";	//신규 검색기능 추가 treebom_insert2.php를 변경하여 검색기능 추가 한것.
			document.sys_bom.submit();
		}
	}
}
function bgc() {
	window.open("./color.html","","alwaysLowered=no,resizable=no,width=260,height=440,left=50,top=50,dependent=yes,z-lock=yes");
}
function AXcolor() {
	window.open("./fontcolor.html","","alwaysLowered=no,resizable=no,width=260,height=440,left=50,top=50,dependent=no,z-lock=yes");
	ControlA();
	return;
}
function img() {
	window.open("./img.php","","alwaysLowered=no,resizable=no,width=500,height=200,left=50,top=50,dependent=yes,z-lock=no");
} 
function img_add() {
	window.open("./img2.php","","alwaysLowered=no,resizable=yes,width=800,height=400,left=50,top=50,dependent=yes,z-lock=no");
}
function Xcolor() {
	//document.all.view_back.style.background = document.sys_bom.bgcolor.value;
}
function fontf() {
}

-->
</script>

<script>
 function photoControl(fz){   
  var obj = document.getElementsByName("liTitle");
  //var obj = document.getElementsByName("view_font");
  //alert(obj +"//"+ obj.length + " fz:" + fz);
  for( i = 0; i < obj.length; i++ ){
   //obj[i].style.display = "none";
   //if( 0 == i  ){
    
	/*obj[i].style.color = "#ff0000";
    obj[i].innerHTML = "홍길동<br>이순신";
    obj[i].style.backgroundColor = "#00ff00";
    obj[i].style.border = "1px solid #ff0000"; // '1px solid DarkGreen'; dotted 2px #FF6600
    obj[i].style.fontWeight = "bolder"; //bold,normal
    obj[i].style.display = "block";
    obj[i].style.fontStyle = "italic"; //italic,normal
    obj[i].style.height = 40;
    obj[i].style.width = 200;
    obj[i].style.align = "center"; 
    obj[i].style.top = 200; 
    obj[i].style.left = 200;
    obj[i].style.zIndex = 0; 
    obj[i].focus(); 
    obj[i].blur();
    obj[i].style.letterSpacing = 20;
    obj[i].style.letterPadding = "center";
    obj[i].style.filter = "alpha(opacity=50)"; 
    obj[i].style.cssText ="border:1px solid #ff0000;width:500px;text-align:center;padding-top:100px";
    obj[i].style.overflow = "hidden";
    obj[i].style.position = "relative";
    obj[i].style.cursor = "pointer";
    obj[i].style.padding = 10;
    obj[i].style.paddingLeft = 30;
    obj[i].style.paddingTop = 30;
    obj[i].style.marginLeft = 50;
    obj[i].style.marginTop = 50;
    obj[i].style.fontFamily = 'Lucida Console'; //"궁서";
    obj[i].style.backgroundImage = 'none';
    obj[i].style.borderTopWidth = 5;
    */
	
	obj[i].style.color = document.sys_bom.fontcolor.value;
	if(i <3 ) {
		obj[i].style.fontSize = fz;//25;
		obj[i].style.height = 40;//25;
		obj[i].style.width = 100;//25;
	}
	if(i==0) obj[i].innerText = "Preview";// \n [미리보기]
	if(i==1) obj[i].innerText = "Preview \n View \n Sample";
  } // for
}
 
	function ControlA(){   
		var obj = document.getElementsByName("liTitle");
		for( i = 0; i < obj.length; i++ ){
			obj[i].style.color = document.sys_bom.fontcolor.value;
			/*if(i==0) obj[i].innerText = "Preview \n [미리보기]";
			if(i==1) obj[i].innerText = "Preview \n [미리보기] \n View \n Sample";
			if(i==2) obj[i].innerText = "Font Color [글자색]";*/
			if(i==0) obj[i].innerText = "Preview ";
			if(i==1) obj[i].innerText = "Preview \n View \n Sample";
			//if(i==2) obj[i].innerText = "Font Color [글자색]";
		} // for
		return;
	}
</script>

<link rel='stylesheet' href='../include/css/kancss.css' type='text/css'><!-- 중요! -->

</head>
<BODY bgproperties=FIXED bgcolor="#000000" text="#ffffff" leftmargin=0 oncontextmenu="return false" ondragstart="return false" onselectstart="return false" onload="sys_bom.sys_subtit.focus()">

<?php
	$cur='C';
	include "../menu_run.php";

	if( isset($_REQUEST['fontcolor']) ) $fontcolor = $_REQUEST['fontcolor'];
	else $fontcolor='cyan';
	if( isset($_REQUEST['bgcolor']) ) $bgcolor = $_REQUEST['bgcolor'];
	else $bgcolor='black';
	if( isset($_REQUEST['fontsize']) ) $fontsize = $_REQUEST['fontsize'];
	else $fontsize='15';

	$uid = explode('@', $H_ID); // 2024-04-05
	$cratreecode   = $uid[0] . time();

	//$first_linkurl = "./cratree_my_list_menu.php?mid=$from_session_id"; // only tree list.
	$first_linkurl = "./index.php?mid=$H_ID"; // only tree list.
	$target_       = "run_menu";  //$_REQUEST['target_'];
?>

<div align="center">

<form name='sys_bom' METHOD='POST' enctype="multipart/form-data" >
	<input type='hidden' name='sys_link' value="<?=$first_linkurl?>" ><!-- "../treelist_cranim_book.php" -->
	<input type='hidden' name='sys_pg'   value='<?=$cratreecode?>' >
	<input type='hidden' name='target_'  value='<?=$target_?>'>

<table border="1" width="500" cellspacing="0" bordercolordark="yellow">
	<tr>  
		<td align='center' colspan="2" style="background-color:gray;color:white;ime-mode:active;height:30;">
			&nbsp; K-Tree Menu
			<br>[code:<?=$cratreecode?>]</font>
		</td>
	</tr>
	<tr>  
		<td style="background-color:black;ime-mode:active;height:30;">
		<p align="center">
			<b><span style="background-color:black;color:<?=$fontcolor?>;">Title</span></b></td>
		<td style="background-color:black;ime-mode:active;height:30;">  
			<input type='text' name='sys_subtit' size='30' maxlength='30' style="background-color:black;ime-mode:active;height:30;color:white">
		</td> 
	</tr>
	<tr>
		<td align='left' width="108" valign='middle' height='26'><b><p align="center"><span style="background-color:black;color:<?=$fontcolor?>;">memo</span></b></td>
		<td valign='middle' height=26 width="376">
			<input type='text' name='sys_memo' size='50' maxlength='250' value="" style="background-color:#00000f;ime-mode:active;height:30;color:white">
		</td> 
	</tr>
	<tr>
		<td align='center' height="189" width="108">
		<div name='liTitle' id='view_font2' style='display:block;color:<?=$fontcolor?>;font-size:<?=$fontsize?>px' align='center'>
			<span style="background-color:black;color:<?=$fontcolor?>;"> Preview </span>
		</div>
			<table border="1" width="100" height="100"  id="view_back" cellspacing="0" style='display:block;color:<?=$fontcolor?>;font-size:<?=$fontsize?>px'>
				<tr>
					<td width="100" height="100" id="view_fontX">
					<div name='liTitle' id='view_font' style='display:block;color:<?=$fontcolor?>;font-size:<?=$fontsize?>px' align='center'>
						<span style="background-color:black;color:<?=$fontcolor?>;">Preview<br>View<br>Sample<br></span>
					</div>
					</td>
				</tr>
			</table>
		</td>
		<td align='center' height="199" width="450">
		<p align="center">
		<b><span style="border-style:;background-color:black;color:yellow;height:30;">
		[Design settings]</span></b><br>
			<table cellpadding="0" cellspacing="0" width="440">
				<tr>
					<td width="150" height="18"><p align="right"><font color='cyan'>Font Size &nbsp;</td>
					<td width="164" height="18">
					<select name="fontsize" onchange='photoControl(this.value)' style="border-style:;background-color:#00000f;color:white;height:30;"> 
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15" selected>15-usually</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="36">36</option>
					</select>
					</td>
				</tr>
				<tr>
					<td><p align="right"><font color='cyan'>Background color &nbsp;</td> 
					<td width="264" height="26">
						<input type="text" name="bgcolor" size="7" onblur="javascript:Xcolor();" value="<?=$bgcolor?>" style="border-style:;background-color:black;color:<?=$fontcolor?>;height:30;">
						<input type="button" value="color select" onclick="javascript:bgc();" style="border-style:;background-color:#00000f;color:<?=$fontcolor?>;height:30;">
					</td>
				</tr><tr>
					<td>
						<div name='liTitleA' id='view_font3' style='display:block;color:<?=$fontcolor?>;text-align:right;'>
							<span>Font Color &nbsp;</span>
						</div>
					</td>
					<td width="264" height="18"><p>
						<input type="text" name="fontcolor" size="7" value="<?=$fontcolor?>" style="border-style:;background-color:black;color:<?=$fontcolor?>;height:30;">
						<input type="button" value="color select" onclick="javascript:AXcolor();" style="border-style:;background-color:#00000f;color:<?=$fontcolor?>;height:30;">
					</td>
				</tr>
				<tr>
					<td><p align="right"><font color='cyan'>Font &nbsp;</td>
					<td width="264" height="21"><p>
					<select name="fontface" onchange="javascript:fontf();" style="border-style:;background-color:#00000f;color:white;height:30;">
                         <option value="Arial" selected>Arial</option>
                         <option value="Arial Black">Arial Black</option>
                         <option value="Book Antiqua">Book Antiqua</option>
                         <option value="Courier">Courier</option>
                         <option value="fixedsys">Fixedsys</option>
                         <option value="georgia">georgia</option>
                         <option value="system">System</option>
                         <option value="Tahoma">Tahoma</option>
                  	 </select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr> 
		<td align='center' height='39' colspan="2" width="488" bgcolor="#000000"  bordercolordark="#3399CC">
			<input type='button' value='Creates' onclick="javascript:Create_sendform( this, '<?=$target_?>');" class='HeadTitle01AX' title='Create a menu tree.'>
		</td>
	</tr>
</table>
<br>
</form>
</div>

<?php if($H_ID){ ?>
	<form name='form_view' method='post' enctype='multipart/form-data' >
		<input type='hidden' name='mode' value='' />
		<input type='button' value='Tree List' onclick="javascript:Menu_List('appgenerator');" class='HeadTitle01AX' title='List of Tree Menu'>
	</form>
<?php } ?>


 </BODY>
</HTML>
