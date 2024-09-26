<?php
	include_once('../tkher_start_necessary.php');

	$H_ID		= get_session("ss_mb_id");  $ip = $_SERVER['REMOTE_ADDR'];
	if( isset($member['mb_level']) ) $H_LEV =$member['mb_level'];
	else $H_LEV = 0;
	if( isset($member['mb_email']) ) $H_EMAIL =$member['mb_email'];
	else $H_EMAIL = '';
	/* -------------------------------------------------
		contents_view_menuD_main.php : change comment <- my_editor2_book_comment_menu.php copy 
		call : contents_view_menuD.php 
		table : {$tkher['webeditor_table']}, webeditor_comment
	----------------------------------------------------- */
	$num='';
	if( isset($_REQUEST['num']) ) $num = $_REQUEST['num'];
	else if( isset($_POST['num']) ) $num = $_POST['num'];

	if( !$H_ID || !$num) {
		m_("Sign in now! You do not have permission. ");//\\n 로그인 하세요! 권한이 없습니다.
		//$rungo = "./contents_view_menuD.php?num=$num";
		//if( $num ) echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator Tree Menu. Made in Kang, Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="<?=KAPP_URL_T_?>/logo/logo25a.jpg">
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> 
<meta name='keywords' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> 
<meta name='description' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> 
<meta name="robots" content="ALL">
</head>

<!-- <link href="/t/include/css/default.css" rel="stylesheet" type="text/css">
<script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script> -->

	<!-- <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/contents/bbs/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/contents/bbs/css/editor.css" type="text/css" charset="utf-8"/>
	<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/contents/bbs/js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script> -->

	<link href="<?=KAPP_URL_T_?>/menu/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=KAPP_URL_T_?>/menu/css/editor.css" type="text/css" charset="utf-8"/>
	<script src="<?=KAPP_URL_T_?>/menu/js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>

<script>
	<!--
		function boardSubmit()
		{
			var frm = document.tx_editor_form;
			frm.mode.value="save_update";
			frm.action="contents_view_menuD_main.php";
			frm.submit();
		}
		function cancelSubmit(num)
		{
			var frm = document.tx_editor_form;
			//frm.action="contents_view_menuD.php?num="+num;
			frm.action="contents_view_menuD.php";
			frm.submit();
		}
		function retSubmit()
		{
			var frm = document.tx_editor_form;
			frm.action="contents_view_menuD.php";
			frm.submit();
		}
	-->
</script>
<?php

	function special_chk ($input) { // 특수문자 제거. "'"만 제거한다.
		if( is_array($input)) { //m_("---1");
			return array_map('special_chk', $input); 
		} else if( is_scalar($input)) { //m_("---2");
				return preg_replace("/'/i", "", $input); //return preg_replace("/[ #\/\\\:;,'\"`<>()]/i", "", $input);
		} else { //m_("---3");
			return $input; 
		} 
	}

	$mid   = '';
	$mode  = '';
	$seq  = '';
	$book_num = '';	
	$sys_pg   = '';	
	$target_run  = '';

	if( isset($_POST['mid']))  $mid  = $_POST['mid'];
	if( isset($_POST['mode'])) $mode = $_POST['mode'];
	if( isset($_POST['seq']))  $seq  = $_POST['seq'];	//m_("seq:$seq, mode:$mode");
	if( isset($_POST['book_num']))   $book_num = $_POST['book_num'];	
	if( isset($_POST['book_num']))   $sys_pg   = $_POST['book_num'];	
	if( isset($_POST['target_run'])) $target_run = $_POST['target_run'];
	//m_("mode: " . $mode . ", " . $num . ", " . $sys_pg); // mode: update,  dao1643878113, dao1642730463
	
	if( $mode == "Save_encrypted_run" ) {
		$open_sel  = $_POST['open_sel'];
		$old_title	= $_POST['old_title'];
		$title		= $_POST['title'];
		$content	= $_POST['content'];
		$str		= $content;
		$secret_key = $_POST['form_psw'];
		$content	= Encrypt($str, $secret_key, $link_secret_iv);
		$contentX	= $content;
		$encrypted_check = 'Link_Encrypted_OK';

	} else if( $mode == "Decryption_run") {

		$open_sel	= $_POST['open_sel'];
		$old_title	= $_POST['old_title'];
		$title			= $_POST['title'];
		$secret_key= $_POST['form_psw'];
		$str	= $_POST['content'];
		//$encrypted	= $_POST['BODY0'];
		$content	= Decrypt($str, $secret_key, $link_secret_iv);
		$contentX	= $content;
		$encrypted_check = 'Link_Dcrypted_OK';

	} else if( $mode=="save_update") {

		//if( $upfile_name ) {
		$upfile_name = '';
		if( isset($_FILES["upfile"]["name"]) ) {
			$upfile_name= $_FILES["upfile"]["name"];
			$upfile_size= $_FILES["upfile"]["size"];
			if( $upfile_size >  $upload_file_size_limit ) {		// my_func. 3*1000000
				m_("$upload_file_size_limit byte Only uploaded below");
				// \n $upload_file_size_limit byte 이하만 업로드 가능합니다 
				echo "<script>window.open( 'content_view_menuD_main.php?num=$num' , '_top',''); </script>";
				exit;
			}
			$ext_name		= substr($upfile_name, -4);
			$upfile_name	= str_replace(" ", "", $upfile_name);
			if( isset($_POST['up_file']) ) $up_file	= $_POST['up_file'];
			else $up_file = '';
			if( isset($_POST['in_dir']) ) $in_dir = $_POST['in_dir']; 
			else $in_dir = '';; 
			$f_path		= "./" . $in_dir . "/";
			$jtree_dir	= "./" . $in_dir;
			$f_del		= "./" . $in_dir . "/" . $up_file;
			if( !is_dir($jtree_dir) ) {
				if( !@mkdir( $jtree_dir, 0777 ) ) {
					echo " Error: $jtree_dir : " . $jtree_dir . " Failed to create directory.";exit;
					echo "<script>window.open( 'content_view_menuD_main.php?num=$num' , '_top',''); </script>";
				}
			}
			$uid = explode('@', $H_ID); // 2024-05-28
			//$upfile2	= $H_ID . "_" . time() . $ext_name;
			$upfile2	= $uid[0] . "_" . time() . $ext_name;

			move_uploaded_file($_FILES["upfile"]["tmp_name"], $f_path . $upfile2 );
			if( file_exists( $f_del ) ) {
				unlink( $f_del );
			}

		}
		if( isset($_POST['open_sel'])) $open_sel   = $_POST['open_sel'];
		else $open_sel   ='';
		if( isset($_POST['bgimg'])) $bgimg		= $_POST['bgimg'];
		else $bgimg   =''; 
		if( isset($_POST['title'])) $title		= $_POST['title'];
		else $title   ='';
		if( isset($_POST['old_title'])) $old_title	= $_POST['old_title'];
		else $old_title   ='';
		if( isset($_POST['BODYBGC'])) $BODYBGC	= $_POST['BODYBGC'];
		else $BODYBGC   ='';
		if( isset($_POST['BODYBG'])) $BODYBG		= $_POST['BODYBG'];
		else $BODYBG   ='';
		if( isset($_POST['savetype'])) $savetype	= $_POST['savetype'];
		else $savetype   ='';
		if( isset($_POST['content'])) $content	= $_POST['content'];
		else $content   ='';
		$content = special_chk( $content );

		if( $encrypted_check == 'Link_Encrypted_OK' ) $content	= $_POST['contentX'];
		if( $encrypted_check == 'Link_Dcrypted_OK' ) $content	= $_POST['contentX'];
		if( $upfile_name ) {
			$returnValue = sql_query(" UPDATE {$tkher['webeditor_table']} SET h_lev='$open_sel', title='$title', content='$content', up_file='$upfile2', align='$upfile_name' WHERE num='$num' ");
		} else {
			$returnValue = sql_query(" UPDATE {$tkher['webeditor_table']} SET title='$title', content='$content' WHERE num='$num' ");
		}

		if( !$returnValue){
			echo "<script>
					window.alert('DB Update Error.');
					document.location.target='run_menu';
					document.location.href='contents_view_menuD.php?num=$num';
				</script>
			";
		} else {
			if( $title == $old_title ){	//m_("" . $title . ", " . $old_title . ", ok save");
				echo	"<script>
				document.location.target='run_menu'; document.location.href='contents_view_menuD.php?num=$num';	
				</script>";
			} else{
				$sys_pg  = $book_num;
				$xsys_pg = $book_num;
				$sys_subtit = $title;
				$sql = "update {$tkher['job_link_table']} set user_name='$sys_subtit' where user_id='$H_ID' and aboard_no='$num' ";
				sql_query( $sql ); 

				if( !$savetype ) { //// 1:단독 등록자료구분 . 트리가없다. !!!!!!!!!증요!!!!!!!!!!
					$sql_a = "update {$tkher['sys_menu_bom_table']} set sys_subtit='$sys_subtit' where sys_userid='$H_ID' and book_num='$num' ";
					sql_query( $sql_a );  
					//$rungo = KAPP_URL_ . '/t/tree_menu_guest.php?sys_pg=' . $sys_pg . '&open_mode=on&mid='.$mid.'&doc_num='.$num;
					$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg . '&open_mode=on&mid='.$mid.'&doc_num='.$num;

					$run_mode = 'cratree_update_book_my';
					//$run_mode = 'cratreebook_update';
					include "./index_create.php"; // include "./tree_create_menu.php"; // 2021-03-02 change
					echo "<script>window.open('$rungo', '_top', ''); </script>";
				}
			}
		}
	}	// save_update
	else if( $mode=='update' ){
		$sql = "SELECT * from {$tkher['webeditor_table']} WHERE num='$num' ";
		$ret = sql_query($sql);
		$row = sql_fetch_array( $ret );
		$title	= $row['title']; 
		$content= $row['content'];

		if( $row['user'] != $H_ID && $H_LEV < 8) {
			m_("I'm not the author! ");//\n 작성자가 아닙니다. 권한이 없습니다. 
			$rungo = "./contents_view_menuD.php?num=$num"; //echo "<script>window.open( '$rungo' , '_top', ''); </script>";
			//$rungo = KAPP_URL_T_ . '/tree_menu_guest.php?sys_pg=' . $sys_pg . '&open_mode=on&mid='.$mid.'&doc_num='.$num;
			$rungo = KAPP_URL_T_ . '/menu/tree_run.php?sys_pg=' . $sys_pg . '&open_mode=on&mid='.$mid.'&doc_num='.$num;
			echo "<script>
				document.location.target='run_menu'; document.location.href='".$rungo."';	
				</script>";
			exit;
		}

		if( $row['user'] == $row['book_name'] ) 
				$savetype='1';				// 단독 등록자료구분 . 트리가없다. !!!!!!!!!증요!!!!!!!!!! 
		else	$savetype='0';

		$in_dir		= substr($row['date'], 0, 7);
		$open_sel	= $row['h_lev'];
		$up_file	= $row['up_file'];
		$afile		= $row['align'];
		$old_title	= $row['title'];
		$addfile = "Attached file:[none]";
		if( $up_file ) $addfile = "Attached file:[" . $afile . "]";
		//$content = htmlspecialchars($row['content'], ENT_QUOTES);

	} else {
		m_("--------- ERROR mode:" . $mode);
	}
?>
<body bgcolor="#ffffff" text="#000000" topmargin="0" leftmargin="0" >
	<center>
		<!-- <form name="boardForm" method="post" enctype="multipart/form-data" > -->
		<form name='tx_editor_form' id='tx_editor_form' action='contents_view_menuD_main.php' method='post' accept-charset='utf-8'>
			<input type='hidden' name='mode' value='' >
			<input type='hidden' name='seq' value='<?=$seq?>' >
			<input type='hidden' name='book_num' value='<?=$sys_pg?>' ><!-- book_num -->

			<input type='hidden' name='savetype' value='<?=$savetype?>' >
			<input type='hidden' name='num' value='<?=$num?>' >

			<input type='hidden' name='contentX' value='<?=$contentX?>' >

			<input type='hidden' name='bgcolorX' value='<?=$bgcolorX?>' >
			<input type='hidden' name='fontcolorX' value='<?=$fontcolorX?>' >

			<input type='hidden' name='in_dir' value='<?=$in_dir ?>' >
			<input type='hidden' name='up_file' value='<?=$up_file?>' >
			<input type='hidden' name='mid' value='<?=$mid?>' >

			<input type='hidden' name='old_title' value='<?=$old_title?>' >
			<input type='hidden' name='bgimg' value='<?=$bgimg?>' >
			<input type='hidden' name='BODY0' value='<?=$body0?>' >
			<input type='hidden' name='BODYBG' value='<?=$bgimageX?>' >
			<input type='hidden' name='BODYBGC' value='<?=$bgcolorX?>' >
			<input type='hidden' name='myid' value='<?=$myid?>' >
			<input type='hidden' name='target_run' value='<?=$target_run?>' >
			<input type='hidden' name='encrypted_check' value='<?=$encrypted_check?>' >
			<input type='hidden' name='open_sel' value='0' >

<!-- <div>
				<input type='button' onclick="boardSubmit();" value=' Save comment ' style="cursor:hand;">&nbsp;
				<input type='button' onclick="cancelSubmit('<?=$num?>');" value=' Cancel ' style="cursor:hand;">&nbsp;
</div> -->
<div>
				<input type='file' name='upfile' id='upfile' >
				&nbsp;Title:<input type='text' name="title" style="ime-mode:active;height:25;" size="20" class="input" value="<?=$title?>" >
				&nbsp;&nbsp;<input type='button' onclick="saveContent(this, '<?=$H_ID?>', 'U')" value=' Save ' style="cursor:hand;border-radius:20px;" title='view menuD main Save Update'>&nbsp;
				<input type='button' onclick="cancelSubmit('<?=$num?>');" value=' Cancel ' style="cursor:hand;border-radius:20px;">&nbsp;
				&nbsp;<?=$addfile?>
</div>
		<?php
			require_once ('write_head.php');
		?>

		<table border="1" width="100%" borderColorDark="#fdfdfa" borderColorLight="#bec9d4" cellSpacing="0" cellpadding="0">
			<tr bordercolor="#FFFFFF" bgcolor="#006600"> 	
				<td height="31" class="dark_blue" align="center" colspan='2'> 
					&nbsp; Encryption key:
					<input type='password' name='form_psw' size='4' value=''> 
						 &nbsp; <input type=button  onclick="javascript:saveContent(this, '<?=$H_ID?>','E');" value='Encryption' style="border-style:;background-color:red;color:yellow;height:25;" title='view menuD main Save Encryption'>&nbsp; 
					<input type='button'  onclick="javascript:saveContent(this, '<?=$H_ID?>','D');" value='Decryption' style="border-style:;background-color:blue;color:yellow;height:25;" title="Enter the password and press the button!" title='view menuD main Save Decryption'>
				</td>
			</tr>
			<tr bordercolor="#FFFFFF" bgcolor="#006600"> 	
				<td height="31" class="dark_blue" align="center" > 
					<font color='black'>&nbsp; Encrypt and save notes.
					<br> &nbsp; The encryption key is not stored and should be remembered. 
					<br> &nbsp; If you forget the key, the memo can not be decrypted.
					</font>
				</td>
				<!--<td height="31" class="dark_blue" align="center" > 
					<font color=gray>&nbsp; 내용을 암호화하여저장합니다. 
					<br> &nbsp; 암호키는 저장되지않으며 잘기억해두어야합니다. 
					<br> &nbsp; 키를 잊어버리면 메모는 복호화가 불가능합니다.
					</font>
				
				</td>-->
			</tr>
		</table>

		</form>

	</center>


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

		function Save_encrypted(t) {
			form = document.tx_editor_form;
			psw=form.form_psw.value;
			if( !psw ) { alert(' Please enter your passkey! '); return false; }
			if( confirm('Do you want to encrypt and save the note? passkey='+psw + ' \n If you forget your passkey, you will not be able to recover it. ') ) {	//\n 메모를 암호화하여 저장하시겠습니까? \n 암호키를 잊어버리면 복구가불가능합니다. 
				form.mode.value = "Save_encrypted_run";
				//if( t == 'my_solpa_user_r' ) form.target='my_solpa_user_r';
				//else	form.target='url_link_tree_solpa_user_r_my';
				form.target='_self';
				form.action='content_view_menuD_main.php';	//'my_editor2_book_menu.php';
				form.submit();
			}
		}
		function Decryption(t) {
			form = document.tx_editor_form;
			psw = form.form_psw.value;
			if( !psw ) { alert(' Please enter your passkey!'); return false; }
			form.mode.value = "Decryption_run";
			form.target='_self';
			form.action='content_view_menuD_main.php';
			form.submit();
		}

	function saveContent(x, id, type) {

		if( !id ) {
			alert('Please login! ');
			return false;
		}
		var x = document.tx_editor_form; //alert(" saveContent id: "+id);
		if( type == 'E' ){ // Save_encrypted_run
			psw = x.form_psw.value;
			if( !psw ) { alert(' Please enter your passkey! '); return false; }
			if( confirm('Do you want to encrypt and save the note? passkey='+psw + ' \n If you forget your passkey, you will not be able to recover it. ') ) {	//\n 메모를 암호화하여 저장하시겠습니까? \n 암호키를 잊어버리면 복구가불가능합니다. 
				x.mode.value = "Save_encrypted_run";
				//if( t == 'my_solpa_user_r' ) form.target='my_solpa_user_r';
				//else	form.target='url_link_tree_solpa_user_r_my';
				x.target='_self';
			}
		} else if( type == 'D' ){ // Decryption_run
			psw = x.form_psw.value;
			if( !psw ) { alert(' Please enter your passkey!'); return false; }
			x.mode.value = "Decryption_run";
		} else if( type == 'U' ){ // contents Update
			x.mode.value="save_update";
		}

		//x.action="contents_view_menuD_change.php";
		//x.submit();

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

		//console.log(content);

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

        /*var files = editor.getAttachments('file');
        for (i = 0; i < files.length; i++) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'attach_file';
            input.value = files[i].data.attachurl;
            form.createField(input);
        }*/
        return true;
	}

	function youTubeImplant() {

		var popUrl = "./youtube.html";
		var popOption = "./youtube.html";
		window.open(popUrl, "", popOption);
	}

  function loadContent() {

	var content = '<?php echo $content; ?>';
	
    var attachments = {};
    attachments['image'] = [];
    attachments['file'] = [];
    /*
	attachments['image'].push({
      'attacher': 'image',
      'data': {
        'imageurl': 'https://24c.kr/Tboard/uploads',
        'filename': '이미지 024.png',
        'filesize': 59501,
        'originalurl': 'https://24c.kr/Tboard/uploads',
        'thumburl': 'https://24c.kr/Tboard/uploads'
      }
    });
	
    attachments['file'] = [];
    attachments['file'].push({
      'attacher': 'file',
      'data': {
        'attachurl': 'http://cfile297.uf.daum.net/attach/207C8C1B4AA4F5DC01A644',
        'filemime': 'image/gif',
        'filename': 'editor_bi.gif',
        'filesize': 640
      }
    }); */
	//alert("---3 content: " + content);
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
<script>
window.onload = function()
{
	loadContent();
}
</script>


</body>
</html>
<?php
//	if ($mode=="save_update") {
//		if ( $returnValue ) {
//			echo	"<script>retSubmit();</script>";
//		}
//	} 

?>