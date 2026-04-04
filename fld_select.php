<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!$H_ID) {
		my_msg("Please Login! ");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
	if( isset($_POST['mode']) && $_POST['mode']!='' ) $mode = $_POST['mode'];
	else $mode = ''; //tab_hnmS
	if( isset($_POST['group_code']) && $_POST['group_code']!='' ) $group_code = $_POST['group_code'];
	else $group_code = '';

	if( isset($_POST['tab_hnmS']) && $_POST['tab_hnmS'] !='' ) {
		$tab_hnmS =$_POST['tab_hnmS'];
		$tab_R = explode(":", $tab_hnmS);
		$tab_enm = $tab_R[0];
		$tab_hnm = $tab_R[1];
	} else {
		$tab_hnmS = '';
		$tab_enm = '';
		$tab_hnm = '';
	}


	if( isset($_POST['param']) && $_POST['param']!='' ) $param = $_POST['param'];
	else $param = '';
	if( isset($_POST['sel']) && $_POST['sel']!='' ) $sel = $_POST['sel'];
	else $sel = '';
	if( isset($_POST['search_data']) && $_POST['search_data']!='' ) $search_data = $_POST['search_data'];
	else $search_data = '';
	if( isset($_POST['g_name']) && $_POST['g_name']!='' ) $g_name = $_POST['g_name'];
	else $g_name = '';
	//$no = $_REQUEST['no'];
	if( isset($_POST['no']) && $_POST['no']!='' ) $no = $_POST['no'];
	else if( isset($_REQUEST['no']) && $_REQUEST['no']!='' ) $no = $_REQUEST['no'];
	else $no = '';
	//m_("no:$no");
	/* 
	   ----------------------------------------------------------
	   관리자용 : pg_list_select_admin.php이 있다. 등록과 같이할 수 있다.
	   -------------------------------------------------------------
	*/
?>
<script	language="JavaScript">
<!--
	function call_pg_select( hnm, type, len, no, memo ) {
		eval ( "parent.window.opener.document.insert['fld_hnm[" + no + "]'].value=hnm");
		eval ( "parent.window.opener.document.insert['fld_type[" + no + "]'].value=type");
		eval ( "parent.window.opener.document.insert['fld_len[" + no + "]'].value=len");
		eval ( "parent.window.opener.document.insert['memo[" + no + "]'].value=memo");
			window.close();
	}
	function doSubmit()
	{
		document.xpg_select.submit();
	}
	function change_g_name_func(g_name) {
		if(g_name == 'Board') document.xpg_select.type.value='A';
		else if(g_name == 'Note') document.xpg_select.type.value='D';
		else if(g_name == 'PROGRAM') document.xpg_select.type.value='P';
		else if(g_name == 'linktree') document.xpg_select.type.value='T';
		else document.xpg_select.type.value='';

		document.xpg_select.g_name.value = g_name;
		document.xpg_select.submit();
	}
	function group_code_change_func(cd){
		index=document.xpg_select.group_code.selectedIndex;
		nm = document.xpg_select.group_code.options[index].text;
		document.xpg_select.mode.value='Search_Project';
		document.xpg_select.tab_hnmS.value='';
		document.xpg_select.group_name.value=nm;
		document.xpg_select.action="fld_select.php";
		document.xpg_select.target='_self';
		document.xpg_select.submit();
	}
	function change_table_func(pnmS){ // Relation_Table_func
		document.xpg_select.mode.value="SearchTAB";
		document.xpg_select.action="fld_select.php";
		document.xpg_select.submit();
	}
-->
</script>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-App. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=$logo25a?>">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0' bgcolor='black'>
<table width="710" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="600" colspan='3'>
	<form method="post" action="fld_select.php" name="xpg_select">	
		<input type="hidden" name="no" value='<?=$no?>' >
		<input type="hidden" name="type" value='' >
		<input type='hidden' name='g_name'>
		<input type='hidden' name='group_name'>
		<input type='hidden' name='mode'>
		
		
		<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0" height="25"><tr>
				<td rowspan="2" width="330" align="right" height="25" valign='center'>
				<font color='yellow'>Search:<input type="text" name="search_data" size="20" maxlength="20" value='<?=$search_data?>'></td>
				<td align="left" width="230" valign='center'>
				<input type='button' value='Confirm' onclick='doSubmit()'>
			  </td></tr></table> -->
<center>
		<div>
		<span>
		<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered.' "; ?> >
			<option value=''>Project</option>
<?php
			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );
			while($rs = sql_fetch_array($result)) {
				$chk = '';
				if( $rs['group_code']==$group_code) $chk =' selected ';
?>
				<option value='<?=$rs['group_code']?>' <?php echo $chk; ?>><?=$rs['group_name']?></option>
<?php
			}
?>
		</select>
		</span>

		<span bgcolor='#ffffff'>
		<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func(this.value);" style='width:250px;height:30px;background-color:#FFDF6E;border:1 solid black' >
<?php
		if( $mode =='SearchTAB') echo "<option value='$tab_hnmS' selected >$tab_hnm</option>";
		else echo "<option value=''>2.Select Table</option>";
		$sql = "SELECT * from {$tkher['table10_table']} ";
		if( $group_code !='' ) {
			$sql = $sql . " where group_code='$group_code' and userid='$H_ID' and fld_enm='seqno' order by upday desc";
		} else {
			$sql = $sql . " where userid='$H_ID' and fld_enm='seqno' order by upday desc";
		}
		$result = sql_query( $sql );
		while( $rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php if($rs['tab_hnm']==$tab_hnm) echo " selected "; ?> title='table code:<?=$rs['tab_enm']?>'><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</SELECT>
		</span>
		</div>




		<div>
			<select name="param" style="background-color:gray;color:white;height:24;">
<?php
if( $param !='') {
	//if( $param == 'group_name') echo "<option value='$param' >Project Name</option>";
	//else if( $param == 'tab_enm') echo "<option value='$param' >Table Name</option>";
	//else if( $param == 'fld_hnm') echo "<option value='$param' >Column Name</option>";
	echo "<option value='$param' >Column Name</option>";
} else echo "<option value='fld_hnm' selected >Column Name</option>";
?>
				<!-- <option value="group_name" style="background-color:gray;color:white;">Project Name</option>
				<option value="tab_hnm"    style="background-color:gray;color:white;">Table Name</option> -->
				<option value="fld_hnm"    style="background-color:gray;color:white;">Column Name</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="=" <?php if( $sel=='=') echo " selected ";?> >=</option>
				<option value="like" <?php if( $sel=='like') echo " selected ";?> >Like</option>
			</select>
			<input type="text" name="search_data" size="20" maxlength="20" value='<?=$search_data?>'>
			<input type='button' value='Search' onclick="javascript:doSubmit();" >
		</div>


	</form>
  </td>
</tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
<tr align='center' style='color:yellow;'>
   <td>Project</td>
   <td>table</td>
   <td>field</td> 
   <td>type</td>
   <td>length</td>
</tr>
<?php
	$ls = "SELECT * FROM {$tkher['table10_table']} ";
	$Where = " where fld_enm!='seqno' ";
	if( $group_code !='') $Where = $Where . " and group_code='$group_code' ";
	if( $tab_hnm !='') $Where = $Where . " and tab_hnm='$tab_hnm' ";
	if( $search_data !='') {
		if( $sel == '=') $Where = $Where . " and fld_hnm='$search_data' ";
		else if( $sel == 'like') $Where = $Where . " and fld_hnm like '%".$search_data."%' ";
	}
	$Order = " order by fld_hnm, upday desc ";
	$ls = $ls . $Where . $Order;

	/*if ( !$g_name && !$search_data ) {
		 $ls = $ls . $Where . $Order;
	} else if ( !$search_data ) {
		 $ls = $ls . $Where . $Order;
	} else if ( $search_data ) {
		$ls = $ls . $Where . $Order;
	} else {
		 $ls = $ls . $Where . $Order;
	}*/
	$result = sql_query(  $ls );
	while ( $rs = sql_fetch_array( $result ) ) {
            if($rs['fld_hnm']=='seqno') continue;
			$project_name	= $rs['group_name'];
			$tab_hnm	= $rs['tab_hnm'];
			$fld_hnm	= $rs['fld_hnm'];
			$fld_type	= $rs['fld_type'];
			$fld_len	= $rs['fld_len'];
			$if_type	= $rs['if_type'];
			$if_data	= $rs['if_data'];
			$relation_data= $rs['relation_data']; 
			$memo		= $rs['memo'];
?>
		<tr style='color:white;fontsize:32px;'>
		  <td><?=$project_name?></td>
		  <td><?=$tab_hnm?></td>
		  <td title='if_data:<?=$if_data?>'>
			   <a href="javascript:call_pg_select('<?=$fld_hnm?>','<?=$fld_type?>', '<?=$fld_len?>', '<?=$no?>', '<?=$memo?>' )"><font color='yellow' size='3'><?=$fld_hnm?></a> </td>
		  <td><?=$fld_type?></td>
		  <td><?=$fld_len?></td>
		</tr>
<?php
	}
?>
  </td>
</tr>
<tr align="center">
  <td height="30" colspan='5'>
   <a href="javascript:self.close()">
    <font color='cyan' size='3'>[ * CLOSE * ]</a></td>
</tr>
</table>
</body>
</html>
