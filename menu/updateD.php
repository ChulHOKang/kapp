<?php
	include_once('../tkher_start_necessary.php');
	/*
	updateD.php : general board

	email is incorrect! email:solpakan59@gmail.com
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
	include "./infor.php";
	$grant_read	= $mf_infor[46];
	$grant_write= $mf_infor[47];
	$ip = $_SERVER['REMOTE_ADDR'];

	$H_ID = get_session("ss_mb_id");
	if( $H_ID && $H_ID !=='') {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
		$H_EMAIL = get_session("ss_mb_email"); 
	} else {
		$email	= '';  
		if( $grant_write > 1 ){
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page'>";
			exit;
		} else {
			$H_ID	= 'Guest';  
			$H_NICK	= 'Guest';
			$H_NAME = 'Guest';
			$H_LEV	= 1;
			$H_EMAIL= ''; 
		}
	}

	if( isset($_POST['mode']) ) $mode    = $_POST['mode'];
	else if( isset($_REQUEST['mode']) ) $mode= $_REQUEST['mode'];
	else $mode  = "";
	if( isset($_REQUEST['list_no']) ) $list_no = $_REQUEST['list_no'];
	else if( isset($_POST['list_no']) ) $list_no = $_POST['list_no'];

	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	if( $mode != 'updateTT' || !$infor ) {
		m_("mode:".$mode." , You do not have permission to reply. infor:".$infor); 
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page'>";
	}
	$in_day = date("Y-m-d H:i");
	$query="select * from aboard_" . $mf_infor[2] . " where no=".$list_no;
	$mf = sql_fetch( $query );
	$content = $mf['context'];	//$content = htmlspecialchars( $mf['context'] );
	$email = $mf['email'];
	if( $mf_infor[47]== 1 && $H_ID == 'Guest' ){
		$H_NAME = $mf['name'];
		$H_EMAIL = $mf['email'];
		$H_ID = $mf['id'];
	}

	if( $H_LEV < $mf_infor[47] && $H_ID !== $mf_infor[53] && $mf['email']!==$H_EMAIL){
		m_("$H_ID, member permission to read. $mf_infor[47] - $mf_infor[53]"); 
		echo "<meta http-equiv='refresh' content=0;url='listD.php?infor=$infor&list_no=$list_no&page=$page'>";
		exit;
	}
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
			alert('Auto-typing prevention characters are incorrect : ' + xx );
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

		<input type="hidden" name='auto_char'	value='<?=$auto_char?>' />
			<input type='hidden' name='infor' 			value='<?=$infor?>' > 
			<input type='hidden' name='list_no'			value='<?=$list_no?>'>
			<input type='hidden' name='page' 			value='<?=$page?>'>
			<input type='hidden' name='security_yn' 	value='<?=$mf_infor[51]?>'>
			<input type='hidden' name='fileup_yn' 		value='<?=$mf_infor[3]?>'>
			<input type='hidden' name='html_yn' 		value='<?=$mf_infor[7]?>'>
			<input type='hidden' name='file_ext' 		value=''>
			<input type="hidden" name='previous'		value='<?=$_REQUEST["previous"]?>' />
			<input type='hidden' name='mode'			value=''>
			<input type='hidden' name='target'			value='<?=$mf['target']?>'>
			<input type='hidden' name='step'			value='<?=$mf['step']?>'>
			<input type='hidden' name='re'				value='<?=$mf['re']?>'>
			<input type='hidden' name='search_choice'	value='<?=$search_choice?>'>
			<input type='hidden' name='search_text'		value='<?=$search_text?>'>
			<input type="hidden" name="passwordG" value="<?=$mf['password']?>" >

			<div class="boardView">
				<div class="viewHeader">
					<span><?=$in_day?></span>
					<a href="javascript:back_go('<?=$infor?>','<?=$list_no?>','<?=$page?>')" class="btn_bo02">Previous</a>
					<a href="javascript:board_listTT();" class="btn_bo02">List</a>
				</div>
				<div class="viewSubj"><span><?=$mf_infor[1]?> - [ Update ]</span> </div>
				<ul class="viewForm">
<?php if( $H_ID != "" && $H_LEV > 1 ){ ?>
					<li class="autom_tit">
						<span class="t01">Writer</span>
						<span class="t02"><input type="text" name="nameA" id='nameA' value='<?=$H_NAME?>' placeholder="Please enter a name." readonly></span>
					</li>
<?php } else if( $grant_write == 1 ){ ?>
					<li class="autom_tit">
						<span class="t01">Name</span>
						<span class="t02"><input type="text" name="nameA" id='nameA' value='<?=$H_NAME?>' placeholder="Please enter a name." readonly></span>
					</li>
					<li>
						<span class="t01">E-Mail</span>
						<span class="t02"><input type="text" name="email" align=center itemname="E-Mail" type="text" placeholder="Please enter a E-Mail " required="required" id='email' value='<?=$H_EMAIL?>'></span>
					</li>
					<li class="pw_char">
						<span class="t01">password</span>
						<span class="t02"><input type="password" name="password" placeholder="Please enter your password, you will need it." value=''></span>
					</li>
<?php } ?>
					<li class="autom_tit">
						<span class="t01">Title</span>
						<span class="t02">
							<input type="text" name="subject" value='<?=$mf['subject']?>' placeholder="Please enter a title! " class="autom_subj" >
						</span>
					</li>
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
								<input type="text" name="fileAW" style="padding-top:12.5px;" value='<?=$mf['file_wonbon']?>' readonly>
								<input type="hidden" name="fileW" value='<?=$mf['file_name']?>' >
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
							<span class="t02">
							<input type="text" name="auto_check"  placeholder="Please enter the Auto-Protect text on the left! Case sensitivity! " required="required"></span>
							</span>
						</li>
					</ul>
					<div class="cradata_check">
						<a href="javascript:saveContent('<?=$auto_char?>', '<?=$list_no?>', '<?=$mf['email']?>');" class="btn_bo03">Save</a>
					</div>
				</div>
			</div>
		</div>
 	</div><!-- end : container -->
</form>
</div><!-- end : wrapper-->

 
<script type="text/javascript">
  function saveContent(xauto, no, email_id) {
		var formA = document.tx_editor_form;
		xx = formA.auto_check.value;
		var p1 = formA.password.value;
		var p2 = formA.passwordG.value;
		if( email_id == formA.email.value ){
			if( p1 =='' ) {
				alert('Enter Password! ' );
				formA.password.focus();
				return false;
			} else if( p1 == p2 ) {
				if( formA.auto_check.value==''){
					alert('Please enter an auto-prevention character! ');
					formA.auto_check.focus();
					return false;
				}
			} else {
				alert('Password is incorrect! p:' + p1 );
				formA.password.focus();
				return false;
			}
		} else {
				alert('email is incorrect! email:' + formA.email.value + ', email_id: ' +email_id  );
				//email is incorrect! email:solpakan59@gmail.com, id: Guest
				//email is incorrect! email:solpakan59@gmail.com
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
		if(xx == xauto){
			formA.mode.value='update_funcTT'
			Editor.save();
			formA.submit();
			return true;
		} else {
			alert('Auto-typing prevention characters are incorrect ' + xauto + ' : ' + xx );
			formA.auto_check.focus();
			return false;
		}
		return false;
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
      alert('Please enter the content');
      return false;
    }
    return true;
  }
 
  /**
   * After calling Editor.save(), the validForm callback is executed.
   * A callback function that is called to create and change form fields for actual form submission.
   * Use it appropriately according to each situation.
   * @function
   * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
   * @returns {Boolean} 정상적인 경우에 true
   */
  function setForm(editor) { // save here
        var i, input;
        var form = editor.getForm();
        var content = editor.getContent();

        /* The part where the body content creates a field and assigns a value */
        var textarea = document.createElement('textarea');
        textarea.name = 'content';
        textarea.value = content;
        form.createField(textarea);
 
        /* The code below creates fields and assigns values ​​to attached data. Modify it to suit your situation. Only the attached data of a given type (image, file, etc.) is passed as an array. */
        var images = editor.getAttachments('image');
        for (i = 0; i < images.length; i++) {
            /* existStage is whether the current text exists or not */
            if (images[i].existStage) {
                /* data is data passed through execAttach, etc. in the pop-up */
				/* Click here when saving edits. */
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
    /* Call a function to retrieve saved content */
    Editor.modify({
      "attachments": function () { /* If there are saved attachments, pass them as an array, modify the upper part, and use the lower part without modification. */
        var allattachments = [];
        for (var i in attachments) {
          allattachments = allattachments.concat(attachments[i]);
        }
        return allattachments;
      }(),
      "content": content /* document.getElementById("sample_contents_source") Content string, textarea  sample_contents_source */
       /* "content": content Content string, textarea  sample_contents_source */
    });
  }
</script>
 
<script type="text/javascript">
	var config = {
    txHost: '<?=KAPP_URL_T_?>', /* The part needed to load resources at runtime */
    txPath: '<?=KAPP_URL_T_?>', /* The part needed to load resources at runtime */
    txService: 'kapp', /* sample . */
    txProject: 'kapp', /* sample . Modify only if there are multiple projects. */
    initializedId: "", /* In most cases, an empty string*/
    wrapper: "tx_trex_container", /* The name of the layer surrounding the editor (editor container) */
    form: 'tx_editor_form'+"", /* Form name for registration */
    txIconPath: "./images/icon/editor/", /* Image directory used by the editor */
    txDecoPath: "./images/deco/contents/", /* The image directory used in the body of the text is modified to an absolute path when used in a service so that it can be distributed as completed content. */
    canvas: {
            exitEditor:{
                /*
                desc:'Press shift+b to exit.',
                hotKey: {
                    shiftKey:true,
                    keyCode:66
                },
                nextElement: document.getElementsByTagName('button')[0]
                */
            },
      styles: {
        color: "#123456",		/* basic font color */
        fontFamily: "Arial",		/* basic font */
        fontSize: "10pt",		/* basic font size */
        backgroundColor: "#fff", /* basic background color */
        lineHeight: "1.5",		/* Default line spacing */
        padding: "8px"			/* WYSIWYG area margins */
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
      contentWidth: 1500 /* Set if there is a width of the specified text area */
    }
  };
 
  EditorJSLoader.ready(function(Editor) {
    var editor = new Editor(config);
  });
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
