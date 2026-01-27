<?php
	include_once('./tkher_start_necessary.php');
	/*
		app_permission.php : app grant level setting.
		- table10u1_PC.php :  table permission : no use
	*/
	$H_ID = get_session("ss_mb_id");	
	if ( !$H_ID ) {
		m_("Login Please!");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
	else $H_LEV = 1;
	if( $H_LEV < 2) {
		m_("Login Please!");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
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
		align-content: center;				/* flex-start, flex-end, center, space-between, space-around �ٳѱ� ó���� ���. */
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
<link rel="stylesheet" href= KAPP_URL_T_ . "/include/css/common.css" type="text/css" />
<link rel="stylesheet" href= KAPP_URL_T_ . "/include/css/kancss.css" type="text/css">

<body leftmargin="0" topmargin="0">

<script type="text/javascript" src= KAPP_URL_T_ . "/include/js/ui.js"></script>
<script type="text/javascript" src= KAPP_URL_T_ . "/include/js/common.js"></script>
<script type="text/javascript" >
<!--
	function title_func(fld_code){       
		document.insert_form.App_Page.value = 1;                
		document.insert_form.fld_code.value= fld_code;           
		document.insert_form.mode.value='title_func';           
		document.insert_form.action='app_permission.php';
		document.insert_form.submit();                         
	} 
	function edit_attr_save(aaa, no, num){ 
		p = document.insert_form.App_Page.value;
		var sel_r = eval("document.insert_form.grant_read_" + aaa + ".value");
		var sel_w = eval("document.insert_form.grant_write_" + aaa + ".value");
		document.insert_form.read_.value = sel_r;
		document.insert_form.write_.value = sel_w;
		document.insert_form.seqno_.value = no;
		document.insert_form.mode.value = "update_level";

		var res = confirm(" Do you want to save it?");
		if (res) { document.insert_form.submit(); }
	}

	function App_search(){
		var tab_hnm = document.insert_form.data.value;
		var tab = document.insert_form.tab_hnmS.value;
		document.insert_form.App_Page.value =1;
		document.insert_form.mode.value='App_search';
		document.insert_form.action="app_permission.php";
		document.insert_form.target='_self';
		document.insert_form.submit();
	}

	function page_func( App_Page, data ){
		document.insert_form.mode.value		='';
		document.insert_form.data.value		=data;
		document.insert_form.App_Page.value=App_Page;
		document.insert_form.action="app_permission.php";
		document.insert_form.target='_self';
		document.insert_form.submit();
	}
	function Change_line_cnt( $line){
		document.insert_form.App_Page.value = 1;
		document.insert_form.action='app_permission.php';
		document.insert_form.submit();
	}
	function group_code_change_func(cd){
		index=document.insert_form.group_code.selectedIndex;
		nm = document.insert_form.group_code.options[index].text;
		document.insert_form.mode.value='Search_Project';
		document.insert_form.group_name.value=nm;
		document.insert_form.action="app_permission.php";
		document.insert_form.target='_self';
		document.insert_form.submit();
	}
	function run_func( pg ){
		pg_code = pg;
		document.insert_form.action='./tkher_program_data_list.php';
		document.insert_form.target				="_blank";
		document.insert_form.pg_code.value	=pg_code;
		document.insert_form.submit();
	}
//-->
</script>

<?php
	if( isset($_POST['line_cnt']) && $_POST['line_cnt']!='' ){
		$line_cnt	= $_POST['line_cnt'];
	} else  $line_cnt	= 10;
	$page_num = 10; 

	if( isset( $_POST['fld_code']) ) $fld_code= $_POST['fld_code'];
	else $fld_code = '';

	if( isset($_REQUEST['App_Page']) ) $App_Page = $_REQUEST['App_Page'];
	else if( isset($_POST['App_Page']) ) $App_Page = $_POST['App_Page'];
	else $App_Page = 1;

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";   

	if( $mode == 'My_List') $my = " userid='".$H_ID."' ";
	else $my ='';

	if( isset($_POST['param']) && $_POST['param'] !="" ) $param = $_POST['param'];
	else $param = "";   
	if( isset($_POST['sel']) && $_POST['sel'] !="" ) $sel = $_POST['sel'];
	else $sel = "";   
	if( isset($_POST['data']) && $_POST['data'] !="" ) $data = $_POST['data'];
	else $data = "";   

	if( isset($_POST['group_code']) && $_POST['group_code']!='' ) {
		$group_code = $_POST['group_code'];   
		$wsel = " and group_code = '$group_code' ";
	} else {
		$group_code= '';
		$wsel = '';
	}

	if( $mode == "update_level") {
		$seqno = $_POST['seqno_'];
		$sel_r = $_POST['read_'];
		$sel_w = $_POST['write_'];
		$query = "update {$tkher['table10_pg_table']} set grant_view='$sel_r', grant_write='$sel_w' where userid='$H_ID' and seqno=$seqno  ";
		$mq = sql_query($query);
		if( $mq ){ echo("<script>alert('App reset complete')</script>");}

		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !='' ){
			if( $sel == 'like' ) $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
			else $ls = $ls . " where $param $sel '$data' and userid='$H_ID'";
		} else $ls = $ls . " where userid='$H_ID' ";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;

	} else if( $mode == 'App_search' ) {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !='' ){
			if( $sel == 'like' ) $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
			else $ls = $ls . " where $param $sel '$data' and userid='$H_ID'";
		} else $ls = $ls . " where userid='$H_ID' ";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;

	} else if( $mode == 'Search_Project' && $group_code!='') {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !='' ){
			if( $sel == 'like' ) $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
			else $ls = $ls . " where $param $sel '$data' and userid='$H_ID'";
		} else $ls = $ls . " where userid='$H_ID' ";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;
	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " where userid='$H_ID'";
		if( $wsel!='' ) $ls = $ls . $wsel;
		if( $fld_code!='' ) $OrderBy = " order by $fld_code ";    
		else $OrderBy= " ORDER BY upday desc ";
		$ls = $ls . $OrderBy;
	}
	$resultT	= sql_query( $ls );
	$total = sql_num_rows( $resultT );

	$total_page = intval(($total-1) / $line_cnt)+1; 
	$first = ($App_Page-1) * $line_cnt; 
	$last = $line_cnt; 
	if($total < $last) $last = $total;
	$limit = " limit $first, $last ";
	if( $App_Page == "1") $no = $total;
	else $no = $total - ($App_Page - 1) * $line_cnt;
?>
<center>
<?php
		if( $mode=="Search" ) $T_msg = "[ Set App permissions : ". $pg_name . " ]";
		else $T_msg = "[ Set App permissions ]";
		if( isset($H_ID) ) $T_msg = $T_msg . ", P:" . $member['mb_point']. ", L:" . $member['mb_level'] . "," .$member['mb_email'];
		else $T_msg = $T_msg . " , " . $ip;
?>
	<FORM name="insert_form" Method='post'  enctype="multipart/form-data" >
			<input type="hidden" name="read_"	value="" >
			<input type="hidden" name="write_"	value="" >
			<input type="hidden" name="seqno_"	value="" >
			<input type="hidden" name="memo_"	value="" >
			<input type="hidden" name="mode"	value="<?=$mode?>" >
			<input type='hidden' name='App_Page' value="<?=$App_Page?>">
			<input type="hidden" name="tab_hnmS" value=''>
			<input type="hidden" name="pg_name" value='<?=$pg_name?>'> 
			<input type="hidden" name="pg_code" value='<?=$pg_code?>' > 
			<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
			<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>
			<input type="hidden" name='fld_code' value='<?=$fld_code?>' />
			<input type='hidden' name='group_name' >
		<div>
			<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="pg_name">App name</option>
			</select> 
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="=" <?php if($sel == '=') echo " selected ";?> >=</option>
				<option value="like" <?php if($sel == 'like') echo " selected ";?>>Like</option>
			</select>
			<input type="text" name="data" value='<?=$data?>' maxlength="30" size="15">
			<input type='button' value='Search' onclick="javascript:App_search();" >
		</div>
<span title='kapp permission' style="border-style:;background-color:black;color:yellow;height:28;border-radius:20px;"><strong><?=$T_msg?></strong></span>
<br>
<span>
	<SELECT id='group_code' name='group_code' onchange="group_code_change_func(this.value);" style='height:25px;background-color:#FFDF6E;border:1 solid black' <?php echo "title='Select the classification of the table to be registered.' "; ?> >
		<option value=''>Project</option>
<?php
	$result = sql_query( "SELECT * from {$tkher['table10_group_table']} order by group_name " );
	while($rs = sql_fetch_array($result)) {
		$chk = '';
		if( $rs['group_code']==$group_code) $chk =' selected ';
?>
		<option value='<?=$rs['group_code']?>' <?php echo $chk; ?>><?=$rs['group_name']?></option>
<?php
	}
?>
	</SELECT>
</span>

<span>
View Line: 
<SELECT id='line_cnt' name='line_cnt' onChange="Change_line_cnt(this.options[selectedIndex].value)" style='height:20;'>
	<option value='10'  <?php if( $line_cnt=='10')  echo " selected" ?> >10</option>
	<option value='30'  <?php if( $line_cnt=='30')  echo " selected" ?> >30</option>
	<option value='50'  <?php if( $line_cnt=='50')  echo " selected" ?> >50</option>
	<option value='100' <?php if( $line_cnt=='100') echo " selected" ?> >100</option>
</SELECT>&nbsp;&nbsp;&nbsp;&nbsp; 
</span>

<table class='floating-thead' width='100%' cellspacing="0" cellpadding="0" >
<thead  width='100%'>
      <tr>
        <TH width="2%" height="28" align="center" bgcolor="#EEEEEE" title=''>no</TH>
<?php
	echo " <th title='User Sort click' onclick=title_func('userid')>User</th> ";
	echo " <th title='project Sort click' onclick=title_func('group_name')>Project</th> ";
	echo " <th title='App Name Sort click' onclick=title_func('pg_name')>App Name</th> ";
?>
        <TH width='4%' align='center' bgcolor='#EEEEEE' title='Read permission - Read permission above level'>Grant View</TH>
        <TH width='4%' align='center' bgcolor='#EEEEEE' title='Write permission - Write permission above level'>Grant Write</TH>
        <TH width='10%' align='center' bgcolor='#EEEEEE'>Submit</TH>
      </tr>
</thead>

<tbody width='100%'  height='400'>
<?php
    $line=0;
	$i=1;
	if( $mode != 'Search') $ls = $ls . " $limit ";
	$resultT = sql_query( $ls );
	while( $rsP = sql_fetch_array( $resultT ) ) { 
		$pg_code = $rsP['pg_code'];
		$pg_name = $rsP['pg_name'];
		$line = $line_cnt*$App_Page + $i - $line_cnt;
		$grant_view = $rsP['grant_view'];
		$grant_write = $rsP['grant_write'];
?>
		  <tr>
			<TD><?=$line?></TD>
			<td bgcolor="#FFFFFF" title="user:<?=$rsP['userid']?>, userid:<?=$rsP['userid']?>"><?=$rsP['userid']?></td>
			<td bgcolor="#FFFFFF" title="project code:<?=$rsP['group_code']?>"><?=$rsP['group_name']?></td>
			<td bgcolor="#FFFFFF" title="Click run, pg_code:<?=$rsP['pg_code']?>" ><a onclick="run_func('<?=$pg_code?>')" style='background-color:cyan;color:black;'><?=$rsP['pg_name']?> (<?=$rsP['pg_code']?>) </a></td>
			<td bgcolor="#FFFFFF" >
			<SELECT name='grant_read_<?=$i?>' >
				<option value='1' <?php if($grant_view==0||$grant_view==1)  echo " selected"; ?> >Guest</option>
				<option value='2' <?php if($grant_view==2)  echo " selected"; ?> >Member</option>
				<option value='3' <?php if($grant_view==3)  echo " selected"; ?> >For creators only</option>
				<option value='8' <?php if($grant_view==8)  echo " selected"; ?> >Only system manager</option>
			</select></td>
			<td bgcolor="#FFFFFF" align="center">
			<SELECT name="grant_write_<?=$i?>" >
				<option value='1' <?php if($grant_write==0||$grant_write==1)  echo " selected"; ?> >Guest</option>
				<option value='2' <?php if($grant_write==2)  echo " selected"; ?> >Member</option>
				<option value='3' <?php if($grant_write==3)  echo " selected"; ?> >For creators only</option>
				<option value='8' <?php if($grant_write==8)  echo " selected"; ?> >Only system manager</option>
			</select>
			</td>
			<td bgcolor="#FFFFFF" align="center" width='10%'>
<?php
	if( $H_ID == $rsP['userid'] ){
?>
			<input type='button' value='Execution' <?php echo " title='Read and Write permission settings' "; ?> border="0" onClick="edit_attr_save(<?=$i?>,'<?=$rsP['seqno']?>','<?=$rsP['pg_name']?>')" style="cursor:hand;" >
<?php } ?>
			</td>
		  </tr>
<?php
		$i++;
	}
?>
		  </form>
</tbody>
    </table>

<table width="100%"   bgcolor="#CCCCCC">
  <tr>
    <td align="center" bgcolor="f4f4f4">
<?php
		$first_page = intval(($App_Page-1)/$page_num+1)*$page_num-($page_num-1);
		$last_page = $first_page+($page_num-1);
		if($last_page > $total_page) $last_page = $total_page;
		$prev = $first_page-1;
		if($App_Page > $page_num) 
			echo"<a href='#' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
		for($i = $first_page; $i <= $last_page; $i++){
			if($App_Page == $i) echo" <b>$i</b> "; 
			else echo"<a href='#' onclick=\"page_func('".$i."','".$data."')\" style='font-size:18px;'>[$i]</a>";
		}
		$next = $last_page+1;
		if($next <= $total_page) 
			echo"<a href='#' onclick=\"page_func('".$next."','".$data."')\" style='font-size:18px;'>[Next]</a>";
?>
	</td>
  </tr>
</table>
</body>
</html>
