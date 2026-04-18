<?php
if (!defined('_KAPP_')) exit; // 개별 페이지 접근 불가
/*
kapp_data_list_paging.php
 	$linkurl : 로드할 URL 주소
// 	$total : 전체 목록수
// 	$page : 현재 페이지
// 	$line_cnt : 한페이지에 보여줄 목록수
// 	$seek : 목록 열지정
// 	사용예 :  본페이지에서 $line_cnt값을 선언해주고
//		$seek=($page*$line_cnt)-$line_cnt;
//		mysql_data_seek($mq,$seek); 
//		*페이징이 들어갈 위치에서 함수를 호출해 준다.
//		paging($linkurl,$total,$page,$line_cnt); 
//function paging($linkurl, $total, $page, $line_cnt, $line_cnt){
*/

function paging( $linkurl, $total, $page, $line_cnt, $form_obj){
	$page_num = 10; // display max page num
	if( !$total ) { return; }
	$total_page	= ceil((INT)$total/(INT)$line_cnt);
	/*
	$temp		= $page%$line_cnt;
	if($temp=="0"){
		$a=$line_cnt-1;
		$b=$temp;
	}else{
		$a=$temp-1;
		$b=$line_cnt-$temp;
	}
	$start	= $page-$a;
	$end		= 10;//$page+$b;
	*/
	$first_page = intval(($page-1)/$page_num+1)*$page_num-($page_num-1);
	$last_page = $first_page+($page_num-1);
	if($last_page > $total_page) $last_page = $total_page;

	echo "<div class=paging>";
	if( $page > $page_num ) {
		echo "<a href=\"javascript:Kapp_ProgramJS.page_move( $form_obj, 1, '$linkurl');\">[First]</a><span>.</span>";
	} else {
		echo "<span>[Start].</span>";
		//echo "<img src=./include/img/btn/b_first_silver.gif border=0 height=30 title='First'>";
	}
	if( $page > $page_num ) {
		$back_page = $first_page - 1;
		//echo "<a href=\"javascript:Kapp_ProgramJS.page_move( $form_obj, $back_page, '$linkurl')\" ><img src=./include/img/btn/btn_prev.png width=30 title='previous'></a>";
		echo "<a href=\"javascript:Kapp_ProgramJS.page_move( $form_obj,$back_page, '$linkurl')\" >[Prev]</a><span>.</span>";
	} else {
		//echo("<img src=./include/img/btn/btn_prev.png width=30 title='Previous'>");
		//echo("<span>[Prev].</span>");
	}
	for( $i=$first_page; $i <= $last_page; $i++ ){
		if( $i > $total_page){ break;}
		if( $page==$i ){ echo "<a href='javascript:void(0)' class=on>$i</a><span>.</span>"; }
		else         { echo "<a href=\"javascript:Kapp_ProgramJS.page_move( $form_obj, $i, '$linkurl')\">$i</a><span>.</span>"; }
	}
	if( $last_page < $total_page){
		$next_page=$last_page+1;
		echo "<a href=\"javascript:Kapp_ProgramJS.page_move( $form_obj,$next_page);\">[Next]</a><span>.</span>";
		//echo "<a href=\"javascript:Kapp_ProgramJS.page_move( '$linkurl',$form_obj, $next_page);\"><img src=./include/img/btn/btn_next.png width=30 title='B Next Page'></a>");
	}else { 
		//echo("<img src=./include/img/btn/btn_next.png width=30 title='Btn Next Page'>");
		//echo "<span>[Next].</span>";
	}
	if( $last_page < $total_page){
		echo "<a href=\"javascript:Kapp_ProgramJS.page_move( $form_obj, $total_page, '$linkurl');\">[Last]</a>";
	}else{
		echo("<span>[End]</span>");
		//echo "<img src=./include/img/btn/b_last_silver.gif border=0 height=30 title='Last'>";
	}
	//m_("last_page:$last_page , total_page:$total_page"); //last_page:5 , total_page:5
	echo "</div>";
}
?>