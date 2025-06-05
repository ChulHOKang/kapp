<?php
	include_once('../tkher_start_necessary.php');

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;

	include "./paging.php";
	include "./infor.php";
	include "./memo_cnt.php"; //memo_count($board,$no)

	$mid = $mf_infor[53];

	if( isset($_POST['view_line'])) $view_line =$_POST['view_line']; 
	else $view_line =2;
	if( isset($_POST['view_count'])) $view_count =$_POST['view_count']; 
	else $view_count =10;
	if( isset($_POST['tot_cnt'])) $tot_cnt =$_POST['tot_cnt']; 
	else $tot_cnt = 20;

	//$img_line = $view_count; //10; // Number of lines to print on one line : image only.
	$limite = $tot_cnt;

	//m_("limite: " . $limite . ", view_line: " . $view_line . ", view_count: " . $view_count);
	//limite: 100, view_line: 2, view_count: 10

	if( isset($_POST['page'])) $page =$_POST['page']; 
	else $page =1;

	$board_name =$mf_infor[2];	//m_("mid:$mid, board_name:$board_name"); //mid:dao, board_name:tkher126
	
	if( isset($_POST['search_choice'])) $search_choice=$_POST["search_choice"]; 
	else $search_choice ='';
	if( isset($_POST['search_text'])) $search_choice=$_POST["search_text"]; 
	else $search_text ='';
	if( $search_choice ){
		if($search_choice=='1'){$query="SELECT * from aboard_" . $mf_infor[2] . " where subject like '%$search_text%' order by target desc , step";}
		if($search_choice=='2'){$query="SELECT * from aboard_" . $mf_infor[2] . " where context like '%$search_text%' order by target desc , step";}
		if($search_choice=='3'){$query="SELECT * from aboard_" . $mf_infor[2] . " where name='$search_text' order by target desc , step";}
	} else {
		$query="SELECT * from aboard_" . $mf_infor[2] . " order by target desc , step";
	}
	//$size = $mf_infor[16];

	$page_num = 10; 
	$mq =sql_query($query);
	if( $mq ) {
		$total = sql_num_rows($mq);
		if( !$page ) $page =1; 
		$total_page = intval(($total-1) / $limite)+1; 
		$first = ($page-1)*$limite; 
		$last = $limite; 
		if( $total < $last) $last = $total;
		$limit = " limit $first,$last";
	}
	$now = time();	
?>
<!-- 44:top_html -->
<?=$mf_infor[44]?>

<script>
	function openpage(url){
		newwin=window.open(url,"new","width=190,height=20,scrollbars=no");
		}
	function text(){
		window.status=("");
	}
	function check(x){
		if(x.search_text.value==''){
			alert('No query found. ');
			x.search_text.focus();
			return false;
		}
		else{return true;}
		
	}
	function admin_func(lev, infor) {
		if( lev > 1){
			document.list_form.infor.value=infor;
			document.list_form.action="insert1.php";
			document.list_form.target='_blank';
			document.list_form.submit();
		} else {
			alert("login please");
			return false;
		}
	}
	function view_detail(lev, list_no,infor,page,search_text,del_admin ){
			view_lev = document.list_form.view_lev.value; //alert(" view_lev : " + view_lev);
		if( view_lev < 2 || lev > 1 ){
			document.list_form.no.value      =list_no;
			document.list_form.list_no.value =list_no;
			document.list_form.infor.value   = infor;
			document.list_form.page.value    = page;
			document.list_form.search_text.value = search_text;
			document.list_form.action = 'list1_detail.php';
			document.list_form.submit();
		} else {
			alert("login please - view_detail");
			return false;
		}
	}
	//function page_move($page){
	function Xpage_move($page, $line, $count, $tot_cnt){
		document.list_form.view_line.value = $line;
		document.list_form.view_count.value = $count;
		document.list_form.tot_cnt.value    = $tot_cnt;
		document.list_form.page.value = $page;
		document.list_form.action='list1.php';
		document.list_form.submit();
	}
	function page_move($page){
		document.list_form.page.value = $page;
		document.list_form.action='list1.php';
		document.list_form.submit();
	}
	function Change_view_count( $count, $page, $line ){ //this.options[selectedIndex].value
		document.list_form.page.value = 1;//$page;
		document.list_form.view_line.value = $line;
		document.list_form.view_count.value = $count;
		var $tot_cnt = $line * $count;
		document.list_form.tot_cnt.value = $tot_cnt;
		document.list_form.action='list1.php';
		document.list_form.submit();
	}
	function Change_view_line( $line, $page, $count ){ //this.options[selectedIndex].value

		var Index = list_form.view_lineS.selectedIndex;
		lineA = list_form.view_lineS[Index].value;
		document.list_form.page.value = 1;//$page;
		document.list_form.view_line.value = $line;
		document.list_form.view_count.value = $count;
		var $tot_cnt = $line * $count;
		document.list_form.tot_cnt.value = $tot_cnt;

		document.list_form.action='list1.php';
		document.list_form.submit();
	}
</script>

<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/board_new.png">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/include/css/default.css" type="text/css" />
<body>
<center>
<?php
	$cur='B';
	include "../menu_run.php";
?>
<form name='list_form' method='post'>
	<input type='hidden' name='target' >
	<input type='hidden' name='search_text' value="<?=$search_text?>" >
	<input type='hidden' name='page' >
	<input type='hidden' name='infor' value="<?=$infor?>">
	<input type='hidden' name='list_no' >
	<input type='hidden' name='no' >
	<input type='hidden' name='view_lev' value="<?=$mf_array['grant_view']?>" >
	<input type='hidden' name='view_count' value="<?=$view_count?>" >
	<input type='hidden' name='view_line'  value="<?=$view_line?>" >
	<input type='hidden' name='tot_cnt'    value="<?=$tot_cnt?>" >

		<table width="800" border="0" cellspacing="0" cellpadding="0">
    			<tr>
      			<td align="center"> 
  			<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
    				<tr>
      				<td align="center" bgcolor="#FFFFFF" align='center'> 
        			<br>
        			<table width="100%" border="0" cellspacing="1" cellpadding="1">
          				<tr> 
            				<td valign="top" align="left">
	 
 					<table border='0' cellspacing='0' cellpadding='5' width='100%' bgcolor='Silver'>
    						<tr> 
      						<td height='22'><font color="#FFFFFF"><?=$mf_infor[1]?></font></td>
    						</tr>

					
					<div><!--  class="fl" fr -->
						<span>Total: <strong><?=$total?></strong>, 
						&nbsp;view line : <select id='view_lineS' name='view_lineS' onChange="Change_view_line(this.options[selectedIndex].value, <?=$page?>, <?=$view_count?>)" style='height:20;'>
								<option value='1'  <?php if($view_line=='1' )  echo " selected " ?> >1</option>
								<option value='2'  <?php if($view_line=='2' )  echo " selected " ?> >2</option>
								<option value='3'  <?php if($view_line=='3' )  echo " selected " ?> >3</option>
								<option value='5'  <?php if($view_line=='5')   echo " selected" ?>  >5</option>
								<option value='10' <?php if($view_line=='10')  echo " selected" ?>  >10</option>
							</select>
							&nbsp;, view count : <select id='view_countS' name='view_countS' onChange="Change_view_count(this.options[selectedIndex].value, <?=$page?>, <?=$view_line?>)" style='height:20;'>
								<option value='2'  <?php if($view_count=='2' )  echo " selected " ?> >2</option>
								<option value='3'  <?php if($view_count=='3' )  echo " selected " ?> >3</option>
								<option value='5'  <?php if($view_count=='5' )  echo " selected " ?> >5</option>
								<option value='10' <?php if($view_count=='10' ) echo " selected " ?> >10</option>
								<option value='15' <?php if($view_count=='15')  echo " selected" ?>  >15</option>
							</select>
						</span>
					</div>
</form>
					
					</table>
  					<table width='100%' <?=$mf_infor[11]?>>
		<form name='while_form' method='post'>
					<tr>
					<td>
<?php //관리자 아이콘표시
if( isset($_REQUEST['del_admin']) ) $del_admin = $_REQUEST['del_admin'];
else $del_admin = '';

if( !$del_admin ){
	echo "<a href=\"javascript:admin_func('$H_LEV', '" . $infor . "')\")>Insert</a>"; //<img src='$mf_infor[41]' border=0>
}
?>
						</td>
						</td>
    						<tr>
      						<td width="100%" height="1" align="center" colspan="<?=$view_count?>"></td>
    						</tr>    						
    						<tr>
      						<td width="100%" height="1" bgcolor="#c0c0c0" align="center" colspan="<?=$view_count?>"></td>
    						</tr>
<?php 
$cnt=0;	$j=0; $dep=""; $file=""; $new=""; $memo_cnt="";
$ls = "SELECT * from aboard_" . $mf_infor[2] . " where subject like '%$search_text%' order by target desc , step";
$ls = $ls . " $limit ";
$mq = sql_query( $ls );

while( $mf = sql_fetch_row( $mq ) ){
	if( !$cnt ){ $cnt=1; }
	$j++;
	//$date = strftime("%m/%d", $mf[4]);
	//글자르기//	$mf[3]=Shorten_String($mf[3],"45","...");
	$mf[3] = iconv_substr($mf[3], 0, 45, 'utf-8');// . "...";
	//답변들여쓰기
	for( $i=0;$i<$mf[6];$i++){ $dep = $dep . "&nbsp;&nbsp;"; }
	//메모글 카운트
	if( $mf_infor[5]){ $memo_cnt =memo_count($mf_infor[2],$mf[0]);} // memo_cnt.php
	//파일이미지 삽입
	//include "./inc/file_image.php";
	//new 이미지삽입
	$today =$now - $mf[7]; // 4 -7
	if( $today <= 86400){$new="<img src='$mf_infor[38]' border=0>";}
	//검색어 표시
	if( $search_text){ $mf[3] = preg_replace("($search_text)","<font color=blue>\\1</font>",$mf[3]); }
	$msg_=iconv_substr($mf[9], 0, 20, 'utf-8');// . "..."; // author	//Shorten_String( $mf[9],"20","...");	// author
?>
      		<td width="8%" height="20" align="center" bgcolor="<?=$mf_infor[14]?>" title='<?=$msg_?>'>
			<img onclick="view_detail('<?=$H_LEV?>','<?=$mf[0]?>','<?=$infor?>','<?=$page?>','<?=$search_text?>','<?=$del_admin?>');" src="../file/<?=$mid?>/aboard_<?=$board_name?>/<?=$mf[12]?>" border='0' width='50' height='50'  
			 title='<?=$mf[12]?>:<?=$msg_?>' >
			</td>
<?php
			if( $j == $view_count) {
				$j = 0;
				echo "</tr><tr>";
			}
	if( $cnt == $limite){ break; } //$size
	$cnt++; $dep="";$file="";$new="";$memo_cnt="";
} // while
?>
							<input type='hidden' name='del_admin' value='1'>
							<input type='hidden' name='infor' value='<?=$infor?>'>
		</form>
						<tr>
							<td height="1" bgcolor="#ffffff" align="center" colspan="<?=$view_count?>"></td>
   						</tr>
   						<tr>
			<form name='form' action='list1.php' method='post' onsubmit='return check(this)'>

      						<td height="12" colspan="<?=$view_count?>">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" height="1">
								<tr>
										<td width="60%">
		<?php
			$link = "list1.php?infor=$infor&search_choice=$search_choice&search_text=$search_text&del_admin=$del_admin";
			paging($link, $total, $page, $limite, $page_num, $view_line, $view_count);
		?>
										</td>
										<td width="40%" align="right">
										<table border="0" cellpadding="0" cellspacing="0" width="200" id="AutoNumber2">
											<tr>
											<td width="22%">                
											<select size="1" name="search_choice" >
											<option value='1'>subject</option>
											<option value='2'>context</option>
											<!--<option value='3'>name</option>-->
											</select>
											</td>
											<td width="30%">
											<input type="text" name="search_text" size="5" style='border:1 black solid;'>
											<input type='hidden' name='search' value=1>
											<input type='hidden' name='infor' value=<?=$infor?>>
											</td>
											<td width="32%" align=left><input type="image" src='<?=KAPP_URL_T_?>/icon/<?=$mf_infor[36]?>'></td>
											</tr>
										</table>
										</td>
									</tr>
			</form>
								</table>
      						</td>
    					</tr>
						<tr>
						<td  align=right height="30" colspan="<?=$view_count?>">
<?php
	if( $H_LEV > 7 or $mf_infor[53] == $H_ID ){ //34: e_list.gif, 41: e_admin.gif, 53: solpakan_naver
?>
        <a href='update.php?no=<?=$infor?>' target='_blank'>
        <img src='<?=KAPP_URL_T_?>/icon/<?=$mf_infor[41]?>' width='30' border='0' target='_blank'></a>
<?php
	}
?>
							<?php if( $search_choice){ ?>
							<a href='list1.php?infor=<?=$infor?>'><img src='<?=KAPP_URL_T_?>/icon/<?=$mf_infor[34]?>' border='0' title="list" ></a>
							<?php } ?>
						<?php if($H_ID == $mid || $mf_array['grant_write'] == 1 || $mf_array['grant_write'] < $H_LEV) { ?>
							<a href='insert1.php?infor=<?=$infor?>'><img src='<?=KAPP_URL_T_?>/icon/<?=$mf_infor[30]?>' border='0' title="write" ></a></td>
						<?php } ?>      							
						</tr>
  					</table>
        	<!-- End of Paging Table --> 
    					</td>
  					</tr>  
				</table>
<?php
//echo "<br> 45: " . $mf_infor[45];
?>
