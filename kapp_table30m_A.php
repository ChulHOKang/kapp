<?php
	include_once('./tkher_start_necessary.php');
	/*
	 * kapp_table30m_A.php : table30m_Create.php copy 2023-08-25 - kan
		- include_once("./include/lib/kapp_table_func.php");
		- <script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/kapp_table.js"></script>
		: column 속성을 추가또는 변경시에는 kapp_table_list.php - Change need.
		: TAB_curl_sendA( $tab_enm, $tab_hnm,0 , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo );
	 */
	include_once("./include/lib/kapp_table_func.php");

	$H_ID= get_session("ss_mb_id");
	$ip = $_SERVER['REMOTE_ADDR'];
	if( !isset($H_ID) ){
		m_("You need to login.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else $mode='';
	if( isset($_POST['old_tab_enm']) ) $old_tab_enm= $_POST['old_tab_enm'];
	else $old_tab_enm='';

	$project_nmS = '';
	$project_name= '';
	$project_code= '';
	$tab_hnmS = '';
	$tab_enm = '';
	$tab_hnm = '';
	$new_tab_hnm = '';
	
		if( isset($_POST['project_nmS']) && $_POST['project_nmS'] !='' ) {
			$project_nmS = $_POST['project_nmS'];
			$pcd_nm = explode(":", $project_nmS );
			if( isset($pcd_nm[0]) && $pcd_nm[0] !=='' ) $project_code	= $pcd_nm[0];
			else $project_code = '';	
			if( isset($pcd_nm[1]) && $pcd_nm[1] !=='' ) $project_name	= $pcd_nm[1]; 
			else $project_name= '';
		}
		if( isset($_POST['tab_hnmS']) && $_POST['tab_hnmS'] !='' ) {
			$tab_hnmS =$_POST['tab_hnmS'];
			$tab_R = explode(":", $tab_hnmS);
			$tab_enm = $tab_R[0];
			$tab_hnm = $tab_R[1];
			$new_tab_hnm = $tab_R[1];
		}
	if( $mode == 'Project_Search'){
		$project_nmS = $_POST['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		if( isset($pcd_nm[0]) ) $project_code	= $pcd_nm[0];
		if( isset($pcd_nm[1]) ) $project_name	= $pcd_nm[1]; 
	} else if( $mode == 'SearchTAB' ) {
		$tab_hnmS =$_POST['tab_hnmS'];
		$tab_R = explode(":", $tab_hnmS);
		if( isset($tab_R[0])) $tab_enm = $tab_R[0];
		if( isset($tab_R[1])) {
			$tab_hnm = $tab_R[1];
			$new_tab_hnm = $tab_R[1];
		}
		//$project_code = $tab_R[2];
		//$project_name = $tab_R[3];
	}
	$uid = explode('@', $H_ID);
	$new_tab_enm = $uid[0] . "_" . time();
	if( isset($_POST['line_set']) ) $line_set = $_POST['line_set'];
	else $line_set = 10;
	if( isset($_POST['del_mode']) ) $del_mode = $_POST['del_mode'];
	else $del_mode = '';
	if( isset($_POST['pg_mode']) ) $pg_mode = $_POST['pg_mode'];
	else $pg_mode = '';
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
	body, td, tr { font-size:10pt}
	a:link, a:visited, a:active {text-decoration:none; font-size:10pt; color:black}
	a:hover {text-decoration:yes; font-size:10pt; color:eeeeee}
	p { font-size:24px; text-align:left; height:25px; margin-left:33px; padding: 3px; }

	table {}
	th, td { padding: 1px; text-align:center; border-bottom:0px solid #DDD; }
	tr:hover {background-color: #A6EEEE;}
</style>

<script src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/kapp_table.js"></script>
<script>
	$(function () {
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
<body style="background-color:#fff; width:100%;" >
<center>
<?php
	if( $del_mode == 'column_modify_mode' ){ // column update - no use
		if( isset( $_POST['add_column_enm']) ) $fld_enm=$_POST['add_column_enm'];
		else return;
		if( !Kcolumn_check($fld_enm) ) return;
		$table_yn	=$_POST['table_yn'];
		$fld_hnm	=$_POST['add_column_hnm'];
		$fld_type	=$_POST['add_column_type'];
		$fld_len	=$_POST['add_column_len'];
		$fld_memo	=$_POST['add_column_memo'];
		$seqno		=$_POST['del_seqno'];
		if( $table_yn =='y' ) {
			if( $fld_type== 'CHAR' || $fld_type== 'VARCHAR' ) {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type . "(". $fld_len .") DEFAULT NULL";
			} else if( $fld_type== 'INT' || $fld_type =='BIGINT' || $fld_type =='TINYINT' || $fld_type =='SMALLINT' || 'MEDIUMINT' || $fld_type =='FLOAT' || $fld_type =='DOUBLE' || $fld_type =='DECIMAL' ) {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type . " DEFAULT 0 ";
			} else {
				$query = "ALTER TABLE ". $tab_enm . " MODIFY " . $fld_enm . " " . $fld_type ;
			}
			$mq1=sql_query($query);
			if( $mq1 ) {
				sql_query( "UPDATE {$tkher['table10_table']} set  fld_hnm= '$fld_hnm', fld_type= '$fld_type', fld_len=$fld_len, memo='$fld_memo' where seqno=$seqno " );
				m_(" column update OK!! ");
			}
			else {
				printf(" sql:%s ", $query);
				m_(" column modify error------------!! ");
			}
		} else {
			$sql = "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len=$fld_len, userid='$H_ID', memo='$fld_memo', disno=$dis ";
			$ret = sql_query( $sql );
			if( $ret ) m_(" table10 column add OK!! ");
			else {
					echo "sql: " . $sql; exit;
			}
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";

	} else if( $del_mode == 'column_add_mode' ){
		$table_yn	=$_POST['table_yn'];
		$dis		=$_POST['disno'];
		$fld_enm =$_POST['add_column_enm'];
		$fld_hnm =$_POST['add_column_hnm'];
		$fld_type=$_POST['add_column_type'];
		$fld_len =$_POST['add_column_len'];
		$fld_memo=$_POST['add_column_memo'];
		if( $table_yn =='y' ) {
			if( $fld_type== 'CHAR' || $fld_type== 'VARCHAR' ) {
				$query = "ALTER TABLE ". $tab_enm . " ADD COLUMN " . $fld_enm . " " . $fld_type . "(". $fld_len .") DEFAULT NULL ";
			} else if( $fld_type== 'INT' || $fld_type =='BIGINT' || $fld_type =='TINYINT' || $fld_type =='SMALLINT' || 'MEDIUMINT' || $fld_type =='FLOAT' || $fld_type =='DOUBLE' || $fld_type =='DECIMAL' ) {
				$query = "ALTER TABLE ". $tab_enm . " ADD COLUMN " . $fld_enm . " " . $fld_type . " DEFAULT 0 ";
			} else {
				$query = "ALTER TABLE $tab_enm ADD COLUMN $fld_enm $fld_type ";
			}
			$mq1 =sql_query($query);
			if( $mq1 ) {
				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len=$fld_len, userid='$H_ID', memo='$fld_memo', disno=$dis " );
				m_(" column add OK!! ");
			}
			else {
				echo " sql:" . $query; m_(" column add error------------!! ");	
			}
		} else {
				sql_query( "INSERT INTO {$tkher['table10_table']} set group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', userid='$H_ID', memo='$fld_memo', disno=$dis " );
				m_(" table10 column add OK!! ");
		}
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";

	} else if( $del_mode == 'Delete_column_mode' ){
		$seqno	= $_POST["del_seqno"]; 
		$fld_enm	= $_POST["del_fld_enm"];
		$query = "ALTER TABLE $tab_enm drop $fld_enm ";
		$mq1	=sql_query($query);
		$query = "DELETE from {$tkher['table10_table']} where userid='" .$H_ID. "' and seqno = ". $_POST["del_seqno"];
		$mq2	=sql_query($query);
		echo "<script>create_after_run( '$tab_enm' , '$tab_hnm' , '$del_mode' );</script>";
	}
	if( $mode == "table_create_reaction" ){
		KAPP_Table_Create_Reaction_Func(); // line reset
	} else if( $mode == "table_update_remake" ){
		$view_set=1;
		$tab_enm = $_POST['old_tab_enm'];
		KAPP_Table_Update_Remake_Func( $tab_enm ); // drop and remake
	} else if( $mode == "table_create" ) {
		KAPP_Table_Create_Func();
	} else if( $mode == "table_new_copy" ){	// copy and new.
		Copy_Table_Func();
	}
?>
<?php
		$cur='B';
		include_once "./menu_run.php";
		$userid	= $H_ID;
		$record_cnt = 0;
		$Aseqno		= array();
		$Afld_enm	= array();
		$Afld_hnm	= array();
		$Afld_type	= array();
		$Afld_len	= array();
		$Amemo		= array();
	
	if( $mode == 'SearchTAB'){
		$aa = explode(':', $tab_hnmS);
		$tab_enm = $aa[0];
		$tab_hnm = $aa[1];
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enm' order by disno" );
		$record_cnt = sql_num_rows($result);
		$ARR=0;
		$item_array = "";
		$if_type = "";
		$if_data = "";
		while( $rs = sql_fetch_array($result)) {
				$fld_enm		= $rs['fld_enm'];
				$fld_hnm		= $rs['fld_hnm'];
			if($rs['fld_enm'] == 'seqno' )	{
				$userid				= $rs['userid']; 
				$project_code		= $rs['group_code'];
				$project_name		= $rs['group_name'];
				$tab_enm			= $rs['tab_enm'];
				$tab_hnm			= $rs['tab_hnm'];
				$table_yn			= $rs['table_yn'];
				$disno				= $rs['disno'];
				$Aseqno[0]			= $rs['seqno'];
				$Afld_enm[0]		= $rs['fld_enm'];
				$Afld_hnm[0]		= $rs['fld_hnm'];
				$Afld_type[0]		= $rs['fld_type'];
				$Afld_len[0]		= $rs['fld_len'];
				$Amemo[0]			= $rs['memo'];
			}else {
				$table_yn			= $rs['table_yn'];
				$ARR++;
				$Aseqno[$ARR]		= $rs['seqno'];
				$Afld_enm[$ARR]		= $rs['fld_enm'];
				$Afld_hnm[$ARR]		= $rs['fld_hnm'];
				$Afld_type[$ARR]		= $rs['fld_type'];
				$Afld_len[$ARR]		= $rs['fld_len'];
				$Amemo[$ARR]		= $rs['memo'];
				$fld_type	= $rs['fld_type'];
				$fld_len		= $rs['fld_len'];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
			}
		}//while
		$disno = $ARR +1;

		if( $pg_mode=="on" ){
			$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_code='$tab_enm' ";
			$resultPG = sql_query($sqlPG);
			$table10_pg = sql_num_rows($resultPG);
			if( $table10_pg ) {
				$query="UPDATE {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', item_cnt=$ARR, item_array='$item_array' WHERE userid='$H_ID' and pg_code='$tab_enm' ";
				sql_query($query);
			} else {
				$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', relation_type='',relation_data='', item_cnt=$cnt, userid='$H_ID', tab_mid='$H_ID' ";
				sql_query($query);
				$link_ = KAPP_URL_T_ . "kapp_table30m_A.php";
			}
			$pg_mode="";
		}
	} else if( $mode == "line_set" ) {
		$aa = explode(':', $tab_hnmS);
		$tab_enm = $aa[0];
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enm' order by disno" );
		$record_cnt = sql_num_rows($result);
		$ARR=0;
		while( $rs = sql_fetch_array($result)) {
				$fld_enm		= $rs['fld_enm'];
				$fld_hnm		= $rs['fld_hnm'];
			if( $rs['fld_enm'] == 'seqno' )	{
				$userid				= $rs['userid'];
				$tab_enm			= $rs['tab_enm'];
				$tab_hnm			= $rs['tab_hnm'];
				$table_yn			= $rs['table_yn'];
				$disno				= $rs['disno'];
				$Aseqno	[0]			= $rs['seqno'];
				$Afld_enm[0]		= $rs['fld_enm'];
				$Afld_hnm[0]		= $rs['fld_hnm'];
				$Afld_type[0]		= $rs['fld_type'];
				$Afld_len[0]		= $rs['fld_len'];
				$Amemo[0]			= $rs['memo'];
				$Aif_line[0]		= $rs['if_line']; 
				$Aif_type[0]		= $rs['if_type']; 
				$Aif_data[0]		= $rs['if_data']; 
				$Arelation_data[0]	= $rs['Arelation_data']; 
			} else {
				$table_yn			= $rs['table_yn'];
				$ARR++;
				//$disno				= $rs['disno'];
				$Aseqno[$ARR]		= $rs['seqno'];
				$Afld_enm[$ARR]		= $rs['fld_enm'];
				$Afld_hnm[$ARR]		= $rs['fld_hnm'];
				$Afld_type[$ARR]	= $rs['fld_type'];
				$Afld_len[$ARR]		= $rs['fld_len'];
				$Amemo[$ARR]		= $rs['memo'];
				$Aif_line[$ARR]		= $rs['if_line']; 
				$Aif_type[$ARR]		= $rs['if_type']; 
				$Aif_data[$ARR]		= $rs['if_data']; 
				$Arelation_data[$ARR]= $rs['Arelation_data']; 
			}
		}//while
	}
?>
	<Form METHOD='POST' name='kapp_table_Form' enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" >
		<input type="hidden" name="old_tab_enm" id="old_tab_enm" value='<?=$old_tab_enm?>'>
		<input type="hidden" name="new_tab_enm" id="new_tab_enm" value='<?=$new_tab_enm?>'>
		<input type="hidden" name="project_code" id="project_code" value='<?=$project_code?>'>
		<input type="hidden" name="project_name" id="project_name" value='<?=$project_name?>'>
		<input type="hidden" name="line_index" >
		<input type="hidden" name="no" ><!-- use fld_select.php -->
		<input type="hidden" name="thisform" value='document.kapp_table_Form'><!-- use fld_select.php -->
		<input type="hidden" name="pg_mode" >
		<input type="hidden" name="del_mode" >
		<input type="hidden" name="del_seqno" >
		<input type="hidden" name="del_fld_hnm" >
		<input type="hidden" name="del_fld_enm" >
		<input type="hidden" name="userid" value='<?=$userid?>'> <!--  H_ID -->
		<input type="hidden" name="disno" value='<?=$disno?>'>
		<input type="hidden" name="add_column_no" value=''>
		<input type="hidden" name="add_column_enm" >
		<input type="hidden" name="add_column_hnm" >
		<input type="hidden" name="add_column_type" >
		<input type="hidden" name="add_column_len" >
		<input type="hidden" name="add_column_memo" >
		<input type="hidden" name="table_yn" value='<?=$table_yn?>'>

		<h2><font fce="Arial">Table Design High Level<?php if( $mode=='SearchTAB' ) echo "( Change )"; ?></font></h2>

<div>
	<ul><!-- onchange="change_project_func(this.value)" -->
		<span bgcolor='#f4f4f4' <?php echo "title='You can change or add the group name of the table.' "; ?>><font color='black'>Project</span>
		<span bgcolor='#ffffff'><!-- this.form.submit() , change_project_func(this.value);-->
			<SELECT id='project_nmS' name='project_nmS' onchange="this.form.submit()" style="width:250px;height:30px;background-color:#FFDF6E;border:1 solid black" title='Select the classification of the table to be registered. <?=$project_nmS?> , <?=$project_name?>'>
<?php 
		echo "<option value=''>1.Select Project</option>";
		if( isset( $project_nmS) && $project_nmS !=''  ) echo "<option value='$project_nmS' selected >$project_name</option>";

		$result= sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " ); 
		while( $rs = sql_fetch_array($result)) {
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>'><?=$rs['group_name']?></option>
<?php	} ?>
		</SELECT>
		</span>
		<span bgcolor='#ffffff'>
		<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func(this.value);" style='width:250px;height:30px;background-color:#FFDF6E;border:1 solid black' >
<?php
		echo "<option value=''>2.Select Table</option>";
		if( $mode =='SearchTAB') echo "<option value='$tab_hnmS' selected >$tab_hnm</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where group_code='$project_code' and userid='".$H_ID."' and fld_enm='seqno'  order by upday desc");	//group by tab_enm " );
		while( $rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php if($rs['tab_hnm']==$tab_hnm) echo " selected "; ?> title='table code:<?=$rs['tab_enm']?>'><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</SELECT>
		</span>
</ul>
<ul>
	<span bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Name</span>
	<span bgcolor='#ffffff'><input type='text' id='new_tab_hnm' name='new_tab_hnm'  value='<?=$new_tab_hnm?>' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>
		
</ul>
</div>

<div>
	  New Table Code:<?=$tab_enm?>, Column Count : <!-- javascript:line_set_func(this.value) -->
	  <SELECT type='text' name="line_set" onchange="this.form.submit()" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Set the number of lines to be registered.' "; ?>>
		<option value="<?php echo $line_set ?>" selected ><?php if($mode=='SearchTAB') echo $record_cnt; else echo $line_set; ?> </option>
		  <option value="10" >10</option>
		  <option value="15" >15 </option>
		  <option value="20" >20 </option>
		  <option value="25" >25 </option>
		  <option value="30" >30 </option>
		  <option value="40" >40 </option>
		  <option value="50" >50 </option>
		  <option value="60" >60 </option>
		  <option value="70" >70 </option>
		  <option value="100" >100 </option>
		  <option value="150" >150 </option>
	  </select>
</div>
	<TABLE class='floating-thead' border=0 cellpadding="1" cellspacing="3">
	<THEAD >
		<TR align='center' style='background-color:eeeeee;'>
		 <TH><b>NO</b></TH>
		 <TH><b>Ref</b></TH>
		 <TH title="Column names must not contain spaces."><b>column name</b></TH>
		 <TH><b>column title</b></TH>
		 <TH><b>data type</b></TH>
		 <TH><b>size</b></TH>
		 <TH><b>memo</b></TH>
		 <?php if( $mode=='SearchTAB' ) echo "<TH><b>CTL</b></TH>"; ?>
		</TR>
	</THEAD>
<?php
	if( $mode=='SearchTAB' ) { $dis_cnt=$record_cnt +1;  }
	else if( $mode=='line_set' ) { $line_cnt=$_POST['line_set']; $dis_cnt=$_POST['line_set']; }
	else  $dis_cnt=$line_set;
	$if_lineA       = $i;
	$if_typeA       = '';
	$if_dataA       = '';
	$relation_dataA = '';
	For ($i = 0; $i < $dis_cnt  ; $i++) {
		if( $i < $record_cnt ) $m_line = 0;
		else $m_line = 1;
		if( $mode == 'SearchTAB' and $i < $dis_cnt) {
			if( isset($Aseqno[$i]) ) $seqno		=	$Aseqno[$i];
			if( isset($Afld_enm[$i]) ) $fld_enm	=	$Afld_enm[$i];
			else $fld_enm	=	"";
			if( isset($Afld_hnm[$i]) ) $fld_hnm	=	$Afld_hnm[$i];
			else $fld_hnm	=	"";
			if( isset($Afld_type[$i]) ) $fld_type	=	$Afld_type[$i];
			else $fld_type	=	"";
			if( isset($Afld_len[$i]) ) $fld_len	=	$Afld_len[$i];
			else $fld_len	=	"";
			if( isset($Amemo[$i]) ) $memo		=	$Amemo[$i];
			else $memo	=	"";
			if( isset($Aif_line[$i]) ) $if_lineA       = $Aif_line[$i]; 
			if( isset($Aif_type[$i]) ) $if_typeA       = $Aif_type[$i];
			if( isset($Aif_data[$i]) ) $if_dataA       = $Aif_data[$i];
			if( isset($Arelation_data[$i]) ) $relation_dataA = $Arelation_data[$i];
			$bcolor		= '#FFDF6E';
			$fcolor		= '#666666';
		} else if( $mode == 'SearchTAB' and $i == $line_set) {
			$fld_enm	=	'fld_' . $dis_cnt;
			$fld_hnm	=	"";
			$fld_type	=	"";
			$fld_len	=	"";
			$memo		=	"";
			$bcolor		= 'black';
			$fcolor		= 'yellow';
		} else if( $mode == 'SearchTAB' ) {
			$seqno		=	$Aseqno[$i];
			$fld_enm	=	$Afld_enm[$i];
			$fld_hnm	=	$Afld_hnm[$i];
			$fld_type	=	$Afld_type[$i];
			$fld_len	=	$Afld_len[$i];
			$memo		=	$Amemo[$i];
			$if_lineA       = $Aif_line[$i]; 
			$if_typeA       = $Aif_type[$i]; 
			$if_dataA       = $Aif_data[$i]; 
			$relation_dataA = $Arelation_data[$i]; 
			$bcolor		= '#FFDF6E';
			$fcolor		= '#666666';
		} else if( $mode == 'line_set' and $i < $record_cnt) {
			$seqno		=	$Aseqno[$i];
			$fld_enm	=	$Afld_enm[$i];
			$fld_hnm	=	$Afld_hnm[$i];
			$fld_type	=	$Afld_type[$i];
			$fld_len	=	$Afld_len[$i];
			$memo		=	$Amemo[$i];
			$if_lineA       = $Aif_line[$i]; 
			$if_typeA       = $Aif_type[$i]; 
			$if_dataA       = $Aif_data[$i]; 
			$relation_dataA = $Arelation_data[$i]; 
			$bcolor		= '#FFDF6E';
			$fcolor		= '#666666';
		} else if( $mode == 'line_set' and $i >= $record_cnt) {
			$fld_enm	=	'fld_' . $i;
			$fld_hnm	=	"";
			$fld_type	=	"";
			$fld_len	=	"";
			$memo		=	"";
			$bcolor		= 'black';
			$fcolor		= 'white';
		} else if( !isset($mode) ) {
			if( $i==0)	$fld_enm	=	'seqno';
			else		$fld_enm	=	'fld_' . $i;
			$fld_hnm	=	"";
			$fld_type	=	"";
			$fld_len	=	"";
			$memo		=	"";
			$bcolor		= '#FFDF6E';
			$fcolor		= '#666666';
		} else {
			if( $i==0)	$fld_enm	=	'seqno';
			else		$fld_enm	=	'fld_' . $i;
			$fld_hnm	=	"";
			$fld_type	=	"";
			$fld_len	=	"";
			$memo		=	"";
			$bcolor		= '#FFDF6E';
			$fcolor		= '#666666';
		}
?>
<TBODY width='100%'>
	<TR bgcolor='#000' bordercolor='#999999'>
		<td style="color:#fff;" ><?=$i?></TD><!-- No -->
			<input type="hidden" name="seq[<?=$i?>]" >
			<input type="hidden" name="seqno[<?=$i?>]" value='<?=$seqno?>'>
			<input type="hidden" name="fld_enm_old[<?=$i?>]" value='<?=$fld_enm?>'>
<?php if($mode=="SearchTAB"){	?>
			<input type="hidden" name="Afld_enm[<?=$i?>]" value='<?=$fld_enm?>'>
			<input type="hidden" name="Afld_hnm[<?=$i?>]" value='<?=$fld_hnm?>'>
			<input type="hidden" name="Afld_type[<?=$i?>]" value='<?=$fld_type?>'>
			<input type="hidden" name="Afld_len[<?=$i?>]" value='<?=$fld_len?>'>
			<input type="hidden" name="Afld_memo[<?=$i?>]" value='<?=$memo?>'>
<?php }	?>

			<input type="hidden" name="Aif_line[<?=$i?>]" value='<?=$if_lineA?>'>
			<input type="hidden" name="Aif_type[<?=$i?>]" value='<?=$if_typeA?>'>
			<input type="hidden" name="Aif_data[<?=$i?>]" value='<?=$if_dataA?>'>
			<input type="hidden" name="Arelation_data[<?=$i?>]" value='<?=$relation_dataA?>'>

		<td>
			<input type='button' id="fld_ref[<?=$i?>]" name="fld_ref[<?=$i?>]" value='Ref' onclick="ref_func('<?=$i?>', 'document.kapp_table_Form')"
			style='width:25px;height:22px;background-color:black;color:yellow; border:1 solid black' title='You can select an existing field by finding the material.'> </td><!-- 기존의 필드를 자료를 찾아서 선택 할 수 있습니다. -->
		<td>
			<input type='text' id="fld_enm[<?=$i?>]" name="fld_enm[<?=$i?>]" title="Column names must not contain spaces." onclick="line_getA(<?=$i?>);"
			<?php if( $fld_enm=='seqno' or $i==0) { echo "value='seqno' readonly ";  } else if ( $fld_enm ){ echo " value='$fld_enm' ";} ?>
			style='width:120px;height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'> </td>
		<td>
			<input type='text' id="fld_hnm[<?=$i?>]" name="fld_hnm[<?=$i?>]" onclick="line_getA(<?=$i?>);"
			<?php if( $fld_enm=='seqno' or $i==0) { echo "value='seqno' readonly ";  } else if ( $fld_hnm ){ echo " value='$fld_hnm' ";} ?>
			style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title="column:<?=$fld_enm?>"> </td>
		<td>
		<SELECT type='text' id="fld_type[<?=$i?>]" name="fld_type[<?=$i?>]" onchange="javascript:type_set_func('<?=$i?>', this.value);" style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title='MYSQL basic '>
			<option <?php echo "title='CHAR A fixed-length (0-255, default 1) string that fills the right with blanks to the specified length at all times when saved.' "; ?> 
			value="CHAR" <?php if($fld_type == 'CHAR') echo " selected ";  ?> >CHAR</option>
			<option <?php echo "title='VARCHAR Variable-length (0-65,535) string.' "; ?> 
			value="VARCHAR" <?php if($fld_type == 'VARCHAR') echo " selected ";  ?> >VARCHAR</option>
			<option <?php echo "title='TEXT Text column with a maximum length of 65535 (2 ^ 16-1) characters.' "; ?> 
			value="TEXT" <?php if($fld_type == 'TEXT') echo " selected ";  ?>>TEXT</option>
			<option <?php echo "title='INT The range of 4-byte integer types is 2147483647 with -2,147,483,647 when there is a sign, and 4,294,967,295 when there is no sign.' "; ?> 
			value="INT" <?php if ( $i==0 ) { echo "selected"; } ?> <?php if($fld_type == 'INT') echo " selected ";  ?> >INT</option>
			<option <?php echo "title='TINYINT The range of a 1-byte integer type is from -128 to 127 when it is signed, and from 0 to 255 when it is not signed.' "; ?> 
			value="TINYINT" <?php if($fld_type == 'TINYINT') echo " selected ";  ?> >TINYINT</option>
			<option <?php echo "title='SMALLINT The range of a 2-byte integer is -32,768 to 32,767 if signed and 0 to 65,355 if unsigned.' "; ?> value="SMALLINT" <?php if($fld_type == 'SMALLINT') echo " selected ";  ?> >SMALLINT</option>
			<option <?php echo "title='MEDIUMINT The range of 3-byte integers is -8388608 to 8388607 if signed, and 0 to 16,777,215 if not signed.' "; ?> value="MEDIUMINT" <?php if($fld_type == 'MEDIUMINT') echo " selected ";  ?> >MEDIUMINT</option>
			<option <?php echo "title='BIGINT An 8-byte integer type range is from -9,223,372,036,854,775,808 to +9,223,372,036,854,775,808 when there is a sign, and 18,446,744,073,709,551,615 when there is no sign.' "; ?> 
			value="BIGINT" <?php if($fld_type == 'BIGINT') echo " selected ";  ?>>BIGINT</option>
			<option <?php echo "title='DECIMAL Fixed-point number (M, D): The maximum number of digits (M) is 65 (default is 10) and the maximum number of decimal places (D is 30)' "; ?> 
			value="DECIMAL" <?php if($fld_type == 'DECIMAL') echo " selected ";  ?>>DECIMAL</option>
			<option <?php echo "title='FLOAT A small floating-point number, acceptable values are -3.402823466E + 38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E + 38.' "; ?> 
			value="FLOAT" <?php if($fld_type == 'FLOAT') echo " selected ";  ?>>FLOAT</option>
			<option <?php echo "title='DOUBLE precision floating point numbers, acceptable values are -1.7976931348623157E + 308 to -2.2250738585072014E-308, 0, And from 2.2250738585072014E-308 to 1.7976931348623157E + 308.' "; ?> 
			value="DOUBLE" <?php if($fld_type == 'DOUBLE') echo " selected ";  ?>>DOUBLE</option>
			<option <?php echo "title='DATE Date types 1000-01-01 through 9999-12-31 are available.' "; ?> 
			value="DATE" <?php if($fld_type == 'DATE') echo " selected ";  ?>>DATE</option>
			<option <?php echo "title='DATETIME Date and time combination, 1000-01-01 00:00:00 through 9999-12-31 23:59:59 Wanted.' "; ?> 
			value="DATETIME" <?php if($fld_type == 'DATETIME') echo " selected ";  ?>>DATETIME</option><!-- 2023-07-18 kan -->
			<option <?php echo "title='TIME Date and time combination, 00:00:00 through 23:59:59 Wanted.' "; ?> 
			value="TIME" <?php if( $fld_type == 'TIME') echo " selected ";  ?>>TIME</option>
			<option <?php echo "title='YEAR Date and time combination, 0000 through 2026 Wanted.' "; ?> 
			value="YEAR" <?php if($fld_type == 'YEAR') echo " selected ";  ?>>YEAR</option>
			<option <?php echo "title='MONTH Year and month combination, yyyy-mm.' "; ?> 
			value="MONTH" <?php if($fld_type == 'MONTH') echo " selected ";  ?>>MONTH</option>

			<option <?php echo "title='TIMESTAMP timestamp format 1970-01-01 00:00:01 UTC to 2038-01-09 03:14:07 UTC Until EPOCH (1970-01-01 00:00:00 UTC), the elapsed time in seconds since the number.' "; ?> 
			value="TIMESTAMP" <?php if($fld_type == 'TIMESTAMP') echo " selected ";?> >TIMESTAMP</option>
			<option <?php echo "title='LONGBLOB Length Maximum data size: 4GiB' "; ?> 
			value="LONGBLOB" <?php if( $fld_type=='LONGBLOB') echo " selected ";?> >LONGBLOB</option>
			<option <?php echo "title='BLOB Length Maximum data size: 65,535Byte' "; ?> 
			value="BLOB" <?php if( $fld_type=='BLOB') echo " selected ";?> >BLOB</option>
			<!-- 데이터 최대크기 4GiB -->
		</SELECT>
		</td>
		<td><input type='text' id="fld_len[<?=$i?>]" name="fld_len[<?=$i?>]"  style='width:30px;height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'
<?php
				if( $fld_enm=='seqno' or $i==0) { echo "value='13' readonly"; } else { echo " value='$fld_len' ";}
?>  >
		</td>
		<td>
			<input type='text' id="memo[<?=$i?>]" name="memo[<?=$i?>]"  style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'
			<?php
				if( $fld_enm=='seqno' or $i==0) {
					echo " value='AUTO_INCREMENT , Key : Can not change' title='Can not change' readonly";
				} else {
					echo " value='$memo' ";
				}
			?> >
	   </td>
<?php
		if( $mode=='SearchTAB') {
?>
			<td>
<?php
			if ( $i > 0 ) {
				if ($m_line) {
					echo " <input type='button' name='add' onclick=\"javascript:column_add_mode_func('$i', '$table_yn', '$dis_cnt');\"  value='column add' style='height:22px;background-color:blue;color:yellow;border-radius:20px;border:1 solid black' title=' Add a column.'>";
				}else {
					echo " <div id='manager_".$i.">' class='manager_".$i."' style='display: ;' > ";

					echo " <input type='button' name='del' onclick=\"javascript:delete_column_func('$seqno', '$fld_hnm', '$fld_enm', '$i');\"  value='delete' style='height:22px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  title=' Delete a column.'>";
					echo "</div>";
				}
			} else {
				echo "";
			}

?>
			</td>
<?php   } // if Search ?>
		</tr>
<?php } // for ?>
	<tr>
      <td colspan='8' align='center'>
	   <img src="./icon/bt_down_s02.gif" title="column down" border="0" onclick="down_func();" />&nbsp;&nbsp;
	   <img src="./icon/bt_up_s02.gif" title="column up" border="0" onclick="up_func();" />&nbsp;&nbsp;
<?php
		if( $mode=="SearchTAB") {
?>
			<input title='Delete the created table and register the changes.' type='button' id='upd' onclick="javascript:Save_Update('<?=$line_set?>');"
			value=" Save Change " style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>&nbsp;&nbsp;&nbsp;
			<input title='Save as a new table. table code:<?=$new_tab_enm?>' type='button' id='Newset' onclick="javascript:Copy_New_table_save('<?=$line_set?>');"
			value="Copy New Table" style='height:30px;background-color:cyan;color:blue;border-radius:20px;border:1 solid white'>&nbsp;&nbsp;&nbsp;
			<input title='Change to the table registration screen.' type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else if( $mode=="line_set") {
?>
			<input <?php echo "title='Re-create the table after deletion.'"; ?> type='button' name='upd' onclick="javascript:Save_Update_Insert('<?=$line_set?>');"
			value="Change additional registration" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else {
?>
			<input <?php echo "title='Register and create the created table.' "; ?> type='button' name='ins' onclick="javascript:New_table_create_func('<?=$line_set?>');"
			value="Create Table" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
			<input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		}
?>
        &nbsp
		<br><br><b>#There should be no spaces in the name of the column.
      </td>
    </tr>
	</TBODY>
  </TABLE>

</Form>
<P>- 컬럼명은 공백이 없어야 함.</P>
<p>- 테이블 생성작업은 데이터 CRUD 프로그램을 동시에 생성함.</P>
<p>- CRUD는 Create, Read, Update, Delete 의미.</P>
<p>- 테이블을 생성, 변경, 복사 등 작업 가능.</P>
<P>- 변경 작업은 생성한 테이블의 데이터와 테이블을 삭제하고 다시 생성 합니다.</P>
<P>- 테이블 복사는 테이블 정보를 복사하여 새로운 테이블을 생성 합니다.</P>
</body>
</html>
