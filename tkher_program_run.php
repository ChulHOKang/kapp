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
	----------------------------------------------------------------- */
	if( $is_mobile ) {
		$menu1TWPer=36;
	} else {
		$menu1TWPer=15;
	}
	$menu1AWPer=100 - $menu1TWPer;
	$menu2TWPer=10;
	$menu2AWPer=50 - $menu2TWPer;
	$menu3TWPer=10;
	$menu3AWPer=33.3 - $menu3TWPer;
	$menu4TWPer=10;
	$menu4AWPer=25 - $menu4TWPer;
	$Xwidth='100%';
	$Xheight='100%';
	$Text_height='60px';

	$H_ID	= get_session("ss_mb_id");
	if( !$H_ID || !$H_LEV ) {
		m_("You need to login. ");
		echo "<meta http-equiv='refresh' content=0;url='tkher_program_data_list.php?pg_code=".$_REQUEST['pg_code']."'>";exit;
	} else if( isset($H_ID) && $H_ID !=='' ) {
		$H_POINT	= $member['mb_point'];
		$H_LEV=$member['mb_level'];
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Made in Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="./logo/appmaker.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

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
.Btn_List03A{
	width:104px;
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
</style>

<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	$is_mobile = false;
	$is_mobile = preg_match('/'.KAPP_MOBILE_AGENT.'/i', $_SERVER['HTTP_USER_AGENT']);
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else $page = 1;
	if( isset($_REQUEST['line_cnt']) ) $line_cnt = $_REQUEST['line_cnt'];
	else $line_cnt = 1;
	if( isset($_REQUEST['pg_code']) ) $pg_code = $_REQUEST['pg_code'];
	else $pg_code = 1;
	if( !$pg_code  ) {
			m_(" Abnormal approach. $mode, $pg_code ");
	}
	$in_day = date("Y-m-d H:i");
	$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	$resultPG = sql_query($sqlPG);
	$table10_pg = sql_num_rows($resultPG);
	if( !$table10_pg  ) {
			m_(" Abnormal approach. program no found! : $pg_code"); exit();
	}
	$rsPG		= sql_fetch_array($resultPG);
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
		$ddd = "";
		$qqq = "";
		$iftypeX = "";
		$ifdataX = "";
		$item_array = "";
		$kkk0 = "document.makeform.fld_1.value";
		$kkk1 = "document.makeform.fld_1.value";
		$kkk2 = "document.makeform.fld_2.value";
		$kkk3 = "+";
		$kkk5 = 1;  //func seq number
		$item_array = $rsPG['item_array'];
		$iftypeX	= $rsPG['if_type'];
		$ifdataX	= $rsPG['if_data'];
		$iftype		= explode("|", $iftypeX);
		$ifdata		= explode("|", $ifdataX);
		$popdata	= explode("^", $pop_dataPG);
		if( isset($item_array) ) $list = explode("@", $item_array);
		else  $list = "";
		for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
				$ddd  = $list[$i];
				if( isset($iftype[$j]) ) $typeX	= $iftype[$j];
				else $typeX	= "";
				if( isset($ifdata[$j]) ) $dataX	= $ifdata[$j];
				else $dataX	= "";
				if( isset($popdata[$j]) ) $popX	= $popdata[$j];
				else $popX	= "";
				if( isset($dataX) ) $if_fld = explode(":", $dataX);
				else $if_fld = "";
				if( isset($ddd) ) $fld = explode("|", $ddd);
				else $fld="";
			if( $fld[1] !== "seqno") { 
				$fld_enm= $fld[1];
				$fld_enmX= $fld[1];
				if( $fld[3] == "TEXT" ) {
					echo " <div class='menu1Area' ><p>$fld[2]</p><textarea name='$fld[1]' placeholder='Please enter your $fld[2]!' style='width:$Xwidth;height:$Text_height;'></textarea></div>";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "TIME" ) {
							$tday=date("H:i:s");
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type='$fld[3]' name='$fld[1]' value='$tday' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "DATE" ) { 
							$day=date("Y-m-d");
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type='$fld[3]' name='$fld[1]' value='$day' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "DATETIME" || $fld[3] == "TIMESTAMP" ) { 
							$day=date("Y-m-d H:i");
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type='$fld[3]' name='$fld[1]' value='$day' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
				} else if( $fld[3] == "INT" || $fld[3] == "TINYINT" || $fld[3] == "BIGINT" || $fld[3] == "SMALLINT" || $fld[3] == "MEDIUMINT" || $fld[3] == "DECIMAL" || $fld[3] == "FLOAT" || $fld[3] == "DOUBLE" ) { 

						if( $typeX == "1" ) { // radio button
								echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
								echo " <div class='radio1A'><span>";
							for ( $k=0; $if_fld[$k] != ""; $k++ ){
								echo	"<input type='radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' class='input1A'>" . $if_fld[$k] . " &nbsp;";
							}
								echo " </span></div> ";
								echo " <div class='blankA'> </div> ";
						} else if( $typeX == "3" ) { //check box
								echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
								echo " <div class='radio1A'><span>";
							for ( $k=0; $if_fld[$k] != ""; $k++ ){
									echo	"<input type='Checkbox' name='" . $fld[1] .  "[]'  value='" . $if_fld[$k] . "' >" . $if_fld[$k] . " &nbsp;";
							}
								echo " </span></div> ";
								echo " <div class='blankA'> </div> ";
						
						} else if( $typeX == "5" ) { // list box
								echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
								echo " <div class='ListBox1A'>";
								echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;'>";
							for ( $k=0; $if_fld[$k] != ""; $k++ ){
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
							$kkk0 = "document.makeform." . $f0 . ".value";
							$kkk1 = "document.makeform." . $f2 . ".value";
							$kkk2 = "document.makeform." . $f4 . ".value";
							$kkk3 = $f3;
							$kkk5++; // = $func_cnt;
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><span><input type=number name='$fld[1]' onClick='$fld[1]FUNC$kkk5()' title='$fld[1]XY()' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></span></div> ";
							echo " <div class='blankA'> </div> ";
						} else {
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=number name='$fld[1]' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].' class=autom_subj></div> ";
							echo " <div class='blankA'> </div> ";
						}
				} else {
						
						if( $typeX == "1" ) { // radio button
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
							for ( $k=0; $if_fld[$k] != ""; $k++ ){
								echo	"<input type='radio' name='" . $fld[1] . "' value='" . $if_fld[$k] . "' class='input1A'>" . $if_fld[$k] . " &nbsp;";
							}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "3" ) { //check box
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='radio1A'><span>";
							for ( $k=0; $if_fld[$k] != ""; $k++ ){
									echo	"<input type='Checkbox' name='" . $fld[1] .  "[]'  value='" . $if_fld[$k] . "' >" . $if_fld[$k] . " &nbsp;";
							}
							echo " </span></div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "5" ) { // list box
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='ListBox1A'>";
							echo	"<SELECT NAME='$fld[1]' SIZE='1' style='border-style:;height:25;'>";
							for ( $k=0; $if_fld[$k] != ""; $k++ ){
								echo "<OPTION SELECTED>$if_fld[$k]</OPTION>";
							}
							echo "</SELECT>";
							echo " </div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "7" ) { //password
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=PASSWORD name='$fld[1]' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "9" ) { // add file 
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='File1A'>";
							echo " <input type='FILE' name='$fld[1]' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'> ";
							echo " </div> ";
							echo " <div class='blankA'> </div> ";
						} else if( $typeX == "13" ) { // popup window
							$_SESSION['fld_session']=$i;
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=text name='$fld_enmX' onclick=\"javascript:popup_call('$if_dataPG', '$popX', '$i')\" style='width:$Xwidth;height:$Xheight;' placeholder='PopUp Window. Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
						} else {
							echo " <div class='menu1T' align=center><span style='width:$Xwidth;height:$Xheight;'>$fld[2]</span></div> ";
							echo " <div class='menu1A'><input type=text name='$fld[1]' value='' style='width:$Xwidth;height:$Xheight;' placeholder='Please enter a $fld[2].'></div> ";
							echo " <div class='blankA'> </div> ";
						}
					}
				} else {	//if seqno
					m_("seqno ========== ");
				}
		}//for
?>
		<input type=text name='iftype' value='<?=$iftypeX?>' style="display:none;">
		<input type=text name='ifdata' value='<?=$ifdataX?>' style="display:none;">
		<input type='hidden' name='mode'			value=''>
		<input type='hidden' name='pg_code'		value='<?=$pg_code?>'>
		<input type='hidden' name='pg_name'		value='<?=$pg_name?>'>
		<input type="hidden" name="tab_enm"		value="<?=$tab_enm?>">
		<input type="hidden" name="tab_hnm"		value="<?=$tab_hnm?>">
		<input type="hidden" name="item_array"	value="<?=$item_array?>">
		<input type="hidden" name="item_cnt"		value="<?=$item_cnt?>">
		<input type='hidden' name='pop_data'		value='<?=$pop_dataPG?>'>
		<input type='hidden' name='relation_data'	value='<?=$relation_dataPG?>'>
		<input type='hidden' name='column_cnt'	value=''>
		<input type='hidden' name='mid'	value='<?=$H_ID?>'>
		<input type="hidden" name='Hid'		value='<?=$H_ID?>' />
		<input type="button" value="submit" onclick="program_run_pg('<?=$i?>','<?=$iftypeX?>')" class='Btn_List01A'>
		<input type="reset" value="reset" class='Btn_List01A'>
		<input type='button' value='Source Down' onclick="javascript:tkher_source_create('<?=$H_POINT?>')" class="Btn_List03A" 
		title='Program source creation and Download the data registration program source. You need to download the table before you can run the program. Database creation is also included there. To download a table, click Program Creation Menu->Table Search->Table Name and click the Source Download button.' title='point:<?=$H_POINT?>'>
<?php
		echo "<input type='button' value='Excel_Upload' onclick=\"excel_upload_func('".$tab_enm."','".$tab_hnm."')\" class='Btn_List03A' title='Batch upload of data to excel file'>"
?>
		<input type='button' value='List' onclick="javascript:table_data_list('<?=$pg_code?>');" class="Btn_List01A">
</form>
<br>
<p>To download and run the program, you must also download the table creation source code.  To download a table, click Program Creation Menu->Table Search->Table Name and click the Source Download button.</p>

<script language="JavaScript"> 
<!--
	function home_func(pg_code){
		view_form.mode='home_func';
		view_form.action='tkher_program_data_list.php?pg_code='+pg_code;
		view_form.submit();
	}
	function tkher_source_create($coin){
		if( !document.makeform.Hid.value ) {
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
	function program_run_pg(item_cnt,iftype) {
		if( !document.makeform.Hid.value ) {
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

<?php
	if($kkk !="off") {
?>
	function <?=$kkk?>FUNC<?=$kkk5?>() {
		v1 = (<?=$kkk1?>*1) <?=$kkk3?> (<?=$kkk2?>*1);
		<?=$kkk0?> = v1;
	}
<?php } ?>

//-->
</script>
