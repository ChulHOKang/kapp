<?php
	include_once('../tkher_start_necessary.php');
	/* 
		treebom_updw_new_menu.php : call - tree_menu_guest.php -> tree_menu_update.php에서 call.
		: tree 메뉴 내용 변경 작업,
		call : treebom_update2_new.php
		run : tree_create.php : Note Tree Source Create.
	*/
	$H_ID	= get_session("ss_mb_id");
	$url= KAPP_URL_T_; // '/';	//$PHP_SELF;
	if ( !$H_ID ) {
		echo "<script> alert('Login is required.');</script>";
		echo "<script>window.open('$url', '_top', '');</script>";
		exit;
	}
	$H_LEV=$member['mb_level'];
	$H_EMAIL   = $member['mb_email'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$root_tit= $_POST['gtit'];
	$data	= $_POST['data'];
	$data1	= $_POST['data1'];
	$sys_pg	= $_POST['sys_pg'];
	$sys_pg_root= $_POST['sys_pg_root'];
	$mode	= $_POST['mode'];
	$m_type = $_POST['m_type'];
	$make_type = $_POST['make_type'];
	$gtit = $_POST['gtit'];
	$mt   = $_POST['mt']; 
	$my_page_run = $_POST['my_page_run']; 
	$sql="select * from {$tkher['sys_menu_bom_table']} where sys_pg ='$sys_pg_root' and sys_submenu = '$sys_pg_root' and sys_level='mroot'";
	$result = sql_query( $sql);	
	$rs     = sql_fetch_array($result);
	$mid    = $rs['sys_userid'];
	if( $H_ID !== $mid && $H_LEV < 8 ) {
		m_(" You do not have permission to work. ");
		if($mt=='M') $rungo = KAPP_URL_T_ . "/menu/" . $rs['sys_userid'] . "/". $sys_pg_root . "_runf.html";
		else $rungo = KAPP_URL_T_ . "/menu/" . $rs['sys_userid'] . "/". $sys_pg_root . "_runf.html"; 
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	$sys_subtit_ = "sys_subtit_0";
	$sys_subtit	= $_REQUEST[$sys_subtit_];
	if( isset($sys_subtit) ) {
  ?>
<html>
<form name='kapp_sys_bom' method='post' enctype="multipart/form-data">
		<table border=1 >
			<tr>
				<th> title </th>
				<th> URL </th>
			</tr>
<?php 
		for( $intloop = 0; $sys_subtit; $intloop++ ) {
			$sys_subtit_ = "sys_subtit_" . $intloop;
			if( isset($_POST[$sys_subtit_]) && $_POST[$sys_subtit_]!='' ) $sys_subtit = $_POST[$sys_subtit_];
			else $sys_subtit = "";
			if( $sys_subtit != "") { 
				$sys_disno	= "sys_disno_" . $intloop;
				$seqno	    = "seqno_" . $intloop;	
				$sys_subtit = "sys_subtit_" . $intloop;
				$sys_pg_job = "sys_pg_job_" . $intloop;
				$book_num   = "book_num_" . $intloop;
				$sys_link	= "sys_link_" . $intloop;
				$sys_memo	= "sys_memo_" . $intloop;
				$typex	    = "type_" . $intloop;
				$sys_subtit_old = "sys_subtit_old_" . $intloop;
				$sys_disno	= $_POST[$sys_disno];	
				$seqno	    = $_POST[$seqno];	
				$sys_subtit	= $_POST[$sys_subtit];
				if( $intloop == 0 ) $sys_subtit_group = $sys_subtit;
				$sys_pg_job	= $_POST[$sys_pg_job]; 
				$book_num	= $_POST[$book_num];
				$sys_link	= $_POST[$sys_link];
				$sys_memo	= $_POST[$sys_memo];
				$typex	    = $_POST[$typex];
				$sys_subtit_old	= $_POST[$sys_subtit_old];
                if ( $sys_link == "" ) {
                     $sys_link = "http://";
                }
				echo "<tr><td>".$sys_subtit."</td>";
				echo "<td>".$sys_link."</td></tr>";
                $sql = " update {$tkher['sys_menu_bom_table']} set sys_subtit='$sys_subtit', sys_link='$sys_link', sys_disno='$sys_disno', tit_gubun='$typex', sys_memo='$sys_memo' where seqno='$seqno' "; 
				sql_query( $sql);
				switch( $typex ){
					case 'T' : $type_nm='cratree'; break;
					case 'B' : $type_nm='BOOK';    break;
					case 'M' : $type_nm='menu';    break;
					case 'N' : $type_nm='Note';    break;  
					case 'G' : $type_nm='BBSTREE'; break;
					case 'U' : $type_nm='LINK';    break;
					default  : $type_nm='gita';    break;
				}
				$sqla = "update {$tkher['job_link_table']} set user_name='$sys_subtit', job_name='$root_tit', job_addr='$sys_link', jong='$typex', job_group='$type_nm', memo='$sys_memo' where user_id='$H_ID' and num='$sys_pg' and aboard_no='$book_num' "; 
				sql_query( $sqla );  
				if( $typex == 'G' ) {
					$sqlb = "update {$tkher['admin_tkher_bbs_table']} set comment='$sys_subtit', top3='$sys_subtit', memo='$sys_memo' where make_userid='$H_ID' and name='$book_num' ";  
					sql_query( $sqlb );  
				}
           } //if
		} //for
?>	
		</table>
	<input type='hidden' name="mode"		value="" >
	<input type='hidden' name="sys_pg"		value="<?=$sys_pg?>" >
	<input type='hidden' name="sys_pg_root"		value="<?=$sys_pg_root?>" >
	<input type='hidden' name="open_mode"		value="on" >
	<input type='hidden' name="mid"		value="<?=$mid?>" >
	<input type='hidden' name="sys_subtit"		value="<?=$sys_subtit?>" >
	<input type='hidden' name="sys_jong"		value='<?=$sys_jong?>' >
	<input type='hidden' name="board_num"	value='<?=$board_num?>' >
	<input type='hidden' name="sys_link"	value='<?=$sys_link?>' >
<?php
			$sys_userid_0 = "sys_userid_0";
			$mid	= $_POST[$sys_userid_0];
 			$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg.'&open_mode=on&mid='.$mid.'&sys_subtitS='.$sys_subtit . "&num=" . $max_num . "&sys_jong=" . $sys_jong . "&board_num=" . $board_num . "&sys_link=" . $sys_link;
			//echo "<script>return_in_sert(); </script>";  
			echo "<script>window.open('$rungo', '_top', ''); </script>";
	} else {
?> 
		<p><center> update error. </center> 
			<input type='button' value='return' onclick='history.back()'>
<?php
    } // if( isset($sys_subtit) )
//https://www.bizinfo.go.kr/sii/siia/selectSIIA200View.do?hashCode=&rowsSel=&rows=&cpage=&cat=&schPblancDiv=&schJrsdCodeTy=&schWntyAt=&schAreaDetailCodes=&schEndAt=&orderGb=&sort=&preKeywords=&condition=&condition1=&keyword=
?> 

<script language=javascript> 
<!-- 
	function return_in_sert(){ // Save after return
		document.kapp_sys_bom.target ='_blank';  
		document.kapp_sys_bom.action="tree_run.php"; 
		document.kapp_sys_bom.submit();
		//location.replace(location.href);
	} 
-->
</script>
</html>