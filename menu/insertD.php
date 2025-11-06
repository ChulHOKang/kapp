<?php
	include_once('../tkher_start_necessary.php');
	/*
		insertD.php
	*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<script type="text/javascript" src="../include/js/common.js"></script>
<SCRIPT src="../include/js/contents_resize.js" type='text/javascript'></SCRIPT>
<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	$H_ID = get_session("ss_mb_id");
	if( $H_ID && $H_ID !=='') {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
	} else {
		$H_LEV	= 0;  
		$H_NAME	= 'Guest';  
		$H_NICK	= 'Guest';  
	}
	$H_EMAIL = get_session("ss_mb_email"); 
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;
	if( isset($_POST['menu_mode']) ) $menu_mode=$_REQUEST['menu_mode'];
	else $menu_mode = '';
	$in_day = date("Y-m-d H:i");
	if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	else $infor = '';
	if( $infor ) $_SESSION['infor'] = $infor;

	include "./infor.php";
	$grant_write=$mf_array['grant_write'];
	//m_(" session infor: ". $_SESSION['infor'] . ", 47: " . $mf_infor[47]. ", grant_write: " . $mf_array['grant_write'] );
	//session infor: 2, 47: 2, grant_write: 2
	/*
		switch( $mf_infor[47] ){ // 47=grant_write
			case '0': break;			// guest
			case '1': 					// member
				if( !$H_ID || $H_LEV < $grant_write ) { 
					m_("You do not have permission to write. " . $H_ID . ", " . $H_LEV); 
					echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";exit;
				}
				else break;
			case '2': 
				//if( $H_ID != $mf_infor[53] && $H_LEV < 2) { 
				if( $H_ID != $mf_infor[53] && $H_LEV < $grant_write) { 
					m_("You do not have permission to write."); 
					echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";exit;
				}
				else break;
			case '3': 
				if( $H_ID != $mf_infor[53] && $H_LEV < 8 ) { 
					m_("You do not have permission to write."); //echo "<script>history.back(-1);</script>"; exit;
					echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";exit;
				}
				else break;
		} */
		if( $grant_write > 1 && $H_LEV < $grant_write ) { 
			m_("You do not have permission to write. " . $H_ID . ", " . $H_LEV . ", write: " . $grant_write); 
			echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";exit;
		}
	$amember_name	= $H_NICK;
	$amember_id		= $H_ID;
	$mf_47 = $mf_infor[47];
?>

<script type="text/javascript">

	function board_listD(menu_mode) {
		x = document.tx_editor_form;
		infor = x.infor.value;
		x.action='listD.php?infor='+infor+'&menu_mode=' +menu_mode;
		x.submit();

	}
	function data_check(x,y){
			alert('Please enter your name');// \n 이름을 입력하세요
			x.title.focus();
			return false;

		if(x.title.value==''){
			alert('Please enter a title'); //  \n 제목을 입력하세요
			x.title.focus();
			return false;
		}
		if(x.contents.value==''){
			alert('Please enter your content'); // \n 내용을 입력하세요
			x.contents.focus();
			return false;
		}
	}
	function textarea_size(value) {
		if (value == 0) {
		  document.form.contents.cols  = 60;
		  document.form.contents.rows  = 10;
		}
		if (value == 1) document.form.contents.cols += 5;
		if (value == 2) document.form.contents.rows += 5;
	}

	function email_check( email ) {
		alert(' email ' + email);

	  if (ereg("(^[a-zA-Z0-9]{1}([_0-9a-zA-Z-]+)@[^\.@]+(\.[0-9a-zA-Z-]{2,})*(\.([a-zA-Z]{2,})$))",email)){
		$return = true;}
		else {$return = false;}
	  return $return;
	}
/*
	 function back_go(infor,list_no, page) {
 		x = document.tx_editor_form;
		x.infor.value=infor;
		x.list_no.value=list_no;
		x.page.value=page;
		x.action=x.previous.value;
		x.submit();
	}*/
</script>

<script>
	$(function() {
		$('.cradata_check').on('click', function() {
			x = document.tx_editor_form;
			var nm = x.name.value;
			alert('nm:'+nm);
			if( x.name.value == "") {
				alert(' Please check your name!! ');// \n 성함 확인바랍니다.
				insert_form.name.focus();
				return false;
			}
			if( x.user_phone.value == "") {
				alert(' Please contact us'); // \n 연락처 확인바랍니다. 
				return false;
			}
			
			if( x.title.value == "") {
				alert(' Please check the title'); // \n 제목 확인바랍니다. 
				return false;
			}
			
			if( x.homep.value == "") {
				alert(' Please check the homepage address. '); // \n 홈페이지 주소 확인바랍니다.
				return false;
			}
			if( x.pass_check.value == "") {
				alert(' Please check your password'); // \n 비밀번호 확인바랍니다. 
				return false;
			}
			
			if( x.auto_check.value == "") {
				alert(' Automatic character verification. '); // \n 자동문자 확인바랍니다.
				return false;
			}
			var auto_char = x.auto_char.value;
			var auto_check = x.auto_check.value;
			if( auto_check == auto_char ) {
				x.submit();
			} else {
				alert(' The automatic characters do not match.');
				return false;
			}
		});	
	});
</script>

</head>
<body width='100%'>
		<?php 
		$cur='A';
		if( $menu_mode != 'off') include_once "../menu_run.php";
		?>

<?php
	include "./headerD.php"; // OK ./header.php는 Tboard write.php 용. 주의.
?>

<div class="wrapper">
	<div id="write_page" class="mainProject">
<form name="tx_editor_form" id="tx_editor_form" action="insertD_check.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<input type="hidden" name='mode'		value='' />
		<input type="hidden" name='auto_char'	value='<?=$auto_char?>' /><!-- my_func -->
		<input type="hidden" name='c_sel'		value='<?=$c_sel?>' />
		<input type="hidden" name='id'			value='<?=$id?>' />
		<input type="hidden" name='board'		value='<?=$board?>' />
		<input type="hidden" name='target_'		value='<?=$target_?>' />
		<input type="hidden" name='name'		value='<?=$H_NICK?>' />
		<input type='hidden' name='security_'   value='1'>
		<input type='hidden' name='security_yn' value='<?=$mf_infor[51]?>'>
		<input type='hidden' name='fileup_yn'   value='<?=$mf_infor[3]?>'><!-- 업로드 가능한 화일 크기 -->
		<input type='hidden' name='html_yn'     value='<?=$mf_infor[7]?>'>
		<input type='hidden' name='tab_enm'     value='aboard_<?=$mf_infor[2]?>'>
		<input type='hidden' name='tab_hnm'     value='<?=$mf_infor[1]?>'>
		<input type='hidden' name='infor'       value='<?=$infor?>' > 
		<input type='hidden' name='file_ext'    value=''>
		<input type='hidden' name='list_no'     value=''>
		<input type='hidden' name='page'        value=''>
		<input type="hidden" name='menu_mode'	value='<?=$menu_mode?>' />
			
			<div class="boardView">
				<div class="viewHeader">
					<span><?=$in_day?></span>
					<a href="javascript:board_listD('<?=$menu_mode?>');" class="btn_bo02">List</a>
				</div>

				<div class="viewSubj"><span><?=$mf_infor[1]?></span> </div>

				<ul class="viewForm">
<?php
if( !$H_ID ){
?>
					<li class="autom_tit">
						<span class="t01">Name</span>
						<span class="t02"><input type="text" name="nameA" id='nameA' value='<?=$H_NICK?>' placeholder="Please enter a name."></span>
					</li>
					<li>
						<span class="t01">E-Mail</span>
						<span class="t02"><input type="text" name="email" align=center itemname="E-Mail" type="text" placeholder="Please enter a E-Mail " required="required" id='email' value=''></span>
					</li>
					<li class="pw_char">
						<span class="t01">password</span>
						<span class="t02"><input type="password" name="password"  placeholder="Please enter your password, you will need it."></span>
					</li>
<?php } else { ?>
					<li class="autom_tit">
						<span class="t01">Name</span>
						<span class="t02"><input type="text" name="nameA" id='nameA' value='<?=$H_NICK?>' placeholder="Please enter a name." readonly></span>
					</li>
<?php } ?>
					<li class="autom_tit">
						<span class="t01">Title</span>
						<span class="t02">
							<input type="text" name="subject" placeholder="Please enter a title! " class="autom_subj" >
						</span>
					</li>
<?php if($mf_infor[7]){ ?>
					<li class="autom_tit">
						<span class="t01">Text type</span>
						<span class="t02">
							<input type="radio" value="1" name="html"> HTML
							<input type="radio" value="2" name="html"> HTML Source
							<input type="radio" value="3" checked name="html"> TEXT</td>
						</span>
					</li>
<?php } ?>
<?php if($mf_infor[51]){ ?><!-- 비밀글. -->
					<li class="autom_tit">
						<span class="t01">Secret article</span>
						<span >
							<input type="radio" value="use" name="security1" id="security1"> use
							<input type="radio" value="nouse" checked name="security1" id="security1"> no use
							<input type="text"  value="" name="security" size="10" style='border:1 black solid;' title='This is required when writing secrets.'> (password) 
						</span>
					</li>
<?php } ?>

			</ul>
<?php 
	$_SESSION['infor'] = $infor;	//m_("infor: " . $infor);
	require_once ('write_head.php');
?>

				<div class="viewFooter">
					<ul class="viewForm_2">
<?php if($mf_infor[3]){ ?><!-- 첨부화일. -->
						<li>
							<span class="t01">Attachments</span>
							<span class="t02 select_file">
								<input type="file" name="fileA" id="fileA"  style="padding-top:12.5px;">
							</span>
						</li>
<?php } ?>
						<li>
							<span class="t01">Auto-Protect : <b><?=$auto_char?></b></span>
							<span class="t02"><!-- 대소문자 구분! -->
							<input type="text" name="auto_check"  placeholder="Please enter the Auto-Protect text on the left! Case sensitivity! " required="required"></span>
							</span>
						</li>
					</ul>
						<a href="javascript:saveContent(this, '<?=$auto_char?>', '<?=$H_ID?>');" class="btn_bo02">Save</a>
					<a href="javascript:board_listD('<?=$menu_mode?>');" class="btn_bo02">List</a>


				</div>
			</div>
		</div>
 	</div><!-- end : container -->
</form>
</div><!-- end : wrapper-->


<script type="text/javascript">
	var config = {
		txHost: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */
		txPath: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */
		txService: 'sample', /* 수정필요없음. */
		txProject: 'sample', /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
		initializedId: "", /* 대부분의 경우에 빈문자열 */
		wrapper: "tx_trex_container", /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
		form: 'tx_editor_form'+"", /* 등록하기 위한 Form 이름 */
		txIconPath: "images/icon/editor/", /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
		txDecoPath: "images/deco/contents/", /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */
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
	
</script>

<script type="text/javascript">

	function saveContent(x, xauto, id) {

		x = document.tx_editor_form;
		if(x.nameA.value==''){
			alert('Please enter a name! ');
			x.nameA.focus();
			return false;
		}
		if( !id ) {
			if(x.password.value==''){
				alert('Please enter a password! ');
				x.password.focus();
				return false;
			}
		}
		if(x.subject.value==''){
			alert('Please enter a title! ');
			x.subject.focus();
			return false;
		}
		if(x.auto_check.value==''){
			alert('Please enter an auto-prevention character! ');
			x.auto_check.focus();
			return false;
		}
		xx = x.auto_check.value;
		if(xx == xauto){
		} else {
			alert('Auto-typing prevention characters are incorrect ' + xauto + ' : ' + xx );
			return false;
		}
		var nm = x.nameA.value;
		//var contents = document.getElementById("EditCtrl").value;
		security = x.security_yn.value;
		if( security > 0) {	// 비밀글 작성 가능시에.
			var se_ = x.security1.value;
			if(se_=="use"){
				p = x.security.value;
				if( !p ){
					alert('Please enter a password.');
					x.security.focus();
					return false;
				}
			}
		} else {
		}
		fileup = x.fileup_yn.value;	//	alert('insertTT board_write security:' + security);
		ff= x.fileA.value;
		if( fileup > 0 && ff !== "" ){	// 첨부화일 가능시에. fileup=fileup_yn : 업로드 화일 사이즈크기 이다. 0이면 업로드 불가 다.
			ff= x.fileA.value;
			if (x.fileA.value != ""){
				input = document.getElementById('fileA'); //filein
				file_sz = input.files[0].size;
				file_sz = file_sz / 1024 / 1024;
				if( file_sz > fileup ) {
					alert( fileup +"Mb Only uploaded below. file size:" + file_sz );//Mb Only uploaded below. file size:22.114242553710938
					return false;
				}
				idx_path = x.fileA.value.lastIndexOf("."); 
				if ( idx_path < 0 ) {
					idx_colon = x.fileA.value.lastIndexOf(".");
					if ( idx_colon >= 0 ) temp = x.fileA.value.substring(idx_colon);
				} else {
					temp = x.fileA.value.substring(idx_path);	//toLowerCase()
				}
				temp = temp.toLowerCase();
				if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xlsx" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"  && temp != ".mp3" && temp != ".mp4" && temp != ".avi" ){
					alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx,mp3,mp4,avi Please format!");
					return;
				}
				x.file_ext.value=temp;
			}
		}
		Editor.save(); // 이 함수를 호출하여 글을 등록하면 된다. -> insertD_check.php - 2024-01-23 kan
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
		// Place your validation logic here

		// sample : validate that content exists
		var validator = new Trex.Validator();
		var content = editor.getContent();
		if (!validator.exists(content)) {
			alert('내용을 입력하세요');
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
            // existStage는 현재 본문에 존재하는지 여부
            if (images[i].existStage) {
                // data는 팝업에서 execAttach 등을 통해 넘긴 데이터
                //OK alert('attachment information - image[' + i + '] \r\n' + JSON.stringify(images[i].data));
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

    var popUrl = "./youtube.html";
    var popOption = "./youtube.html";
    window.open(popUrl, "", popOption);
}

</script>

</body>
</html>
