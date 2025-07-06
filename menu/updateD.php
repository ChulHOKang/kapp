<?php
	include_once('../tkher_start_necessary.php');
	/*
	updateD.php : general board
	*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator Tree Menu. Made in Kang, Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> 
<meta name='keywords' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> 
<meta name='description' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> 
<meta name="robots" content="ALL">

<?php
	$H_ID= get_session("ss_mb_id");
	if( !$H_ID || $H_ID == "" ){ 
		echo "<script>history.back(-1);</script>"; exit; 
	} else {
		$H_EMAIL		= $member['mb_email'];  
		$H_LEV			= $member['mb_level'];  
		$H_NAME			= $member['mb_name'];  
		$H_NICK			= $member['mb_nick'];  
	}
	$ip= $_SERVER['REMOTE_ADDR'];
	if( isset($_POST['mode']) ) $mode    = $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode  = "";
	if( isset($_REQUEST['list_no']) ) $list_no = $_REQUEST['list_no'];
	else if( isset($_POST['list_no']) ) $list_no = $_POST['list_no'];
	if( isset($_REQUEST['infor']) ) $infor = $_REQUEST['infor'];
	else if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	if( $mode != 'updateTT' || !$infor ) {
		m_("mode:".$mode." , You do not have permission to reply. infor:".$infor); 
		echo "<script>history.back(-1);</script>"; exit;
	}
	$email	= $member['mb_email'];  
	$in_day = date("Y-m-d H:i");
	include "./infor.php";
	$query="select no, name, context, target, step, re, subject, file_name, file_wonbon, password, id from aboard_" . $mf_infor[2] . " where no=".$list_no;
	$mq = sql_query($query);
	$mf = sql_fetch_row($mq);
	$mf[6] = htmlspecialchars($mf[6]);
	$content = $mf[2];
	if( $mf_infor[47]=='0' and !$H_ID ) $H_NAME = $mf[1];

	if( $H_LEV < $mf_infor[47] && $H_ID !== $mf_infor[53] && $mf[10]!==$H_ID){
		m_("$H_ID, member permission to read. $mf_infor[47] - $mf_infor[53]"); 
		echo "<script>window.open('listD.php?infor=$infor','_self','')</script>";
		exit;
	}
	/*switch( $mf_infor[47] ){
		case '0': break;
		case '1': 	
			if( !$H_ID || $H_LEV < 2 ) { 
				m_("1 You do not have permission to write."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
		case '2': 
			if( $H_ID != $mf_infor[53] ) { 
				m_("2 You do not have permission to write."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
		case '3': 
			if( $H_LEV < 8 ) { 
				m_("3 You do not have permission to write."); 
				echo "<script>history.back(-1);</script>"; exit;
			}
			else break;
	}*/

?>
<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<link rel="stylesheet" href="../include/css/default.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>
<SCRIPT src="../include/js/contents_resize.js" type='text/javascript'></SCRIPT>

<link href="<?=KAPP_URL_T_?>/menu/css/main.css" rel="stylesheet">
<link rel="stylesheet" href="<?=KAPP_URL_T_?>/menu/css/editor.css" type="text/css" charset="utf-8"/>
<script src="<?=KAPP_URL_T_?>/menu/js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
	function board_listTT() {
		x = document.tx_editor_form;
		page=x.page.value;
		infor = x.infor.value;
		x.action='listD.php?infor='+infor+'&page='+page;
		x.submit();
	}
	function data_check(x,y){
			alert('Please enter your name');
			x.title.focus();
			return false;
		if(x.title.value==''){
			alert('Please enter a title'); 
			x.title.focus();
			return false;
		}
		if(x.contents.value==''){
			alert('Please enter your content');
			x.contents.focus();
			return false;
		}
	}
	function textarea_size(value) {
		if (value == 0) {
		  document.tx_editor_form.contents.cols  = 60;
		  document.tx_editor_form.contents.rows  = 10;
		}
		if (value == 1) document.tx_editor_form.contents.cols += 5;
		if (value == 2) document.tx_editor_form.contents.rows += 5;
	}
	function update_func(xauto, listno, id){
		var formA = document.tx_editor_form;
		alert('listno: ' + listno); 
		if( formA.auto_check.value==''){
			alert('Please enter an auto-prevention character! ');
			formA.auto_check.focus();
			return false;
		}
		xx = formA.auto_check.value;
		if(xx != xauto){
			alert('Auto-typing prevention characters are incorrect : ' + xx );//Auto-typing prevention characters are incorrect 0u1nvd : 0
			formA.auto_check.focus();
			return;
		}
		if( !id ){
			var p1 = document.tx_editor_formA.password.value;
			if( !p1 ) { alert('Enter Password! ' ); document.tx_editor_form.password.focus();  return false; }
			var p2 = document.tx_editor_form.passwordG.value;
			if( p1 == p2 )	document.tx_editor_form.submit();
			else {
				alert('Password is incorrect! p:' + p1 );
				document.tx_editor_form.password.focus();
				return false;
			}
		} 
			if(formA.nameA.value==''){
				alert('Please enter your name.');
				formA.nameA.focus();
				return false;
			}
			if(formA.subject.value==''){
				alert('Please enter a title. ');
				formA.subject.focus();
				return false;
			}
			ff= formA.file.value;
			fileup = formA.fileup_yn.value;
			if ( fileup > 0 && ff != "" ){
				idx_path = formA.file.value.lastIndexOf("."); 
				if ( idx_path < 0 ) {
					idx_colon = formA.file.value.lastIndexOf(".");
				 if ( idx_colon >= 0 )
					temp = formA.file.value.substring(idx_colon);
				} else {
					temp = formA.file.value.substring(idx_path);
				}
				temp = temp.toLowerCase();
				if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"){
					alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx Format Please! \n 형식이어야 합니다.");
					return;
				}
				formA.file_ext.value=temp;
			}
			formA.mode.value='update_funcTT'
			formA.action='updateD_check.php'; // modify_check.php
			formA.submit();
	}

	function email_check( email ) {
		alert(' email ' + email);

	  if (ereg("(^[a-zA-Z0-9]{1}([_0-9a-zA-Z-]+)@[^\.@]+(\.[0-9a-zA-Z-]{2,})*(\.([a-zA-Z]{2,})$))",email)){
		$return = true;}
		else {$return = false;}
	  return $return;
	}

	 function back_go(infor,list_no, page) {
		x = document.tx_editor_form;

		x.infor.value=infor;
		x.list_no.value=list_no;
		x.page.value=page;
		
		x.action=x.previous.value;
		x.submit();
	}

</script>

</head>
<body>
<?php 
		$cur='B';
		include_once "../menu_run.php"; 
?>
<div class="wrapper">
		<div id="write_page" class="mainProject">
<form name="tx_editor_form" id="tx_editor_form" action="updateD_check.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<!-- <input type ="hidden" name = "doc_idx2" value="<?=$doc_idx?>"> -->

		<input type="hidden" name='auto_char'	value='<?=$auto_char?>' /><!-- my_func -->

			<input type='hidden' name='infor' 			value='<?=$infor?>' > 
			<input type='hidden' name='list_no'			value='<?=$list_no?>'>
			<input type='hidden' name='page' 			value='<?=$page?>'>
			<!-- <input type='hidden' name='security_' 		value='1'> -->
			<input type='hidden' name='security_yn' 	value='<?=$mf_infor[51]?>'>
			<input type='hidden' name='fileup_yn' 		value='<?=$mf_infor[3]?>'><!-- upload file size -->
			<input type='hidden' name='html_yn' 		value='<?=$mf_infor[7]?>'>
			<input type='hidden' name='file_ext' 		value=''>
			<input type="hidden" name='previous'		value='<?=$_REQUEST["previous"]?>' />

			<input type='hidden' name='mode'			value=''>
			<input type='hidden' name='target'			value='<?=$mf[3]?>'>
			<input type='hidden' name='step'			value='<?=$mf[4]?>'>
			<input type='hidden' name='re'				value='<?=$mf[5]?>'>
			<input type='hidden' name='search_choice'	value='<?=$search_choice?>'>
			<input type='hidden' name='search_text'		value='<?=$search_text?>'>
			<input type="hidden" name="passwordG" value="<?=$mf[9]?>" >

			<div class="boardView">
				<div class="viewHeader">
					<span><?=$in_day?></span>

					<a href="javascript:back_go('<?=$infor?>','<?=$list_no?>','<?=$page?>')" class="btn_bo02">Previous</a>
					<a href="javascript:board_listTT();" class="btn_bo02">List</a>
					<!-- 위 목록 버튼은 절대경로로 사이트 주소를 풀로 적고 뒤에 #customer 를 적어서 ID값으로 이동하게끔 하면 됨 -->
				</div>

				<div class="viewSubj"><span><?=$mf_infor[1]?> - [ Update ]</span> </div>
				<ul class="viewForm">

<?php 
	if( $H_ID != "" && $H_LEV > 1 ){
?>
					<li class="autom_tit">
						<span class="t01">Writer</span>
						<span class="t02"><input type="text" name="nameA" id='nameA' value='<?=$H_NAME?>' placeholder="Please enter a name." readonly></span>
					</li>
<?php
	} else {
?>
					<!-- <li class="autom_tit">
						<span class="t01">Writer</span>
						<span class="t02"><input type="text" name="nameA" id='nameA' value='<?=$H_NAME?>' placeholder="Please enter a name."></span>
					</li>
					<li>
						<span class="t01">E-Mail</span>
						<span class="t02"><input type="text" name="email" align=center itemname="E-Mail" type="text" placeholder="Please enter a E-Mail " required="required" value=''></span>
					</li>
					<li class="pw_char">
						<span class="t01">password</span>
						<span class="t02"><input type="text" name="password"  placeholder="Please enter your password, you will need it."></span>
					</li> -->
<?php } ?>
					<li class="autom_tit">
						<span class="t01">Title</span>
						<span class="t02">
							<input type="text" name="subject" value='<?=$mf[6]?>' placeholder="Please enter a title! " class="autom_subj" >
						</span>
					</li>

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
	$_SESSION['infor'] = $infor;
	require_once ('write_head.php');
?>
				<div class="viewFooter">
					<ul class="viewForm_2">
<?php if($mf_infor[3]){ ?><!-- 첨부화일. -->
						<li>
							<span class="t01">Attachments</span>
							<span class="t02 select_file">
								<input type="text" name="fileAW" style="padding-top:12.5px;" value='<?=$mf[7]?>' readonly>
								<input type="hidden" name="fileW" value='<?=$mf[8]?>' >
							</span>
						</li>
						<li>
							<span class="t01">Attachments</span>
							<span class="t02 select_file">
								<input type="file" name="fileA" style="padding-top:12.5px;">
							</span>
						</li>
<?php } ?>
						<li>
							<span class="t01">Auto-Protect : <?=$auto_char?></span>
							<span class="t02"><!-- 대소문자 구분! -->
							<input type="text" name="auto_check"  placeholder="Please enter the Auto-Protect text on the left! Case sensitivity! " required="required"></span>
							</span>
						</li>
					</ul>
					<div class="cradata_check">
						<!-- <a href="javascript:update_func('<?=$auto_char?>', '<?=$list_no?>', '<?=$H_ID?>');" class="btn_bo03">Save</a> -->
						<a href="javascript:saveContent('<?=$auto_char?>', '<?=$list_no?>', '<?=$H_ID?>');" class="btn_bo03">Save</a>
					</div>
				</div>
			</div>
		</div>
 	</div><!-- end : container -->
</form>
</div><!-- end : wrapper-->

<script type="text/javascript">
	var content = '<?php echo $content; ?>';
	var config = {
    txHost: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */
    txPath: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */
    txService: 'sample', /* 수정필요없음. */
    txProject: 'sample', /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
    initializedId: "", /* 대부분의 경우에 빈문자열 */
    wrapper: "tx_trex_container", /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
    form: 'tx_editor_form'+"", /* 등록하기 위한 Form 이름 */
    txIconPath: "./images/icon/editor/", /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
    txDecoPath: "./images/deco/contents/", /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */
    canvas: {
            exitEditor:{
                /*
                desc:'빠져 나오시려면 shift+b를 누르세요.',
                hotKey: {
                    shiftKey:true,
                    keyCode:66
                },
                nextElement: document.getElementsByTagName('button')[0]
                */
            },
      styles: {
        color: "#123456",		/* 기본 글자색 */
        fontFamily: "굴림",		/* 기본 글자체 */
        fontSize: "10pt",		/* 기본 글자크기 */
        backgroundColor: "#fff", /*기본 배경색 */
        lineHeight: "1.5",		/*기본 줄간격 */
        padding: "8px"			/* 위지윅 영역의 여백 */
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
      contentWidth: 1500 /* 지정된 본문영역의 넓이가 있을 경우에 설정 */
    }
  };
 
  EditorJSLoader.ready(function(Editor) {
    var editor = new Editor(config);
  });
</script>
 
<script type="text/javascript">
  function saveContent(xauto, no, id) {
		var formA = document.tx_editor_form;
		if( formA.auto_check.value==''){
			alert('Please enter an auto-prevention character! ');
			formA.auto_check.focus();
			return false;
		}
		xx = formA.auto_check.value;
		if(xx != xauto){
			alert('Auto-typing prevention characters are incorrect : ' + xx );//Auto-typing prevention characters are incorrect 0u1nvd : 0
			formA.auto_check.focus();
			return;
		}

		/*if( !id ){
			var p1 = document.tx_editor_formA.password.value;
			if( !p1 ) { alert('Enter Password! ' ); document.tx_editor_form.password.focus();  return false; }
			var p2 = document.tx_editor_form.passwordG.value;
			if( p1 == p2 )	document.tx_editor_form.submit();
			else {
				alert('Password is incorrect! p:' + p1 );
				document.tx_editor_form.password.focus();
				return false;
			}
		} */

			if(formA.nameA.value==''){
				alert('Please enter your name.');
				formA.nameA.focus();
				return false;
			}
			if(formA.subject.value==''){
				alert('Please enter a title. ');
				formA.subject.focus();
				return false;
			}
			formA.mode.value='update_funcTT'


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
    // Place your validation logic here
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
  function setForm(editor) { // 저장할때 여기를 탄다.
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
                //alert('attachment information - image[' + i + '] \r\n' + JSON.stringify(images[i].data));
				// 수정 저장할때 여기를 탄다.
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'attach_image';
                input.value = images[i].data.imageurl;  // 예에서는 이미지경로만 받아서 사용
                form.createField(input);
            }
        }
        var files = editor.getAttachments('file');
        for (i = 0; i < files.length; i++) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'attach_file';
            input.value = files[i].data.attachurl;
            form.createField(input);
        }
        return true;
  }
function youTubeImplant() {
    var popUrl = "./youtube.html";
    var popOption = "./youtube.html";
    window.open(popUrl, "", popOption);
}

</script>
 
<script type="text/javascript">
  function loadContent() {
	var content = '<?php echo $content; ?>';
    var attachments = {};
    attachments['image'] = [];
    attachments['file'] = [];
    /* 저장된 컨텐츠를 불러오기 위한 함수 호출 */
    Editor.modify({
      "attachments": function () { // 저장된 첨부가 있을 경우 배열로 넘김, 위의 부분을 수정하고 아래 부분은 수정없이 사용 
        var allattachments = [];
        for (var i in attachments) {
          allattachments = allattachments.concat(attachments[i]);
        }
        return allattachments;
      }(),
      "content": content /* document.getElementById("sample_contents_source") 내용 문자열, 주어진 필드(textarea) 엘리먼트  sample_contents_source */
       /* "content": content 내용 문자열, 주어진 필드(textarea) 엘리먼트  sample_contents_source */
    });
  }
</script>
<!-- End: Loading Contents -->
<script>
	window.onload = function()
	{
		loadContent();
	}
</script>

</body>
</html>
