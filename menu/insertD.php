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
	//if( $infor ) $_SESSION['infor'] = $infor;
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

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['page']) ) $page = $_POST['page'];
	else $page = 1;
	if( isset($_POST['menu_mode']) ) $menu_mode=$_REQUEST['menu_mode'];
	else $menu_mode = '';
	$in_day = date("Y-m-d H:i");
	$grant_write=$mf_array['grant_write'];
		/*
		switch( $mf_infor[47] ){ // 47=grant_write
			case '0': break;			// error
			case '1': 					// guest
			case '2': //member
			case '3': // only my
		} */
		if( $grant_write > 1 && $H_LEV < $grant_write ) { 
			m_("You do not have permission to write. " . $H_ID . ", " . $H_LEV . ", write: " . $grant_write); 
			echo "<meta http-equiv='refresh' content=0;url='listD.php?infor=$infor&list_no=$list_no&page=$page'>";
		}
	$amember_name	= $H_NICK;
	$amember_id		= $H_ID;
	$mf_47 = $mf_infor[47];
?>

<script type="text/javascript">

	function board_listD(menu_mode, infor) {
		x = document.tx_editor_form;
		x.action='listD.php?infor='+infor+'&menu_mode=' +menu_mode;
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

</head>
<body width='100%'>
<?php 
	$cur='A';
	if( $menu_mode != 'off') include_once "../menu_run.php";
	include "./headerD.php";
?>

<div class="wrapper">
	<div id="write_page" class="mainProject">
<form name="tx_editor_form" id="tx_editor_form" action="insertD_check.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<input type="hidden" name='mode'		value='' />
		<input type="hidden" name='auto_char'	value='<?=$auto_char?>' />
		<input type="hidden" name='c_sel'		value='<?=$c_sel?>' />
		<input type="hidden" name='id'			value='<?=$id?>' />
		<input type="hidden" name='board'		value='<?=$board?>' />
		<input type="hidden" name='target_'		value='<?=$target_?>' />
		<input type="hidden" name='name'		value='<?=$H_NICK?>' />
		<input type='hidden' name='security_'   value='1'>
		<input type='hidden' name='security_yn' value='<?=$mf_infor[51]?>'>
		<input type='hidden' name='fileup_yn'   value='<?=$mf_infor[3]?>'><!-- upload file size -->
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
					<a href="javascript:board_listD('<?=$menu_mode?>', '<?=$infor?>');" class="btn_bo02">List</a>
				</div>
				<div class="viewSubj"><span><?=$mf_infor[1]?></span> </div>
				<ul class="viewForm">
<?php
if( $H_ID && $H_ID == 'Guest' ){
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

			</ul>
<?php 
	$_SESSION['infor'] = $infor;
	require_once ('write_head.php');
?>
				<div class="viewFooter">
					<ul class="viewForm_2">
<?php if($mf_infor[3]){ ?>
						<li>
							<span class="t01">Attachments</span>
							<span class="t02 select_file">
								<input type="file" name="fileA" id="fileA"  style="padding-top:12.5px;">
							</span>
						</li>
<?php } ?>
						<li>
							<span class="t01">Auto-Protect : <b><?=$auto_char?></b></span>
							<span class="t02">
							<input type="text" name="auto_check"  placeholder="Please enter the Auto-Protect text on the left! Case sensitivity! " required="required"></span>
							</span>
						</li>
					</ul>
						<a href="javascript:saveContent(this, '<?=$auto_char?>', '<?=$H_ID?>');" class="btn_bo02">Save</a>
					<a href="javascript:board_listD('<?=$menu_mode?>', '<?=$infor?>');" class="btn_bo02">List</a>


				</div>
			</div>
		</div>
 	</div><!-- end : container -->
</form>
</div><!-- end : wrapper-->

<script type="text/javascript">
	var config = {
		txHost: '<?=KAPP_URL_T_?>', /* */
		txPath: '<?=KAPP_URL_T_?>', /* */
		txService: 'kapp', /* sample */
		txProject: 'kapp', /* sample */
		initializedId: "", /* In most cases, an empty string */
		wrapper: "tx_trex_container", /* layer name (edit container) */
		form: 'tx_editor_form'+"", /* Form name */
		txIconPath: "images/icon/editor/", /* image dir */
		txDecoPath: "images/deco/contents/", /*The image directory used in the body of the text is modified to an absolute path when used in a service so that it can be distributed as completed content.*/
		canvas: {
			styles: {
				color: "#123456", /* basic font color */
				fontFamily: "Arial", /* basic font */
				fontSize: "10pt", /* basic font size */
				backgroundColor: "#fff", /* basic background color */
				lineHeight: "1.5", /* Default line spacing */
				padding: "8px" /* Margins of WYSIWYG area */
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
			contentWidth: 1500 /* If there is a width of the specified body area, set it to 700 1500 */
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
		if( id == 'Guest' ) {
			if(x.password.value==''){
				alert('Please enter a password! ');
				x.password.focus();
				return false;
			}
			if(x.email.value==''){
				alert('Please enter a email! ');
				x.email.focus();
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
		/* var contents = document.getElementById("EditCtrl").value; */
		fileup = x.fileup_yn.value;
		ff= x.fileA.value;
		if( fileup > 0 && ff !== "" ){
			ff= x.fileA.value;
			if (x.fileA.value != ""){
				input = document.getElementById('fileA');
				file_sz = input.files[0].size;
				file_sz = file_sz / 1024 / 1024;
				if( file_sz > fileup ) {
					alert( fileup +"Mb Only uploaded below. file size:" + file_sz );
					return false;
				}
				idx_path = x.fileA.value.lastIndexOf("."); 
				if ( idx_path < 0 ) {
					idx_colon = x.fileA.value.lastIndexOf(".");
					if ( idx_colon >= 0 ) temp = x.fileA.value.substring(idx_colon);
				} else {
					temp = x.fileA.value.substring(idx_path);
				}
				temp = temp.toLowerCase();
				if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xlsx" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"  && temp != ".mp3" && temp != ".mp4" && temp != ".avi" ){
					alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx,mp3,mp4,avi Please format!");
					return;
				}
				x.file_ext.value=temp;
			}
		}
		Editor.save();
		formA.submit();
		return true;

	}

	/**
	 * A callback function called to check if the data is valid when Editor.save() is called.
	 * Modify and use according to the situation.
	 * Returns true if all data is valid.
	 * @function
	 * @param {Object} editor -editor object passed from the editor
	 * @returns {Boolean} true if all data is valid
	 */
	function validForm(editor) {
		/* Place your validation logic here sample : validate that content exists */
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
	 * @param {Object} editor - editor object passed from the editor
	 * @returns {Boolean} true in normal cases
	 */
	function setForm(editor) {
        var i, input;
        var form = editor.getForm();
        var content = editor.getContent();

        /* The part where the body content creates a field and assigns a value */
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
