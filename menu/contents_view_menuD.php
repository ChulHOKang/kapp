<?php
	include_once('../tkher_start_necessary.php');

	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';
	/* -----------------------------------------------------------------------------
		contents_view_menuD.php : Note View - 현재 2023-11-01 사용.
		view count add , point add
		comment delete : h_lev=1
		change : contents_view_menuD_main.php
	----------------------------------------------------------------------------- */
	function special_chk ($input) { // 특수문자 제거. "'"만 제거한다.
		if (is_array($input)) { //m_("---1");
			return array_map('special_chk', $input); 
		} 
		else if (is_scalar($input)) { //m_("---2");
				return preg_replace("/'/i", "", $input); //return preg_replace("/[ #\/\\\:;,'\"`<>()]/i", "", $input);
		} 
		else { //m_("---3");
			return $input; 
		} 
	}
	if( isset($_POST['xmode']) ) $xmode = $_POST['xmode'];
	else $xmode = '';
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';

	if( isset($_POST['target_run']) ) $target_run = $_POST['target_run'];
	else $target_run = '';

	$num = '';
	if( isset($_POST['num']) && $_POST['num'] !=='') $num = $_POST['num'];	//$content	= $_REQUEST['content'];
	else if( isset($_REQUEST['num']) && $_REQUEST['num'] !=='') $num = $_REQUEST['num'];	//$content	= $_REQUEST['content'];
	else { m_("error num: " . $num); exit; }//m_("".$num);

	if( isset($_POST['mid']) ) $mid = $_POST['mid'];
	else $mid = '';
	if( isset($_POST['seq']) ) $seq = $_POST['seq'];
	else $seq = '';
	
	if( $mode == 'del_comment'){
		$doc_userid	= $_POST['doc_userid'];
		$sql= "Update {$tkher['webeditor_comment_table']} SET del='1' where seq='$seq' and ( user='$mid' or doc_userid='$doc_userid') "; 
		$ret = sql_query( $sql );
		if ( $ret ){
			m_(" Delete comment. ");
		} else m_(" Error Delete comment. ");

	} else if( $xmode == 'save_insert' ){
		$xmode  = '';
		$reply	= $_POST['content'];
		$reply  = special_chk( $reply );
		if( !$reply ){
			m_("Please register comment. ");
			$rungo		= "contents_view_menuD.php?num=" . $num;
			echo "<script> window.open('$rungo', '_top', ''); </script>";
		}
		$up_day	= date("Y-m-d H:i:s",time());
		$sql	= "INSERT INTO {$tkher['webeditor_comment_table']} SET num='$num', doc_userid='$mid', user='$H_ID', reply='$reply', title='$title', diff='1', date='$up_day' "; // diff='1'은 Daum type 게시판으로 새로 생성한 것을 적용하기 위함.
		$retV   = sql_query( $sql );
		if( $retV ){
			$rungo = $tkher_iurl . "/" . $_SERVER['SCRIPT_NAME'];
			insert_point_app( $H_ID, $config['kapp_memo_send_point'], $rungo, 'comment@contents_view_menuD', $H_ID, $num, $num );
			m_("OK! register comment.  title:$title, mid:$mid"); 
		} else {
			m_("error! register comment.  title:$title, mid:$mid"); 
		}
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE>
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="kapp,k-app,appgenerator, app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="kapp,k-app,appgenerator,app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
	<link href="<?=KAPP_URL_T_?>/menu/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=KAPP_URL_T_?>/menu/css/editor.css" type="text/css" charset="utf-8"/>
	<script src="<?=KAPP_URL_T_?>/menu/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<script>
 //alert(" script ----------- menuD"); ok
		function upd_func( num, mode, diff, book_name, target_run){
			//alert('upd_func - num: ' + num+ ', '  + mode+ ', '  + diff + ', book_name: ' +  book_name + ', ' + target_run);
			if( book_name) {
				document.edit_form.target="_self";
				document.edit_form.mode.value="update";
				document.edit_form.num.value=num;
				document.edit_form.action="contents_view_menuD_main.php"; // my_editor2_book_menu.php
				document.edit_form.submit();
			}
		}
		function upd_func_comment(seq,mode,num,mid, target_run){ //diff
			//alert('upd_func_comment - ');
				document.delete_form.mode.value="change_comment";
				document.delete_form.mid.value=mid;
				document.delete_form.seq.value=seq;
				document.delete_form.num.value=num;
				document.delete_form.target="_self";
				document.delete_form.action="contents_view_menuD_change.php?num="+num+"&seq="+seq;	// my_editor2_book_comment_menu.php
				document.delete_form.submit();
		}
		function del_func_comment(seq,mode,num,mid, doc_userid){
			if( !confirm('Do you want to delete?') ) {	// 
				return false;
			}
				document.delete_form.mode.value="del_comment";
				document.delete_form.doc_userid.value=doc_userid;
				document.delete_form.mid.value=mid;
				document.delete_form.seq.value=seq;
				document.delete_form.num.value=num;
				document.delete_form.target="_self";
				document.delete_form.action="contents_view_menuD.php?num="+num;
				document.delete_form.submit();
		} 
		function ins_func(){

			document.edit_form.action="my_editor2_book_insert_menu.php";
			document.edit_form.submit();
		}
		function boardSubmit()
		{
			var frm = document.commentForm;
			frm.xmode.value='save_insert';
			frm.submit();
		}
</script>
<?php
$query	= "SELECT * from {$tkher['webeditor_table']} where num = '".$num . "' ";
$result	= sql_query( $query );
$line	= sql_fetch_array($result);
if( isset($line['user'])) $row_user = $line['user'];
else $row_user = ''; 
if( $row_user == $line['book_name'])
		$savetype = '1';//단독등록 구분 
else	$savetype = '0';

$h_lev		= $line['h_lev'];
$book_name = $line['book_name'];
$mid			= $line['user'];
$title			= $line['title'];
$in_dir		= substr($line['date'],0,7);
$upfile		= $line['up_file'];
$align			= $line['align']; 

$addfile ='';

if( isset($title) ) {
	//m_("line OK sql_fetch_array "); //line OK sql_fetch_array 

	$content   = $line['content'];
	$backcolor = $line['backgroundcolor'];
	$fcolor = 'gray';
	$view_cnt =$line['view_cnt'] +1;
?>
	<style>
	body {
		background-color: <?=$backcolor?>;
		background-image: <?=$line['backgroundimage']?>;
	}
	</style>
	<body bgProperties="" leftmargin="0" topmargin="0" height='100%' >
	<?php
	$cur='C';
	//include "./menu_run_menu.php"; // note tree
	?>
	<form name='edit_form' METHOD='POST' enctype="multipart/form-data">
		<input type='hidden' name='mid'   value='<?=$row_user?>'>
		<input type='hidden' name='mode'  value=''>
		<input type='hidden' name='num'   value=''>
		<input type='hidden' name='diff'       value='1'> 
		<input type='hidden' name='savetype'   value='<?=$savetype?>'> <!-- 트리생성 유무 구분용 -->
		<input type='hidden' name='book_num'   value='<?=$book_name?>'>
		<input type='hidden' name='target_run' value='<?=$target_run?>'>
<?php
	if( $upfile) $addfile="Attached file:[" . $align . "]";
	if( $H_ID and $H_ID == $row_user || $H_LEV > 7)  {
?>
		<DIV style='background-color:yellow;color:black;text-align:left;'>
		[ Title :<?=$title?> ] [user:<?=$row_user?> - point:<?=number_format( $member['mb_point'])?>] [view:<?=$view_cnt?>] :
		<input type='button' value=' Change ' title='data change upd_func' style='border-radius:20px;' onClick="javascript:upd_func('<?=$num?>','update','1', '<?=$book_name?>', '<?=$target_run?>');">
		&nbsp;<a href='./download.php?num=<?=$num?>'  style='background-color:blue;color:yellow;border-radius:20px;'><?=$addfile?></a>
		</DIV>
<?php } else {?>
		<DIV style='background-color:yellow;color:black;text-align:left'>
		[ Title : <?=$title?> ] [user:<?=$row_user?>] [view:<?=$view_cnt?>]
		</DIV>
<?php } ?>
	</form>
	<form name='delete_form' METHOD='POST' enctype="multipart/form-data">
		<input type='hidden' name='mode' value=''>
		<input type='hidden' name='doc_userid' value=''>
		<input type='hidden' name='mid' value=''>
		<input type='hidden' name='num' value=''>
		<input type='hidden' name='seq' value=''>
	</form>
<?php 
	echo "<div style='text-align:left'>$content</div>";
	$sql   ="SELECT * from {$tkher['webeditor_comment_table']} where num='$num' and del != '1' ";
	$result =sql_query($sql);
	$row_tot = sql_num_rows($result);
	if( $row_tot > 0 ){ 
		while( $rs =sql_fetch_array($result) ){
			$doc_userid =$rs['doc_userid'];
			$id    =$rs['user'];
			$reply =$rs['reply'];
			$date  =$rs['date'];
			if( ($rs['user'] == $H_ID || $H_LEV > 7) && !isset($rs['h_lev']) ) {
				echo "<DIV style='background-color:gray;color:cyan;text-align:left'>[Doc:$num] [user:$id] [$date]
				&nbsp;<input type='button' value=' Change ' title='num: ".$num."' style='border-radius:20px;' onClick=\"javascript:upd_func_comment('".$rs['seq']."','update','".$num."', '$id', '$target_run')\">
				&nbsp;<input type='button' value=' Delete ' style='border-radius:20px;' onClick=\"javascript:del_func_comment('".$rs['seq']."','delete','".$num."', '$id', '$doc_userid')\">
				</DIV>";
			} else {
				echo "<DIV style='background-color:gray;color:cyan;text-align:left'>[comment] [user:$id] [$date]</DIV>";
			}
			if( $rs['h_lev'] == '1' ) {
				echo "<DIV style='text-align:left'>Deleted</DIV>";
			} else {
				echo "<DIV style='text-align:left'>$reply</DIV>";
			}
		}
	}
		echo "
			<form name='tx_editor_form' id='tx_editor_form' action='contents_view_menuD.php' method='post' accept-charset='utf-8'>
				<input type='hidden' name='xmode' value=''>
				<input type='hidden' name='num'   value='$num'>
				<input type='hidden' name='mid'   value='$mid'>
				<input type='hidden' name='title' value='$title'>
				<DIV style='background-color:gray;color:cyan;text-align:left'> [comment] [User:$H_ID]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type='button' onclick=\"saveContent(this, '$H_ID')\" value=' Comment Save ' style='cursor:hand;border-radius:20px;'>&nbsp;
				</DIV>";
			include './write_head.php';
			echo "</form>";
		$view_cnt = $line['view_cnt'] + 1;
		$sql = " update {$tkher['webeditor_table']} set view_cnt=$view_cnt where num = '$num' ";
		$retok = sql_query( $sql );

} else {
		echo "<DIV>error no found num:$num</DIV>";
} //if( $line )
?>
<script type="text/javascript">
	var config = {
		txHost: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */
		txPath: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */
		txService: 'sample', /* 수정필요없음. */
		txProject: 'sample', /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
		initializedId: "", /* 대부분의 경우에 빈문자열 */
		wrapper: "tx_trex_container", /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
		form: 'tx_editor_form'+"", /* 등록하기 위한 Form 이름 */
		txIconPath: "<?=KAPP_URL_T_?>/menu/images/icon/editor/", /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
		txDecoPath: "<?=KAPP_URL_T_?>/menu/images/deco/contents/", /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */
		canvas: {
			styles: {
				color: "#123456", /* 기본 글자색 */
				fontFamily: "굴림", /* 기본 글자체 */
				fontSize: "10pt", /* 기본 글자크기 */
				backgroundColor: "#fff", /*기본 배경색 */
				lineHeight: "1.5", /*기본 줄간격 */
				padding: "8px" /* 위지윅 영역의 여백 */
			},
			showGuideArea: false
		},
		events: {
			preventUnload: false
		},
		sidebar: {
			attachbox: {
				show: true,
				confirmForDeleteAll: true
			}
		},
		size: {
			contentWidth: 1500 /* 지정된 본문영역의 넓이가 있을 경우에 설정 700 1500 */
		}
	};
	EditorJSLoader.ready(function(Editor) {
		var editor = new Editor(config);
	});
	function saveContent(x, id) {
		x = document.tx_editor_form;
		x.xmode.value='save_insert';
		if( !id ) {
			alert('Please login! ');
			return false;
		}
		Editor.save(); // 이 함수를 호출하여 글을 등록하면 된다.
	}
	/**
	 * Editor.save()를 호출한 경우 데이터가 유효한지 검사하기 위해 부르는 콜백함수로
	 * 상황에 맞게 수정하여 사용한다.
	 * 모든 데이터가 유효할 경우에 true를 리턴한다.
	 * @function
	 * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
	 * @returns {Boolean} 모든 데이터가 유효할 경우에 true
	 */
	function validForm(editor) {
		var validator = new Trex.Validator();
		var content = editor.getContent();
		if (!validator.exists(content)) {
			alert('validator 내용을 입력하세요');
			return false;
		}
		return true;
	}
	/**
	 * Editor.save()를 호출한 경우 validForm callback 이 수행된 이후
	 * 실제 form submit을 위해 form 필드를 생성, 변경하기 위해 부르는 콜백함수로
	 * 각자 상황에 맞게 적절히 응용하여 사용한다.
	 * @function
	 * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
	 * @returns {Boolean} 정상적인 경우에 true
	 */
	function setForm(editor) {
        var i, input;
        var form = editor.getForm();
        var content = editor.getContent();
        // 본문 내용을 필드를 생성하여 값을 할당하는 부분
        var textarea = document.createElement('textarea');
        textarea.name = 'content';
        textarea.value = content;
        form.createField(textarea);
        /* 아래의 코드는 첨부된 데이터를 필드를 생성하여 값을 할당하는 부분으로 상황에 맞게 수정하여 사용한다.
         첨부된 데이터 중에 주어진 종류(image,file..)에 해당하는 것만 배열로 넘겨준다. */
        var images = editor.getAttachments('image');
        for (i = 0; i < images.length; i++) {
            if (images[i].existStage) { //// existStage는 현재 본문에 존재하는지 여부
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'attach_image';
                input.value = images[i].data.imageurl;  // 예에서는 이미지경로만 받아서 사용
                form.createField(input);
            }
        }
        return true;
	}
	function youTubeImplant() {
		var popUrl = "<?=KAPP_URL_T_?>/menu/youtube.html";
		var popOption = "<?=KAPP_URL_T_?>/menu/youtube.html";
		window.open(popUrl, "", popOption);
	}
</script>
</body>
</html>
