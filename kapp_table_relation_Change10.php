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
<body leftmargin="0" topmargin="0">
<script language="JavaScript"> 
<!--
	function reset_confirm(){
		var relation_num = document.getElementById('relation_num').value;
		resp = confirm(' Would you like to reset relationship data removable? reset relation no: ' + relation_num);
		if( !resp ) return false;
		else {
			document.makeform.mode.value='Reset_Check';
			document.makeform.relation_reset.value='on';
			document.makeform.relation_move_data.value='';
			document.makeform.relation_data.value='';
			document.makeform.relation_key.value='';
			document.makeform.action="kapp_table_relation_Change10.php";
			document.makeform.submit();
		}
		return;
	}
	function delete_confirm(){
		resp = confirm(' Would you like to Delete relationship data removable?');
		if( !resp ) return false;
		else {
			document.makeform.mode.value='Delete_Check';
			document.makeform.relation_reset.value='';
			document.makeform.relation_move_data.value='';
			document.makeform.relation_data.value='';
			document.makeform.action="kapp_table_relation_Change10.php";
			document.makeform.submit();
		}
		return;
	}
	function relation_back_func(){
		document.makeform.mode.value="";
		document.makeform.relation_reset.value = '';
		document.makeform.action="kapp_table_relation10.php";
		document.makeform.submit();
	}
	function relation_Cancel_func(relation_num){
		resp = confirm(' Do you want to Cancel relation - '+relation_num +' ?');
		if( !resp ) return false;
		document.makeform.mode.value="";
		document.makeform.relation_reset.value = '';
		document.makeform.action="kapp_table_relation10.php";
		document.makeform.submit();
	}
	function relation_save_ALL_func(relation_num) {
		if( document.makeform.relation_type_SQL[0] === false && document.makeform.relation_type_SQL[1] === false){
			alert(" The relation is Update. Please select a key field and click the 'SQL Save' button to save it! ");
			return false;
		}
		if( document.makeform.relation_move_data.value ==''){ 
			alert(" After setting the relational expression, click the 'save' button!");
			return false; 
		}
		if( document.makeform.relation_key_column.value ==''){ 
			alert(" After setting the relational key column expression, click the 'save' button!");
			return false; 
		}
		key_col = document.makeform.relation_key_column.value;
		var colnm = document.getElementsByName('re_key_col'); 
		var k_cnt = colnm.length;
		colnm_value = document.getElementById('relation_key_column').value + ":";
		$k_check = 0;
		for( i=0; i<k_cnt; i++){
			if( document.getElementById('re_key_col'+i).checked === true ){
				if( i ==0 ) colnm_value =  colnm_value + colnm[i].value + "|";
				else if( i > 0 ) colnm_value =  colnm_value + ":" + colnm[i].value + "|";
				$k_check++;
			}
		}
		if( $k_check == 0 ){
			alert("key column no clicked"); return false;
		}
		document.getElementById('relation_key').value= colnm_value;
		document.getElementById('relation_key_column').value = colnm_value;
		
		//document.getElementById('relation_key_old_'+relation_num).value = colnm_value;
		document.getElementById('relation_key_old_['+relation_num+']').value = colnm_value;

		resp = confirm(' Do you want to Save relation - '+relation_num +' ?');
		if( !resp ) return false;
		document.makeform.modeRun.value="table_relation_save_Change";
		document.makeform.action="kapp_table_relation_Change10.php";
		document.makeform.submit();
	}
	function create_after_run(relation_pg_codeS, Rtab_hnmS){
		document.makeform.mode.value='Save_OK';
		document.makeform.target		='_self';
		document.makeform.action		="kapp_table_relation_Change10.php";
		document.makeform.submit();
	}

	function relation_move_set(){
		var relation_pg_codeS = document.getElementById('relation_pg_codeS').value;
		var Rtab_hnmS = document.getElementById('Rtab_hnmS').value;
		var pg_name = document.getElementById('pg_name').value;
		var tab_hnm = document.getElementById('tab_hnm').value;
		if(!relation_pg_codeS){
			alert(' Select the program for which you want to set the relationship!');
			return false;
		}
		if(!Rtab_hnmS){
			alert(' Please select a table of relations!');
			return false;
		}
		var fld1e = document.makeform.pg_tab_column.value;
		if( !fld1e ) {
			alert(' Please select a column in the program table!');
			return false; 
		}
		var fld2e = document.makeform.re_tab_column.value;
		if( !fld2e  ) {
			alert(' Please select a column in the relational table!');
			return false; 
		}
		var t3 = document.makeform.sellist_calc.value;
		if( !t3 ) {
			alert(' Please select a relationship!');
			return false; 
		}
		fld1ex = fld1e.split(":"); 
		var fld1h = fld1ex[1];
		fld2ex = fld2e.split(":");	 
		var fld2h = fld2ex[1];


		if( fld1ex[2] == fld2ex[2] ){ //2:data type, 3:data length, = rj[1]+':'+ rj[2] + ':'+ rj[3]+ ':' + rj[4];
		} else {
			if( fld1ex[2]!='TIMESTAMP' && fld1ex[2]!='DATETIME' && fld2ex[2] !='DATE' && fld2ex[2] !='YEAR') {
				alert("The data types are not the same." + ", pg type: "+fld1ex[2]+", relation type:"+ fld2ex[2]);
				return false;
			}
		}

		r_tab = Rtab_hnmS.split(":");
		relation_data = document.makeform.relation_data.value;
		nmxh = document.makeform.nmxh.value;
		document.makeform.nmxh.value = nmxh + fld1h + calc_val + fld2h + " , ";
		nmx2 = document.makeform.relation_move_data.value;

		var calc_val = t3;
		document.makeform.relation_move_data.value =  nmx2 + fld1h + calc_val + fld2h + " , ";	
		document.makeform.relation_data.value = relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		relation_num = document.getElementById('relation_num').value;
		Rdata = Rtab_hnmS + relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		
		//document.getElementById('relation_data_old_'+relation_num).value = Rdata; 
		document.getElementById('relation_data_old_['+relation_num+']').value = Rdata; 

		//document.getElementById('relation_data_tab').value = document.getElementById('relation_data_old_0').value + '^' +document.getElementById('relation_data_old_1').value + '^' + document.getElementById('relation_data_old_2').value;
		return;
	}
	function Change_Relation_Table_func(ptbS){ // Relation_Table_func
		no = document.getElementById('relation_num').value;
		if( ptbS == '') {
			alert('Select Relation Table!');
			return false;
		}
		tb = ptbS.split(':');
		document.getElementById('modeRun').value = 'Relation_SearchTAB';
		document.makeform.action="kapp_table_relation_Change10.php";
		document.makeform.submit();
	}
/*
val: Insert, pg: 0, dd: dao_1766822184:ABC_AAA:|fld_1|상품|VARCHAR|15@|fld_2|원산지|VARCHAR|15@|fld_3|단위|VARCHAR|15@|fld_4|수량|INT|12@|fld_5|단가|INT|12@|fld_6|금액|INT|12@|fld_7|날짜|DATE|15@$fld_1:fld1|=|fld_1:상품:VARCHAR:15$fld_2:fld2|=|fld_2:원산지:VARCHAR:15$fld_3:fld3|=|fld_3:단위:VARCHAR:15$fld_4:수량|=|fld_4:수량:INT:12$fld_5:단가|=|fld_5:단가:INT:12$fld_6:금액|=|fld_6:금액:INT:12$fld_7:날짜|=|fld_7:날짜:DATE:15
*/
	function relation_sql_type( pg, val){
		dd = document.getElementById('relation_data_old_['+pg+']').value;
		if( dd==''){
			alert("Please set up the removable data first! type: "+val);//data 이동식을 먼저 설정 하세요! 
			document.makeform.relation_type_SQL[0].checked = false;
			document.makeform.relation_type_SQL[1].checked = false
			return;
		}
		sql_v = val+':::@@'; 
		document.getElementById('relation_key_column').value= val;
		Rtab_col = document.getElementById('Rtab_col').value; 	
		RTcol = Rtab_col.split('|');
		rdata = dd.split('$');
		st = " style='background-color:cyan;' ";
		ss='';
		k=0;
		for( i=0; RTcol[i] !='' && i<RTcol.length; i++){
			RTcol_i = RTcol[i];
			rr_fld = RTcol_i.split(':');
			re_enm = rr_fld[0]; // enm
			re_hnm = rr_fld[1]; // hnm
			re_yp  = rr_fld[2]; // type
			ck = '';
			for( j=1; rdata[j] !='' && j<rdata.length; j++){
				rr = rdata[j].split('|');
				pg = rr[0]; // program field
				sk = rr[1]; // sik
				RF = rr[2]; // relation table field
				fn = RF.split(':');
				Renm = fn[0];
				Rhnm = fn[1];
				Rtyp = fn[2];
				Rlen = fn[3];
				Kval = Renm+":"+Rhnm+":"+Rtyp+":"+Rlen;
				if( Renm == re_enm) {
					tt = "Renm:" + Renm+", Rhnm:" + Rhnm+", Rtyp:" + Rtyp+", Rlen:" + Rlen;
					ss+="<label " +st+ " title='"+ tt +"'><input type='checkbox' "+ck+" id='re_key_col"+k+"' name='re_key_col' title='"+ tt+"' value='"+ Kval+"'>"+Rhnm+"</label><br>";
					k++;
				}
			}
		}
		here_relation.innerHTML = ss;
		alert("Now, set the key column!"); // 지금, key column을 설정하세요!
	}
	function close_func(){
		windows.close();
	}
	function Breturn_func(){
		document.makeform.relation_reset.value = '';
		document.makeform.mode.value='';	
		document.makeform.action ="kapp_table_relation10.php";
		document.makeform.target='_self';
		document.makeform.submit();
	}
	function sendDataToPHP( projectnmS, pnmdataS ) { /* don't change */
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
//-->
</script>

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
		<FORM name='makeform' METHOD='POST' enctype="multipart/form-data">
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
										<input type='button' id='Applyrun' name='Applyrun' title='Apply the relational expression.' onClick="relation_move_set()" value='Apply'  style="background-color:#666666;color:yellow;width:90px;height:50px;text-align:center;">
                                  </td>
								</tr>
                             </table>
                           </td>
                           <td valign="top" >
                                <table width='' cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td style="border-style:;background-color:#666666;color:white;height:33px;font-size:15;text-align:center;">Relation table column</td></tr>
								<tr><td>
		<SELECT id='Rtab_hnmS' name='Rtab_hnmS' onchange="Change_Relation_Table_func(this.value);" style="background-color:#666666;color:yellow;height:33px;font-size:15;" >
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
 <input type='radio' onclick="relation_sql_type(<?=$relation_num?>,this.value)" id='relation_type_SQL' name='relation_type_SQL' value='Insert' <?php if( isset($type_R_num[0]) && $type_R_num[0] =='Insert') echo 'checked'; ?> >Insert</label>
<?php echo "<label style='background-color:$rel_cB;' title='Update must set the key column.' >"; ?>
 <input type='radio' onclick="relation_sql_type(<?=$relation_num?>,this.value)" id='relation_type_SQL' name='relation_type_SQL' value='Update' <?php if( isset($type_R_num[0]) && $type_R_num[0] =='Update') echo 'checked'; ?> >Update</label>
						
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
		<input type='button' value='Change Save Submit ' id='all_save_button' onclick='relation_save_ALL_func(<?=$relation_num?>)' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>&nbsp;&nbsp;&nbsp;
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
