<?php
	include_once('./tkher_start_necessary.php');

	$ss_mb_id	= get_session("ss_mb_id");
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];

	if( !$H_ID || $H_LEV < 2 )
	{
		m_("Only registered members can use it after membership.");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}

/* ---------------------------------------------------------------------------------
 memo : table_relation_runf - program_pglist + program_list : 2018-10-25
           : program_pglist.php : 프로그램 목록을 출력한다. 관계식 설정 정보. 
--------------------------------------------------------------------------------- */
?>

<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
</head>

<?php

			$mode = $_POST['mode'];
			$seqno = $_POST['seqno'];
			$tab_enm = $_POST['tab_enm'];
			$tab_hnm = $_POST['tab_hnm'];
			$tab_hnmS = $_POST['tab_hnmS'];
			$pg_codeS = $_POST['pg_codeS'];
?>
<link rel="stylesheet" type="text/css" href="admin.css">
<body leftmargin="0" topmargin="0">

<script language="JavaScript"> 
<!--
	function rdata_sel(pg_rdata) {
			var ret_data="";
			rdata = pg_rdata.split("$");
			for( i=1; rdata[i]!=""; i++ ) {
				rrdata = rdata[i];
				if( !rrdata ) break;
				fld = rrdata.split("|");
				fld_p		= fld[0];
				rel_sik	= fld[1];
				fld_r		= fld[2];
				fld1 = fld_p.split(":");
				fld2 = fld_r.split(":");
				ret_data = ret_data + fld1[1] + rel_sik + fld2[1] + ",";
			}
			return ret_data;
	}

	function sellist_onclick() {

		makeform.pg_code.value	="";
		makeform.pg_name.value	="";
		makeform.tab_enm.value	="";
		makeform.tab_hnm.value	="";
		makeform.pg_formula.value="";
		makeform.tb_popup.value	="";
		makeform.pg_popup.value	="";
		makeform.pg_array.value	="";
		makeform.tb_relation.value = "";
		makeform.pg_relation.value = "";
		var selind = makeform.sellist.selectedIndex;
		var tab = ""; 
		tab=makeform.sellist.options[selind].value;
		var pgR="";
		var formula_data = "";
		var pop_table = "";
		var iftype="";
		var ifdata="";
		pgR = tab.split("!");
		makeform.tab_enm.value=pgR[0];
		makeform.tab_hnm.value=pgR[1];
		makeform.pg_code.value=pgR[8];
		makeform.pg_name.value=pgR[9];
		makeform.project_name.value=pgR[10];
		makeform.project_code.value=pgR[11];
		pg_name=pgR[9];
		ift=pgR[2];
		ifd=pgR[3];
		cnt=pgR[7];
		if( pgR[3] != "" ) {
			pgR3 = pgR[3];
			ifdata = pgR[3].split("|");
		}	else {
			//ifdata='';
		}
		if( pgR[2] != "" ) {
			pgR2 = pgR[2];
			iftype = pgR2.split("|");
			for(i=1; i < cnt ; i++) {
				typeX = iftype[i];
				if( typeX == "" ) break;
				dataX = ifdata[i];
				if( typeX == '11') { 
					formula_data=dataX.split(":"); 
					makeform.pg_formula.value=formula_data[1];
				} else formula_data="";	//fld_4 = fld_2 * fld_3:금액 = 단가 * 수량
				if( typeX == '13') { 
					pop_table=dataX.split(":"); 
					makeform.tb_popup.value=pop_table[1];
				} else pop_table="";
			}
		}	else iftype='';
		var pop_move="";
		var move_col="";
		var mdata="";
		var dataX="";
		if( pgR[4] != "" ) {
			pop = pgR[4].split("@");
			pop0=pop[0];
			pop_move = pop0.split("$");
			for(i=1;pop_move[i] != ""; i++) {
				mdata = pop_move[i];
				if( !mdata ) break;
				dataX = mdata.split("|");
				dd1= dataX[0];
				dd2= dataX[1];
				move_col1 = dd1.split(":");
				move_col2 = dd2.split(":");
				move_col = move_col + move_col1[1] + "=" + move_col2[1] + " , ";
			}
		}	else move_col='';
		if( !move_col ) makeform.pg_popup.value="";
		else  makeform.pg_popup.value=move_col;
		var fld_h = "";
		if( pgR[6] != "" ) {
			item = pgR[6].split("@");
			for(i=0;item[i]!='';i++) {
				fff = item[i];
				if ( !fff ) break;
				fld = fff.split("|");
				fld_h = fld_h + fld[2] +"("+ fld[3] + ") , ";
			}
		}	else fld='';
		makeform.pg_array.value=fld_h;
		rrr = pgR[5];
		//alert('rrr:'+rrr);	 //rrr:dao_1537844601:입고정보$fld_1:상품|=|fld_1:상품$fld_2:수량|=|fld_2:수량$fld_2:수량|=|fld_3:재고$fld_5:일자|=|fld_4:일자
		if( rrr ) {
			rel = rrr.split("$");
			rtb = rel[0];
			rtab = rtb.split(":");
			makeform.tb_relation.value = rtab[1];
			makeform.pg_relation.value = rdata_sel( rrr );			//
		}
	}

	function change_table_func(tab) {
		tab = document.makeform.tab_hnmS.value;
		document.makeform.mode.value='SearchTAB';	// table_relation.php에 전달한다.
		document.makeform.action="table_pg70.php";
		document.makeform.target='runf_main';
		document.makeform.submit();
	}

	function change_program_func(pg) {
		pg = document.makeform.pg_codeS.value;
		document.makeform.mode.value='SearchPG';
		document.makeform.action="table_pg70.php";
		document.makeform.target='runf_main';
		document.makeform.submit();
		return;
	}

	function relation_setup(pg)
	{
		pg_name = document.makeform.pg_name.value;
		if( !pg_name ) {
			alert(" Please select or enter program name!");
			document.makeform.pg_name.focus();
			return false;
		}

		document.makeform.mode.value = 'SearchPG';
		document.makeform.mode_call.value = 'program_pglist';
		document.makeform.action='table_relation.php';
		document.makeform.target='tab_pg_list';
		document.makeform.submit();
	}

	function run_pg(pg_code)
	{
		pg_name = document.makeform.pg_name.value;
		if( !pg_name ) {
			alert(" Please select a program! ");
			document.makeform.pg_name.focus();
			return false;
		}
		document.makeform.mode.value = 'program_pglist';
		document.makeform.mode_call.value = 'program_pglist';
		//document.makeform.action='tkher_program_run.php';
		document.makeform.action='tkher_program_run.php?pg_code='+pg_code;
//		document.makeform.action='table_pg70_write.php';
//		document.makeform.action='table_item_run70.php';
		document.makeform.target= 'tab_pg_list';
		document.makeform.submit();
	}

	 function run_tablelist(pg)
	{
			pg_name = document.makeform.pg_name.value;
			if( !pg_name ) {
				alert(" Please select a Program! ");
				document.makeform.pg_name.focus();
				return false;
			} else {
				document.makeform.mode.value='Program_Search';
				document.makeform.param.value='pg_name';
				document.makeform.sel.value='like';
				document.makeform.data.value=pg_name;
				document.makeform.action='program_list3.php';
				document.makeform.target='tab_pg_list';
				document.makeform.submit();
				tab_hnm = document.makeform.pg_name.value;
			}
	}

	 function run_pg_list(pg)
	{
			pg_name = document.makeform.pg_name.value;
			if( !pg_name ) {
				alert(" Please select a Program! ");
				document.makeform.pg_name.focus();
				return false;
			} else {
				document.makeform.mode.value='program_pglist';
				document.makeform.action='tab_list_pg70.php';
				document.makeform.target='tab_pg_list';
				document.makeform.submit();
				tab_hnm = document.makeform.pg_name.value;
			}
	}
	
	function program_search_onclick()
	{
			pg_name = document.makeform.program_name_search.value;
			if( !pg_name ) {
				alert(" Please enter the program name! ");
				document.makeform.program_name_search.focus();
				return false;
			}
			document.makeform.action='program_pglist.php';
			document.makeform.target='_self';
			document.makeform.submit();
	}

	function group_code_change_func(cd){
		index = document.makeform.group_code.selectedIndex;
		//alert('index: ' + index );
		nm = document.makeform.group_code.options[index].text;
		document.makeform.group_name.value = nm;
		vv = document.makeform.group_code.options[index].value;
		document.makeform.group_codeX.value = vv;
		//alert('cd: ' + cd + ', nm: ' + nm);
		document.makeform.mode.value = "project_search";
		document.makeform.action ="program_pglist.php";
		document.makeform.submit();
		return;
	}
//-->
</script>

<?php
	$w='100%';
	$w2='200';
	$pg_code = $H_ID . "_" . time();
	if( $mode_session == 'POPUP') {
	} else if( $mode_session == 'Formula') {
	}
	//---------------------------------------------------------------------------------------------------------
	if( $mode == 'SearchTAB' ){
			$aa = explode(':', $tab_hnmS);
			$tab_enm = $aa[0];
			$tab_hnm = $aa[1];
			$sqlTAB = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID'  and pg_name='$tab_hnm' ";
			$resultTAB = sql_query($sqlTAB);
			$table10_tab = sql_num_rows($resultTAB);
			$rsTAB = sql_fetch_array($resultTAB);
			$item_cnt	= $rsTAB['item_cnt'];
			$item_array	= $rsTAB['item_array'];
			$if_type		= $rsTAB['if_type'];
			$if_data		= $rsTAB['if_data'];
			$pop_data	= $rsTAB['pop_data'];
			$group_code	= $rsTAB['group_code'];  
			$group_name	= $rsTAB['group_name'];  
	} else if( $mode == 'SearchPG' ){

			$aa = explode(':', $pg_codeS);
			$pg_code = $aa[0];
			$pg_name = $aa[1];
			$tab_enm = $aa[2];
			$tab_hnm = $aa[3];
			$group_code = $aa[4];
			$group_name = $aa[5];
		
			$sqlPG = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID'  and pg_code='$pg_code' ";
			$resultPG = sql_query($sqlPG);
			$table10_pg = sql_num_rows($resultPG);
			$rsPG = sql_fetch_array($resultPG);
			$seqno		= $rsPG['seqno'];
			$item_cnt	= $rsPG['item_cnt'];
			$item_array	= $rsPG['item_array'];
			$if_type		= $rsPG['if_type'];
			$if_data		= $rsPG['if_data'];
			$pop_data	= $rsPG['pop_data'];
			$rel_data	= $rsPG['relation_data'];
			$tab_hnmS= $tab_enm . ":" . $tab_hnm;
	}	// mode search end
?>

<center>

<div id='menu_normal'>
   <table cellspacing='0' cellpadding='4' width='<?=$w2?>' border='1' class="c1">

		<form name="makeform" method="post" >
			<input type="hidden" name="mode" value="" >
			<input type="hidden" name="param" value="" > 
			<input type="hidden" name="sel" value="" > 
			<input type="hidden" name="data" value="" > 
			<input type="hidden" name="mode_call"	value="" >
			<input type="hidden" name="pg_codeS"	value="">
			<input type="hidden" name="pg_code"		value="<?=$pg_code?>">
			<input type="hidden" name="calc"			value="<?=$calc?>"> 
			<input type="hidden" name="pop_data"	value="<?=$pop_data?>"> 
			<input type="hidden" name="rel_data"		value="<?=$relation_data?>"> 
			<input type='hidden' name='if_line'			value='' >
			<input type='hidden' name='group_codeX'	value='<?=$group_code?>' >
			<input type='hidden' name='group_name'	value='<?=$group_name?>' >
			<input type='hidden' name='tab_enm'		value='<?=$tab_enm?>' >
		 <tr>
			<td height="30" align="center" style="border-style:;background-color:#666666;color:yellow;" <?php echo" title='Relationship setup \n 1:Select Program \n 2:Click Set button.'  "; ?>>
			   <input type='text' id='program_name_search' name='program_name_search' maxlength='200' size='20' style="border-style:;background-color:black;color:yellow;height:25;" value='' <?php echo "title=Enter the column name and click the button! ' "; ?> >
				<input type='button' name='program_search' <?php echo "title=' Program Search.' "; ?>  onClick="program_search_onclick()"  value='Search' style="border-style:;background-color:green;color:white;height:25;"><br>

			<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black'>
<?php
 if( strlen($_POST['group_name']) > 0 ){
?>
							<option value='<?=$group_code?>' selected ><?=$_POST['group_name']?></option>
<?php
			} else {
?>
							<option value=''>Select Project</option>
<?php
			}
					$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );
					while( $rs = sql_fetch_array( $result)) {
?>
							<option value='<?=$rs['group_code']?>'><?=$rs['group_name']?></option>
							<!-- <option value='<?=$rs['group_code']?>' <?php if($rs['group_name']==$group_name) echo "selected"; ?>><?=$rs['group_name']?></option> -->
<?php
					}
?>
			</select>
			
			
			<b>[ Program List ]</b> <br> 
		</tr>
		<tr>
		   <td width="100%" valign="top" align="left">
			  <!-- <div id='menu_normal'> -->
							<!-- <table cellspacing="0" cellpadding="0" width="200" border="0">
								  <tr>
                                     <td valign="top"> -->
			<select id="sellist" name="sellist" onDblClick="run_tablelist('program_pglist')" onChange="" onClick="sellist_onclick()" multiple='multiple' size="14" <?php echo "title=' Double-click to view the data list.' "; ?> style="border-style:;background-color:black;color:cyan; WIDTH: 315px; height:150;">
<?php
			$program_name_search = $_POST['program_name_search'];
			if( $program_name_search )
					$sql = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and pg_name like '%$program_name_search%' order by pg_name ";
			else if( $mode == "project_search" )
					$sql = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' and group_code='".$_POST['group_codeX']."' order by upday desc";
			else	$sql = "SELECT * from {$tkher['table10_pg_table']} where userid='$H_ID' order by upday desc";
			$result = sql_query($sql);
			while($rsP = sql_fetch_array($result)) {
					$seqno = $rsP['seqno']; 
					$group_code = $rsP['group_code'];  
					$group_name = $rsP['group_name'];  
?>
				<option value="<?=$rsP['tab_enm']?>!<?=$rsP['tab_hnm']?>!<?=$rsP['if_type']?>!<?=$rsP['if_data']?>!<?=$rsP['pop_data']?>!<?=$rsP['relation_data']?>!<?=$rsP['item_array']?>!<?=$rsP['item_cnt']?>!<?=$rsP['pg_code']?>!<?=$rsP['pg_name']?>!<?=$rsP['group_name']?>!<?=$rsP['group_code']?>" ><?=$rsP['pg_name']?></option>
<?php
			}//while
?>
		</select>
                                    <!--  </td>
                                   </tr>
                            </table> -->
                       </div>
                      </td>
					</tr>
					  <tr>
						<td height="24" <?php echo "title='' "; ?> style="border-style:;background-color:#666666;color:cyan;height:25;">
						*Project: 
						   <input type='text' id='project_name' name='project_name' style="border-style:;background-color:black;color:yellow;height:25;width:120;" value='' readonly>
						   <input type='text' id='project_code' name='project_code' style="border-style:;background-color:black;color:yellow;height:25;width:111;">
						<br>*Used Table:
						   <input type='text' id='tab_hnm' name='tab_hnm' maxlength='200' size='25' style="border-style:;background-color:black;color:yellow;height:25;" value='' <?php echo "title='' "; ?> readonly>
						<br>*Formula<br>
						   <input type='text' id='pg_formula' name='pg_formula' maxlength='200' size='40' style="border-style:;background-color:black;color:yellow;height:25;" value='' 
						   <?php echo "title='' "; ?> readonly>
						<br>*POPUP<br>
						   <input type='text' id='tb_popup' name='tb_popup' maxlength='200' size='40' style="border-style:;background-color:black;color:yellow;height:25;" value='' 
						   <?php echo "title='' "; ?> readonly>
						<br><textarea id='pg_popup' name='pg_popup' rows='3' cols='38' style="border-style:;background-color:black;color:yellow;height:40;width:315;" readonly></textarea>
						<br>*Relation Table<br>
						   <input type='text' id='tb_relation' name='tb_relation' maxlength='200' size=40 style="border-style:;background-color:black;color:yellow;height:25;" value='' 
						   <?php echo "title='' "; ?> readonly>
						<br><textarea id='pg_relation' name='pg_relation' rows='3' cols='38' style="border-style:;background-color:black;color:yellow;height:60;width:315;" readonly></textarea>
						<br><textarea id='pg_array' name='pg_array' rows='3' cols='38' style="border-style:;background-color:black;color:yellow;height:60;width:315;" readonly></textarea>
						 </td>
					   </tr>
                            <!-- </table>
                          </td>
                         </tr>
                       </table>
                       </div>
                      </td>
                     </tr> -->
					<tr>
                      <td align="center" >

Program<input type='text' id='pg_name' name='pg_name' value='' maxlength='200' style="border-style:;background-color:black;color:yellow;width:110px;height:25;" value=''  <?php echo" title='Enter the name of the program to be created! pg_code:$pg_code' "; ?> readonly>
<input type='button' value='Run' <?php echo "title=' Run the data registration program.' "; ?> onClick="run_pg('<?=$pg_code?>')"  style="border-style:;background-color:#666666;color:yellow;width:75px; height:25px;" >
						</td>
                    </tr>

		</form>
	</table>

	<!-- </td>
  </tr> -->
	</div>

</body>
</html>
