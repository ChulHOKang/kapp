<?php
// 	$link : 로드할 URL 주소
// 	$total : 전체 목록수
// 	$page : 현재 페이지
// 	$size : 한페이지에 보여줄 목록수
// 	$seek : 목록 열지정
// 	사용예 :  본페이지에서 $size값을 선언해주고
//		$seek=($page*$size)-$size;
//		mysql_data_seek($mq,$seek); 
//		*페이징이 들어갈 위치에서 함수를 호출해 준다.
//		paging($link,$total,$page,$size); 


//function paging($link, $total, $page, $size, $page_num){
function paging($link, $total, $page, $size){
	$page_num = 10;
	if( !$total ) { return; }
	$total_page	= ceil($total/$size);
	/*
	$temp		= $page%$size;
	if($temp=="0"){
		$a=$size-1;
		$b=$temp;
	}else{
		$a=$temp-1;
		$b=$size-$temp;
	}
	$start	= $page-$a;
	$end		= 10;//$page+$b;
	*/
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;

	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo("<a href='javascript:page_move(1)'>[First]</a><span>.</span>");
	} else {
		echo("<span>[Start].</span>");
		//echo("<img src=./include/img/btn/b_first_silver.gif border=0 height=30 title='First'>");
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		//echo("<a href='javascript:page_move($back_page)' ><img src=./include/img/btn/btn_prev.png width=30 title='previous'></a>");
		echo("<a href='javascript:page_move($back_page)' >[Prev]</a><span>.</span>");
	} else {
		//echo("<img src=./include/img/btn/btn_prev.png width=30 title='Previous'>");
		//echo("<span>[Prev].</span>");
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo("<a href='javascript:void(0)' class=on>$i</a><span>.</span>"); }
		else         { echo("<a href='javascript:page_move($i)'>$i</a><span>.</span>"); }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo("<a href='javascript:page_move($next_page)'>[Next]</a><span>.</span>");
		//echo("<a href='javascript:page_move($next_page)'><img src=./include/img/btn/btn_next.png width=30 title='B Next Page'></a>");
	}else { 
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo("<span>[Next].</span>");
	}
	if( $last_page < $total_page){
		echo("<a href='javascript:page_move($total_page)'>[Last]</a>");
	}else{
		echo("<span>[End]</span>");
		//echo("<img src=./include/img/btn/b_last_silver.gif border=0 height=30 title='Last'>");
	}
	echo "</div>";
}
?>