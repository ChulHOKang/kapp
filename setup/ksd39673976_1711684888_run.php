<?php 
	include_once('../tkher_start_necessary.php');
	if($_SESSION['mb_level'] < 8) {
		m_("approach error. ---mb_level:".$member['mb_level']);
		echo "<script>window.open( './index.php' , '_self');</script>";
	}
?> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" > 
<TITLE>AppGenerator.net AppGenerator is generator program. Made in Kang ChulHo</TITLE>  
<link rel='shortcut icon' href='./logo25a.jpg'> 
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> 
<meta name='keywords' content='app generator, app maker, appgenerator, app, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> 
<meta name='description' content='app generator, app maker, appgenerator, app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> 
<meta name='robots' content='ALL'> 
</head> 
<script src="//code.jquery.com/jquery.min.js"></script> 
<script> 
$(function () { 
  $('table.listTableT').each(function() { 
    if( $(this).css('border-collapse') == 'collapse') { 
      $(this).css('border-collapse','separate').css('border-spacing',0); 
    } 
    $(this).prepend( $(this).find('thead:first').clone().hide().css('top',0).css('position','fixed') ); 
  }); 
  $(window).scroll(function() { 
    var scrollTop = $(window).scrollTop(), 
      scrollLeft = $(window).scrollLeft(); 
    $('table.listTableT').each(function(i) { 
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
<style>  
*{ font-family:'Noto Sans KR', 'Malgun Gothic', sans-serif;font-size:14px;color:#666;-webkit-overflow-scrolling: touch;letter-spacing:-1px;-webkit-transition:color .5s, background .5s;transition:color .5s, background .5s;}  
html,body,p, input, select, form, label, mark, ul, ul li, ol, ol li, dl, dl dt, dl dd, img, a, table, h1, h2, h3, h4, h5{margin:0;padding:0;}  
img{ border:0; }  
ul, ol{ list-style:none; }  
a{color:#555;text-decoration:none; }  
a:hover{text-decoration:none; }  
table{border:0;border-collapse:collapse;table-layout:fixed;}  
.HeadTitle03AX{  
	display:inline-block;  
	margin:0 1px;  
	height:35px;  
	line-height:35px;  
	padding:0 20px;  
	font-size:25px;  
	background:#d01c27;  
	color:#ffffff;  
	border-radius:5px;  
}  
.btn_bo02T{width:64px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;font-size:14px;background:#d01d27; margin-right: 10px;text-decoration: none;}  
.btn_bo03T{width:84px;height:33px;display:inline-block;line-height:33px;text-align:center;color:#fff;font-size:14px;background:#d01d27; margin-right: 10px;text-decoration: none;}  
.viewHeaderT{width:100%;height:auto;overflow:hidden;position:relative;text-align:left;}  
.viewHeaderT span{left:0;top:12px;font-size:14px;color:#686868;}  
.boardViewT{width:1168px;height:auto;overflow:hidden;margin:0 auto 50px auto;}  
.boardViewX{width:99%;height:auto;overflow:hidden;margin:0 auto 50px auto;}  
.listTableT{width:100%px;text-decoration: none;}  
.listTableT th{word-break:break-all;height:42px;border-top:3px solid #d01c27;font-size:14px;color:#69604f;font-weight:normal;background:#fafafa;border-bottom:1px solid #dedede;}  
.listTableT td{word-break:break-all;height:30px;border-bottom:1px solid #dedede;font-size:14px;color:#69604f;font-weight:normal;}  
.listTableT td a span{font-size:14px;color:#69604f;}  
.listTableT td a .t01{font-size:14px;color:#d01c27;}  
.listTableT span{font-size:18px;color:#171512; vertical-align:baseline; }  
.listTableT .cell01{width:60px;text-align:center;text-decoration: none;}  
.listTableT .cell03{font-size:18px;text-align:center;text-decoration: none;font-weight:bold;}  
.listTableT .cell03X{}  
.listTableT .cell05{width:70px;text-align:center;}  
.listTableT .cell02{width:80px;text-align:center;}  
.listTableT .cell04{width:200px;text-align:center;}  
.listTableT .cell06{width:50px;text-align:center;}  
.paging{margin:20px auto 0 auto;width:100%;height:auto;overflow:hidden;text-align:center;}  
.paging a, .paging span, .paging img{display:inline-block;vertical-align:middle;}  
.paging a{color:#979288;font-size:18px;font-weight:bold;}  
.paging span{color:#979288;font-size:18px;font-weight:bold;}  
.paging a:hover{opacity:1;color:#d01c27;}  
.paging a.on{font-weight:bold;color:#d01c27;}  
.paging a.prev{margin-right:20px;}  
.paging a.next{margin-left:20px;}  
</style>  
 <script type='text/javascript' >                          
	function home_func($pg_code){                       
		document.view_form.page.value = 1;                
		document.view_form.mode='home_func';           
		document.view_form.action='./ksd39673976_1711684888_run.php';                
		document.view_form.submit();                         
	} 
	function Change_Csel3(c_sel){ 
		document.view_form.search_choice.value=c_sel; 
		document.view_form.c_sel3.value=c_sel; 
	} 
	function Change_Csel2(c_sel){ 
		var obj = document.getElementById("c_sel3"); 
		var c = c_sel.split("|"); 
		document.view_form.search_fld.value = c[0]; 
		document.view_form.mode.value = 'search'; 
	} 
	function pg_record_view( seqno ){ 
		document.view_form.seqno.value=seqno; 
		document.view_form.action='ksd39673976_1711684888_view.php?seqno=' + seqno;                
		document.view_form.submit(); 
	} 
	function table_record_write(mode){  
		document.view_form.mode.value = mode;  
		document.view_form.action='./ksd39673976_1711684888_write.php';                
		document.view_form.submit(); 
	} 
	function excel_down(){ 
		document.view_form.mode.value = 'excel_create'; 
		document.view_form.action='excel_download_user.php'; 
		document.view_form.submit(); 
	} 
	function page_move($page){ 
		document.view_form.page.value = $page; 
		document.view_form.action='./ksd39673976_1711684888_run.php'; 
		document.view_form.submit(); 
	} 
function Change_line_cnt($line){ 
		document.view_form.page.value = 1; 
		document.view_form.line_cnt.value = $line; 
		document.view_form.action='./ksd39673976_1711684888_run.php'; 
		document.view_form.submit(); 
	} 
	function search_data(){  
			var c_sel = document.getElementById("c_sel"); 
			i = c_sel.selectedIndex; 
			c_sel = c_sel.options[i].value; 
			var c_sel3 = document.getElementById("c_sel3"); 
			i = c_sel3.selectedIndex; 
			c_sel3 = c_sel3.options[i].value; 
			document.view_form.mode.value = 'SR'; 
			document.view_form.search_fld.value = c_sel; 
			document.view_form.search_choice.value = c_sel3; 
			document.view_form.page.value = 1; 
			document.view_form.action = './ksd39673976_1711684888_run.php' 
			document.view_form.submit(); 
	} 
 </script> 
<?php 
	$c_sel		= $_POST['c_sel']; 
	$c_sel3		= $_POST['c_sel3']; 
	$search_fld	= $_POST['search_fld']; 
	$search_text	= $_POST['search_text']; 
	$search_choice = $_POST['search_choice']; 
	$tab_enm	    = "ksd39673976_1711684888"; 
	$tab_hnm	    = "kapp_table_list"; 
	$table_item_array	= "|k_table_name|k_table_name|CHAR|30@|k_table_link|k_table_link|CHAR|100@|k_date|k_date|DATETIME|20@|memo|memo|TEXT|255@"; 
			$line_cnt	= $_POST['line_cnt'];	 
			if( !$line_cnt  ) $line_cnt	= 10;					 
			$page_num = 10;			// #[1] [2] [3] 갯수  - 10:고정.  
 ?> 
  <body width=100%>                            
  <center>                                           
  			<br>                                       
  			<div style='text-align:center;'>    
  				<P onclick="javascript:home_func('ksd39673976_1711684888')" class='HeadTitle03AX'>kapp_table_list</P>   
  			</div>                   
<?php       
			$tab_enm = 'ksd39673976_1711684888';   
			$SQL1 = "select * from ksd39673976_1711684888 ";   
			if( $mode=='SR' ){   
				if( $search_choice == 'like')		$SQL1 = $SQL1 . " where $search_fld $search_choice '%$search_text%' ";   
				else									$SQL1 = $SQL1 . " where $search_fld $search_choice '$search_text' ";   
			}   
			if ( ($result = sql_query( $SQL1 ) )==false )   
			{   
				printf("Invalid query: %s
", $SQL1);   
				my_msg(" ERROR : Select ksd39673976_1711684888  ");   
				$total_count = 0;   
			} else {   
				$total_count = sql_num_rows($result);   
				if( $total_count ) $total_page  = ceil($total_count / $line_cnt);    
				else $total_page  =1;   
				if ($page < 2) {   
					$page = 1;    
					$start = 0;   
				} else {   
					$start = ($page - 1) * $line_cnt;    
				}   
				$last = $line_cnt;    
				if( $total_count < $last) $last = $total_count;   
			}   
?>               
			<div style='width:99%;'>          
				<div class='viewHeaderT'>          
						<span>appgenerator.net: ksd39673976_1711684888 &nbsp;&nbsp;&nbsp;&nbsp;Total: <strong><?=$total_count?> &nbsp;&nbsp;&nbsp;&nbsp; Page:<?=$page?></strong>          
						&nbsp;&nbsp;&nbsp;&nbsp;          
							<select id='line_cntS' name='line_cntS' onChange='Change_line_cnt(this.options[this.selectedIndex].value)' style='height:20;'>          
								<option value='5'  <?php if($line_cnt=='5' )  echo " selected " ?> >5</option>         
								<option value='10'  <?php if($line_cnt=='10' )  echo " selected " ?> >10</option>      
								<option value='20'  <?php if($line_cnt=='20' )  echo " selected " ?> >20</option>      
								<option value='30'  <?php if($line_cnt=='30' )  echo " selected " ?> >30</option>       
								<option value='50'  <?php if($line_cnt=='50')   echo " selected " ?>  >50</option>      
								<option value='100' <?php if($line_cnt=='100') echo " selected " ?>  >100</option>     
							</select>          
						</span>          
				</div>          
			</div>           
					<form name='view_form' method='post' enctype='multipart/form-data' >    
						<input type='hidden' name='mode'		value='<?=$mode?>' />    
						<input type='hidden' name='seqno'		value='' />    
						<input type='hidden' name='page'		value='<?=$page?>' />    
						<input type='hidden' name='tab_enm'		value='<?=$tab_enm?>' />    
						<input type='hidden' name='tab_hnm'		value='<?=$tab_hnm?>' />    
						<input type='hidden' name='item_array'	value='<?=$item_array?>'>    
						<input type='hidden' name='table_item_array'	value='|k_table_name|k_table_name|CHAR|30@|k_table_link|k_table_link|CHAR|100@|k_date|k_date|DATETIME|20@|memo|memo|TEXT|255@'>    
						<input type='hidden' name='item_cnt'	value='<?=$item_cnt?>'>    
						<input type='hidden' name='list_no'		value='' />    
						<input type='hidden' name='c_sel'		value='<?=$c_sel?>' />    
						<input type='hidden' name='c_sel3'		value='<?=$c_sel3?>' />    
						<input type='hidden' name='pg_code'		value='<?=$pg_code?>' />    
						<input type='hidden' name='search_fld'	value='<?=$search_fld?>' />    
						<input type='hidden' name='search_choice' value='<?=$search_choice?>' />    
						<input type='hidden' name='line_cnt'	value='<?=$line_cnt?>' />    
	<table class='listTableT' width=99%>   
		<thead>   
			<tr>   
				<th style='width:30px; height:100%px;text-align:center;font-weight:bold'>No</th>   
					<th class='cell03'>k_table_name</th>    
					<th class='cell03'>k_table_link</th>    
					<th class='cell03'>k_date</th>    
					<th class='cell03'>memo</th>    
			</tr>   			
		</thead>   				
		<tbody width=100%>   	
<?php    
			$SQL		= "select * from ksd39673976_1711684888 ";  
 			$SQL_limit	= "  limit $start , $last; ";  
			$OrderBy	= " order by seqno desc ";    
			if( $mode == "SR" ){    
				if( $search_choice == 'like' )	$SQL = $SQL . " where $search_fld $search_choice '%$search_text%' ";  
				else							$SQL = $SQL . " where $search_fld $search_choice '$search_text' ";  
			}     
			$SQL = $SQL . $OrderBy . $SQL_limit;    
			if ( ($result = sql_query( $SQL ) )==false )    
			{    
				printf("Record 0 : query: %s
", $SQL);    
			} else {    
				if( $page > 1 ) $no=($page -1) * $line_cnt;    
				else $no=0;    
				while( $row = sql_fetch_array($result)  ) {    
					$no++;    
?>    
					<tr>    
						<td style='width:30px; height:100%px;text-align:center'>    
						 <a href="javascript:pg_record_view('<?=$row["seqno"]?>');" ><?=$no?></a></td>    
				<td class=cell03><a href="javascript:pg_record_view('<?=$row["seqno"]?>');" ><?=$row['k_table_name']?></a></td>     
				<td class=cell03><a href="javascript:pg_record_view('<?=$row["seqno"]?>');" ><?=$row['k_table_link']?></a></td>     
				<td class=cell03><a href="javascript:pg_record_view('<?=$row["seqno"]?>');" ><?=$row['k_date']?></a></td>     
				<td class=cell03><a href="javascript:pg_record_view('<?=$row["seqno"]?>');" ><?=$row['memo']?></a></td>     
					</tr>    
<?php    
				}	//while    
			}    
?>    
		</tbody>    
	</table>				    
			<div class="fl">    
					<table>    
						<tr>    
						<td>    
						<select id='c_sel' name='c_sel' onChange='Change_Csel2(this.options[this.selectedIndex].value)' style='height:30;' >    
						  <option value='k_table_name'     
						<?php if($search_fld == 'k_table_name') echo " selected ";?> >k_table_name</option>";    
						  <option value='k_table_link'     
						<?php if($search_fld == 'k_table_link') echo " selected ";?> >k_table_link</option>";    
						  <option value='k_date'     
						<?php if($search_fld == 'k_date') echo " selected ";?> >k_date</option>";    
						  <option value='memo'     
						<?php if($search_fld == 'memo') echo " selected ";?> >memo</option>";    
						</select></td>    
						<td>    
						<select id='c_sel3' name='c_sel3' onChange='Change_Csel3(this.options[this.selectedIndex].value)' style='height:30;'>    
							<option value='like' <?php if($search_choice=='like' ) echo " selected " ?> >like</option>    
							<option value='=' <?php if($search_choice=='=' ) echo " selected " ?> >=</option>    
							<option value='>' <?php if($search_choice=='>') echo " selected" ?> >></option>    
							<option value='<' <?php if($search_choice=='<') echo " selected" ?> ><</option>    
						</select>    
						</td>    
						<td><input type='text' name='search_text' id='search_text'  value='<?=$search_text?>' style='height:30;' /></td>    
						<td><input type='button' value='Search' onclick="javascript:search_data();" class='btn_bo02T'></td>    
						<td title='tkher_program_data_listDN'>    
							<input type='button' value='Write' onclick="javascript:table_record_write('table_pg70_write');" class='btn_bo02T'></td>    
						<td title='Create and download the data as an Excel file.'>    
							<input type='button' value='Excel Down' onclick="javascript:excel_down();" class='btn_bo03T'></td>    
					</tr>    
					</table>    
					</form>    
			</div>     
<?php    
			pagingA("ksd39673976_1711684888_run.php",$total_count,$page,$line_cnt );      
?>     
</body>    
</html>    
