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
	$search_data = $_POST['search_data'];
	$g_name = $_REQUEST['sel_g_name'];
	$no = $_REQUEST['no'];
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
-->
</script>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
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
		<table width="100%" border="0" cellspacing="0" cellpadding="0" height="25">
			<tr>
				<td rowspan="2" width="330" align="right" height="25" valign='center'>
				<font color='yellow'>Search:<input type="text" name="search_data" size="20" maxlength="20" value='<?=$search_data?>'></td>
			  <td align="left" width="230" valign='center'>
				<input type='button' value='Confirm' onclick='doSubmit()'>
			  </td>
			</tr>
		</table>
	</form>
  </td>
</tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
<tr align='center' style='color:yellow;'>
   <td>group</td>
   <td>table</td>
   <td>field</td> 
   <td>type</td>
   <td>length</td>
</tr>
<?php
	if ( !$g_name && !$search_data ) {
		 $ls = "SELECT * FROM {$tkher['table10_table']} where fld_enm!='seqno' order by fld_hnm, upday desc";
	} else if ( !$search_data ) {
		 $ls = "SELECT * FROM {$tkher['table10_table']} where fld_enm!='seqno' order by fld_hnm, upday desc";
	} else if ( $search_data ) {
		 $ls = "SELECT * FROM {$tkher['table10_table']} WHERE fld_hnm='$search_data' order by upday desc";
	} else if ( $g_name ) {
		 $ls = "SELECT * FROM {$tkher['table10_table']} WHERE group_name='$g_name' order by upday desc";
	} else {
		 $ls = "SELECT * FROM {$tkher['table10_table']} where fld_enm!='seqno' order by fld_hnm, upday desc";
	}
	$result = sql_query(  $ls );
	while ( $rs = sql_fetch_array( $result ) ) {
            if($rs['fld_hnm']=='seqno') continue;
			$group_name	= $rs['group_name'];
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
		  <td><?=$group_name?></td>
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
