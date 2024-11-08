<?php
	include_once('../tkher_start_necessary.php');
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<TITLE>Board App Generator System. Made in Kang Chul Ho : solpakan89@gmail.com</TITLE> 
<link rel="shortcut icon" href="/logo/logo25a.jpg">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta name="keywords" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3, ">
<meta name="description" content="app generator, web app, web, homepage, development, php, generator, source code, open source, tkher, tool, soho, html, html5, css3 ">
<meta name="robots" content="ALL">

<?php

	$ss_mb_id		= get_session("ss_mb_id");   //"ss_mb_id";
	$ss_mb_level	= $member['mb_level'];    //get_session("ss_mb_level");   //"ss_mb_id";
	$H_ID			= get_session("ss_mb_id");
	$H_LEV			= $member['mb_level'];  
	$H_NAME			= $member['mb_name'];  
	$H_NICK			= $member['mb_nick'];  
	$H_EMAIL		= $member['mb_email'];  
	$ip				= $_SERVER['REMOTE_ADDR'];

		$email			= $member['mb_email'];  //		m_("email:$email");//email:solpakan59@gmail.com
		$mode = $_POST['mode'];

		if( isset($_REQUEST['list_no']) ) $list_no = $_REQUEST['list_no'];
		else if( isset($_POST['list_no']) ) $list_no = $_POST['list_no'];

		if( isset($_REQUEST['infor']) ) $infor = $_REQUEST['infor'];
		else if( isset($_POST['infor']) ) $infor = $_POST['infor'];
		if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
		else if( isset($_POST['page']) ) $page = $_POST['page'];

		if( $mode != 'replyTT' || !$list_no ) {
			m_("mode:$mode , You do not have permission to reply. no:$list_no"); 
			echo "<script>history.back(-1);</script>"; exit;
		}
		$in_day = date("Y-m-d H:i");

	include "./infor.php";
	switch( $mf_infor[47] ){
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
	}

?>

<link rel="stylesheet" href="../include/css/common.css" type="text/css" />
<!-- <link rel="stylesheet" href="../../t/include/css/default.css" type="text/css" /> -->
<script type="text/javascript" src="../include/js/ui.js"></script>
<script type="text/javascript" src="../include/js/common.js"></script>
<!-- <SCRIPT src="../js/contents_resize.js" type='text/javascript'></SCRIPT> -->

        <link href="<?php echo KAPP_URL_T_;?>/menu/css/main.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo KAPP_URL_T_;?>/menu/css/editor.css" type="text/css" charset="utf-8"/>
		<script src="<?php echo KAPP_URL_T_;?>/menu/js/editor_loader.js?environment=development" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

	function board_listTT() {
		x = document.tx_editor_form;
		infor = x.infor.value;
		//alert('infor:'+infor);
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
		//var contents = x.contents.value;
		var contents = document.getElementById("EditCtrl").value;
		alert('nm:'+nm+' , contents:'+contents);
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
		/*
		if(x.EditCtrl.value==''){
			alert('Please enter your content \n 내용을 입력하세요');
			x.EditCtrl.focus();
			return false;
		}*/

		security = x.security_yn.value;
		fileup = x.fileup_yn.value;
		if( security > 0) {	// 비밀글 작성 가능시에.
			//alert('111 --------- security:' + security);
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
			//alert('222222 --------- fileup:' + fileup );
		}
		
		//alert('--------- fileup:' + fileup );

		if( fileup > 0 ){	// 첨부화일 가능시에.
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

				//alert(' temp:'+temp);	return false;	// temp:.html
				if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"  && temp != ".mp3" && temp != ".mp4" && temp != ".avi" ){
					alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx xat Please! \n 형식이어야 합니다.");
					return;
				}
				x.file_ext.value=temp;
			}
		}
			//location.href="customer_write.php?uid="+uid;
		x.mode.value='insert_formTT'; 
		x.action='replyD_check.php'; // x.action='query_ok_new.php';
		x.submit();

	}
	//-------------------------------------------------
	function reply_func(xauto){ // No use
		var form = document.tx_editor_form; //tx_editor_form
		if(form.auto_check.value==''){
			alert('Please enter an auto-prevention character! ');
			form.auto_check.focus();
			return false;
		}

		xx = form.auto_check.value;
		if(xx == xauto){

		} else {
			alert('Auto-typing prevention characters are incorrect ' + xauto + ' : ' + xx );
			return false;
		}
		
		if( form.nameA.value==''){
			alert('Please enter your name.');
			form.nameA.focus();
			return false;
		}
		if( form.subject.value==''){
			alert('Please enter a title. ');
			form.subject.focus();
			return false;
		}
		/*if(tx_editor_form.context.value==''){
			alert('Please enter your content \n 내용을 입력하세요');
			tx_editor_form.context.focus();
			return false;
		}*/

		ff= form.file.value;
		//alert('ff:'+ff);	//ff:C:\fakepath\aboard_tkher58.sql
		if (form.file.value != ""){
			idx_path = form.file.value.lastIndexOf("."); 
			if ( idx_path < 0 ) {
				idx_colon = form.file.value.lastIndexOf(".");
			 if ( idx_colon >= 0 )
				temp = form.file.value.substring(idx_colon);
			} else {
				temp = form.file.value.substring(idx_path);
			}

			//alert(' temp:'+temp);	return false;	// temp:.html
			if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppk" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"){
				alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppk,alz,rar,pptx,xlsx Format Please! \n 형식이어야 합니다.");
				return;
			}
			form.file_ext.value=temp;
		}

		form.mode.value='reply_funcTT'
		form.submit();
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

<?php
	$str  = "abcdefghijklmnopqrstuvwxyz";
    $str .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str .= "0123456789";

    $shuffled_str = str_shuffle($str);
	$auto_char=substr($shuffled_str, 0, 6);
	//-----------------------------------------------------------------------------------------------------
	$query="select no,name,context,target,step,re,subject from aboard_" . $mf_infor[2] . " where no=".$list_no;
//	$query="SELECT * from aboard_" . $mf_infor[2] . " where no='$list_no'";
	$mq=sql_query($query);
	$mf=sql_fetch_row($mq);
	$mf[2]="[ ".$H_ID." Sir ]\n".$mf[2]; // context
	$mf[6]="Re: ".$mf[6]; //subject

?>

<div class="wrapper">
		<div id="write_page" class="mainProject">

<!-- <form name='reply_form' action='query_ok_new.php' method='post' enctype="multipart/form-data" > -->
<form name="tx_editor_form" id="tx_editor_form" action="replyD_check.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">

		<input type="hidden" name='auto_char'	value='<?=$auto_char?>' />
<!--		<input type="hidden" name='c_sel'		value='<?=$c_sel?>' />
		<input type="hidden" name='id'			value='<?=$id?>' />
		<input type="hidden" name='board'		value='<?=$board?>' />
		<input type="hidden" name='target_'		value='<?=$target_?>' />
		<input type="hidden" name='name'		value='<?=$H_NAME?>' />
-->		
			<input type='hidden' name='mode'			value='reply_funcTT'>
			<input type='hidden' name='infor'       value='<?=$infor?>' > 
			<input type='hidden' name='list_no'   value='<?=$list_no?>'>
			<input type='hidden' name='page'      value='<?=$page?>'>
			<input type='hidden' name='security_yn' value='<?=$mf_infor[51]?>'>
			<input type='hidden' name='fileup_yn' value='<?=$mf_infor[3]?>'>
			<input type='hidden' name='file_ext'  value=''>
			<input type="hidden" name='previous'  value='<?=$_REQUEST['previous']?>' />

			<input type='hidden' name='target'			value='<?=$mf[3]?>'>
			<input type='hidden' name='step'			value='<?=$mf[4]?>'>
			<input type='hidden' name='re'				value='<?=$mf[5]?>'>
			<input type='hidden' name='search_choice'	value='<?=$search_choice?>'>
			<input type='hidden' name='search_text'		value='<?=$search_text?>'>

			<div class="boardView">
				<div class="viewHeader">
					<span><?=$in_day?></span>

					<a href="javascript:back_go('<?=$_REQUEST['infor']?>','<?=$_REQUEST['list_no']?>','<?=$_REQUEST['page']?>')" class="btn_bo02">Previous</a>
					<a href="javascript:board_listTT();" class="btn_bo02">List</a>
					<!-- 위 목록 버튼은 절대경로로 사이트 주소를 풀로 적고 뒤에 #customer 를 적어서 ID값으로 이동하게끔 하면 됨 -->
				</div>

				<div class="viewSubj"><span><?=$mf_infor[1]?></span> </div>
				<ul class="viewForm">
					<!--
					<li>
						<span class="t01">휴대폰</span>
						<span class="t02"><input type="text" name="user_phone"  placeholder="전화번호를 입력하세요."></span></span>
					</li> 
					<li>
						<span class="t01">홈페이지</span>
						<span class="t02"><input type="text" name="homep" placeholder="홈페이지주소를 입력하세요." ></span>
					</li>-->
<?php 
	if( $H_ID !== "" && $H_LEV > 1 ){
?>
					<li class="autom_tit">
						<span class="t01">Writer</span>
						<span class="t02"><input type="text" name="nameA" id='nameA' value='<?=$H_NICK?>' placeholder="Please enter a name." readonly></span>
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

<?if($mf_infor[51]){?><!-- 비밀글. -->
		<!-- <tr>
      <td width="15%" height="12" bgcolor="<?=$mf_infor[25]?>" align="center">
        <font color="<?=$mf_infor[26]?>">Secret article<br>(비밀글)</td>
		<td width="75%" height="12">
		<input type="radio" value="use" name="security1" id="security1"> use
		<input type="radio" value="nouse" checked name="security1" id="security1"> no use
        <input type="text" value="" name="security" size="10" style='border:1 black solid;' title='This is required when writing secrets. 비밀 글을 작성할때 필요합니다.'> (password) </td>
		</tr>-->
					<li class="autom_tit">
						<span class="t01">Secret article</span>
						<span >
							<input type="radio" value="use" name="security1" id="security1"> use
							<input type="radio" value="nouse" checked name="security1" id="security1"> no use
							<input type="text"  value="" name="security" size="10" style='border:1 black solid;' title='This is required when writing secrets.'> (password) 
						</span>
					</li>
<?}?>
				</ul>

		<!-- <table border="0" width="100%" borderColorDark="#fdfdfa" borderColorLight="#bec9d4" cellSpacing="0" cellpadding="0">
			<tr bordercolor="#FFFFFF" bgcolor="#FFFFFF">
			 <td>

				<DIV id='editctrlX' align='' style='background-color:yellow;ime-mode:active; background-image:; width:100%; height:100%; '>
				<textarea name="EditCtrl" id="EditCtrl" ></textarea>
				</DIV>

					<script>
						//CKEDITOR.replace( 'EditCtrl' );//처음것. 아래것은:화면크기조정 가능.
						CKEDITOR.replace(
						'EditCtrl',
						{
						customConfig: '/contents/ckeditor/config.js',
						toolbar : 'standard',
						language: 'en',
						width : '100%',
						height : '100'
						}
						);
					</script>

			</td>
			</tr>
		</table> -->

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
						<!-- <li class="pw_char" oncontextmenu='return false' ondragstart='return false' onselectstart='return false' >
							<span class="t01">Auto-Protect : <?=$auto_char?></span>
							<span class="t02"><?=$auto_char?></span>
						</li> -->
						<li>
							<span class="t01">Auto-Protect : <?=$auto_char?></span>
							<span class="t02"><!-- 대소문자 구분! -->
							<input type="text" name="auto_check"  placeholder="Please enter the Auto-Protect text on the left! Case sensitivity! " required="required"></span>
							</span>
						</li>
					</ul>
					<div class="cradata_check">
						<!-- <a href="javascript:reply_func('<?=$auto_char?>');" class="btn_bo03">Save</a> -->
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
	//alert("--- content: " + content);

  var config = {
    txHost: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */
    txPath: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */
    txService: 'sample',                   /* 수정필요없음. */
    txProject: 'sample',                   /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
    initializedId: "",                     /* 대부분의 경우에 빈문자열 */
    wrapper: "tx_trex_container",          /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
    form: 'tx_editor_form'+"",             /* 등록하기 위한 Form 이름 */
    txIconPath: "./images/icon/editor/",   /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
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
 
<!-- Sample: Saving Contents -->
<script type="text/javascript">
  /* 예제용 함수 */
  function saveContent(xauto, no, id) {

		var form = document.tx_editor_form; //tx_editor_form
		if(form.auto_check.value==''){
			alert('Please enter an auto-prevention character! ');
			form.auto_check.focus();
			return false;
		}

		xx = form.auto_check.value;
		if(xx == xauto){

		} else {
			alert('Auto-typing prevention characters are incorrect ' + xauto + ' : ' + xx );
			return false;
		}
		
		if( form.nameA.value==''){
			alert('Please enter your name.');
			form.nameA.focus();
			return false;
		}
		if( form.subject.value==''){
			alert('Please enter a title. ');
			form.subject.focus();
			return false;
		}
		/*if(tx_editor_form.context.value==''){
			alert('Please enter your content \n 내용을 입력하세요');
			tx_editor_form.context.focus();
			return false;
		}*/

		ff= form.fileA.value;		//alert('ff:'+ff);	//ff:C:\fakepath\aboard_tkher58.sql
		if (form.fileA.value != ""){
			idx_path = form.fileA.value.lastIndexOf("."); 
			if ( idx_path < 0 ) {
				idx_colon = form.fileA.value.lastIndexOf(".");
				if ( idx_colon >= 0 ) temp = form.fileA.value.substring(idx_colon);
			} else {
				temp = form.fileA.value.substring(idx_path);
			}

			//alert(' temp:'+temp);	return false;	// temp:.html
			if( temp != ".jpg" && temp != ".gif" &&temp != ".png" &&temp != ".zip" && temp != ".csv" && temp != ".xls" && temp != ".hwp" && temp != ".pdf" && temp != ".txt" && temp != ".pem" && temp != ".ppt" && temp != ".alz" && temp != ".rar" &&temp != "pptx" && temp != "xlsx"){
				alert(" jpg,gif,png,zip,csv,xls,hwp,pdf,txt,pem,ppt,alz,rar,pptx,xlsx Format Please!");
				return;
			}
			form.file_ext.value=temp;
		}

		form.mode.value='reply_funcTT'


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
	  //alert('validForm ----------- '); //저장할때 여기를 탄다.
    // Place your validation logic here : 여기에 유효성 검사 논리를 배치하십시오.
 
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
  function setForm(editor) { // 저장할때 여기를 탄다.
        var i, input;
        var form = editor.getForm();
        var content = editor.getContent();
         // alert('content: ' + content); 
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

    var popUrl    = "./youtube.html";
    var popOption = "./youtube.html";
    window.open(popUrl, "", popOption);
}

</script>
<!-- <div><button onclick='saveContent()'>SAMPLE - submit contents</button></div> -->
<!-- End: Saving Contents -->
 
<!-- Sample: Loading Contents -->
<!-- 
<script type="text/javascript">
  function loadContent() {

	//var content = '<?php echo $data["content"]; ?>';
	//var content = '<?php echo $mf[2]; ?>';
	var content = '<?php echo $content; ?>';
	//alert("---2 content: " + content); // OK
	
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
 -->
<!--<div><button onclick='loadContent()'>SAMPLE - load contents to editor</button></div>-->
<!-- End: Loading Contents -->
<!-- 
<script>
window.onload = function()
{
	loadContent();
}
</script>
 -->
</body>
</html>
