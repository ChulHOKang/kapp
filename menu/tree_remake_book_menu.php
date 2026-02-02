<?php
	include_once('../tkher_start_necessary.php');
	/*
	- tree_remake_book_menu.php : ReDesign Job,  Tree Note Remake Source
	- run : tree_remakew_book_menu.php
			트리메뉴 재생성 시작 페이지:tree_remakew_book call
	- mid : 
	*/
	$H_ID	= get_session("ss_mb_id");
	if( $H_ID && $H_ID !=='' ){
		$H_LEV=$member['mb_level']; 
	} else {
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];

	if (!$H_ID) {
		my_msg(" Please login. ");
		$rungo = "./";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}

	$make_type = $_POST['make_type'];
	$target_   = $_REQUEST['target_'];

	//my_msg("tree_remake_book_menu make_type:$make_type, " );
	//Fetch menuskin NULL ERROR : , sys_pg:link
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Beginner PG-Upgrade AppGeneratorSystem. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<style>
body, td, tr { font-size:9pt;font-family:Arial;}
a:link, a:visited, a:active {text-decoration:no; color:black;}
a:hover { color:red}
</style>

<script language=javascript>
<!--
	function sendform( type ){ 
		var f = document.sys_bom;
		//alert( "tree_remake_book_menu - make_type: " + f.make_type.value); //tree_remake_book_menu - make_type: booktreeupdateM2

		if (f.sys_pg.value.length==0){ alert("Menu Code Insert Please! "); f.sys_pg.focus(); }
		else if (f.sys_subtit.value.length==0){ alert(" Please enter a title "); f.sys_subtit.focus(); }
		else
		{
			document.sys_bom.action="tree_remakew_book_menu.php";   
			document.sys_bom.submit();
		}
	}
	function bgc() {
		window.open("./color.html","","alwaysLowered=no,resizable=yes,width=260,height=440,left=150,top=150,dependent=yes,z-lock=yes");
	}
	function AXcolor() {
		window.open("./fontcolor.html","","alwaysLowered=no,resizable=no,width=260,height=440,left=50,top=50,dependent=yes,z-lock=yes");
	} 

	function img() {
		window.open("./img.php","","alwaysLowered=no,resizable=no,width=500,height=500,left=50,top=50,dependent=yes,z-lock=no");
	}
	function img_add() {
		window.open("./img2.php","","alwaysLowered=no,resizable=yes,width=800,height=400,left=50,top=50,dependent=yes,z-lock=no");
	}
	function Xcolor() {
	}
	function fontf() {
	}
	function fonts() {
	}
-->
</script>

<script>
 function photoControl(fz){   
  var obj = document.getElementsByName("liTitle");
  for( i = 0; i < obj.length; i++ ){
	obj[i].style.color = document.sys_bom.fontcolor.value;
	obj[i].style.fontSize = fz; 
	if(i==0) obj[i].innerText = "Preview ";
	if(i==1) obj[i].innerText = "Preview \n View \n Sample";
  }//for
 }
</script>

</head>
<?php	
	//$sys_pg = $_REQUEST['sys_pg'];
	//if( !$sys_pg ) $sys_pg = $_POST['pg'];
	$sys_pg = $_POST['sys_pg'];
	if( !$sys_pg ) m_("ERROR - tree_remake_book_menu sys_pg:" . $sys_pg);
	if( isset($_POST['book_num']) ) $book_num = $_POST['book_num'];
	else if(isset($_REQUEST['book_num']) ) $book_num = $_REQUEST['book_num'];
	else $book_num = '';
	$sql = "select * from {$tkher['sys_menu_bom_table']} where sys_pg = '".$sys_pg."' and sys_level='mroot' order by seqno  desc ";
	$result = sql_query($sql);	
	$rs = sql_fetch_array($result);
	$mid = $rs['sys_userid'];
	if( !$rs ) {
		if( $H_ID !== $mid and $H_LEV < 8 ) {
			my_msg(" You do not have permission ");
			//$rungo = $sys_pg . "_r1.htm";
			echo "<script>history.back(); histroy.go(-1); </script>";
			exit;
		}
	}
	$first_linkurl = 'contents_view_menuD.php?num=' . $rs['book_num'];//667
	$sql2 = "select * from {$tkher['menuskin_table']} where sys_pg = '".$sys_pg."' order by seqno  desc ";
	$result2 = sql_query($sql2);	
	$rs2 = sql_fetch_array($result2); 
	if(!$rs2)	m_(" Fetch menuskin NULL ERROR : $rs, sys_pg:".$sys_pg);
	//Fetch menuskin NULL ERROR : , sys_pg:link
	// Fetch menuskin NULL ERROR : Array, sys_pg:dao1697839181
?>

<BODY bgproperties=FIXED bgcolor="#000000" text="#ffffff" leftmargin=0 oncontextmenu="return false" ondragstart="return false" onselectstart="return false" onload="sys_bom.sys_subtit.focus()">

<div align="center">

<form name='sys_bom'  METHOD='POST' enctype="multipart/form-data"> 
		<input type="hidden" name="make_type"	value="<?=$make_type?>">
		<input type="hidden" name="book_num"	value="<?=$book_num?>">
		<input type="hidden" name="sys_pg"		value="<?php echo $sys_pg ?>">
		<input type="hidden" name="mid"			value="<?php echo $mid ?>"><!-- add 2018-04-01 -->
		<input type="hidden" name="target_"		value="<?=$target_?>">
<table border="1" width="800" cellspacing="0" bordercolordark="000000">
	<tr>  
		<td align='center' colspan="2" style="background-color:blue;ime-mode:active;height:30;">
		<b><font size=3 color=cyan>&nbsp; Regenerate Link Tree Note <br> <?=$sys_pg?></td>
	</tr>
	<tr>
		<td width="108" height='26'>
		<p align="center">
		<b><span style="background-color:black;"><font color=cyan>Title</span></b></td>
		<td valign='middle' height='26' width="376">  
			<input type='text' name='sys_subtit' size='30' maxlength='30' value="<?php echo $rs['sys_subtit'] ?>" style="border-style:;background-color:black;color:yellow;height:30;">
<?php
if ( $rs['view_lev'] == '0') $t_lev= 'Open'; 
else if ( $rs['view_lev'] == '1') $t_lev= 'No Open'; 
else $t_lev= 'Open'; 
?>
 		</td> 
	</tr>
	<tr>
		<td style="background-color:black;ime-mode:active;height:30;">
		<p align="center">
			<b><span style="background-color:black;"><font color='cyan'>URL </span></b></td> 
		<td valign='middle' height='26' width='376' > 
			<input type='text' onFocus='this.select();' name='sys_link' size='50' maxlength='250' value="<?=$first_linkurl?>" style="border-style:;background-color:black;color:yellow;height:30;" readonly>
		</td> 
	</tr>
	<tr>
		<td style="background-color:black;ime-mode:active;height:30;">
		<p align="center">
			<b><span style="background-color:black;"><font color='cyan'>memo </span></b></td> 
		<td valign='middle' height='26' width='376' > 
			<input type='text' onFocus='this.select();' name='sys_memo' size='50' maxlength='250' value="<?php echo $rs['sys_memo'] ?>" style="border-style:;background-color:black;color:gray;height:30;">
		</td> 
	</tr>
	<tr>
		<td align='center' height="189" width="108">
<?php
	$fontsize = $rs2['fontsize'];
	$fontcolor = $rs2['fontcolor'];
?>
		<div name='liTitle' id='view_font2' style='display:block;color:<?=$fontcolor?>;font-size:<?=$fontsize?>px' align=center>
		<span>Preview </span><!-- </p> -->
		</div>
			<table border="1" width="100%" height="100"  id="view_back" cellspacing="0" style='display:block;color:<?=$fontcolor?>;font-size:<?=$fontsize?>px'>
				<tr>
					<td width="200" height="100" id="view_fontX">
					<div name='liTitle' id='view_font' style='display:block;color:<?=$fontcolor?>;font-size:<?=$fontsize?>px' align=center>
					<span>Preview<br>View<br>Sample<br></span>
					</div>
					</td>
				</tr>
			</table>
		</td>
		<td align=center height="189" width="600"><p align="center">
		<b><span style="border-style:;background-color:black;color:cyan;height:30;">Design settings </span></b><br>
			<table cellpadding="0" cellspacing="0" width="600">
				<tr>
					<td width="191" height="18"><p align="right"><font color=cyan>Font Size &nbsp;</td>
					<td width="464" height="18"><p>

						<select name="fontsize" onchange='photoControl(this.value)' style="border-style:;background-color:#00000f;color:white;height:30;">
 
							<option value="<?php echo $rs2['fontsize'] ?>" selected ><?php echo $rs2['fontsize'] ?>pt
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12-usually</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
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
					<td width="250" height="26"><p align="right"><font color=cyan>Background color &nbsp;</td> 
					<td width="264" height="26"><p>
						<input type="text" name="bgcolor" size="7" onblur="javascript:Xcolor();" value="<?php echo $rs2['bgcolor'] ?>" style="border-style:;background-color:black;color:yellow;height:25;">
						<input type="button" value="color select"  style="border-style:groove;" onclick="javascript:bgc();">
					</td>
				</tr><tr>
					<td width="250" height="18"><p align="right"><font color=cyan>Font Color &nbsp;</td>
					<td width="264" height="18"><p>
						<input type="text" name="fontcolor" size="7" value="<?php echo $rs2['fontcolor'] ?>" style="border-style:;background-color:black;color:yellow;height:25;">
						<input type="button" value="color select"  style="border-style:groove;" onclick="javascript:AXcolor();">
					</td>
				</tr><tr>
					<td width="250" height="21"><p align="right"><font color=cyan>Font &nbsp;</td>
					<td width="264" height="21"><p>
					   <select name="fontface" onchange="javascript:fontf();" style="border-style:;background-color:black;color:yellow;height:25;">
						 <option value="<?php echo $rs2['fontface'] ?>" selected ><?php echo $rs2['fontface'] ?>
                         <option value="Arial" selected>Arial</option>
                         <option value="Arial Black">Arial Black</option>
                         <option value="Book Antiqua">Book Antiqua</option>
                         <option value="Courier">Courier</option>
                         <option value="fixedsys">Fixedsys</option>
                         <option value="georgia">georgia</option>
                         <option value="system">System</option>
                         <option value="Tahoma">Tahoma</option>
                         <option value="굴림">굴림</option>
                         <option value="굴림체">굴림체</option>
                         <option value="궁서">궁서</option>
                         <option value="궁서체">궁서체</option>
                         <option value="돋움">돋움</option>
                         <option value="돋움체" >돋움체</option>
                         <option value="바탕">바탕</option>
                         <option value="바탕체">바탕체</option>
                         <option value="새굴림">새굴림</option>
                         <option value="서울가을바람M">서울가을바람M</option>
                         <option value="서울결정B">서울결정B</option>
                         <option value="서울꿈">서울꿈</option>
                         <option value="서울전설">서울전설</option>
                         <option value="서울헤드라인">서울헤드라인</option>
                         <option value="휴먼매직체">휴먼매직체</option>
                         <option value="휴먼옛체">휴먼옛체</option>
					   </select>
					</td>
				</tr>
				<tr>
					<td width="91" height="19"><p align="right"><font color='cyan'>icon&nbsp;&nbsp;</td>
					<td width="264" height="19"><p>
						<input type="hidden" name="imgtype1" size="1" value="<?=$rs2['imgtype1']?>">
                    	<input type="hidden" name="imgtype2" size="1" value="<?=$rs2['imgtype2']?>">
                    	<input type="hidden" name="imgtype3" size="1" value="<?=$rs2['imgtype3']?>">
                    	<img name="img1" align='middle' src="<?=KAPP_URL_T_?>/icon/<?php echo $rs2['imgtype1']?>">
						<img name="img2" align='middle' src="<?=KAPP_URL_T_?>/icon/<?php echo $rs2['imgtype2']?>">
						<img name="img3" align='middle' src="<?=KAPP_URL_T_?>/icon/<?php echo $rs2['imgtype3']?>">
<?php
	if ( $H_ID == 'admin' || $H_LEV > 7) { 
?>
						<input type="button" value="추가" onclick="javascript:img_add();" style="border-style:groove;">
<?php
	}	
?>

					</td>
				</tr>
			</table>
		</td>
	</tr><tr> 
		<td align='center' height='39' colspan="2" style="border-style:;background-color:black;color:yellow;height:30;"> 
			<input type='button' name='ins' onclick="javascript:sendform('<?=$make_type?>');" value="Confirm " style="border-style:; background-color:blue; color:yellow;height:30;">
		</td>
	</tr>
</table>
<br>
</div> 
</body>
</html>