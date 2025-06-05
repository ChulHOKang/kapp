<?php
	include "./paging.php";
	include "./memo_cnt.php";
	/*
		inc_list1.php : list1.php - list1_detail.php에서 include : image display type 
		$img_line=7; // Number of lines to print on one line : image only.

	*/
	$img_line=10; // Number of lines to print on one line : image only.

	$mid = $mf_infor[53];
	$board_name=$mf_infor[2];

	//m_("mid:$mid, board_name:$board_name"); //mid:dao, board_name:tkher126
	if($search_choice){
		if($search_choice=='1'){ $query="select * from aboard_" . $mf_infor[2] . " where subject like '%$search_text%' order by target desc , step";}
		if($search_choice=='2'){ $query="select * from aboard_" . $mf_infor[2] . " where context like '%$search_text%' order by target desc , step";}
		if($search_choice=='3'){ $query="select * from aboard_" . $mf_infor[2] . " where name='$search_text' order by target desc , step";}
	} else {
		$query="select * from aboard_" . $mf_infor[2] . " order by target desc , step";
	}

	$size   = $mf_infor[16];
	$limite = $mf_infor[16];
	$page_num = 10; 

	$mq = sql_query($query);
	if( $mq){
		$total =sql_num_rows($mq);

		if( !$page ) $page =1; 
		$total_page = intval(($total-1) / $limite)+1; 
		$first = ($page-1)*$limite; 
		$last = $limite; 
		if( $total < $last) $last = $total;
		$limit = " limit $first,$last";
	}

	$now = time();
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
	function admin_func(infor) {
		document.list_form.action="update.php?no="+infor;
		document.list_form.target='_blank';
		document.list_form.submit();
	}
	function view_detail(list_no,infor,page,search_text,del_admin ){
		document.list_form.list_no.value=list_no;
		document.list_form.infor.value = infor;
		document.list_form.page.value = page;
		document.list_form.search_text.value = search_text;
		document.list_form.action='list1_detail.php';
		document.list_form.submit();
	}
	function page_moveD($page){
		document.list_form.page.value = $page;
		document.list_form.action='list1_detail.php';
		document.list_form.submit();
	}

</script>


<center>

<form name='list_form' method='post'>
	<input type='hidden' name='target' >
	<input type='hidden' name='search_text' value="<?=$search_text?>">
	<input type='hidden' name='page' >
	<input type='hidden' name='infor' value="<?=$infor?>">
	<input type='hidden' name='list_no' value="<?=$list_no?>">
	<input type='hidden' name='no' >
	<input type='hidden' name='search_choice' value="<?=$search_choice?>">
	<input type='hidden' name='step' >
	<input type='hidden' name='re' >
	<input type='hidden' name='old_no' >
	<input type='hidden' name='mode' > 
	<input type='hidden' name='view_lev' value="<?=$mf_array['grant_view']?>" >
	<input type='hidden' name='view_count' value="<?=$view_count?>" >
	<input type='hidden' name='view_line'  value="<?=$view_line?>" >
	<input type='hidden' name='tot_cnt'    value="<?=$tot_cnt?>" >
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
					<form action='query_ok_new.php' method='post'>
    						<tr>
      						<td width="600" height="1" align="center" colspan="<?=$img_line?>"></td>
    						</tr>    						
    						<tr>
      						<td width="600" height="1" bgcolor="#c0c0c0" align="center" colspan="<?=$img_line?>"></td>
    						</tr>
<?php 
//$seek=($page*$size)-$size;
if( isset($_REQUEST['del_admin']) ) $del_admin = $_REQUEST['del_admin'];
else $del_admin = '';

$cnt=0;	$j=0; $dep=""; $file=""; $new=""; $memo_cnt="";

$ls = "SELECT * from aboard_" . $mf_infor[2] . " where subject like '%$search_text%' order by target desc , step";
$ls = $ls . " $limit ";
$mq = sql_query( $ls );

while( $mf = sql_fetch_row($mq)){
	
	if(!$cnt){$cnt=1;}
	$j++;
	$date=strftime("%m/%d",intval($mf[4]));
	//글자르기	//	$mf[3]=Shorten_String($mf[3],"45","...");
	$mf[3] = iconv_substr($mf[3], 0, 45, 'utf-8');// . "...";
	//	$mf[1]=Shorten_String($mf[1],"4","...");
	//	$mf[1] = iconv_substr($mf[1], 0, 45, 'utf-8');// . "...";
	//답변들여쓰기
	for($i=0;$i<$mf[6];$i++){$dep=$dep . "&nbsp;&nbsp;";}
	//메모글 카운트
	if($mf_infor[5]){$memo_cnt=memo_count($mf_infor[2],$mf[0]);}
	//파일이미지 삽입	//include "./inc/file_image.php";
	//new 이미지삽입
	$today = $now - intval($mf[4]);
	$bt38 =".".$mf_infor[38];
	if($today <= 86400){$new="<img src='$bt38' border=0>";}
	//검색어 표시
	if($search_text){$mf[3] = preg_replace("($search_text)","<font color=blue>\\1</font>",$mf[3]);}
	$msg_=iconv_substr($mf[9], 0, 20, 'utf-8');//Shorten_String( $mf[9],"20","...");	// author
?>
		<td width="8%" height="20" align="center" bgcolor="<?=$mf_infor[14]?>" title='<?=$msg_?>'>
			<img onclick="view_detail('<?=$mf[0]?>','<?=$infor?>','<?=$page?>','<?=$search_text?>','<?=$del_admin?>');" src="../file/<?=$mid?>/aboard_<?=$board_name?>/<?=$mf[12]?>" border='0' width='50' height='50' title="<?=$mid?>:<?=$board_name?>:<?=$mf[12]?>:<?=$msg_?>">
							</td>
				<?php
								if($j == $img_line) {
									$j = 0;
									echo "</tr><tr>";
								}
				?>
<?php if($cnt==$size){break;}$cnt+=1;$dep="";$file="";$new="";$memo_cnt="";}?>
							<input type='hidden' name='del_admin' value='1'>
							<input type='hidden' name='infor' value='<?=$infor?>'></form>

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
	$link = "list1_detail.php?infor=$infor&search_choice=$search_choice&search_text=$search_text&del_admin=$del_admin";
	pagingD($link, $total, $page, $size, $page_num); // mn: 35 - paging.php set
	//paging("list1.php?infor=$infor&search_choice=$search_choice&search_text=$search_text&del_admin=$del_admin",$total,$page,$size,10);
	//m_("36: " . $mf_infor[36]);//36: search.gif
?>            
										</td>
										<td width="40%" align="right">
										<table border="0" cellpadding="0" cellspacing="0" width="200" id="AutoNumber2">
											<tr>
											<td width="22%">                
										<select size="1" name="search_choice" >
											<option value='1'>subject</option>
											<option value='2'>context</option>
										</select>
											</td>
											<td width="40%">
											<input type="text" name="search_text" size="15" style='border:1 black solid;'>
											<input type='hidden' name='search' value='1'>
											<input type='hidden' name='infor' value='<?=$infor?>'>
											</td><?php $bt36="../icon/".$mf_infor[36];?>
											<td width="32%" align='left'><input type="image" src='<?=$bt36?>'></td>
											</tr>
										</table>
										</td>
									</tr>
			</form>

								</table>
      						</td>
    					</tr>
						<tr>
						<td align='right' height="30" colspan="<?=$img_line?>">
<?php
	if( $H_LEV > 7 or $mf_infor[53] == $H_ID ){
				$bt41="../icon/".$mf_infor[41];
?>
         <a href='update.php?no=<?=$infor?>' target='_blank'>
        <img src='<?=$bt41?>' width='30' border='0' target='_blank'></a>
<?php
	}
			$bt30="../icon/".$mf_infor[30];
			$bt34="../icon/".$mf_infor[34];
?>
						<?php if( $search_choice){ ?>
							<a href='list1.php?infor=<?=$infor?>'><img src='<?=$bt34?>' border='0' title="list" ></a>
						<?php } ?>      							
						<?php if($H_ID == $mid || $mf_array['grant_write'] == 1 || $mf_array['grant_write'] < $H_LEV) { ?>
							<a href='insert1.php?infor=<?=$infor?>'><img src='<?=$bt30?>' border='0' title="write" ></a></td>
						<?php } ?>      							

						</tr>
  					</table>
        	<!-- End of Paging Table --> 
    					</td>
  					</tr>  
				</table>

				
<?=$mf_infor[45]?>
