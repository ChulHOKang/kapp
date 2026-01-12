<?php
	include_once('./tkher_start_necessary.php');
	/*
	 *  kapp_table_relation_Change.php : call : kapp_table_relationA.php
			: Relation Number data change.
			: Update 에는 반드시 Key field를 설정해야 한다.
			: {$tkher['table10_pg_table']}
	 *  kapp_save_session.php
		relation_data 구성 샘플: dao_1766735120:ABCYY$
		fld_1:fld1|=|fld_5:product:VARCHAR$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT$fld_7:날짜|=|fld_1:날짜:TIMESTAMP@
		dao_1766812390:ABCYY_FFF_New$
		fld_1:fld1|=|fld_5:product:VARCHAR$fld_7:날짜|=|fld_1:날짜:TIMESTAMP$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT@
		dao_1766822184:ABC_AAA$
		fld_1:fld1|=|fld_1:fld1:VARCHAR$fld_7:날짜|=|fld_7:날짜:TIMESTAMP$fld_5:fld5|+|fld_5:fld5:INT$fld_6:fld6|+|fld_6:fld6:INT
		relation_type 구성 샘플: Update:fld_1:fld_5:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_1:CHAR
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
<TITLE>K-App System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>
<body leftmargin="0" topmargin="0">
<script language="JavaScript"> 
<!--
	function reset_confirm(){
		var relation_num = document.getElementById('relation_num').value;
		resp = confirm(' Would you like to reset relationship data removable? reset relation no: ' + relation_num);
		if( !resp ) return false;
		else {
			makeform.mode.value='Reset_Check';
			makeform.relation_reset.value='on';
			makeform.relation_move_data.value='';
			makeform.relation_data.value='';
			makeform.relation_key.value='';
			document.makeform.action="kapp_table_relation_Change.php";
			document.makeform.submit();
		}
		return;
	}
	function delete_confirm(){
		resp = confirm(' Would you like to Delete relationship data removable?');
		if( !resp ) return false;
		else {
			makeform.mode.value='Delete_Check';
			makeform.relation_reset.value='';
			makeform.relation_move_data.value='';
			makeform.relation_data.value='';
			document.makeform.action="kapp_table_relation_Change.php";
			document.makeform.submit();
		}
		return;
	}
	//================================
	function relation_save_ALL_func() {
		if( makeform.relation_type_SQL[0] === false && makeform.relation_type_SQL[1] === false){
			alert(" The relation is Update. Please select a key field and click the 'SQL Save' button to save it! ");
			return false;
		}
		if( document.makeform.relation_move_data.value ==''){ 
			alert(" After setting the relational expression, click the 'save' button!");
			return false; 
		}
		resp = confirm(' Do you want to Save relation '+relation_num +' ?');
		if( !resp ) return false;
		//makeform.relation_reset.value = '';
		makeform.modeRun.value="table_relation_save_Change";
		makeform.action="kapp_table_relation_Change.php";
		makeform.submit();
	}

	function create_after_run(relation_pg_codeS, Rtab_hnmS){
		document.makeform.mode.value='Save_OK';
		document.makeform.target		='_self';
		document.makeform.action		="kapp_table_relation_Change.php";
		document.makeform.submit();
	}
	function Relation_SQL_Key_Set_func(){
		var relation_num = document.getElementById('relation_num').value;
		if ( makeform.relation_type_SQL[0].checked == true ) {
			document.makeform.relation_key.value = 'Insert' + ':' + ':' + ':';
			key_type = document.getElementById('relation_key_old_'+relation_num).value;
			if( key_type=='') document.getElementById('relation_key_old_'+relation_num).value = 'Insert' + ':' + ':' + ':';
		} else {
			var relation_pg_codeS = makeform.relation_pg_codeS.value;
			var Rtab_hnmS = makeform.Rtab_hnmS.value;
			if(!relation_pg_codeS){
				alert(' Select the program for which you want to set the relationship!');
				return false;
			}
			if(!Rtab_hnmS){
				alert(' Please select a table of relations!');
				return false;
			}
			var fld1e = document.makeform.pg_tab_column.value;
			var fld2e = document.makeform.re_tab_column.value;
			if( !fld1e ) {
				alert(' Select a column in the program table!');
				return false; 
			}
			if( !fld2e ) {
				alert(' Select a column in the relational table!');
				return false; 
			}
			fld1ex = fld1e.split(":");	 
			var Kfld1e = fld1ex[0]; 
			var Kfld1h = fld1ex[1]; 
			document.getElementById('program_Key_fld').value = Kfld1e;
			document.getElementById('program_Key_nm').value = Kfld1h; 
			fld2ex = fld2e.split(":");
			var Kfld2e = fld2ex[0]; 
			var Kfld2h = fld2ex[1];
			var Kfld2t = fld2ex[2];
			document.getElementById('relation_Key_fld').value = Kfld2e;
			document.getElementById('relation_Key_nm').value = Kfld2h; 
			if( Kfld2t.indexOf("INT")>=0 || Kfld2t.indexOf("DECIMAL")>=0 || Kfld2t.indexOf("FLOAT")>=0 || Kfld2t.indexOf("DOUBLE")>=0) {
				document.makeform.relation_Key_fld_type.value  = "INT";
			} else document.makeform.relation_Key_fld_type.value  = "CHAR";
			
			Key_data = 'Update' +':'+Kfld1e+':'+Kfld2e+':' + document.getElementById('relation_Key_fld_type').value;
			document.getElementById('relation_key').value= Key_data;
			relation_num = document.getElementById('relation_num').value;
			document.getElementById('relation_key_old_'+relation_num).value = Key_data;
		}
		r_t_k = document.makeform.relation_type_key.value;
		if( r_t_k == '' ){
			//document.makeform.relation_type_key.value = Key_data + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value + "^" + R_item_array + "^" + "^";
		} else {
			rtk[0]=''; rtk[1]=''; rtk[2]='';
			rtk = r_t_k.split("^");
			if( rtk[1] =='') {
				RK = Key_data + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value;
				//document.makeform.relation_type_key.value = RK + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value + "^" + R_item_array + "^" + "^";
			} else {
				if(relation_num==0){
					RK = Key_data + '@' +document.makeform.relation_key_old_1.value + '@' + document.makeform.relation_key_old_2.value;
					//document.makeform.relation_type_key.value = RK + "^" + R_item_array + "^" + rtk[1] + "^" + rtk[2];
				} if(relation_num==1) {
					RK = document.makeform.relation_key_old_0.value + '@' +Key_data + '@' + document.makeform.relation_key_old_2.value;
					//document.makeform.relation_type_key.value = RK + "^" + rtk[0]+ "^" + R_item_array + "^" + rtk[2];
				} if(relation_num==2) {
					RK = document.makeform.relation_key_old_0.value + '@' + document.makeform.relation_key_old_1.value +Key_data;
					//document.makeform.relation_type_key.value = RK + "^" + rtk[0]+ "^" + rtk[1]+ "^" + R_item_array;
				}
			}
		}
	}

	function relation_move_set(){
		var relation_pg_codeS = document.getElementById('relation_pg_codeS').value;
		var Rtab_hnmS = document.getElementById('Rtab_hnmS').value;
		var pg_name = document.getElementById('pg_name').value;
		var tab_hnm = document.getElementById('tab_hnm').value;
		//alert( "tab_hnm: "+tab_hnm+ ", pg_name: " +pg_name);

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
		document.getElementById('relation_data_old_'+relation_num).value = Rdata; 
		document.getElementById('relation_data_tab').value = document.getElementById('relation_data_old_0').value + '^' +document.getElementById('relation_data_old_1').value + '^' + document.getElementById('relation_data_old_2').value;
		return;
	}
	function change_relation_num_func(pg) {
		R_typeA = document.getElementById('relation_type_key').value;
		R_dataA = document.getElementById('relation_data_tab').value;
		if( R_dataA!=''){
			R_data = R_dataA.split('^');
			document.getElementById('relation_data').value= R_data[pg];
		}
		if( R_typeA !=''){
			R_t = R_typeA.split('^');
			R_type = R_t[0].split('@');
			document.getElementById('relation_key').value= R_type[pg];
		}
		dt = document.getElementById('relation_key_old_'+pg).value; 
		dd = document.getElementById('relation_data_old_'+pg).value;
		var selectIndex = document.makeform.Rtab_hnmS.selectedIndex;
		if( dd !=''){
			Rdata = dd.split('$');
			dataT = Rdata[0].split(':');
			tabenm = dataT[0]; // 0:table cd name
			tabhnm = dataT[1];
			document.makeform.Rtab_hnmS[selectIndex].value = Rdata[0];
			document.makeform.Rtab_hnmS[selectIndex].text = dataT[1];
			
		} else {
			document.getElementById('Rtab_hnmS').value = '';
			document.getElementById('re_tab_column').value = '';
		}
		r_func( dd, dt );
		return;
	}
	function r_func(relation_column, keyf){ // only relation column in table
		rt = keyf.split(':');
		rdata = relation_column.split('$');
		len = rdata.length;
		ss="";
		for( i=1; i<len; i++){
			rr = rdata[i].split('|');
			pg = rr[0]; // program field
			sk = rr[1]; // sik
			re = rr[2]; // relation table field
			fn = re.split(':');
			re_enm = fn[0];
			re_hnm = fn[1];
			st = " style='background-color:white;' ";
			ck = "";
			tt = rdata[i];
			if( rt[2] == re_enm) { // rt = Update:fld_1:fld_5:
				st = " style='background-color:cyan;' ";
				ck = " checked ";
				tt = " key " + tt;
			}
			ss+="<label " +st+ " title='"+ tt +"'><input type='radio' "+ck+" id='re_tab_column' name='re_tab_column' title='"+ re+"' value='"+ re+"'>"+re_hnm+"</label><br>";
		}
		here_relation.innerHTML=ss;
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
	function Change_Relation_Table_func(ptbS){ // Relation_Table_func
		no = document.getElementById('relation_num').value;
		if( ptbS == '') {
			alert('Select Relation Table!');
			return false;
		}
		tb = ptbS.split(':');
		document.getElementById('item_array_'+no).value = tb[2];
		sendDataToPHP('Rtab_hnmS', ptbS);
		document.getElementById('modeRun').value = 'Relation_SearchTAB';
		document.makeform.action="kapp_table_relation_Change.php";
		document.makeform.submit();
	}
	function radio_box_func(rnum,val){
		sql_v = val+':::@@';
		document.getElementById('relation_key_old_'+rnum).value = sql_v; 
	}
	function close_func(){
		windows.close();
	}
//-->
</script>

<?php

	$relation_num = $_POST['relation_num'];

	if( isset($_POST['modeRun']) ) $modeRun = $_POST['modeRun'];
	else $modeRun = '';

	if( isset($_POST['modeRun']) && $_POST['modeRun'] == 'table_relation_save_Change' ) {
		$modeRun = $_POST['modeRun'];
		$pg_code = $_POST['pg_code'];
		table_relation_save_func( $pg_code, $relation_num );
		//echo "<script>window.close();</script> ";
		echo "<script>window.open('', '_self').close();</script>";
	}
	$data_R = array();
	$type_R = array();
	$pg_rel = array(); // program relation set column
	$re_rel = array(); // relation table   set column
	$data_R_num = array();
	$type_R_num = array();

	$rel_cA = 'white';
	$rel_cB = 'white';
	$relation_data ='';
	$relation_move_data ='';      // 이동식 컬럼 이동식 데이터
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
	$relation_data_old_0 = '';
	$relation_key_old_0 = '';
	$item_array_0 ='';
	$relation_data_old_1 = '';
	$relation_key_old_1 = '';
	$item_array_1='';
	$relation_data_old_2 = '';
	$relation_key_old_2 = '';
	$item_array_2='';

	if( isset($_POST['mode']) && $_POST['mode'] == 'Reset_Check' || $modeRun == 'Relation_SearchTAB') {
		$mode =$_POST['mode'];
		if( isset($_POST['relation_reset']) ) $relation_reset = $_POST['relation_reset'];

		if( isset($_POST['relation_data_old_0']) ) $relation_data_old_0 = $_POST['relation_data_old_0'];
		if( isset($_POST['relation_data_old_1']) ) $relation_data_old_1 = $_POST['relation_data_old_1'];
		if( isset($_POST['relation_data_old_2']) ) $relation_data_old_2 = $_POST['relation_data_old_2'];

		if( isset($_POST['relation_key_old_0']) ) $relation_key_old_0 = $_POST['relation_key_old_0'];
		if( isset($_POST['relation_key_old_1']) ) $relation_key_old_1 = $_POST['relation_key_old_1'];
		if( isset($_POST['relation_key_old_2']) ) $relation_key_old_2 = $_POST['relation_key_old_2'];
		
		if( isset($_POST['item_array_0']) ) $item_array_0 = $_POST['item_array_0'];
		if( isset($_POST['item_array_1']) ) $item_array_1 = $_POST['item_array_1'];
		if( isset($_POST['item_array_2']) ) $item_array_2 = $_POST['item_array_2'];

		if( isset($_POST['relation_data_tab']) ) $relation_data_tab = $_POST['relation_data_tab'];
		if( isset($_POST['relation_type_key']) ) $relation_type_key = $_POST['relation_type_key'];
		if( isset($_POST['project_code']) ) $project_code = $_POST['project_code'];
		if( isset($_POST['project_name']) ) $project_name = $_POST['project_name'];
		if( isset($_POST['pg_code']) ) $pg_code = $_POST['pg_code'];
		if( isset($_POST['pg_name']) ) $pg_name = $_POST['pg_name'];
		if( isset($_POST['tab_enm']) ) $tab_enm = $_POST['tab_enm'];
		if( isset($_POST['tab_hnm']) ) $tab_hnm = $_POST['tab_hnm'];
		if( isset($_POST['item_array']) ) $item_array = $_POST['item_array'];
	}

	$relation_project_nmS = $_SESSION['relation_project_nmS'];
	$relation_pg_codeS =$_SESSION['relation_pg_codeS'];

	if( $modeRun != 'Relation_SearchTAB') {
		switch($relation_num){
			case '0':
				$relation_data_old_0 = '';
				$relation_key_old_0 = '';
				$item_array_0 ='';
				break;
			case '1':
				$relation_data_old_1 = '';
				$relation_key_old_1 = '';
				$item_array_1='';
				break;
			case '2':
				$relation_data_old_2 = '';
				$relation_key_old_2 = '';
				$item_array_2='';
				break;
		}
	}

	if( $modeRun=='Relation_SearchTAB' ) {
		if( isset($_SESSION['Rtab_hnmS']) && $_SESSION['Rtab_hnmS'] !='' ){
			$Rtab_hnmS =$_SESSION['Rtab_hnmS'];
			$relation_TAB = explode(":", $Rtab_hnmS); //dao_1766735120:ABCYY
			$tab_enmR = $relation_TAB[0];
			$tab_hnmR = $relation_TAB[1];
		}
	}
	$relation_numX = (INT)$relation_num +1;
?>
<center>
   <table width='300' cellspacing='0' cellpadding='4' border='1' class="c1">
		<FORM name='makeform' METHOD='POST' enctype="multipart/form-data">
			<input type="hidden" name="mode" id="mode" value="<?=$mode?>" >
			<input type="hidden" name="modeRun" id="modeRun" value="<?=$modeRun?>" >
			<input type="hidden" name="relation_reset" id="relation_reset" value="<?=$relation_reset?>" >
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
			<td align="center" <?php echo" title='\n(work order)\n1:Select program \n2:Select Relation Number \n3:Select relation table \n4:Select relation column \n5:Select relational expression \n6:Apply button \n7:Select SQL Type \n8:SQL Save button click \n9:Save button click' "; ?> style="border-style:;background-color:#666666;color:cyan;width:160px; height:33px;font-size:15;">
			Relational Resettings(<?=$H_ID?>)
		<br>Project:<?=$project_name?>
			<input type="hidden" name="relation_project_nmS" id="relation_project_nmS" value="<?=$relation_project_nmS?>">
		<br>Program:<?=$pg_name?>
			<input type="hidden" name="relation_pg_codeS" id="relation_pg_codeS" value="<?=$relation_pg_codeS?>">

		<p style='color:yellow;font-size:18px;'>Relation Number: Relation <?=$relation_numX?></p>
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
			$Rtab_hnmS = $_SESSION['Rtab_hnmS'];
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
	Relation_Table_Display( $tab_enmR );
}
?>
	</div>
					 </td>
				   </tr>
			</table>
		  </td>
		 </tr>
	   </table>
                      </td>
                     </tr>
					  <tr><!-- SQL Type은 변경을 할것인지 또는 등록을 할것인지를 구분하는 것이다. -->
						<td title='SQL Type distinguishes whether to change or register.'>SQL Key Type:
 <?php echo "<label style='background-color:$rel_cA;' title='Insert does not require a key column.'>"; ?>
 <input type='radio' onclick='radio_box_func(<?=$relation_num?>,this.value)' id='relation_type_SQL' name='relation_type_SQL' value='Insert' <?php if( isset($type_R_num[0]) && $type_R_num[0] =='Insert') echo 'checked'; ?> >Insert</label>
 <?php echo "<label style='background-color:$rel_cB;' title='Update must set the key column.' >"; ?>
 <input type='radio' onclick='radio_box_func(<?=$relation_num?>,this.value)' id='relation_type_SQL' name='relation_type_SQL' value='Update' <?php if( isset($type_R_num[0]) && $type_R_num[0] =='Update') echo 'checked'; ?> >Update</label>
						
<?php
 echo "<input id='sqlsave_button' type='button' value=' SQL Key Set ' onClick='Relation_SQL_Key_Set_func();' style='height:30px;font-size:15; border-radius:20px;border:1 solid white;' title='If the sql type is update, you need to set the key column. However, insert does not require a key column.'  >";
?>
	<br>
	<input width='' id='relation_move_data' name='relation_move_data' maxlength='250' value='<?=$relation_move_data?>' style="border-style:;background-color:#666666;color:yellow;width:600px;height:33px;font-size:12;" readonly title='relation_move_data:<?=$relation_move_data?>'>
	<!-- display:none -->
	<!-- relation_data_tab(all) --><textarea id='relation_data_tab' name='relation_data_tab' rows='3' cols='84' style="display:none;"><?=$relation_data_tab?></textarea>
	<!-- relation_type_key(all) --><textarea id='relation_type_key' name='relation_type_key' rows='3' cols='84' style="display:none;"><?=$relation_type_key?></textarea>

	<!-- relation_data(now) --><textarea id='relation_data' name='relation_data' rows='3' cols='84' style="display:none;"><?=$relation_data?></textarea>
	<!-- relation_key(now) --><textarea id='relation_key'   name='relation_key'  rows='3' cols='84' style="display:none;"><?=$relation_key?></textarea>

	<!-- relation_data_old_0 --><textarea id='relation_data_old_0' name='relation_data_old_0' rows='3' cols='84' style="display:none;"><?=$relation_data_old_0?></textarea>
	<!-- relation_key_old_0 --><textarea id='relation_key_old_0' name='relation_key_old_0' rows='1' cols='84' style="display:none;"><?=$relation_key_old_0?></textarea>
	<!-- item_array_0 --><textarea id='item_array_0' name='item_array_0' rows='3' cols='84' style="display:none;"><?=$item_array_0?></textarea>

	<!-- relation_data_old_1 --><textarea id='relation_data_old_1' name='relation_data_old_1' rows='3' cols='84' style="display:none;"><?=$relation_data_old_1?></textarea>
	<!-- relation_key_old_1 --><textarea id='relation_key_old_1' name='relation_key_old_1' rows='1' cols='84' style="display:none;"><?=$relation_key_old_1?></textarea>
	<!-- item_array_1 --><textarea id='item_array_1' name='item_array_1' rows='3' cols='84' style="display:none;"><?=$item_array_1?></textarea>
	
	<!-- relation_data_old_2 --><textarea id='relation_data_old_2' name='relation_data_old_2' rows='3' cols='84' style="display:none;"><?=$relation_data_old_2?></textarea>
	<!-- relation_key_old_2 --><textarea id='relation_key_old_2' name='relation_key_old_2' rows='1' cols='84' style="display:none;"><?=$relation_key_old_2?></textarea>
	<!-- item_array_2 --><textarea id='item_array_2' name='item_array_2' rows='3' cols='84' style="display:none;"><?=$item_array_2?></textarea>
	
	<input type='hidden' id='nmxh' name='nmxh' maxlength='250' size='30'  value=''>
		  </tr>
		<tr>
		  <td align="center" >
		<input type='button' value='Change Save Submit ' id='all_save_button' onclick='relation_save_ALL_func()' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		</FORM>
	</table>
<?php
	function Fetch_pg_code($pg_code, $pg_name){
		global $relation_reset, $relation_num, $item_array, $tab_enm, $tab_hnm;
		global $relation_data_tab, $relation_type_key, $relation_key, $relation_data;
		global $relation_move_data;
		global $relation_data_old_0, $relation_key_old_0, $relation_data_old_1, $relation_key_old_1, $relation_data_old_2, $relation_key_old_2;
		global $item_array_0, $item_array_1, $item_array_2;//, $R_item_array;
		global $data_R, $type_R;
		global $tab_enmR, $tab_hnmR;
		global $rel_cA, $rel_cB;
		global $type_R_num, $data_R_num, $pg_rel, $re_rel;
		global $tkher;
			/*
			$relation_move_data = '';
			$relation_data = '';
			$relation_data_tab = '';
			$relation_type_key = '';
			$relation_key = '';
			$relation_data_old_0 = '';
			$relation_key_old_0 = '';
			$relation_data_old_1 = '';
			$relation_key_old_1 = '';
			$relation_data_old_2 = '';
			$relation_key_old_2 = ''; */

		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$pg_code."' ";
		$resultPG= sql_query($sqlPG);	//$table10_pg	= sql_num_rows($resultPG);
		if( sql_num_rows($resultPG) > 0 ) {
			$rsPG = sql_fetch_array( $resultPG);
			$item_array	= $rsPG['item_array'];
			$tab_enm	= $rsPG['tab_enm'];
			$tab_hnm	= $rsPG['tab_hnm'];
			if( $rsPG['relation_data'] !='' ) {
				$relation_data_tab = $rsPG['relation_data'];
				$relation_data     = $rsPG['relation_data'];
				$relation_type_key = $rsPG['relation_type'];
				$relation_key = $rsPG['relation_type'];
				//m_("relation_data: " . $relation_data . ", relation_key: " . $relation_key);
				//relation_data: dao_1766735120:ABCYY$fld_1:fld1|=|fld_5:product:VARCHAR$fld_7:날짜|=|fld_1:날짜:TIMESTAMP$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT@@, relation_key: Insert:::@@
				$data_R    = explode("^", $rsPG['relation_data'] );
				$type_R    = explode("^", $relation_key ); 
				//m_("relation_key: $relation_key");
				//relation_key: Update:fld_1:fld_1:CHAR@@^|fld_1|fld1|VARCHAR|15@|fld_2|fld2|VARCHAR|15@|fld_3|fld3|VARCHAR|15@|fld_4|fld4|INT|12@|fld_5|fld5|INT|12@|fld_6|fld6|INT|12@^^
				if(isset($data_R[0]) && $data_R[0]!=''){
					$relation_data_old_0 = $data_R[0];
					$relation_data_old_1 = $data_R[1];
					$relation_data_old_2 = $data_R[2];

			/* 
					Update:fld_1:fld_1:CHAR@@^|fld_1|fld1|VARCHAR|15@|fld_2|fld2|VARCHAR|15@|fld_3|fld3|VARCHAR|15@|fld_4|fld4|INT|12@|fld_5|fld5|INT|12@|fld_6|fld6|INT|12@^^
			*/
					$key_arrayA = $type_R[0];
					if( isset($type_R[0]) ) {
						$key_arrayA = explode("@", $key_arrayA );
						$relation_key_old_0 = $key_arrayA[0];
						$relation_key_old_1 = $key_arrayA[1];
						$relation_key_old_2 = $key_arrayA[2];
					} else {
						$relation_key_old_0 = '';
						$relation_key_old_1 = '';
						$relation_key_old_2 = '';
					}
					if( isset($type_R[1]) ) $item_array_0 = $type_R[1];
					else $item_array_0 = '';
					if( isset($type_R[2]) ) $item_array_1 = $type_R[2];
					else $item_array_1 = '';
					if( isset($type_R[3]) ) $item_array_2 = $type_R[3];
					else $item_array_2 = '';

				}
				if( isset($data_R[$relation_num]) && $data_R[$relation_num] !='' && isset($type_R[$relation_num]) && $type_R[$relation_num] !='' ){
					$data_R_num = explode("$", $data_R[$relation_num] ); //relation_num:0,1,2로하고 화면에는 1,2,3으로 표시만 중요.
					$type_R_num = explode(":", $type_R[$relation_num] );
					$tab_ = $data_R_num[0]; // 0:Relatio Table
					$tab_R    = explode(":", $data_R_num[0] );
					$tab_enmR = $tab_R[0];
					$tab_hnmR = $tab_R[1];
				} else {
					$tab_ = ''; // 0:Relatio Table
					$tab_enmR = '';
					$tab_hnmR = '';
				}
				if( $relation_reset =='on'){ //if( $_POST['relation_reset']=='on' || $_POST['rel_job'] == 'add'){// reset후 테이블을 선택했을 경우 여기로 탄다. 
						$relation_move_data = '';
						//$relation_data = '';
				} else { // reset이 아니면 여기를 탄다.
					for( $i=1; isset($data_R_num) && $i < count( $data_R_num); $i++ ) { //$data_R_num[0] i==0 -> relation table
						$re_data = $data_R_num[$i];
						$rrr = explode("|", $re_data);
						$pg_fld = explode(":", $rrr[0]); //$rrr[1] 연결 식 =, +, -, * 
						$re_fld = explode(":", $rrr[2]);
						$pg_rel[$i-1] = $pg_fld[1];
						$re_rel[$i-1] = $re_fld[1];
						$relation_move_data .= $pg_rel[$i-1]. $rrr[1] . $re_rel[$i-1]. ",";
						//$relation_data = $relation_data . $data_R_num[$i] . '$';
					}
				}
			}
		}
	}
	function pg_tab_disp( $item_array ){
		global $type_R_num, $pg_rel;
		global $mode;
		$pg_col_chk=0;
		$ck = ''; // key fld 'checked' 표시
		if( isset( $item_array ) && $item_array !='' ){
			$col_ = explode( "@", $item_array );
			for( $i=0; $i < count($col_)-1; $i++) {
				$_col = explode("|", $col_[$i]);
				if( isset( $type_R_num[1]) && isset($_col[1]) && $type_R_num[1] == $_col[1] ) $ck = ' checked'; // 1: program table key field 
				else $ck = '';
				$pg_col_chk=0;
				$sel_color='white';
				for( $j=0; $j < count($pg_rel); $j++ )	if( $pg_rel[$j]==$_col[2] ) $pg_col_chk=1;
				if( $pg_col_chk==1 ) $sel_color ='cyan'; //if( $pg_col_chk==1 && $mode!="Reset_Check" ) $sel_color ='cyan';
				echo "<label style='background-color:$sel_color;'><input type='radio' id='pg_tab_column' name='pg_tab_column' value='".$_col[1].":".$_col[2]."' ".$ck." >".$_col[2]."</label><br>";
			}//for
		}//if
	}
	function Relation_Table_Display( $tab_enmR ){
		global $tkher, $H_ID;
		global $type_R_num, $re_rel;//, $R_item_array;
		global $rel_cA,$rel_cB;
		$sql = "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enmR' order by disno asc";
		$result = sql_query($sql);
		if( isset($re_rel) ) $rcnt = count( $re_rel);
		else $rcnt = 0;
		//$R_item_array = '';
		while( $rsP = sql_fetch_array($result)) {
			if( $rsP['fld_enm'] =='seqno' )	{
				//$R_item_array=$rsP['memo'];
				continue;
			}
			if( isset($type_R_num[2]) && $type_R_num[2] == $rsP['fld_enm'] ) {
				$ck = ' checked'; // relation tab
				$rel_cA = 'white'; $rel_cB = 'cyan';
			} else { 
				$ck = ''; 
				$rel_cA = 'white'; $rel_cB = 'white';
			}
			$pg_col_chk=0;
			$sel_color='white';
			for( $j=0; $j < count( $re_rel); $j++ ){
				if( isset($re_rel[$j]) && $re_rel[$j] == $rsP['fld_hnm'] ) {
					$pg_col_chk=1; // 1:관계식 설정된 컬럼.
					$sel_color ='cyan';
				} 
			}
			echo "<label style='background-color:".$sel_color.";' ><input type='radio' id='re_tab_column' name='re_tab_column' value='".$rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type']."' ".$ck.">".$rsP['fld_hnm']."</label><br>";
		}//while
		return;// $R_item_array;
	}
	function relation_array( $relation_num ){
		global $data_R, $type_R, $tab_enmR, $tab_hnmR;
		global $relation_move_data, $relation_data;
		global $pg_rel, $re_rel;

		if( isset($data_R[$relation_num]) && $data_R[$relation_num] !='' && isset($type_R[$relation_num]) && $type_R[$relation_num] !='' ){
			$data_R_num = explode("$", $data_R[$relation_num] ); //$data_R  = explode("^", $relation_data_tab); relation_num:0,1,2로하고 화면에는 1,2,3으로 표시만 중요.
			$type_R_num = explode(":", $type_R[$relation_num] );
			$tab_ = $data_R_num[0]; // 0:Relatio Table
			$tab_R    = explode(":", $data_R_num[0] );
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];
		} else {
			$tab_ = ''; // 0:Relatio Table
			$tab_enmR = '';
			$tab_hnmR = '';
		}
		if( $relation_reset =='on'){ // reset후 테이블을 선택했을 경우 여기로 탄다. 
				$relation_move_data = '';
				$relation_data = '';

		} else { // reset이 아니면 여기를 탄다.
			for( $i=1; isset($data_R_num) && $i < count( $data_R_num); $i++ ) { //$data_R_num[0] i==0 -> relation table
				$re_data = $data_R_num[$i];
				$rrr = explode("|", $re_data);
				$pg_fld = explode(":", $rrr[0]); //$rrr[1] 연결 식 =, +, -, * 
				$re_fld = explode(":", $rrr[2]);
				
				$pg_rel[$i-1] = $pg_fld[1];
				$re_rel[$i-1] = $re_fld[1];
				$relation_move_data .= $pg_rel[$i-1]. $rrr[1] . $re_rel[$i-1]. ",";
				$relation_data = $relation_data . $data_R_num[$i] . '$';
			}
		}
	}
	function table_relation_save_func( $pg_code, $Rno ){
		global $tkher, $H_ID;
		//global $relation_data_old_0, $relation_data_old_1, $relation_data_old_2;
		//global $relation_key_old_0, $relation_key_old_1, $relation_key_old_2;
		//global $item_array_0, $item_array_1, $item_array_2;
		//global $Rtab_hnmS, $tab_enmR, $tab_hnmR;
		//$Rtab_hnmS = $_POST['Rtab_hnmS']
		$relation_data_old_0 = $_POST['relation_data_old_0'];
		$relation_data_old_1 = $_POST['relation_data_old_1'];
		$relation_data_old_2 = $_POST['relation_data_old_2'];
		$relation_key_old_0 = $_POST['relation_key_old_0'];
		$relation_key_old_1 = $_POST['relation_key_old_1'];
		$relation_key_old_2 = $_POST['relation_key_old_2'];
		$item_array_0 = $_POST['item_array_0'];
		$item_array_1 = $_POST['item_array_1'];
		$item_array_2 = $_POST['item_array_2'];

		$relation_data = $relation_data_old_0 . "^" . $relation_data_old_1. "^" . $relation_data_old_2;
		$relation_T = $relation_key_old_0 . "@" . $relation_key_old_1. "@" . $relation_key_old_2;
		$array_R = $item_array_0 . "^" . $item_array_1 . "^" . $item_array_2;
		$relation_type = $relation_T . "^" . $array_R;
		$query = "UPDATE {$tkher['table10_pg_table']} SET relation_type='$relation_type', relation_data='$relation_data' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_("Save, Complete the relationship. pg_code:".$pg_code);
		else m_("Program UPDATE error! ");
		//echo "<script>create_after_run( '$relation_pg_codeS' , '$Rtab_hnmS' );</script>"; 
	}
	function relation_all_delete( $pg_code ){ //dao_1644456532:거래처$fld_2:거래처|=|fld_1:거래처명$fld_6:외상매출액|=|fld_5:매출총액
		global $tkher, $H_ID;
		$query="UPDATE {$tkher['table10_pg_table']} SET relation_data='', relation_type='' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_(" Delete, Complete the relationship. pg_code:".$pg_code);
		else m_("Program Delete error! pg_code: $pg_code");
		$_SESSION['Rtab_hnmS'] ='';
		echo "<script>delete_after_run( '' , '$pg_code' );</script>"; 
	}
	function item_color( $relation_num ){
		global $type_R,	$rel_cA, $rel_cB;
		if( $type_R[$relation_num] != '' ){
			$rel_Qt   = explode(':' , $type_R[$relation_num] );
			$relation_Qtype = $rel_Qt[0]; // 'Insert' or 'Update'
			$relation_update_key = $rel_Qt[1];
		} else {
			$relation_Qtype = ''; // 'Insert' or 'Update'
			$relation_update_key = '';
		}
		if( $relation_Qtype == 'Insert') {
			$rel_cA = 'cyan';
			$rel_cB = 'white';
		} else if ( $relation_Qtype == 'Update'){
			$rel_cA = 'white';
			$rel_cB = 'cyan';
		}
	}
?>
</body>
</html>
