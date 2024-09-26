<?php
	include_once('../tkher_start_necessary.php');

	$H_ID= get_session("ss_mb_id"); $ip = $_SERVER['REMOTE_ADDR'];
	$H_LEV = $member['mb_level'];
	$H_EMAIL = $member['mb_email'];
	//m_( $H_LEV. ", H_EMAIL: ". $H_EMAIL);
	/* -------------------------------------------------
		contents_view_menuD_change.php : change comment 
		call : contents_view_menuD_change.php
		table : {$tkher['webeditor_comment_table']}
	----------------------------------------------------- */
	if( isset($_POST['num']) ) $num = $_POST['num'];
	else $num = '';
	if( isset($_POST['seq']) ) $seq = $_POST['seq'];
	else $seq = '';
	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode ='';
	if( isset($_POST['mid'])) $mid   = $_POST['mid'];
	else $mid ='';

	//m_( $H_LEV. ", mode: ". $mode.", num: ". $num. ", seq: ".$seq);//9, mode: change_comment, num: solpakan1716537167, seq: 1
	if( !$H_ID ) {
		m_("Sign in now! You do not have permission. ");//\\n 로그인 하세요! 권한이 없습니다.
		$rungo = "./contents_view_menuD.php?num=$num";
		echo "<script>window.open( '$rungo' , '_top', ''); </script>";
		exit;
	}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>App Generator Tree Menu. Made in Kang, Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="../logo/logo25a.jpg">
<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'> 
<meta name='keywords' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, asp, javascript, python, raspberry pi, arduino, esp8266, php, java, generator, source code, open source, tkher, tool, soho, html, html5, css3, '> 
<meta name='description' content='app, tree, tree menu, app make, appgenerator, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 '> 
<meta name="robots" content="ALL">
</head>
<!-- <link href="/t/include/css/default.css" rel="stylesheet" type="text/css"> -->
<!-- <script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script> -->

	<link href="<?=KAPP_URL_T_?>/menu/css/main.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=KAPP_URL_T_?>/menu/css/editor.css" type="text/css" charset="utf-8"/>
	<script src="<?=KAPP_URL_T_?>/menu/js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">


		function boardSubmit()
		{
			var frm = document.tx_editor_form;
			frm.mode.value="save_update";
			frm.action="contents_view_menuD_change.php";
			frm.submit();
		}
		function cancelSubmit(num)
		{
			var frm = document.tx_editor_form;
			frm.action="contents_view_menuD.php?num="+num;
			frm.submit();
		}
		function retSubmit(num)
		{
			var frm = document.tx_editor_form;
			//frm.action="contents_view_menuD_change.php?num="+num;
			frm.action="contents_view_menuD_change.php";
			frm.submit();
		}

</script>
<?php

	if ( $mode =="save_update") {
		$reply = $_POST['content'];
		$returnValue = sql_query("UPDATE {$tkher['webeditor_comment_table']} SET reply='$reply' WHERE seq=$seq");

		if (!$returnValue)
		{
			echo "<script>window.alert('DB Update Error.');	top.document.location.href='contents_view_menuD.php?num=$num';</script>";
		} else {
			m_("ok update");
			echo "<script>retSubmit('".$num."');</script>";
		}
	} 



		$ret = sql_query("select * from {$tkher['webeditor_comment_table']} WHERE seq=$seq" );
		$rs = sql_fetch_array( $ret );
		$content = $rs['reply'];		//m_(" content: ". $content );
		//m_(" title: ". $rs['title'] );
?>
<body bgcolor="#ffffff" text="#000000" topmargin="0" leftmargin="0" >
	<center>
		
		<!-- <form name="boardForm" method="post" enctype="multipart/form-data" > -->
		<form name='tx_editor_form' id='tx_editor_form' action='contents_view_menuD_change.php' method='post' accept-charset='utf-8'>

			<input type='hidden' name='mode' value='' >
			<input type='hidden' name='num'  value="<?=$num?>" >
			<input type='hidden' name='seq'  value="<?=$seq?>" >
<?php
//		$ret = sql_query("select * from {$tkher['webeditor_comment_table']} WHERE seq=$seq ");
//		$rs = sql_fetch_array($ret);
//		$reply = $rs['reply'];

	//m_(" title: ". $rs['title'] );

	//if( $upfile) $addfile="Attached file:[" . $align . "]";
	//$addfile="[]";
	if( $H_ID and $H_ID == $rs['user'] || $from_session_lev > 7)  {
	?>
		<DIV style='background-color:yellow;color:black;text-align:left;'>
		[ Title :<?= $rs['title']?> ] [user:<?=$rs['user']?> - point:<?=number_format($member['mb_point'])?>] 
			<input type='button' value=' Save ' onClick="javascript:saveContent(this,'update', '<?=$H_ID?>');">
			<!-- &nbsp;<a href='./download.php?num=<?=$_REQUEST['num']?>'  style='background-color:blue;color:yellow'><?=$addfile?></a> -->

			<input type='button' onclick="cancelSubmit('<?=$num?>');"	value=' Back ' style="cursor:hand;">&nbsp;
		</DIV>
<?php } else {?>
		<DIV style='background-color:yellow;color:black;text-align:left'>
		[ Title : <?=$rs['title']?> ] [user:<?=$rs['user']?>]</DIV>
<?php } ?>

<!-- <div>
				<input type='button' onclick="saveContent(this, '$H_ID');"	value=' Save comment ' style="cursor:hand;">&nbsp;
				<input type='button' onclick="cancelSubmit();"	value=' Cancel ' style="cursor:hand;">&nbsp;
</div> -->

		<?php
			//require_once ('../../contents/bbs/write_head.php');
			require_once ('write_head.php');
		?>
		</form>
	</center>


<script type="text/javascript">

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

	function saveContent(x, id) {

		//alert(" saveContent id: "+id);

		if( !id ) {
			alert('Please login! ');
			return false;
		}
		var x = document.tx_editor_form;
		x.mode.value="save_update";
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
