<?php
	include_once('./tkher_start_necessary.php');

	/* ----------------------------------------------------------------------
	kapp_program_data_list.php - copy - tkher_program_data_list.php
	tkher_program_data_list.php?pg_code=dao_1540779796  : data list   system program , popup , calc
    kapp_program_data_write.php - copy - tkher_program_run.php
	tkher_program_run.php?pg_code=dao_1693896214		: data insert system program , call : table10i.php, app_pg50RC.php 에서 call
    tkher_program_data_update.php						: data update system program
	tkher_program_data_view.php							: data view   system program

		tkher_program_data_list.php : table data list.
		- call : tkher_program_run.php : data insert program.
		- call : program_list3.php 
		https://tkher.com/t/t_login.php?pg_code=dao_1537317833
	---------------------------------------------------------------------- */
	include "./kapp_data_list_paging.php";
	$H_ID  = get_session("ss_mb_id"); 
	if( isset($H_ID) && $H_ID !='' ) {
		$H_LEV = $member['mb_level']; 
		$H_POINT	= $member['mb_point']; 
	} else {
		$H_LEV = 1; 
		$H_POINT= 0; 
	}
	if( isset( $_GET['pg_code']) ){
		$pg_code= $_GET['pg_code'];
	} else if( isset( $_REQUEST['pg_code']) ){
		$pg_code= $_REQUEST['pg_code'];
	} else if( isset( $_POST['pg_code']) ){
		$pg_code= $_POST['pg_code'];
	} else {
		$pg_code = ''; 
		m_("ERROR - pg_code is NULL"); exit;
	}
	if( isset( $_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else if( isset( $_POST['mode']) ) $mode= $_POST['mode'];
	else $mode = '';
	if( isset( $_POST['fld_code_pg']) ) $fld_code_pg= $_POST['fld_code_pg'];
	else $fld_code_pg = '';
	if( isset( $_POST['fld_code_asc_pg']) ) $fld_code_asc_pg= $_POST['fld_code_asc_pg'];
	else $fld_code_asc_pg = '';
	if( $mode == "project_search" ) $group_code = $_POST['group_code'];
	else if( isset( $_POST['group_code']) ) $group_code= $_POST['group_code'];
	else $group_code = '';
	$pg_mid= ''; $tab_mid= ''; 

	if( isset($_REQUEST['search_fld']) ) $search_fld= $_REQUEST['search_fld']; // c_sel
	else if( isset($_POST['search_fld']) ) $search_fld= $_POST['search_fld'];
	else  $search_fld = "";
	if( isset($_REQUEST['search_choice']) ) $search_choice= $_REQUEST['search_choice']; //c_sel3
	else if( isset($_POST['search_choice']) ) $search_choice= $_POST['search_choice'];
	else  $search_choice = "";
	if( isset($_REQUEST['searchT']) ) $searchT= $_REQUEST['searchT'];
	else if( isset($_POST['searchT']) ) $searchT= $_POST['searchT'];
	else  $searchT = "";

	$sqlPG ="SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$rsPG =sql_fetch($sqlPG);
	if( isset($rsPG['item_array']) && $rsPG['item_array'] !=''){
		$table_item_array = $rsPG['item_array'];
		$if_data = $rsPG['if_data'];
		$if_type = $rsPG['if_type'];
		$tab_enm = $rsPG['tab_enm'];
		$tab_hnm = $rsPG['tab_hnm'];
		$item_cnt = $rsPG['item_cnt']; //$fld_cnt = $rsPG['item_cnt'];
		$pg_name = $rsPG['pg_name']; 
		$pg_mid= $rsPG['userid']; 
		$tab_mid= $rsPG['tab_mid']; 
		$grant_view= $rsPG['grant_view']; 
		$grant_write= $rsPG['grant_write']; 
		if( $group_code=='') $group_code= $rsPG['group_code'];
		$group_name= $rsPG['group_name'];
	} else {
			m_(" program name ERROR : table10_pg , pg_name:$pg_name , pg_code:$pg_code NO Found! "); exit;
	}
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

<script src="//code.jquery.com/jquery.min.js"></script>
<script>
$(function () {
	let timer;
	thisform = document.Kapp_HtmlForm;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			$hnm = e.target.innerText;
			$enm = document.getElementById($hnm).value;
			Kapp_ProgramJS.title_func(thisform,$enm);
		}, 250); // Executes after waiting about 250ms - 약 250ms 대기 후 실행
	  
	});
	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer); // Remove last click timer - 마지막 클릭 타이머를 제거
		$hnm = e.target.innerText;
		$enm = document.getElementById($hnm).value;
		Kapp_ProgramJS.title_wfunc(thisform,$enm);
	});

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
	$('.search_btn').on('click', function() {
		var search_fld = document.getElementById("search_fld");
		i = search_fld.selectedIndex;
		search_fld = search_fld.options[i].value;
		var search_choice = document.getElementById("search_choice");
		i = search_choice.selectedIndex;
		search_choice = search_choice.options[i].value;
		document.view_form.mode.value = 'search';
		document.view_form.search_fld.value = search_fld;
		document.view_form.search_choice.value = search_choice;
		document.view_form.action = 'kapp_program_data_list.php';
		document.view_form.submit();
	});
});
</script>

<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/kapp_data.js"></script>
<!-- <link type="text/css" rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/kapp_basic.css" /> -->
<body style="background-color:#fff; width:100%;" >

<?php
	$cur='B';
	include "./menu_run.php";

	$fld_enm= array();
	$fld_hnm= array();
	$fld_type= array();
	$fld_len	= array();
	$list		= array();
	$item		= array(); 
	$item_A	= "";	//$in_day= date("Y-m-d H:i");
	$list		= explode("@", $table_item_array);
	for( $i=0; isset($list[$i]) && $list[$i] != ""; $i++ ){
		$item_A		= $list[$i];
		$item			= explode("|", $item_A);
		$fld_enm[$i]	= $item[1];
		$fld_hnm[$i]	= $item[2];
		$fld_type[$i]	= $item[3];
		$fld_len[$i]		= $item[4];
		if( $i==0 && !$search_fld) $search_fld = $item[1];
	}
	$item_cnt=$i;
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!="" ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_cnt	= 10;

	$total_count = 0;
	$view_msg ='';
	if( $H_LEV >= $grant_view || $pg_mid == $H_ID ) {
			$SQL1 = "SELECT * from `$tab_enm` ";
			if( $search_choice != '' && $searchT !='') {   
				if( $search_choice == "like")		$SQL1 = $SQL1 . " where `$search_fld` $search_choice '%$searchT%' ";
				else $SQL1 = $SQL1 . " where `$search_fld` $search_choice '$searchT' ";
			} 
			if( ($result = sql_query( $SQL1 ) )==false ){
				echo "Invalid query: " . $SQL1;
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
		$view_msg ='You do not have permission to view this material. <br>The only level of permissions that can be viewed is that of the creator or higher. grant_view:'.$grant_view;
	}
?>
<FORM id='Kapp_HtmlForm' name='Kapp_HtmlForm' method='post' enctype="multipart/form-data" >
<br>
<div>
	<P onclick="javascript:Kapp_ProgramJS.kapp_program_data_list_home_func(this.form);" class="HeadTitle03AX" title='list - home_func - table:<?=$tab_enm?> , pg code:<?=$pg_code?>'><?=$pg_name?></P>
</div>
<script type="text/javascript" src="./include/js/dropdowncontent.js"></script>

<div style='width:99%;'>
	<div class="fl">
		<tr>
			<td align='left'>
			<P align="left" style="margin-top: 0px" title='pg: Project List '>
			<SELECT id='group_code' name='group_code' onchange="this.form.submit()" style='height:25px;background-color:#FFDF6E;border:1 solid black'>
					<option value=''>Select Project</option>
<?php
			if( $H_LEV > 7) $result=sql_query( "SELECT * from {$tkher['table10_group_table']} order by group_name " );
			else $result=sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );

			while( $rs = sql_fetch_array( $result)) {
				$chk = '';
				if( $group_code == $rs['group_code'] ) $chk =' selected ';
?>
				<option value='<?=$rs['group_code']?>' <?php echo $chk; ?> ><?=$rs['group_name']?></option>
<?php
			}
?>
			</select>
			<a href="#" id="contentlink" rel="subcontent2"><font color='black' ><b>&#9776; Program List [▼]</b></font></a>
<?php 
	if( isset($H_ID) ) echo "id:$H_ID, lev:$H_LEV"; 
?> 
			</P>
				<DIV id="subcontent2" style="position:absolute; visibility: hidden; border: 9px solid black; background-color: lightyellow; width: 270px; height: 100%px; padding: 4px;z-index:1000">
				<TABLE border='0' cellpadding='1' cellspacing='0' bgcolor='#cccccc' width='240'>
<?php
	if( $H_LEV > 7) $sqlA = "SELECT * from {$tkher['table10_pg_table']} where `group_code` ='" . $group_code . "' order by upday desc ";
	else			$sqlA = "SELECT * from {$tkher['table10_pg_table']} where `userid`='$H_ID' and `group_code`='" . $group_code . "' order by upday desc ";
	$result = sql_query( $sqlA );
	if( $result == false ){
		m_(" 2 Select Error ");
		echo "Invalid query sql:"; exit;
	}
	while( $rs = sql_fetch_array( $result )  ) {
		$pg_codeA = $rs['pg_code'];
		$pg_nameA = $rs['pg_name'];
		$tab_enmA = $rs['tab_enm'];
?>
		<tr>
		<td width='270' height='24' background='./icon/admin_submenu.gif'>
			<a href="javascript:Kapp_ProgramJS.kapp_program_listAll(this.form, '<?=$pg_codeA?>', '<?=$tab_enmA?>');" title='<?=$pg_codeA?>:<?=$tab_enmA?>'><img src='./icon/left_icon.gif'><?=$pg_nameA?></a>
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
					K-APP:<?=$pg_code?>&nbsp;&nbsp;&nbsp;&nbsp;
					Total:<?=$total_count?>&nbsp;&nbsp;&nbsp;&nbsp; 
						<strong title='View page count'>Page:<?=$page?></strong>
		<SELECT name='line_cnt' onChange="this.form.submit()" style='height:20;'>
					<option value='10'  <?php if($line_cnt=='10')  echo " selected" ?> >10</option>
					<option value='30'  <?php if($line_cnt=='30')  echo " selected" ?> >30</option>
					<option value='50'  <?php if($line_cnt=='50')  echo " selected" ?> >50</option>
					<option value='100' <?php if($line_cnt=='100') echo " selected" ?> >100</option>
		</SELECT>&nbsp;&nbsp;&nbsp;&nbsp; 
					</span>
<?php
if( $H_ID==$pg_mid ) {
?>
					<span>
						<strong title='Click to change properties'>View: </strong>
						<select class="grant_view_func" id='grant_view' name='grant_view' onChange="Kapp_ProgramJS.Change_grant_view_list( this.form, '<?=$grant_view?>', this.options[selectedIndex].value, '<?=$pg_code?>')" style='height:25;' title='Click to change properties'>
							<option value='1' <?php if($grant_view=='0'||$grant_view=='1')  echo " selected"; ?> >Guest</option>
							<option value='2' <?php if($grant_view=='2')  echo " selected"; ?> >Member</option>
							<option value='3' <?php if($grant_view=='3')  echo " selected"; ?> >For creators only</option>
							<option value='8' <?php if($grant_view=='8')  echo " selected"; ?> >Only system manager</option>
						</select>&nbsp;&nbsp;&nbsp;&nbsp; 
						<strong title='Click to change properties'>Write: </strong>
						<select id='grant_write' name='grant_write' onChange="Kapp_ProgramJS.Change_grant_write_list( this.form, '<?=$grant_write?>', this.options[selectedIndex].value, '<?=$pg_code?>')" style='height:25;' title='Click to change properties'>
							<option value='1' <?php if($grant_write=='0'||$grant_write=='1')  echo " selected"; ?> >Guest</option>
							<option value='2' <?php if($grant_write=='2')  echo " selected"; ?> >Member</option>
							<option value='3' <?php if($grant_write=='3')  echo " selected"; ?> >For creators only</option>
							<option value='8' <?php if($grant_write=='8')  echo " selected"; ?> >Only system manager</option>
						</select>
					</span>
<?php
}
		echo "<br><p style='font-size:25px;'>".$view_msg . "</p><br>";
?>
				</div>
						<input type="hidden" name='pg_call'			value='' />
						<input type="hidden" name='mode'			value='<?=$mode?>' />
						<input type="hidden" name='fld_code_pg'		value='<?=$fld_code_pg?>' />
						<input type="hidden" name='fld_code_asc_pg'	value='<?=$fld_code_asc_pg?>' />
						<input type="hidden" name='page'			value='<?=$page?>' />
						<input type="hidden" name='tab_enm'		value='<?=$tab_enm?>' />
						<input type="hidden" name='tab_hnm'		value='<?=$tab_hnm?>' />
						<input type="hidden" name="table_item_array"	value="<?=$table_item_array?>">
						<input type="hidden" name="item_cnt"		value="<?=$item_cnt?>">
						<input type="hidden" name='pg_title'		value='<?=$tit?>' />
						<input type="hidden" name='seqno'			value='' />
						<input type="hidden" name='no'				value='' />
						<input type="hidden" name='id'				value='<?=$H_ID?>' />
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

						<input type="hidden" name='H_LEV'		value='<?=$H_LEV?>' />

	<table class='listTableT' width='99%'>
		<thead id='tit_et'>
			<tr>
				<th style="width:30px; height: 100%px;text-align:center">No</th>
<?php
		for( $i=0; $i < $item_cnt; $i++){
			$fhnm = $fld_hnm[$i];
			$fenm = $fld_enm[$i];
			echo " <th title='$fenm:$fhnm Sort click or doubleclick' >$fhnm</th> ";
			echo "<input type='hidden' id='$fhnm' name='$fhnm' value='$fenm' >";
		}
?>
			</tr>
		</thead>
		<tbody width='100%'>
<?php
	if( $H_LEV>= $grant_view || $pg_mid == $H_ID ) {
			$SQL		= "SELECT * from $tab_enm ";
			$SQL_limit	= "  limit " . $start . ", " . $last;
			if( $mode == "search" ){
				if( $search_choice == "like") $SQL = $SQL . " where $search_fld $search_choice '%$searchT%' ";
				else $SQL = $SQL . " where $search_fld $search_choice '$searchT' ";
			} else {     
				if( $search_choice != '' && $searchT !='') {     
					if( $search_choice == 'like' )	$SQL = $SQL . " where $search_fld $search_choice '%$searchT%' ";  
					else					$SQL = $SQL . " where $search_fld $search_choice '$searchT' ";       
				}     
			}
			if( $fld_code_pg!='' ) $OrderBy = " ORDER BY $fld_code_pg $fld_code_asc_pg ";    
			else $OrderBy	= " ORDER BY seqno desc ";
			$SQL = $SQL . $OrderBy;
			$SQL = $SQL . $SQL_limit;
			if( ($result = sql_query( $SQL ) )==false )	{
				printf("Record 0 : query: %s\n", $SQL); exit;
			} else {
				if( $page > 1 ) $no=($page -1) * $line_cnt;
				else $no=0;
				while( $row = sql_fetch_array($result)  ) {
					$no++;
					$row_seqno = $row['seqno'];
					if( isset($row['kapp_memo']) ) $kapp_memo = $row['kapp_memo'];
					else $kapp_memo ='';
					if( isset($row['kapp_userid']) ) $data_mid = $row['kapp_userid'];
					else $data_mid = '';//$H_ID;
?>
					<tr>
						<td style="width:30px; height:100%px;text-align:center" title='<?=$row_seqno?>, <?=$kapp_memo?>'><?=$no?></td>
<?php
						for( $i=0; $i < $item_cnt; $i++){
							$fenm = $fld_enm[$i];
							if( $fld_type[$i]=='INT' || $fld_type[$i]=='BIGINT' ){
								$num = number_format( $row[$fenm] );
echo " <td class='cell03' title='$row_seqno, $kapp_memo'><a href=\"javascript:Kapp_ProgramJS.kapp_program_data_view(this.form, ".$row['seqno'].", '". $data_mid."');\" >$num</a></td> ";
							} else if( $fld_type[$i]=='TEXT' ){
								echo " <td class='cell04' title='$row_seqno, $kapp_memo'>$row[$fenm]</td> ";
							} else
								echo " <td class='cell03' title='$row_seqno, $kapp_memo'><a href=\"javascript:Kapp_ProgramJS.kapp_program_data_view(this.form, ".$row['seqno'].", '". $data_mid."');\" >".$row[$fenm]."</a></td> ";
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
		<SELECT id='search_fld' name='search_fld' style='height:30;'>
<?php
		for( $i=0; $i < $item_cnt; $i++ ){
			$fff		= $fld_enm[$i];
			$hhh		= $fld_hnm[$i];
			$search_fld_type = $fld_type[$i];
			echo " <option value='$fff' ";
			if( $search_fld == $fff) echo " selected >$hhh</option>";
			else echo ">$hhh</option>";
		}
?>
		</select>
		<SELECT id='search_choice' name='search_choice' style='height:30;'>
				<option value='=' >=</option>
				<option value='=' <?php if($search_choice=='=' ) echo " selected " ?> >=</option>
				<option value='>' <?php if($search_choice=='>') echo " selected" ?> >></option>
				<option value='<' <?php if($search_choice=='<') echo " selected" ?> ><</option>
				<option value='like' <?php if($search_choice=='like' ) echo " selected " ?> >like</option>
		</select>
		<input type="text" name='searchT' id='searchT' value='<?=$searchT?>' style='height:30;' />
		<a href="#" class="search_btn">Search</a>
				<br>
					<div class="fr">
<input type='button' onclick="javascript:Kapp_ProgramJS.table_record_write_list(this.form, '<?=$H_LEV?>', '<?=$grant_write?>');" value=" Write " class="kapp_btn_bo02" title='kapp_program_data_list' />

				<input type='button' value='Excel_Upload' onclick="havascript:Kapp_ProgramJS.excel_upload_list_func( this.form, '<?=$tab_enm?>','<?=$tab_hnm?>');" class='kapp_btn_bo03' title='Batch upload of data to excel file'>
				<input type='button' value='Excel Down' onclick="javascript:Kapp_ProgramJS.excel_down(this.form, '<?=$H_ID?>');" class="kapp_btn_bo02" title=' Download data as an Excel file'>
				<input type='button' value='Source Down' onclick="javascript:Kapp_ProgramJS.tkher_source_createDN(this.form,'<?=$H_POINT?>');" class="kapp_btn_bo02" title='Program source creation and Download the source. point:<?=$H_ID?>=<?=$H_POINT?>'>
	</div> 
<?php
	paging("kapp_program_data_list.php?pg_code=$pg_code",$total_count,$page,$line_cnt, "document.Kapp_HtmlForm"); 
?> 

</form>
</body>
</html>
