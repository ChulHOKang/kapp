<?php
	include_once('./tkher_start_necessary.php');
	/*
		app_permission.php : app grant level setting.
		- table10u1_PC.php :  table permission : no use
	*/
	$H_ID = get_session("ss_mb_id");	
	if ( !$H_ID ) {
		m_("Login Please!");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
	else $H_LEV = 1;
	if( $H_LEV < 2) {
		m_("Login Please!");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	include_once( KAPP_PATH_T_ . "/table_paging.php");
?>

<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="./icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>
<style>
table { border-collapse: collapse; }
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }
	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		justify-content: space-between;		/* flex-start, flex-end, center, space-between, space-around */
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
		align-items: center;							/* flex-start, flex-end, center, baseline, stretch */
		height:25px;

	}
	.item {
		background-color: gold;
		boarder: 1px solid gray;
	}
</style>

<script src="//code.jquery.com/jquery.min.js"></script>
<!-- <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/kapp_program.js"></script> -->

<script>
$(function () {
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			switch(e.target.innerText){
				case 'Project' : title_func('group_name', 'app_permission.php'); break;
				case 'User'    : title_func('userid', 'app_permission.php'); break;
				case 'Program' : title_func('pg_name', 'app_permission.php'); break;
				case 'Table'   : title_func('tab_hnm', 'app_permission.php'); break;
				case 'Date'    : title_func('upday', 'app_permission.php'); break;
				default        : title_func('', 'app_permission.php'); break;
			}
		}, 250);
	});
	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer);
		switch(e.target.innerText){
				case 'Project' : title_wfunc('group_name', 'app_permission.php'); break;
				case 'User'    : title_wfunc('userid', 'app_permission.php'); break;
				case 'Program' : title_wfunc('pg_name', 'app_permission.php'); break;
				case 'Table'   : title_wfunc('tab_hnm', 'app_permission.php'); break;
				case 'Date'    : title_wfunc('upday', 'app_permission.php'); break;
				default        : title_wfunc('', 'app_permission.php'); break;
		}
	});

	$('table.floating-thead').each(function() {
		if( $(this).css('border-collapse') == 'collapse') {
		  $(this).css('border-collapse','separate').css('border-spacing',0);
		}
		$(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
	});
	$(window).scroll(function() {
		var scrollTop = $(window).scrollTop(),
		  scrollLeft = $(window).scrollLeft();
		$('table.floating-thead').each(function(i) {
		  var thead = $(this).find('thead:last'),
			clone = $(this).find('thead:first'),
			top = $(this).offset().top,
			bottom = top + $(this).height() - thead.height();
		  if( scrollTop < top || scrollTop > bottom ) {
			clone.hide();
			return true;
		  }
		  if( clone.is('visible') ) return true;
		  clone.find('th').each(function(i) {
			$(this).width( thead.find('th').eq(i).width() );
		  });
		  clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
		});
	});
});
  
</script>

<!-- <link rel="stylesheet" href= KAPP_URL_T_ . "/include/css/common.css" type="text/css" />
<link rel="stylesheet" href= KAPP_URL_T_ . "/include/css/kancss.css" type="text/css"> -->

<body leftmargin="0" topmargin="0">

<!-- <script type="text/javascript" src= KAPP_URL_T_ . "/include/js/ui.js"></script>
<script type="text/javascript" src= KAPP_URL_T_ . "/include/js/common.js"></script> -->
<script type="text/javascript" >
<!--
	/*function title_wfunc( thisform, fld_code_pg){       
		thisform.page.value = 1;
		thisform.fld_code_pg.value= fld_code_pg;
		thisform.fld_code_asc_pg.value= 'desc';
		thisform.mode.value='title_wfunc';
		thisform.target='_self';
		thisform.action='app_permission.php';
		thisform.submit();                         
	} 
	function title_func( thisform, fld_code){       
		document.kapp_program_list_Form.page.value = 1;                
		document.kapp_program_list_Form.fld_code.value= fld_code;           
		document.kapp_program_list_Form.mode.value='title_func';           
		document.kapp_program_list_Form.action='app_permission.php';
		document.kapp_program_list_Form.submit();                         
	} */


	function title_wfunc( fld_code, pg){       
		document.kapp_program_list_Form.page.value = 1;
		document.kapp_program_list_Form.fld_code.value= fld_code;
		document.kapp_program_list_Form.fld_code_asc.value= 'desc';
		document.kapp_program_list_Form.mode.value='title_wfunc';
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.action=pg; //'kapp_program_list.php';
		document.kapp_program_list_Form.submit();                         
	} 
	function title_func( fld_code, pg){       
		document.kapp_program_list_Form.page.value = 1;                
		document.kapp_program_list_Form.fld_code.value= fld_code;           
		document.kapp_program_list_Form.fld_code_asc.value= 'asc';
		document.kapp_program_list_Form.mode.value='title_func';           
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.action=pg; //'kapp_program_list.php';
		document.kapp_program_list_Form.submit();                         
	} 

	function edit_attr_save(aaa, no, num){ 
		p = document.kapp_program_list_Form.page.value;
		var sel_r = eval("document.kapp_program_list_Form.grant_read_" + aaa + ".value");
		var sel_w = eval("document.kapp_program_list_Form.grant_write_" + aaa + ".value");
		document.kapp_program_list_Form.read_.value = sel_r;
		document.kapp_program_list_Form.write_.value = sel_w;
		document.kapp_program_list_Form.seqno_.value = no;
		document.kapp_program_list_Form.mode.value = "update_level";

		var res = confirm(" Do you want to save it?");
		if (res) { document.kapp_program_list_Form.submit(); }
	}

	function App_search(){
		var tab_hnm = document.kapp_program_list_Form.data.value;
		var tab = document.kapp_program_list_Form.tab_hnmS.value;
		document.kapp_program_list_Form.page.value =1;
		document.kapp_program_list_Form.mode.value='App_search';
		document.kapp_program_list_Form.action="app_permission.php";
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.submit();
	}

	function page_func( page, data ){
		document.kapp_program_list_Form.mode.value		='';
		document.kapp_program_list_Form.data.value		=data;
		document.kapp_program_list_Form.page.value=page;
		document.kapp_program_list_Form.action="app_permission.php";
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.submit();
	}
	function Change_line_cnt( $line){
		document.kapp_program_list_Form.page.value = 1;
		document.kapp_program_list_Form.action='app_permission.php';
		document.kapp_program_list_Form.submit();
	}
	function group_code_change_func(cd){
		document.kapp_program_list_Form.page.value=1;
		index=document.kapp_program_list_Form.group_code.selectedIndex;
		nm = document.kapp_program_list_Form.group_code.options[index].text;
		document.kapp_program_list_Form.mode.value='Search_Project';
		document.kapp_program_list_Form.group_name.value=nm;
		document.kapp_program_list_Form.action="app_permission.php";
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.submit();
	}
	function run_func( pg ){
		document.kapp_program_list_Form.action='./kapp_program_data_list.php';
		document.kapp_program_list_Form.target="_blank";
		document.kapp_program_list_Form.pg_code.value=pg;
		document.kapp_program_list_Form.submit();
	}
	function Change_grant_view_list( thisform, cd, grant_view, pg_code) {
		resp = confirm("Are you sure change? Y/N ");
		if( resp === true ) {
			jQuery(document).ready(function ($) {
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: 'kapp_column_change_ajax.php',
						data: {
							"mode": 'grant_view_change',
							"pg_code": pg_code,
							"grant_view": grant_view
								
						},
					success: function(data) {
						alert("OK change --- " + grant_view);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" error.-- kapp_column_change_ajax.php");
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						return;
					}
				});
			});
		} else {
			switch(cd){
				case '0': 
				case '1': old_cd = 0; msg='Guest'; break;
				case '2': old_cd = 1; msg='Member'; break;
				case '3': old_cd = 2; msg='For creators only'; break;
				case '8': old_cd = 3; msg='Only system manager'; break;
				default : old_cd = 0; msg='Guest'; break;
			}
			view_form.grant_view.selectedIndex = old_cd;
		}
	}	
	function Change_grant_write_list( thisform, cd, grant_write, pg_code){
		resp = confirm("Are you sure change? Y/N ");
		if( resp === true) {
			jQuery(document).ready(function ($) {
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: 'kapp_column_change_ajax.php',
						data: {
							"mode": 'grant_write_change',
							"pg_code": pg_code,
							"grant_write": grant_write
								
						},
					success: function(data) {
						alert("OK change --- " + grant_write);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" Error -- kapp_column_change_ajax.php");
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						return;
					}
				});
			});
		} else {
			switch(cd){
				case '0': 
				case '1': old_cd = 0; msg='Guest'; break;
				case '2': old_cd = 1; msg='Member'; break;
				case '3': old_cd = 2; msg='For creators only'; break;
				case '8': old_cd = 3; msg='Only system manager'; break;
				default : old_cd = 0; msg='Guest'; break;
			}
			view_form.grant_write.selectedIndex = old_cd;
		}
	}	
	function kapp_line_cnt_submit(pg){
		document.kapp_program_list_Form.page.value= 1;
		document.kapp_program_list_Form.mode.value='';
		document.kapp_program_list_Form.action=pg; //'kapp_program_list.php';
		document.kapp_program_list_Form.target="_self";
		document.kapp_program_list_Form.submit();
	}
	function page_move(thisform, $page, linkurl){
		thisform.page.value = $page;
		thisform.action= linkurl; //'kapp_program_data_list.php';
		thisform.submit();
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.kapp_program_list_Form.mode.value="kapp_program_list";
		//document.kapp_program_list_Form.seqno.value=seqno;
		document.kapp_program_list_Form.pg_name.value=pg_name;
		document.kapp_program_list_Form.pg_code.value=pg_code;
		document.kapp_program_list_Form.action="./kapp_program_data_list.php";
		document.kapp_program_list_Form.target="_blank";
		document.kapp_program_list_Form.submit();
	}
//-->
</script>

<?php

	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10; 

	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset( $_POST['fld_code_asc']) ) $fld_code_asc= $_POST['fld_code_asc'];
	else $fld_code_asc = '';

	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";   

	if( $mode == 'My_List') $my = " userid='".$H_ID."' ";
	else $my ='';

	if( isset($_POST['param']) && $_POST['param'] !="" ) $param = $_POST['param'];
	else $param = "";   
	if( isset($_POST['sel']) && $_POST['sel'] !="" ) $sel = $_POST['sel'];
	else $sel = "";   
	if( isset($_POST['data']) && $_POST['data'] !="" ) $data = $_POST['data'];
	else $data = "";   

	if( isset($_POST['group_code']) && $_POST['group_code']!='' ) {
		$group_code = $_POST['group_code'];   
		$wsel = " and group_code = '$group_code' ";
	} else {
		$group_code= '';
		$wsel = '';
	}

	if( $mode == "update_level") {
		$seqno = $_POST['seqno_'];
		$sel_r = $_POST['read_'];
		$sel_w = $_POST['write_'];
		$query = "update {$tkher['table10_pg_table']} set grant_view='$sel_r', grant_write='$sel_w' where userid='$H_ID' and seqno=$seqno  ";
		$mq = sql_query($query);
		if( $mq ){ echo("<script>alert('App reset complete')</script>");}

		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !='' ){
			if( $sel == 'like' ) $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
			else $ls = $ls . " where $param $sel '$data' and userid='$H_ID'";
		} else $ls = $ls . " where userid='$H_ID' ";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;

	} else if( $mode == 'App_search' ) {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !='' ){
			if( $sel == 'like' ) $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
			else $ls = $ls . " where $param $sel '$data' and userid='$H_ID'";
		} else $ls = $ls . " where userid='$H_ID' ";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;

	} else if( $mode == 'Search_Project' && $group_code!='') {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !='' ){
			if( $sel == 'like' ) $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
			else $ls = $ls . " where $param $sel '$data' and userid='$H_ID'";
		} else $ls = $ls . " where userid='$H_ID' ";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;
	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid='$H_ID'";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;
	}
	$resultT	= sql_query( $ls );
	$total_count = sql_num_rows( $resultT );

	$total_page = intval(($total_count-1) / $line_cnt)+1; 
	$first = ($page-1) * $line_cnt; 
	$last = $line_cnt; 
	if($total_count < $last) $last = $total_count;
	$limit = " limit $first, $last ";
	if( $page == "1") $no = $total_count;
	else $no = $total_count - ($page - 1) * $line_cnt;
?>
<center>
<?php
		if( $mode=="Search" ) $T_msg = "[ Set permissions of program : ". $pg_name . " ]";
		else $T_msg = "[ Set permissions of program ]";
		if( isset($H_ID) ) $T_msg = $T_msg;
		else $T_msg = $T_msg . " , " . $ip;
?>
<FORM name="kapp_program_list_Form" Method='post'  enctype="multipart/form-data" >
			<input type="hidden" name="read_"	value="" >
			<input type="hidden" name="write_"	value="" >
			<input type="hidden" name="seqno_"	value="" >
			<input type="hidden" name="memo_"	value="" >
			<input type="hidden" name="mode"	value="<?=$mode?>" >
			<input type='hidden' name='page' value="<?=$page?>">
			<input type="hidden" name="tab_hnmS" value=''>
			<input type="hidden" name="pg_name" value='<?=$pg_name?>'> 
			<input type="hidden" name="pg_code" value='<?=$pg_code?>' > 
			<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
			<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>
			<input type="hidden" name='fld_code' value='<?=$fld_code?>' />
			<input type="hidden" name='fld_code_asc' value='<?=$fld_code_asc?>' />
			<input type='hidden' name='group_name' >
<span title='program permission set' style="border-style:;background-color:cyan;color:black;height:28;font-weight: bold;"><?=$T_msg?></span>
		<div>
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
	</SELECT>

			<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="pg_name">program</option>
			</select> 
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="=" <?php if($sel == '=') echo " selected ";?> >=</option>
				<option value="like" <?php if($sel == 'like') echo " selected ";?>>Like</option>
			</select>
			<input type="text" name="data" value='<?=$data?>' maxlength="30" size="15">
			<input type='button' value='Search' onclick="javascript:App_search();" >
			- P: <?=$member['mb_point']?>, L: <?=$member['mb_level']?> , <?=$member['mb_nick']?>
, View Line: 
<SELECT id='line_cnt' name='line_cnt' onChange="kapp_line_cnt_submit('app_permission.php')" style='height:20;'>
<?php echo "<option value='$line_cnt' selected >$line_cnt</option>"; ?>
								<option value='5'>5</option>
								<option value='10'>10</option>
								<option value='15'>15</option>
								<option value='30'>30</option>
								<option value='50'>50</option>
								<option value='100'>100</option>
</SELECT>&nbsp; - total:<?=$total_count?>, page:<?=$page?>

		</div>



<table class='floating-thead' width="100%">
<thead id='tit_et' width="100%">
      <tr>
        <th>NO</th>
<?php
	echo " <th title='User Sort click or doubleclick' >User</th> ";
	echo " <th title='project Sort click or doubleclick' >Project</th> ";
	echo " <th title='Program Sort click or doubleclick' >Program</th> ";
	echo " <th title='Table Sort click or doubleclick' >Table</th> ";
	echo " <th title='Date Sort click or doubleclick' >Date</th> ";
?>
        <TH width='4%' align='center' bgcolor='#EEEEEE' title='Read permission - Read permission above level'>Grant View</TH>
        <TH width='4%' align='center' bgcolor='#EEEEEE' title='Write permission - Write permission above level'>Grant Write</TH>
        <!-- <TH width='10%' align='center' bgcolor='#EEEEEE'>Submit</TH> -->
      </tr>
</thead>

<tbody width='100%'>
<?php
    $line=0;
	$i=1;
	if( $mode != 'Search') $ls = $ls . " $limit ";
	$resultT = sql_query( $ls );
	while( $rsP = sql_fetch_array( $resultT ) ) { 
		$pg_code = $rsP['pg_code'];
		$pg_name = $rsP['pg_name'];
		$line = $line_cnt*$page + $i - $line_cnt;
		$grant_view = $rsP['grant_view'];
		$grant_write = $rsP['grant_write'];

		if( $H_ID == $rsP['userid']) $bcolor ="style='background-color:cyan;'";
		else $bcolor='';
?>
		  <tr>
			<TD><?=$line?></TD>
			<td bgcolor="#FFFFFF" title="user:<?=$rsP['userid']?>, userid:<?=$rsP['userid']?>"><?=$rsP['userid']?></td>
			<td bgcolor="#FFFFFF" title="project code:<?=$rsP['group_code']?>"><?=$rsP['group_name']?></td>
	
	<td <?=$bcolor?> title="Click run, pg_code:<?=$rsP['pg_code']?>" >
		<a href="javascript:program_run_funcList2( '<?=$rsP['seqno']?>', '<?=$rsP['pg_name']?>', '<?=$rsP['pg_code']?>' );" ><?=$rsP['pg_name']?> (<?=$rsP['pg_code']?>) </a></td>

	<TD <?=$bcolor?> title='Data List program run'>
		<a href="javascript:program_run_funcList2( '<?=$rsP['seqno']?>', '<?=$rsP['pg_name']?>', '<?=$rsP['pg_code']?>' );" ><?=$rsP['tab_hnm']?></a></td>

	<TD><?=substr($rsP['upday'], 0,10)?></td>
			<td bgcolor="#FFFFFF" >
			<!-- <SELECT name='grant_read_<?=$i?>' > -->
			<select class="grant_view_func" id='grant_view' name='grant_view' onChange="Change_grant_view_list( this.form, <?=$grant_view?>, this.options[selectedIndex].value, '<?=$pg_code?>')" style='height:25;' title='Click to change properties'>
				<option value='1' <?php if($grant_view==0||$grant_view==1)  echo " selected"; ?> >Guest</option>
				<option value='2' <?php if($grant_view==2)  echo " selected"; ?> >Member</option>
				<option value='3' <?php if($grant_view==3)  echo " selected"; ?> >For creators only</option>
				<option value='8' <?php if($grant_view==8)  echo " selected"; ?> >Only system manager</option>
			</select></td>
			<td bgcolor="#FFFFFF" align="center">

			<!-- <SELECT name="grant_write_<?=$i?>" > -->
			<select id='grant_write' name='grant_write' onChange="Change_grant_write_list( this.form, '<?=$grant_write?>', this.options[selectedIndex].value, '<?=$pg_code?>')" style='height:25;' title='Click to change properties'>
				<option value='1' <?php if($grant_write==0||$grant_write==1)  echo " selected"; ?> >Guest</option>
				<option value='2' <?php if($grant_write==2)  echo " selected"; ?> >Member</option>
				<option value='3' <?php if($grant_write==3)  echo " selected"; ?> >For creators only</option>
				<option value='8' <?php if($grant_write==8)  echo " selected"; ?> >Only system manager</option>
			</select>
			</td>
		  </tr>
<?php
		$i++;
	}
?>
		  </form>
</tbody>
    </table>

<?php
	paging("app_permission.php",$total_count,$page,$line_cnt, "document.kapp_program_list_Form"); 
?> 

</body>
</html>
