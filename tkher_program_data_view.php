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
	if( $H_ID != '' ){
		$H_LEV = $member['mb_level'];
		$H_POINT= $member['mb_point'];
	} else {
		$H_LEV = 1;
		$H_POINT=0;
	}
	if( $H_LEV >= $grant_view || $H_ID == $pg_mid || $H_ID == $data_mid) {
	} else {
		m_("You need to view level: $H_LEV, grant: $grant_view ");
		echo "<meta http-equiv='refresh' content=0;url='tkher_program_data_list.php?pg_code=".$pg_code."'>";exit;
	}
	$mode		= $_POST['mode'];
	$seqno		= $_POST['seqno'];
	$tab_hnm	= $_POST['tab_hnm'];
 	$if_data		= array();
	$if_type		= array();
	if( isset($_POST['if_data']) ) $if_data	= $_POST['if_data'];
	if( isset($_POST['if_type']) ) $if_type	= $_POST['if_type'];
	$item_cnt	= $_POST['item_cnt'];
	$pg_name	= $_POST['pg_name'];
	$line_cnt	= $_POST['line_cnt'];
?>
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/kapp_basic.css" type="text/css" />

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
<body bgcolor='#ffffff'>
<center>
<?php
$data_mid = '';
$SQLX = " SELECT * from $tab_enm where seqno=$seqno ";
if ( ($row = sql_fetch( $SQLX ) )==false ){
		m_( "Error $tab_enm , seqno:$seqno" );
		exit();
} else {
		$data_mid = $row['kapp_userid'];
?>
<?php
		$cur='B';
		include_once "./menu_run.php"; 
?>
		<div>
			<P onclick="javascript:tab_pg_view()" class="HeadTitle03AX" title='table code:<?=$tab_enm?> , program name:<?=$pg_name?>' align='center'><?=$pg_name?></P>
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
				<input type="hidden" name='if_type'			value='<?=$if_type?>' />
				<input type="hidden" name='if_data'			value='<?=$if_data?>' />
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
				m_("Delete OK!");
				$rungo = "tkher_program_data_list.php";
				echo "<script>table_data_list('$tab_hnm'); </script>";
			}
		}
?>
			<form name='form3' action='' method='post' enctype="multipart/form-data" onsubmit='return check(this)'>
<?php
				$list = array();
				$ddd = "";
				$qqq = "";
				$item_array= $rowPG['item_array'];
				$list			= explode("@", $item_array);
				$iftypeX		= $rowPG['if_type'];
				$ifdataX		= $rowPG['if_data'];
				$if_type		= explode("|", $iftypeX);
				$if_data		= explode("|", $ifdataX);
			for ( $i=0,$j=1; $list[$i] != ""; $i++, $j++ ){
				$ddd  = $list[$i];
				if( isset($if_type[$j]) ) $typeX= $if_type[$j];
				else $typeX= '';
				if( isset($if_data[$j]) ) $if_fld = explode(":", $if_data[$j]); 
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
		if( $H_ID == $pg_mid || $H_ID == $data_mid ){ //쓰기권한 
?>
			<input type='button' value='Modify' onclick="javascript:record_update();" class="btn_bo02" title="grant write:<?=$grant_write?>:<?=$H_LEV?>">
			<input type='button' value='Delete' onclick="javascript:data_delete('<?=$H_ID?>', <?=$row['seqno']?>);" class="btn_bo02">
<?php } ?>
			<input type='button' value='List' onclick="javascript:tab_pg_view();" class="btn_bo02">
			<input type='button' value='Source Down' onclick="javascript:tkher_source_create('<?=$H_POINT?>', '<?=$seqno?>')" class="kapp_btn_bo02" title='Download the source.'>
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
