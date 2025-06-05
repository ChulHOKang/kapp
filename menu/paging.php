<?php
// 	$link : 로드할 URL 주소
// 	$total : 전체 목록수
// 	$page : 현재 페이지
// 	$size : 한페이지에 보여줄 목록수
// 	$page_num , $seek : 목록 열지정
// 	사용예 :  본페이지에서 $size값을 선언해주고
//		$seek=($page*$size)-$size;
//		mysql_data_seek($mq,$seek); 
//		*페이징이 들어갈 위치에서 함수를 호출해 준다.
//		paging($link,$total,$page,$size); 

// list1
function Xpaging_img($link, $total, $page, $size, $page_num, $view_line, $view_count){
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);

	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	// 6을 구하는식
	$last_page = $first_page+($page_num-1);
	if( $last_page > $total_page) $last_page = $total_page;

	echo "<div class='paging'>";
	//처음페이지
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>First</a>");
	} else {
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/b_first_silver.gif' border='0' height='20' title='first'>";
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		echo "<a href='javascript:page_move($back_page)' ><img src='". KAPP_URL_T_ ."/include/img/btn/btn_prev.png' width='20' title='previous'></a>";
	} else {
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/btn_prev.png' width='20' title='Previous'>";
	}
	//페이지 출력
	echo("&nbsp;");
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("&nbsp;<font size=3>$i</font><span>&nbsp;.&nbsp;</span>"); }
		else         { echo("&nbsp;<a href='javascript:page_move($i)'>$i</a><span>&nbsp;.&nbsp;</span>"); }
	}
	//다음페이지
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'><img src='../include/img/btn/btn_next.png' width='20' title='B Next Page'></a>");
	}else { 
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/btn_next.png' width='20' title='Btn Next Page'>";
	}
	//마지막 페이지	
	if( $last_page < $total_page){
		echo "<a href='javascript:page_move($total_page)'>Last</a>";
	}else{
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/b_last_silver.gif' border='0' height='20' title='Next Page'>";
	}
	echo "</div>";
}
function paging($link, $total, $page, $size, $page_num){
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);

	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	// 6을 구하는식
	$last_page = $first_page+($page_num-1);
	if( $last_page > $total_page) $last_page = $total_page;

	echo "<div class='paging'>";
	//처음페이지
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>First</a>");
	} else {
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/b_first_silver.gif' border='0' height='20' title='first'>";
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		echo "<a href='javascript:page_move($back_page)' ><img src='". KAPP_URL_T_ ."/include/img/btn/btn_prev.png' width='20' title='previous'></a>";
	} else {
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/btn_prev.png' width='20' title='Previous'>";
	}
	//페이지 출력
	echo("&nbsp;");
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("&nbsp;<font size=3>$i</font><span>&nbsp;.&nbsp;</span>"); }
		else         { echo("&nbsp;<a href='javascript:page_move($i)'>$i</a><span>&nbsp;.&nbsp;</span>"); }
	}
	//다음페이지
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'><img src='../include/img/btn/btn_next.png' width='20' title='B Next Page'></a>");
	}else { 
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/btn_next.png' width='20' title='Btn Next Page'>";
	}
	//마지막 페이지	
	if( $last_page < $total_page){
		echo "<a href='javascript:page_move($total_page)'>Last</a>";
	}else{
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/b_last_silver.gif' border='0' height='20' title='Next Page'>";
	}
	echo "</div>";
}
// list1_detail.php - inc_list1.php
function pagingD($link, $total, $page, $size, $page_num){
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);

	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	// 6을 구하는식
	$last_page = $first_page+($page_num-1);
	if( $last_page > $total_page) $last_page = $total_page;

	echo "<div class='paging'>";
	//처음페이지
	if( $page > $page_num ) {
		echo("<a href='javascript:page_moveD(1)'>First</a>");
	} else {
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/b_first_silver.gif' border='0' height='20' title='first'>";
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		echo "<a href='javascript:page_moveD($back_page)' ><img src='". KAPP_URL_T_ ."/include/img/btn/btn_prev.png' width='20' title='previous'></a>";
	} else {
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/btn_prev.png' width='20' title='Previous'>";
	}
	//페이지 출력
	echo("&nbsp;");
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("&nbsp;<font size=3>$i</font><span>&nbsp;.&nbsp;</span>"); }
		else         { echo("&nbsp;<a href='javascript:page_moveD($i)'>$i</a><span>&nbsp;.&nbsp;</span>"); }
	}
	//다음페이지
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_moveD($next_page)'><img src='../include/img/btn/btn_next.png' width='20' title='B Next Page'></a>");
	}else { 
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/btn_next.png' width='20' title='Btn Next Page'>";
	}
	//마지막 페이지	
	if( $last_page < $total_page){
		echo "<a href='javascript:page_moveD($total_page)'>Last</a>";
	}else{
		echo "<img src='". KAPP_URL_T_ ."/include/img/btn/b_last_silver.gif' border='0' height='20' title='Next Page'>";
	}
	echo "</div>";
}

?>