<?php
	include_once('./tkher_start_necessary.php');
	/*
		kapp_table_index_Create.php : Table index create
		kapp_save_session.php - project_nmS set
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
<!DOCTYPE html>
<html lang="en">
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
table {}
th, td { padding: 8px; text-align: center; border-bottom: 1px solid #DDD; }
tr:hover {background-color: #D6EEEE;}
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/kapp_table.js"></script>

<?php
	$key_msg='';
	if( isset($_POST['mode']) ) $mode= $_POST['mode'];
	else $mode = '';	
	if( isset($_POST['tab_hnmS']) ) $tab_hnmS= $_POST['tab_hnmS'];
	else $tab_hnmS = '';	

	if( $mode=='Project_Search' ) { 
		$project_nmS = $_POST['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	} else if( isset( $_POST['project_nmS']) && $_POST['project_nmS']!='' ) {
		$project_nmS = $_POST['project_nmS'];
		$pcd_nm = explode(":", $project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	} else {
		$project_nmS = '';
		$project_name= "";
		$project_code= "";
	}
	if( $mode=='SearchTAB' ) {
		$tab_hnmS =$_POST['tab_hnmS'];
		$tab_R = explode(":", $tab_hnmS);
		$tab_enm = $tab_R[0];
		$tab_hnm = $tab_R[1];
	} else if( isset($_POST['tab_hnmS']) && $_POST['tab_hnmS']!='' ) {
		$tab_hnmS =$_POST['tab_hnmS'];
		$tab_R = explode(":", $tab_hnmS);
		$tab_enm = $tab_R[0];
		$tab_hnm = $tab_R[1];
	} else {
		$tab_hnmS = '';
		$tab_enm = '';
		$tab_hnm = '';
	}

	if( isset($_POST['seqno']) ) $seqno= $_POST['seqno'];
	else  $seqno = "";
	if( isset($_POST['idx_name']) ) $idx_name= $_POST['idx_name'];
	else  $idx_name = "";
	if( isset($_POST['item_cnt']) ) $item_cnt= $_POST['item_cnt'];
	else  $item_cnt = 0;
?>
<body leftmargin="0" topmargin="0">
 
<?php
	if( $mode == 'SearchTAB' || isset($_POST['tab_nmS']) ){
		$aa				= explode(':', $tab_hnmS);
		$tab_enm		= $aa[0];
		$tab_hnm		= $aa[1];
		$sqlTAB		= "SELECT * from {$tkher['table10_table']} where userid='$H_ID' && tab_enm='$tab_enm' && fld_enm='seqno' ";
		$rsTAB			= sql_fetch($sqlTAB);
		$key_msg		= $rsTAB['key_msg'];
		$item_array		= $rsTAB['memo'];
		$key_array		= $rsTAB['relation_data'];
		$itX = explode("@",$item_array);
		$item_cnt		= count($itX) -1;
	}
?>
<center>
		<form name="kapp_makeform" method="post" >
			<input type="hidden" name="sellist"	        value="" >
			<input type="hidden" id='mode' name="mode" value="<?=$mode?>" >
			<input type="hidden" id="key_array" name="key_array" value="<?=$key_array?>" > 

<div id='menu_normal'>
   <table height='100%' cellspacing='0' cellpadding='4' border='1' > 




<tr><td colspan='2' align="center" <?php echo" title='Create index of Table \n 1:Select Project and Table \n 2:Enter program name \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;">
		Creation Index of Table (<?=$H_ID?>)<br>
			Project:<SELECT id='project_nmS' name='project_nmS' onchange="change_project_Index_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:50%; height:30px;" >

			<option value=''>1.Select Project</option>
<?php 
		if( $mode=='Project_Search' || isset( $_POST['project_nmS']) ) echo "<option value='$project_nmS' selected >$project_name</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by upday desc " ); 
		while( $rs = sql_fetch_array($result)) {
			$chk = "";
			if( $project_code == $rs['group_code']) $chk = " selected ";
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php echo $chk; ?> title='Project code: <?php echo $project_code;?>' ><?=$rs['group_name']?></option>
<?php	} ?>
			</SELECT>
</td></tr>

<tr><td colspan='2' <?php echo" title='New Index creation order \n 1:Enter index name \n 2:Select columns \n 3:Click Create button.'  "; ?> style="border-style:;background-color:#666666;color:cyan;width:100%; height:20px;text-align:center;">
			Table:&nbsp;

<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_Index_func(this.value);" style="border-style:;background-color:#666666;color:yellow;width:50%; height:30px;">
					<option value=''>2.Select table</option>
<?php 
				if( $mode=='SearchTAB' || isset($_POST['tab_nmS'])) echo "<option value='$tab_hnmS' selected >$tab_hnm</option>";
				$result = sql_query( "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and group_code='$project_code' and fld_enm='seqno'" );
				while( $rs = sql_fetch_array($result)) {
					if( $tab_enm == $rs['tab_enm'] ) $sel = ' selected ';
					else $sel='';
?>
					<option value='<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>' title='Table code: <?=$rs['tab_enm']?>' <?=$sel?> ><?=$rs['tab_hnm']?></option>
<?php
				}
?>
</SELECT>
</td></tr>

<tr><td colspan='2' style="text-align:left;background-color:#666666;color:cyan;" >
Index name:<input type='text' id='idx_name' name='idx_name' value='<?=$idx_name?>' style="border-style:;background-color:black;color:yellow;height:25px;width:180;">
&nbsp;<input type='checkbox' id='idxdup_confirm' name='idxdup_confirm' value='Confirm' onClick="return false">&nbsp;
&nbsp;<input type='button' onclick="Index_name_Dup_Check()" value='Duplicate check' >
&nbsp;<input type='button' value='Index Create' onClick="index_Create_button('kapp_index_Create')" style="border-style:;background-color:#666fff;color:yellow; height:30px;">
</td></tr>
<tr>
	<td valign="top" style='text-align:left;width:50%;'>
	<div id="here">
	<table border="1" style='text-align:left;table-layout:fixed;'>
<?php
	$qna = "sequence of the work|Select Project and Table.|Enter index name.|Click Column button.|Click Create button.|"; // 4:item cnt, ^:item add.
	$column_ = "";
	if( $mode == 'SearchTAB' || isset($_POST['tab_nmS'])){
		$itX = explode("@",$item_array);
		for( $i=0, $j=0; $i<$item_cnt; $i++, $j++){
			$it = explode("|",$itX[$i]);
			$column_ = $column_ . "<label id='columnRX".$j."' onclick='column_list_onclickAA(" .$j. " )'><input type='checkbox' id='column_list".$j."' name='column_list' onclick='column_list_onclickA(this.value, " .$j. ")' value='".$itX[$i]."'><label id='columnR".$j."'>".$it[2]."</label></label><br>";
		}
		echo "<script> Print_item_func(\"".$column_."\", \"".$qna."\");</script> "; 
	} else {
		$column_ = "";
	}
?>
	</table>
	</div>
	</td>
	<td valign="top" style='text-align:center;'>
	<div id="here">
	<table border="1">
				<tr>
				  <td style='background-color:#000000;color:yellow;height:30px;text-align:center;'>index list of <?=$tab_hnm?></td>
				</tr>
				<tr>
				  <td valign="top" style='background-color:#f5f5f5;color:black;height:30px;text-align:center;'>
					 <SELECT id="fnclist" style="width:100%" onChange="indexlist_onclick(this.value)" multiple size="8" name="fnclist">
<?php
	if( $mode=='SearchTAB' || isset($_POST['tab_nmS'])){
		$keyA = explode("@",$key_array);
		echo "<option value='seqno' title='Cannot be deleted'>PRIMARY KEY (seqno)</option>";
		$key_flds = ''; 
		for( $i=0; $i < count($keyA) && $keyA[$i]!=''; $i++){
				$key_i = explode("|", $keyA[$i]);
				$key_cnt = count($key_i);
				$key_flds = ''; 
				$key_flds = $key_i[2];
				for( $k=3; $k < $key_cnt; $k++) $key_flds = $key_flds . " + " . $key_i[$k];
				$k_m = $key_i[1] . ":" . $keyA[$i];
				echo "<option value='".$key_i[1]."' title='".$k_m."'>".$key_i[1]." KEY (".$key_flds.") </option>";
		}
	} else {
				echo "<option value='' ></option>";
	}
?>
					  </SELECT>
				   </td>
				 </tr>
				 <tr>
					<td height="24">Selection index:<input id='index_name' name='index_name' readonly title='readonly'>
					<input type='button' id='Delete_idx' value="Delete" style="border:1px solid black;background-color:red;color:white;height:27px;border-radius:20px;" title='Delete index key. caution!'>
					<textarea id='mns' onKeyUp='ption()' name='ents' rows='3' cols='60' onChange='chkDescription()' style="display:none;"></textarea>
					</td>
				 </tr>
	</table>
	</div>
	</td>
</tr>
<tr><td colspan='2' bgcolor="#666666" height="27">
</td></tr>
<tr><td colspan='2' height="24" title='Enter the column name and click the button! ' >
</td></tr>
		<input type='hidden' id='column_index' name='column_index' >
		<input type='hidden' name='multy_menu_sel' >
		<input type='hidden' id='tab_enm' name='tab_enm' value='<?=$tab_enm?>' >
		<input type='hidden' id='tab_hnm' name='tab_hnm' value='<?=$tab_hnm?>' >
		<input type='hidden' id='seqno' name='seqno' value='<?=$seqno?>' >
		<input type='hidden' name='item_cnt' value='<?=$item_cnt?>' >
		<input type='hidden' name='item_array' value='<?=$item_array?>' >
</form>
</table>
</div>
</body>
</html>
