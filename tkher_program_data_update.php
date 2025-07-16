<?php
	include_once('./tkher_start_necessary.php');
	/*
		tkher_program_data_update.php						: data update system program
		tkher_program_run.php?pg_code=dao_1693896214		: data insert system program , call : table10i.php, app_pg50RC.php 에서 call
		tkher_program_data_updateT.php						: data update test - system program
		tkher_program_data_view.php							: data view   system program
		tkher_program_data_list.php?pg_code=dao_1540779796  : data list   system program , popup , calc
	*/

	$H_ID = get_session("ss_mb_id");   
	if( $H_ID == '' ) {
		m_("You need to login. ");
		echo "<meta http-equiv='refresh' content=0;url='tkher_program_data_list.php?pg_code=".$_REQUEST['pg_code']."'>";exit;
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Made in Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/appmaker.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php
	$H_LEV			= $member['mb_level'];  
	$mode			= $_POST['mode'];
	$seqno			= $_POST['seqno'];
	$grant_write	= $_POST['grant_write'];
	$pg_name		= $_POST['pg_name'];
	$pg_code		= $_POST['pg_code'];
	$if_data			= array();
	if( isset($_POST['if_data']) ) $if_data=$_POST['if_data'];
	$tab_hnm		=	$_POST['tab_hnm'];
	$tab_enm		=	$_POST['tab_enm'];

	if( $mode == 'CHG_MODE' ){
		$pg_mid		= $_POST['pg_mid'];
		$tab_mid		= $_POST['tab_mid'];
		$item_array		= $_POST['item_array'];
		$item_cnt		= $_POST['item_cnt'];
		$iftypeX			= $_POST['iftypeX'];
		$iftype			= explode("|", $iftypeX);
		$list				= array();
		$ddd				= "";
		$list				= explode("@", $item_array);
		$upfileX = "";

		$query			= " UPDATE $tab_enm SET  ";
		for( $i=0, $j=1; $list[$i] != ""; $i++,$j++ ){
			$ddd  = $list[$i];
			if( isset($iftype[$j]) ) $typeX = $iftype[$j];
			else $typeX = '';
			$fld = explode("|", $ddd);
			$fld_enm= $fld[1];
			IF( $i==($item_cnt-1) ) { // 마지막 컬럼 체크 "," 처리를 위해...sql a=1, b=2 

				if( $typeX=='3' ) {
					$aa = @implode(",",$_POST[$fld[1]]);
					$query = $query . $fld[1] . "= '" . $aa . "' ";

				} else if( $typeX=='9' ) { // add file
					$nm = $fld[1]; 
					$upfileX = $_FILES["$nm"]["name"]; 
					$f_path = KAPP_PATH_T_ . "/file/" .  $tab_mid . "/" . $tab_enm. "/";
					$upfile_name = $_FILES["$nm"]["name"];
					if( isset($upfile_name) && $upfile_name !=='' ) {
						$upfile_name = str_replace(" ", "", $upfile_name);
						$upfile_name = $H_ID . "_" . time() ."_" . $upfile_name;
						$query = $query . $fld[1] ."= '" .$upfile_name. "' ";
						if( $_FILES["$nm"]["error"] > 0){ // error check
							echo "tkher_program_data_update nm:$nm, Return Code: " . $_FILES["$nm"]["error"] . "<br>"; // fld_3
						} else { // none error
							move_uploaded_file($_FILES["$nm"]["tmp_name"], $f_path.$upfile_name );
							echo "Stored in: " . $f_path.$upfile_name;	// upload 
						}
					}
				} ELSE IF( $fld[3] == "CHAR" || $fld[3] == "VARCHAR" || $fld[3] == "TEXT") {
						$query = $query . $fld[1] . "= '" . $_POST[$fld[1]] . "' ";
				} ELSE IF( $fld[3] == "DATE" || $fld[3] == "TIME" || $fld[3] == "DATETIME") {
						$query = $query . $fld[1] . "= '" . $_POST[$fld[1]] . "' ";
				} ELSE {
						$query = $query . $fld[1] . "= " . $_POST[$fld[1]] . " ";
				}
			} ELSE {

				if( $typeX=='3' ) {				// 3: checkbox
					$aa = @implode("," , $_POST[$fld[1]] ); 
					$query = $query . $fld[1] . "= '" . $aa . "', ";

				} else if( $typeX=='9' ) { 
					$nm = $fld[1]; 
					$upfileX = $_FILES["$nm"]["name"]; 
					$f_path = KAPP_PATH_T_ . "/file/" .  $tab_mid . "/" . $tab_enm. "/";
					$upfile_name = $_FILES["$nm"]["name"];
					if( isset($upfile_name) && $upfile_name !=='' ) {
						$upfile_name = str_replace(" ", "", $upfile_name);
						$upfile_name = $H_ID . "_" . time() ."_" . $upfile_name;
						$query = $query . $fld[1] ."= '" .$upfile_name. "', ";
						if( $_FILES["$nm"]["error"] > 0){ // error check
							echo "tkher_program_data_update nm:$nm, Return Code: " . $_FILES["$nm"]["error"] . "<br>";
						} else { // none error
							move_uploaded_file($_FILES["$nm"]["tmp_name"], $f_path.$upfile_name );
						}
					}

				} ELSE IF( $fld[3] == "CHAR" || $fld[3] == "VARCHAR" || $fld[3] == "TEXT") {
						$query = $query . $fld[1] . "= '" . $_POST[$fld[1]] . "', ";
				} ELSE IF( $fld[3] == "DATE" || $fld[3] == "TIME" || $fld[3] == "DATETIME") {
						$query = $query . $fld[1] . "= '" . $_POST[$fld[1]] . "', ";
				} ELSE {
						$query = $query . $fld[1] . "= " . $_POST[$fld[1]] . ", ";
				}
			}	// $i
		}	// for
		$query = $query . " where seqno=$seqno ";
		$ret = sql_query( $query );
		if( $ret ) {
			m_(" Change completed! ");
			if( isset($_POST['up_file']) ) {
				$up_file = $_POST['up_file'];
				if( $upfileX !=='' && $up_file && $up_file !=='' ) exec ("rm $up_file");// 첨부화일이 있으면 기존화일을 삭제
			} else $up_file = '';
		} else m_(" Change Error! ");
	}

	$SQL = " SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' and fld_enm='seqno' ";
	if ( ($result = sql_query( $SQL ) )==false ){
		printf("11111  Invalid query: %s\n", $SQL);
		exit();
	} else {
		$row = sql_fetch_array($result);
		$tab_hnm		= $row['tab_hnm'];
		$grant_write	= $row['grant_write'];
		$grant_view	= $row['grant_view'];
		$tab_mid				= $row['userid'];
		$pg_title		= $tab_hnm;
	} 
?>

<style>
* {
  box-sizing: border-box;
}

.header2A {
  width: 100%;
  height:50px;
  float: left;
  border: 0px solid red;
  padding: 0px;
}

.menu1Area {
  width: 100%;
/*  height:60px; */
  height:auto;
  float: left;
  padding: 0px;
  border: 0px solid #DEDEDE;
  background-color:#FAFAFA;
}

.menu2T {
  padding-top: 3px;
  width: 25%;
  height:30px;
  float: left;
  padding: 4px;
  border: 1px solid #DEDEDE;
  background-color:#FAFAFA;
}
.menu2A {
  width: 25%;
  height:30px;
  float: left;
  padding: 0px;
  border: 0px solid #DEDEDE;
  background-color:#FAFAFA;
}
.data2A {
  width: 25%;
  height:30px;
  float: left;
  padding: 4px;
  border: 1px solid #DEDEDE;
  background-color:#FFFFFF;
}

.input1A {
  padding: 0px;
}

.mainA {
  width: 100%;
  float: left;
  padding: 15px;
  border: 1px solid red;
}

.menu1T {
  padding-top: 0px;
  width: <?=$menu1TWPer?>%;
  height:30px;
  float: left;
  padding: 6px;
  border: 1px solid #DEDEDE;
  background-color:#FAFAFA;
}
.menu1A {
  width: <?=$menu1AWPer?>%;
  height:30px;
  float: left;
  padding: 0px;
}
.data1A {
  width: <?=$menu1AWPer?>%;
  height:30px;
  float: left;
  padding: 6px;
  border: 1px solid #DEDEDE;
  background-color:#FFFFFF;
  text-align:left;
}

.radio1A {
  width: <?=$menu1AWPer?>%;
  height:30px;
  float: left;
  padding: 6px;
  border: 1px solid #DEDEDE;
  background-color:#FFFFFF;
}

.ListBox1A {
  width: <?=$menu1AWPer?>%;
  height:30px;
  float: left;
  padding: 2px;
  border: 1px solid #DEDEDE;
  background-color:#FFFFFF;
}

.File1A {
  width: <?=$menu1AWPer?>%;
  height:30px;
  float: left;
  padding: 2px;
  border: 1px solid #DEDEDE;
  background-color:#FFFFFF;
}

.menu4T {
  padding-top: 3px;
  width: 10%;
  height:30px;
  float: left;
  padding: 4px;
  border: 1px solid #DEDEDE;
  background-color:#FAFAFA;
}
.input4A {
  width: 15%;
  height:30px;
  float: left;
  padding: 0px;
  border: 1px solid #DEDEDE;
  background-color:#FFFFFF;
}
.menu4B {
  width: 15%;
  height:30px;
  float: left;
  padding: 0px;
  border: 0px solid #DEDEDE;
  background-color:#FAFAFA;
}
.data4A {
  width: 15%;
  height:30px;
  float: left;
  padding: 4px;
  border: 1px solid #DEDEDE;
  background-color:#FFFFFF;
}

.main4A {
  width: 100%;
  float: left;
  padding: 15px;
  border: 1px solid #DEDEDE;
}

.blankA {
	border-top:0px;
	width: 100%;
    float: left;
	height: 1px;
	padding: 0px;
	border: 1px solid #FFFFFF;
	background-color:#FFFFFF;
}

.blankB {
  width: 100%;
  height: 1px;
  padding: 1px;
  float: left;
  border: 1px solid #FFFFFF;
  background-color:#FFFFFF;
}

.viewSubjX{
	margin-top:1px;
	width:100%;height:35px;
	line-height:32px;
	border-top:3px solid #d01c27;
	text-align:center;
	background:#fafafa;
	border-bottom:1px solid #dedede;
	overflow:hidden;
	font-size:18px;
	color:#69604f;
}
.viewSubjX span{
	font-size:22px;color:#171512; vertical-align:baseline; 
}

.HeadTitle02AX{
	display:inline-block;
	margin:0 1px;
	height:35px;
	line-height:35px;
	padding:0 20px;
	font-size:25px;
	background:#d01c27;
	color:#ffffff;
	border-radius:5px;
}
.HeadTitle03AX{
	display:inline-block;
	margin:0 1px;
	height:35px;
	line-height:35px;
	padding:0 20px;
	font-size:25px;
	background:#d01c27;
	color:#ffffff;
	border-radius:5px;
	text-align:center;
}
.HeadTitle01AX{
	display:inline-block;margin:0 1px;height:40px;line-height:0px;padding:0 20px;
	font-size:22px;background:#d01c27;color:#fff;border-radius:5px;
}
.HeadTitle01AX a.on{
	background:#d01c27;color:#fff;
}

.HeadTitle01A{
	display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;
	font-size:22px;background:#dedcdf;color:#000;border-radius:5px;
}
.HeadTitle02A a{
	display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;
	font-size:22px;background:#dedcdf;color:#000;border-radius:5px;
}
.HeadTitle01A a{
	display:inline-block;margin:0 1px;height:35px;line-height:35px;padding:0 20px;
	font-size:22px;background:#dedcdf;color:#000;border-radius:5px;
}
.HeadTitle01A a.on{
	background:#d01c27;color:#fff;
}

.Btn_List01A{
	width:64px;
	height:33px;
	display:inline-block;
	line-height:33px;
	text-align:center;
	color:#fff;
	font-size:14px;
	background:#d01d27;
	margin-right: 10px;
	}
.Btn_List02A{
	width:64px;
	height:33px;
	display:inline-block;
	line-height:33px;
	text-align:center;
	color:#fff;
	font-size:14px;
	background:#d01d27;
	margin-right: 10px;
	}
.viewHeader{width:100%;height:auto;overflow:hidden;position:relative;text-align:left;}
.viewHeader span{left:0;top:12px;font-size:14px;color:#686868;}

.boardView{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}
.boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}

.listTableX{width:100%px;}
.listTableX th{height:42px;border-top:3px solid #d01c27;font-size:14px;color:#69604f;font-weight:normal;background:#fafafa;border-bottom:1px solid #dedede;}
.listTableX td{height:42px;border-bottom:1px solid #dedede;font-size:14px;color:#69604f;font-weight:normal;}
.listTableX .cell02{width:80px;text-align:center;}
.listTableX .cell03{}
.listTableX .cate{border-radius:5px;display:block;width:48px;height:23px;line-height:23px;overflow:hidden;margin:0 auto;color:#fff;font-size:12px;font-weight:bold;}

.listTable{width:100%px;text-decoration: none;}
.listTable th{height:42px;border-top:3px solid #d01c27;font-size:14px;color:#69604f;font-weight:normal;background:#fafafa;border-bottom:1px solid #dedede;}
.listTable td{height:30px;border-bottom:1px solid #dedede;font-size:14px;color:#69604f;font-weight:normal;}
.listTable .cell01{width:60px;text-align:center;text-decoration: none;}
.listTable .cell03{}
.listTable .cell05{width:70px;text-align:center;}
.listTable .cell02{width:80px;text-align:center;}
.listTable .cell04{width:200px;text-align:center;}
.listTable .cell06{width:50px;text-align:center;}
.listTable .cate{border-radius:5px;display:block;width:48px;height:23px;line-height:23px;overflow:hidden;margin:0 auto;color:#fff;font-size:12px;font-weight:bold;}
.listTable .cate.t01{background:#919191;}
.listTable .cate.t02{background:#086fbf;}
.listTable .cate.t03{background:#d01c27;}
.listTable td a span{font-size:14px;color:#69604f;text-decoration: none;}
.listTable td a .t01{font-size:14px;color:#d01c27;text-decoration: none;}

.btn_bo01{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#494949;font-size:14px;background:#dedcdf;}
.btn_bo02{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;font-size:14px;background:#d01d27; margin-right: 10px;text-decoration: none;}
.btn_bo03{width:76px;height:28px;display:inline-block;line-height:28px;text-align:center;color:#fff;font-size:14px;background:#3e3e3e;}

.search_btn{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;font-size:14px;background:#d01d27; margin-right: 10px;text-decoration: none;}

.paging{margin:20px auto 0 auto;width:100%;height:auto;overflow:hidden;text-align:center;}
.paging a, .paging span, .paging img{display:inline-block;vertical-align:middle;}
.paging a{color:#979288;font-size:18px;font-weight:bold;}
.paging span{color:#979288;font-size:18px;font-weight:bold;}
.paging a:hover{opacity:1;color:#d01c27;}
.paging a.on{font-weight:bold;color:#d01c27;}
.paging a.prev{margin-right:20px;}
.paging a.next{margin-left:20px;}
</style>
</head>

<body bgcolor='#ffffff'>
<center>

<?php
$SQLX = " SELECT * from $tab_enm where seqno=$seqno ";
if( ($result = sql_query( $SQLX ) )==false ) {
		printf("SQLX Invalid query: %s\n", $SQLX);
		exit();
} else {
		$row	= sql_fetch_array($result);

		$cur='B';
		include_once "./menu_run.php"; 
?>

<div>
	<P href="#" class="HeadTitle03AX" title='table code:<?=$tab_enm?> , program name:<?=$pg_name?>'><?=$pg_name?></P>
</div>
			<form name='tkher_form' action='tkher_program_data_update.php' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
				<input type="hidden" name='mode'		value='' />
				<input type="hidden" name='tab_enm'	value='<?=$tab_enm?>' />
				<input type="hidden" name='tab_hnm'	value='<?=$tab_hnm?>' />
				<input type="hidden" name='seqno'			value='<?=$seqno?>' />
				<input type="hidden" name='pg_name'		value='<?=$pg_name?>' />
				<input type="hidden" name='pg_code'		value='<?=$pg_code?>' />
				<input type="hidden" name='page'			value='<?=$page?>' />
				<input type="hidden" name='grant_write'	value='<?=$grant_write?>' />
			</form>

	<div class="boardViewX">
		<div class="viewHeader">
			<span title='tab_update_pg70'>Date : <?=date("Y-m-d H:i:s" ); ?></span>
		</div>
		<div class="viewSubjX"><span><?=$pg_name?>(<?=$pg_code?>:<?=$tab_hnm?>)</span> </div>
		<div class='blankA'> </div>
<?php
		$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
		$resultPG = sql_query($sqlPG);
		if ( $resultPG == false ) { m_(" tkher_program_data_update pg_name:$pg_name select ERROR "); exit; }
		$table10_pg = sql_num_rows($resultPG);
		$rsPG		= sql_fetch_array($resultPG);
		$list	= array();
		$ddd = "";
		$qqq = "";
		$kkk="off";
		$kkk0 = "document.makeform.fld_1.value";
		$kkk1 = "document.makeform.fld_1.value";
		$kkk2 = "document.makeform.fld_2.value";
		$kkk3 = "+";
		$kkk5 = 1; //func seq number
		$pg_name	= $rsPG['pg_name'];
		$tab_enm	= $rsPG['tab_enm'];
		$tab_hnm	= $rsPG['tab_hnm'];
		$group_code	= $rsPG['group_code'];
		$group_name	= $rsPG['group_name'];
		$item_cnt	= $rsPG['item_cnt'];
		$item_array = $rsPG['item_array'];
		$iftypeX	= $rsPG['if_type'];
		$ifdataX	= $rsPG['if_data'];
		$pop_dataPG	= $rsPG['pop_data'];
		$relation_dataPG = $rsPG['relation_data'];
		$relation_typePG = $rsPG['relation_type'];
		$iftype		= explode("|", $iftypeX);
		$ifdata		= explode("|", $ifdataX);
		$popdata	= explode("^", $pop_dataPG);
		$pg_mid			= $rsPG['userid'];
		$_SESSION['iftype_db']		= $iftypeX;
		$_SESSION['ifdata_db']		= $ifdataX;
		$_SESSION['if_dataPG']		= $ifdataX;	
		$_SESSION['pop_dataPG']		= $pop_dataPG;
		$_SESSION['relation_dataPG']	= $relation_dataPG;
		$_SESSION['relation_typePG']	= $relation_typePG;
		$_SESSION['pg_name']			= $pg_name;
		$_SESSION['pg_code']			= $pg_code;
?>
		<form name='makeform' action='' method='post' enctype="multipart/form-data">
					<input type="hidden" name='mode'			value='' />
					<input type="hidden" name='pg_mid'				value='<?=$pg_mid?>' />
					<input type="hidden" name='tab_mid'				value='<?=$tab_mid?>' />
					<input type="hidden" name='tab_hnm'		value='<?=$tab_hnm?>' />
					<input type="hidden" name='tab_enm'		value='<?=$tab_enm?>' />
					<input type="hidden" name='seqno'			value='<?=$seqno?>' />
					<input type="hidden" name='page'			value='<?=$page?>' />
					<input type="hidden" name='c_sel'			value='<?=$c_sel?>' />
					<input type="hidden" name='target_'		value='<?=$target_?>' />
					<input type="hidden" name='pg_name'		value='<?=$pg_name?>' />
					<input type="hidden" name='pg_code'		value='<?=$pg_code?>' />
					<input type="hidden" name='item_array'	value='<?=$item_array?>' />
					<input type="hidden" name='item_cnt'		value='<?=$item_cnt?>' />
					<input type="hidden" name='iftypeX'		value='<?=$iftypeX?>' />
					<input type="hidden" name='iftype'			value='<?=$iftype?>' />
					<input type="hidden" name='grant_write'	value='<?=$grant_write?>' />

<?php
		$list= explode("@", $item_array);
		for ( $i=0,$j=1; isset($list[$i]) && $list[$i] != ""; $i++, $j++ ){
				if( isset($iftype[$j])  && $iftype[$j] !=='') $typeX	= $iftype[$j];
				else $typeX	= '';
				if( isset($ifdata[$j]) && $ifdata[$j] !=='' ) $dataX	= $ifdata[$j];
				else $dataX	= '';
				if( isset($popdata[$j]) && $popdata[$j] !=='' ) $popX	= $popdata[$j]; 
				else $popX	= '';
				if( isset($ifdata[$j]) && $ifdata[$j] !=='') $if_fld= explode(":", $ifdata[$j]);
				else $if_fld	= '';
				$ddd		= $list[$i];
				$fld = explode("|", $ddd);
				$fldenm= $fld[1];
				$fldhnm= $fld[2];
				if ( $fld[3] == "TEXT" ) {
					echo"<p>$fldhnm</p>";
					echo " <div class='menu1Area' ><textarea name='$fld[1]' placeholder='Please enter your $fld[2]!' style='width:$Xwidth;height:$Text_height;'>$row[$fldenm]</textarea></div>";
					echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "BIGINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ) { 

						if ( $typeX == '5' ) {	// list box
									echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
									echo " <div class='ListBox1A'>";
									echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;'>";
									
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
									echo	"<input type='Checkbox' name='" . $fld[1] .  "[]' value='" . $if_fld[$k] . "' " . $mm ." >" . $if_fld[$k] . " &nbsp;";
								}
									echo " </span></div> ";
									echo " <div class='blankA'> </div> ";
						} else if( $typeX == '1' ) {	// radio 버턴.
									echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
									echo " <div class='radio1A'><span>";
								for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
									if( $if_fld[$k] == $row[$fldenm] )
											echo	"<input type = 'radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' checked >" . $if_fld[$k] . " &nbsp;";
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
							$kkk0 = "document.makeform." . $f0 . ".value";
							$kkk1 = "document.makeform." . $f2 . ".value";
							$kkk2 = "document.makeform." . $f4 . ".value";
							$kkk3 = $f3;
							$kkk5++; // = $func_cnt;

							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><span><input type=number name='$fld[1]' onClick='$fld[1]FUNC$kkk5()' title='$fld[1]XY()' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></span></div> ";
						} else {
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=number name='$fld[1]' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].' class=autom_subj></div> ";
						}
							echo " <div class='blankA'> </div> ";

				} else if ( $typeX == '13' ) {	// popup window
						$fld_session = $i;	// popup column 
						echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
						echo " <div class='menu1A'><input type=text name='$fldenm' value='$row[$fldenm]' onclick=\"javascript:popup_call('$ifdataX', '$pop_dataPG')\" style='width:$Xwidth;height:$Xheight;' placeholder='PopUp Window. Please enter a $fld[2].'></div> ";
						echo " <div class='blankA'> </div> ";

				} else if ( $typeX == '9' ) {	// add file
					if( $row[$fldenm] !== '' ) {
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
								echo " <input type='FILE' name='$fldenm' value='$row[$fldenm]' placeholder='Please enter a $fld[2].' style='width:$Xwidth;height:$Xheight;'> ";
								echo " </div> ";
								echo " <div class='blankA'> </div> ";
							} else {
								echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
								echo " <div class='data1A'><a href='./file/$tab_mid/$tab_enm/$row[$fldenm]'><img src=./icon/default.gif border=0>&nbsp;$row[$fldenm] </a></div> ";
								echo " <div class='blankA'> </div> ";
								echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
								echo " <div class='File1A'>";
								echo " <input type='FILE' name='$fldenm' value='$row[$fldenm]' placeholder='Please enter a $fldenm.' style='width:$Xwidth;height:$Xheight;'> ";
								echo " </div> ";
								echo " <div class='blankA'> </div> ";
							}
					} else {
								echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
								echo " <div class='File1A'>";
								echo " <input type='FILE' name='$fldenm' value='$row[$fldenm]' placeholder='Please enter a $fldenm.' style='width:$Xwidth;height:$Xheight;'> ";
								echo " </div> ";
								echo " <div class='blankA'> </div> ";
					}

				} else if ( $typeX == '7' ) {	// password
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=PASSWORD name='$fld[1]' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
				} else if ( $typeX == '5' ) {	// list box

							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='ListBox1A'>";
							echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;'>";
							
						for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
							if( $if_fld[$k] == $row[$fldenm] )
									echo "<OPTION SELECTED>$if_fld[$k]</OPTION>";
							else	echo "<OPTION >$if_fld[$k]</OPTION>";
						}
							echo "</SELECT>";
							echo " </div> ";
							echo " <div class='blankA'> </div> ";
				} else if ( $typeX == '3' ) {	// check box
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
						$ck = explode(",", $row[$fldenm] );
						$kk = count($ck);
						for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
							$mm = " ";
							for($ii=0;$ii<$kk;$ii++) {
								if( $if_fld[$k] == $ck[$ii] ) $mm=" checked ";
							}
							echo	"<input type='Checkbox' name='" . $fld[1] .  "[]' value='" . $if_fld[$k] . "' " . $mm ." >" . $if_fld[$k] . " &nbsp;";
						}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
				} else if ( $typeX == '1' ) {	// radio .
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
						for ( $k=0; isset($if_fld[$k]) && $if_fld[$k] != ""; $k++ ){
							if( $if_fld[$k] == $row[$fldenm] )
									echo	"<input type = 'radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' checked >" . $if_fld[$k] . " &nbsp;";
							else	echo	"<input type = 'radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "'>" . $if_fld[$k] . " &nbsp;";
						}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
				} else if ( $typeX == '0' ) {	//
						echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
						echo " <div class='menu1A'><input type='$fld[3]' name='$fldenm' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fldenm.'></div> ";
						echo " <div class='blankA'> </div> ";
				} else {	// typeX
						echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
						echo " <div class='menu1A'><input type='$fld[3]' name='$fldenm' value='$row[$fldenm]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fldenm.'></div> ";
						echo " <div class='blankA'> </div> ";
				}	//if
			} //  for
?>
				<input type="hidden" name='upfile'		value='<?=$upfile?>' />
				<div class="viewHeader">
					<a href="javascript:record_modify('<?=$seqno?>');" class="btn_bo02"> Submit </a>
					<a href="javascript:tab_pg_list();" class="btn_bo02">List</a>
				</div>
			</form>
			</div>
<?php
		$day	= date("Y-m-d");
		$up_day = date("Y-m-d h:i:s");

}  //query false
?>
</body>

 <script type="text/javascript">
	function popimage(imagesrc,winwidth,winheight){
		var look='width='+winwidth+',height='+winheight+','
		popwin=window.open("","",look)
		popwin.document.open()
		popwin.document.write('<title>urllinkcoin.com</title><body bgcolor="white" topmargin=0 leftmargin=0 marginheight=0 marginwidth=0><a href="javascript:window.close()"><img src="'+imagesrc+'" border=0></a></body>')
		popwin.document.close()
	}
	function record_modify( seqno ){
		if( confirm("Do you want to change it? seqno:"+seqno) ) {
			document.makeform.seqno.value=seqno;
			document.makeform.mode.value = "CHG_MODE";
			document.makeform.action = 'tkher_program_data_update.php';
			document.makeform.submit();
		}
	}
	function tab_pg_list() {
		document.tkher_form.action='tkher_program_data_list.php';
		document.tkher_form.target='_top';
		document.tkher_form.submit();
	}
	function Change_Csel_(c_sel){
		document.makeform.c_sel.value=c_sel;
	}
	function popup_call(if_dataPG, pop_dataPG ) {
		window.open("<?=KAPP_URL_T_?>/popup_call.php","","alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes");
		return true;  
	}

<?php
	if($kkk != "off") {
?>
	function <?=$kkk?>FUNC<?=$kkk5?>() {
		v1 = (<?=$kkk1?>*1) <?=$kkk3?> (<?=$kkk2?>*1);
		<?=$kkk0?> = v1;
	}
<?php } ?>
</script>
</html>
