<?php
	include_once('./tkher_db_lib.php'); 
	/*
	 *  popup_callDN.php : type : 13 : popup win 
		소스를 생성후 실행할때 필요함.
		$tkher_iurl : tkher_db_lib.php 에서 선언됨.
	*/
	include './tkher_dbcon_Table.php';// DB 정보를 공백으로 선함. 사용자 서버에서 설치할떄

	$relation_dataPG	= $_SESSION['relation_dataPG'];  // add 2020-11
	$pop_dataPG	= $_SESSION['pop_dataPG']; 
	$if_dataPG	= $_SESSION['if_dataPG']; 
	$ifdata_db	= $_SESSION['if_dataPG']; 
	$if_typePG	= $_SESSION['if_typePG']; 
	$iftype_db	= $_SESSION['if_typePG']; 

	$fld_session	= $_REQUEST['fld_session']; 

	$idata = explode("|", $ifdata_db);
	$itype = explode("|", $iftype_db);
	$it = (int)$fld_session+1;

	$pop_if = $itype[$it];
	$pop_db = $idata[$it];

	$tdata = explode(":", $pop_db);

	$tab_enmP = $tdata[0];
	$tab_hnmP = $tdata[1];
	$pdataA = explode("^", $pop_dataPG);
	$pdata		= explode("@", $pdataA[$it]); 

	$mpxcol = array();
	$mwxcol = array();

	$movecol = explode("$", $pdata[0]);

	for( $i=0, $j=1; $movecol[$j] != ""; $i++ , $j++) {
			$mmcol	= explode("|", $movecol[$j]);
			$mp0		= $mmcol[0];
			$mpcol	= explode(":", $mp0 );
			array_push( $mpxcol, $mpcol );	
			$mp1		= $mmcol[1];
			$mwcol	= explode(":", $mp1 );
			array_push( $mwxcol, $mwcol );
	}
	$pxcol = array();
	for( $i=0, $j=1; $pdata[$j] != ""; $i++, $j++ ) {
			$pcol = explode(":", $pdata[$j]);
			array_push($pxcol, $pcol);	 	
	}
	for( $i=0; $pxcol[$i][0] != ""; $i++ ) {
			$fe=$pxcol[$i][0];	
			$fh=$pxcol[$i][1];
	}
?>
<script	language="JavaScript">
<!--
	function call_pg_select( pp, pw, pd) {
		p1 = pp.split("|");
		p2 = pw.split("|");
		p3 = pd.split("|");
		for( i=0; p1[i] != "";  i++){
			pk		= p1[i].split(":");
			$p0	= pk[0];
			$p1	= pk[1];
			pg		= p2[i].split(":");
			$pg0	= pg[0];
			$pg1	= pg[1];
			$dd0	= p3[i];
			eval ( "parent.window.opener.document.makeform."+$pg0+".value = $dd0" );
		}
		window.close();
		return false;
	}

	function doSubmit()
	{
		if ( document.popupform.sel_g_name.value == "") {
			alert(" You did not select a search column.");// \n 검색 컬럼을 선택 않았습니다. 
			document.popupform.search_data.focus();
			return false;
		}
		if (document.popupform.search_data.value == "") {
			alert(" You have not entered any search terms.");// \n 검색어를 입력 않았습니다. 
			document.popupform.search_data.focus();
			return false;
		}
			document.popupform.submit();
	}

	function change_g_name_func(g_name) {
		//if(g_name) location.href="pg_list_select.php?g_name="+g_name;
		//else location.href="pg_list_select.php";
		//document.popupform.sel_g_name.value = g_name;
		//document.popupform.submit();
	}
-->
</script>

<html>
<head>
<title>data search</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0' bgcolor='black'>
<table width="710" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"><font color='yellow'>Table : <?=$tab_hnmP?></tr>
<tr>
  <td width="600" colspan='3'>
	<form method="post" action="popup_call.php" name="popupform">	
		<input type="hidden" name="if_dataPG"	value='<?=$if_dataPG?>' >
		<input type="hidden" name="pop_dataPG" value='<?=$pop_dataPG?>' >
		<input type='hidden'  name='g_name'>
		<table width="750" border="0" cellspacing="0" cellpadding="0" height="25">
			<tr>
					<td  rowspan="1" width="330" align="right" height="25" valign='center'><font color='yellow'>&nbsp; Column :
						<select name='sel_g_name' onchange="change_g_name_func(this.value);" style="HEIGHT: 20px">
<?php

							for( $i=0; $pxcol[$i][0] != ""; $i++ ) {
									$fpe=$pxcol[$i][0];	
									$fph=$pxcol[$i][1];
?>
										<option value='<?=$fpe?>' <?php if( $fpe ==$_POST['sel_g_name']) echo "selected"; ?> ><?=$fph?></option>
<?php
							}
?>
						</select>
					</td>

					<td rowspan="2"  align="left" height="30">
						<font color='yellow'>&nbsp;<input type="text" name="search_data" size="20" maxlength="50" value='<?=$search_data?>'>
						<input type='button' value='Confirm' onclick='doSubmit()'>
						</td>
			</tr>
		</table>
	</form>
  </td>
</tr>
</table>
<table width="650" border="1" cellspacing="0" cellpadding="0">
	<tr align='center'>
<?php
			for ( $i=0; $pxcol[$i][1]!=""; $i++) {
				$t = $pxcol[$i][1];	// 팝업창 컬럼 타이틀 부분......
?>
				<td><font color='yellow' size=3><?=$t?></td> 
<?php
			}
?>
				<td><font color='yellow'>Select</td>
	</tr>
<?php
	if( $_POST['sel_g_name'] != "" && $_POST['search_data'] != "") {
		$sf	= $_POST['sel_g_name'];
		$sd	= $_POST['search_data'];
		$w		= " WHERE ( ".$_POST['sel_g_name']." like '%".$_POST['search_data']."%' ) ";
		$ls		= " SELECT * FROM ". $tab_enmP . $w;
	}
	else $ls	= "SELECT * FROM ". $tab_enmP . " ";
	$result	= sql_query(  $ls );
	while( $rs = sql_fetch_array( $result ) ) {
?>
			<tr valign="middle" align='center'>
<?php
				$pw		= "";
				$datap	= "";
				$fieldp	= "";
				$fieldw	= "";
				$kkk		= 1;
			for ( $i=0; $pxcol[$i][0] != ""; $i++) {
				$pf = $pxcol[$i][0];
				$pd = $rs[$pf];		// data
				for( $k=0; $mpxcol[$k] != ""; $k++ ) {	// data diplay
						$fp0=$mpxcol[$k];	// popup column
						$fw0		= $mwxcol[$k];	// program column
						$ppc		= $fp0[0];
						$rdata	= $rs[$ppc];
						if( $pf == $fp0[0] && $kkk==1) {
								$pp		= $fp0[0] . ":" .$fp0[1];
								$pw		= $fw0[0] . ":" .$fw0[1];
								$datap	= $datap . $rdata . "|";
								$fieldp	= $fieldp . $pp . "|";
								$fieldw	= $fieldw . $pw . "|";
						}
				}
?>
			  <td height='15'><font color='yellow' size='2'><?=$pd?><br></td>
<?php
		  }//for
				if( $kkk==1) {	// 첫번째 라인 출력시  컬럼 전체를 체크하므로 한번만 체크하면된다.
					//6: pf:fld_6, w:fld_1:상품|fld_3:단가|, p:fld_1:상품명|fld_4:판매가|fld_1:상품명|fld_4:판매가|fld_1:상품명|fld_4:판매가|, d:패드:900000:
					$kkk=0;
				}
?>
			  <td height=15>
						<input type='button' value='Select' onclick="javascript:call_pg_select('<?=$fieldp?>','<?=$fieldw?>','<?=$datap?>' )">
			  </td>
			</tr>
<?php
	}
?>
  </td>
</tr>
<tr align="center">
  <td height="30" width="550" colspan='<?=$i+1?>'><a href="javascript:self.close()"><font color='cyan' size='3'>[ * CLOSE! * ]</a></td>
</tr>
</table>
</body>
</html>
