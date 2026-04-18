<?php
	include_once('../tkher_start_necessary.php');
	/*
		replyD.php : general board
	*/
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>K-APP. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/icon/_board_.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">
<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	if( isset($_POST['search_choice']) ) $search_choice = $_POST['search_choice'];
	else $search_choice = "";
	if( isset($_POST['search_text']) ) $search_text   = $_POST['search_text'];
	else $search_text = "";
	if( isset($_POST['mode']) ){
		$mode = $_POST['mode'];
	} else $mode =''; 
	if( $mode !== 'replyTT' ) {
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page'>";
		exit;
	}
	if( isset($_REQUEST['infor']) ) $infor = $_REQUEST['infor'];
	else if( isset($_POST['infor']) ) $infor = $_POST['infor'];
	else { 
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page'>";
		exit;
	}
	$_SESSION['infor'] = $infor;
	if( isset($_REQUEST['list_no']) ) $list_no = $_REQUEST['list_no'];
	else if( isset($_POST['list_no']) ) $list_no = $_POST['list_no'];
	else echo "<script>history.back(-1);</script>";
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;
	$in_day = date("Y-m-d H:i");
	include "./infor.php";
	$grant_read	= $mf_infor[46];
	$grant_write= $mf_infor[47];

	$H_ID = get_session("ss_mb_id");
	if( $H_ID && $H_ID !=='' && $H_ID !=='Guest') {
		$H_LEV	= $member['mb_level'];  
		$H_NAME	= $member['mb_name'];  
		$H_NICK	= $member['mb_nick'];  
		$H_EMAIL = get_session("ss_mb_email"); 
	} else {
		if( $grant_write > 1 ){
			echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page'>";
			exit;
		} else {
			$H_NICK	= 'Guest';
			$H_NAME = 'Guest';
			$H_LEV	= 1;
			$H_ID	= 'Guest';  
			$H_EMAIL= ''; 
		}
	}

	if( $H_LEV < $mf_infor[47] && $H_ID !== $mf_infor[53]){
		echo "<meta http-equiv='refresh' content=0;url='detailD.php?infor=$infor&list_no=$list_no&page=$page'>";
		exit;
	}
?>
<link rel="stylesheet" href="../include/css/default.css" type="text/css" />
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>
<script type='text/javascript' src="../include/js/contents_resize.js" ></script>
<link rel="stylesheet" href="./css/main.css" type="text/css" >
<link rel="stylesheet" href="./css/editor.css" type="text/css" charset="utf-8"/>
<script type='text/javascript' src="./js/editor_loader.js?environment=development" charset="utf-8"></script>


<script type="text/javascript">
	function board_listTT() {
		x = document.tx_editor_form;
		infor = x.infor.value;
		x.action='listD.php?infor='+infor;
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
	function board_write(x,board, xauto){
		x = document.tx_editor_form;
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
		var contents = document.getElementById("EditCtrl").value;
		if(x.nameA.value==''){
			alert('Please enter a name! ');
			x.nameA.focus();
			return false;
		}
		if(x.subject.value==''){
			alert('Please enter a title! ');
			x.subject.focus();
			return false;
		}
		security = x.security_yn.value;
		fileup = x.fileup_yn.value;
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
		}
		if( fileup > 0 ){	// add file
			ff= x.file.value;
			if (x.file.value != ""){
				idx_path = x.file.value.lastIndexOf("."); 
				if ( idx_path < 0 ) {
					idx_colon = x.file.value.lastIndexOf(".");
					if ( idx_colon >= 0 ) temp = x.file.value.substring(idx_colon);
				} else {
					temp = x.file.value.substring(idx_path);	//toLowerCase()
				}
				temp = temp.toLowerCase();
				if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"  && temp != ".mp3" && temp != ".mp4" && temp != ".avi" ){
					alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx xat Please! \n 형식이어야 합니다.");
					return;
				}
				x.file_ext.value=temp;
			}
		}
		x.mode.value='insert_formTT'; 
		x.action='replyD_check.php'; 
		x.submit();
	}
	function email_check( email ) {
	  if (ereg("(^[a-zA-Z0-9]{1}([_0-9a-zA-Z-]+)@[^\.@]+(\.[0-9a-zA-Z-]{2,})*(\.([a-zA-Z]{2,})$))",email)){
		$return = true;}
		else {$return = false;}
	  return $return;
	}
	 function back_go( infor,list_no, page) {
 		x = document.tx_editor_form;
		x.infor.value=infor;
		x.list_no.value=list_no;
		x.page.value=page;
		x.action=x.previous.value;
		x.submit();
	}
</script>
</head>

<body style='background-color:#fff;color:#000;' >
<?php 
	$cur='B';
	include_once "../menu_run.php"; 
	$query="SELECT * from aboard_" . $mf_infor[2] . " where no=". $list_no;
	$mf = sql_fetch($query);
	$mf['context'] = "[ ".$H_ID." Sir ]\n" . $mf['context']; 
	$mf['subject'] = "Re: ".$mf['subject']; 
	$mf_id = $mf['id'];
	$mf_name = $mf['name'];
	$mf_email = $mf['email'];
	$mf_subject = $mf['subject'];
	$mf_context = $mf['context'];
	$content = $mf['context'];
	if( isset($_REQUEST['previous']) ) $previous = $_REQUEST['previous'];
	else  $previous = "";
?>
<div class="wrapper">
		<div id="write_page" class="mainProject">
<form name="tx_editor_form" id="tx_editor_form" action="replyD_check.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<input type="hidden" name='auto_char'	value='<?=$auto_char?>' /><!-- my_func -->
			<input type='hidden' name='mode'	value='reply_funcTT'>
			<input type='hidden' name='infor'   value='<?=$infor?>' > 
			<input type='hidden' name='list_no' value='<?=$list_no?>'>
			<input type='hidden' name='page'    value='<?=$page?>'>
			<input type='hidden' name='security_yn' value='<?=$mf_infor[51]?>'>
			<input type='hidden' name='fileup_yn'   value='<?=$mf_infor[3]?>'>
			<input type='hidden' name='file_ext'    value=''>
			<input type="hidden" name='previous'    value='<?=$previous?>' />
			<input type='hidden' name='target'		value='<?=$mf['target']?>'>
			<input type='hidden' name='step'		value='<?=$mf['step']?>'>
			<input type='hidden' name='re'			value='<?=$mf['re']?>'>
			<input type='hidden' name='search_choice' 		value='<?=$search_choice?>'>
			<input type='hidden' name='search_text' 		value='<?=$search_text?>'>
			<div class="boardView">
				<div class="viewHeader">
					<span><?=$in_day?></span>
					<a href="javascript:back_go('<?=$infor?>','<?=$list_no?>','<?=$page?>')" class="btn_bo02">Previous</a>
					<a href="javascript:board_listTT();" class="btn_bo02">List</a>
				</div>
				<div class="viewSubj"><span><?=$mf_infor[1]?></span> </div>
				<ul class="viewForm">
<?php if( $H_ID !== "" && $H_LEV > 1 ){ ?>
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
<?php } else { ?>
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
							<input type="text" id="subject" name="subject" value='<?=$mf_subject?>' placeholder="Please enter a title! " class="autom_subj" >
						</span>
					</li>

				</ul>
<?php 
	$_SESSION['infor'] = $infor;
	require_once ('write_head.php');
?>
				<div class="viewFooter">
					<ul class="viewForm_2">
<?php
		if( isset($mf_infor[3]) ){ 
				if( isset( $mf['context']) ) $mf_context = $mf['context'];
				else $mf_context = "";
				if( isset( $mf['subject']) ) $mf_subject = $mf['subject'];
				else $mf_subject = "";
?>
						<li>
							<span class="t01">Attachments</span>
							<span class="t02 select_file">
								<input type="text" name="fileAW" style="padding-top:12.5px;" value='<?=$mf['file_name']?>' readonly>
								<input type="hidden" name="fileW" value='<?=$mf_subject?>' >
							</span>
						</li>
						<li>
							<span class="t01">Attachments</span>
							<span class="t02 select_file">
								<input type="file" id="fileA" name="fileA" style="padding-top:12.5px;">
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
						<a href="javascript:saveContent( '<?=$auto_char?>', '<?=$list_no?>', '<?=$H_ID?>');" class="btn_bo03">Submit</a>
					</div>
				</div>
			</div>
		</div>
 	</div><!-- end : container -->
</form>

</div><!-- end : wrapper-->

<script type="text/javascript">
  var config = {
    txHost: '<?=KAPP_URL_T_?>', /*The part needed to load resources at runtime */
    txPath: '<?=KAPP_URL_T_?>', /* The part needed to load resources at runtime  */
    txService: 'kapp', /* sample */
    txProject: 'kapp', /* sample */
    initializedId: "", /* In most cases, an empty string */
    wrapper: "tx_trex_container", /* The name of the layer surrounding the editor (editor container) */
    form: 'tx_editor_form'+"", /* Form name */
    txIconPath: "./images/icon/editor/", /* Image directory used by the editor. */
    txDecoPath: "./images/deco/contents/", /* Image directory used in the body */
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
        color: "#123456",		/*  */
        fontFamily: "Arial",		/* */
        fontSize: "10pt",		/* */
        backgroundColor: "#fff", /*  */
        lineHeight: "1.5",		/*Default line spacing */
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
 
<!-- Sample: Saving Contents -->
<script type="text/javascript">
  function saveContent( xauto, no, id) {
		var form = document.tx_editor_form;
		if( id == 'Guest' ) {
			if( form.password.value==''){
				alert('Please enter a password! ');
				form.password.focus();
				return false;
			}
			if(form.email.value==''){
				alert('Please enter a email! ');
				form.email.focus();
				return false;
			}
		}
		if( form.nameA.value==''){
			alert('Please enter your name.');
			form.nameA.focus();
			return false;
		}
		if( form.auto_check.value==''){
			alert('Please enter an auto-prevention character! ');
			form.auto_check.focus();
			return false;
		}
		xx = form.auto_check.value;
		if( xx == xauto){
		} else {
			alert('Auto-typing prevention characters are incorrect ' + xauto + ' : ' + xx );
			form.auto_check.focus();
			return false;
		}
		if( form.subject.value==''){
			alert('Please enter a title. ');
			form.subject.focus();
			return false;
		}
		ff= form.fileA.value;
		if( form.fileA.value != ""){
			idx_path = form.fileA.value.lastIndexOf("."); 
			if( idx_path < 0 ) {
				idx_colon = form.fileA.value.lastIndexOf(".");
				if ( idx_colon >= 0 ) temp = form.fileA.value.substring(idx_colon);
			} else {
				temp = form.fileA.value.substring(idx_path);
			}
			if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppt" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"){
				alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppt,alz,rar,pptx,xlsx Format Please!");
				return;
			}
			form.file_ext.value=temp;
		}
		form.mode.value='reply_funcTT'
    Editor.save(); // data save
  }
 
  function validForm(editor) {
    var validator = new Trex.Validator();
    var content = editor.getContent();
    if (!validator.exists(content)) {
      alert('data enter!');
      return false;
    }
 
    return true;
  }
 
  function setForm(editor) { // save routine
        var i, input;
        var form = editor.getForm();
        var content = editor.getContent();
        var textarea = document.createElement('textarea');
        textarea.name = 'content';
        textarea.value = content;
        form.createField(textarea);
         var images = editor.getAttachments('image');
        for (i = 0; i < images.length; i++) {
            if (images[i].existStage) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'attach_image';
                input.value = images[i].data.imageurl;
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
		var popUrl    = "./youtube.html";
		var popOption = "./youtube.html";
		window.open(popUrl, "", popOption);
	}
</script>


</body>
</html>
