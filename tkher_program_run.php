<?php
	include_once('./tkher_start_necessary.php');
	/* ----------------------------------------------------------------------------------------------------------------------------
    tkher_program_run.php?pg_code=dao_1693896214		: data insert system program , call : table10i.php, app_pg50RC.php 에서 call
    tkher_program_data_update.php						: data update system program
	tkher_program_data_view.php							: data view   system program
	tkher_program_data_list.php?pg_code=dao_1540779796  : data list   system program , popup , calc
	** 프로그램:table_item_run70.php : 프로그램 속성을 저장한 table10_pg 테이블을 생성한다.
	** table_pg70_write.php와 다른점 : item_array를 table10_pg테이블을 사용한다. 
		: tab_list_pg70.php에서콜. 
		: table10_pg_create, table_relation_pglist.php, table_search_list.php 에서도 콜.
		javascript:submit_run2( '/t/tkher_program_data_list.php?pg_code=dao_1535240830', 'dao_1535240830', 'my_solpa_user_r');
		http://tkher.com/test/css_pg_run.php?pg_code=dao_1540779796
		http://tkher.com/test/css_pg_run.php?pg_code=dao_1537158930 : 각종 입력 필드 타입 . pg_505.

	Data 등록 프로그램 - 같은 프로그램.
	tkher_program_run.php
	table_item_run50.php
	table_pg70_write.php
	//--- Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36, KAPP_MOBILE_AGENT: phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|android|sony
	----------------------------------------------------------------- */
	$ip = $_SERVER['REMOTE_ADDR'];

	$H_ID= get_session("ss_mb_id");
	if( isset($H_ID) && $H_ID !='' ) {
		$H_POINT	= $member['mb_point'];
		$H_LEV=$member['mb_level'];
	} else {
		m_("You need to login. ");
		echo "<meta http-equiv='refresh' content=0;url='tkher_program_data_list.php?pg_code=".$_REQUEST['pg_code']."'>";exit;
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

<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/kapp_basic.css" type="text/css" />

<?php
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else $page = 1;
	if( isset($_POST['line_cnt']) ) $line_cnt = $_POST['line_cnt'];
	else if( isset($_REQUEST['line_cnt']) ) $line_cnt = $_REQUEST['line_cnt'];
	else $line_cnt = 1;
	if( isset($_POST['pg_code']) ) $pg_code = $_POST['pg_code'];
	else if( isset($_REQUEST['pg_code']) ) $pg_code = $_REQUEST['pg_code'];
	else $pg_code = '';
	if( !$pg_code  || $pg_code =='') {
			m_(" Abnormal approach. $mode, $pg_code "); exit;
	}
	$in_day = date("Y-m-d H:i");
	$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$rsPG = sql_fetch($sqlPG);
	if( !$rsPG['pg_code']  ) {
			m_(" Abnormal approach. program no found! : $pg_code"); exit();
	}
	$pg_mid	= $rsPG['userid'];
	$tab_mid	= $rsPG['tab_mid'];
	$grant_write = $rsPG['grant_write'];
	if( $H_LEV >=$grant_write || $pg_mid == $H_ID ) {
	} else{
		$write_msg ='You do not have permission. Your permission level is higher than that of the creator. grant_write:'.$grant_write;
		m_( $write_msg );//  권한이 없습니다. 권한은 생성자 이상의 레벨입니다.
		echo "<script>window.open('tkher_program_data_list.php?pg_code=$pg_code','_self','')</script>";
		exit;
	}
	$pg_name	= $rsPG['pg_name'];
	$tab_enm	= $rsPG['tab_enm'];
	$tab_hnm	= $rsPG['tab_hnm'];
	$group_code	= $rsPG['group_code'];
	$group_name	= $rsPG['group_name'];
	$item_cnt	= $rsPG['item_cnt'];
	$if_typePG	= $rsPG['if_type'];
	$if_dataPG	= $rsPG['if_data']; 
	$pop_dataPG	= $rsPG['pop_data'];
	$relation_dataPG = $rsPG['relation_data'];
	$relation_typePG = $rsPG['relation_type'];

	$_SESSION['iftype_db']		= $if_typePG;
	$_SESSION['ifdata_db']		= $if_dataPG;
	$_SESSION['if_dataPG']		= $if_dataPG;	
	$_SESSION['pop_dataPG']		= $pop_dataPG;
	$_SESSION['relation_dataPG']	= $relation_dataPG;
	$_SESSION['relation_typePG']	= $relation_typePG;
	$_SESSION['pg_name']			= $pg_name;
	$_SESSION['pg_code']			= $pg_code;
	$cur='B';
	include_once "./menu_run.php"; 
?>
	<div>
		<P onclick="javascript:home_func('<?=$pg_code?>')" class="HeadTitle02AX" title='pg:<?=$pg_code?>, tab:<?=$tab_enm?> '><?=$pg_name?></P>
	</div>

	<div class="boardViewX">
		<div class="viewHeader">
			<span title='pg:tkher_program_run'><?=$in_day?></span>
		</div>
		<div class="viewSubjX"><span title='(<?=$pg_code?>:<?=$tab_hnm?>)'><?=$pg_name?></span> </div>
		<div class='blankA'> </div>
		<form name="makeform" method = "post" action="" enctype="multipart/form-data">
			<input type="hidden" name='page'		value="<?=$page?>" />
			<input type="hidden" name='line_cnt'	value="<?=$line_cnt?>" />
<?php
		$kkk="off";
		$list = array();
		$kkk0 = array();
		$kkk1 = array();
		$kkk2 = array();
		$kkk3 = array();
		$kkk5 = 1;  //func seq number
		$ddd = "";

		$iftypeX = "";
		$ifdataX = "";
		$item_array = "";
		$item_array = $rsPG['item_array'];
		$iftypeX	= $rsPG['if_type'];
		$ifdataX	= $rsPG['if_data'];
		$iftype		= explode("|", $iftypeX);
		$ifdata		= explode("|", $ifdataX);
		$popdata	= explode("^", $pop_dataPG);
		if( isset($item_array) ) $list = explode("@", $item_array);
		else  $list = '';
		for( $i=0,$j=1; isset($list[$i]) && $list[$i] != ""; $i++, $j++ ){
				$ddd  = $list[$i];
				if( isset($iftype[$j]) && $iftype[$j]!='' ) $typeX	= $iftype[$j];
				else $typeX	= '';
				if( isset($ifdata[$j]) && $ifdata[$j]!='' ) $dataX	= $ifdata[$j];
				else $dataX	= '';
				if( isset($popdata[$j]) ) $popX	= $popdata[$j];
				else $popX	= '';
				if( isset($dataX) && $dataX!='' ) $if_fld = explode(":", $dataX);
				else $if_fld = '';
				if( isset($ddd) ) $fld = explode("|", $ddd);
				else $fld="";
			if( $fld[1] != "seqno") { 
				$fld_enm= $fld[1];
				$fld_enmX= $fld[1];
				if( $fld[3] == "TEXT" ) {
					echo " <div class='menu1Area' ><p>$fld[2]</p><textarea name='$fld[1]' placeholder='Please enter your $fld[2]!' style='width:$Xwidth;height:$Text_height;'></textarea></div>";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "TIME" ) {
							$tday=date("H:i:s");
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type='$fld[3]' name='$fld[1]' value='$tday' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "DATE" ) { 
							$day=date("Y-m-d");
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type='$fld[3]' name='$fld[1]' value='$day' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "DATETIME" || $fld[3] == "TIMESTAMP" ) { 
							$day=date("Y-m-d H:i");
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type='$fld[3]' name='$fld[1]' value='$day' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "BIGINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ) { 

						if( $typeX == "1" ) { // radio button
								echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
								echo " <div class='radio1A'><span>";
							for ( $k=0; isset( $if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
								echo	"<input type='radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' class='input1A'>" . $if_fld[$k] . " &nbsp;";
							}
								echo " </span></div> ";
								echo " <div class='blankA'> </div> ";
						} else if( $typeX == "3" ) { //check box
								echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
								echo " <div class='radio1A'><span>";
							for ( $k=0; isset( $if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
									echo	"<input type='Checkbox' name='" . $fld[1] .  "[]'  value='" . $if_fld[$k] . "' >" . $if_fld[$k] . " &nbsp;";
							}
								echo " </span></div> ";
								echo " <div class='blankA'> </div> ";
						
						} else if( $typeX == "5" ) { // list box
								echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
								echo " <div class='ListBox1A'>";
								echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;'>";
							for ( $k=0; isset( $if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
								echo "<OPTION SELECTED>$if_fld[$k]</OPTION>";
							}
								echo "</SELECT>";
								echo " </div> ";
								echo " <div class='blankA'> </div> ";
						} else if( $typeX == "11" ) { // calc
							$kkk=$fld[1];
							$idata=explode(":", $dataX);
							$datax = $idata[1];
							$datay = $idata[0];
							$ff = explode(" ", $datay);	 //datay:fld_4 = fld_2 * fld_3, ff:fld_4 = fld_2 * fld_3 
							$f0 = $ff[0];
							$f1 = $ff[1];
							$f2 = $ff[2];
							$f3 = $ff[3];
							$f4 = $ff[4];
							$kkk0[$kkk5] = "document.makeform." . $f0 . ".value";
							$kkk1[$kkk5] = "document.makeform." . $f2 . ".value";
							
							if( is_numeric($f4) ) $kkk2[$kkk5] = $f4;
							else $kkk2[$kkk5] = "document.makeform." . $f4 . ".value";
							
							$kkk3[$kkk5] = $f3;
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							//echo " <div class='menu1A'><span><input type=number name='$fld[1]' onClick='$fld[1]FUNC$kkk5()' title='$fld[1]XY()' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></span></div> ";
							echo " <div class='menu1A'><span><input type=number name='$fld[1]' onClick='FUNC_$kkk5()' title='FUNC_$kkk5()' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></span></div> ";
							echo " <div class='blankA'> </div> ";
							$kkk5++; // = $func_cnt;
						} else {
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type='number' name='$fld[1]' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].' class=autom_subj></div> ";
							echo " <div class='blankA'> </div> ";
						}
				} else {
						
						if( $typeX == "1" ) { // radio button
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
							for ( $k=0; isset( $if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
								echo	"<input type='radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' class='input1A'>" . $if_fld[$k] . " &nbsp;";
							}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "3" ) { //check box
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
							for ( $k=0; isset( $if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
									echo	"<input type='Checkbox' name='" . $fld[1] .  "[]'  value='" . $if_fld[$k] . "' >" . $if_fld[$k] . " &nbsp;";
							}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "5" ) { // list box
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='ListBox1A'>";
							echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;'>";
							for ( $k=0; isset( $if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
								echo "<OPTION SELECTED>$if_fld[$k]</OPTION>";
							}
							echo "</SELECT>";
							echo " </div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "7" ) { //password
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=PASSWORD name='$fld[1]' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "9" ) { // add file 
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='File1A'>";
							echo " <input type='FILE' name='$fld[1]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'> ";
							echo " </div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "13" ) { // popup window
							$_SESSION['fld_session']=$i;
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=text name='$fld_enmX' onclick=\"javascript:popup_call('$if_dataPG', '$popX', '$i')\" style='width:$Xwidth;height:$Xheight;' placeholder='PopUp Window. Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
						} else {
							echo " <div class='menu1T' ><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=text name='$fld[1]' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
						}
				} //if( $fld[3] == "TEXT" ) {
			} else {	//if( $fld[1] != "seqno")
					m_("seqno ========== ");
			}
		}//for
?>
		<input type='text' name='iftype' value='<?=$iftypeX?>' style="display:none;">
		<input type='text' name='ifdata' value='<?=$ifdataX?>' style="display:none;">
		<input type='hidden' name='mode'			value=''>
		<input type='hidden' name='pg_name'		value='<?=$pg_name?>'>
		<input type='hidden' name='pg_code'		value='<?=$pg_code?>'>
		<input type="hidden" name="tab_enm"		value="<?=$tab_enm?>">
		<input type="hidden" name="tab_hnm"		value="<?=$tab_hnm?>">
		<input type="hidden" name="item_array"	value="<?=$item_array?>">
		<input type="hidden" name="item_cnt"		value="<?=$item_cnt?>">
		<input type='hidden' name='pop_data'		value='<?=$pop_dataPG?>'>
		<input type='hidden' name='relation_data'	value='<?=$relation_dataPG?>'>
		<input type='hidden' name='column_cnt'	value=''>
		<input type='hidden' name='H_ID'	value='<?=$H_ID?>'>
		<input type='hidden' name='pg_mid'	value='<?=$pg_mid?>'>
		<input type='hidden' name='tab_mid'	value='<?=$tab_mid?>'>
		<input type="hidden" name='grant_write'		value='<?=$grant_write?>' />
		<input type="button" value="Submit" onclick="program_run_pg( '<?=$i?>','<?=$iftypeX?>')" class='kapp_btn_bo02'>
		<input type="reset" value="reset" class='kapp_btn_bo02'>
		<input type='button' value='Source Down' onclick="javascript:tkher_source_create('<?=$H_POINT?>')" class="kapp_btn_bo02" 
		title='Program source creation and Download the data registration program source. You need to download the table before you can run the program. Database creation is also included there. To download a table, click Program Creation Menu->Table Search->Table Name and click the Source Download button.' title='point:<?=$H_POINT?>'>
<?php
		echo "<input type='button' value='Excel_Upload' onclick=\"excel_upload_func('".$tab_enm."','".$tab_hnm."')\" class='kapp_btn_bo02' title='Batch upload of data to excel file'>"
?>
		<input type='button' value='List' onclick="javascript:table_data_list('<?=$pg_code?>');" class="kapp_btn_bo02">
</form>
<br>
<p>To download and run the program, you must also download the table creation source code.  To download a table, click Program Creation Menu->Table Search->Table Name and click the Source Download button.</p>

<script language="JavaScript"> 
<!--
	function home_func(pg_code){
		document.makeform.mode='home_func';
		document.makeform.action='tkher_program_data_list.php?pg_code='+pg_code;
		document.makeform.submit();
	}
	function tkher_source_create($coin){
		if( !document.makeform.H_ID.value ) {
			alert('Login Please!'); return false;
		}
		if( $coin < 1000 ) {
			alert('AppGenerator Point is low. You must do activities to accumulate points. point:'+ $coin);//UrlLinCoin Point가 부족합니다. point를 축적해야합니다.
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.makeform.mode.value = 'write_r';
				document.makeform.action='tkher_php_programDNW.php';
				document.makeform.target = '_blank';
				document.makeform.submit();
			} else {
				alert('Cancel!');
			}
		}
	}
	function popup_call(if_dataPG, pop_dataPG, i ) {
		document.makeform.column_cnt.value = i;
		window.open("popup_call.php?fld_session="+i,"","alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes");
		return true;  
	}

	function input_check(item_cnt,iftype) { 
		return true; // no check
	}
	function program_run_pg( item_cnt,iftype) {
		if( !document.makeform.H_ID.value ) {
			alert('Login Please!'); return false;
		}
		if( !input_check(item_cnt,iftype) ) {
			alert('Please check the input of the column. ');
			return false;
		}
		document.makeform.mode.value='table_pg70_write';
		document.makeform.action='tkher_program_run_r.php';
		document.makeform.target='_self';
		document.makeform.submit();
	}
	function excel_upload_func(tab_enm, tab_hnm){
		document.makeform.mode.value="Upload_mode_table10i";
		document.makeform.tab_enm.value=tab_enm;
		document.makeform.tab_hnm.value=tab_hnm;
		document.makeform.action="excel_load.php";
		document.makeform.submit();
	}
	function table_data_list(pg_code) {
		document.makeform.target="_top";
		document.makeform.action="tkher_program_data_list.php?pg_code=" + pg_code;
		document.makeform.submit();
	}

//-->
</script>

<?php
	if( $kkk !="off") {
		for( $fi=1, $fj=1; $fi<$kkk5; $fi++, $fj++){
			$k0=$kkk0[$fj];
			$k1=$kkk1[$fj];
			$k2=$kkk2[$fj];
			$k3=$kkk3[$fj];

			echo "<script>";
			echo "function FUNC_".$fj."() {  ";
			echo "	v1 = ( ".$k1." * 1 ) ".$k3." ( ".$k2 ." * 1 );";
			echo $k0 . " = v1; ";
			echo "} ";
			echo "</script>";
		}
	}
?>
