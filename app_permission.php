<?php
	include_once('./tkher_start_necessary.php');
	$H_ID = get_session("ss_mb_id");	
	if( isset($member['mb_level']) ) $H_LEV = $member['mb_level'];
	else $H_LEV = 1;
	$ip = $_SERVER['REMOTE_ADDR'];
	if ( !$H_ID || $H_LEV < 2) {
		m_("Login Please!");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	/*
		app_permission.php : app grant level setting.
		- table10u1_PC.php :  table permission : no use
	*/
?>

<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href= KAPP_URL_T_ . "/logo/land25.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

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
</head>
<body leftmargin="0" topmargin="0">

<script type="text/javascript" src= KAPP_URL_T_ . "/include/js/ui.js"></script>
<script type="text/javascript" src= KAPP_URL_T_ . "/include/js/common.js"></script>
<script type="text/javascript" >
<!--

	function edit_attr_save(aaa, no, num){ 
		p = document.insert_form.App_Page.value;
		//alert('aaa:'+aaa+', no:'+no+', num:'+num+', page:'+p);
		//aaa:0, no:1215, num:dao_1537753861
		var sel_r = eval("document.insert_form.grant_read_" + aaa + ".value");
		//insert_form.grant_read.value;
		var sel_w = eval("document.insert_form.grant_write_" + aaa + ".value");	 	//insert_form.grant_read.value;
		//var memo = eval("document.insert_form.grant_memo_" + aaa + ".value");	 	//insert_form.grant_read.value;
		
		document.insert_form.read_.value = sel_r;
		document.insert_form.write_.value = sel_w;
		document.insert_form.seqno_.value = no;
		//document.insert_form.memo_.value = memo;
		document.insert_form.mode.value = "update_level";

		var res = confirm(" Do you want to save it?");
		if (res) { document.insert_form.submit(); }
	}

	function App_search(){
		var tab_hnm = document.insert_form.data.value;
		//alert('data tab_hnm:'+tab_hnm);
		var tab = document.insert_form.tab_hnmS.value;
		document.insert_form.App_Page.value =1;
		document.insert_form.mode.value='App_search';
		document.insert_form.action="app_permission.php";
		document.insert_form.target='_self'; // .htm
		document.insert_form.submit();
	}

	function page_func( App_Page, data ){

		document.insert_form.mode.value		=''; // App_Page click
		document.insert_form.data.value		=data;
		document.insert_form.App_Page.value=App_Page;
		document.insert_form.action="app_permission.php";
		document.insert_form.target='_self'; // .htm

		document.insert_form.submit();
	}
	function my_data(){
		//alert("-- my"); return;
		document.insert_form.modeMy.value='My_List'; // Table_page click
		document.insert_form.action		="app_permission.php";
		document.insert_form.target='_self'; // .htm
		document.insert_form.submit();
	}
//-->
</script>

<?php
	$w='100%';
	$w2='800';

	$limit_cnt = 15; 
	$page_num = 10; 

	if( isset($_REQUEST['App_Page']) ) $App_Page = $_REQUEST['App_Page'];
	else if( isset($_POST['App_Page']) ) $App_Page = $_POST['App_Page'];
	else $App_Page = 1;

	if( isset($_POST['modeMy']) ) $modeMy = $_POST['modeMy'];
	else $modeMy = "";   

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = "";   

	if( $mode == 'My_List') $my = " userid='".$H_ID."' ";
	else $my ='';

	if( isset($_POST['data']) && $_POST['data'] !=="" ) $data = $_POST['data'];
	else $data = "";   
	if( isset($_POST['sel']) && $_POST['sel'] !=="" ) $sel = $_POST['sel'];
	else $sel = "";   
	if( isset($_POST['param']) && $_POST['param'] !=="" ) $param = $_POST['param'];
	else $param = "";   

	$param ="pg_name";
	//m_("mode:".$mode);
	if( $mode == "update_level") {
		$seqno = $_POST['seqno_'];
		$sel_r = $_POST['read_'];
		$sel_w = $_POST['write_'];
		$query = "update {$tkher['table10_pg_table']} set grant_view='$sel_r', grant_write='$sel_w' where userid='$H_ID' and seqno=$seqno  ";
		$mq = sql_query($query);
		if( $mq ){ echo("<script>alert('App reset complete')</script>");}

		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !=="" && $modeMy == 'My_List') $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
		else if( $data !=="" && $modeMy == '') $ls = $ls . " where $param like '%$data%' ";
		else if( $data =="" && $modeMy == 'My_List') $ls = $ls . " where userid='$H_ID' ";
		else if( $data =="" && $modeMy == '') $ls = $ls . " ";
		else  $ls = $ls . " ";
		$ls = $ls . " ORDER BY upday desc ";

	} else if( $mode == 'App_search' && $data == '') {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " ";
		$ls = $ls . " ORDER BY upday desc ";
	} else if( $modeMy == 'My_List' ) {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !=="") $ls = $ls . " where $param $sel '%$data%' and userid='$H_ID'";
		else if( $data =="") $ls = $ls . " where userid='$H_ID' ";
		else  $ls = $ls . " ";
		$ls = $ls . " ORDER BY upday desc ";

	} else if( $mode == 'App_search' ) {

		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		if( $data !=="" ) $ls = $ls . " where $param $sel '%$data%' ";
		else if( $data =="" ) $ls = $ls . " ";
		else  $ls = $ls . " ";
		$ls = $ls . " ORDER BY upday desc ";

	} else {
		$ls = " SELECT * from {$tkher['table10_pg_table']} ";
		$ls = $ls . " ";
		$ls = $ls . " ORDER BY upday desc ";
	}
	//echo "ls: " . $ls; exit;

	$resultT	= sql_query( $ls );
	$total = sql_num_rows( $resultT );

	if(!$App_Page) $App_Page=1; 
	$total_page = intval(($total-1) / $limit_cnt)+1; 

	$first = ($App_Page-1) * $limit_cnt; 
	$last = $limit_cnt; 

	if($total < $last) $last = $total;
	$limit = " limit $first, $last ";

	if ($App_Page == "1")
		$no = $total;
	else {
		$no = $total - ($App_Page - 1) * $limit_cnt;
	}

?>
<center>
<?php
		//$cur='B'; //include_once "./menu_run.php"; 
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
			<input type="hidden" name="modeMy"	value="<?=$modeMy?>" >
			<input type='hidden' name='App_Page' value="<?=$App_Page?>">
			<input type="hidden" name="tab_hnmS" value=''> <!-- table10i_old.php  -->
			<input type="hidden" name="pg_name" value='<?=$pg_name?>'> 
			<input type="hidden" name="pg_code" value='<?=$pg_code?>' > 
			<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
			<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>

		<div>
			<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="pg_name">App name</option>
			</select> 
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="like">Like</option>
				<option value="=">=</option>
			</select>
			<input type="text" name="data" value='<?=$data?>' maxlength="30" size="15">
			<input type='button' value='Search' onclick="javascript:App_search();" >
		</div>

<!-- <tr>
	<td style='background-color:#f4f4f4;color:blue;' align='center' colspan='7'><?=$T_msg?></td> 
</tr> -->

<span title='my data print - app_permission.php'><strong><a onclick="javascript:my_data();" style="border-style:;background-color:black;color:yellow;height:28;border-radius:20px;"><?=$T_msg?></a></strong></span>

<table class='floating-thead' width='100%' cellspacing="0" cellpadding="0" >
<thead  width='100%'>
      <tr>
        <TH width="2%" height="28" align="center" bgcolor="#EEEEEE" title=''>no</TH>
        <TH width="10%" height="28" align="center" bgcolor="#EEEEEE" title=''>User</TH>
        <TH width="20%" height="28" align="center" bgcolor="#EEEEEE" title=''>Project</TH>
        <TH width="40%" height="28" align="center" bgcolor="#EEEEEE" title=''>App Name</TH>
        <TH width="4%" align="center" bgcolor="#EEEEEE" title='Read permission - Read permission above level'>Grant View</TH>
        <TH width="4%" align="center" bgcolor="#EEEEEE" title='Write permission - Write permission above level'>Grant Write</TH>
        <TH width="10%" align="center" bgcolor="#EEEEEE">Submit</TH>
      </tr>
</thead>

<tbody width='100%'  height='400'>

<?php
    $line=0;
	$i=1;
	if( $mode !== "Search") $ls = $ls . " $limit ";
	//$ls = $ls . " $limit ";
	$resultT = sql_query( $ls );
	while( $rsP = sql_fetch_array( $resultT ) ) { 
		$pg_code = $rsP['pg_code'];
		$pg_name = $rsP['pg_name'];
		$line = $limit_cnt*$App_Page + $i - $limit_cnt;
		$grant_view = $rsP['grant_view'];
		$grant_write = $rsP['grant_write'];
?>
		  <tr>
			<TD><?=$line?></TD>
			<td bgcolor="#FFFFFF" title="user:<?=$rsP['userid']?>, userid:<?=$rsP['userid']?>"><?=$rsP['userid']?></td>
			<td bgcolor="#FFFFFF" title="project code:<?=$rsP['group_code']?>"><?=$rsP['group_name']?></td>
			<td bgcolor="#FFFFFF" title="pg_code:<?=$rsP['pg_code']?>"><?=$rsP['pg_name']?> (<?=$rsP['pg_code']?>)</td>
			<td bgcolor="#FFFFFF" ><select name='grant_read_<?=$i?>' >

				<!-- <option value="7" <?php if($rsP['grant_view']==7) echo "selected"; ?> title='Level:7 higher'>Level:7</option>
				<option value="6" <?php if($rsP['grant_view']==6) echo "selected"; ?> title='Level:6 higher'>Level:6</option>
				<option value="5" <?php if($rsP['grant_view']==5) echo "selected"; ?> title='Level:5 higher'>Level:5</option>
				<option value="4" <?php if($rsP['grant_view']==4) echo "selected"; ?> title='Level:4 higher'>Level:4</option>
				<option value="3" <?php if($rsP['grant_view']==3) echo "selected"; ?> title='Level:3 higher'>Level:3</option>
				<option value="2" <?php if($rsP['grant_view']==2) echo "selected"; ?> title='Level:2 higher'>Level:2</option>
				<option value="1" <?php if($rsP['grant_view']==1 || $rsP['grant_view']==0) echo "selected"; ?>>Level:1</option> -->

				<option value='1' <?php if($grant_view==0||$grant_view==1)  echo " selected"; ?> >Guest</option>
				<option value='2' <?php if($grant_view==2)  echo " selected"; ?> >Member</option>
				<option value='3' <?php if($grant_view==3)  echo " selected"; ?> >For creators only</option>
				<option value='8' <?php if($grant_view==8)  echo " selected"; ?> >Only system manager</option>
			  </select>
			  </td>
			<td bgcolor="#FFFFFF" align="center"><select name="grant_write_<?=$i?>" >

				<!-- <option value="7" <?php if($rsP['grant_write']==7) echo "selected"; ?> title='Level:7 higher'>Level:7</option>
				<option value="6" <?php if($rsP['grant_write']==6) echo "selected"; ?> title='Level:6 higher'>Level:6</option>
				<option value="5" <?php if($rsP['grant_write']==5) echo "selected"; ?> title='Level:5 higher'>Level:5</option>
				<option value="4" <?php if($rsP['grant_write']==4) echo "selected"; ?> title='Level:4 higher'>Level:4</option>
				<option value="3" <?php if($rsP['grant_write']==3) echo "selected"; ?> title='Level:3 higher'>Level:3</option>
				<option value="2" <?php if($rsP['grant_write']==2) echo "selected"; ?> title='Level:2 higher'>Level:2</option>
				<option value="1" <?php if($rsP['grant_write']==1 || $rsP['grant_write']==0) echo "selected";?> >Level:1</option> -->

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
			<input type='button' value='Execution' <?php echo " title='Save Settings' "; ?> border="0" onClick="edit_attr_save(<?=$i?>,'<?=$rsP['seqno']?>','<?=$rsP['pg_name']?>')" style="cursor:hand;" >
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
	if( $mode=='Search' ) {
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$App_Page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		
		echo "<input type='button' value='Data Insert' onclick=\"program_run_funcList('".$pg_name."', '".$pg_code."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data Write of $pg_name' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$pg_name."', '".$pg_code."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of $pg_name' >&nbsp;&nbsp; ";
		echo "<input type='button' value='All DownLoad' onclick=\"tkher_source_create('".$pg_name."', '".$pg_code."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of $pg_name.' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Create table only' onclick=\"Table_source_create('".$pg_name."', '".$pg_code."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Create and download table creation source and data processing program source of $pg_name.' >&nbsp;&nbsp; ";
	} else {
		//$data = $_POST['data'];
		$first_page = intval(($App_Page-1)/$page_num+1)*$page_num-($page_num-1); // $page_num =10
		$last_page = $first_page+($page_num-1);
		if($last_page > $total_page) $last_page = $total_page;
		$prev = $first_page-1;

		if($App_Page > $page_num) 
			echo"<a href='#' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
		for($i = $first_page; $i <= $last_page; $i++)
		{
			if($App_Page == $i) echo" <b>$i</b> "; 
			else 
				echo"<a href='#' onclick=\"page_func('".$i."','".$data."')\" style='font-size:18px;'>[$i]</a>";
		}
		$next = $last_page+1;
		if($next <= $total_page) 
			echo"<a href='#' onclick=\"page_func('".$next."','".$data."')\" style='font-size:18px;'>[Next]</a>";
	}
?>
	</td>
  </tr>
</table>
</body>
</html>
