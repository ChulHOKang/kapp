<?php 
	include_once('../tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;
	/*
		tree_menu_update.php : tree_menu_updateM.php, tree_menu_updateM2.php 에서 콜. 중요.
		                     : root 하단의 수정할 목록을 출력.
		treebom_update2_new_menu.php : tree menu 용.
		treebom_update2_new.php : tree,  book tree, board tree 를 변경등록 작업시에 공통으로 여기에서 처리한다. : 중요!
		run : treebom_updw_new.php 
				include "./tree_create_new_bbstree.php";
				include "./tree_create.php";
				include "./tree_create_new.php";
				//T:  m_type:cratreeupdate
				//B:  m_type:booktreeupdate
				//G : m_type:bbstreeupdate 
	*/
	if (!$from_session_id) {
		my_msg(" Please login.");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	$mode	= $_POST['mode'];
	//m_("-update sys_pg_root:" . $_REQUEST['sys_pg_root']);
	if( isset($_REQUEST['sys_pg_root']) ) {
		$sys_pg_root= $_REQUEST['sys_pg_root'];
		$data	= $_REQUEST['data'];
		$data1	= $_REQUEST['data1'];
		$mid	= $_REQUESTST['mid'];
		//m_("tree_menu_update - mid:$mid sys_pg_root:$sys_pg_root, data:$data, data1:$data1, mode:$mode ");
	} else if( isset($_POST['sys_pg_root']) ) {
		$sys_pg_root= $_POST['sys_pg_root'];
		$data	= $_POST['data'];
		$data1	= $_POST['data1'];
		$mid	= $_POST['mid'];
		//m_("tree_menu_update - mid:$mid sys_pg_root:$sys_pg_root, data:$data, data1:$data1, mode:$mode ");
	}
	if( $mode == 'mroot' ){ // Update job select click - 여기로
		$sys_pg		= $_REQUEST['data'];
		$sys_pg_root= $_REQUEST['data'];
		//m_($mode . ", sys_pg:".$sys_pg . ", sys_pg_root:" . $sys_pg_root); // mroot, sys_pg:dao1642213611, sys_pg_root:dao1642213611
		if( $_REQUEST['data'] !== $_REQUEST['data1'] ) {
			$sys_pg		= $_REQUEST['sys_pg_root'];
			//$xsys_pg	= $_REQUEST['sys_pg_root'];
			$sys_pg_root= $_REQUEST['sys_pg_root'];
		}
	} else {
		if( isset($sys_pg_root) ) {
			$sys_pg_root= $_REQUEST['sys_pg_root'];
			$sys_pg		= $_REQUEST['sys_pg_root'];
			//$xsys_pg	= $_REQUEST['sys_pg_root'];
		} else my_msg(" ERROR : sys_pg_root:$sys_pg_root, data:$data, data1:$data1, mode:$mode ");

	}
	$first_mode	= $_POST['first_mode'];
	$make_type	= $_POST['make_type'];
	$m_type	    = $_POST['m_type'];
	//m_("tree_menu_update - make_type:$make_type, m_type:$m_type ");

	$sql = "select * from {$tkher['sys_menu_bom_table']} where sys_pg ='$sys_pg_root' and sys_submenu = '$sys_pg_root' and sys_level='mroot' order by sys_disno";
	$result = sql_query( $sql);	
	$rs   = sql_fetch_array($result);
	$mid  = $rs['sys_userid']; 
	$gtit = $rs['sys_subtit'];  
	$mt   = $rs['tit_gubun']; 
	//if($mt == 'T')			$m_type='booktreeupdateM';//cratreeupdate
	//else if($mt == 'B')		$m_type='booktreeupdateM';
	//else if($mt == 'M')		$m_type='booktreeupdateM';
	//else if($mt == 'G')		$m_type='booktreeupdateM';//bbstreeupdate
	//else {
	//	my_msg("ERROR type:$mt, ");
	//	$m_type='booktreeupdateM';
	//}
	$my_page_run=get_session("my_page_run");	
	set_session("my_page_run", "");
	//my_msg("222 m_type:$m_type, make_type:$make_type, my_page_run:$my_page_run ");

	if ( $from_session_id !== $mid ) {
		my_msg(" You do not have permission to work.");// \\n 작업권한이 없습니다. 
		$rungo = "./" . $mid . "/". $sys_pg_root . "_runf.html";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
?>
<html>   
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Appgenerator Tree Menu. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<script language=javascript> 
<!--
	function up_date(mtype){
		//alert('tree_menu_update mtype:'+mtype); //return;
		var ins = window.confirm(" Do you want to change it?"); // \n 변경하시겠습니까? 
		if (ins)
		{
			document.sys_bom.m_type.value=mtype; //mtype=booktreeupdate
			document.sys_bom.make_type.value=mtype; //mtype=booktreeupdate
			document.sys_bom.action="treebom_updw_new_menu.php"; 
			document.sys_bom.submit();
		}
	}
	function root_up_date(){
		document.sys_bom.mode.value='mroot';
		//document.sys_bom.action="treebom_update2_new_menu.php";
		document.sys_bom.action="tree_menu_update.php";
		document.sys_bom.submit(); 
	}
	function del_ete(type,sys_pg,menu,submenu,book_num){
		var del = window.confirm(" Cra Tree Data Delete OK? ");
		if (del)
		{
		document.sys_bom.mode.value='delete';
		document.sys_bom.m_type.value=type;
		document.sys_bom.book_num.value=book_num;
		document.sys_bom.sys_pg.value=sys_pg;
		document.sys_bom.sys_menu.value=menu;
		document.sys_bom.sys_submenu.value=submenu;
		document.sys_bom.action="treebom_delw_new_menu.php";
		document.sys_bom.submit();
		}
	}

	function contents_sel( jjj ) {
		var word = ''; 
		window.open('./ .php?no2='+jjj , 'pg_select','width=700,height=700, toolbar=no,scrollbars=yes,resizable=no');
		return true;  
	}
-->
</script>
<?php  
		//m_("tree_menu_update mode:" . $_REQUEST['mode']);
	  $first = $sys_pg_root."_r";
      if ( $_REQUEST['mode'] !== 'rowlevel' ) {
		//m_("no rowlevel mode:" . $_REQUEST['mode']);
			$sql= " select * from {$tkher['sys_menu_bom_table']} where sys_pg='$sys_pg_root' and (sys_level='mroot' or sys_level='sroot')  order by sys_disno";
      } else if ( $mode == 'mroot' ) {
			$sql= " select * from {$tkher['sys_menu_bom_table']} where sys_pg='$sys_pg_root' and (sys_level='mroot' or sys_level='sroot')  order by sys_disno";
      } else if ( $first_mode == 'delete' ) {
		  m_("delete - sys_pg_root:$sys_pg_root");
      } else if ( $first_mode == 'root' ) {
			$m_level = "up_root";
			$sql= " select * from {$tkher['sys_menu_bom_table']} where ( sys_pg = '$sys_pg_root' and (sys_menu = '$first' or (sys_menu = '$data' and sys_menutit='mroot'))) order by sys_disno, sys_pg, sys_menu, sys_submenu ";
	  } else {
			$sql= " select * from {$tkher['sys_menu_bom_table']} where ( (sys_pg = '$sys_pg_root') and (sys_submenu = '$data1')) or ( (sys_pg = '$sys_pg_root') and (sys_menu = '$data1') ) order by sys_disno, sys_pg, sys_menu, sys_submenu ";
	  }
	  $result = sql_query( $sql);
?>
<form method='post' name='sys_bom' enctype="multipart/form-data">
	<input type='hidden' name="book_num"		value="" >
	<input type='hidden' name="make_type"		value="<?=$make_type?>" >
	<input type='hidden' name="m_type"		value="<?=$m_type?>" >
	<input type='hidden' name="mode"			value="<?=$mode?>" >
	<input type='hidden' name="first_mode"	value="root" >
	<input type='hidden' name="sys_pg"		value="<?=$sys_pg_root?>" >
	<input type='hidden' name="sys_menu"		value='' >
	<input type='hidden' name="sys_submenu"	value='' >
	<!-- <input type='hidden' name="xsys_pg"		value="<?=$sys_pg_root?>" > -->
	<input type='hidden' name="sys_pg_root"	value="<?=$sys_pg_root?>" > 
	<input type='hidden' name="data"			value="<?=$data?>" >
	<input type='hidden' name="data1"			value=<?=$data1?> >
	<input type='hidden' name="mid"			value=<?=$mid?> >
	<input type='hidden' name="gtit"			value=<?=$gtit?> >
	<input type='hidden' name="mt"			value=<?=$mt?> >
	<input type='hidden' name="m_level"		value=<?=$m_level?> >
	<input type='hidden' name="my_page_run"	value=<?=$my_page_run?> >

<center><font color=green><h3>Change Link Tree menu <br> Click on the left menu for individual changes 
</h3></font></center><!-- [개별변경은 왼쪽메뉴를 클릭] -->

<body leftmargin=0 topmargin=0 bgcolor=black> 
	<center>
<table border=1 cellspacing=0 cellpadding=0 bgcolor=black> 
	<tr>
		<th><font color=cyan <?php echo "title='Set output order. The first line is unchangeable! ' "; ?>> NO </th><!-- \n 출력순서 설정, 첫라인은 변경불가! -->
		<th><font color=cyan>Find</th>
		<th><font color=cyan>Title </th>
		<th><font color=cyan> Link URL </th>
		<th><font color=cyan> Memo </th>
		<th><font color=cyan>Delete</th>
	</tr>
<?php
	$recordcount = sql_num_rows($result);  

	$j=0;
	while ( $rs = sql_fetch_array($result) ) {
		$mid		= $rs['sys_userid'];
		$xbook_num	= $rs['book_num'];
    	$xseqno		= $rs['seqno'];
    	$Rsys_pg	= $rs['sys_pg'];
    	$xmenu		= $rs['sys_menu'];
    	$xsubmenu	= $rs['sys_submenu'];
    	$xsubtit	= $rs['sys_subtit'];
    	$xlink		= $rs['sys_link'];	
		$xlevel		= $rs['sys_level'];
		$xmenutit	= $rs['sys_menutit'];	
		$xrcnt		= $rs['sys_rcnt'];
		$xcnt		= $rs['sys_cnt'];
		$xdisno		= $rs['sys_disno'];
		$xfile		= $rs['sys_file'];
		$xmemo		= $rs['sys_memo'];

		if ( $j == 0 ) $main_level = $rs['sys_level'];

?>
	<tr valign=middle > 
						<input type='hidden' name="sys_userid_<?=$j?>"		value='<?=$rs['sys_userid']?>' >
						<input type='hidden' name="seqno_<?=$j?>"		value='<?=$rs['seqno']?>' >
						<input type='hidden' name="sys_menu_<?=$j?>"	value='<?=$rs['sys_menu']?>' >
						<input type='hidden' name="sys_submenu_<?=$j?>" value='<?=$rs['sys_submenu']?>' >
						<input type='hidden' name="sys_subtit_old_<?=$j?>" value='<?=$rs['sys_subtit']?>' >
						<input type='hidden' name="sys_pg_job_<?=$j?>" value='<?=$rs['sys_pg']?>' >
						<input type='hidden' name="book_num_<?=$j?>" value='<?=$rs['book_num']?>' >
						<input type='hidden' name="type_<?=$j?>" value='<?=$rs['tit_gubun']?>' >
      
<?php
	if ( $mode == 'mroot') {	  
?>
	  <td><input type='text' name="sys_disno_<?=$j?>" size='3' value='<?=$xdisno?>' style="background-color:black;ime-mode:active;height:30;color:yellow" <?php if($j==0) echo 'readonly'; ?> > </td>
	  <td align='left' size='10'>
		<input type='button' value="Search" onClick="javascript:contents_sel(<?=$j?>)" style="background-color:<?php if($j==0) echo 'red'; else echo 'gray';?>;ime-mode:active;height:30;color:black" <?php if($j==0) echo 'readonly'; ?>>
	  </td> 
      <td> <input type='text' name="sys_subtit_<?=$j?>" size='20' value="<?=$xsubtit?>" title='mid:<?=$mid?>' style="background-color:<?php if($j==0) echo 'red'; else echo 'black';?>;ime-mode:active;height:30;color:yellow" <?php if($j==0) echo 'readonly'; ?>> </td>
      <td> <input type='text' name="sys_link_<?=$j?>" size='60' maxlength='120' value='<?=$xlink?>' style="background-color:<?php if($j==0) echo 'red'; else echo 'black';?>;ime-mode:active;height:30;color:yellow" <?php if($j==0) echo 'readonly'; ?>> </td>
<?php
    } else {	  
	  if ( $j == 0 and $data==$data1) {
?>
	       <td align=center> <input type='text' name="sys_disno_<?=$j?>" size='3' value='<?=$xdisno?>' readonly style="background-color:red;ime-mode:active;height:30;color:yellow;"> </td>
		  <td align='left' size='10'>
				<input type='button' value="search" onClick="" style="background-color:red;ime-mode:active;height:30;color:yellow;" readonly>
		  </td> 
		  <td align='left'> <input type='text' name="sys_subtit_<?=$j?>" size='20' maxlength='100' value="<?=$xsubtit?>" title='mid:<?=$mid?>'  style="background-color:black;ime-mode:active;height:30;color:yellow;" readonly> </td>
<?php
	  } else {
?>
       <td align=center> <input type='text' name="sys_disno_<?=$j?>" size='3' value='<?=$xdisno?>' style="background-color:black;ime-mode:active;height:30;color:yellow;" <?php if($j==0) echo 'readonly'; ?> > </td>
	  <td align='left' size='10'>
			<input align=center type='button' value="find" onClick="javascript:contents_sel(<?=$j?>)" style="ime-mode:disabled; FONT-SIZE:10pt; FONT-FAMILY:verdana; BACKGROUND-COLOR:black; color:yellow;;">
	  </td> 
	  <td align='left'> <input type='text' name="sys_subtit_<?=$j?>" size='20' maxlength='100' value="<?=$xsubtit?>" title='mid:<?=$mid?>'  style="background-color:black;ime-mode:active;height:30;color:yellow;"> </td>
<?php    } ?>
      <td align='left'> <input type='text' name="sys_link_<?=$j?>" size='60' maxlength='120' value='<?=$xlink?>' style="background-color:black;ime-mode:active;height:30;color:yellow;"> </td>

<?php
	}		
	if ( $xlevel == "mroot" ) {
?>
				<input type='hidden' name="sys_level_<?=$j?>" value='<?=$xlevel?>' > 
				</td>
<?php				
	} else if ( $xmenutit == "root" ) {
?>
				<input type='hidden' name="sys_level_<?=$j?>" value='<?=$xmenu?>' > 
				</td>
<?php				
	} else {
?>
				<input type='hidden' name="sys_level_<?=$j?>" value='<?=$xmenutit?>' > 
				</td>
<?php
	}
?>
      <td align='left'><input type='text' name="sys_memo_<?=$j?>" size='19' maxlength='250' value='<?=$xmemo?>' style="background-color:black;ime-mode:active;height:30;color:yellow;"> </td>

	  <!-- --------------- tree Delete-------------- -->
	  <td>
	  <?php if($rs['sys_userid']==$H_ID){  ?>
		<input type='button' name='del' onclick="javascript:del_ete('<?=$m_type?>','<?=$Rsys_pg?>','<?=$xmenu?>','<?=$xsubmenu?>','<?=$xbook_num?>');" value="delete" style="background-color:red;color:yellow;height:25;" <?php echo "title='$xsubtit \n $Rsys_pg-$xseqno\n $xmenu \n $xsubmenu \n Delete the tree. Be careful!'"; ?> >
	  <?php } else{ ?>
	  <?php }       ?>
	  </td>
	</tr>
<?php         
		$j = $j + 1;
	} //while end
?> 
 </table>
<br>
<?php 
	if ( $main_level == "mroot" and $m_level != "up_root"  ) {
?>
		<input type='button' name=upd onclick="javascript:up_date('<?=$m_type?>');" value=" (Save) " style="border-style:;background-color:blue;color:yellow;height:25;">

		<!-- <font color=red > <br>
		※ 최상위 메뉴항목 변경은 트리 변경에서 가능합니다. 첫항목은 삭제를 하실수 없습니다.
		</font> -->
<?php
	} else if ( $m_level == "up_root" ) {
?>
		<input type='button' name='upd' onclick="javascript:up_date('<?=$m_type?>');" value=" <Save> ">
		<br> <font color=red >※ You can not delete the top level menu. <br></font>
<?php   
	} else { 
?>
		 <input type='button' name='upd' onclick="javascript:up_date('<?=$m_type?>');" value=" [Save] " style="border-style:;background-color:green;color:yellow;height:30;">
<?php 
     }
?>

<?php
	if ( $_REQUEST['mode'] == 'rowlevel' ) {
?>
		 <input type='button' name='root_dis' onclick="javascript:root_up_date(this.form);" value="Main List" title='Print the main list.' style="border-style:;background-color:blue;color:yellow;height:25;">
<?php
	}
	$root_chk = $root_chk;
	$record_cnt = $recordcount;
?>
   	<input type="hidden" name="root_chk"	value="<?=$root_chk?>">
   	<input type="hidden" name="record_cnt"  value="<?=$record_cnt?>">
</form>
</body></html>

