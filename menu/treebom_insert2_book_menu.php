<?php
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];

	/* --------------------------------------------------------------------------
	 *  *** 중요 - book 다중등록시에만 사용:
		treebom_insert2_book_menu.php : 
		2023-08-09 : CURL 작업 추가 - treebom_insw_book_menu.php 
		2021-02 , 2022-01-27보완:$sys_pg null error, tree_in_sert(mtype, sys_pg, data1)보완 sys_pg, data1추가
		/t/tree_menu_guest.php에서도 사용함. : 2021-06-03
		run : treebom_insw_book_menu.php -> tree_create_menu.php: Record 다중 등록.
			$url='contents_view_menu.php?num=' . $max_num;
	 * treebom_insert2_new.php는 크라트리와 Board 만 같이 사용하고 북 BOOK은 이것을 사용함. 링크 정보가 달라...2018-04-07
	 * tree_menu_updateM2.php : call 추가. 2021-05-30 : 모바일용 통합프로그램. 
	----------------------------------------------------------------------------- */
	if (!$H_ID || $H_LEV < 1) {
		my_msg(" Please login. ");
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
		$target_my	= $_POST['target_my'];
	} else {
		$sys_pg_root= $_REQUEST['sys_pg_root'];
		$make_type	= $_REQUEST['make_type'];
		$m_type		= $_REQUEST['m_type'];
		$mode		= $_REQUEST['mode'];
		$data		= $_REQUEST['data'];		
		$data1		= $_REQUEST['data1'];
		$target_my	= $_REQUEST['target_my'];
	}
	if( !$data1 || !$sys_pg_root ){
		m_( "sys_pg_root: " . sys_pg_root . ", data1: " . $data1 . " - Error treebom_insert2_book_menu" ); exit;
	}
	$sql="select * from {$tkher['sys_menu_bom_table']} where sys_menu ='$data' and sys_submenu = '$data1' ";
	$result = sql_query( $sql);	
	$rs		= sql_fetch_array($result);
	$mid	= $rs['sys_userid']; 
	$gtit	= $rs['sys_subtit']; 
	$view_lev   = $rs['view_lev']; 
	$sys_pg_root= $rs['sys_pg']; 
	$xsys_pg	= $rs['sys_pg'];

	if ( $H_ID != $mid ) {
		//my_msg(" You do not have permission to work. \\n 작업권한이 없습니다. mid:$mid, data:$data, data1:$data1");
		my_msg(" You do not have permission to work.");
		$rungo = "./" . $rs['sys_userid'] . "/". $xsys_pg . "_runf.html";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>tree Update M AppGeneratorSystem. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
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
		//alert( mode + ', type:'+ mtype + ', sys_pg:'+sys_pg+', data1:'+data1);
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
		} //alert('data:'+data + ', sys_pg:' + document.sys_bom.sys_pg_root.value);
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
	/*
	function contents_sel_web( jjj ) {
		var word = ''; 
		window.open('./pg_list_select_web_menu.php?formName=frm&no2='+jjj+'&dong='+word,'pg_select','width=700,height=700, toolbar=no,scrollbars=yes,resizable=no');
		return true;  
	}*/
	function jong_func( jong, j, num ) { //alert('jong:' + jong + ', j:' + j + ', num:' + num); //jong:note, j:1, num:dao1705646474
        if(jong=='link') pg_name = "";
        else if(jong=='note')  pg_name = "contents_view_menuD.php?num=" + num;
		//else if(jong=='board') pg_name = "/contents/index.php?infor=" + num;
        else if(jong=='board') pg_name = "index_bbs.php?infor=";// 등록 시점에서 알수없어서 비워두고 sys_bom_menu 등록할때 + infor 을 추가한다.; // 2024-01-18 /bbs/index5.php?infor=
        else if(jong=='photo') pg_name = "index_bbs.php?infor=";// + num;
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
	  $rs = sql_fetch_array($result);
		//m_("mode: ".$mode . ", m_type: " .$m_type);//mode: mroot, m_type: booktreeupdateM2
	  if ($rs != null) {
			$recordcount = sql_num_rows($result);	 
			$xm1 = $rs['sys_menu'];
			$xm2 = $rs['sys_submenu'];
			$sys_level = $rs['sys_level'];
			$rcnt= $rs['sys_rcnt'];
			$cnt = $rs['sys_cnt'];
			$tit = $rs['sys_subtit'];
			$sys_pg = $rs['sys_pg'];
			//if ( $mode == 'mroot' and $m_type == '' ) {
			if ( $mode == 'mroot' ) {
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
	 if ( $rs != null ) { 
		$recordcount = $rs['sys_rcnt'];
		$xm1 = $rs['sys_menu'];	
		$xm2 = $rs['sys_submenu'];	

		$xroot_chk	= $rs['sys_menutit']; 
		$xroot_cnt	= $rs['sys_rcnt'];
		$xlow_cnt	= $rs['sys_cnt'];

		if ( $mode == "mroot" ){ 
			$recordcount = $xroot_cnt;							
		} else if ( $xroot_chk == "root" ) {
			$recordcount = $xlow_cnt;
		} else {
			$recordcount = 0;
		}
	}
for ( $i=1, $j=0; $i <= 13; $i++, $j++ ) {  
     //if( $mode == 'mroot') {
     //if( $mode == 'mroot' || $xroot_level=='mroot') {
     if( $mode == 'mroot' && $xroot_level=='mroot') { // 2021-12-09
             $low_cnt = $recordcount + $i; 
             //$xdata1 = $data1 . "_r";  // 2021-11-13 변경
             $xdata1 = $sys_pg . "_r";
             
             if ( strlen($low_cnt) == 1 ){
				$xdata2 = $sys_pg . "_r" . "0" . $low_cnt; 
//				$xdata2 = $data1 . "_r" . "0" . $low_cnt; // 2021-11-13 변경
             } else {
             	$xdata2 = $sys_pg . "_r" . $low_cnt;
//             	$xdata2 = $data1 . "_r" . $low_cnt;       // 2021-11-13 변경
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

	$uid = explode('@', $H_ID); // 2024-04-05
	//$max_num = $H_ID . (time() + $j);	//$max_num - 중요 : 게시판 테이블명으로 사용됨. 
	$max_num = $uid[0] . (time() + $j);	//$max_num - 중요 : 게시판 테이블명으로 사용됨. query_ok_new.php 에서도 같은 방법 사용

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
			//$url='../t/menu/contents_view_menu.php?num=' . $max_num;
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
	if (($xm1 == $xm2) and ($sw == 1)) {
	          $sw = 2; 
	} else {
	          $sw = 1;
	}
	$root_chk = $root_chk;
	$record_cnt = $recordcount;		
?>
   	<input type="hidden" name="root_chk"	value="<?=$root_chk?>">
   	<input type="hidden" name="record_cnt"  value="<?=$record_cnt?>">

</form>
</body>
</html>
