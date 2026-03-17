<?php
	include_once('./tkher_start_necessary.php');
	/*
	tkher_program_data_view.php : kapp pg data view
	*/
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
<?php
	$H_ID= get_session("ss_mb_id");   
	if( $H_ID != '' ){
		$H_LEV = $member['mb_level'];
		$H_POINT= $member['mb_point'];
	} else {
		$H_ID = 'Guest';
		$H_LEV = 1;
		$H_POINT=0;
	}
	if( isset($_REQUEST['pg_code']) ) $pg_code = $_REQUEST['pg_code'];
	else if( isset($_POST['pg_code']) )  $pg_code = $_POST['pg_code'];
	else $pg_code='';
	if( $pg_code =='' ) {
			m_(" ERROR : pg_code:$pg_code , tab_enm:$tab_enm ");exit;
	}
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) )  $page = $_POST['page'];
	else $page='';
	if( isset($_REQUEST['data_mid']) ) $data_mid = $_REQUEST['data_mid'];
	else if( isset($_POST['data_mid']) ) $data_mid = $_POST['data_mid'];
	else $data_mid='';

 	$if_dataR= array();
	$if_typeR= array();
	$relation_dataPG= '';
	$relation_typePG= '';
	$SQL = " SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	if( ($rowPG = sql_fetch( $SQL ) )==false ){
		m_("tkher_program_data_view Error ");
		exit();
	} else {
		$grant_write= $rowPG['grant_write'];
		$grant_view	= $rowPG['grant_view'];
		$pg_mid	= $rowPG['userid'];
		$tab_mid= $rowPG['tab_mid'];
		$tab_enm= $rowPG['tab_enm'];
		$tab_hnm= $rowPG['tab_hnm'];
		$if_dataR= $rowPG['if_data'];
		$if_typeR= $rowPG['if_type'];
		$pg_name= $rowPG['pg_name'];
		$relation_dataPG= $rowPG['relation_data'];
		$relation_typePG= $rowPG['relation_type'];
	}
	if( $H_LEV >= $grant_view || $H_ID == $pg_mid || $H_ID == $data_mid) {
	} else {
		m_("You need to view level: $H_LEV, grant: $grant_view ");
		echo "<script>table_data_list('$pg_code'); </script>";
		exit;
	}
	if( isset($_POST['mode']) ) $mode		= $_POST['mode'];
	if( isset($_POST['seqno']) ) $seqno		= $_POST['seqno'];
	if( isset($_POST['item_cnt']) ) $item_cnt	= $_POST['item_cnt'];
	if( isset($_POST['line_cnt']) ) $line_cnt	= $_POST['line_cnt'];
?>
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/kapp_basic.css" type="text/css" />

<script type="text/javascript">
	
	function table_data_list(pg_code) {
		document.form_view.action="tkher_program_data_list.php";
		document.form_view.target='_self';
		document.form_view.submit();
	}
	function popimage(imagesrc,winwidth,winheight){
		var look='width='+winwidth+',height='+winheight+','
		popwin=window.open("","",look)
		popwin.document.open()
		popwin.document.write('<title>K-APP</title><body bgcolor="white" topmargin=0 leftmargin=0 marginheight=0 marginwidth=0><a href="javascript:window.close()"><img src="'+imagesrc+'" border=0></a></body>')
		popwin.document.close()
	}
	function data_delete( hid, seqno, RelTs_hnm){
		if( hid=='Guest'){
			alert("Guests cannot make changes");
			return;
		}
		if( document.form_view.Hid.value =='Guest') {
			alert('Guests cannot delete!'); return false;
		}
		if( confirm(" A table relation has been established. \n It cannot be changed. \n table name is: "+RelTs_hnm + "\n Are you sure you want to delete? ") ) {
			document.form_view.mode.value="data_delete";
			document.form_view.seqno.value=seqno;
			document.form_view.action='tkher_program_data_view.php';
			document.form_view.submit();
		}
	}
	function record_update(hid, RelTs_hnm){
		if( hid=='Guest'){
			alert("Guests cannot make changes");
			return;
		}
		if( document.form_view.Hid.value =='Guest') {
			alert("Guests cannot make changes");
			return false;
		}
		if( RelTs_hnm !='' ){
			alert("A table relation has been established. \n It cannot be changed. \n table name is: "+RelTs_hnm);
			return false;
		}
		document.form_view.mode.value='modify';
		document.form_view.action='tkher_program_data_update.php';
		document.form_view.target = '_self';
		document.form_view.submit();
	}
	function tab_pg_view() {
		document.form_view.action='tkher_program_data_list.php';
		document.form_view.target = '_self';
		document.form_view.submit();

	}
	function tkher_source_create($coin, seq){
		if( document.form_view.Hid.value == 'Guest' ) {
			alert('Login Please!'); return false;
		}
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.form_view.mode.value = 'view';
				document.form_view.action='tkher_php_programDNV.php';
				document.form_view.target = '_blank';
				document.form_view.submit();
			} else {
				alert('Cancel!');
			}
		}
	}
</script>
<body bgcolor='#ffffff'>
<center>
<?php
	$SQLX = " SELECT * from $tab_enm where seqno=$seqno ";
	if( ($row = sql_fetch( $SQLX ) )==false ){
			m_( "Error $tab_enm , seqno:$seqno" );
			exit();
	} else {
		if( isset($row['kapp_userid']) ) $data_mid = $row['kapp_userid'];
		else $data_mid = '';
?>
<?php
		$cur='B';
		include_once "./menu_run.php"; 
?>
		<div>
			<P onclick="javascript:tab_pg_view()" class="HeadTitle03AX" title='table code:<?=$tab_enm?> , program name:<?=$pg_name?>' align='center'><?=$pg_name?></P>
		</div>
<FORM name='form_view' method='post' enctype="multipart/form-data" >
		<input type="hidden" name='mode'		value='' />
		<input type="hidden" name='Hid'			value='<?=$H_ID?>' />
		<input type="hidden" name='pg_mid'			value='<?=$pg_mid?>' />
		<input type="hidden" name='tab_mid'			value='<?=$tab_mid?>' />
		<input type="hidden" name='data_mid'			value='<?=$data_mid?>' />
		<input type="hidden" name='tab_enm'	value='<?=$tab_enm?>' />
		<input type="hidden" name='tab_hnm'	value='<?=$tab_hnm?>' />
		<input type="hidden" name='seqno'		value='<?=$seqno?>' />
		<input type="hidden" name='page'		value='<?=$page?>' />
		<input type="hidden" name='grant_write' value='<?=$grant_write?>' />
		<input type="hidden" name='pg_name'	value='<?=$pg_name?>' />
		<input type="hidden" name='pg_code'	value='<?=$pg_code?>' />
		<input type="hidden" name='line_cnt' value='<?=$line_cnt?>' />
		<input type="hidden" name='item_cnt' value='<?=$item_cnt?>' />
		<input type="hidden" name='if_type' value='<?=$if_typeR?>' />
		<input type="hidden" name='if_data' value='<?=$if_dataR?>' />

	<div class="boardViewX">
		<div class="viewHeader">
			<span title='tkher_program_data_view'>pg:<?=$pg_code?>(<?=$pg_name?>) &nbsp;&nbsp;&nbsp; Date : <?=date("Y-m-d H:i:s" ); ?></span>
		</div>
		<div class="viewSubjX"><span title='(pg_mid:<?=$pg_mid?>:data_mid:<?=$data_mid?>:<?=$pg_code?>:<?=$tab_enm?>)'><?=$pg_name?></span> </div>
		<div class='blankA'> </div>
<?php
/*
//m_("$i, Rdata: " . $rdata[$i] . ", Rtype: " . $rt[$i]);
//Update:fld_1:fld_1:CHAR@Update:fld_1:fld_5:CHAR@Update:fld_1:fld_2:CHAR
//^|fld_1|상품|VARCHAR|15@|fld_2|원산지|VARCHAR|15@|fld_3|단위|VARCHAR|15@|fld_4|수량|INT|12@|fld_5|단가|INT|12@|fld_6|금액|INT|12@|fld_7|날짜|DATE|15@
//^|fld_1|날짜|DATE|15@|fld_2|yyyy|CHAR|15@|fld_3|mm|CHAR|15@|fld_4|dd|CHAR|15@|fld_5|product|VARCHAR|15@|fld_6|total_count|INT|12@|fld_7|tottal_price|BIGINT|15@
//^|fld_1|년도|YEAR|4@|fld_2|상품|VARCHAR|15@|fld_3|수량|INT|12@|fld_4|금액|INT|12@|fld_5|메모|TEXT|255@

//dao_1766822184:ABC_AAA:|fld_1|상품|VARCHAR|15@|fld_2|원산지|VARCHAR|15@|fld_3|단위|VARCHAR|15@|fld_4|수량|INT|12@|fld_5|단가|INT|12@|fld_6|금액|INT|12@|fld_7|날짜|DATE|15@
//$fld_1:fld1|=|fld_1:상품:VARCHAR
//$fld_2:fld2|=|fld_2:원산지:VARCHAR
//$fld_3:fld3|=|fld_3:단위:VARCHAR$fld_4:수량|+|fld_4:수량:INT$fld_5:단가|=|fld_5:단가:INT$fld_6:금액|+|fld_6:금액:INT
//$fld_7:날짜|=|fld_7:날짜:DATE
//^dao_1766735120:ABCYY:|fld_1|날짜|DATE|15
//@|fld_2|yyyy|CHAR|15
//@|fld_3|mm|CHAR|15
//@|fld_4|dd|CHAR|15
//@|fld_5|product|VARCHAR|15@|fld_6|total_count|INT|12@|fld_7|tottal_price|BIGINT|15@$fld_1:fld1|=|fld_5:product:VARCHAR
//$fld_7:날짜|=|fld_1:날짜:DATE$fld_4:수량|+|fld_6:total_count:INT$fld_6:금액|+|fld_7:tottal_price:BIGINT
//^dao_1773304478:ABC_년도별_판매실적:|fld_1|년도|YEAR|4@|fld_2|상품|VARCHAR|15@|fld_3|수량|INT|12@|fld_4|금액|INT|12@|fld_5|메모|TEXT|255@$fld_1:fld1|=|fld_2:상품:VARCHAR
//$fld_7:날짜|=|fld_1:년도:YEAR$fld_4:수량|+|fld_3:수량:INT$fld_6:금액|+|fld_4:금액:INT$fld_2:fld2|=|fld_5:메모:TEXT
*/
	if( $mode=="data_delete" ) {
		$SQL = " delete from $tab_enm where seqno=$seqno ";
		if(( $result = sql_query( $SQL ) )==false ){
			echo "table: $tab_enm - delete  Invalid query! SQL: ". $SQL; exit;
		} else {
			$relation_data =$relation_dataPG;
			$relation_type =$relation_typePG; 
			if( $relation_data !='' ) {
				$rdata = explode("^", $relation_data);
				$rtype = explode("^", $relation_type);
				$rtA = explode("@", $rtype[0]);	//$rt = explode("|", $rtA[0]);
				$data_cnt = count( $rdata);			//m_(" data_cnt: " . $data_cnt ); // data_cnt: 3
				for( $i=0; $i < $data_cnt && isset($rdata[$i]) && $rdata[$i] !=""; $i++ ){
					if( isset( $rdata[$i]) && $rdata[$i] !="" && $rdata[$i] !="undefined"){
						$reldata = $rdata[$i];
						$reltype = $rtype[$i];
						$rtab = explode(":", $rdata[$i] );
						$rt = explode("|", $rtA[$i]);
						$ktype = explode(":", $rt[0] );
						//echo "rt0:" . $rt[0] . ", i:$i, rdata: ". $rdata[$i] .", rtA: " . $rtA[$i];
						//m_("$i, rt0:" . $rt[0] . ", rdata: ". $rdata[$i] .", rtA: " . $rtA[$i] );
						//1, rt0:Update:fld_1:날짜:DATE, 
						//rdata: dao_1766735120:ABCYY:|fld_1|날짜|DATE|15@|fld_2|yyyy|CHAR|15@|fld_3|mm|CHAR|15@|fld_4|dd|CHAR|15@|fld_5|product|VARCHAR|15@|fld_6|total_count|INT|12@|fld_7|tottal_price|BIGINT|15@$fld_1:fld1|=|fld_5:product:VARCHAR$fld_7:날짜|=|fld_1:날짜:DATE$fld_4:수량|+|fld_6:total_count:INT$fld_6:금액|+|fld_7:tottal_price:BIGINT,
						//rtA: Update:fld_1:날짜:DATE|:fld_5:product:VARCHAR|
						//0, rt0:Insert:fld_1:상품:VARCHAR, 
						//rdata: dao_1766822184:ABC_AAA:|fld_1|상품|VARCHAR|15@|fld_2|원산지|VARCHAR|15@|fld_3|단위|VARCHAR|15@|fld_4|수량|INT|12@|fld_5|단가|INT|12@|fld_6|금액|INT|12@|fld_7|날짜|DATE|15@$fld_1:fld1|=|fld_1:상품:VARCHAR$fld_2:fld2|=|fld_2:원산지:VARCHAR$fld_3:fld3|=|fld_3:단위:VARCHAR$fld_4:수량|=|fld_4:수량:INT$fld_5:단가|=|fld_5:단가:INT$fld_6:금액|=|fld_6:금액:INT$fld_7:날짜|=|fld_7:날짜:DATE,
						//rtA: Insert:fld_1:상품:VARCHAR|

						if( $ktype[0] == 'Insert' ) relation_record_delete( $rdata[$i], $pg_code, $rtA[$i] );
						else if( $ktype[0] == 'Update' ) relation_record_update( $rdata[$i], $pg_code, $rtA[$i] );
					}
				}
			}
			$rungo = "tkher_program_data_list.php";
			echo "<script>table_data_list('$pg_code'); </script>";
		}
	}
	$list = array();
	$relationA = array();
	$relationT1 = array();
	$relationT2 = array();
	$relationT3 = array();
	$ddd = "";
	$qqq = "";
	if( $relation_dataPG != ''){
		$relationA= explode("^", $relation_dataPG);
		$relationT1= explode(":", $relationA[0]);
		$relationT2= explode(":", $relationA[1]);
		$relationT3= explode(":", $relationA[2]);
		if( $relationT1[1] !='') $relationT = $relationT1[1] . ', ' . $relationT2[1] . ', ' . $relationT3[1];
		else $relationT = '';
	} else $relationT = '';

	$item_array= $rowPG['item_array'];
	$list			= explode("@", $item_array);
	$if_type		= explode("|", $if_typeR);
	$if_data		= explode("|", $if_dataR);
	$kkk="off";
	$kkk0 = array();
	$kkk1 = array();
	$kkk2 = array();
	$kkk3 = array();
	$kkk5 = 1;

	for( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
		if( isset($if_type[$j])  && $if_type[$j] !='') $typeX	= $if_type[$j];
		else $typeX	= '';
		if( isset($if_data[$j]) && $if_data[$j] !='' ) $dataX	= $if_data[$j];
		else $dataX	= '';
		if( isset($popdata[$j]) && $popdata[$j] !='' ) $popX	= $popdata[$j]; 
		else $popX	= '';
		if( isset($if_data[$j]) && $if_data[$j] !='') $if_fld= explode(":", $if_data[$j]);
		else $if_fld	= '';
		$ddd		= $list[$i];
		$fld = explode("|", $ddd);
		$fldenm= $fld[1];
		$fldhnm= $fld[2];
		if( $fld[3] == "TEXT" ) {
			echo"<p>$fldhnm</p>";
			echo " <div class='menu1Area' ><textarea name='$fld[1]' placeholder='Please enter your $fld[2]!' style='width:$Xwidth;height:$Text_height;' readonly>$row[$fldenm]</textarea></div>";
			echo " <div class='blankA'> </div> ";
		} else if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "BIGINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ) { 
				if( $typeX == '5' ) {	// list box
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='ListBox1A'>";
							echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;' readonly>";
							
						for( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
							if( $if_fld[$k] == $row[$fldenm] )
									echo "<OPTION SELECTED>$if_fld[$k]</OPTION>";
							else	echo "<OPTION >$if_fld[$k]</OPTION>";
						}
							echo "</SELECT>";
							echo " </div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $typeX == '3' ) {	// check box
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
						$ck = explode(",", $row[$fldenm] );
						$kk = count($ck);
						for( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
							$mm = " ";
							for($ii=0;$ii<$kk;$ii++) {
								if( $if_fld[$k] == $ck[$ii] ) $mm=" checked ";
							}
							echo	"<input type='Checkbox' name='" . $fld[1] .  "[]' value='" . $if_fld[$k] . "' " . $mm ." readonly>" . $if_fld[$k] . " &nbsp;";
						}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $typeX == '1' ) {	// radio 버턴.
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
						for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
							if( $if_fld[$k] == $row[$fldenm] )
									echo	"<input type = 'radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' checked readonly>" . $if_fld[$k] . " &nbsp;";
							else	echo	"<input type = 'radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "'>" . $if_fld[$k] . " &nbsp;";
						}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $typeX == "11" ) { // calc
					$kkk=$fld[1];
					$idata = explode(":", $dataX);
					$datax = $idata[1];
					$datay = $idata[0];
					$ff = explode(" ", $datay);
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

					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
					echo " <div class='menu1A'><span><input type='number' name='$fld[1]' onClick='FUNC_$kkk5()' title='FUNC_$kkk5()' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].' readonly></span></div> ";
					$kkk5++; // = $func_cnt;
				} else {
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
					echo " <div class='menu1A'><input type='number' name='$fld[1]' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].' class='autom_subj' readonly></div> ";
				}
				echo " <div class='blankA'> </div> ";
		} else if( $typeX == '13' ) {	// popup window
				$fld_session = $i;	// popup column 
				echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
				echo " <div class='menu1A'><input type='text' name='$fldenm' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='PopUp Window. Please enter a $fld[2].' readonly></div> ";
				echo " <div class='blankA'> </div> ";

		} else if ( $typeX == '9' ) {	// add file
			if( $row[$fldenm] != '' ) {
				$upfile = KAPP_PATH_T_ . "/file/" . $tab_mid . "/" . $tab_enm . "/". $row[$fldenm];
				echo "<input type='hidden' name='up_file' value='$upfile' >"; // delete - use
				$ifile = explode( ".", $row[$fldenm] );
				$image_size = @GetImageSize( $upfile );
				$im = "./file/" . $tab_mid. "/" . $tab_enm . "/". $row[$fldenm];
				if( strtolower($ifile[1]) == 'jpg' || strtolower($ifile[1]) == 'png' || strtolower($ifile[1]) == 'gif' ) {
					echo"<p>$fldhnm</p>";
					echo"<div class='viewWriteBox' ><a href='#' onClick=\"popimage('$im',$image_size[0],$image_size[1]);return false\" onfocus='this.blur()'><img src='$im'  width='400' height='300' border=0></a> </div>";
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
					echo " <div class='File1A'>";
					echo " <input type='FILE' name='$fldenm' value='$row[$fldenm]' placeholder='Please enter a $fld[2].' style='width:$Xwidth;height:$Xheight;' readonly> ";
					echo " </div> ";
					echo " <div class='blankA'> </div> ";
				} else {
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
					echo " <div class='data1A'><a href='./file/$tab_mid/$tab_enm/$row[$fldenm]'><img src=./icon/default.gif border=0>&nbsp;$row[$fldenm] </a></div> ";
					echo " <div class='blankA'> </div> ";
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
					echo " <div class='File1A'>";
					echo " <input type='FILE' name='$fldenm' value='$row[$fldenm]' placeholder='Please enter a $fldenm.' style='width:$Xwidth;height:$Xheight;' readonly> ";
					echo " </div> ";
					echo " <div class='blankA'> </div> ";
				}
			} else {
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
					echo " <div class='File1A'>";
					echo " <input type='FILE' name='$fldenm' value='$row[$fldenm]' placeholder='Please enter a $fldenm.' style='width:$Xwidth;height:$Xheight;' readonly> ";
					echo " </div> ";
					echo " <div class='blankA'> </div> ";
			}
		} else if( $typeX == '7' ) {	// password
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
					echo " <div class='menu1A'><input type='PASSWORD' name='$fld[1]' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].' readonly></div> ";
					echo " <div class='blankA'> </div> ";
		} else if( $typeX == '5' ) {	// list box
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
					echo " <div class='ListBox1A'>";
					echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;' readonly>";
				for( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
					if( $if_fld[$k] == $row[$fldenm] )
							echo "<OPTION SELECTED>$if_fld[$k]</OPTION>";
					else	echo "<OPTION >$if_fld[$k]</OPTION>";
				}
					echo "</SELECT>";
					echo " </div> ";
					echo " <div class='blankA'> </div> ";
		} else if( $typeX == '3' ) {	// check box
					echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
					echo " <div class='radio1A'><span>";
				$ck = explode(",", $row[$fldenm] );
				$kk = count($ck);
				for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
					$mm = " ";
					for($ii=0;$ii<$kk;$ii++) {
						if( $if_fld[$k] == $ck[$ii] ) $mm=" checked ";
					}
					echo "<input type='Checkbox' name='" . $fld[1] .  "[]' value='" . $if_fld[$k] . "' " . $mm ." readonly>" . $if_fld[$k] . " &nbsp;";
				}
					echo " </span></div> ";
					echo " <div class='blankA'> </div> ";
		} else if( $typeX == '1' ) {	// radio .
				echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
				echo " <div class='radio1A'><span>";
				for( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
					if( $if_fld[$k] == $row[$fldenm] )
							echo	"<input type = 'radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' checked readonly>" . $if_fld[$k] . " &nbsp;";
					else	echo	"<input type = 'radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "'>" . $if_fld[$k] . " &nbsp;";
				}
				echo " </span></div> ";
				echo " <div class='blankA'> </div> ";
		} else if( $typeX == '0' ) {	//
				echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
				echo " <div class='menu1A'><input type='$fld[3]' name='$fldenm' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fldenm.' readonly></div> ";
				echo " <div class='blankA'> </div> ";
		} else {	// typeX
				echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
				echo " <div class='menu1A'><input type='$fld[3]' name='$fldenm' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fldenm.' readonly></div> ";
				echo " <div class='blankA'> </div> ";
		}	//if
	} // while // for
?>
					<div class="viewBtn">
<?php
		if( $H_ID == $pg_mid || $H_ID == $data_mid || $H_LEV >= $H_LEV ){
?>
			<input type='button' value='Modify' onclick="javascript:record_update('<?=$H_ID?>','<?=$relationT?>');" class="btn_bo02" title="grant write:<?=$grant_write?>:<?=$H_LEV?>">
			<input type='button' value='Delete' onclick="javascript:data_delete('<?=$H_ID?>', <?=$row['seqno']?>,'<?=$relationT?>');" class="btn_bo02">
<?php	} ?>
			<input type='button' value='List' onclick="javascript:tab_pg_view();" class="btn_bo02">
			<input type='button' value='Source Down' onclick="javascript:tkher_source_create('<?=$H_POINT?>', '<?=$seqno?>')" class="kapp_btn_bo02" title='Download the source.'>
					</div>
				</div>
			</div>
		</div>
<?php
	}  //query false
?>
</div>
</FORM>
</body>
</html>
