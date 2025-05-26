<?php
	include_once('../tkher_start_necessary.php');

	$ss_mb_id= get_session("ss_mb_id");
	$H_ID= $ss_mb_id;	$H_LEV	= $member['mb_level'];  $ip = $_SERVER['REMOTE_ADDR'];
	$from_session_id = $H_ID;

	include "./paging.php";
	include "./string.php";
	include "./infor.php";
	include "./memo_cnt.php"; //memo_count($board,$no)
	/*
		list1.php : image type board
		 - insert1.php : query_ok_new.php
		 - list1_detail.php
		$img_line=7; // Number of lines to print on one line : image only.

	*/
	$img_line=10; // Number of lines to print on one line : image only.

	$mid = $mf_infor[53];
	$board_name=$mf_infor[2];
	//m_("mid:$mid, board_name:$board_name"); //mid:dao, board_name:tkher126
	if($search_choice){
		if($search_choice=='1'){$query="SELECT * from aboard_" . $mf_infor[2] . " where subject like '%$search_text%' order by target desc , step";}
		if($search_choice=='2'){$query="SELECT * from aboard_" . $mf_infor[2] . " where context like '%$search_text%' order by target desc , step";}
		if($search_choice=='3'){$query="SELECT * from aboard_" . $mf_infor[2] . " where name='$search_text' order by target desc , step";}
	} else {
		$query="SELECT * from aboard_" . $mf_infor[2] . " order by target desc , step";
	}
	$mq =sql_query($query);
	if ($mq) { $mn=sql_num_rows($mq); }

	if(!$page){$page=1;}
	$size=$mf_infor[16];
	$now=time();	//m_("infor: " . $infor);
?>
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
	//	alert('No query found. 검색어가 없습니다.');
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
		if( lev > 1){
			document.list_form.no.value      =list_no;
			document.list_form.list_no.value =list_no;
			document.list_form.infor.value   = infor;
			document.list_form.page.value    = page;
			document.list_form.search_text.value = search_text;
			document.list_form.action = 'list1_detail.php';
			document.list_form.submit();
		} else {
			alert("login please");
			return false;
		}
	}

</script>

<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board - App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
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
	<input type='hidden' name='search_text' >
	<input type='hidden' name='page' >
	<input type='hidden' name='infor' >
	<input type='hidden' name='list_no' >
	<input type='hidden' name='no' >

	<!-- <input type='hidden' name='no' >
	<input type='hidden' name='search_choice' >
	<input type='hidden' name='step' >
	<input type='hidden' name='re' >
	<input type='hidden' name='old_no' >
	<input type='hidden' name='mode' > -->

</form>
		<table width="589" border="0" cellspacing="0" cellpadding="0">
    			<tr>
      			<td align="center"> 


  			<table width="565" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC">
    				<tr>
      				<td align="center" bgcolor="#FFFFFF" align=center> 
        			<br>
        			<table width="565" border="0" cellspacing="1" cellpadding="1">
          				<tr> 
            				<td valign="top" align="left">
	 
 					<table border=0 cellspacing=0 cellpadding=5 width=565 bgcolor=Silver>
    						<tr> 
      						<td height=22><font color="#FFFFFF"><?=$mf_infor[1]?></font></td>
    						</tr>
 					</table>

  					<table width='565' <?=$mf_infor[11]?>>

		<form name='while_form' action='query_ok.php' method='post'>
					<tr>
					<td>
<?php //관리자 아이콘표시
if(!$del_admin){
	//echo("<a href=\"javascript:admin_func('$infor')\")>Insert</a>"); //<img src='$mf_infor[41]' border=0>
	echo "<a href=\"javascript:admin_func('$H_LEV', '" . $infor . "')\")>Insert</a>"; //<img src='$mf_infor[41]' border=0>
}
//else{if($del_admin){echo("<input type=hidden name=infor value='$infor'><input type=submit value='삭제' style='border:1 black solid;'>");}}
?>
						</td>
						</td>
<!--
						<td align=right colspan=3>
<?php
if($mf_infor[8]){$url=$PHP_SELF . "?" . $QUERY_STRING;
	if($uid){
	if($amember_sid==$uid){?>
	<a href='../amember/update.php?url=<?=$url?>&aboard_infor=<?=$infor?>' onMouseOver="window.status=(''); return true;" onMouseOut="window.status=(''); return true;"><font size=1 color=<?=$mf_infor[15]?>>Myinfor</a>
	<a href='../amember/query_ok.php?logout=1&url=<?=$url?>&aboard_infor=<?=$infor?>' onMouseOver="window.status=('aboard'); return true;" onMouseOut="window.status=(''); return true;"><font size=1 color=<?=$mf_infor[15]?>>Logout</a>
	<?php } }
	else{?>
	<a href='../amember/insert1.php?url=<?=$url?>&aboard_infor=<?=$infor?>' onMouseOver="window.status=(''); return true;" onMouseOut="window.status=(''); return true;"><font size=1 color=<?=$mf_infor[15]?>>Join</a>
	<a href='../amember/login.php?url=<?=$url?>&aboard_infor=<?=$infor?>' onMouseOver="window.status=(''); return true;" onMouseOut="window.status=(''); return true;"><font size=1 color=<?=$mf_infor[15]?>>Login</a>
	<?php } } ?>
</font>
						</td>
						</tr>
	 -->
    						<tr>
      						<td width="600" height="1" align="center" colspan="<?=$img_line?>"></td>
    						</tr>    						
    						<tr>
      						<td width="600" height="1" bgcolor="#c0c0c0" align="center" colspan="<?=$img_line?>"></td>
    						</tr>
<?php 
$seek=($page*$size)-$size;
//if($mn){mysqli_data_seek($mq,$seek);}
//while( $mf=mysqli_fetch_row($mq)){

//if( function_exists('mysqli_fetch_assoc') && KAPP_MYSQLI_USE )  mysqli_data_seek($mq,$seek);
//else mysql_data_seek( $mq, $seek );
sql_data_seek($mq, $seek);

while( $mf = sql_fetch_row($mq)){
	
	if(!$cnt){$cnt=1;}
	$j++;
	$date=strftime("%m/%d",$mf[4]);
	//글자르기
//	$mf[3]=Shorten_String($mf[3],"45","...");
	$mf[3] = iconv_substr($mf[3], 0, 45, 'utf-8');// . "...";
//	$mf[1]=Shorten_String($mf[1],"4","...");
//	$mf[1] = iconv_substr($mf[1], 0, 45, 'utf-8');// . "...";
	//답변들여쓰기
	for( $i=0;$i<$mf[6];$i++){$dep=$dep . "&nbsp;&nbsp;"; }
	//메모글 카운트
	if( $mf_infor[5]){ $memo_cnt =memo_count($mf_infor[2],$mf[0]);} // memo_cnt.php
	//파일이미지 삽입
	//include "./inc/file_image.php";
	//new 이미지삽입
	$today =$now - $mf[4];
	if( $today <= 86400){$new="<img src='$mf_infor[38]' border=0>";}
	//검색어 표시
	if( $search_text){ $mf[3] = preg_replace("($search_text)","<font color=blue>\\1</font>",$mf[3]); }

	$msg_=iconv_substr($mf[9], 0, 20, 'utf-8');// . "..."; // author	//Shorten_String( $mf[9],"20","...");	// author

?>

      						<td width="8%" height="20" align="center" bgcolor="<?=$mf_infor[14]?>" title='<?=$msg_?>'>
      							<!-- <a href='detail.php?no=<?=$mf[0]?>&infor=<?=$infor?>&page=<?=$page?>&search_choice=<?=$search_choice?>&search_text=<?=$search_text?>' title='<?=$msg_?>'> 
								<img src="../file/<?=$mid?>/aboard_<?=$board_name?>/<?=$mf[12]?>" border='0' width='50' height='50' title='<?=$msg_?>'>
								</a> -->
								<img onclick="view_detail('<?=$H_LEV?>','<?=$mf[0]?>','<?=$infor?>','<?=$page?>','<?=$search_text?>','<?=$del_admin?>');" src="../file/<?=$mid?>/aboard_<?=$board_name?>/<?=$mf[12]?>" border='0' width='50' height='50' title='./file/<?=$mid?>/aboard_<?=$board_name?>/<?=$mf[12]?>:<?=$msg_?>'>
							</td>
							<?php
								if($j == $img_line) {
									$j = 0;
									echo "</tr><tr>";
								}
							?>
        						
<?php
	if( $cnt==$size){ break; }
	$cnt+=1; $dep="";$file="";$new="";$memo_cnt="";
} // while

//m_("=============");
?>
							<input type='hidden' name='del_admin' value='1'>
							<input type='hidden' name='infor' value='<?=$infor?>'>
		</form>

						<tr>
							<td height="1" bgcolor="#ffffff" align="center" colspan="<?=$img_line?>"></td>
   						</tr>
   						<tr>
			<form name='form' action='list1.php' method='post' onsubmit='return check(this)'>

      						<td height="12" colspan="<?=$img_line?>">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" height="1">
								<tr>
										<td width="60%">
		<?php
			paging("list1.php?infor=$infor&search_choice=$search_choice&search_text=$search_text&del_admin=$del_admin",$mn,$page,$size); 
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
											<td width="40%">
											<input type="text" name="search_text" size="15" style='border:1 black solid;'>
											<input type='hidden' name='search' value=1>
											<input type='hidden' name='infor' value=<?=$infor?>>
											</td>
											<td width="32%" align=left><input type="image" src='<?=$mf_infor[36]?>'></td>
											</tr>
										</table>
										</td>
									</tr>
			</form>

								</table>
      						</td>
    					</tr>
						<tr>
						<td  align=right height="30" colspan="<?=$img_line?>">
<?php
	if( $H_LEV > 7 or $mf_infor[53] == $H_ID ){
?>
        <a href='update.php?no=<?=$infor?>' target='_blank'>
        <img src='<?=$mf_infor[41]?>' width='30' border='0' target='_blank'></a>
<?php
	}

	m_("30: " . $mf_infor[30]);
?>
							<?php if( $search_choice){ ?>
							<a href='list1.php?infor=<?=$infor?>'><img src='<?=$mf_infor[34]?>' border='0' title="list" ></a>
							<?php } ?>      							
							<a href='insert1.php?infor=<?=$infor?>'><img src='<?=$mf_infor[30]?>' border='0' title="write" ></a></td>
						</tr>
  					</table>
        	<!-- End of Paging Table --> 
    					</td>
  					</tr>  
				</table>

				
<?php
echo "<br> 45: " . $mf_infor[45];
?>
