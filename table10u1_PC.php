<?php
	include_once('./tkher_start_necessary.php');
	$H_ID	= get_session("ss_mb_id");	
	$H_LEV=$member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	if ( !$H_ID || $H_LEV < 2) {
			//$url= KAPP_URL_T_;//$PHP_SELF;
			//$url= urlencode($url);
			//echo("<meta http-equiv='refresh' content='0; URL=$url'>");
		$url= KAPP_URL_T_;
		echo "<script>window.open( '$url' , '_top', ''); </script>";
		exit;
	}
	/*
		- table10u1_PC.php : table10u1.php copy �۾����� : table ��� ���� ����.
	*/
?>

<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
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
<script type="text/javascript" src= KAPP_URL_T_ . "/include/js/ui.js"></script>
<script type="text/javascript" src= KAPP_URL_T_ . "/include/js/common.js"></script>

<link rel="stylesheet" href= KAPP_URL_T_ . "/include/css/kancss.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0">

<script type="text/javascript" >
<!--

function edit_attr_save(aaa, no, num)
{ 
		p = document.insert_form.Table_page.value;
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

	function table_search(){
		var tab_hnm = document.insert_form.data.value;
		//alert('data tab_hnm:'+tab_hnm);
		var tab = document.insert_form.tab_hnmS.value;
		document.insert_form.Table_page.value =1;
		document.insert_form.mode.value='Table_Search';
		document.insert_form.action="table10u1_PC.php";
		document.insert_form.target='_self'; // .htm
		document.insert_form.submit();
	}

	function page_func( Table_page, data ){

		document.insert_form.mode.value		=''; // Table_page click
		document.insert_form.data.value		=data;
		document.insert_form.Table_page.value=Table_page;
		document.insert_form.action="table10u1_PC.php";
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

	if( isset($_REQUEST['Table_page']) ) $Table_page = $_REQUEST['Table_page'];
	else $Table_page = $_POST['Table_page'];

	$mode = $_POST["mode"];   
	$data = $_POST["data"];   
	//m_("mode:".$mode);
	if ($mode == "update_level") {
		$seqno = $_POST['seqno_'];
		$sel_r = $_POST['read_'];
		$sel_w = $_POST['write_'];
		//$memo = $_POST['memo_'];
		//$query = "update {$tkher['table10_table']} set  grant_view='$sel_r', grant_write='$sel_w', memo='$memo' where userid='$H_ID' and seqno=$seqno  ";
		$query = "update {$tkher['table10_table']} set  grant_view='$sel_r', grant_write='$sel_w' where userid='$H_ID' and seqno=$seqno  ";
		$mq = sql_query($query);
		if( $mq ){ echo("<script>alert('Update Table')</script>");}

		$data  =$_POST['data'];
		$param =$_POST['param'];
		$sel   =$_POST['sel'];
		if($sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where userid='$H_ID' and fld_enm='seqno' and $param like '%$data%' ";
			$ls = $ls . " ORDER BY group_name, $param ";

		} else {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where userid='$H_ID' and fld_enm='seqno' and $param $sel '$data' ";
			$ls = $ls . " ORDER BY group_name, $param ";
		}
	} else if( $mode == 'Table_Search' || isset($data) ) { // .htm ���� �˻�.

		$data  =$_POST['data'];
		$param =$_POST['param'];
		$sel   =$_POST['sel'];
		if($sel == 'like') {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where userid='$H_ID' and fld_enm='seqno' and $param like '%$data%' ";
			$ls = $ls . " ORDER BY group_name, $param ";

		} else {
			$ls = " SELECT * from {$tkher['table10_table']} ";
			$ls = $ls . " where userid='$H_ID' and fld_enm='seqno' and $param $sel '$data' ";
			$ls = $ls . " ORDER group_name, BY $param ";
		}
	} else {
		$ls = " SELECT * from {$tkher['table10_table']} ";
		$ls = $ls . " where userid='$H_ID' and fld_enm='seqno' ";
		//$ls = $ls . " ORDER BY tab_hnm asc, seqno asc ";
		$ls = $ls . " ORDER BY group_name, upday desc ";
	}


	$resultT	= sql_query( $ls );
	$total = sql_num_rows( $resultT );

	if(!$Table_page) $Table_page=1; 
	$total_page = intval(($total-1) / $limit_cnt)+1; 

	$first = ($Table_page-1) * $limit_cnt; 
	$last = $limit_cnt; 

	if($total < $last) $last = $total;
	$limit = " limit $first, $last ";

	if ($Table_page == "1")
		$no = $total;
	else {
		$no = $total - ($Table_page - 1) * $limit_cnt;
	}

?>

<center>
<?php
		$cur='B';
		//include_once "./menu_run.php"; 
?>


<?php

		if( $mode=="Search" ) $T_msg = "[ Set table permissions : ". $tab_hnm . " ]";
		else $T_msg = "[ Set table permissions ]";

		if( isset($H_ID) ) $T_msg = $T_msg . ", P:" . $member['mb_point']. ", L:" . $member['mb_level'] . "," .$member['mb_email'];
		else $T_msg = $T_msg . " , " . $ip;
?>
	<FORM name="insert_form" Method='post'  enctype="multipart/form-data" >

			<input type="hidden" name="read_"	value="" >
			<input type="hidden" name="write_"	value="" >
			<input type="hidden" name="seqno_"	value="" >
			<input type="hidden" name="memo_"	value="" >
			<input type="hidden" name="mode"	value="" >
			<input type='hidden' name='Table_page' value="<?=$_POST['Table_page']?>">
			<input type="hidden" name="tab_hnmS" value=''> <!-- table10i_old.php  -->
			<input type="hidden" name="pg_name" value=''> 
			<input type="hidden" name="pg_code" value='<?=$pg_code?>' > 
			<input type='hidden' name='tab_enm' value='<?=$tab_enm?>'>
			<input type='hidden' name='tab_hnm' value='<?=$tab_hnm?>'>

		<div><center>
			<select name="param" style="border-style:;background-color:gray;color:#ffffff;height:24;">
				<option value="tab_hnm">Table</option>
			</select> 
			<select name="sel" style="border-style:;background-color:cyan;color:#000000;height:24;">
				<option value="like">Like</option>
				<option value="=">=</option>
			</select>
			<input type="text" name="data" value='<?=$data?>' maxlength="30" size="15">
			<input type='button' value='Search' onclick="javascript:table_search();" >
		</div>

<tr>
	<td style='background-color:#f4f4f4;color:blue;' align='center' colspan='7'><?=$T_msg?></td> 
</tr>

<table class='floating-thead' width='100%' cellspacing="0" cellpadding="0" >
<thead  width='100%'>
      <tr>
        <TH width="20" height="28" align="center" bgcolor="#EEEEEE" title=''>no</TH>
        <TH width="120" height="28" align="center" bgcolor="#EEEEEE" title=''>Project</TH>
        <TH width="150" height="28" align="center" bgcolor="#EEEEEE" title=''>Table Name</TH>
        <TH width="130" align="center" bgcolor="#EEEEEE" title='Read permission - Read permission above level'>Read</TH>
        <TH width="130" align="center" bgcolor="#EEEEEE" title='Write permission - Write permission above level'>Write</TH>
        <TH width="50" align="center" bgcolor="#EEEEEE">Confirm</TH>
      </tr>
</thead>

<tbody width='100%'  height='400'>

<?php
    $line=0;
	$i=1;
	if($mode !== "Search") $ls = $ls . " $limit ";
	$resultT	= sql_query( $ls );
	while ( $rsP = sql_fetch_array( $resultT ) ) { 
		$line = $limit_cnt*$Table_page + $i - $limit_cnt;
	
?>
		  <tr>
			<TD><?=$line?></TD>
			<td bgcolor="#FFFFFF" title="user:<?=$rsP['userid']?>, group_code:<?=$rsP['group_code']?>"><?=$rsP['group_name']?></td>
			<td bgcolor="#FFFFFF" title="user:<?=$rsP['userid']?>, table_name:<?=$rsP['tab_enm']?>">&nbsp;&nbsp;<?=$rsP['tab_hnm']?></td>
			<td bgcolor="#FFFFFF" align="center"><select name='grant_read_<?=$i?>' >

				<option value="7" <?php if($rsP['grant_view']=='7') echo "selected"; ?> title='Level:7 higher'>Level:7</option>
				<option value="6" <?php if($rsP['grant_view']=='6') echo "selected"; ?> title='Level:6 higher'>Level:6</option>
				<option value="5" <?php if($rsP['grant_view']=='5') echo "selected"; ?> title='Level:5 higher'>Level:5</option>
				<option value="4" <?php if($rsP['grant_view']=='4') echo "selected"; ?> title='Level:4 higher'>Level:4</option>
				<option value="3" <?php if($rsP['grant_view']=='3') echo "selected"; ?> title='Level:3 higher'>Level:3</option>
				<option value="2" <?php if($rsP['grant_view']=='2') echo "selected"; ?> title='Level:2 higher'>Level:2</option>
				<option value="" <?php if( !$rsP['grant_view'] ) echo "selected"; ?> title='Level:0 higher'>Level:0</option>
			  </select>
			  </td>
			<td bgcolor="#FFFFFF" align="center"><select name="grant_write_<?=$i?>" >

				<option value="7" <?php if($rsP['grant_write']=='7') echo "selected"; ?> title='Level:7 higher'>Level:7</option>
				<option value="6" <?php if($rsP['grant_write']=='6') echo "selected"; ?> title='Level:6 higher'>Level:6</option>
				<option value="5" <?php if($rsP['grant_write']=='5') echo "selected"; ?> title='Level:5 higher'>Level:5</option>
				<option value="4" <?php if($rsP['grant_write']=='4') echo "selected"; ?> title='Level:4 higher'>Level:4</option>
				<option value="3" <?php if($rsP['grant_write']=='3') echo "selected"; ?> title='Level:3 higher'>Level:3</option>
				<option value="2" <?php if($rsP['grant_write']=='2') echo "selected"; ?> title='Level:2 higher'>Level:2</option>
				<option value="" <?php if( !$rsP['grant_write'] ) echo "selected"; ?> title='Level:0 higher'>Level:0</option>
			  </select>
			  </td>
			<td bgcolor="#FFFFFF" align="center" width='10%'>
			<input type='button' value='confirm' <?php echo " title='Save Settings' "; ?> border="0" onClick="edit_attr_save(<?=$i?>,'<?=$rsP['seqno']?>','<?=$rsP['tab_enm']?>')" style="cursor:hand;" ></td>
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
		echo "<input type='button' value='Back Return' onclick=\"javascript:run_back('".$mode."', '".$data."', '".$Table_page."');\" style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Search List of Program'>&nbsp;&nbsp;";
		
		echo "<input type='button' value='Data Insert' onclick=\"program_run_funcList('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data Write of $tab_hnm' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Data List' onclick=\"program_run_funcListT('".$tab_hnm."', '".$tab_enm."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Data List of $tab_hnm' >&nbsp;&nbsp; ";
		echo "<input type='button' value='All DownLoad' onclick=\"tkher_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title='Database and table creation source and data processing program source creation and download of $tab_hnm.' >&nbsp;&nbsp; ";
		echo "<input type='button' value='Create table only' onclick=\"Table_source_create('".$tab_hnm."', '".$tab_enm."', '".$H_POINT."')\"  style='height:22px;background-color:cyan;color:black;border:1 solid black'  title=' Create and download table creation source and data processing program source of $tab_hnm.' >&nbsp;&nbsp; ";
	} else {
		$data = $_POST['data'];
		$first_page = intval(($Table_page-1)/$page_num+1)*$page_num-($page_num-1); // $page_num =10
		$last_page = $first_page+($page_num-1);
		if($last_page > $total_page) $last_page = $total_page;
		$prev = $first_page-1;

		if($Table_page > $page_num) 
			echo"<a href='#' onclick=\"page_func('".$prev."','".$data."')\" style='font-size:18px;'>[Prev]</a>";
		for($i = $first_page; $i <= $last_page; $i++)
		{
			if($Table_page == $i) echo" <b>$i</b> "; 
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
