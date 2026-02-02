<?php
	include_once('../tkher_start_necessary.php');

	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';
	/*
		- cratree_coinadd.php :  _run.html에서 클릭시에 실행된다. , call: _r.htm -
				: <a href='https://google.com' onclick="javascript:submit_run( 'cracan1004', 'cracan1004_1529705854', 'cracan1004_1529705854_r', 'cracan1004_1529705854_r01', 'cracan1004_1529705854', 'https://google.com', 'T', '구글ac', 'https://google.com', 'url_link_tree_solpa_user_r');" target='url_link_tree_solpa_user_r' style='color:#999900;font-size:12'>구글ac</a>

				: login 하지 않은 사용자가 클릭시에는 등록자에게 코인을 지급하지않는다. 2018-06-09 : 뷰 카운트만한다....

		- coin_add_sys.php : 이것은 시스템 트리목록 : treelist2_cranim_book.php : TKHER Tree All List 에서 클릭시에 사용된다.
									트리생성후 트리내부에서 https://naver.com등 보안 url 에대한 링크및 코인 지급 처리시에 tree_coinadd.php를 사용한다.
									https:// 분류 체크는 _run.html 소스에서 분류처리한다.
				: function submit_run( mid, sys_pg, sys_menu, sys_submenu, num, pg, jong, title_, link_, target_):분류 함수.
				: 샘플예제:_run.html를 테스트하고 tree_create_new.php소스생성에서 적용함
				: 소스생성 결과 샘플 1호: /cratree/cracan1004/cracan1004_1529705854_run.html
	*/
	//mid, num, pg, jong, title_, link_, target_


	if( isset($_POST['sys_board_num'])) $sys_board_num	= $_POST['sys_board_num'];
	else $sys_board_num	= '';
	if( isset($_POST['mid'])) $mid			= $_POST['mid'];
	else $mid			= '';
	if( isset($_POST['sys_pg'])) $sys_pg			= $_POST['sys_pg'];
	else $sys_pg			= '';
	if( isset($_POST['sys_menu'])) $sys_menu		= $_POST['sys_menu'];
	else $sys_menu		= '';
	if( isset($_POST['sys_submenu'])) $sys_submenu 	= $_POST['sys_submenu'];
	else $sys_submenu 	= '';
	if( isset($_POST['num'])) $num				= $_POST['num'];
	else $num			= '';
	if( isset($_POST['pg'])) $pg				= $_POST['pg'];
	else $pg				= '';
	if( isset($_POST['jong'])) $jong			= $_POST['jong'];
	else $jong			= '';
	if( isset($_POST['title_'])) $title_		= $_POST['title_'];
	else $title_			= '';
	if( isset($_POST['link_'])) $link_			= $_POST['link_'];
	else $link_			= '';
	if( isset($_POST['target_'])) $target_		= $_POST['target_'];
	else $target_		= '';
	if( isset($_POST['seqno'])) $seqno			= $_POST['seqno'];
	else $seqno			= '';

	$_SESSION['sys_pg'] = $sys_pg;
	if( isset($_POST['sys_subtit']) ) $_SESSION['sys_subtitS'] = $_POST['sys_subtit'];
	$_SESSION['sys_subtitS'] = '';
?>
<script language="javascript">
<!--
	function submit_run( pg , target_ , jong, sys_pg, url_T , url_, sys_board_num) {

				//alert("pg:" + pg + " ---url_: " +url_);
				//pg:contents_view_menuD.php?num=dao1639446967 ---url_: https://ailinkapi.com
				//pg:contents_view_menuD.php?num=dao_1756603979 ---url_: https://ailinkapi.com
				//pg: ---url_: https://ailinkapi.com
				// pg:undefined ---url_: https://appgenerator.net
				//pg: ---url_: https://ailinkapi.com
				//pg:http:// ---url_: https://appgenerator.net
			if( pg == 'http://' || pg == 'https://' ) {
				window.close();
				exit;
			} else if( pg.indexOf("blog.naver.com")>=0 ) {
						location.href=pg;
			} else if( pg.indexOf("naver.com")>=0 ) {
						document.click_run.target='_top';
						location.href=pg;
			} else if( pg.indexOf("https://youtu.be/")>=0 ) {
						document.click_run.target='_top';
						location.href=pg;
			} else if( pg.indexOf("https://www.youtube.com/")>=0 ) {
						document.click_run.target='_top';
						location.href=pg;
			} else if( pg.indexOf("https://www.youtube.com/embed/")>=0 ) {
						document.click_run.target='_top';
						location.href=pg;
			} else if( pg.indexOf("https://google")>=0 ) {
						document.click_run.target='_top';
						location.href=pg;
			} else if( pg.indexOf("index_bbs.php?infor")>=0 ) {
						//pgA = url_T + "/menu/" + pg; 					//alert("pgA: " + pgA); //pgA: index_bbs.php?infor=259
						document.click_run.action= pg; // pg:index_bbs.php?infor=226 - insw
						document.click_run.submit();
			} else if( pg.indexOf("tree_run.php")>=0 ) {
						document.click_run.target='_top';
						location.href=pg;
			} else if( pg.indexOf("https://")>=0 ) {
						document.click_run.target='_top';
						location.href=pg;
			} else if( pg.indexOf("http://")>=0 ) {
						document.click_run.target=target_;
						location.href=pg;
			} else if( pg.indexOf("tkher_program_data_list.php")>=0 ) {
						u_ = pg.split('/'); //alert(" u_: " + u_.length ); // 2
						if( u_.length > 1 ) pgA = url_T + "/" + u_[1];
						else pgA = url_T + "/" + u_;
						document.click_run.action= pgA;
						document.click_run.submit();
			} else if( pg.indexOf("contents_view_menuD.php")>=0 ) {
						document.click_run.action= pg;
						document.click_run.submit();
			} else if( pg.indexOf( url_) >= 0 ) { // alert(" ---url_: " +url_); // ---url_: https://fation.net
						document.click_run.action= pg;
						document.click_run.submit();
			} else if( pg == 'undefined' ) {
				window.close();
				exit;
			} else {
						document.click_run.target='_top';
						location.href=pg;
			}
	}
//-->
</script>
	<form name='click_run' method='post' enctype='multipart/form-data' >
	<input type='hidden' name='sys_pg' value='<?=$sys_pg?>' >
</form>
<?php
	date_default_timezone_set("Asia/Seoul");
	$ip  = $_SERVER['REMOTE_ADDR'];
	$host	 = KAPP_URL_T_; //getenv("HTTP_HOST");
	$Accept  = getenv("HTTP_ACCEPT");
	$agent = '';
	$msg		= $ip . "|" . $agent . "|" . $Accept;
	$pattern = "/mobile/i";
	if( preg_match($pattern, $agent, $matches)){
		$type='mobile';
	} else{
		$type='pc';
	}
	$ipcode = '';
	$ipname = '';
			/*
			$ip_num = htol($ip);	//2342680517
			$ret = sql_query("SELECT * from ip_info where ipno1 <= $ip_num and ipno2 >= $ip_num " );
			$tot = sql_num_rows( $ret );
			//m_("1---- tot:" . $tot); //1---- tot:0 NULL Error else link_:
			$rs  = sql_fetch_array( $ret );
			if( $tot > 0 ){
				$ipcode = $rs['country_cd'];
				$ipname = $rs['country_name'];
			} else {
				$ipcode = '';
				$ipname = '';
			}*/
			//m_("2---- tot:" . $tot); // 2---- tot:0
	$day	= date("Y-m-d");
	$up_day = date("Y-m-d h:i:s");
	/*if( isset($_POST['seqno']) && $_POST['seqno'] !=='' ){
		$query = "update {$tkher['job_link_table']} set view_cnt=view_cnt+1 where seqno=" . $_POST['seqno'];
		$ret = sql_query($query);
	}*/
	if( isset($_POST['num']) && isset($_POST['title_']) ){
		$query = "update {$tkher['sys_menu_bom_table']} set view_cnt=view_cnt+1 where sys_pg='" . $_POST['num'] . "' and sys_subtit='" . $_POST['title_'] ."' "; 
		$ret = sql_query($query);
	}

		$SQL	= " SELECT * from {$tkher['coin_view_table']} where url='$link_' and makeid='$mid' ";
		$ret = sql_query($SQL);
		$v   = sql_num_rows($ret);
	if( isset($H_ID) && $H_LEV > 1 ) {	// 로그인 중일때.........
		if( $v ) { // url 클릭 하는 날짜가 있으면 뷰 카운터만 한다.
			$retA = sql_fetch_array($ret);
			$seqnoA = $retA['seqno'];
			$query = "update {$tkher['coin_view_table']} set view_cnt=view_cnt+1 where seqno=$seqnoA";//회원이클릭시에 +1
			$result = sql_query($query);
		} else { // url 클릭 하는 날짜가 없으면 포인트를 지급. 보는 이 100 와 만드 이 100 모두에게
			$query = "insert {$tkher['coin_view_table']} set id='$H_ID', makeid='$mid', title='$title_', url='$link_', up_day='$up_day', ip='$ip', host='$host', view_cnt=1, type='$type' "; //cd='$ipcode', cdname='$ipname', 
			$result = sql_query($query);

			if( $sys_pg && $mid != $H_ID ) {
				// 본사람도 코인을 지급한다......당분간만????
				//  $config['kapp_use_point']=100, $config['kapp_comment_point']=1000,$config['kapp_recommend_point']=1000, $config['kapp_login_point']=100, $config['kapp_read_point']=100, $config['kapp_write_point']=3000, $config['kapp_download_point']=-3000, $config['kapp_register_point']=3000, $config['kapp_memo_send_point']=100
				insert_point_app( $member['mb_id'], $config['kapp_use_point'], $link_, 'viewer@cratree_coinadd_menu' , $mid, $title_, $title_ );
				//kapp_use_point = click point
				// 만든 사람에게 포인트를 지급한다...kapp_comment_point=1000, kapp_use_point=100
				if( $member['mb_id'] !== $mid) insert_point_app( $mid, $config['kapp_read_point'], $link_, 'view@cratree_coinadd_menu' , $mid, $title_ );
			} else {
				insert_point_app( $member['mb_id'], $config['kapp_use_point'], $link_, 'viewer@cratree_coinadd_menu', $mid, $title_  );
				//kapp_use_point = click point
			}

		}
	} else {	// 로그인이 아닌 손님일때 뷰 저장.
		if( $v ) { // url 클릭 하는 날짜가 있으면 뷰 카운터만 한다.
			$retA = sql_fetch_array($ret);
			$seqnoA = $retA['seqno'];
			$query = "update {$tkher['coin_view_table']} set view_cnt=view_cnt+1 where seqno=$seqnoA";//회원이클릭시에 +1
//			$query = "update {$tkher['coin_view_table']} set view_cnt=view_cnt+1 where url='".$link_."' ";//회원이클릭시에 +1
			$result = sql_query($query);
		} else { // url 클릭 하는 날짜가 없으면 포인트를 지급. 보는 이 100 와 만드 이 100 모두에게
			$query = "insert {$tkher['coin_view_table']} set id='$mid', makeid='$mid', title='$title_', url='$link_', up_day='$up_day', ip='$ip', host='$host', view_cnt=1, type='$type' ";
			$result = sql_query($query);
		}

	}
	if( isset($link_) ){
		echo "<script>submit_run('" . $link_ . "', '" . $target_ . "', '" . $jong. "', '". $sys_pg. "', '". KAPP_URL_T_ . "', '" . KAPP_URL_ . "' , '".$sys_board_num."' );</script>";
	} else {
		m_("NULL Error else link_: " . $link_); // link_: index_bbs.php?infor=261
	}
	//exit;
?>
