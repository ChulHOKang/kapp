<?php
	include_once('./tkher_start_necessary.php');
	/*
	 *  kapp_table_relation_Change10.php - kapp_table_relation10.php
			: Relation Number data change.
			: You must set the Key field. 반드시 Key field를 설정해야 한다.
			: {$tkher['table10_pg_table']}
	 *  kapp_save_session.php
	 */
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID = get_session("ss_mb_id");
	if( !$H_ID || $H_ID == ''){
		m_("Login please.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	} else {
		$H_LEV = $member['mb_level']; 
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
<style>
	textarea {
	  width: 600px;
	  height: 30px;
	  padding: 0px;
	  border: 2px solid #ccc;
	  border-radius: 0px;
	  background-color: #000000;
	  font-family: Arial, sans-serif;
	  font-size: 12px;
	  color: #fff;
	}
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/kapp_table.js"></script>
<body leftmargin="0" topmargin="0">

<?php
	if( isset($_POST['relation_num']) ) $relation_num = $_POST['relation_num'];
	else $relation_num = 0;	//m_("relation_num: $relation_num");
	if( isset($_POST['relation_type_memo']) ) $relation_type_memo = $_POST['relation_type_memo'];
	else $relation_type_memo = '';

	if( isset($_POST['modeRun']) ) $modeRun = $_POST['modeRun'];
	else $modeRun = '';

	if( isset($_POST['modeRun']) && $_POST['modeRun'] == 'table_relation_save_Change' ) {
		$modeRun = $_POST['modeRun'];
		$pg_code = $_POST['pg_code'];
		table_relation_save_func( $pg_code, $relation_num );
		echo "<script>Breturn_func();</script>";
	}
	$relation_data_old_ = array();
	$relation_key_old_ = array();
	$data_R = array();
	$type_R = array();
	$pg_rel = array(); // program relation set column
	$re_rel = array(); // relation table   set column
	$data_R_num = array();
	$type_R_num = array();
	$rel_cA = 'white';
	$rel_cB = 'white';
	$relation_data ='';
	$relation_move_data ='';
	$mode ='';
	$relation_reset ='';
	$item_array='';
	$relation_project_nmS = '';
	$project_name= '';
	$project_code= '';
	$relation_pg_codeS = '';
	$pg_code = '';
	$pg_name = '';
	$tab_enm = '';
	$tab_hnm = '';
	$Rtab_hnmS = '';
	$tab_enmR = '';
	$tab_hnmR = '';
	$relation_type_key = '';
	$relation_key = '';
	$relation_data_tab = '';
	$relation_key_column='';

	if( isset($_POST['R_count_max']) )  $R_count_max = $_POST['R_count_max'];
	else $R_count_max=10;
	
	if( isset($_POST['relation_key_old_']) )  $relation_key_old_  = $_POST['relation_key_old_'];
	if( isset($_POST['relation_data_old_']) ) {
		$relation_data_old_ = $_POST['relation_data_old_'];
			$relation_data_old_ = $_POST['relation_data_old_'];
			$T1 = explode(":",$relation_data_old_[$relation_num]);
	}

	if( isset($_POST['mode']) && $_POST['mode'] == 'Reset_Check' || $modeRun == 'Relation_SearchTAB') {
		$mode =$_POST['mode'];
		if( isset($_POST['relation_data_tab']) ) $relation_data_tab = $_POST['relation_data_tab'];
		if( isset($_POST['project_code']) ) $project_code = $_POST['project_code'];
		if( isset($_POST['project_name']) ) $project_name = $_POST['project_name'];
		if( isset($_POST['pg_code']) ) $pg_code = $_POST['pg_code'];
		if( isset($_POST['pg_name']) ) $pg_name = $_POST['pg_name'];
		if( isset($_POST['tab_enm']) ) $tab_enm = $_POST['tab_enm'];
		if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
		if( isset($_POST['item_array']) ) $item_array = $_POST['item_array'];
		if( isset($_POST['relation_type_key']) && $_POST['relation_type_key'] !='' ) {
			$relation_type_key = $_POST['relation_type_key'];
			$relation_type_ = explode("^", $relation_type_key);
			$relation_type = explode("@", $relation_type_[0]);
			if( isset( $relation_type[$relation_num])) $relation_key_column = $relation_type[$relation_num];
			else $relation_key_column = '';
		}
	}
	if( isset( $_POST['relation_project_nmS']) ) $relation_project_nmS = $_POST['relation_project_nmS'];
	else $relation_project_nmS = '';
	if( isset($_POST['relation_pg_codeS']) ) $relation_pg_codeS =$_POST['relation_pg_codeS'];
	else $relation_pg_codeS ='';

	if( $modeRun=='Relation_SearchTAB' ) {
		if( isset($_POST['Rtab_hnmS']) && $_POST['Rtab_hnmS'] !='' ){
			$Rtab_hnmS =$_POST['Rtab_hnmS'];
			$relation_TAB = explode(":", $Rtab_hnmS); //dao_1766735120:ABCYY
			$tab_enmR = $relation_TAB[0];
			$tab_hnmR = $relation_TAB[1];
			$T1[1] = $relation_TAB[1];
		}
	}
	$relation_numX = (INT)$relation_num +1;
?>
<center>
   <table width='300' cellspacing='0' cellpadding='4' border='1' class="c1">
		<FORM name='kapp_Relation_resetForm' METHOD='POST' enctype="multipart/form-data">
			<input type="hidden" name="mode" value="<?=$mode?>" >
			<input type="hidden" name="relation_reset"  value="<?=$relation_reset?>" >
			<input type="hidden" name="modeRun" id="modeRun" value="<?=$modeRun?>" >
			<input type="hidden" name="tab_enm" id="tab_enm" value="<?=$tab_enm?>">
			<input type="hidden" name="pg_code"	id="pg_code" value="<?=$pg_code?>">
			<input type="hidden" name="pg_name"	id="pg_name" value="<?=$pg_name?>">
			<input type="hidden" name="project_code" id="project_code" value="<?=$project_code?>">
			<input type="hidden" name="project_name" id="project_name" value="<?=$project_name?>">
			<input type="hidden" name="item_array" id="item_array" value="<?=$item_array?>">
			<input type="hidden" name="relation_Key_fld" id="relation_Key_fld" value="">
			<input type="hidden" name="relation_Key_nm" id="relation_Key_nm"  value="">
			<input type="hidden" name="relation_Key_fld_type" id="relation_Key_fld_type"  value="">
			<input type="hidden" name="program_Key_fld" id="program_Key_fld" value="">
			<input type="hidden" name="program_Key_nm" id="program_Key_nm" value="">
			<input type="hidden" name="relation_num" id="relation_num" value="<?=$relation_num?>">
			
		  <tr>
			<td align="center" <?php echo" title='\n(work order)\n1:Select program \n2:Select Relation Number \n3:Select relation table \n4:Select relation column \n5:Select relational expression \n6:Apply button \n7:Select Relation SQL Type and Relation Key column set \n8:SQL Save button click \n9:Save button click' "; ?> style="border-style:;background-color:#666666;color:cyan;width:160px; height:33px;font-size:15;">
			Relational Resettings(<?=$H_ID?>)
		<br>Project:<?=$project_name?>
			<input type="hidden" name="relation_project_nmS" id="relation_project_nmS" value="<?=$relation_project_nmS?>">
		<br>Program:<?=$pg_name?>
			<input type="hidden" name="relation_pg_codeS" id="relation_pg_codeS" value="<?=$relation_pg_codeS?>">
		<p style='color:yellow;font-size:18px;'><?=$T1[1]?> : ReSet Relation <?=$relation_numX?></p>
			</td>
		  </tr>
		  <tr>
               <td valign="top" align="center">
                    <table width='' border="1" cellspacing="0" cellpadding="0">
                       <tr>
                              <td valign="top" align="right" >
                                <table cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td bgcolor="#666666" height="30" align="center">
									  <font color="#FFFFFF" >Program table column</font>
									</td>
                                  </tr>
                                  <tr>
									<td>
									<input id='tab_hnm' name='tab_hnm' maxlength='250' style="border-style:;background-color:#666666;color:yellow;height:33px;font-size:15;" type='text'  value='<?=$tab_hnm?>' title='table code:<?=$tab_enm?>' readonly>
									</td>
                                  </tr>
                                  <tr>
								  <td valign="top">
<?php
	$sel_color  = 'white';
	pg_tab_disp( $item_array );
?>
                                     </td>
                                   </tr>
                            </table>
                          </td>
                          <td valign="top">
                              <table border="1" style='text-align:center;table-layout:fixed;'>
                                <tr>
                                  <td align="center" style="background-color:#666666;color:#ffffff;" >Relationship <br> Select<br>
								  </td>
                                </tr>
                                
								<tr>
                                  <td height="15" align='center'><br>
										<p><label> <input type='radio' id='sellist_calc' name='sellist_calc' value='='>=(Move)</label></p>
										<p><label> <input type='radio' id='sellist_calc' name='sellist_calc' value='+'>+( Plus )</label></p>
										<p><label> <input type='radio' id='sellist_calc' name='sellist_calc' value='-'>-(Minus)</label></p>
										<br>
										<input type='button' id='Applyrun' name='Applyrun' title='Apply the relational expression.' onClick="relation_move_Reset()" value='Apply'  style="background-color:#666666;color:yellow;width:90px;height:50px;text-align:center;">
                                  </td>
								</tr>
                             </table>
                           </td>
                           <td valign="top" >
                                <table width='' cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td style="border-style:;background-color:#666666;color:white;height:33px;font-size:15;text-align:center;">Relation table column</td></tr>
								<tr><td>
		<SELECT id='Rtab_hnmS' name='Rtab_hnmS' onchange="Change_Relation_Table_resetfunc(this.value);" style="background-color:#666666;color:yellow;height:33px;font-size:15;" >
<?php 
		if( $mode=='Reset_Check' && $modeRun=='Relation_SearchTAB' ) {
			$Rtab_hnmS = $_POST['Rtab_hnmS'];
			$tab_R = explode(":", $Rtab_hnmS);
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];
		}
		if( $modeRun=='Relation_SearchTAB') echo "<option value='$Rtab_hnmS' selected >$tab_hnmR</option>";
		else echo "<option value=''>Select Relation Table</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where group_code='$project_code' and userid='$H_ID' and fld_enm='seqno' " );//관계용테이블선택.
		while( $rs = sql_fetch_array($result)) {
?>
			<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['memo']?>" title='Table code:<?=$rs['tab_hnm']?>:<?=$rs['memo']?>' <?php if( $tab_enmR==$rs['tab_enm']) echo ' selected '; ?> ><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</SELECT>
			<input type='hidden' id='tab_hnmR' name='tab_hnmR' value='<?=$tab_hnmR?>' >
			<br>
			</td>
		  </tr>
		  <tr>
			 <td valign="top">
	<div id="here_relation" style="font-size:18px;">
<?php
if( $mode !='Project_Search' && $mode !='Delete_Check' ){
	$Rtab_col = Relation_Table_Display( $tab_enmR );
}
?>
	</div>
	<input type='hidden' id='Rtab_col' name='Rtab_col' value='<?=$Rtab_col?>'>
					 </td>
				   </tr>
			</table>
		  </td>
		 </tr>
	   </table>
                      </td>
                     </tr>
					  <tr><!-- SQL Type은 변경을 할것인지 또는 등록을 할것인지를 구분하는 것이다. -->
						<td title='SQL Type distinguishes whether to change or register.'>
	<input id='relation_move_data' name='relation_move_data' value='<?=$relation_move_data?>' style="border-style:;background-color:#666666;color:yellow;width:600px;height:33px;font-size:12;" readonly title='relation_move_data:<?=$relation_move_data?>'>
<br>Relation SQL Type:
<?php echo "<label style='background-color:$rel_cA;' title='Insert does not require a key column.'>"; ?>
 <input type='radio' onclick="relation_sql_typeReset(<?=$relation_num?>,this.value)" id='relation_type_SQL' name='relation_type_SQL' value='Insert' <?php if( isset($type_R_num[0]) && $type_R_num[0] =='Insert') echo 'checked'; ?> >Insert</label>
<?php echo "<label style='background-color:$rel_cB;' title='Update must set the key column.' >"; ?>
 <input type='radio' onclick="relation_sql_typeReset(<?=$relation_num?>,this.value)" id='relation_type_SQL' name='relation_type_SQL' value='Update' <?php if( isset($type_R_num[0]) && $type_R_num[0] =='Update') echo 'checked'; ?> >Update</label>
						
<?php
 echo "<br>Relation Key Column:<input id='relation_key_column' name='relation_key_column' type='text' style='width:600px;height:33px;' value='' readonly>";
?>

<br>
	<!-- display:none -->
	<!-- (all) --><textarea id='relation_data_tab' name='relation_data_tab' style="display:none;"><?=$relation_data_tab?></textarea>
	<!-- (all) --><textarea id='relation_type_key' name='relation_type_key' style="display:none;"><?=$relation_type_key?></textarea>
	<!-- (now) --><textarea id='relation_data' name='relation_data' style="display:none;" title='now data'><?=$relation_data?></textarea>
	<!-- (now) --><textarea id='relation_key'  name='relation_key'  style="display:none;" title='now key'><?=$relation_key?></textarea>
	<textarea id='relation_type_memo' name='relation_type_memo' style="display:none;"><?=$relation_type_memo?></textarea>

<?php
	if( $mode !='Project_Search' && isset($_POST['relation_pg_codeS']) ) {
		for( $i=0,$j=1; $i < $R_count_max; $i++, $j++){
			if( isset( $relation_key_old_[$i]) && $relation_key_old_[$i]!='' ) $relation_key_old_A = $relation_key_old_[$i];
			else $relation_key_old_A='';
			if( isset( $relation_data_old_[$i]) && $relation_data_old_[$i]!='' ) $relation_data_old_A = $relation_data_old_[$i];
			else $relation_data_old_A='';
			echo "
				<textarea id='relation_key_old_[$i]' name='relation_key_old_[$i]' style='display:none;' title='key - i:$i'>$relation_key_old_A</textarea>
				<textarea id='relation_data_old_[$i]' name='relation_data_old_[$i]' style='display:none;' title='data - i:$i'>$relation_data_old_A</textarea>
			";
		}
	}
?>
	<input type='hidden' id='R_count_max' name='R_count_max' value='<?=$R_count_max?>'>
	<input type='hidden' id='nmxh' name='nmxh' value=''>
		  </tr>
		<tr>
		  <td align="center" >
		<input type='button' value='Change Save Submit ' id='all_save_button' onclick='relation_save_ALL_resetfunc(<?=$relation_num?>)' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
		<!-- <input type='button' value=' Cancel ' id='Cancel_button' onclick='relation_Cancel_func(<?=$relation_num?>)' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp; -->
		<input type='button' value=' Back Return ' id='back_button' onclick='relation_back_func()' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		</FORM>
	</table>
<?php
	function pg_tab_disp( $item_array ){
		global $type_R_num, $pg_rel;
		global $mode;
		$pg_col_chk=0;
		$ck = '';
		if( isset( $item_array ) && $item_array !='' ){
			$col_ = explode( "@", $item_array );
			for( $i=0; $i < count($col_)-1; $i++) {
				$_col = explode("|", $col_[$i]);
				if( isset( $type_R_num[1]) && isset($_col[1]) && $type_R_num[1] == $_col[1] ) $ck = ' checked'; // 1: program table key field 
				else $ck = '';
				$pg_col_chk=0;
				$sel_color='white';
				for( $j=0; $j < count($pg_rel); $j++ )	if( $pg_rel[$j]==$_col[2] ) $pg_col_chk=1;
				if( $pg_col_chk==1 ) $sel_color ='cyan';
				echo "<label style='background-color:$sel_color;' title='".$col_[$i]."'><input type='radio' id='pg_tab_column' name='pg_tab_column' value='".$_col[1].":".$_col[2].":".$_col[3].":".$_col[4]."' ".$ck." >".$_col[2]."</label><br>";
			}//for
		}//if
	}
	function Relation_Table_Display( $tab_enmR ){
		global $tkher, $H_ID;
		global $type_R_num, $re_rel;
		global $rel_cA,$rel_cB;
		$Rtab_col ='';
		if( isset($re_rel) ) $rcnt = count( $re_rel);
		else $rcnt = 0;
		$sql = "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enmR' order by disno asc";
		$result = sql_query($sql);
		while( $rsP = sql_fetch_array($result)) {
			if( $rsP['fld_enm'] =='seqno' )	{
				continue;
			}
			if( isset($type_R_num[2]) && $type_R_num[2] == $rsP['fld_enm'] ) {
				$ck = ' checked';
				$rel_cA = 'white'; $rel_cB = 'cyan';
			} else { 
				$ck = ''; 
				$rel_cA = 'white'; $rel_cB = 'white';
			}
			$pg_col_chk=0;
			$sel_color='white';
			for( $j=0; $j < count( $re_rel); $j++ ){
				if( isset($re_rel[$j]) && $re_rel[$j] == $rsP['fld_hnm'] ) {
					$pg_col_chk=1;
					$sel_color ='cyan';
				} 
			}
			echo "<label style='background-color:".$sel_color.";' title='".$rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type'].":".$rsP['fld_len']."'><input type='radio' id='re_tab_column' name='re_tab_column' value='".$rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type'].":".$rsP['fld_len']."' ".$ck.">".$rsP['fld_hnm']."</label><br>";
			$Rtab_col=$Rtab_col . $rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type'].":".$rsP['fld_len']."|";
		}//while
		return $Rtab_col;
	}
	function table_relation_save_func( $pg_code, $Rno ){
		global $tkher, $H_ID, $relation_type_memo, $R_count_max;

		$relation_data_old_ = $_POST['relation_data_old_'];
		$relation_key_old_ = $_POST['relation_key_old_'];

			$relation_data = '';
			$relation_keyT = '';
		for($i=0; $i < $R_count_max; $i++){
			if( $i==0 ){
				$relation_data = $relation_data_old_[$i];
				$relation_keyT = $relation_key_old_[$i];
			} else if( $i>0 ){
				$relation_data = $relation_data . "^" . $relation_data_old_[$i];
				$relation_keyT = $relation_keyT . "@" . $relation_key_old_[$i];
			}
		}
		$relation_type = $relation_keyT . "^";
		//m_("relation_type: $relation_type"); //relation_type: Insert:fld_1:상품:VARCHAR:15|@@@@@@@@@^
		//relation_type: Insert:fld_1:상품:VARCHAR:15|@Update:fld_1:날짜:DATETIME:20|:fld_5:product:VARCHAR:15|@Update:fld_1:년도:YEAR:4|:fld_2:상품:VARCHAR:15|@@@@@@@^
		//relation_type: @Update:fld_1:날짜:DATETIME:20|:fld_5:product:VARCHAR:15|@Update:fld_1:년도:YEAR:4|:fld_2:상품:VARCHAR:15|@@@@@@@^
		$relation_type_memo = $relation_type_memo . " , " . date('Y-m-d:H:i:s') . ":" . $H_ID.":" . $relation_type;
		$query = "UPDATE {$tkher['table10_pg_table']} SET relation_type='$relation_type', relation_data='$relation_data', relation_type_memo='$relation_type_memo' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_("Save, Complete the relationship. pg_code:".$pg_code);
		else m_("Program UPDATE error! ");
	}
?>
</body>
</html>
