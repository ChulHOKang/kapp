<?php
	include_once('../tkher_start_necessary.php');
	/*
		index_create.php - call: index.php - List, Re Design
		-cratreebook_make_create_menu.php : note tree Create.
	*/
	$H_ID  = get_session("ss_mb_id");	
	if( $H_ID && isset($member['mb_level']) ){
		$H_LEV = $member['mb_level']; 
		$H_EMAIL = $member['mb_email']; 
	} else {
		m_(" login please! ");
		echo "<script>window.open( './' , '_top', ''); </script>";
		exit;
	}
	$ip    = $_SERVER['REMOTE_ADDR'];
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
.HeadTitle01AX{display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;font-size:22px;background:#d01c27;color:#fff;border-radius:5px;}  
.HeadTitle01AX a.on{background:#d01c27;color:#000;}  
</style>  

<script language=javascript>
<!--
	function Menu_List(Anum) {
			location.href='index.php'; 
	}
function Create_sendform( fm, target_ ){ 
	var tit = document.sys_bom.sys_subtit.value;
	if( !tit ){
		alert("Please enter a title"); 
		document.sys_bom.sys_subtit.focus(); 
		return false;
	} else {
		if( confirm('Are you sure you want to create? ') ) {
			document.sys_bom.action="cratreebook_make_create_menu.php";
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
	function sys_type_check() {
		if(document.sys_bom.sys_type.checked === false){

			if( confirm('Prints at the top of the list, Cancle? Y/N ') ) {
				document.sys_bom.sys_type.checked =false;
				document.sys_bom.sys_type.value='M';
				return;
			} else {
				document.sys_bom.sys_type.checked =true;
				document.sys_bom.sys_type.value='T';
				return;
			}
		}
		if( confirm('Prints at the top of the list! Y/N ') ) {
			document.sys_bom.sys_type.checked =true;
			document.sys_bom.sys_type.value='T';
		} else {
			document.sys_bom.sys_type.checked =false;
			document.sys_bom.sys_type.value='M';
		}
		/*
		if(document.sys_bom.sys_type.checked === false){
			alert("------- true");
			document.sys_bom.sys_type.checked =false;
			return;
		} else {
			if( confirm('Prints at the top of the list! Y/N ') ) {
				document.sys_bom.sys_type.checked =true;
			} else {
				document.sys_bom.sys_type.checked =false;
			}
		}*/
	}

-->
</script>

<script>
	function photoControl(fz){   
		var obj = document.getElementsByName("liTitle");
		for( i = 0; i < obj.length; i++ ){
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
			if(i==0) obj[i].innerText = "Preview ";
			if(i==1) obj[i].innerText = "Preview \n View \n Sample";
		} // for
		return;
	}
</script>
<link rel='stylesheet' href='../include/css/kancss.css' type='text/css'>

<BODY bgproperties='FIXED' bgcolor="#000000" text="#ffffff" leftmargin='0' oncontextmenu='return false' ondragstart="return false" onselectstart="return false" onload="sys_bom.sys_subtit.focus()">
<?php
	$cur='C';
	include "../menu_run.php";

	if( isset($_REQUEST['fontcolor']) ) $fontcolor = $_REQUEST['fontcolor'];
	else $fontcolor='cyan';
	if( isset($_REQUEST['bgcolor']) ) $bgcolor = $_REQUEST['bgcolor'];
	else $bgcolor='black';
	if( isset($_REQUEST['fontsize']) ) $fontsize = $_REQUEST['fontsize'];
	else $fontsize='15';

	//$uid = explode('@', $H_ID); 
	//$cratreecode   = $uid[0] . time();
	$cratreecode   = $H_ID . '_' . time();
	$first_linkurl = "./index.php?mid=$H_ID"; 
	$target_       = "run_menu"; 
?>
<div align="center">

<form name='sys_bom' METHOD='POST' enctype="multipart/form-data" >
	<input type='hidden' name='sys_link' value="<?=$first_linkurl?>" >
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
			&nbsp;&nbsp;&nbsp;<span style='color:yellow;' title='Print at the top.'>System menu</span>&nbsp;
			<input type='checkbox' id='sys_type' name='sys_type' value='' onclick="sys_type_check()" >
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

<?php if( $H_ID !== ''){ ?>
	<form name='form_view' method='post' enctype='multipart/form-data' >
		<input type='hidden' name='mode' value='' />
		<input type='button' value='Tree List' onclick="javascript:Menu_List('appgenerator');" class='HeadTitle01AX' title='List of Tree Menu'>
	</form>
<?php } ?>
 </BODY>
</HTML>
