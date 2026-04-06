<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	$H_LEV=$member['mb_level'];  
	$ip = $_SERVER['REMOTE_ADDR'];
	if (!$H_ID) {
		my_msg("Please Login! ");
		$rungo = "/";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
?>
<style>
table { border-collapse: collapse; }
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }
	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		justify-content: space-between;		/* flex-start, flex-end, center, space-between, space-around */
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around 줄넘김 처리시 사용. */
		align-items: center;							/* flex-start, flex-end, center, baseline, stretch */
		height:25px;

	}
	.item {
		background-color: gold;
		boarder: 1px solid gray;
	}
</style>
<script src="//code.jquery.com/jquery.min.js"></script>
<script>
<!--
	$(function () {
		let timer;
		document.getElementById('tit_et').addEventListener('click', function(e) {
			clearTimeout(timer);
			timer = setTimeout(() => {
				switch(e.target.innerText){
					case 'Project'    : title_func('group_name'); break;
					case 'Table'      : title_func('tab_hnm'); break;
					case 'Field'      : title_func('fld_hnm'); break;
					case 'Type'       : title_func('fld_type'); break;
					default           : title_func(''); break;
				}
			}, 250);
		});
		document.getElementById('tit_et').addEventListener('dblclick', function(e) {
			clearTimeout(timer);
			switch(e.target.innerText){
					case 'Project'    : title_wfunc('group_name'); break;
					case 'Table'      : title_wfunc('tab_hnm'); break;
					case 'Field'      : title_wfunc('fld_hnm'); break;
					case 'Type'       : title_wfunc('fld_type'); break;
					default           : title_wfunc(''); break;
			}
		});

		$('table.floating-thead').each(function() {
			if( $(this).css('border-collapse') == 'collapse') {
			  $(this).css('border-collapse','separate').css('border-spacing',0);
			}
			$(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') );
		});
		$(window).scroll(function() {
			var scrollTop = $(window).scrollTop(),
			scrollLeft = $(window).scrollLeft();
			$('table.floating-thead').each(function(i) {
				var thead = $(this).find('thead:last'),
				clone = $(this).find('thead:first'),
				top = $(this).offset().top,
				bottom = top + $(this).height() - thead.height();
				if( scrollTop < top || scrollTop > bottom ) {
					clone.hide();
					return true;
				}
				if( clone.is('visible') ) return true;
				clone.find('th').each(function(i) {
					$(this).width( thead.find('th').eq(i).width() );
				});
				clone.css("margin-left", -scrollLeft ).width( thead.width() ).show();
			});
		});
	});

	function call_pg_select( hnm, type, len, no, memo ) {
		eval ( "parent.window.opener.document.insert['fld_hnm[" + no + "]'].value=hnm");
		eval ( "parent.window.opener.document.insert['fld_type[" + no + "]'].value=type");
		eval ( "parent.window.opener.document.insert['fld_len[" + no + "]'].value=len");
		eval ( "parent.window.opener.document.insert['memo[" + no + "]'].value=memo");
			window.close();
	}
	function doSubmit(){
		document.xpg_select.submit();
	}
	function group_code_change_func(cd){
		index=document.xpg_select.group_code.selectedIndex;
		nm = document.xpg_select.group_code.options[index].text;
		document.xpg_select.mode.value='Search_Project';
		document.xpg_select.tab_hnmS.value='';
		document.xpg_select.group_name.value=nm;
		document.xpg_select.action="fld_select.php";
		document.xpg_select.target='_self';
		document.xpg_select.submit();
	}
	function change_table_func(pnmS){ // Relation_Table_func
		document.xpg_select.mode.value="SearchTAB";
		document.xpg_select.action="fld_select.php";
		document.xpg_select.submit();
	}
	function page_func( page, data ){
		document.xpg_select.mode.value		='';
		document.xpg_select.search_data.value		=data;
		document.xpg_select.page.value		=page;
		document.xpg_select.action		="fld_select.php";
		document.xpg_select.target='_self';
		document.xpg_select.submit();
	}
	function Change_line_cnt( $line){
		document.xpg_select.page.value = 1;
		document.xpg_select.line_cnt.value = $line;
		document.xpg_select.action='fld_select.php';
		document.xpg_select.target='_self';
		document.xpg_select.submit();
	}
	function title_wfunc(fld_code){       
		document.xpg_select.page.value = 1;
		document.xpg_select.fld_code.value= fld_code;
		document.xpg_select.fld_code_asc.value= 'desc';
		document.xpg_select.mode.value='title_wfunc';
		document.xpg_select.target='_self';
		document.xpg_select.action='fld_select.php';
		document.xpg_select.submit();                         
	} 
	function title_func(fld_code){       
		document.xpg_select.page.value = 1;                
		document.xpg_select.fld_code.value= fld_code;           
		document.xpg_select.fld_code_asc.value= 'asc';
		document.xpg_select.mode.value='title_func';           
		document.xpg_select.target='_self';
		document.xpg_select.action='fld_select.php';
		document.xpg_select.submit();                         
	} 
-->
</script>


<?php
	if( isset($_POST['mode']) && $_POST['mode']!='' ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['group_code']) && $_POST['group_code']!='' ) $group_code = $_POST['group_code'];
	else $group_code = '';

	if( isset($_POST['tab_hnmS']) && $_POST['tab_hnmS'] !='' ) {
		$tab_hnmS =$_POST['tab_hnmS'];
		$tab_R = explode(":", $tab_hnmS);
		$tab_enm = $tab_R[0];
		$tab_hnm = $tab_R[1];
	} else {
		$tab_hnmS = '';
		$tab_enm = '';
		$tab_hnm = '';
	}
	if( isset($_POST['param']) && $_POST['param']!='' ) $param = $_POST['param'];
	else $param = '';
	if( isset($_POST['sel']) && $_POST['sel']!='' ) $sel = $_POST['sel'];
	else $sel = '';
	if( isset($_POST['search_data']) && $_POST['search_data']!='' ) $search_data = $_POST['search_data'];
	else $search_data = '';

	if( isset($_POST['no']) && $_POST['no']!='' ) $no = $_POST['no'];
	else if( isset($_REQUEST['no']) && $_REQUEST['no']!='' ) $no = $_REQUEST['no'];
	else $no = '';

	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10;
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;
	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';
	if( isset( $_POST['fld_code_asc']) ) $fld_code_asc= $_POST['fld_code_asc'];
	else $fld_code_asc = '';
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

<body marginwidth='0' marginheight='0' leftmargin='0' topmargin='0' bgcolor='black'>
<table width="700" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="600" colspan='3'>
	<form name="xpg_select" method="post" action="fld_select.php">	
		<input type="hidden" name="no" value='<?=$no?>' >
		<input type="hidden" name="type" value='' >
		<!-- <input type='hidden' name='g_name'> -->
		<input type='hidden' name='group_name'>
		<input type='hidden' name='mode'>
		<input type='hidden' name='page'    value="<?=$page?>">
		<input type="hidden" name='fld_code'     value='<?=$fld_code?>' />
		<input type="hidden" name='fld_code_asc' value='<?=$fld_code_asc?>' />
<center>
		<div>
		<span>
		<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered.' "; ?> >
			<option value=''>Project</option>
<?php
			$result = sql_query( "SELECT * from {$tkher['table10_group_table']} where userid='$H_ID' order by group_name " );
			while($rs = sql_fetch_array($result)) {
				$chk = '';
				if( $rs['group_code']==$group_code) $chk =' selected ';
?>
				<option value='<?=$rs['group_code']?>' <?php echo $chk; ?>><?=$rs['group_name']?></option>
<?php
			}
?>
		</select>
		</span>

		<span bgcolor='#ffffff'>
		<SELECT id='tab_hnmS' name='tab_hnmS' onchange="change_table_func(this.value);" style='width:250px;height:30px;background-color:#FFDF6E;border:1 solid black' >
<?php
		if( $mode =='SearchTAB') echo "<option value='$tab_hnmS' selected >$tab_hnm</option>";
		else echo "<option value=''>2.Select Table</option>";
		$sql = "SELECT * from {$tkher['table10_table']} ";
		if( $group_code !='' ) {
			$sql = $sql . " where group_code='$group_code' and userid='$H_ID' and fld_enm='seqno' order by upday desc";
		} else {
			$sql = $sql . " where userid='$H_ID' and fld_enm='seqno' order by upday desc";
		}
		$result = sql_query( $sql );
		while( $rs = sql_fetch_array($result)) {
?>
				<option value="<?=$rs['tab_enm']?>:<?=$rs['tab_hnm']?>:<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php if($rs['tab_hnm']==$tab_hnm) echo " selected "; ?> title='table code:<?=$rs['tab_enm']?>'><?=$rs['tab_hnm']?></option>
<?php
		}
?>
		</SELECT>
		</span>
		</div>




<?php
	$ls = "SELECT * FROM {$tkher['table10_table']} ";
	$Where = " where fld_enm!='seqno' ";
	if( $group_code !='') $Where = $Where . " and group_code='$group_code' ";
	if( $tab_hnm !='') $Where = $Where . " and tab_hnm='$tab_hnm' ";
	if( $search_data !='') {
		if( $sel == '=') $Where = $Where . " and fld_hnm='$search_data' ";
		else if( $sel == 'like') $Where = $Where . " and fld_hnm like '%".$search_data."%' ";
	}
	$Order = " order by fld_hnm, upday desc ";
	$ls = $ls . $Where . $Order;

	$resultT	= sql_query( $ls );
	$total = sql_num_rows( $resultT );
	$total_page = intval(($total-1) / $line_cnt)+1;
	if( $page>1) $first = ($page-1) * (INT)$line_cnt; 
	else $first =0;
	$last = $line_cnt;
	if( $total < $last) $last = $total;
	$limit = " limit $first, $last ";
	/*if( $page == 1){
		$tno = $total;
	} else {
		if( $page>1) $tno = $total - ($page - 1) * $line_cnt;
		else $tno = $total;
	}*/


	//if( $search_data !='')
	//		echo "<option value='$param' >Column Name</option>";
	//else	echo "<option value='fld_hnm' selected >Column Name</option>";
?>
		<div>
			<select name="param" style="background-color:gray;color:white;height:24;">
				<option value="fld_hnm"    style="background-color:gray;color:white;">Column Name</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="=" <?php if( $sel=='=') echo " selected ";?> >=</option>
				<option value="like" <?php if( $sel=='like') echo " selected ";?> >Like</option>
			</select>
			<input type="text" name="search_data" size="20" maxlength="20" value='<?=$search_data?>'>
			<input type='button' value='Search' onclick="javascript:doSubmit();" >
		</div>


	<!-- </form> -->
  </td>
</tr>
</table>


<span style='color:white;'>
View Line: 
	<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
		<option value='10'  <?php if( $line_cnt=='10')  echo " selected" ?> >10</option>
		<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
		<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
		<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
	</select>&nbsp;&nbsp;&nbsp;&nbsp; - total:<?=$total?>
</span>

<table class='floating-thead' width='700'>
<thead id='tit_et' width='100%'>
	<tr align='center'>
		<TH>no</TH>

<?php
	echo " <th title='project Sort click or doubleclick' >Project</th> ";
	echo " <th title='Table Sort click or doubleclick' >Table</th> ";
	echo " <th title='Field Sort click or doubleclick' >Field</th> ";
	echo " <th title='Type Sort click or doubleclick' >Type</th> ";
?>
   <!-- <td>Project</td>
   <td>table</td>
   <td>field</td> 
   <td>type</td> -->
   <TH>length</YH>
	</tr>
</thead>
<tbody width="100%">
<?php
	$ls = "SELECT * FROM {$tkher['table10_table']} ";
	$Where = " where fld_enm!='seqno' ";
	if( $group_code !='') $Where = $Where . " and group_code='$group_code' ";
	if( $tab_hnm !='') $Where = $Where . " and tab_hnm='$tab_hnm' ";
	if( $search_data !='') {
		if( $sel == '=') $Where = $Where . " and fld_hnm='$search_data' ";
		else if( $sel == 'like') $Where = $Where . " and fld_hnm like '%".$search_data."%' ";
	}
	if( $fld_code!='' ) $Order = " order by $fld_code $fld_code_asc ";    
	else $Order	= " order by fld_hnm, upday desc "; //" ORDER BY upday desc ";
	$ls = $ls . $Where . $Order;
	$ls = $ls . $limit;
	$result = sql_query(  $ls );
	$line=0;
	$i=1;
	while( $rs = sql_fetch_array( $result ) ) {
		$line=$line_cnt*$page + $i - $line_cnt;
            if( $rs['fld_hnm']=='seqno') continue;
			$project_name	= $rs['group_name'];
			$tab_hnm	= $rs['tab_hnm'];
			$fld_hnm	= $rs['fld_hnm'];
			$fld_type	= $rs['fld_type'];
			$fld_len	= $rs['fld_len'];
			$if_type	= $rs['if_type'];
			$if_data	= $rs['if_data'];
			$relation_data= $rs['relation_data']; 
			$memo		= $rs['memo'];
?>
		<tr style='color:white;fontsize:32px;'>
		  <TD><?=$line?></td>
		  <td><?=$project_name?></td>
		  <td><?=$tab_hnm?></td>
		  <td title='if_data:<?=$if_data?>'>
			   <a href="javascript:call_pg_select('<?=$fld_hnm?>','<?=$fld_type?>', '<?=$fld_len?>', '<?=$no?>', '<?=$memo?>' )"><font color='yellow' size='3'><?=$fld_hnm?></a> </td>
		  <td><?=$fld_type?></td>
		  <td><?=$fld_len?></td>
		</tr>
<?php
	$i++;
	}
?>
  </td>
</tr>
<tr align="center">
  <td height="30" colspan='5'>
   <a href="javascript:self.close()">
    <font color='cyan' size='3'>[ * CLOSE * ]</a></td>
</tr>
<!-- </table> -->


</form>
</tbody>
</table>

<table width="100%" bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if( $last_page > $total_page) $last_page = $total_page;
	$prev = $first_page-1;
	if( $page > $page_num)
		echo"<a href='#' title='page:$page, prev:$prev, data:$search_data' onclick=\"page_func('".$prev."','".$search_data."')\" style='font-size:18px;'>[Prev]</a>";
	for( $i = $first_page; $i <= $last_page; $i++){
		if($page == $i) echo" <b>".$i."</b> ";
		else
			echo"<a href='#' title='page:$page, i:$i, data:$search_data' onclick=\"page_func('".$i."','".$search_data."')\" style='font-size:18px;'>[".$i."]</a>";
	}
	$next = $last_page+1;
	if($next <= $total_page)
		echo"<a href='#' title='page:$page, next:$next, data:$search_data' onclick=\"page_func('".$next."','".$search_data."')\" style='font-size:18px;'>[Next]</a>";
?>
	</td>
  </tr>
</table>

</body>
</html>
