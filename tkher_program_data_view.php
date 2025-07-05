<?php
	include_once('./tkher_start_necessary.php');
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
	if( isset($_REQUEST['pg_code']) ) $pg_code = $_REQUEST['pg_code'];
	else if( isset($_POST['pg_code']) )  $pg_code = $_POST['pg_code'];
	else $pg_code='';

	if( isset($_REQUEST['tab_enm']) ) $tab_enm = $_REQUEST['tab_enm'];
	else if( isset($_POST['tab_enm']) )  $tab_enm = $_POST['tab_enm'];
	else $tab_enm='';

	if( isset($_REQUEST['data_mid']) ) $data_mid = $_REQUEST['data_mid'];
	else if( isset($_POST['data_mid']) )  $data_mid = $_POST['data_mid'];
	else $data_mid='';

	if( $pg_code =='' || $tab_enm =='' ) {
			m_(" ERROR : pg_code:$pg_code , tab_enm:$tab_enm ");exit;
	}
		$pg_mid	= '';
		$tab_mid= '';
	$SQL = " SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
	if( ($rowPG = sql_fetch( $SQL ) )==false ){
		m_("tkher_program_data_view Error ");
		exit();
	} else {
		//$row = sql_fetch_array($result);
		$grant_write= $rowPG['grant_write'];
		$grant_view	= $rowPG['grant_view'];
		$pg_mid	= $rowPG['userid'];
		$tab_mid= $rowPG['tab_mid'];
	} 
	$H_ID= get_session("ss_mb_id");   
	if( $H_ID !== '' ){
		$H_LEV = $member['mb_level'];
		$H_POINT= $member['mb_point'];
	} else {
		$H_LEV = 1;
		$H_POINT=0;
	}
	if( $H_LEV >= $grant_view || $H_ID == $pg_mid || $H_ID == $data_mid) {
		//m_("You need to login. $H_ID");
		//echo "<meta http-equiv='refresh' content=0;url='tkher_program_data_list.php?pg_code=".$pg_code."'>";exit;
	} else {
		m_("You need to view level: $H_LEV, grant: $grant_view ");
		echo "<meta http-equiv='refresh' content=0;url='tkher_program_data_list.php?pg_code=".$pg_code."'>";exit;
	}
	$mode		= $_POST['mode'];
	$seqno		= $_POST['seqno'];
	$tab_hnm	= $_POST['tab_hnm'];
 	$if_data		= array();
	$iftype		= array();
	$if_data		= $_POST['if_data'];
	$iftype		= $_POST['iftype'];
	$item_cnt	= $_POST['item_cnt'];
	$pg_name	= $_POST['pg_name'];
	$line_cnt	= $_POST['line_cnt'];

	/*$SQL = " SELECT * from {$tkher['table10_table']} where tab_enm='$tab_enm' and fld_enm='seqno' ";
	if( ($row = sql_fetch( $SQL ) )==false ){
	//if( ($result = sql_query( $SQL ) )==false ){
		//printf(" Error  Invalid query: %s\n", $SQL);
		m_("Fetch Error - pg_code: $pg_code, tab_enm: $tab_enm");
		exit();
	} else {
		//$row = sql_fetch_array($result);
		$tab_hnm	= $row['tab_hnm'];
		$grant_write= $row['grant_write'];
		$grant_view	= $row['grant_view'];
		$tab_mid= $row['userid'];
	}*/

	$str  = "abcdefghijklmnopqrstuvwxyz";
	$str .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$str .= "0123456789";
	$shuffled_str = str_shuffle($str);
	$auto_char=substr($shuffled_str, 0, 6);

	$menu1TWPer=15;
	$menu1AWPer=100 - $menu1TWPer;
	$menu2TWPer=10;
	$menu2AWPer=50 - $menu2TWPer;
	$menu3TWPer=10;
	$menu3AWPer=33.3 - $menu3TWPer;
	$menu4TWPer=10;
	$menu4AWPer=25 - $menu4TWPer;
	$Xwidth='100%';
	$Xheight='100%';
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
  height:60px;
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
.btn_T03T{width:84px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;font-size:14px;background:#d01d27; margin-right: 10px;text-decoration: none;}
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

.paging{margin:20px auto 0 auto;width:100%;height:auto;overflow:hidden;text-align:center;}
.paging a, .paging span, .paging img{display:inline-block;vertical-align:middle;}
.paging a{color:#979288;font-size:18px;font-weight:bold;}
.paging span{color:#979288;font-size:18px;font-weight:bold;}
.paging a:hover{opacity:1;color:#d01c27;}
.paging a.on{font-weight:bold;color:#d01c27;}
.paging a.prev{margin-right:20px;}
.paging a.next{margin-left:20px;}
</style>

<script type="text/javascript">
	
	function table_data_list(tab) {
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
	function data_delete(uid, seqno){
		if( !document.form_view.Hid.value ) {
			alert('Login Please!'); return false;
		}
		if( confirm("Are you sure you want to delete? ") ) {
			document.form_view.mode.value="data_delete";
			document.form_view.seqno.value=seqno;
			document.form_view.action='tkher_program_data_view.php';
			document.form_view.submit();
		}
	}
	function record_update(){
		if( !document.form_view.Hid.value ) {
			alert('Login Please!'); return false;
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
	function home_func(){
		view_form.mode='home_func';
		view_form.action='tkher_program_data_list.php';
		view_form.submit();
	}
	function tkher_source_create($coin, seq){
		if( !document.form_view.Hid.value ) {
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
</head>
<body bgcolor='#ffffff'>
<center>
<?php
$data_mid = '';
$SQLX = " SELECT * from $tab_enm where seqno=$seqno ";
if ( ($row = sql_fetch( $SQLX ) )==false ){
//if ( ($result = sql_query( $SQLX ) )==false ){
		m_( "Error $tab_enm , seqno:$seqno" );
		//printf("SQLX Invalid query: %s\n", $SQLX);
		exit();
} else {
		//$row	= sql_fetch_array($result);
		$data_mid = $row['kapp_userid'];
?>
<?php
		$cur='B';
		include_once "./menu_run.php"; 
?>
		<div>
			<P onclick="javascript:home_func()" class="HeadTitle03AX" title='table code:<?=$tab_enm?> , program name:<?=$pg_name?>' align='center'><?=$pg_name?></P>
		</div>
			<form name='form_view' action='tkher_program_data_view.php?id=<?=$H_ID?>#update_page' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
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
				<input type="hidden" name='line_cnt'	value='<?=$line_cnt?>' />
				<input type="hidden" name='item_cnt'	value='<?=$item_cnt?>' />
			</form>

	<div class="boardViewX">
		<div class="viewHeader">
			<span title='tkher_program_data_view'>pg:<?=$pg_code?>(<?=$pg_name?>) &nbsp;&nbsp;&nbsp; Date : <?=date("Y-m-d H:i:s" ); ?></span>
		</div>
		<div class="viewSubjX"><span title='(pg_mid:<?=$pg_mid?>:data_mid:<?=$data_mid?>:<?=$pg_code?>:<?=$tab_enm?>)'><?=$pg_name?></span> </div>
		<div class='blankA'> </div>
<?php
		if( $mode=="data_delete" ) {
			$SQL = " delete from $tab_enm where seqno=$seqno ";
			if ( ($result = sql_query( $SQL ) )==false )
			{
				printf("delete  Invalid query: %s\n", $SQL);
				exit();
			} else {
				my_msg("Delete OK!");
				$rungo = "tkher_program_data_list.php";
				echo "<script>table_data_list('$tab_hnm'); </script>";
			}
		}
?>
			<form name='form3' action='' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
<?php
				/*$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where pg_code='$pg_code' ";
				$resultPG = sql_query($sqlPG);
				if ( $resultPG == false ) { my_msg(" tab_view_pg70 pg_name:$pg_name select ERROR "); exit; }
				$table10_pg = sql_num_rows($resultPG);
				$rsPG = sql_fetch_array($resultPG);
				*/

				$list = array();
				$ddd = "";
				$qqq = "";
				//$mid			= $rowPG['userid'];
				$item_array= $rowPG['item_array'];
				$list			= explode("@", $item_array);
				$iftypeX		= $rowPG['if_type'];
				$iftype		= explode("|", $iftypeX);
				$ifdataX		= $rowPG['if_data'];
				$ifdata		= explode("|", $ifdataX);
			for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
				$ddd  = $list[$i];
				if( isset($iftype[$j]) ) $typeX= $iftype[$j];
				else $typeX= '';
				if( isset($ifdata[$j]) ) $if_fld = explode(":", $ifdata[$j]); 
				else $if_fld = '';
				$fld = explode("|", $ddd); 
				$fldenm= $fld[1];
				$fldhnm= $fld[2];
				if ( $fld[3] == "TEXT" ) {
					echo "<p>$fldhnm</p>";
					echo "<div class='viewWriteBox' ><textarea name='$fldenm' >$row[$fldenm]</textarea></div>";
				} else if ( $typeX == '9' ) { // add file
						if( $row[$fldenm] != '' ) {
								$ifile = explode( ".", $row[$fldenm] );
								$row_fnm = $row[$fldenm];
								$im = "./file/" . $tab_mid . "/". $tab_enm . "/" . $row_fnm;
								$imP= KAPP_PATH_T_ . "/file/" . $tab_mid . "/". $tab_enm . "/" . $row_fnm;
								$image_size = @GetImageSize( $imP );
								if( strtolower($ifile[1]) == 'jpg' or strtolower($ifile[1]) == 'png' or strtolower($ifile[1]) == 'gif' ) {
									echo"<p>$fldhnm</p>";
									echo"<div class='viewWriteBox' ><a href='#' onClick=\"popimage('$im',$image_size[0],$image_size[1]);return false\" onfocus='this.blur()'><img src='$im' width='400' height='300' border='0'></a> </div>";
								} else {
									echo " <div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
									echo " <div class='data1A'><a href='./file/$tab_mid/$tab_enm/$row[$fldenm]' target='_BLANK'><img src=./icon/file/default.gif border=0>&nbsp;$row[$fldenm] </a></div> ";
									echo " <div class='blankA'> </div> ";
								}
						}else{
								echo " <div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
								echo " <div class='data1A'> <img src='./icon/file/default.gif' border='0'> </div> ";
								echo " <div class='blankA'> </div> ";
						}
				} else {
					echo " <div class='menu1T' align='center'><span style='width:$Xwidth;height:$Xheight;'>$fldhnm</span></div> ";
					echo " <div class='data1A'>$row[$fldenm]</div> ";
					echo " <div class='blankA'> </div> ";
				}	//if
			} // while // for
?>
					<div class="viewBtn">
<?php
//		if( $H_LEV >= $grant_write ){ //쓰기권한 
//		if( $H_LEV >= $grant_write || $H_ID == $pg_mid || $H_ID == $data_mid ){ //쓰기권한 
		if( $H_ID == $pg_mid || $H_ID == $data_mid ){ //쓰기권한 
?>
			<input type='button' value='Modify' onclick="javascript:record_update();" class="btn_bo02" title="grant write:<?=$grant_write?>:<?=$H_LEV?>">
			<input type='button' value='Delete' onclick="javascript:data_delete('<?=$H_ID?>', <?=$row['seqno']?>);" class="btn_bo02">
<?php } ?>
			<input type='button' value='List' onclick="javascript:tab_pg_view();" class="btn_bo02">
			<input type='button' value='Source Down' onclick="javascript:tkher_source_create('<?=$H_POINT?>', '<?=$seqno?>')" class="Btn_List03A" title='Download the source.'>
					</div>
					</form>
				</div>
			</div>
		</div>
<?php
		$day	= date("Y-m-d");
		$up_day = date("Y-m-d h:i:s");
}  //query false
?>

</div>
</body>
</html>
