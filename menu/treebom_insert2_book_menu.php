<?php
	include_once('../tkher_start_necessary.php');
	/* --------------------------------------------------------------------------
		treebom_insert2_book_menu.php : 
		run : treebom_insw_book_menu.php -> tree_create_menu.php: Record .
			$url='contents_view_menuD.php?num=' . $max_num;
	 * treebom_insert2_new.php
	 * tree_menu_updateM2.php 
	----------------------------------------------------------------------------- */
	$H_ID	= get_session("ss_mb_id");	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL = $member['mb_email'];
	else $H_EMAIL = '';

	if (!$H_ID || $H_LEV < 1) {
		m_(" Please login. ");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	//m_("post make_type:" . $_POST['make_type']); // tree_menu_updateM.php- booktreeupdateM
	if( isset($_POST['make_type'] )){
		$sys_pg_root= $_POST['sys_pg_root'];
		$make_type	= $_POST['make_type'];
		$m_type		= $_POST['m_type'];
		$mode		= $_POST['mode'];
		$data		= $_POST['data'];		
		$data1		= $_POST['data1'];
	} else if( isset($_REQUEST['make_type']) ) {
		$sys_pg_root= $_REQUEST['sys_pg_root'];
		$make_type	= $_REQUEST['make_type'];
		$m_type		= $_REQUEST['m_type'];
		$mode		= $_REQUEST['mode'];
		$data		= $_REQUEST['data'];		
		$data1		= $_REQUEST['data1'];
	} else {
		$sys_pg_root= '';
		$make_type	= '';
		$m_type		= '';
		$mode		= '';
		$data		= '';
		$data1		= '';
	}
	if( isset($_POST['target_my']) ) $target_my= $_POST['target_my'];
	else if( isset($_REQUEST['target_my']) ) $target_my= $_REQUEST['target_my'];
	else $target_my	= '';

	//m_( "2 sys_pg_root: " . $sys_pg_root . ", data: " . $data . ", data1: " . $data1);
	//2 sys_pg_root: link, data: dao_1756603979, data1: https://ailinkapi.com/kapp
	//2 sys_pg_root: dao_1756603979, data: dao_1756603979_r, data1: dao_1756603979_r02

	if( !$data1 || !$sys_pg_root ){
		m_( "sys_pg_root: " . $sys_pg_root . ", data1: " . $data1 . " - Error treebom_insert2_book_menu" ); exit;
	}
	if( $sys_pg_root == 'link' ) $sql="select * from {$tkher['sys_menu_bom_table']} where sys_menu ='$data' and sys_submenu = '$data' ";
	else  $sql="select * from {$tkher['sys_menu_bom_table']} where sys_menu ='$data' and sys_submenu = '$data1' ";
	$result = sql_query( $sql);	
	$rs		= sql_fetch_array($result);
	$mid	= $rs['sys_userid']; 
	$gtit	= $rs['sys_subtit']; 
	$view_lev   = $rs['view_lev']; 
	$sys_pg_root= $rs['sys_pg']; 
	$xsys_pg	= $rs['sys_pg'];

	if ( $H_ID != $mid ) {
		//m_(" You do not have permission to work. \\n 작업권한이 없습니다. mid:$mid, data:$data, data1:$data1");
		m_(" You do not have permission to work.  mid:$mid, " . $H_ID); //You do not have permission to work.  mid:, dao
		$rungo = "./" . $rs['sys_userid'] . "/". $xsys_pg . "_runf.html";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/_tree_.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,app generator, web app, homepage, php, generator, source code, open source, app tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,app generator, web app, homepage, php, generator, source code, open source, app tool, soho, html, html5, css3, ">
<meta name="robots" content="ALL">
</head>
<body bgcolor='black'> <font color='yellow'>

<script language=javascript> 
<!-- 
	function tree_in_sert(mtype, sys_pg, data1){ // Save button
		if( sys_pg == '' || data1 == ''){ // 2022-01-27 추가부분.
			alert('Error sys_pg:'+sys_pg+', data1:'+data1); return;
		}
		mode = document.sys_bom.mode.value;
		data = document.sys_bom.data.value;
		data1 = document.sys_bom.data1.value;//alert('mode:'+mode+', data:'+data+', data1:'+data1);
		sys_pg_root = document.sys_bom.sys_pg_root.value; //alert('sys_pg_root:'+sys_pg_root);
		var ins = window.confirm(" Do you want to register? sys_pg_root: "+sys_pg_root);
		if (ins)
		{ 
			document.sys_bom.action="treebom_insw_book_menu.php"; 
			document.sys_bom.submit();
		} 
	} 

	function reset_in_sert( data ){ // Main level set
		if( !document.sys_bom.sys_pg_root.value ) {
			alert('ERROR - data:'+data + ', sys_pg:' + document.sys_bom.sys_pg_root.value);
			return;
		}
		document.sys_bom.data.value = document.sys_bom.sys_pg_root.value;	//sys_pg;
		document.sys_bom.data1.value = document.sys_bom.sys_pg_root.value;	//sys_pg;
		document.sys_bom.mode.value ="mroot";
		document.sys_bom.action ="treebom_insert2_book_menu.php";
		document.sys_bom.submit();
	} 

	function contents_sel( jjj ) {
		var word = ''; 
		window.open('./pg_list_select_menu.php?no2='+jjj,'','width=700,height=700, toolbar=no,scrollbars=yes,resizable=no');
		return true;  
	}
	function jong_func( jong, j, num ) {
        if(jong=='link') pg_name = "";
        else if(jong=='note')  pg_name = "contents_view_menuD.php?num=" + num;
        else if(jong=='board') pg_name = "index_bbs.php?infor=";
        else if(jong=='photo') pg_name = "index_bbs.php?infor=";
		else pg_name = "";
		eval ( "document.sys_bom.sys_link_"+j+".value = pg_name" );
		return true;  
	}
-->
</script>
<?php
if( ! isset($mode) ) $mode='mroot';
//m_("mode: " . $mode . ", data: " . $data. ", data1: " . $data1. ", sys_pg_root:". $sys_pg_root); 
//mode: mroot, data: dao1612664367, data1: dao1612664367, sys_pg_root:dao1612664367
if( $mode=='mroot' ) {
	  $sql = " select * from {$tkher['sys_menu_bom_table']} where sys_userid='$H_ID' and sys_pg='$sys_pg_root' and sys_submenu='$sys_pg_root' "; 
} else {
	  $sql = " select * from {$tkher['sys_menu_bom_table']} where sys_userid='$H_ID' and sys_menu='$data' and sys_submenu = '$data1' ";
}
	  $result = sql_query( $sql);	
	  $rs = sql_fetch_array($result);//m_("mode: ".$mode . ", m_type: " .$m_type);//mode: mroot, m_type: booktreeupdateM2
		$xm1 = '';
		$xm2 = '';
	  if( $rs != null) {
			$recordcount = sql_num_rows($result);	 
			$xm1 = $rs['sys_menu'];
			$xm2 = $rs['sys_submenu'];
			$sys_level = $rs['sys_level'];
			$rcnt= $rs['sys_rcnt'];
			$cnt = $rs['sys_cnt'];
			$tit = $rs['sys_subtit'];
			$sys_pg = $rs['sys_pg'];
			if( $mode == 'mroot' ) {
				$root_chk = 1;
?>
				<center>
				<h3 title='treebom_insert2_book_menu'> 
				 <font color='yellow'>Main level registration of</font>
				 <font color='white'>'<?=$tit?>'</font>
				</h3></center>
<?php   
			} else{
				$root_chk = 0;
?>
				<center><font size='4' color='green'>
				<h3 title='treebom_insert2_book_menu'><b> Bottom level registration of <font color='yellow'><?=$tit?></font></b> </h3></font></center>
<?php 
			}
	   } else {
 ?>
			<center><font size='4' color='green'><h3><b> [ ERROR - treebom_insert2_book_menu ] [data:<?=$data?>][data1:<?=$data1?>]</b></h3></font></center>
			<body leftmargin='0' topmargin='0' bgproperties='fixed'>  
<?php 
	  }
		$xroot_level= $rs['sys_level'];	
?>
  <center>
<form method='post' name='sys_bom' >
	<input type='hidden' name='mid'		value='<?=$H_ID?>' >
	<input type='hidden' name='make_type'	value='<?=$make_type?>' >
	<input type='hidden' name='m_type'	value='<?=$m_type?>' >
	<input type='hidden' name='data'		value='<?=$data?>' > 
	<input type='hidden' name='data1'		value='<?=$data1?>' >
	<input type='hidden' name='mode'		value='<?=$mode?>'>
	<input type='hidden' name='sys_rcnt'	value='<?=$rcnt?>'>
	<input type='hidden' name='sys_cnt'	value='<?=$cnt?>'>
	<input type='hidden' name='gtit'		value='<?=$gtit?>'>
	<input type='hidden' name='view_lev'	value='<?=$view_lev?>'>
	<input type='hidden' name='sys_pg_root'		value='<?=$sys_pg_root?>'><!-- add 2018-04-07 job_link_table 등록을위해 필요. -->
	<input type='hidden' name='target_my'	value='<?=$target_my?>'>

	<input type='hidden' name='xroot_level'	value='<?=$xroot_level?>'><!-- 2021-12-09 : root의 top line 체크및 등록을 위해 -->

  <table border='1' cellspacing='0' cellpadding='0' style='background-color:black;color:white;' >
	<tr style='color:white'>
		<td>No</td>
		<td>Find</td>
		<td>Tile</td>
		<td>Type</td>
		<td>Link URL</td> 
		<td>Memo</td>
	</tr>
<?php
	 if( $rs != null ) { 
		$recordcount = $rs['sys_rcnt'];
		$xm1 = $rs['sys_menu'];	
		$xm2 = $rs['sys_submenu'];	
		$xroot_chk	= $rs['sys_menutit']; 
		$xroot_cnt	= $rs['sys_rcnt'];
		$xlow_cnt	= $rs['sys_cnt'];
		if( $mode == "mroot" ){ 
			$recordcount = $xroot_cnt;							
		} else if ( $xroot_chk == "root" ) {
			$recordcount = $xlow_cnt;
		} else {
			$recordcount = 0;
		}
	}
for ( $i=1, $j=0; $i <= 13; $i++, $j++ ) {  
     if( $mode == 'mroot' && $xroot_level=='mroot') { // 2021-12-09
             $low_cnt = $recordcount + $i; 
             $xdata1 = $sys_pg . "_r";
             if ( strlen($low_cnt) == 1 ){
				$xdata2 = $sys_pg . "_r" . "0" . $low_cnt; 
             } else {
             	$xdata2 = $sys_pg . "_r" . $low_cnt;
			 }
	 } else {
	     $low_cnt = $recordcount + $i;
	     $xdata1 = $xm2;
	     
		if ( strlen($low_cnt) == 1 ) {
			$xdata2 = $data1 . "_" . "0" . $low_cnt; // $xdata2 = $data1 . "_" . "0" . $low_cnt;
		} else {
			$xdata2 = $data1 . "_" . $low_cnt;	// $xdata2 = $data1 . "_" . $low_cnt;	
		}
	 } 
	$max_num = $H_ID . (time() + $j);
?>
		<tr valign='middle' style='background-color:black;color:white;'> 
		  <td align='center' bgcolor='black'><font color='green' size='4'><?=$low_cnt?></td>
				<input type='hidden' name="max_num_<?=$j?>"     value='<?=$max_num?>' >
				<input type='hidden' name="sys_disno_<?=$j?>"   value='<?=$low_cnt?>' >
				<input type='hidden' name="sys_pg1_<?=$j?>"     value='<?=$data?>' >
				<input type='hidden' name="sys_level_<?=$j?>"   value='<?=$xroot_level?>' >
				<input type='hidden' name="sys_menu_<?=$j?>"    value='<?=$xdata1?>' >
				<input type='hidden' name="sys_submenu_<?=$j?>" value='<?=$xdata2?>' >
		  <td align='left' size='10'>
			<input type='button' value="Find" onClick="javascript:contents_sel(<?=$j?>)" style="ime-mode:disabled; FONT-SIZE:10pt; FONT-FAMILY:verdana; BACKGROUND-COLOR:black; color:gray;">
		  </td> 
		  <td> <input type='text' name="sys_subtit_<?=$j?>" size='20' maxlength='50' style='background-color:black;color:white;'> </td>
		<td>
			<select name="jong_<?=$j?>" onchange="jong_func( this.value, '<?=$j?>', '<?=$max_num?>')" style='background-color:cyan;color:blue;'> 
				<option value="link" selected>Link</option>
				<option value="note">Note</option>
				<option value="board">Board</option>
				<option value="photo">Photo</option>
			</select>
		</td>
		  <?php
			$url='contents_view_menuD.php?num=' . $max_num;
		  ?>
		  <td> 
		   <input type='text' name="sys_link_<?=$j?>" size='39' maxlength='250' value='' onfocus='this.select();' style='background-color:black;color:white;'> </td>
		  <td> 
		   <input type='text' name="sys_memo_<?=$j?>" value='' size='20' maxlength='250' onfocus='this.select();' style='background-color:black;color:white;'>	<!-- <input type='text' name="sys_memo_<?=$j?>" value='mode:<?=$mode?>, xm1:<?=$xm1?>, xm2:<?=$xm2?>, <?=$xroot_level?>, <?=$xdata1?>, <?=$xdata2?>' size='20' maxlength='250' onfocus='this.select();' style='background-color:black;color:white;'> -->
		   </td>
		</tr>
<?php 
		//mode:mroot, xm1:dao1632184451, xm2:dao1632184451, mroot, dao1632184451_r, dao1632184451_r19
} 
 ?> 

  </table>
		<input type='button' name='ins' onclick="javascript:tree_in_sert('<?=$m_type?>','<?=$sys_pg?>','<?=$data1?>');" value=" [Save] " style="border-style:;background-color:green;color:yellow;height:25;border-radius:20px;" title='treebom_insert2_book_menu - Record Insert to DB'>
 <?php
	if ( $mode == 'mroot' or $mode == '' ) {
 ?>
		<!-- <input type=button value='하위 등록 전환' onclick="javascript:reset_in_sert('root_rowlevel');"> -->
<?php
	} else {
?>
		<input type='button' value='Switch to main level' onclick="javascript:reset_in_sert('<?=$data?>');" style="border-style:;background-color:blue;color:yellow;height:25;">
<?php
	}
?>

<?php
	if ( $mode == 'mroot' and $m_type=='' ) {
?>
		<br>
		 <font color='yellow'>Create the main level! sys_pg:<?=$sys_pg?>, data1:<?=$data1?></font> <br>
<?php
	} else {
?>
		<br>
		 <font color='yellow'>Create bottom level of <?=$tit?>, sys_pg:<?=$sys_pg?>, data1:<?=$data1?></font><br>
<?php
	}
	//if( ($xm1 == $xm2) and ($sw == 1)) {
	//          $sw = 2; 
	//} else {
	//          $sw = 1;
	//}
	$root_chk = $root_chk;
	$record_cnt = $recordcount;		
?>
   	<input type="hidden" name="root_chk"	value="<?=$root_chk?>">
   	<input type="hidden" name="record_cnt"  value="<?=$record_cnt?>">

</form>
</body>
</html>
