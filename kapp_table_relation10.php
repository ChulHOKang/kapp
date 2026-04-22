<?php
	include_once('./tkher_start_necessary.php');
	/*
	 *  kapp_table_relation10.php : kapp_table_relationA.php, table_relationA.php ,table_relationAM.php
			: Table Relation 정보저장.
			: A의 테이블에 데이터를 등록하면 X,Y,Z 3개의 테이블에도 데이터를 'Insert' 또는 'Update' 한다.
			: Update 에는 반드시 Key field를 설정해야 한다.
			: {$tkher['table10_pg_table']}
	 *  kapp_save_session.php
	    A테이블에 데이터를 등록하면 B테이블(Relation Table)에도 데이터를 등록한다.
		프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식
	 *  관계식에는 테이블이 처리될때마다 동일하게 처리되는 관계식과 프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식 두가지가 있다.
	 *  여기서는 후자에 속하는 프로그램별로 테이블의 등록,수정,삭제시에 대한 관계식을 적용한다.
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
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['relation_type_memo']) ) $relation_type_memo = $_POST['relation_type_memo'];
	else $relation_type_memo = '';
	if( $mode == 'table_relation_save' ) {
		$pg_code = $_POST['pg_code'];
		$relation_num = $_POST['relation_num'];
		$relation_num = 0;
		table_relation_save_func( $pg_code, $relation_num );
	}
	$data_R = array();
	$type_R = array();
	$R_count_max = 10;
	$R_count = 0;
	$pg_rel = array(); // program relation set column
	$re_rel = array(); // relation table   set column
	$data_R_num = array();
	$type_R_num = array(); // ^, [0] @, | 

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
	$relation_data_old_ = array();
	$relation_key_old_ =  array();
	$relation_num = 0;
	$relation_key_column ='';

	if( $mode == 'Delete_Check' ) {
		$pg_code = $_POST['pg_code'];
		relation_all_delete( $pg_code );
		$_POST['relation_project_nmS'] = '';
		$_POST['relation_pg_codeS'] = '';
		$_POST['Rtab_hnmS'] = '';
		$_POST['mode'] = '';
	} else {
		if( isset($_POST['mode']) ) $mode =$_POST['mode'];
		if( isset($_POST['relation_type_key']) ) $relation_type_key = $_POST['relation_type_key'];
		if( isset($_POST['relation_data_tab']) ) $relation_data_tab = $_POST['relation_data_tab'];
		
		if( isset($_POST['relation_key']) ) $relation_key = $_POST['relation_key'];
		if( isset($_POST['relation_reset']) ) $relation_reset = $_POST['relation_reset'];
		if( isset($_POST['item_array']) ) $item_array = $_POST['item_array'];
		if( isset($_POST['relation_num']) ) $relation_num = $_POST['relation_num'];

		if( isset($_POST['relation_key_old_']) ) $relation_key_old_ = $_POST['relation_key_old_'];
		if( isset($_POST['relation_data_old_']) ) $relation_data_old_ = $_POST['relation_data_old_'];
	}
	if( $mode=='Project_Search' ) {
		if( isset($_POST['relation_project_nmS']) && $_POST['relation_project_nmS'] !='' ){
			$relation_project_nmS = $_POST['relation_project_nmS'];
			$pcd_nm = explode(":", $relation_project_nmS );
			$project_code	= $pcd_nm[0];
			$project_name	= $pcd_nm[1]; 
		}
	} else if( isset($_POST['relation_project_nmS']) && $_POST['relation_project_nmS'] !='' ){
		$relation_project_nmS = $_POST['relation_project_nmS'];
		$pcd_nm = explode(":", $relation_project_nmS );
		$project_code	= $pcd_nm[0];
		$project_name	= $pcd_nm[1]; 
	}
	/* relation_pg_codeS ! 와 relation_data ^ 구분 자를 혼돈 하지 마라.
	relation_pg_codeS = pg_code:pg_name:tab_enm:tab_hnm:group_code:group_name!relation_data!relation_type!item_array
	relation_data=
	dao_1766735120:ABCYY$fld_1:fld1|=|fld_5:product:VARCHAR$fld_5:fld5|+|fld_6:total_count:INT$fld_6:fld6|+|fld_7:tottal_price:BIGINT$fld_7:날짜|=|fld_1:날짜:TIMESTAMP@@
	relation_type=Update:fld_1:fld_5:CHAR^^
	relation_data = dao_1766822184:ABC_AAA:|fld_1|fld1|VARCHAR|15@|fld_2|fld2|VARCHAR|15@|fld_3|fld3|VARCHAR|15@|fld_4|fld4|INT|12@|fld_5|fld5|INT|12@|fld_6|fld6|INT|12@$fld_1:fld1|=|fld_1:fld1:VARCHAR$fld_7:날짜|=|fld_7:날짜:TIMESTAMP$fld_5:fld5|+|fld_5:fld5:INT$fld_6:fld6|+|fld_6:fld6:INT^dao_1766735120:ABCYY:|fld_1|날짜|TIMESTAMP|20@|fld_2|yyyy|CHAR|4@|fld_3|mm|CHAR|2@|fld_4|dd|CHAR|2@|fld_5|product|VARCHAR|15@|fld_6|total_count|INT|12@|fld_7|tottal_price|BIGINT|15@$fld_1:fld1|=|fld_5:product:VARCHAR$fld_7:날짜|=|fld_1:날짜:TIMESTAMP$fld_5:fld5|+|fld_6:total_count:INT$fld_5:fld5|+|fld_7:tottal_price:BIGINT^
	*/
	if( $mode=='pg_codeS_Search' ) {
		if( isset($_POST['relation_pg_codeS']) && $_POST['relation_pg_codeS']!='' ){
			$relation_pg_codeS =$_POST['relation_pg_codeS'];
			$pg_A = explode("!", $relation_pg_codeS);
			$PGrelation_data   = $pg_A[1];
			$relation_data_tab = $pg_A[1];
			$PGrelation_type   = $pg_A[2];
			$relation_type_key = $pg_A[2];
			$pg_ = explode(":", $pg_A[0]);
			$pg_code = $pg_[0];
			$pg_name = $pg_[1];
			$tab_enm = $pg_[2];
			$tab_hnm = $pg_[3];
			if( isset($pg_A[1]) && $pg_A[1]!='' ){
				$data_R = explode("^", $pg_A[1]); //$relation_dataA = explode("^", $pg_A[1]);
				$relation_dataT = explode("$", $data_R[0]);
				if( $relation_dataT[0] !=''){
					$relation_TAB = explode(":", $relation_dataT[0]);
					$tab_enmR = $relation_TAB[0];
					$tab_hnmR = $relation_TAB[1];
					$Rtab_hnmS = $tab_enmR . ":" . $tab_hnmR;
				}
			}
		}
	} else if( $mode!='Project_Search' && isset($_POST['relation_pg_codeS']) && $_POST['relation_pg_codeS'] !='' ){
		$relation_pg_codeS =$_POST['relation_pg_codeS'];
		/*
		value="<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>!<?=$rs['relation_data']?>!<?=$rs['relation_type']?>!<?=$rs['item_array']?>"
		*/
		$pg_A = explode("!", $relation_pg_codeS);
		$PGrelation_data   = $pg_A[1];
		$relation_data_tab = $pg_A[1];
		$PGrelation_type   = $pg_A[2];
		$relation_type_key = $pg_A[2];
		$pg_ = explode(":", $pg_A[0]);
		$pg_code = $pg_[0];
		$pg_name = $pg_[1];
		$tab_enm = $pg_[2];
		$tab_hnm = $pg_[3];
		if( isset( $pg_A[1]) && $pg_A[1]!='' ){
			$data_R = explode("^", $pg_A[1]); //$relation_dataA = explode("^", $pg_A[1]);
			$relation_dataT = explode("$", $data_R[0]);
			if( $relation_dataT[0] !=''){
				$relation_TAB = explode(":", $relation_dataT[0]);
				$tab_enmR = $relation_TAB[0];
				$tab_hnmR = $relation_TAB[1];
				$Rtab_hnmS = $tab_enmR . ":" . $tab_hnmR;
			}
		}
	}
	if( $mode !='Project_Search' && $mode !='Relation_SearchTAB' && isset($_POST['relation_pg_codeS']) ) {
		$relation_type_memo = Fetch_pg_code($pg_code, $pg_name);
	}
	if( $mode=='Relation_SearchTAB' ) {
		if( isset($_POST['Rtab_hnmS']) && $_POST['Rtab_hnmS'] !='' ){
			$Rtab_hnmS =$_POST['Rtab_hnmS'];
			$relation_TAB = explode(":", $Rtab_hnmS); //dao_1766735120:ABCYY
			$tab_enmR = $relation_TAB[0];
			$tab_hnmR = $relation_TAB[1];
		}
	}
	//m_("relation_type_key: " . $relation_type_key);
	//relation_type_key: Insert:fld_1:상품:VARCHAR|:fld_7:날짜:DATE|@Update:fld_1:날짜:DATE|:fld_5:product:VARCHAR|@Update:fld_1:년도:YEAR|:fld_2:상품:VARCHAR|^|fld_1|상품|VARCHAR|15@|fld_2|원산지|VARCHAR|15@|fld_3|단위|VARCHAR|15@|fld_4|수량|INT|12@|fld_5|단가|INT|12@|fld_6|금액|INT|12@|fld_7|날짜|DATE|15@^Update:fld_1:년도:YEAR|:fld_2:상품:VARCHAR|^
	
	if( $relation_type_key !=''){
		$typeAR  = explode("^", $relation_type_key); 
		$type_R  = explode("@", $typeAR[0]);
		$R_count = count( $type_R );
		if( isset($type_R[$relation_num]) && $type_R[$relation_num]!=''){
			$relation_key_column = $type_R[$relation_num];
			$typeR_ = $type_R[$relation_num];
			$type_R_ = explode("|", $typeR_ );
			$relation_key_count = count( $type_R_);
			$type_R_num = explode(":", $type_R_[0] ); 
			if( $type_R_num[0]=='Insert' ) {
				$rel_cA = 'cyan';
				$rel_cB = 'white';
				$sql_iT = ' checked ';
			} else if( $type_R_num[0]=='Update' ) {
				$rel_cA = 'white';
				$rel_cB = 'cyan';
				$sql_uT = ' checked ';
			} else {
				$rel_cA = 'white';
				$rel_cB = 'white';
				$sql_iT = '';
				$sql_uT = '';
			}
		}
	}
?>
<center>
   <table width='300' cellspacing='0' cellpadding='4' border='1' class="c1">
		<FORM name='kapp_Relation_Form' METHOD='POST' enctype="multipart/form-data">
			<input type="hidden" name="mode" id="mode" value="<?=$mode?>" >
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

		  <tr>
			<td align="center" <?php echo" title='\n(work order)\n1:Select project \n2:Select program \n3:Select Relation Number \n4:Select relation table \n5:Select program table column and relation table column \n6:Relationship select and Apply button \n7:Select Relation SQL Type \n8:Select key column \n9:Save Submit button' "; ?> style="border-style:;background-color:#666666;color:cyan;width:160px; height:33px;font-size:15;">
			Relational settings(<?=$H_ID?>)
			<br>Project:<?=$project_name?>
		<SELECT id='relation_project_nmS' name='relation_project_nmS' onchange="change_project_func(this.value);" style="background-color:#666666;color:yellow;width:50%;height:30px;">
<?php 
		echo "<option value=''>1.Select Project</option>";
		if( isset( $_POST['relation_project_nmS']) ) echo "<option value='$relation_project_nmS' selected title='".$_POST['relation_project_nmS']."'>$project_name</option>";
		$result= sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by upday desc " ); 
		while( $rs = sql_fetch_array($result)) {
?>
			<option value='<?=$rs['group_code']?>:<?=$rs['group_name']?>' <?php if( $project_code==$rs['group_code']) echo ' selected '; ?> title="<?=$rs['group_code']?>:<?=$rs['group_name']?>"><?=$rs['group_name']?></option>
<?php	} ?>
		</SELECT>
		<br>Program:<?=$pg_name?>
		<SELECT id='relation_pg_codeS' name='relation_pg_codeS' onchange="change_program_func(this.value);" style="background-color:#666666;color:yellow;width:45%; height:30px;" >
<?php
		echo "<option value=''>2.Select program</option>";
		if( isset( $_POST['relation_pg_codeS']) && $_POST['relation_pg_codeS']!='' ) echo "<option value='".$relation_pg_codeS."' selected>".$pg_name."</option>";
		$result= sql_query( "SELECT * from {$tkher['table10_pg_table']} where group_code='$project_code' and userid='$H_ID' order by seqno desc " );
		while( $rs = sql_fetch_array($result)) {
			$chk = '';
			if( $pg_code==$rs['pg_code']) $chk= 'selected';
?>
			<option value="<?=$rs['pg_code']?>:<?=$rs['pg_name']?>:<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>!<?=$rs['relation_data']?>!<?=$rs['relation_type']?>!<?=$rs['item_array']?>" <?php echo $chk;?> ><?=$rs['pg_name']?></option>
<?php   } ?>
		</SELECT>
		<br>Relation Number:<SELECT id='relation_num' name='relation_num' onchange="change_relation_num_func(this.value);" style="border-style:;background-color:#666666;color:yellow; height:30px;font-size:15;" >
				<option value=''>Select relation number</option>
<?php
				$num_sel='';
				for( $i=0,$j=1; $i < $R_count_max; $i++, $j++){
					if( $i == $relation_num) $num_sel='selected';
					else $num_sel='';
					if( isset($data_R[$i]) && $data_R[$i]!=''){
						$T1 = explode(":",$data_R[$i]);
						echo "<option value='$i' $num_sel >".$T1[1]." : Relation $j</option>";
					} else echo "<option value='$i' $num_sel >New Relation $j</option>";
				}
?>
		</SELECT>
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
	<div id="here_pgcolumn" style="font-size:18px;">
<?php
	$sel_color  = 'white';
	if( $mode !='Project_Search' ) pg_tab_disp( $item_array );
?>
	</div>
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
		if( $mode=='Relation_SearchTAB' || isset($_POST['Rtab_hnmS']) ) {
			$tab_R = explode(":", $Rtab_hnmS);
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];
		}
		echo "<option value=''>Select Relation Table</option>";
		if( $mode !='Delete_Check' && $mode!='pg_codeS_Search' && $mode=='Relation_SearchTAB' || isset($_POST['Rtab_hnmS']) )
			echo "<option value='".$Rtab_hnmS."' selected >".$tab_hnmR."</option>";
		$result = sql_query( "SELECT * from {$tkher['table10_table']} where group_code='$project_code' and userid='$H_ID' and fld_enm='seqno' " );//관계용테이블선택.
		while( $rs = sql_fetch_array($result)) {
			$chk='';
			if( $tab_enmR==$rs['tab_enm']) $chk= 'selected';
?>
			<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['memo']?>" title='tab_enm:<?=$rs['tab_enm']?>, tab_hnm:<?=$rs['tab_hnm']?>, memo:<?=$rs['memo']?>' <?php echo $chk;?> ><?=$rs['tab_hnm']?></option>
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
	if( isset($type_R_num[0]) ) $type_0 = $type_R_num[0];
	else $type_0 ='';
	if( $mode !='Project_Search' && $mode !='Delete_Check' ){
		if( $tab_enmR !='' ) {
			$Rtab_col = Relation_Table_Display( $tab_enmR );
		}
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
					  <tr><!-- SQL Key Type - Insert or Update. -->
						<td title='SQL Type distinguishes whether to change or register.'>
<input width='' id='relation_move_data' name='relation_move_data' maxlength='250' value='<?=$relation_move_data?>' style="border-style:;background-color:#666666;color:yellow;width:600px;height:33px;font-size:12;" readonly title='relation_move_data:<?=$relation_move_data?>'>
<br>Relation SQL Type:
<?php echo "<label id='type_SQL[0]' style='background-color:$rel_cA;' title='Insert does not require a key column.'>"; ?>
 <input type='radio' onclick='relation_sql_type(<?=$relation_num?>,this.value)' id='relation_type_SQL[0]' name='relation_type_SQL' value='Insert' <?php if( isset($type_R_num[0]) && $type_0 =='Insert') echo $sql_iT; ?> >Insert</label>
<?php echo "<label id='type_SQL[1]' style='background-color:$rel_cB;' title='Update must set the key column.' >"; ?>
 <input type='radio' onclick='relation_sql_type(<?=$relation_num?>,this.value)' id='relation_type_SQL[1]' name='relation_type_SQL' value='Update' <?php if( isset($type_R_num[0]) && $type_0 =='Update') echo $sql_uT; ?> >Update</label>
						
<?php
 echo "<br>Key Column:<input id='relation_key_column' name='relation_key_column' type='text' style='width:500px;' value='$relation_key_column' readonly>";
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
				<textarea id='relation_key_old_[$i]' name='relation_key_old_[$i]' style='display:none;' title='type key - i:$i'>$relation_key_old_A</textarea>
				<textarea id='relation_data_old_[$i]' name='relation_data_old_[$i]' style='display:none;' title='data - i:$i'>$relation_data_old_A</textarea>
			";
		}
	}
?>
	<input type='hidden' id='R_count_max' name='R_count_max' value='<?=$R_count_max?>'>
	<input type='hidden' id='nmxh' name='nmxh' maxlength='250' size='30'  value=''>
		  </tr>
		<tr>
		  <td align="center" >
		<input type='button' value=' Save Submit ' id='all_save_button' onclick='relation_save_ALL_func(<?=$relation_num?>)' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>&nbsp;&nbsp;&nbsp;
		<input type='button' value=' ReSet ' id='all_reset_button' onclick='reset_confirm()' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;' title='Re-establish the relationship corresponding to the relation number'>&nbsp;&nbsp;&nbsp;
		<input type='button' value=' Delete All ' id='all_delete_button' onclick='delete_confirm()' style='background-color:cyan;color:black; height:30px;font-size:15; border-radius:20px;border:1 solid white;'>
			</td>
		</tr>
		</FORM>
	</table>
<?php
	function Fetch_pg_code($pg_code, $pg_name){
		global $relation_reset, $relation_num, $item_array, $tab_enm, $tab_hnm;
		global $relation_data_tab, $relation_type_key, $relation_key, $relation_data;
		global $relation_move_data;
		global $relation_data_old_, $relation_key_old_;
		global $data_R, $type_R;
		global $tab_enmR, $tab_hnmR;
		global $rel_cA, $rel_cB;
		global $type_R_num, $data_R_num, $pg_rel, $re_rel; //$type_R_num = explode(":", $type_R_[0] );
		global $tkher;
			$relation_move_data = '';
			$relation_data = '';
			$relation_data_tab = '';
			$relation_type_key = '';
			$relation_key = '';

		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='".$pg_code."' ";
		$resultPG= sql_query($sqlPG);
		if( sql_num_rows($resultPG) > 0 ) {
			$rsPG = sql_fetch_array( $resultPG);
			$item_array	= $rsPG['item_array'];
			$tab_enm	= $rsPG['tab_enm'];
			$tab_hnm	= $rsPG['tab_hnm'];
			$relation_type_memo	= $rsPG['relation_type_memo'];

			if( $rsPG['relation_data'] !='' ) {
				$relation_type_key = $rsPG['relation_type'];
				$relation_data_tab = $rsPG['relation_data'];
				Data_Classification( $rsPG['relation_data'], $rsPG['relation_type'] );
			}
		}
		return $relation_type_memo;
	}
/*
Insert:fld_1:상품:VARCHAR|:fld_7:날짜:DATE|
@Update:fld_1:날짜:DATE|:fld_5:product:VARCHAR|
@Update:fld_1:년도:YEAR|:fld_2:상품:VARCHAR|
^|fld_1|상품|VARCHAR|15@|fld_2|원산지|VARCHAR|15@|fld_3|단위|VARCHAR|15@|fld_4|수량|INT|12@|fld_5|단가|INT|12@|fld_6|금액|INT|12@|fld_7|날짜|DATE|15@
^Update:fld_1:년도:YEAR|:fld_2:상품:VARCHAR|^	

Update:fld_1:년도:YEAR:4|:fld_2:부품:VARCHAR:15|
@Update:fld_1:일자:DATE:10|:fld_2:상품:VARCHAR:15|
@Update:fld_1:거래처:VARCHAR:15|:fld_2:상품:VARCHAR:15|
^Update:fld_1:일자:DATE:10|:fld_2:상품:VARCHAR:15|
^Update:fld_1:거래처:VARCHAR|:fld_2:상품:VARCHAR|
^|fld_1|거래처|VARCHAR|15@|fld_2|상품|VARCHAR|15@|fld_3|수량|INT|12@|fld_4|금액|INT|12@
*/
	function Data_Classification( $PGrelation_data, $PGrelation_key){
		global $relation_num, $relation_move_data, $relation_reset;
		global $data_R, $type_R, $R_count, $relation_data, $relation_key;
		global $tab_enmR, $tab_hnmR, $Rtab_hnmS;
		global $rel_cA, $rel_cB;
		global $type_R_num, $data_R_num, $pg_rel, $re_rel; //$type_R_num = explode(":", $type_R_[0] );
		global $relation_key_old_, $relation_data_old_;

		$data_R    = explode("^", $PGrelation_data );
		$type_AR   = explode("^", $PGrelation_key ); 
		$type_R    = explode("@", $type_AR[0] );
		$R_count = count( $data_R );

				$relation_data     = $data_R[$relation_num]; //now
				$relation_key      = $type_R[$relation_num]; //now
		for( $i=0, $j=1; $i < $R_count; $i++, $j++){
			if( isset( $data_R[$i] ) && $data_R[$i]!=''){
				$relation_data_old_[$i] = $data_R[$i];
				$relation_key_old_[$i]  = $type_R[$i];
			} else {
				$relation_data_old_[$i] = '';
				$relation_key_old_[$i]  = '';
			}
		}
		if( isset( $data_R[$relation_num]) && $data_R[$relation_num] !='' && isset($type_R[$relation_num]) && $type_R[$relation_num] !='' ){
			$data_R_num = explode("$", $data_R[$relation_num] );
			$typeR_ = $type_R[$relation_num];
			$type_R_ = explode("|", $typeR_ );
			$relation_key_count = count( $type_R_);
			$type_R_num = explode(":", $type_R_[0]); 			//$tab_ = $data_R_num[0];
			$tab_R    = explode(":", $data_R_num[0] );
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];
			$Rtab_hnmS = $tab_enmR . ":" . $tab_hnmR;
		} else {
			//$tab_ = '';
			$tab_enmR = '';
			$tab_hnmR = '';
			$Rtab_hnmS = $tab_enmR . ":" . $tab_hnmR;
		}
		if( $relation_reset =='on'){
				$relation_move_data = '';
		} else {
			for( $i=1; isset($data_R_num) && $i < count( $data_R_num); $i++ ) { //$data_R_num[0] i==0 -> relation table
				$re_data = $data_R_num[$i];
				$rrr = explode("|", $re_data);
				$pg_fld = explode(":", $rrr[0]);
				$re_fld = explode(":", $rrr[2]);
				$pg_rel[$i-1] = $pg_fld[1];
				$re_rel[$i-1] = $re_fld[1];
				$relation_move_data .= $pg_rel[$i-1]. $rrr[1] . $re_rel[$i-1]. ",";
			}
		}
	}
	function pg_tab_disp( $item_array ){
		global $type_R_num, $pg_rel;
		global $mode;
		$pg_col_chk=0;
		$ck = '';
		if( isset( $item_array ) && $item_array !='' ){
			$col_ = explode( "@", $item_array );
			for( $i=0; $i < count($col_)-1; $i++) {
				$_col = explode("|", $col_[$i]);
				$ck = '';
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
		global $relation_num, $type_R;
		$Rtab_col ='';
		$sql = "SELECT * from {$tkher['table10_table']} where userid='$H_ID' and tab_enm='$tab_enmR' order by disno asc";
		$result = sql_query($sql);
		if(isset($type_R[$relation_num]) && $type_R[$relation_num]!=''){
			$typeR_ = $type_R[$relation_num];
			$type_R_ = explode("|", $typeR_ );
			$relation_key_count = count( $type_R_);
		} else $relation_key_count =0;
		while( $rsP = sql_fetch_array($result)) {
			if( $rsP['fld_enm'] =='seqno' )	{
				continue;
			}
			$ck = ''; 
			$pg_col_chk=0;
			$sel_color='white';
			for( $j=0; $j < count( $re_rel); $j++ ){
				if( isset($re_rel[$j]) && $re_rel[$j] == $rsP['fld_hnm'] ) {
					$pg_col_chk=1;
					$sel_color ='cyan';
				} 
				for( $i=0; isset( $type_R_[$i]) && $type_R_[$i]!='' && $i<$relation_key_count; $i++){
					$type_R_num = explode(":", $type_R_[$i] );
					if( isset( $type_R_num[1]) && $type_R_num[1] == $rsP['fld_enm'] ) {
						$ck = ' checked';
						$sel_color='blue';
						break;
					}
				}
			}
			echo "<label style='background-color:".$sel_color.";' title=".$rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type'].":".$rsP['fld_len']."><input type='radio' id='re_tab_column' name='re_tab_column' value='".$rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type'].":".$rsP['fld_len']."' ".$ck.">".$rsP['fld_hnm']."</label><br>";
			$Rtab_col=$Rtab_col . $rsP['fld_enm'].":".$rsP['fld_hnm'].":".$rsP['fld_type'].":".$rsP['fld_len']."|";
		}//while
		return $Rtab_col;
	}
	function relation_array( $relation_num ){
		global $data_R, $type_R, $tab_enmR, $tab_hnmR;
		global $relation_move_data, $relation_data;
		global $pg_rel, $re_rel;
		if( isset($data_R[$relation_num]) && $data_R[$relation_num] !='' && isset($type_R[$relation_num]) && $type_R[$relation_num] !='' ){
			$data_R_num = explode("$", $data_R[$relation_num] );
			$type_R_num = explode(":", $type_R[$relation_num] );
			$tab_ = $data_R_num[0];
			$tab_R    = explode(":", $data_R_num[0] );
			$tab_enmR = $tab_R[0];
			$tab_hnmR = $tab_R[1];
		} else {
			$tab_ = ''; 
			$tab_enmR = '';
			$tab_hnmR = '';
		}
		if( $relation_reset =='on'){
				$relation_move_data = '';
				$relation_data = '';
		} else { // reset이 아니면 
			for( $i=1; isset($data_R_num) && $i < count( $data_R_num); $i++ ) {
				$re_data = $data_R_num[$i];
				$rrr = explode("|", $re_data);
				$pg_fld = explode(":", $rrr[0]);
				$re_fld = explode(":", $rrr[2]);
				$pg_rel[$i-1] = $pg_fld[1];
				$re_rel[$i-1] = $re_fld[1];
				$relation_move_data .= $pg_rel[$i-1]. $rrr[1] . $re_rel[$i-1]. ",";
				$relation_data = $relation_data . $data_R_num[$i] . '$';
			}
		}
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
		$relation_type_memo = $relation_type_memo . " , " . date('Y-m-d:H:i:s') . ":" . $H_ID.":" . $relation_type;
		$query = "UPDATE {$tkher['table10_pg_table']} SET relation_type='$relation_type', relation_data='$relation_data', relation_type_memo='$relation_type_memo' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_("Save, Complete the relationship. pg_code:".$pg_code);
		else m_("Program UPDATE error! ");
	}
	function relation_all_delete( $pg_code ){
		global $tkher, $H_ID;
		$query="UPDATE {$tkher['table10_pg_table']} SET relation_data='', relation_type='' WHERE userid='$H_ID' and pg_code='$pg_code' ";
		$ret = sql_query($query);
		if( $ret ) m_(" Delete, Complete the relationship. pg_code:".$pg_code);
		else m_("Program Delete error! pg_code: $pg_code");
		$_POST['Rtab_hnmS'] ='';
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
