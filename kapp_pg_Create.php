<?php
	include_once('./tkher_start_necessary.php');
	/*
		kapp_pg_Create.php : app_pg50RC.php    : table_pg50RC.php copy. : 
		:  PG_curl_send() 
		: create and update Separate.
		: PC:app_pg50RC.php
		: PC:app_pg50RU.php
		: app_pg50RC_Test.php :test pg
	*/
	$H_ID	= get_session("ss_mb_id");
	if( !$H_ID || $H_ID =='' )	{
		m_("You need to login. ");
		$url="./";
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_LEV =$member['mb_level'];
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<?php
		if( isset($_POST['mode']) ) $mode		= $_POST['mode'];
		else  $mode = "";
		
	if( isset($_SESSION['project_nmS']) ) {
		$project_nmS = $_SESSION['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	} else {
		$project_nmS = '';
		$project_name= "";
		$project_code= "";
	}
	if( isset($_SESSION['tab_hnmS']) ) {
		$tab_hnmS = $_SESSION['tab_hnmS'];
		$tcd_nm = explode(":", $tab_hnmS );
		$tab_enm	= $tcd_nm[0];
		$tab_hnm	= $tcd_nm[1]; 
	} else {
		$tab_hnmS = '';
		$tab_enm= "";
		$tab_hnm= "";
	}

		if( isset($_POST['seqno']) ) $seqno		= $_POST['seqno'];
		else  $seqno = "";
		if( isset($_POST['pg_code']) ) $pg_code		= $_POST['pg_code'];
		else  $pg_code = "";
		if( isset($_POST['pg_name']) ) $pg_name		= $_POST['pg_name'];
		else  $pg_name = "";
		if( isset($_POST['tab_hnm']) ) $tab_hnm		= $_POST['tab_hnm'];
		else  $tab_hnm = "";
		if( isset($_POST['pg_codeS']) ) $pg_codeS		= $_POST['pg_codeS'];
		else  $pg_codeS = "";
?>
<body leftmargin="0" topmargin="0">
 
<script language="JavaScript"> 
<!--
 	var frealname	= ''
	var isEdited    = false
	var delList		= ''
	var smode		= false
	var start, end, grpStr
	function fnclist_onclick() {
		for (var k=0 ; k < makeform.fnclist.options.length ; k++)
		{
		 if (makeform.fnclist.options[k].text != "" && makeform.fnclist.options[k].selected) {
				var fid = makeform.fnclist.options[k].value
				fid = fid.substring(0,fid.indexOf("!:"))
		 }
		}
	}
	function getfname(str) {
		if (str.indexOf("]") > 0) {
			frealname = str.substring(0, str.indexOf("]")+1)
			str = str.substr(str.indexOf("]")+2)
		}
		return str
	}
	function Pg_Dup_Check()	{
		pg_name = document.makeform.pg_name.value;
		if( pg_name == ''){
			alert("Please enter the program name!");
			document.makeform.pg_name.focus();
			return false;
		}
		var item_cnt = makeform.pg_codeS.options.length; 
		for (i = 0; i < item_cnt; i++) {
				var str_val = makeform.pg_codeS.options[i].value;
				var pgnm = makeform.pg_codeS.options[i].text;
				if(pg_name == pgnm){
					alert("Program name is duplicate. Please use a different name!");
					document.makeform.pg_name.focus();
					return false;
				}
		}
		return true;
	}
	function k_func_ok(r,j, ok){
		//alert("k_func_ok - r: " + r + ", j: " + j + ", ok: " + ok);
		return;
	}
	function r_func(r,qna){
		qna1 = qna.split('^');
		len = qna1.length;
		ss="";
		for(i=0;i<len;i++){
			rr = qna1[i].split('|');
			lenj = rr.length-2;
			ok = rr.length-1;
			//ss+=" &#160; <p><form><div>"+(i+1)+". "+rr[0]+"</div> ";
			ss+=" &#160; <p><div>"+(i+1)+". "+rr[0]+"</div> ";
			for(k=0,j=1; k < lenj; k++, j++){
				ss+=" &#160; <label><span><input type='radio' name='qna' onclick=\"k_func_ok('"+ rr[j] +"', "+j+", "+rr[ok]+")\" value="+ rr[j] +">" +j+'. '  + rr[j]+" &#160; </span></label><br>";
			}
		}
		ss+="</p>";
		//ss+="</form></p>";
		here.innerHTML=ss;
	}
	function Print_item_func( ss, qna ){
		if(!ss) r_func('A', qna);
		else here.innerHTML = ss;
	}
	function column_list_onclickAA( j ){
		//alert("AA, j: "+j );
	}
	function column_list_onclickA( ss, j ){
		//alert("A, j: "+j +", ss: " + ss);
	}
	function column_list_onclickA( ss, j ){
	}

	function downItemA() {
	}
	function upItemA() {
	} 
	function del_func() {
	}
	function ifcheck_onclickA(r, seq) {
	} 
	function Apply_button() {
	}
	function titlechange_btncfm_onclickA() {
	}
	function Save_and_Run(pg)
	{
		pg_name = document.makeform.pg_name.value;
		if( !pg_name ) {
			alert(" Please enter the program name!");
			document.makeform.pg_name.focus();
			return false;
		}
		var tab_selind = makeform.tab_hnmS.selectedIndex; 
		var tab_val    = makeform.tab_hnmS.options[tab_selind].value;
		var tabnm      = makeform.tab_hnmS.options[tab_selind].text;
		if( !tab_selind && !tabnm) {
			alert(tab_selind+" :  Please select a table! ");
			document.makeform.pg_name.focus();
			return false;
		}
		var str_array="";
		var colnm = document.getElementsByName('column_list');
		var st = "";
		var item_cnt = colnm.length;
		for (i = 0; i < item_cnt; i++) {
			colnm_value = colnm[i].value;
			st = colnm_value.split('|');
			str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
		} 
		document.makeform.item_array.value = str_array;
		document.makeform.mode.value = 'pg_new_create2'; 
		document.makeform.mode_call.value = 'kapp_pg_Create'; //app_pg50RC
		document.makeform.action='tkher_program_run.php';
		document.makeform.target='tab_pg_list';
		document.makeform.submit();
	}
	function Project_Update(mode){
		var p_selind = makeform.project_nmS.selectedIndex; 
		var p_val    = makeform.project_nmS.options[p_selind].value;
		var p_nm     = makeform.project_nmS.options[p_selind].text;
		if( p_nm=='1.Select Project' || p_nm=='' ){
			alert(p_selind+" : p_val: " + p_val + ", p_nm:" + p_nm + " Please select a project! ");
			return;
		} else {
			var tab_selind = makeform.tab_hnmS.selectedIndex; 
			var tab_val    = makeform.tab_hnmS.options[tab_selind].value;
			var tabnm      = makeform.tab_hnmS.options[tab_selind].text;
			if( tabnm == '1.Select table') {
				alert(tab_selind+" :  Please select a table! ");
				document.makeform.pg_name.focus();
				return false;
			}
			document.makeform.mode.value = mode; 
			//document.makeform.mode_call.value = 'app_pg50RC_Test';
			document.makeform.action='kapp_pg_Create.php'; 
			document.makeform.target='_self';
			document.makeform.submit();
		}
	}
	function change_project_func(pnmS){
		var p_selind = document.makeform.project_nmS.selectedIndex; 
		var p_val    = document.makeform.project_nmS.options[p_selind].value;
		var p_nm     = document.makeform.project_nmS.options[p_selind].text;
	}
	function change_table_func(tab) {
		tab = document.makeform.tab_hnmS.value;
		document.makeform.mode.value='SearchTAB';
		//document.makeform.column_attribute.value='';
		document.makeform.action="kapp_pg_Create.php";
		document.makeform.submit();
	}
	function change_program_func(pg) { // no use= X
		pg = document.makeform.pg_codeS.value;
		document.makeform.mode.value='SearchPG';
		//document.makeform.column_attribute.value='';
		document.makeform.action="kapp_pg_Create.php";
		document.makeform.target='table_main';//run_menu, '_self'; 
		document.makeform.submit();
		return;
	}

	function Create_button( pg) {
		var colnm = document.getElementsByName('column_list'); // name은 첨자가없다.
		var item_cnt = colnm.length;
		str_array = '';
		icnt= 0;
		for( i = 0; i < item_cnt; i++) {
			if( document.getElementById('column_list'+i).checked === true ){
				colnm_value = colnm[i].value;
				str_array = str_array + colnm_value+'@';
				icnt++;
			}
			//st = colnm_value.split('|');
			//str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
		} 
		document.makeform.item_cnt.value = icnt;
		var p_selind = makeform.project_nmS.selectedIndex; 
		var p_val    = makeform.project_nmS.options[p_selind].value;
		var p_nm      = makeform.project_nmS.options[p_selind].text;
		if( p_nm=='1.Select Project' || p_nm=='' ){
			alert( p_selind+" : p_val: " + p_val + ", p_nm:" + p_nm + " Please select a project! ");
			return;
		}

		var tab_selind = makeform.tab_hnmS.selectedIndex; 
		var tab_val    = makeform.tab_hnmS.options[tab_selind].value;
		var tabnm      = makeform.tab_hnmS.options[tab_selind].text;
		if( !tab_selind && !tabnm) {
			alert( tab_selind+" :  Please select a table! ");
			document.makeform.pg_name.focus();
			return false;
		}
		pg_name = document.makeform.pg_name.value;
		if( !pg_name ) {
			alert(" Please enter the program name!");
			document.makeform.pg_name.focus();
			return false;
		}

		if( pg == "kapp_Create") {
			if( !Pg_Dup_Check() ) return false;
			else document.makeform.dup_check.value = 1;
			alert(' OK : '+pg_name+ ', ' + document.makeform.dup_check.value);
			document.makeform.pg_make_set.value = "ok";
			document.makeform.item_array.value = str_array;
			document.makeform.mode.value = 'pg_new_create'; 
			document.makeform.mode_call.value = 'kapp_pg_Create'; //app_pg50RC
			document.makeform.action='kapp_pg_Create.php'; 
			document.makeform.target='_self';
			document.makeform.submit();
		}
	}
	function column_A(){
		var colnm = document.getElementsByName('column_list'); // name은 첨자가없다.
		var item_cnt = colnm.length;
		item_array=document.makeform.item_array.value;
		var st = "";
		var str_array ="";
		const checkbox = document.getElementById('all_confirm');
		if( checkbox.checked === false ) {
			checkbox.checked = true;

			for( i = 0; i < item_cnt; i++) {
				document.getElementById('column_list'+i).checked=true;
				colnm_value = colnm[i].value;
				str_array = str_array + colnm_value+'@';
				//st = colnm_value.split('|');
				//str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
			} 
		} else if( checkbox.checked === true ) {
			checkbox.checked = false;
			for( i = 0; i < item_cnt; i++) {
				document.getElementById('column_list'+i).checked=false;
				colnm_value = colnm[i].value;
				str_array = str_array + colnm_value+'@';
				//st = colnm_value.split('|');
				//str_array = str_array + st[0] +'|'+ st[1] +'|'+ st[2] +'|'+ st[3]+'|'+ st[4]+'@';	
			} 
		}

	}
	function Pg_name_Dup_Check(){
		const checkbox = document.getElementById('pgdup_confirm');
		checkbox.checked = Pg_Dup_Check()
	}
	function sendDataToPHP( projectnmS, pnmdataS ) {
		fetch('<?=KAPP_URL_T_?>/kapp_save_session.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ projectnmS: projectnmS, pnmdataS: pnmdataS }),
		})
		.then(response => response.json())
		.then(data => {
			console.log('Success:', data);
		})
		.catch((error) => {
			console.error('Error:', error);
		});
	}
	function change_project_func(pnmS){
		sendDataToPHP('project_nmS', pnmS); //my_func
		document.makeform.mode.value='Project_Search';
		document.makeform.action="kapp_pg_Create.php";
		document.makeform.submit();
	}
	function change_table_func(pnmS){ // Relation_Table_func
		sendDataToPHP('tab_hnmS', pnmS);
		document.makeform.mode.value='SearchTAB';
		document.makeform.action="kapp_pg_Create.php";
		document.makeform.submit();
		//location.href="kapp_pg_Create.php?mode=SearchTAB";
	}

//-->
</script>

<?php
	$tabData['data'][][] = array(); // use: PG_curl_send() - my_func
	$hostnameA = getenv('HTTP_HOST');

	if( isset($project_nmS) && $project_nmS !=='' ){
		$pcd_nm = explode(":", $project_nmS );
		if( isset($pcd_nm[0]) && $pcd_nm[0] !=='' ) $project_code	= $pcd_nm[0];
		else $project_code = '';	
		if( isset($pcd_nm[1]) && $pcd_nm[1] !=='' ) $project_name	= $pcd_nm[1]; 
		else $project_name= "";
	} else {
		$project_name= "";
		$project_code= "";
	}
	$fld_sel_type	= ""; 

	if( $mode == 'pg_new_create') {
		$pg_code= $H_ID . "_" . time();
		$_SESSION['pg_code'] = $pg_code;
			$rel_type = ""; 
			$rel_data = ""; 
			$pop_data = ""; 
			$if_data = ""; 
			$if_type = ""; 
			if( isset($_POST['item_array']) ) $item_array = $_POST['item_array']; 
			else  $item_array = ""; 
			if( isset($_POST['item_cnt']) ) $item_cnt = $_POST['item_cnt']; 
			else  $item_cnt = ""; 
			$in_day			= date("Y-m-d H:i");
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$pg_code', pg_name='$pg_name', item_cnt=$item_cnt, item_array='$item_array', if_type='$if_type', if_data='$if_data', pop_data='$pop_data', relation_data='$rel_data', relation_type='', tab_mid='$H_ID', userid='$H_ID' ";
			$ret = sql_query($query);
			$sys_pg_root	= $pg_code;
			$sys_subtit		= $pg_name;
			$aboard_no		= $pg_code;
			$job_group		= "KAPP-Program";
			$job_name		= $pg_name;
			$jong			= "P";
			$pg_cd_nm = $pg_code . ":" . $pg_name;
			$sys_link = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $pg_code; 
			$kapp_theme0 = '';
			$kapp_theme1 = '';
			$kapp_theme = $config['kapp_theme'];
			$kapp_theme = explode('^', $kapp_theme );	//$n = sizeof($server_);
			$kapp_theme0 = $kapp_theme[0];
			$kapp_theme1 = $kapp_theme[1];
			job_link_table_add( $pg_code, $pg_name, $sys_link, $pg_code, $job_group, $job_name, $jong );
			insert_point_app( $H_ID, $config['kapp_write_point'], $sys_link, 'program_create@app_pg50RC', $pg_cd_nm, $tab_enm);
			$pg_sys_link	= KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $pg_code;
			
			if( isset($kapp_theme0) && $kapp_theme0 !=='' ){
				PG_curl_send( $kapp_theme0, $item_cnt , $item_array, $if_type, $if_data, $pop_data, $pg_sys_link, $rel_data, $rel_type );
			}
			if( isset($kapp_theme1) && $kapp_theme1 !=='' ) {
				PG_curl_send( $kapp_theme1, $item_cnt , $item_array, $if_type, $if_data, $pop_data, $pg_sys_link, $rel_data, $rel_type );
			}
			$url = "./tkher_program_run.php?pg_code=". $pg_code;
			echo "<script>window.open( '".$url."' , '_blank', ''); </script>";

	} else if( $mode == 'Project_Search' ){
	} else if( $mode == 'SearchTAB' || isset($_SESSION['tab_nmS'])){
		$aa				= explode(':', $tab_hnmS);
		$tab_enm		= $aa[0];
		$tab_hnm		= $aa[1];
		$sqlTAB		= "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_name='$tab_hnm' ";  // use Duplicate check
		$resultTAB		= sql_query($sqlTAB);
		$table10_tab	= sql_num_rows($resultTAB);
		$rsTAB			= sql_fetch_array($resultTAB);
		$item_cnt		= $rsTAB['item_cnt'];
		$item_array		= $rsTAB['item_array'];
		$if_type		= $rsTAB['if_type'];
		$if_data		= $rsTAB['if_data'];
		$pop_data		= $rsTAB['pop_data'];
		$rel_data		= $rsTAB['relation_data'];
		$project_code	    = $rsTAB['group_code'];  
		$project_name	    = $rsTAB['group_name'];  
		$project_nmS	= $project_code.":".$project_name;
	}
?>
<center>
<div id='menu_normal'>
   <table height='100%' cellspacing='0' cellpadding='4' width='500' border='1' class="c1"> 
	<Form METHOD='POST' name='makeform' enctype="multipart/form-data">
			<input type="hidden" name="sellist"	        value="" >
			<input type="hidden" name="mode" id="mode"  value="" >
			<input type="hidden" name="mode_call"		value="" >
			<input type="hidden" name="pg_code"			value="<?=$pg_code?>">
			<input type="hidden" name="calc"			value="<?=$calc?>"> 
			<input type="hidden" name="rel_data"		value="<?=$rel_data?>"> 
			<input type="hidden" name="rel_type"		value="<?=$rel_type?>">
			<input type="hidden" name="dup_check"		value="" > 
		<tr><td align="center" <?php echo" title='New program creation order \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;">
New Program Creation (<?=$H_ID?>)<br>
		Project:<SELECT id='project_nmS' name='project_nmS' onchange="change_project_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:80%; height:30px;" title='Please select the table to use for the Project! '>
<?php 
		if( $mode=='Project_Search' && isset( $_SESSION['project_nmS']) ) echo "<option value='$project_nmS' selected >$project_name</option>";
		else echo "<option value=''>1.Select Project</option>";

		$result= sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " ); 
		while( $rs = sql_fetch_array($result)) {
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php if( $project_code==$rs['group_code']) echo ' selected '; ?> ><?=$rs['group_name']?></option>
<?php	} ?>
		</SELECT>

		<SELECT id='pg_codeS' name='pg_codeS' style="display:NONE;" >
<?php
		$result = sql_query( "SELECT * from {$tkher['table10_pg_table']} where group_code='$project_code' and userid='$H_ID' order by upday desc " );
		while( $rs = sql_fetch_array($result)) {
?>
				<option value='<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>' ><?=$rs['pg_name']?></option>
<?php	} ?>
		</SELECT>
</td></tr>

<tr><td align="center" <?php echo" title='New program creation order \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;">
		Table:&nbsp;
		<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func(this.value);" style='background-color:#666666;color:yellow;width:80%; height:30px;'>
<?php
		if( $mode =='SearchTAB' || isset($_SESSION['tab_nmS']) ) echo "<option value='$tab_hnmS' selected >$tab_hnm</option>";
		else echo "<option value=''>2.Select Table</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where group_code='$project_code' and userid='".$H_ID."' and fld_enm='seqno'  order by upday desc");	//group by tab_enm " );
		while( $rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php if($rs['tab_hnm']==$tab_hnm) echo " selected "; ?> title='table code:<?=$rs['tab_enm']?>'><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</SELECT>




</td></tr>
<tr><td height="30" align="left" style="border-style:;background-color:#666666;color:cyan;" <?php echo" title='New program creation order \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> align='center'>
program name:<input type='text' id='pg_name' name='pg_name' value='<?=$pg_name?>' maxlength='200'  style="border-style:;background-color:black;color:yellow;height:25;width:120;" value='' <?php echo" title=' Enter the name of the program to be created and select the table! ' "; ?> >

&nbsp;<input type='checkbox' id='pgdup_confirm' name='pgdup_confirm' value='Confirm' onClick="return false">&nbsp;
&nbsp;<input type='button' onclick="Pg_name_Dup_Check()" value='Duplicate check' >

<input type='button' value='Create' onClick="Create_button('kapp_Create')" style="border-style:;background-color:#666fff;color:yellow; height:25px;" title='program Create and duplicate check' >


</td></tr>
<tr><td valign="top">

<div id="here">
<?php
	$column_ = "";
	if( $mode == 'SearchTAB' || isset($_SESSION['tab_nmS']) ){
		$column_ = "<p style='font-size:24px;text-align:center;font-weight: bold;border-radius:20px;border:1 solid black;height:22px;'>Select ALL: <input type='checkbox' id='all_confirm' name='all_confirm' value='Confirm' onClick='return false'>&nbsp;<input type='button' onclick='column_A();' value='Click ALL' title='Select all or deselect' ></p>";

		$itX = explode("@",$item_array);
		for( $i=0, $j=0; $i<$item_cnt; $i++, $j++){
			$it = explode("|",$itX[$i]);
			$column_ = $column_ . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. " )'><input type='checkbox' id='column_list".$j."' name='column_list' onclick='column_list_onclickA(this.value, " .$j. " )' value='".$it[0]."|".$it[1]."|".$it[2]."|".$it[3]."|".$it[4]."'><label id='columnR".$j."'>".$it[2]."</label></label><br>";
		}
	} else if( $mode =='pg_new_create' ){
		//m_(" mode: $mode, tab_enm: $tab_enm, $table10_tab, $item_array");//mode: SearchTAB, tab_enm: crakan59_gmail_1764992309, 1
		$column_ = "<p style='font-size:24px;text-align:center;font-weight: bold;border-radius:20px;border:1 solid black;height:22px;'><!-- Select ALL: <input type='radio' id='all_confirm' name='all_confirm' value='Confirm' onClick='return false'>&nbsp;<input type='button' onclick='column_A();' value='Click ALL' title='Select all or deselect' > --></p>";

		$itX = explode("@",$item_array);
		for( $i=0, $j=0; $i<$item_cnt; $i++, $j++){
			$it = explode("|",$itX[$i]);
			$column_ = $column_ . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. " )'><input type='radio' id='column_list".$j."' name='column_list' onclick='column_list_onclickA(this.value, " .$j. " )' value='".$it[0]."|".$it[1]."|".$it[2]."|".$it[3]."|".$it[4]."'><label id='columnR".$j."'>".$it[2]."</label></label><br>";
		}
	} else {
		//m_("--- first routine");
	} //if( $table10_pg>0 or $table10_tab>0 ) 

	$qna = "sequence of the work|Select Project and Table.|Enter program name.|Click Create button.|"; // 4:item cnt, ^:item add.
	echo "<script> Print_item_func(\"".$column_."\", \"".$qna."\");</script> ";
?>
		</div>
</td></tr>

<tr><td bgcolor="#666666" height="27">&nbsp;&nbsp; 
</td></tr>

<tr><td height="24" title='Enter the column name and click the button! ' >
</td></tr>


		<input type='hidden' id='column_attribute_index' name='column_attribute_index' >
		<input type='hidden' id='column_index' name='column_index' >
		<input type='hidden' name='multy_menu_sel' >
		<input type='hidden' name='pg_make_set' >
		<input type='hidden' name='tab_enm'  value='<?=$tab_enm?>' >
		<input type='hidden' name='tab_hnm'  value='<?=$tab_hnm?>' >
		<input type='hidden' name='seqno'    value='<?=$seqno?>' >
		<input type='hidden' name='item_cnt' value='<?=$item_cnt?>' >
		<input type='hidden' name='if_line'  value='' >
		<input type='hidden' name='item_array' value='<?=$item_array?>' >
		<input type='hidden' name='if_typeT' value='<?=$if_type?>' >
		<input type='hidden' name='if_dataT' value='<?=$if_data?>' >
		<input type='hidden' name='pop_dataT' value='<?=$pop_data?>' >
<?php
	$iftypeR =array();
	$ifdataR =array();
	$popdataR =array();
	$itemR =array();
	$ifT	= "";	$ifD	= "";	$ifP	= "";
//	if( isset($table10_pg) || isset($table10_tab) || isset($item_cnt) ) { // table select
	if( $mode == 'SearchTAB' || isset($_SESSION['tab_nmS'])) { // table select
			if( isset($if_type) ) $iftypeR = explode("|", $if_type );
			if( isset($if_data) ) $ifdataR = explode("|", $if_data );
			if( isset($pop_data) ) $popdataR= explode("^", $pop_data );
			if( isset($item_array) ) $itemR   = explode("@", $item_array );
			for( $i=0, $j=1;$i<$item_cnt;$i++, $j++){
				if( isset($iftypeR[$j]) ) $ifT	= $iftypeR[$j];
				if( isset($ifdataR[$j]) ) $ifD	= $ifdataR[$j];
				if( isset($popdataR[$j]) ) $ifP	= $popdataR[$j];
				$it		= $itemR[$i];
?>
				<input type='hidden' name="iftype[<?=$i?>]"  value='<?=$ifT?>' >
				<input type='hidden' name="if_data[<?=$i?>]" value='<?=$ifD?>' > 
				<input type='hidden' name="popdata[<?=$i?>]" value='<?=$ifP?>' > 
				<input type='hidden' name="iftypeA_<?=$i?>" value='<?=$ifT?>' >
				<input type='hidden' name="if_dataA_<?=$i?>" value='<?=$ifD?>' > 
<?php
				$ifT	= "";	$ifD	= "";	$ifP	= "";
			}			
	} else {
		// first run.
	}
?>
	<input type='hidden' name='group_code' value='<?=$project_code?>' >
	<input type='hidden' name='group_name' value='<?=$project_name?>' >
</form>
</table>
</div>
</body>
</html>
