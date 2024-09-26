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


function paging($link, $total, $page, $size){
	//error_msg(" Page total cnt=$total, page=$page, size=$size ");
	//if($page==""){ $page=1;}
	if( !$total ) { return; }

	$total_page=ceil($total/$size);
	$temp=$page%$size;

	if($temp=="0"){
		$a=$size-1;
		$b=$temp;
	}
	else{
		$a=$temp-1;
		$b=$size-$temp;
	}

	$start=$page-$a;
	$end=$page+$b;

	echo "<div class=paging>";

	//처음페이지
	if( $page>$size ) {
		echo("<a href='$link&page=1#customer'>첫페이지</a>&nbsp;");
	} else {
		//echo("<img src=./img/b_first_silver.gif border=0>&nbsp;");
	}
	
	//이전페이지
	if( $page>$size ) {
		$back_page=$start-1;
		//echo("<a href='$link&page=$back_page'><img src=./img/b_back_blue.gif border=0 alt='이전'></a>&nbsp;");
		echo "<a href='$link&page=$back_page#customer' class='prev'><img src='./include/img/btn/btn_prev.png'></a>&nbsp;";
	} else {
		//echo("<img src=./img/b_back_silver.gif border=0>&nbsp;");
		echo "<img src='./include/img/btn/btn_prev.png' >&nbsp;";
	}
	//페이지 출력

?>
					<!-- <a href=javascript:void(0) class=on>1</a><span>.</span>
					<span>.</span>
					<a href="javascript:void(0)">2</a>
					<span>.</span>
					<a href="javascript:void(0)">3</a>
					<span>.</span>
					<a href="javascript:void(0)">4</a>
					<span>.</span>
					<a href="javascript:void(0)">5</a>
					<span>.</span>
					<a href="javascript:void(0)">6</a> 
					<a href="javascript:void(0)" class="next"><img src="../include/img/btn/btn_next.png" /></a>
				</div>-->
<?php
	for( $i=$start; $i <= $end; $i++ ){
		if($i>$total_page){ break;}
		//if($page==$i){ echo("<font color=red>$i</font>&nbsp;"); }
		//else         { echo("<a href='$link&page=$i'>$i</a>&nbsp;"); }
		if($page==$i){ echo("<a href='javascript:void(0)' class=on>$i</a><span>.</span>"); }
		else         { echo("<a href='$link&page=$i#customer'>$i</a><span>.</span>"); }
	}

	//다음페이지
	if($end<$total_page){
		$next_page=$end+1;
		//echo("<a href='$link&page=$next_page'><img src=./img/b_next_blue.gif border=0 alt='다음'></a>");
		echo("<a href='$link&page=$next_page#customer'><img src='./include/img/btn/btn_next.png' title='next btn'></a>");
	}
	else { 
		//echo("<img src=./img/b_next_silver.gif border=0>&nbsp;");
		echo("<img src='./include/img/btn/btn_next.png' >");
	}

	//마지막 페이지	
	if($end<$total_page){
		echo("&nbsp;<a href='$link&page=$total_page#customer'>마지막페이지</a>");
	}
	//else{echo("<img src=./img/b_last_silver.gif border=0>");
	else{
		//echo("<img src=./include/img/btn/btn_next.png>");
	}

	echo "</div>";

}
?>