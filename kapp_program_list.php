<?php
	include_once('./tkher_start_necessary.php');
	/*
	  kapp_program_list.php - program_list3.php copy  : program list A
	  program_pglist.php : program list B
	*/
	$H_ID	= get_session("ss_mb_id");
	$ip = $_SERVER['REMOTE_ADDR'];
	if( $H_ID == '' ) {
		m_("You need to login. ");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$H_LEV=$member['mb_level'];
	connect_count($host_script, $H_ID, 0, $referer);
	if( isset($member['mb_point'])) $H_POINT = $member['mb_point'];
	else $H_POINT = 0;
	$formula_		= "";
	$poptable_		= "";
	$column_all		= "";
	$pop_fld			= "";
	$pop_mvfld		= "";
	$relation_db	= "";
	$rel_mvfld		= "";
	$gita				= "";
	if( isset($_POST['mid']) ) $mid = $_POST['mid'];
	$mid = $H_ID;
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else $page=1;
	if( isset($_POST['pj_code']) && $_POST['pj_code']!='' ) $pj_code = $_POST['pj_code'];
	else $pj_code = "";
	if( isset($_POST['pj_name']) && $_POST['pj_name']!='' ) $pj_name = $_POST['pj_name'];
	else $pj_name = "";
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
<style>
table { border-collapse: collapse; }
/*th { background: #cdefff; height: 32px; } */
th { background: #666fff; color: white; height: 32px; }
th, td { border: 1px solid silver; padding:5px; }
	.container {
		background-color: skyblue;
		display :flex;									/* flex, inline-flex */
		/*flex-direction: row;*/							/* row, row-reverse, column, column-reverse */
		/*flex-wrap: nowrap;*/							/* nowrap, wrap, wrap-reverse */
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
$(function () {
	let timer;
	document.getElementById('tit_et').addEventListener('click', function(e) {
		clearTimeout(timer);
		timer = setTimeout(() => {
			switch(e.target.innerText){
				case 'Project' : title_func('group_name'); break;
				case 'User'    : title_func('userid'); break;
				case 'Program' : title_func('pg_name'); break;
				case 'Table'   : title_func('tab_hnm'); break;
				case 'Date'    : title_func('upday'); break;
				default        : title_func(''); break;
			}
		}, 250);
	});
	document.getElementById('tit_et').addEventListener('dblclick', function(e) {
		clearTimeout(timer);
		switch(e.target.innerText){
				case 'Project' : title_wfunc('group_name'); break;
				case 'User'    : title_wfunc('userid'); break;
				case 'Program' : title_wfunc('pg_name'); break;
				case 'Table'   : title_wfunc('tab_hnm'); break;
				case 'Date'    : title_wfunc('upday'); break;
				default        : title_wfunc(''); break;
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
</script>
<script type="text/javascript" >
	function program_del_funcList2( seqno, pg_name, pg_code, hid, mid ) {
		msg = "Are you sure you want to delete the program " + pg_name +"?";
		if ( window.confirm( msg ) ){
			document.tkher_search.mode.value			="Delete_mode";
			document.tkher_search.seqno.value		=seqno;
			document.tkher_search.pg_code.value	=pg_code;
			document.tkher_search.pg_name.value	=pg_name;
			document.tkher_search.action				="kapp_program_list.php";
			document.tkher_search.target='_self';
			document.tkher_search.submit();
		} else {
			return false;
		}
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.tkher_search.mode.value		="tab_list_pg70";
		document.tkher_search.seqno.value		=seqno;
		document.tkher_search.pg_name.value	=pg_name;
		document.tkher_search.pg_code.value	=pg_code;
		document.tkher_search.action				="./tkher_program_data_list.php";
		document.tkher_search.target				="_blank";
		document.tkher_search.submit();
	}
	function program_upgrade( seqno, pg_code, userid ) {
		document.tkher_search.mode.value		="program_upgrade";
		document.tkher_search.seqno.value		=seqno;
		document.tkher_search.userid.value	=userid;
		document.tkher_search.pg_code.value	=pg_code;
		document.tkher_search.action= "./kapp_pg_Upgrade.php";
		document.tkher_search.target ="_blank";
		document.tkher_search.submit();
	}

	function page_func( page, data ){
		document.tkher_search.mode.value		='';
		document.tkher_search.data.value		=data;
		document.tkher_search.page.value		=page;
		document.tkher_search.action		="kapp_program_list.php";
		document.tkher_search.target='_self';
		document.tkher_search.submit();
	}
	function kproject_func(pj) {
		document.tkher_search.page.value = 1;                
		document.tkher_search.mode.value='Project_search';
		document.tkher_search.pj_code.value=pj;
		Prj = pj.split(':');
		document.tkher_search.pj_code.value= Prj[0];
		document.tkher_search.pj_name.value= Prj[1];
		document.tkher_search.action="kapp_program_list.php";
		document.tkher_search.target='_self';
		document.tkher_search.submit();
	}
	function Change_line_cnt( $line){
		document.tkher_search.page.value = 1;
		document.tkher_search.line_cnt.value = $line;
		document.tkher_search.action='kapp_program_list.php';
		document.tkher_search.target='_self';
		document.tkher_search.submit();
	}
	function search_func(){
		document.tkher_search.page.value = 1;
		document.tkher_search.mode.value = 'Program_Search';
		document.tkher_search.action='kapp_program_list.php';
		document.tkher_search.target='_self';
		document.tkher_search.submit();
	}
	function title_wfunc(fld_code){       
		document.tkher_search.page.value = 1;
		document.tkher_search.fld_code.value= fld_code;
		document.tkher_search.fld_code_asc.value= 'desc';
		document.tkher_search.mode.value='title_wfunc';
		document.tkher_search.target='_self';
		document.tkher_search.action='kapp_program_list.php';
		document.tkher_search.submit();                         
	} 
	function title_func(fld_code){       
		document.tkher_search.page.value = 1;                
		document.tkher_search.fld_code.value= fld_code;           
		document.tkher_search.fld_code_asc.value= 'asc';
		document.tkher_search.mode.value='title_func';           
		document.tkher_search.target='_self';
		document.tkher_search.action='kapp_program_list.php';
		document.tkher_search.submit();                         
	} 
</script>

 <BODY>
 <center>
 <?php
	if( isset($_POST["mode"]) ) $mode		= $_POST["mode"];
	else $mode	 = "";
	if( isset($_POST['param']) && $_POST['param'] !="" ) $param = $_POST['param'];
	else $param = '';
	if( isset($_POST['sel']) && $_POST['sel'] !="" ) $sel = $_POST['sel'];
	else $sel = '';
	if( isset($_POST['data']) && $_POST['data'] !="" ) $data = $_POST['data'];
	else $data = '';
	if( isset($_POST['seqno']) && $_POST['seqno'] !="" ) $seqno = $_POST['seqno'];
	else $seqno = '';
	if( isset($_POST['pg_code']) && $_POST['pg_code'] !="" ) $pg_code = $_POST['pg_code'];
	else $pg_code = '';
	if( isset($_POST['pg_name']) && $_POST['pg_name'] !="" ) $pg_name = $_POST['pg_name'];
	else $pg_name = '';
	if( isset($_POST['tab_hnm']) )  $tab_hnm = $_POST['tab_hnm'];
	else $tab_hnm = "";
	if( isset($_POST['tab_enm']) )  $tab_enm = $_POST['tab_enm'];
	else $tab_enm = "";

	if( $mode == 'Delete_mode' ) { 
		$lsD = " DELETE from {$tkher['table10_pg_table']} ";
		$lsD = $lsD . " where userid='".$H_ID."' and seqno=" . $seqno;
		echo "sql: " . $lsD;
		$reT = sql_query( $lsD );
		if( $reT ) {
			m_( "delete ok pg_name:" . $pg_name . ", pg_code:" . $pg_code);
		} else {
			m_( "delete error pg_name:" . $pg_name . ", pg_code:" . $pg_code);
		}
		$mode='';
	}
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10;

	if( isset($pj_code) &&  $pj_code != "") {
		$lsPJ = " where group_code ='".$pj_code."' ";
		$lsPJand = " and group_code ='".$pj_code."' ";
	} else {
		$lsPJ = " ";
		$lsPJand = " ";
	}
	if( $mode == 'Program_Search' ) {
		if($sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param like '%$data%' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
			$ls = $ls . " and userid= '".$H_ID."' ";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param $sel '$data' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
			$ls = $ls . " and userid= '".$H_ID."' ";
		}
	} else if( $mode=='Project_search' ) {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid= '".$H_ID."'";
		if( $pj_code !='') $ls = $ls . " and group_code= '".$pj_code."' ";

	} else if( isset($data) && $data != "" ) {
		if( $sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param like '%$data%' " ;
			$ls = $ls . " and userid= '".$H_ID."' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
		} else {
			$ls = " SELECT * from {$tkher['table10_pg_table']} ";
			$ls = $ls . " where $param $sel '$data' ";
			$ls = $ls . " and userid= '".$H_ID."' ";
			if( isset($pj_code) && $pj_code !='' ) $ls = $ls . " and group_code= '".$pj_code."'";
		}
   } else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid= '".$H_ID."'";
		if( isset($pj_code ) && $pj_code!='' ) $ls = $ls . " and group_code= '".$pj_code."'";
   }
	$resultT = sql_query( $ls );
	if( $resultT ) {
		$total = sql_num_rows( $resultT );
		$total_page = intval(($total-1) / $line_cnt)+1;
		if( $page > 1) $first = ($page-1)*$line_cnt;
		else $first = 0;
		$last = $line_cnt;
		if( $total < $last) $last = $total;
		$limit = " limit $first, $last ";
		if( $page == 1){
			$no = $total;
		} else {
			$no = $total - ($page - 1) * $line_cnt;
		}
	} else {
		$total = 0;
	}
?>
<h2 title='pg:kapp_program_list'>KAPP Program List(<?=$H_ID?>) - total:<?=$total?></h2>
	<form name="tkher_search" target="_self" method="post" action="kapp_program_list.php"  >
			<input type='hidden' name='mode'    value='<?=$mode?>'>
			<input type='hidden' name='page'    value="<?=$page?>">
			<input type="hidden" name="pg_hnmS" value="<?=$pg_code?>:<?=$pg_name?>">
			<input type="hidden" name='pg_name' value="<?=$pg_name?>">
			<input type="hidden" name="pg_code" value="<?=$pg_code?>" >
			<input type="hidden" name="tab_hnmS" value="<?=$tab_enm?>:<?=$tab_hnm?>">
			<input type='hidden' name='tab_enm' value="<?=$tab_enm?>">
			<input type='hidden' name='tab_hnm' value="<?=$tab_hnm?>">
			<input type='hidden' name='mid'     value="<?=$H_ID?>">
			<input type="hidden" name='pj_name' value="<?=$pj_name?>">
			<input type="hidden" name="pj_code" value="<?=$pj_code?>" >
			<input type="hidden" name="pj_code_check" value="<?=$pj_code_check?>" >
			<input type="hidden" name="data" >
			<input type="hidden" name="seqno" >
			<input type="hidden" name="seqno" >
			<input type="hidden" name="userid" >
			<input type='hidden' name='group_name' >
			<input type="hidden" name='fld_code'     value='<?=$fld_code?>' />
			<input type="hidden" name='fld_code_asc' value='<?=$fld_code_asc?>' />
<?php
		if( $mode == "Search" ) $T_msg = "[ KAPP Program : <b>". $pg_name . "</b> ] - code: <b>" .$pg_code . "</b>";
		else $T_msg = "[ ".$member['mb_id']." ]";
		if( !isset($H_ID) || $H_ID == '' || !$H_ID ) {
			$T_msg = $T_msg . " : " . $ip;
		} else {
			$T_msg = $T_msg . " Point:" . number_format($H_POINT). " : Lev:" . $member['mb_level'];
		}
?>
		<div>
			<SELECT name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="pg_name">Program</option>
				<option value="tab_hnm" style="background-color:gray;color:white;" >Table</option>
				<option value="group_name" style="background-color:gray;color:white;">Project Name</option>
				<option value="userid" style="background-color:gray;color:white;">User</option>
			</select>
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="=" <?php if($sel =='=') echo ' selected ';?> >=</option>
				<option value="like" <?php if($sel =='like') echo ' selected ';?> >Like</option>
			</SELECT>
			<input type="text" name="data" maxlength="30" size="15" value='<?=$data?>'>
			<input type="button" value="Search" onclick='search_func()'>
		</div>
<span title='data print - kapp_program_list'><strong><?=$T_msg?></strong></span>
<br>
<span>
	<SELECT name="kproject" id="kproject" onChange="kproject_func(this.value)" style="background-color:cyan;color:#000;height:24;">
		<option value="">Select Project</option>
<?php
	$sql ="SELECT * from {$tkher['table10_group_table']} where userid ='".$H_ID."'";
	$ret = sql_query($sql);
	while( $rs=sql_fetch_array($ret) ){
		$chk='';
		if( $pj_code == $rs['group_code'] ) $chk = ' selected ';
?>
			<option value="<?=$rs['group_code']?>:<?=$rs['group_name']?>" <?php echo $chk;?> ><?=$rs['group_name']?></option>
<?php } ?>
	</SELECT>
</span>
<span>
View Line: 
	<select id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
		<option value='10'  <?php if( $line_cnt=='10')  echo " selected" ?> >10</option>
		<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
		<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
		<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
	</select>&nbsp;&nbsp;&nbsp;&nbsp; 
</span>

<table class='floating-thead' width="100%">
<thead id='tit_et' width="100%">
	<tr>
	<th>NO</th>
<?php
	echo " <th title='User Sort click or doubleclick' >User</th> ";
	echo " <th title='project Sort click or doubleclick' >Project</th> ";
	echo " <th title='Program Sort click or doubleclick' >Program</th> ";
	echo " <th title='Table Sort click or doubleclick' >Table</th> ";
	echo " <th title='Date Sort click or doubleclick' >Date</th> ";
?>
	<th>Management</th>
	</tr>
</thead>
<tbody width="100%">
 <?php
	$line=0;
	$i=1;
	if( $fld_code!='' ) $OrderBy = " order by $fld_code $fld_code_asc ";    
	else $OrderBy	= " ORDER BY upday desc ";
	$ls = $ls . $OrderBy;
	$ls = $ls . $limit;
	$resultT	= sql_query( $ls );
	while( $rs = sql_fetch_array( $resultT ) ) {
		$line=$line_cnt*$page + $i - $line_cnt;
		$bgcolor = "#eeeeee";
		$mid = $rs['userid'];
		if( $H_ID == $mid) $bcolor ="style='background-color:cyan;'";
		else $bcolor='';
		$if_data = $rs['if_data'];
		$pop_data = $rs['pop_data'];
		$item_all= item_array_func( $rs['item_array'], $rs['if_type'], $rs['if_data'], $rs['pop_data'], $rs['relation_data'] );
		if( $pop_fld && $pop_mvfld )	$attr = $pop_fld . "<br>" .$pop_mvfld . "<br>" . $gita;
		else if( $pop_fld && !$pop_mvfld )	$attr = $pop_fld . "<br>" . $gita;
		else if( !$pop_fld && $pop_mvfld )	$attr = $pop_mvfld . "<br>" . $gita;
		else if( !$pop_fld && !$pop_mvfld )	$attr = $gita;
		else $attr="";
  ?>
	<input type="hidden" name="pg_codeX[<?=$i?>]" value="<?=$rs['pg_code']?>">
	<TR VALIGN='TOP' bgcolor='<?=$bgcolor?>'>
	<TD <?=$bcolor?> width='1%'><?=$line?></td>
	<TD <?=$bcolor?> width='3%'><?=$rs['userid']?> </td>
	<TD <?=$bcolor?> width='2%' title="project_code: <?=$rs['group_code']?>"><?=$rs['group_name']?></td>
	<TD <?=$bcolor?> width='5%'><img src="<?=KAPP_URL_T_?>/icon/default.gif"><a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" title='program run'><?=$rs['pg_name']?></a></td>
	<td TD <?=$bcolor?> width='5%' title='Data List program run'>
		<a href="javascript:program_run_funcList2( '<?=$rs['seqno']?>', '<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>' );" ><?=$rs['tab_hnm']?></a>
	</td>
	<TD <?=$bcolor?> width='5%'><?=substr($rs['upday'], 0,10)?></td>
	<TD <?=$bcolor?> width='15%' align='center'>
	<input type='button' onclick="program_run_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>')"  value='DataList' style='height:22px;width:66px;background-color:cyan;color:black;border-radius:20px;border:1 solid black'  <?php echo "title=' Data List of ".$rs['pg_name']."' ";?>>
<?php if( $H_ID == $rs['userid'] ) { ?>
	<input type='button' onclick="program_del_funcList2('<?=$rs['seqno']?>','<?=$rs['pg_name']?>', '<?=$rs['pg_code']?>', '<?=$H_ID?>', '<?=$rs['userid']?>')" value='Delete' style='height:22px;width:60px;background-color:red;color:white;border-radius:20px;border:1 solid black'  <?php echo "title=' Delete of ".$rs['pg_name']."' ";?>>
	&nbsp;
	<input type='button' onclick="program_upgrade('<?=$rs['seqno']?>','<?=$rs['pg_code']?>','<?=$rs['userid']?>')" value=' Upgrade ' style='height:22px;width:69px;background-color:red;color:yellow;border-radius:20px;border:1 solid black'  <?php echo "title=' Upgrade of ".$rs['pg_name']."' ";?>>
<?php }	?>

	</td>
	</TR>
 <?php
		$i++;
    }
 ?>
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
		echo"<a href='#' title='page:$page, prev:$prev, data:$data' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
	for( $i = $first_page; $i <= $last_page; $i++){
		if($page == $i) echo" <b>".$i."</b> ";
		else
			echo"<a href='#' title='page:$page, i:$i, data:$data' onclick=\"page_func('".$i."','".$data."')\" style='font-size:18px;'>[".$i."]</a>";
	}
	$next = $last_page+1;
	if($next <= $total_page)
		echo"<a href='#' title='page:$page, next:$next, data:$data' onclick=\"page_func('".$next."','".$data."')\" style='font-size:18px;'>[Next]</a>";
?>
	</td>
  </tr>
</table>
</BODY>
</HTML>
