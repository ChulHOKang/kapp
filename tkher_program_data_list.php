<?php
	include_once('./tkher_start_necessary.php');

	/* ----------------------------------------------------------------------
	tkher_program_data_list.php?pg_code=dao_1540779796  : data list   system program , popup , calc
    tkher_program_run.php?pg_code=dao_1693896214		: data insert system program , call : table10i.php, app_pg50RC.php 에서 call
    tkher_program_data_update.php						: data update system program
	tkher_program_data_view.php							: data view   system program

		tkher_program_data_list.php : table data list.
		- call : tkher_program_run.php : data insert program.
		- call : program_list3.php 
		- copy : tab_list_pg70.php 을 copy 하여 생성함. 프로그램 테이블 데이터 리스트 이다.
		https://tkher.com/t/t_login.php?pg_code=dao_1537317833
	---------------------------------------------------------------------- */
	include "./table_paging.php";

	$H_ID  = get_session("ss_mb_id"); 
	if( isset($H_ID) && $H_ID !=='' ) {
		//m_("You need to login. ");
		$H_LEV = $member['mb_level']; 
		$H_POINT	= $member['mb_point']; 
	} else {
		$H_LEV = 1; 
		$H_POINT= 0; 
	}

	if( isset( $_REQUEST['pg_code']) ) $pg_code= $_REQUEST['pg_code'];
	else if( isset( $_POST['pg_code']) ) $pg_code= $_POST['pg_code'];
	else if( isset( $_SESSION['pg_code']) ) $pg_code= $_SESSION['pg_code'];
	else $pg_code = '';


	if( isset( $_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else if( isset( $_POST['mode']) ) $mode= $_POST['mode'];
	else $mode = '';
	
	if( !$pg_code ) {
		$pg_code = $_SESSION['pg_code'];
		m_("pg code - ERROR : pg_code: $pg_code "); exit;//
	} else $_SESSION['pg_code']= $pg_code;

	$pg_mid= ''; $tab_mid= ''; 

	if( $mode == "project_search" ) {
		$group_code = $_POST['group_code'];	//	m_("$mode, $group_code");
		$_SESSION['group_code']=$group_code;
	} else {
		if( isset( $_POST['group_code']) ) $group_code= $_POST['group_code'];
		else if( isset( $_SESSION['group_code']) ) $group_code= $_SESSION['group_code'];
		else $group_code = '';
	}

	$sqlPG ="SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$rsPG =sql_fetch($sqlPG);
	if( isset($rsPG['item_array']) && $rsPG['item_array'] !==''){
		$item_array = $rsPG['item_array'];
		$if_data = $rsPG['if_data'];
		$iftype = $rsPG['if_type'];
		$tab_enm = $rsPG['tab_enm'];
		$tab_hnm = $rsPG['tab_hnm'];
		$item_cnt = $rsPG['item_cnt'];
		$fld_cnt = $rsPG['item_cnt'];
		$pg_name = $rsPG['pg_name']; 
		$pg_mid= $rsPG['userid']; 
		$tab_mid= $rsPG['tab_mid']; 
		$grant_view= $rsPG['grant_view']; 
		$grant_write= $rsPG['grant_write']; 
		//$group_code= $rsPG['group_code'];
		$group_name= $rsPG['group_name'];
	} else {
			m_(" program name ERROR : table10_pg , pg_name:$pg_name , pg_code:$pg_code NO Found! "); exit;
	}
?>
<html> 
<head> 
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/appmaker.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

</head> 

<script src="//code.jquery.com/jquery.min.js"></script>
<script>
$(function () {
  $('table.listTableT').each(function() {
    if( $(this).css('border-collapse') == 'collapse') {
      $(this).css('border-collapse','separate').css('border-spacing',0);
    }
    $(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
  });
  
  $(window).scroll(function() {
    var scrollTop = $(window).scrollTop(),
      scrollLeft = $(window).scrollLeft();
    $('table.listTableT').each(function(i) {
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

<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/common.css" type="text/css" />
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/program_list.css" type="text/css" />

<script type="text/javascript" >
<!--
	function home_func(pg_code){
		view_form.mode='home_func';
		view_form.action='tkher_program_data_list.php?pg_code='+pg_code;
		view_form.submit();
	}
	function Change_Csel(c_sel){
		document.c_sel.c_sel.value=c_sel;
		document.view_form.c_sel.value=c_sel;
		document.c_sel.submit();
	}

	function Change_Csel3(c_sel){
		document.view_form.search_choice.value=c_sel;
		document.view_form.c_sel3.value=c_sel;
	}
	function Change_Csel2(c_sel){
		var obj = document.getElementById("c_sel3");
		var c = c_sel.split("|");
		document.view_form.search_fld.value = c[0];
		document.view_form.mode.value = 'search';
	}
	function pg_record_view( seqno, data_mid ){
		document.view_form.seqno.value=seqno;
		document.view_form.data_mid.value=data_mid;
		document.view_form.action='tkher_program_data_view.php'; 
		document.view_form.submit();
	}
    function table_record_view(enm,hnm)
	{
		document.view_form.pg_code.value=enm;
		document.view_form.pg_name.value=hnm;
		document.view_form.action='tkher_program_data_list.php'; 
		//document.view_form.action='tkher_program_data_list.php?pg_code='+enm; 
		document.view_form.submit();
	}
	function table_record_write(pg_code, grant_write, h_lev){ 
		if( h_lev > 1 && h_lev > grant_write || h_lev == grant_write){
			document.view_form.action='tkher_program_run.php?pg_code='+pg_code; 
			document.view_form.submit();
		} else {
			alert("No permission. ");
			return;
		}
	}
	function excel_down(){
		if( !document.view_form.id.value ) {
			alert('Login Please!'); return false;
		}
		document.view_form.mode.value = 'excel_create';
		document.view_form.action='down_excel_file.php';
		document.view_form.submit();
	}
	function Change_line_cnt( $pg_code, $line){
		
		document.view_form.page.value = 1;
		document.view_form.line_cnt.value = $line;
		document.view_form.action='tkher_program_data_list.php?pg_code='+$pg_code;
		document.view_form.submit();
	}
	function tkher_source_create( $coin ){ 
		if( !document.view_form.id.value ) {
			alert('Login Please!'); return false;
		}
		if( $coin < 1000 ) {
			alert('Requires more than 1000 points. Point is low. You must do activities to accumulate points. point:'+ $coin);//UrlLinCoin Point가 부족합니다. point를 축적해야합니다.
			document.view_form.action='<?=KAPP_URL_T_?>/manual/user_manual.php';
			document.view_form.target = '_blank';
			document.view_form.submit();
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.view_form.mode.value = "data_list";
				document.view_form.action='tkher_php_programDN.php';
				document.view_form.target = '_blank';
				document.view_form.submit();
			} else { 
				alert('Cancel!');
			}
		}
	}
	$(function() {
		$('.search_btn').on('click', function() {
			var c_sel = document.getElementById("c_sel");
			i = c_sel.selectedIndex;
			c_sel = c_sel.options[i].value;
			var c_sel3 = document.getElementById("c_sel3");
			i = c_sel3.selectedIndex;
			c_sel3 = c_sel3.options[i].value;
			var searchT = document.getElementById("searchT").value;//			searchT = searchT.value;
			document.view_form.mode.value = 'search';
			document.view_form.search_fld.value = c_sel; // column
			document.view_form.search_choice.value = c_sel3; // search type
			document.view_form.searchT.value = searchT; // search data
			document.view_form.action = 'tkher_program_data_list.php';
			document.view_form.submit();
		});
	});
	

	function Change_grant_view(cd, grant_view, pg_code){
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
						//console.log(data);
						alert("OK change --- " + grant_view);
						//location.replace(location.href);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" 올바르지 않습니다.-- kapp_column_ajax.php");
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
			//view_form.grant_view[selectIndex].value   = cd;
			//view_form.grant_view[selectIndex].text    = msg;
		}
	}	
	function Change_grant_write(cd, grant_write, pg_code){
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
						//console.log(data);
						alert("OK change --- " + grant_write);
						//location.replace(location.href);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" 올바르지 않습니다.-- kapp_column_ajax.php");
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
	function group_code_change_func(cd,pg_code){
		index = document.view_form.group_code.selectedIndex;
		//nm = document.view_form.group_code.options[index].text;
		//document.view_form.group_name.value = nm;
		//vv = document.view_form.group_code.options[index].value;
		//document.view_form.group_code.value = vv;
		document.view_form.mode.value = "project_search";
		document.view_form.action ="tkher_program_data_list.php";
		//document.view_form.action ="tkher_program_data_list.php?pg_code="+pg_code;
		document.view_form.submit();
		return;
	}
	function page_move($page){
		document.view_form.page.value = $page;
		document.view_form.action='tkher_program_data_list.php';
		document.view_form.submit();
	}
	// -->
 </script>
<body width='100%'>

<?php 
	$cur='B';
	include "./menu_run.php";

/*	
	if( isset($_REQUEST['c_sel']) ) $c_sel= $_REQUEST['c_sel'];
	else  $c_sel = "";
	if( isset($_REQUEST['c_sel3']) ) $c_sel3= $_REQUEST['c_sel3'];
	else  $c_sel3 = "";
*/
	if( isset($_REQUEST['searchT']) ) $searchT= $_REQUEST['searchT'];
	else if( isset($_POST['searchT']) ) $searchT= $_POST['searchT'];
	else  $searchT = "";

	if( isset($_REQUEST['search_fld']) ) $search_fld= $_REQUEST['search_fld']; // c_sel
	else if( isset($_POST['search_fld']) ) $search_fld= $_POST['search_fld'];
	else  $search_fld = "";

	if( isset($_REQUEST['search_choice']) ) $search_choice= $_REQUEST['search_choice']; // c_sel3
	else if( isset($_POST['search_choice']) ) $search_choice= $_POST['search_choice'];
	else  $search_choice = "";

	$fld_enm= array();
	$fld_hnm= array();
	$fld_type= array();
	$fld_len	= array();
	$list		= array();
	$item		= array(); 
	$ddd		= "";
	$list		= explode("@", $item_array);
	for ( $i=0; isset($list[$i]) && $list[$i] != ""; $i++ ){
		$ddd				= $list[$i];
		$item				= explode("|", $ddd);
		$fld_enm[$i]	= $item[1];
		$fld_hnm[$i]	= $item[2];
		$fld_type[$i]	= $item[3];
		$fld_len[$i]		= $item[4];
		if( $i==0 && !$search_fld) $search_fld = $item[1];
	}
	$item_cnt	= $fld_cnt=$i;
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;
	$in_day		= date("Y-m-d H:i");
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!=="" ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	if( $line_cnt < 10  ) $line_cnt	= 10;
	$page_cnt	= 10;
	
	/*$SQL1 = "SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' ";
	if( ( $result = sql_query( $SQL1 ) )==false ){
		printf("Invalid query: %s\n", $SQL1);
		m_("sql Error ");
		exit();
	} else {
		$my_rs = sql_fetch_array($result);
	}
	$levR= $my_rs['grant_view']; 
	$levW= $my_rs['grant_write']; 
	*/
?>
			<br>
			<div>
				<P onclick="javascript:home_func('<?=$pg_code?>')" class="HeadTitle03AX" title='table:<?=$tab_enm?> , pg code:<?=$pg_code?>'><?=$pg_name?></P>
			</div>
<?php
	$total_count = 0;
	$view_msg ='';
	if( $H_LEV >= $grant_view || $pg_mid == $H_ID ) {
			$SQL1 = "SELECT * from `$tab_enm` ";
			if( $mode=='search' ){
				if( $search_choice == "like")		$SQL1 = $SQL1 . " where `$search_fld` $search_choice '%$searchT%' ";
				else $SQL1 = $SQL1 . " where `$search_fld` $search_choice '$searchT' ";
			}
			if( ($result = sql_query( $SQL1 ) )==false ){
				printf("Invalid query: %s\n", $SQL1);
				echo "SQL:" . $SQL1; m_(" 4 Select Error ");
				$total_count = 0; exit;
			} else {
				$total_count = $result->num_rows;
				if( $total_count ) $total_page  = ceil($total_count / $line_cnt);
				else $total_page = 1;
				if( $page < 2 ) {
					$page = 1;
					$start = 0;
				} else {
					$start = ($page - 1) * $line_cnt;
				}
				$last = $line_cnt;
				if( $total_count < $last) $last = $total_count;
			}
	} else {
		$view_msg ='You do not have permission to view this material. The only level of permissions that can be viewed is that of the creator or higher. grant_view:'.$grant_view;
		//자료를 볼수 있는 권한이 없습니다. 볼수있는 권한은 생성자 이상의 레벨입니다.
	}

?>
		<form name='view_form' method='post' enctype="multipart/form-data" >
			<div style='width:99%;'>
				<div class="fl">
						<tr>
							<td align='left'>
								<script type="text/javascript" src="./include/js/dropdowncontent.js"></script>
								<p align="left" style="margin-top: 0px" title='pg: Project List '>

			<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value, '<?=$pg_code?>');" style='height:25px;background-color:#FFDF6E;border:1 solid black'>
							<option value=''>Select Project</option>
<?php
 if( isset($group_name) && $group_name !==''){
?>
							<option value='<?=$group_code?>' selected ><?=$group_name?></option>
<?php
			}
					if( $H_LEV > 7) $result = sql_query( "SELECT * from {$tkher['table10_group_table']} order by group_name " );
					else			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );
					while( $rs = sql_fetch_array( $result)) {
?>
							<option value='<?=$rs['group_code']?>' <?php if( $group_code==$rs['group_code']) echo ' selected '; ?> ><?=$rs['group_name']?></option>
<?php
					}
?>
			</select>
				<a href="#" id="contentlink" rel="subcontent2">
				<font color='black' ><b>&#9776; Program List [▼]</b></font>
				</a><?php if( isset($H_ID) ) echo "id:$H_ID, lev:$H_LEV"; ?> 
				</p>
				<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 300px; height: 100%px; padding: 4px;z-index:1000">
				<TABLE border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='150'>
<?php

	if( isset($H_ID) && $H_ID !=='' ) {
		/*if( isset( $group_code) ){
			$sql = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and group_code='" . $group_code . "' order by upday desc ";
		} else {
			 $sql = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' order by upday desc ";
		}*/
		if( $H_LEV > 7) $sql = "SELECT * from {$tkher['table10_pg_table']} where `group_code` ='" . $group_code . "' order by upday desc ";
		else			$sql = "SELECT * from {$tkher['table10_pg_table']} where `userid`='$H_ID' and `group_code`='" . $group_code . "' order by upday desc ";
		$result = sql_query( $sql );
		if( $result == false ){
			m_(" 2 Select Error ");
			echo "Invalid query sql:"; exit;
		}
	}	else {
			m_(" -----------Please login"); exit;
	}
	while ( $rs = sql_fetch_array( $result )  ) {
		$pg_codeA = $rs['pg_code'];
		$pg_nameA = $rs['pg_name'];
?>
			<tr>
			<td width='130' height='24' background='./icon/admin_submenu.gif'>&nbsp;<img src='./icon/left_icon.gif'>
			<a href="javascript:table_record_view('<?=$pg_codeA?>','<?=$pg_nameA?>');" target='_self'><?=$pg_nameA?></a>
			</td>
			</tr>
<?php
	}
?>
				</TABLE>
							<div align="right"><a href="javascript:dropdowncontent.hidediv('subcontent2')">Hide </a></div>
							</DIV>
								<script type="text/javascript">
									dropdowncontent.init("searchlink", "left-bottom", 300, "mouseover")
									dropdowncontent.init("contentlink", "right-bottom", 300, "click")
								</script>
							</div>
						</td>
					</tr>
				</DIV> 

				<div class="viewHeaderT">
					<span title='pg_mid:<?=$pg_mid?>, view level:<?=$grant_view?>'>&nbsp;&nbsp;
					K-APP:<?=$pg_code?>(<?=$grant_view?>)&nbsp;&nbsp;&nbsp;&nbsp;
					Total:<?=$total_count?>&nbsp;&nbsp;&nbsp;&nbsp; 
						<strong title='View page count'>Page:<?=$page?></strong>
						<select id='line_cntS' name='line_cntS' onChange="Change_line_cnt('<?=$pg_code?>', this.options[selectedIndex].value)" style='height:20;'>
							<option value='10'  <?php if($line_cnt=='10')  echo " selected" ?> >10</option>
							<option value='30'  <?php if($line_cnt=='30')  echo " selected" ?> >30</option>
							<option value='50'  <?php if($line_cnt=='50')  echo " selected" ?> >50</option>
							<option value='100' <?php if($line_cnt=='100') echo " selected" ?> >100</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp; 
					</span>
<?php
if( $H_ID==$pg_mid ) {
?>
					<span>
						<strong title='Set data view level'>Grant View: </strong>
						<select class="grant_view_func" id='grant_view' name='grant_view' onChange="Change_grant_view('<?=$grant_view?>', this.options[selectedIndex].value, '<?=$pg_code?>')" style='height:25;'>
							<option value='1' <?php if($grant_view=='0'||$grant_view=='1')  echo " selected"; ?> >Guest</option>
							<option value='2' <?php if($grant_view=='2')  echo " selected"; ?> >Member</option>
							<option value='3' <?php if($grant_view=='3')  echo " selected"; ?> >For creators only</option>
							<option value='8' <?php if($grant_view=='8')  echo " selected"; ?> >Only system manager</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp; 
						<strong title='Set data write level'>Grant Write: </strong>
						<select id='grant_write' name='grant_write' onChange="Change_grant_write('<?=$grant_write?>', this.options[selectedIndex].value, '<?=$pg_code?>')" style='height:25;'>
							<option value='1' <?php if($grant_write=='0'||$grant_write=='1')  echo " selected"; ?> >Guest</option>
							<option value='2' <?php if($grant_write=='2')  echo " selected"; ?> >Member</option>
							<option value='3' <?php if($grant_write=='3')  echo " selected"; ?> >For creators only</option>
							<option value='8' <?php if($grant_write=='8')  echo " selected"; ?> >Only system manager</option>
						</select>
					</span>
<?php
}// else echo " user: " . $pg_mid;
						echo "<br>".$view_msg;
?>

				</div>
						<input type="hidden" name='mode'			value='<?=$mode?>' />
						<input type="hidden" name='page'			value='<?=$page?>' />
						<input type="hidden" name='tab_enm'		value='<?=$tab_enm?>' />
						<input type="hidden" name='tab_hnm'		value='<?=$tab_hnm?>' />
						<input type="hidden" name="item_array"	value="<?=$item_array?>">
						<input type="hidden" name="item_cnt"		value="<?=$item_cnt?>">
						<input type="hidden" name='pg_title'		value='<?=$tit?>' />
						<input type="hidden" name='seqno'			value='' />
						<input type="hidden" name='no'				value='' />
						<input type="hidden" name='id'				value='<?=$H_ID?>' />
						<input type="hidden" name='c_sel'			value='<?=$c_sel?>' />
						<input type="hidden" name='c_sel3'			value='<?=$c_sel3?>' />
						<input type="hidden" name='target_'		value='<?=$target_?>' />
						<input type="hidden" name='pg_mid'		value='<?=$pg_mid?>' />
						<input type="hidden" name='tab_mid'		value='<?=$tab_mid?>' />
						<input type="hidden" name='data_mid'		value='' />
						<input type="hidden" name='pg_code'		value='<?=$pg_code?>' />
						<input type="hidden" name='pg_name'		value='<?=$pg_name?>' />
						<input type="hidden" name='group_name'		value="<?=$group_name?>" />
						<input type="hidden" name='fld_enm'		value='<?=$fld_enm?>' />
						<input type="hidden" name='fld_hnm'		value='<?=$fld_hnm?>' />
						<input type="hidden" name='fld_type'		value='<?=$fld_type?>' />
						<input type="hidden" name='fld_len'			value='<?=$fld_len?>' />
						<input type="hidden" name='search_fld'	value='<?=$search_fld?>' />
						<input type="hidden" name='search_choice'		value='<?=$search_choice?>' />
						<input type="hidden" name='line_cnt'		value='<?=$line_cnt?>' />
<?php
				for( $i=0;$i<$item_cnt;$i++){
?>
						<input type='hidden' name="iftype[<?=$i?>]" value='<?=$iftype[$i]?>' >
						<input type='hidden' name="if_data[<?=$i?>]" value='<?=$if_data[$i]?>' > 
<?php
				}
?>
	<table class='listTableT' width='99%'>
		<thead>
			<tr>
				<th style="width:30px; height: 100%px;text-align:center">No</th>
<?php
					for( $i=0; $i < $fld_cnt; $i++){
						$fff = $fld_hnm[$i];
						echo " <th class='cell03'>$fff</th> ";
					}
?>
			</tr>
		</thead>
		<tbody width=100%>
<?php
	if( $H_LEV>= $grant_view || $pg_mid == $H_ID ) {
			$SQL		= "SELECT * from $tab_enm ";
			$SQL_limit	= "  limit " . $start . ", " . $last;
			$OrderBy	= " order by seqno desc ";
			if( $mode == "search" ){
				if( $search_choice == "like") $SQL = $SQL . " where $search_fld $search_choice '%$searchT%' ";
				else $SQL = $SQL . " where $search_fld $search_choice '$searchT' ";
			} 
			$SQL = $SQL . $OrderBy . $SQL_limit;
			if( ($result = sql_query( $SQL ) )==false )	{
				printf("Record 0 : query: %s\n", $SQL);
			} else {
				if( $page > 1 ) $no=($page -1) * $line_cnt;
				else $no=0;
				while( $row = sql_fetch_array($result)  ) {
					$no++;
					$row_seqno = $row['seqno'];
					$data_mid = $row['kapp_userid'];
?>
					<tr>
						<td style="width:30px; height:100%px;text-align:center">
						 <a href="javascript:pg_record_view('<?=$row_seqno?>', '<?=$data_mid?>');" ><?=$no?></a></td>
<?php
						for( $i=0; $i < $fld_cnt; $i++){
							$fff = $fld_enm[$i];
							if( $fld_type[$i]=='INT' ){
								$num = number_format( $row[$fff] );
								echo " <td class='cell03'><a href=\"javascript:pg_record_view('".$row['seqno']."', '". $data_mid."');\" >$num</a></td> ";
							} else if( $fld_type[$i]=='TEXT' ){
								echo " <td class='cell04'>$row[$fff]</td> ";
							}
							else echo " <td class='cell03'><a href=\"javascript:pg_record_view('".$row['seqno']."', '". $data_mid."');\" >".$row[$fff]."</a></td> ";
						}
?>
					</tr>
<?php
				}	//while
			}// 
	} // grant_view
?>
		</tbody>
	</table>				
			<div class="fl">

						<select id='c_sel' name='c_sel' onChange='Change_Csel2(this.options[this.selectedIndex].value)' style='height:30;' >
<?php
					for( $i=0; $i < $fld_cnt; $i++ ){
						$fff		= $fld_enm[$i];
						$hhh		= $fld_hnm[$i];
						$search_fld_type = $fld_type[$i];
						echo " <option value='$fff' ";
						if($search_fld == $fff) echo " selected >$hhh</option>";
						else echo ">$hhh</option>";
					}
?>
						</select>
						<select id='c_sel3' name='c_sel3' onChange='Change_Csel3(this.options[this.selectedIndex].value)' style='height:30;'>
							<option value='like' <?php if($search_choice=='like' ) echo " selected " ?> >like</option>
							<option value='=' <?php if($search_choice=='=' ) echo " selected " ?> >=</option>
							<option value='>' <?php if($search_choice=='>') echo " selected" ?> >></option>
							<option value='<' <?php if($search_choice=='<') echo " selected" ?> ><</option>
						</select>

						<input type="text" name='searchT' id='searchT'  value='<?=$searchT?>' style='height:30;' />

						<a href="#" class="search_btn">Search</a>
						<br>
							<div class="fr">
							<input type='button' value='Write' onclick="javascript:table_record_write('<?=$pg_code?>','<?=$grant_write?>','<?=$H_LEV?>');" class="btn_bo02T" title='table_pg70_write'>

						<input type='button' value='Excel Down' onclick="javascript:excel_down();" class="Btn_List03A" title=' Download data as an Excel file'>
						<input type='button' value='Source Down' onclick="javascript:tkher_source_create('<?=$H_POINT?>')" class="Btn_List03A" title='Program source creation and Download the source. point:<?=$H_ID?>=<?=$H_POINT?>'>
					</form>
			</div> 
<?php
	paging("tkher_program_data_list.php?pg_code=$pg_code&pg_name=$pg_name&search_choice=$search_choice&searchT=$searchT&id=$H_ID",$total_count,$page,$line_cnt); 
?> 

</body>
</html>
