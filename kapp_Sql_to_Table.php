<?php
	include_once('./tkher_start_necessary.php');
	/*
	 * kapp_Sql_to_Table.php - tableK_sql.php : table_sql.php : table30m_A.php copy:2025-12-09, table30m_Create.php copy 2023-08-25 - kan
		kapp_table_dup_ajax.php : table name Duplicate check
	 * TAB_curl_sendA( $tab_enm, $tab_hnm,0 , $item_list, $if_line, $if_type, $if_data, $relation_data, $memo ); 
	 */
	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';

	if( !isset($H_ID) || $H_LEV < 2 ){
		m_("You need to login.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($_POST["tab_enm"]) ) $tab_enm	= $_POST["tab_enm"];
	else {
		//$uid = explode('@', $H_ID);
		//$tab_enm = $uid[0] . "_" . time();
		$tab_enm = '';
	}

	if( isset($_POST['tab_hnm']) ) $tab_hnm	= $_POST["tab_hnm"];
	else $tab_hnm = '';
	if( isset($_POST['tab_hnmS']) ) $tab_hnmS	= $_POST["tab_hnmS"];
	else $tab_hnmS = '';
	if( isset($_POST['line_set']) ) $line_set = $_POST['line_set'];
	else $line_set = 30;
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode = $_REQUEST['mode'];
	else $mode = '';
	if( isset($_POST['del_mode']) ) $del_mode = $_POST['del_mode'];
	else $del_mode = '';
	if( isset($_POST["project_code"]) ) $project_code	= $_POST["project_code"];
	else  $project_code	= "";
	if( isset($_POST["project_name"]) ) $project_name	= $_POST["project_name"];
	else  $project_name	= "";

	if( isset($_POST["sql_memo"]) ) $sql_memo= $_POST["sql_memo"];
	else  $sql_memo	= "";

	if( isset($_POST["sql_table"]) ) $sql_table= $_POST["sql_table"];
	else  $sql_table = "";
	
	if( isset($_POST["key_msg"]) ) $key_msg= $_POST["key_msg"];
	else  $key_msg = "";
	if( isset($_POST["key_array"]) ) $key_array= $_POST["key_array"];
	else  $key_array = "";
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
	</style>
<style type="text/css">
<!--
	textarea {
	  width: 50%;
	  height: 250px;
	  padding: 12px;
	  border: 2px solid #ccc;
	  border-radius: 4px;
	  background-color: #000000;
	  font-family: Arial, sans-serif;
	  font-size: 14px;
	  color: #fff;
	  /*resize: vertical;  Allows vertical resizing only */
	}
	textarea:focus {
	  border-color: #007bff; /* Changes border color on focus */
	  outline: none; /* Removes default outline on focus */
	}
	.style3 {
		width: 420px;
		height: 30px;
		font-size: 14px;
		color: blue;
		font-weight: bold;
	}
	.style2 {
		color: #4F2044;
		font-weight: bold;
	}
	.style4 {
		width: 150px;
		height: 35px;
		font-size: 16px;
		color: #4F2044;
		font-weight: bold;
	}
	.style5 {
		height: 25px;
		font-size: 16px;
		font-weight: bold;
		color: #000;
	}
-->
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

<body>
<center>
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
	if( $mode == 'SQL_Search' ){
		if( isset($_POST['item_array']) ) $item_array = $_POST['item_array'];
		$record_cnt = $_POST['item_cnt'];
		$list= explode("@", $item_array);
		for ( $i=0; $list[$i] != ""; $i++ ){
			$ddd= $list[$i];
			$item= explode("|", $ddd);
				$Aseqno[$i]	= $i;
				$Afld_enm[$i]	=$item[1];
				$Afld_hnm[$i]	=$item[2];
				$Afld_type[$i]	=$item[3];
				$Afld_len[$i]	=$item[4];
				$Amemo[$i]		=$item[5];
		}
		$record_cnt = $i;
	}
	if( isset($_POST['group_code_table']) ) $group_code_table = $_POST['group_code_table'];
	$group_code_table ='';
?>
	<Form METHOD='POST' name='kapp_SQL_Form' enctype="multipart/form-data">
		<input type="hidden" name="line_index" >
		<input type="hidden" name="no" >
		<input type="hidden" name="mode" >
		<input type="hidden" name="pg_mode" >
		<input type="hidden" name="del_mode" >
		<input type="hidden" name="del_seqno" >
		<input type="hidden" name="del_fld_hnm" >
		<input type="hidden" name="del_fld_enm" >
		<input type="hidden" name="tab_create_ok" value='<?=$tab_create_ok?>'>
		<input type="hidden" name="userid" value='<?=$H_ID?>'>
		<input type="hidden" name="disno" value='<?=$disno?>'>
		<input type="hidden" name="add_column_no" value=''>
		<input type="hidden" name="add_column_enm" >
		<input type="hidden" name="add_column_hnm" >
		<input type="hidden" name="add_column_type" >
		<input type="hidden" name="add_column_len" >
		<input type="hidden" name="add_column_memo" >
		<input type="hidden" name="group_code_table" value="<?=$group_code_table?>">
		<input type="hidden" name="old_group_code" >
		<input type="hidden" name="item_array" >
		<input type="hidden" name="item_cnt" >
		<input type="hidden" name="table_yn" value='<?=$table_yn?>'>
		<input type="hidden" name="sqlm_length_old" value=''>
		<input type="hidden" name="key_msg" value='<?=$key_msg?>'>
		<input type="hidden" name="key_array" value='<?=$key_array?>'>
		
		<h2><font fce="Arial">Table Design( SQL to Table )</font></h2>
<div>
	<ul>
		<span bgcolor='#f4f4f4' <?php echo "title='You can change or add the group name of the table.' "; ?>><font color='black'>Project</span>
		<span bgcolor='#ffffff'>
		<SELECT id='project_code' name='project_code' onchange="Project_change_SQL_func(this.value);" style='width:250px;height:30px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered. ' "; ?> >
				<option value=''>Select project</option>
<?php
			if( $project_code !='' ) echo "<option value='$project_code' selected >$project_name</option>";
			$SQLG = "SELECT * from {$tkher['table10_group_table']} where userid='".$H_ID."' order by group_name ";
			$result = sql_query( $SQLG );
			while($rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['group_code']?>"><?=$rs['group_name']?></option>
<?php
			}
?>
			</select>
<?php
		if ( isset($H_ID) && $H_ID != "" ) {
?>
		</span>
		<input type='hidden' name='project_name' value='<?=$project_name?>' style='height:25px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='You can change or add the group name of the table.' "; ?> >
<?php
		} else {
?>
				You can register after login.
<?php
		}
?>
</ul>
<ul>
	<span bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Code</span>
		<span bgcolor='#ffffff'><input type='text' name='tab_enm'  value='<?=$tab_enm?>' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>&nbsp;
	<span bgcolor='#f4f4f4' <?php echo "title='Select a table from the list of registered tables.' "; ?>>Table Name</span>
		<span bgcolor='#ffffff'><input type='text' name='tab_hnm'  value='<?=$tab_hnm?>' style='width:250px;height:30px;background-color:#666666;color:yellow;border:1 solid black' <?php echo "title='Enter the name of the table to be created!' "; ?>></span>
		<span>
		&nbsp;<input type='checkbox' id='dup_confirm' name='dup_confirm' value='Confirm' onClick="return false">&nbsp;
		&nbsp;<input type='button' onclick="table_nm_dup_check();" value='Duplicate check' >
		</span>

</ul>
</div>
<?php
$sql_memoA = str_replace('\\', '', $sql_memo);
$sql_table = str_replace('\\', '', $sql_table);
?>
<div>
	<span bgcolor='#f4f4f4' title='Enter SQL here'><textarea title='Enter SQL here' id="sql_memo" name="sql_memo" cols="100%" ><?=$sql_memoA?></textarea></span>
	<span bgcolor='#f4f4f4'><textarea id="sql_table" name="sql_table" cols="100%" style='color:yellow;display:none;' ><?=$sql_table?></textarea></span>
	<p bgcolor='#f4f4f4'><input type='button' onclick="javascript:SQL_check();" value=' Sql to Table ' style='height:30px;width:150;background-color:black;color:white;border-radius:20px;border:1 solid black;' title='sql to table' ></p>
</div>
<?php if( $mode=='SQL_Search') $line_set = $record_cnt; else $line_set=$line_set; ?>
<div>
				  Column Count : <SELECT type='text' name="line_set" onchange="javascript:line_set_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Set the number of lines to be registered.' "; ?>>
					<option value="<?php echo $line_set ?>" selected ><?php if($mode=='SQL_Search') echo $record_cnt; else echo $line_set; ?> </option>
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
			 <TH><b>column</b></TH>
			 <TH><b>column title</b></TH>
			 <TH><b>data type</b></TH>
			 <TH><b>size</b></TH>
			 <TH><b>memo</b></TH>
			</TR>
	</THEAD>
<?php
			if( $mode=='SQL_Search' ) { $dis_cnt = $record_cnt +1;  }
			else if( $mode=='line_set' ) { $line_cnt =$_POST['line_set']; $dis_cnt =$_POST['line_set']; }
			else  $dis_cnt =$line_set;
			$if_lineA =0; $if_typeA =''; $if_dataA ='';	$relation_dataA ='';
			For( $i = 0; $i < $dis_cnt  ; $i++) {
				if( $i < $record_cnt ) $m_line = 0;
				else $m_line = 1;
				if( $mode == 'SQL_Search' ) {
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
	<TR valign='middle' bgcolor='#FFFFFF' bordercolor='#999999'>
		<td><B><?=$i?></B></font></TD><!-- No -->
			<input type="hidden" name="seq[<?=$i?>]" >
			<input type="hidden" name="seqno[<?=$i?>]" value='<?=$seqno?>'>
			<input type="hidden" name="fld_enm_old[<?=$i?>]" value='<?=$fld_enm?>'>
<?php if( $mode=="SQL_Search"){	?>
			<input type="hidden" name="Afld_enm[<?=$i?>]" value='<?=$fld_enm?>'>
			<input type="hidden" name="Afld_hnm[<?=$i?>]" value='<?=$fld_hnm?>'>
			<input type="hidden" name="Afld_type[<?=$i?>]" value='<?=$fld_type?>'>
			<input type="hidden" name="Afld_len[<?=$i?>]" value='<?=$fld_len?>'>
			<input type="hidden" name="Afld_memo[<?=$i?>]" value='<?=$memo?>'>
<?php }	?>

		<td>
			<input type='button' name="fld_ref[<?=$i?>]" size='5' maxlength='10' value='Ref' onclick="ref_func('<?=$i?>')"
			style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title='You can select an existing field by finding the material.'> </td>
		<td align='left'>
			<input type='text' name="fld_enm[<?=$i?>]" size='10' maxlength='30' onclick="line_getA(<?=$i?>);"
			<?php if ( $fld_enm=='seqno' or $i==0) { echo "value='seqno' readonly ";  } else if ( $fld_enm ){ echo " value='$fld_enm' ";} ?>
			style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'> </td>
		<td align='left'>
			<input type='text' name="fld_hnm[<?=$i?>]" size='20' maxlength='30' onclick="line_getA(<?=$i?>);"
			<?php if ( $fld_enm=='seqno' or $i==0) { echo "value='seqno' readonly ";  } else if ( $fld_hnm ){ echo " value='$fld_hnm' ";} ?>
			style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title="column:<?=$fld_enm?>"> </td>
		<td align='left'>
<SELECT type='text' name="fld_type[<?=$i?>]" onchange="javascript:type_set_func('<?=$i?>', this.value);" style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' title='MYSQL basic '>
<option <?php echo "title='CHAR A fixed-length (0-255, default 1) string that fills the right with blanks to the specified length at all times when saved.' "; ?> value="CHAR" <?php if( $fld_type == 'CHAR') echo " selected ";  ?> >CHAR</option>
<option <?php echo "title='VARCHAR Variable-length (0-65,535) string.' "; ?> value="VARCHAR" <?php if($fld_type == 'VARCHAR') echo " selected ";  ?> >VARCHAR</option>
<option <?php echo "title='TEXT Text column with a maximum length of 65535 (2 ^ 16-1) characters.' "; ?> value="TEXT" <?php if($fld_type == 'TEXT') echo " selected ";?>>TEXT</option>
<option <?php echo "title='INT The range of 4-byte integer types is 2147483647 with -2,147,483,647 when there is a sign, and 4,294,967,295 when there is no sign.' "; ?> value="INT" <?php if( $i==0 || $fld_type == 'INT') echo " selected ";  ?> >INT</option>
<option <?php echo "title='TINYINT The range of a 1-byte integer type is from -128 to 127 when it is signed, and from 0 to 255 when it is not signed.' "; ?> value="TINYINT" <?php if( $fld_type == 'TINYINT') echo " selected ";  ?> >TINYINT</option>
<option <?php echo "title='SMALLINT The range of a 2-byte integer is -32,768 to 32,767 if signed and 0 to 65,355 if unsigned.' "; ?> value="SMALLINT" <?php if($fld_type == 'SMALLINT') echo " selected ";  ?> >SMALLINT</option>
<option <?php echo "title='MEDIUMINT The range of 3-byte integers is -8388608 to 8388607 if signed, and 0 to 16,777,215 if not signed.' "; ?> value="MEDIUMINT" <?php if($fld_type == 'MEDIUMINT') echo " selected ";  ?> >MEDIUMINT</option>
<option <?php echo "title='BIGINT An 8-byte integer type range is from -9,223,372,036,854,775,808 to +9,223,372,036,854,775,808 when there is a sign, and 18,446,744,073,709,551,615 when there is no sign.' "; ?> value="BIGINT" <?php if($fld_type == 'BIGINT') echo " selected ";  ?>>BIGINT</option>
<option <?php echo "title='DECIMAL Fixed-point number (M, D): The maximum number of digits (M) is 65 (default is 10) and the maximum number of decimal places (D is 30)' "; ?> value="DECIMAL" <?php if($fld_type == 'DECIMAL') echo " selected ";  ?>>DECIMAL</option>
<option <?php echo "title='FLOAT A small floating-point number, acceptable values are -3.402823466E + 38 to -1.175494351E-38, 0, and 1.175494351E-38 to 3.402823466E + 38.' "; ?> value="FLOAT" <?php if($fld_type == 'FLOAT') echo " selected ";  ?>>FLOAT</option>
<option <?php echo "title='DOUBLE precision floating point numbers, acceptable values are -1.7976931348623157E + 308 to -2.2250738585072014E-308, 0, And from 2.2250738585072014E-308 to 1.7976931348623157E + 308.' "; ?> value="DOUBLE" <?php if($fld_type == 'DOUBLE') echo " selected ";  ?>>DOUBLE</option>
<option <?php echo "title='DATE Date types 1000-01-01 through 9999-12-31 are available.' "; ?> value="DATE" <?php if($fld_type == 'DATE') echo " selected ";?>>DATE</option>
<option <?php echo "title='DATETIME Date and time combination, 1000-01-01 00:00:00 through 9999-12-31 23:59:59 Wanted.' "; ?> value="DATETIME" 
				  <?php if($fld_type == 'DATETIME') echo " selected ";  ?>>DATETIME</option>
<option <?php echo "title='TIME Date and time combination, 00:00:00 through 23:59:59 Wanted.' "; ?> value="TIME" <?php if($fld_type == 'TIME') echo " selected ";  ?>>TIME</option>
<option <?php echo "title='TIMESTAMP timestamp format 1970-01-01 00:00:01 UTC to 2038-01-09 03:14:07 UTC Until EPOCH (1970-01-01 00:00:00 UTC), the elapsed time in seconds since the number.' "; ?> value="TIMESTAMP" <?php if($fld_type == 'TIMESTAMP') echo " selected ";  ?>>TIMESTAMP</option>
<option <?php echo "title='YEAR format 2026(yyyy)' "; ?> value="YEAR" <?php if($fld_type == 'YEAR') echo " selected ";  ?>>YEAR</option>

<option <?php echo "title='BLOB Length Maximum data size: 65,535Byte' "; ?> value="BLOB" <?php if( $fld_type=='BLOB') echo " selected ";?> >BLOB</option> <!-- BLOB data size 65,535Byte -->
<option <?php echo "title='LONGBLOB Length Maximum data size: 4GiB' "; ?> value="LONGBLOB" <?php if( $fld_type=='LONGBLOB') echo " selected ";?> >LONGBLOB</option> <!-- LONGBLOB data size 4GiB -->
</SELECT>
		</td>
		<td align='left'>  <input type='text' name="fld_len[<?=$i?>]" size='3' maxlength='3' style='height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black'
<?php
				if ( $fld_enm=='seqno' or $i==0) { echo "value='11' readonly >"; } else { echo " value='$fld_len' >";}
				$memo = str_replace('\\', '', $memo);
?> 
		</td>
		<td align='left'>
			<input type='text' name="memo[<?=$i?>]" value="<?=$memo?>" style='width:300px;height:22px;background-color:<?=$bcolor?>;color:<?=$fcolor?>; border:1 solid black' >
	   </td>
	<?php
		if( $mode=='SQL_Search') {
	?>
			<td align='left'>
			</td>
<?php  } ?>
		</tr>
<?php } // for ?>
	<tr>
      <td colspan='8' align='center'>
	   <img src="./icon/bt_down_s02.gif" title="column down" border="0" onclick="down_func();" />&nbsp;&nbsp;
	   <img src="./icon/bt_up_s02.gif" title="column up" border="0" onclick="up_func();" />&nbsp;&nbsp;
<?php
		if( $mode=="SQL_Search") {
?>
			<span><input <?php echo "title='Register and create the created table.' "; ?> type='button' name='ins' onclick="javascript:table_create_func('<?=$line_set?>');"
			value="Create Table" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'></span>

			<input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value="Reset" style='height:25px;background-color:black;color:white;border-radius:20px;border:1 solid white'>
<?php
		} else if( $mode=="line_set" || $mode=="" || $mode == "table_create") {
?>
			<span><input <?php echo "title='Register and create the created table.' "; ?> type='button' name='ins' onclick="javascript:table_create_func('<?=$line_set?>');"
			value="Create Table" style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'></span>
			<span><input <?php echo "title='Change to the table registration screen.' "; ?> type='button' name='reset' onclick="javascript:resetgo();"
			value=" Reset " style='height:30px;background-color:black;color:white;border-radius:20px;border:1 solid white'></span>
<?php
		}
?>
        &nbsp
		<br><b>#There should be no spaces in the name of the column.
      </td>
    </tr>
	</TBODY>

  </TABLE>
</Form>
</body>
</html>
<?php

	if( $mode == "sql_table_create" ) {
		if( !Table_check_() ){
			Sql_to_Table_Create_Submit();
		} else m_("table exists : " . $tab_enm);
	}

	function Sql_to_Table_Create_Submit(){
		global $H_ID, $H_EMAIL, $table_yn, $mode, $line_set;
		global $config;
		global $tkher;
		global $project_code, $project_name, $tab_hnm, $tab_enm, $key_msg, $sql_memo, $key_array; 

		$item_list = " create table `". $tab_enm . "` ( ";
		$item_list = $item_list . " `seqno` INT(11) auto_increment not null, ";
		$item_list = $item_list . ' `kapp_userid`  VARCHAR(50),';
		$item_list = $item_list . ' `kapp_pg_code` VARCHAR(50),';
		$cnt = 1;
		$item_array = "";
		$if_type = "";
		$if_data = "";
		$item_cnt   = 0;
		For( $ARR=1; $ARR < $line_set && isset($_POST["fld_hnm"][$ARR]) ; $ARR++ ) {
			if( $_POST["fld_hnm"][$ARR] !='' ) $fld_hnm	=	$_POST["fld_hnm"][$ARR];
			else continue; //$fld_hnm =	'';
			if( isset($_POST['fld_enm'][$ARR]) && $_POST['fld_enm'][$ARR]!='' ) $fld_enm = $_POST['fld_enm'][$ARR];
			else continue;
			if( !Kcolumn_check($fld_enm) ) continue;
			if( $fld_hnm != '' ) {
				$seqno		=	$_POST["seqno"][$ARR];
				$fld_enm	=	$_POST["fld_enm"][$ARR];
				$fld_hnm	=	$_POST["fld_hnm"][$ARR];
				$fld_type	=	$_POST["fld_type"][$ARR];
				$fld_len	=	$_POST["fld_len"][$ARR];
				$memo		=	$_POST["memo"][$ARR];
				$item_array = $item_array ."|". $fld_enm ."|". $fld_hnm  ."|". $fld_type ."|". $fld_len . "@";
				$if_type = $if_type . "|" . "0";
				$if_data = $if_data . "|" . "";
				$memo = str_replace('auto_increment', '', $memo);
				$item_list = $item_list . '`'.$fld_enm . '`' . $memo . ', ';
				
				$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='$fld_enm', fld_hnm='$fld_hnm', fld_type='$fld_type', fld_len='$fld_len', disno=$ARR, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$memo' ";
				$ret = sql_query( $sql );
				if( !$ret ) {
					m_("error --- insert table10_table - $tab_enm");
					echo "Make sure you use reserved words in column names.<br>sql: " . $sql;
					exit;
				}
				$Asqltable=''; $if_lineA=0; $if_typeA=''; $if_dataA=''; $relation_dataA='';
				$cnt++;
			}
		}
		$item_listA = str_replace('\\', '', $item_list);
		if( $key_msg == '' ){
			$SQLA = $item_listA . " PRIMARY KEY (`seqno`) ); ";
			$item_list = $item_list . " PRIMARY KEY (`seqno`) ); ";
		} else {
			$SQLA = $item_listA . " PRIMARY KEY (`seqno`), ". $key_msg;
			$item_list = $item_list . " PRIMARY KEY (`seqno`), ". $key_msg;
		}
		//echo "sql:" . $SQLA; echo "<br>key_msg: " . $key_msg;

		$item_cnt  = $cnt - 1;
		$sql = "INSERT INTO {$tkher['table10_table']} set  tab_enm='$tab_enm', tab_hnm='$tab_hnm', fld_enm='seqno', fld_hnm='seqno', fld_type='INT', fld_len='11', disno=0, userid='$H_ID', table_yn='y', group_code='$project_code', group_name='$project_name', memo='$item_array', sqltable='$item_list', key_msg='$key_msg', sql_copy='$sql_memo', relation_data='$key_array' ";
		$ret = sql_query( $sql ) or die ("`table10_table` Error sql:" . $sql);

		if( $ret ){
			$query="INSERT INTO {$tkher['table10_pg_table']} SET group_code='$project_code', group_name='$project_name', tab_enm='$tab_enm',tab_hnm='$tab_hnm', pg_code='$tab_enm', pg_name='$tab_hnm', item_array='$item_array', if_type='$if_type', if_data='$if_data', item_cnt=$item_cnt, userid='$H_ID', tab_mid='$H_ID', memo='$item_list' ";
			
			$rets = sql_query( $query ) or die ("kapp_Sql_to_Table.php `table10_pg_table` Error sql:" . $query);
			if( $rets ){
				if( !kapp_table_check( $tab_enm ) ){
					$mq1 = sql_query( $SQLA );
					//sleep(1);
					if( !$mq1 ) {
						echo "<br>SQLA: " . $SQLA;
						m_("ERROR mq1 - Make sure you use reserved words in column names. - Create table - $tab_enm");
						exit;
					} else {
						//m_("mq1 -- tab_enm: $tab_enm : table create ok!");
						$table_yn = 'y';
						$link_ = KAPP_URL_T_ . "/kapp_Sql_to_Table.php?tab_enm=". $tab_enm;
						$p_msg = 'table10@kapp_Sql_to_Table.php : ' . $tab_enm;
						insert_point_app( $H_ID, $config['kapp_write_point'], $link_, $p_msg );

						$Tret = TAB_curl_sendA( $tab_enm, $tab_hnm, 0, $item_list, 0, '', '', '', $item_array );
						sleep(1);
						if( $Tret ) {
							$sys_link = KAPP_URL_T_ . "/tkher_program_data_list.php?pg_code=" . $tab_enm; 
							$Pret = PG_curl_sendA( $line_set , $item_array, $if_type, $if_data, '', $sys_link, '' , '' );
							sleep(1);

						} else  m_("TAB_curl_sendA -- Error");
						if( $Pret ) m_("c  Successful creation of the $tab_hnm table - $tab_enm.");
					}
				}

			} else {
				m_("Error INSERT table10_pg_table , $tab_enm , $tab_hnm ");
			}
		} else m_("ERROR INSERT table10_table create_func - tab seqno in ");
		exit;
	}
	function Table_check_(){
		global $table_prefix, $tab_enm, $tkher;
		$sql = "SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' ";
		$rec = sql_fetch($sql);
		if( isset($rec['tab_enm']) && $rec['tab_enm'] !='' ) return true;
		else {
			m_("Table_check_ ---- tab_enm: $tab_enm");
			return false;
		}
	}
	function kapp_table_check( $tab ){
		global $table_prefix;
		$sql = "SELECT COUNT(*) as cnt FROM Information_schema.tables WHERE table_schema = '".KAPP_MYSQL_DB."' AND table_name = '".$tab."' ";
		$ret = sql_fetch( $sql);
		if( isset($ret['cnt']) && $ret['cnt'] > 0 ) { 
			m_("Rec count:".$ret['cnt'] .", " . $tab . ", already exists. ");
			echo "<br>rec count:".$ret['cnt'] .", " . $tab . ", already exists. ";
			return true;
		} else { 
			echo "<br>" . $tab . ", --- ";
			m_("--- none tab: " . $tab );
			return false;
		}
	}
?>
