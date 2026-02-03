<?php
include_once('../tkher_start_necessary.php');

	$host	 = getenv("HTTP_HOST");
	/*
		/manual/user_manual.php
	*/
	$ss_mb_id	= get_session("ss_mb_id");
	$ss_mb_level= $member['mb_level']; 
	$mb_point	= $member['mb_point'];
	$H_ID		= get_session("ss_mb_id");
	$from_session_id		= get_session("ss_mb_id");
	$H_LEV		= $member['mb_level'];  

	$ip  = $_SERVER['REMOTE_ADDR'];		
	$url1 = $_SERVER['PHP_SELF'];
	$url2 = $_SERVER['SCRIPT_FILENAME'];
	$url3 = $_SERVER['DOCUMENT_ROOT'];

	$agent  = getenv("HTTP_USER_AGENT");
	$Accept = getenv("HTTP_ACCEPT");
	$msg = $ip . "|" . $agent . "|" . $Accept;
	$pattern = "/mobile/i";
	if( preg_match($pattern, $agent, $matches)){
		$type='mobile';
	} else{
		$type='pc';
	}
	$ip_num = htol($ip);	//2342680517
	date_default_timezone_set("Asia/Seoul");
	$day = date("Y-m-d H:i:s");

?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="../icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>

<style>
/*This stylesheet sets the width of all images to 100%: */
img { width:100%; }
</style>

<body bgcolor='black'>

<a name="top"></a>
<ul align='center' >
<span style='width:100px;height:100px;background-color:black;'>
		<a href="<?=KAPP_URL_T_?>"><img src="<?=KAPP_URL_T_?>/logo/logo512-512.png" title="KAPP" style='width:100px;height:100px;background-color:black;'></a>
</span>
</ul>

<ul style='font-size:21px;color:yellow;'>
<p align='center'><b>K-APP</b></p>
<p style='font-size:21px;'>App Generator 사용 방법</p>

<a href="https://www.youtube.com/watch?v=HstNaNfthyM" target='_blank' style='color:skyblue'>1. 프로그램 생성 및 소스코드 다운로드 방법 동영상.</a><br>
<br>
<a href="https://www.youtube.com/watch?v=kamVb2L0zrg" target='_blank' style='color:skyblue'>2. 테이블 생성 및 소스코드 다운로드 방법 동영상.</a><br>
<br>
<a href="https://www.youtube.com/watch?v=d3qgtXlF8NI" target='_blank' style='color:skyblue'>3. 트리메뉴 제작 및 소스코드 다운로드 방법 동영상.</a><br>
<br>

<a href="https://www.youtube.com/watch?v=iUsi1MLG5H0" target='_blank' style='color:skyblue'>4. DB Setup 방법 동영상.</a><br>
<br>
<a href="https://www.youtube.com/watch?v=T03pWCObXv8" target='_blank' style='color:skyblue'>5. DB 엑셀화일 업로드 방법 동영상.</a><br>
<br>

<a href="#KAPP" style='color:skyblue'>* '<?=KAPP_URL_T_?>'을 'PC' 또는 '핸드폰'에서 크롬 브라우즈에서 실행.</a><br>
<br>
<a href="#Table_Design" style='color:white'>1. Table_Design 사용 방법</a><br>
<a href="#Table_Source_download" style='color:white'>&nbsp;&nbsp;&nbsp;1.1 Table Source Download 사용 방법</a><br>
<a href="#DB_Setup" style='color:white'>&nbsp;&nbsp;&nbsp;1.2 DB_Setup 사용 방법</a><br>
<a href="#Table_Create" style='color:white'>&nbsp;&nbsp;&nbsp;1.3 사용자서버에 Table을 생성하는 방법</a><br>

<a href="#Program_Create" style='color:white'>2. Program Create 사용 방법</a><br>
<a href="#Program_Upgrade" style='color:white'>3. Program Upgrade 사용 방법</a><br>

<a href="#Column_Attribute" style='color:white'>4. Column Attribute 설정 방법</a><br>
<a href="#Popup_Window" style='color:white'>&nbsp;&nbsp;&nbsp;4.1 Popup Window [Setup] 설정 방법</a><br>
<a href="#Formula" style='color:white'>&nbsp;&nbsp;&nbsp;4.2 Formula [Setup] 설정 방법</a><br>
<a href="#Attached_file" style='color:white'>&nbsp;&nbsp;&nbsp;4.3 Attached file 설정 방법</a><br>
<a href="#Radio" style='color:white'>&nbsp;&nbsp;&nbsp;4.4 Radio Button 설정 방법</a><br>
<a href="#Checkbox" style='color:white'>&nbsp;&nbsp;&nbsp;4.5 Checkbox Button 설정 방법</a><br>
<a href="#Listbox" style='color:white'>&nbsp;&nbsp;&nbsp;4.6 Listbox Button 설정 방법</a><br>

<a href="#Table_Relationship" style='color:white'>5. Table Relationship 사용 방법</a><br>

<a href="#샘플프로그램" style='color:white'>6. 샘플 프로그램 사용 방법</a><br>
<a href="#FTP프로그램" style='color:white'>7. 프로그램 소스를 사용자 서버에서 사용하는 방법</a><br>

<a href="#tree_menu" style='color:white'>8. Tree Menu 제작 방법</a><br>

<a name="KAPP"></a>

<br><ul><li style='font-size:18px;'>Program-Make : 메인화면의 App Make에서 'Program-Make'를 클릭</li></ul>
<img src='./pic_01.png' width='100%'>

<br><ul><li style='font-size:18px;'>Program-Make : </li></ul>
<img src='./pic_001.png' width='100%'>
<ul style='color:white'><li style='font-size:18px;'>Program-Make 설명 : </li></ul>

<a name="Table_Design"></a>
<br><ul><li style='font-size:18px;'>1 Table Design : Table을 생성합니다.</li></ul>
<img src='./pic_table_create.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>1. 'Table Name'을 입력하고, 
<br>2. 'column name'과 'data type'을 정의 하고, 
<br>3. 'size'를 입력하고 
<br>4. 'Create Table'버턴을 클릭하여 Table을 생성합니다.
<br>5. 'Reset'버턴을 클릭하면 입력 내용을 지워버립니다. </li></ul>

<br><ul><li style='font-size:18px;'>1.1 Table 작성예: order_test Table을 컬럼 목록입니다.</li></ul>
<img src='./table_design_column_list.png' style='width:650px;height:450px;'>
<ul style='color:white'><li> 설명 : 
<br>1. 'del' 버턴을 클릭하면 컬럼을 삭제 합니다.
<br>2. 'mod' 버턴을 클릭하면 컬럼을 변경 저장 합니다.
<br>3. 'add' 버턴을 클릭하면 컬럼을 추가 생성 합니다.
<br>4. 'Modification' 버턴을 클릭하면 테이블 변경내용을 저장 합니다.
<br>5. 'New Table' 버턴을 클릭하면 New Table을 생성합니다.
<br>6. 'Reset'버턴을 클릭하면 입력 내용을 지워버립니다. </li></ul>

</li></ul>


<br><ul><li style='font-size:18px;'>1.2 Table List : Table을 생성한 목록입니다.</li></ul>
<img src='./pic_003.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>1. 'Delete' 버턴을 클릭하면 Table을 삭제합니다.
<br>2. 'Download' 버턴을 클릭하면 데이터를 엑셀 화일로 다운로드 합니다.
<br>3. 'Upload' 버턴을 클릭하면 엑셀 화일로 데이터를 Table에 생성합니다.
<br>[Upload excel data sample]<br>
<img src='./excel_data_sample.png' style='width:600px;height:360px'>
</li></ul>

<br><ul><li style='font-size:18px;'>1.2.1 Table Column List : Table목록에서 'Table Name'을 클릭하면 컬럼 목록이 출력됩니다.</li></ul>
<img src='./pic_004.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>1. 'Data Insert' 버턴: 선택한 테이블에 데이터를 등록하는 프로그램을 실행합니다.
<br>2. 'Data List' 버턴: 선택한 테이블의 데이터 목록을 출력합니다.
<br>3. 'All DownLoad' 버턴: 테이블생성및 데이터베이스 설정 관련 소스코드를 압축하여 다운로드 받습니다.
<br>4. 'Create table only' 버턴: 테이블생성 소스코드를 압축하여 다운로드 받습니다.
<br>5. 'Back Return' 버턴: Table 목록으로 이동합니다.

</li></ul>

<a name="Table_Source_download"></a>

<br><ul><li style='font-size:18px;'>1.2.2 All DownLoad 버턴 클릭 화면 : 'Down RUN' 버턴을 클릭하여 소스를 다운로드 받고, 압축을 풉니다.</li></ul>
<img src='./All_Download_list.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>1. 'Down RUN' 버턴을 클릭하여 소스를 다운로드 받고, 
<br>2. 다운받은 화일의 압축을 푼다.
<br>3. 화일들을 사용자의 서버에 FTP로 올려 'urllink_index.php'를 실행합니다. 
<br>4. FTP 프로그램은 주로 오픈소스인 FileZilla를 많이 사용합니다.
<br> - FileZilla 사이트는: <a href="https://filezilla-project.org/">FTP FileZilla 다운로드 사이트 입니다.</a>
</li></ul>

<a name="DB_Setup"></a>
<br><ul><li style='font-size:18px;'>1.2.3 DB Setup and Table Create : 다운로드 받은 화일의 압축을 풀어 사용자의 서버에 업로드하고 'urllink_index.php'를 실행한 화면입니다.</li></ul>
<img src='./db_set_screen.png' width='100%'>
<ul style='color:white'><li> 설명 : '*Host Name'은 'localhost'로 거의 고정입니다.
<br>1. DB Name
<br>2. DB User ID
<br>3. DB User Password
<br> 여기에 입력해야 할 정보는 서버 담당자만이 알고 있는 것으로<br> 담당자에게 문의해서 입력해야 합니다.</li></ul>

<br><ul><li style='font-size:18px;'>1.2.4 Create table only list : 1.3 Table Column List의 'Create table only' 버턴을 클릭하면 출력되는 화면입니다. 
<br>'Down Run'버턴을 클릭하여 소스를 다운로드 받고, 압축을 풉니다.</li></ul>
<img src='./Create_table_only_list.png' width='100%'>
<ul style='color:white'><li> 설명 : Down RUN 링크를 클릭하여 다운받고, 받은 화일의 압축을 풀어 사용자의 서버에 올려 'urllink_index.php'를 실행합니다. </li></ul>

<a name="Table_Create"></a>

<br><ul><li style='font-size:18px;'>1.2.5 Table Create : 사용자 서버에서 Table 생성방법. 'dao_1632726444_table_index.php'를 실행한 화면입니다.
<br>[table name] + '_table_index.php'가 테이블 생성 실행 화일 입니다.
</li></ul> 
<img src='./pic_020.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>1. 'DB Reset' 버턴은 DB 설정을 다시하는 화면으로 이동합니다.
<br>2. 'Table Create' 버턴은 Table 'dao_1632726444'를 생성하는 버턴입니다.
</li></ul>

<br><ul><li style='font-size:18px;'>1.2.6 DB Login : DB Setup을 완료후 'urllink_index.php'를 실행한 화면입니다.</li></ul>
<img src='./DB_Login.png' width='100%'>
<ul style='color:white'><li> 설명 : DB Setup을 완료한후 에 'urllink_index.php'를 실행하면  DB Login 화면이 출력되고 Login을 하면 DB 를 ReSet 할수있습다. 
<br>예를 들어 DB Password를 잘못 입력한경우에 다시 설정 할 수 있습니다.</li></ul>

<a name="Table_Permissions"></a>

<br><ul><li style='font-size:18px;'>1.3 'Table Permissions' : 테이블을 사용을 할수있는 권한을 설정합니다.</li></ul>
<img src='./pic_019.png' width='100%'>
<ul style='color:white'><li> 설명 : 사용자의 Level에 따라 테이블을 읽고 쓸수있는 Level을 설정합니다.
<br>예를 들어 레벨이 '2'이상인 회원은 'Read'할 수있고, 레벨이 '3'인 회원이상은 모드 'Write'할 수 있도록 할려면 read level:2, write level:3으로 설정 합니다.</li></ul>
<a href="#top">Top</a>

<a name="Program_Create"></a>

<br><ul><li style='font-size:18px;'>1.4 'Progeam Create' : 프로그램을 생성합니다. </li></ul>
<img src='./pic_008.png' width='100%'>
<ul style='color:white'><li> 설명 : 새로운 프로그램을 생성합니다.
<br>1. 'Select table'에서 사용할 테이블을 선택합니다. 그러면, 걸럼 목록이 출력 됩니다.
<br>2. 'Program Name'을 입력하고 
<br>3. 'Create' 버턴을 클릭하여 프로그램을 생성합니다. 
<br>'Create' 버턴을 클릭하면 프로그램 명의 중복을 체크후 생성 합니다.
<br>그런다음, 컬럼을 선택 클릭하고 컬럼에 대한 속성을 정의 할 수 있습니다. 
<br>컬럼 속성은 설정은 <a href="#Program_Upgrade">'Program Upgrade'</a>에서 정의 해도 됩니다.</li></ul>

<a href="#top">Top</a>

<a name="Program_Upgrade"></a>

<br><ul><li style='font-size:18px;'>1.5 'Progeam Upgrade' : 프로그램을 수정 보완하여 생성 합니다. </li></ul>
<img src='./program_update.png' width='100%'>
<ul style='color:white'><li> 설명 : program list에서 프로그램을 선택 합니다.
<br>그런다음, 컬럼을 선택 하고 컬럼에데한 속성을 정의 합니다.
<br>'Program Upgrade'에서는 컬럼 속성에 대한 변경, 보완 작업을 할 수 있습니다.
</li></ul>

<a href="#top">Top</a>

<a name="Column_Attribute"></a>

<br><ul><li style='font-size:18px;'>1.5.1 컬럼의 속성을 정의하는 방법. 
<br> 1.5.1.1 컬럼속성을 'POPUP Window'로 설정하는 방법. 
<br>예)컬럼 'id'의 속성을 'POPUP Window'로 설정하는 방법 입니다.
<br>1. 컬럼 'id'선택 
<br>2. 'POPUP Window[Setup]'을 클릭 합니다. 그러면, Popup Window 설정 화면이 출력 됩니다. </li></ul>
<img src='./pic_010.png' width='100%'>

<a name="Popup_Window"></a>
1.5.1.2 컬럼 'id'를 'Popup Window'속성으로 설정하는 화면 입니다.
<img src='./pic_026_Popup_Window.png' width='100%'>
<br>화면에는 Popup Window와 Program Window가 있습니다. 
<br>Popup Window의 'product'테이블은 팝업창에서 Program Window의 'order_tab'테이블은 프로그램에서 사용되는 컬럼입니다. 
<br>1. Popup Window에서 Table을 선택.
 다음 화면은 'product' 테이블을 선택한 화면 입니다.
<img src='./pic_027_Popup_window.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>프로그램 실행시 Popup창에서 사용하지않는 컬럼은 삭제합니다.
<br>삭제 방법은 1.컬럼을 선택하고, 2.'Del'버턴을 클릭하면 삭제 됩니다.
<br>컬럼을 연결하는 방법입니다. 
<br>1. Popup Window 의 'product'컬럼을 선택하고, Program Window의 'id'컬럼을 선택하고 'Apply'버턴을 클릭 합니다.
<br>2. Popup Window 의 'cost'컬럼을 선택하고, Program Window의 'unit_price'컬럼을 선택하고 'Apply'버턴을 클릭 합니다.
<br>3. Popup Window 의 'price'컬럼을 선택하고, Program Window의 'price'컬럼을 선택하고 'Apply'버턴을 클릭 합니다.
<br>4. 'Save' 버턴을 클릭하여 저장합니다. 그러면, 다음과 같은 결과가 출력됩니다.</li></ul>
<img src='./pic_028_Popup_window.png' width='100%'>

<a href="#top">Top</a>

<a name="Formula"></a>

<br><br><ul><li style='font-size:18px;'>1.5.1.2 컬럼속성을 'Formula'로 설정하는 방법. 
<br>Forlula는 계산식을 설정하는 방법입니다.
<br>컬럼 'price'를 Formula속성으로 설정하는 예 입니다.
<br>1. 컬럼 'price'선택 <br>2. 'Formula [Setup]'을 클릭 합니다.
</li></ul>
<img src='./pic_029_formula.png' width='100%'>
컬럼 'price'를 선택하고, 'Formula [Setup]'버턴을 클릭하면 계산식 설정 화면이 출력됩니다.
<img src='./pic_018_formula.png' width='100%'>
<ul style='color:white'><li> 설명 : <br>
예를 들면 금액 = 단가 * 수량 이라고 하면 입력 화면에서 단가와 수량을 입력하면 금액은 계산하여 자동으로 출력합니다. 
<br>계산식 설정 작업순서 
<br>1. 'quantity' 컬럼을 클릭 
<br>2. '*(multiply)'를 클릭 
<br>3. 'unity_price' 컬럼을 클릭 하면, 'Formula' 난에 'price = quantity * unit_price' 라고 표시 됩니다.
<br>4. 'Save' 버턴을 클릭하여 저장합니다.
</li></ul>


<a name="Radio"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.3 컬럼속성을 'Radio' 속성으로 설정하는 방법. </li></ul>

<img src='./pic_030_radio.png' width='100%'>
<ul style='color:white'><li> 설명 : 데이터를 입력시에 직접 입력을 하지않고 선택하여 입력하는 방법으로
<br> 'Radio', 'Checkbox', 'Listbox' 버턴 의 3가지가 있습니다. 
<br>이중에서 여러개를 선택 할 수 있는 것은 'Checkbox'입니다. 나머지 Radio, Listbox는 하나만을 선택 할 수 있습니다.
<br>'Radio', 'Checkbox', 'Listbox' 중에서 하나를 선택하면 'Column attribute data'에 데이터를 입력하고 'Apply Attribute'버턴을 클릭하여 적용합니다.
<br>'unit' 컬럼의 입력 속성 설정 방법으로, 
<br>1. 'unit' 컬럼을 클릭하고
<br>2. '*Column attribute data'에 ea:box 라고 입력하고, 항목의 구분은 ':' 으로 분리 합니다.  
<br>3. 'Radio'버턴을 클릭하고
<br>4. 'Apply Attribute' 버턴을 클릭 합니다.

<br>다른 예) 취미의 경우 축구:농구:배구:골프:야구:바둑:등산:낚시 라고 입력 하고 'Checkbox' 클릭 'Apply Attribute' 버턴을 클릭.
<br>취미는 여러개를 선택 할수있는 'Checkbox'로 많이 사용합니다.
</li></ul>

<a name="Checkbox"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.4 'Checkbox' 속성으로 설정하는 방법. 'Checkbox'는 여러개를 선택 할수있는  속성입니다.</li></ul>
<img src='./pic_053_Checkbox.png' width='100%'>
<ul style='color:white'><li> 설명 :  
<br>1. 'standard' 컬럼을 선택합니다.
<br>2. '*Column attribute data'에 mm:cm:m 라고 입력하고 
<br>3. 'Checkbox'를 선택을 하고 
<br>4. 'Apply Attribute' 버턴을 클릭 합니다.
<br>항목의 구분자는 ':' 입니다.
</li></ul>
<a href="#top">Top</a>

<a name="Listbox"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.5 'Listbox' 속성으로 설정하는 방법. 'manufacturer' 컬럼의 예입니다.</li></ul>
<img src='./pic_054_Listbox.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>1. 'manufacturer' 컬럼을 선택합니다.
<br>2. '*Column attribute data'에 apple:samsung 이라고 입력하고 
<br>3. 'Listbox'를 선택을 하고 
<br>4. 'Apply Attribute' 버턴을 클릭 합니다.
<br>항목의 구분자는 ':' 입니다.
</li></ul>
<a href="#top">Top</a>


<a name="Attached_file"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.6 'Attached file' 속성으로 설정하는 방법. </li></ul>
<img src='./pic_032_Attached_file.png' width='100%'>
<ul style='color:white'><li> 설명 : 'Attached file' 속성은 첨부 화일을 등록 할때 사용합니다. 
<br>예를들면 상품 사진이나, 문서 화일을 첨부하고자 할때 선택합니다.
</li></ul>
<a href="#top">Top</a>

<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.5 컬럼명을 변경하는 방법. </li></ul>
<img src='./pic_032_Attached_file.png' width='100%'>
<ul style='color:white'><li> 설명 : 컬럼의 명칭을 변경 합니다. 
<br>1. 컬럼을 클릭합니다. 
<br>2. '*Change column name'에서 명칭을 변경하여 입력 합니다. 
<br>3. 'Confirm' 버턴을 클릭합니다. 
<br>4. 'Save and Run' 버턴을 클릭하여 저장합니다.
</li></ul>

<a name="Table_Relationship"></a>

<br><ul><li style='font-size:18px;color:yellow;'>1.6.1 'Table Relationship' 설정.
<br>'Table Relationship'은 테이블 관계식이라고 하며, 
<br>A테이블에 테이터를 등록 할 때 B테이블에도 동시에 데이터를 등록하도록 설정하는 작업 입니다.
</li></ul>
<img src='./pic_relation1.png' width='100%'>
<ul style='color:white'><li> 설명 :  'Table Relationship'은 테이블 관계식이라하며, A테이블에 테이터를 등록 할 때 B테이블에도 동시에 데이터를 등록을 설정 방법으로,
<br>예를 들면, 주문을 등록하면서 출고지시를 동시에 하도록하는 경우에 'Table Relationship' 설정을 합니다.
<br>'Table Relationship' 설정 방법.
<br>1. Program을 선택합니다.
<br>2. 'Relation table'을 선택합니다.
<br>3. 'Program table'의 컬럼을 선택하고, 'Relation table'의 컬럼을 선택후 컬럼 이동식을 선택하고 'Apply'버턴을 클릭합니다.
<br>4. 컬럼이동식 설정이 완료되면 'Save'버턴을 클릭하여 저장합니다.
<br>다음 화면은 작업 순서 대로 출력된 화면 입니다.
</li></ul>
<img src='./pic_relation2.png' width='100%'>
<ul style='color:white'><li> 설명 : 'Progeam'을 선택한 화면입니다.</li></ul><br>
<img src='./pic_relation3.png' width='100%'>
<ul style='color:white'><li> 설명 : 'Relation table'을 선택한 화면입니다.</li></ul><br>
<img src='./pic_relation4.png' width='100%'>
<ul style='color:white'><li> 설명 : Table 관계설정을 위해 컬럼을 선택하고 'Apply'버턴을 클릭한 화면입니다.</li></ul><br>
<img src='./pic_relation5.png' width='100%'>
<ul style='color:white'><li> 설명 : 관계설정이 완료된 'Program'을 선택한 화면입니다.
<br>'Table Relationship'을 삭제하고자 하면 'Delete'버턴을 클릭하여 삭제 할 수 있습니다.
</li></ul><br>
<a href="#top">Top</a>

<a name="샘플프로그램"></a>

<br><ul><li style='font-size:18px;color:yellow;'>1.7.1 샘플 프로그램 'order_tab' 데이터 등록 화면. </li></ul>
<img src='./pic_038_sample.png' width='100%'>
<ul style='color:white'><li> 설명 : 샘플 프로그램 order_tab 데이터 등록 화면 입니다.
<br>'submit'버턴은 데이터를 저장합니다.
<br>'reset'버턴은 입력한 데이터를 화면상에서 지워버리고 다시 입력 하도록 합니다.
<br>'Source Down'버턴은 데이터 등록 소스코드를 다운로드합니다.
<br>'List'버턴은 데이터 목록으로 이동합니다.

<br>컬럼 'image'의 '화일선택' 버턴은 컬럼속성 설정에서 'Attached file'을 선택한 경우입니다.

</li></ul>

<br><ul><li style='font-size:18px;color:yellow;'>1.7.2 샘플 프로그램 order_tab의 팝업창 실행 화면. </li></ul>
<img src='./pic_037_sample2.png' width='100%'>
<ul style='color:white'><li> 설명 : 등록 컬럼 'id'를 클릭하여 실행된 팝업창 화면입니다.
<br>'id'의 컬럼속성을 'POPUP Window [Setup]'버턴을 클릭하여 설정하여 실행된 것입니다.
</li></ul>

<br><ul><li style='font-size:18px;color:yellow;'>1.7.3 샘플 프로그램 order_tab의 데이터 리스트 화면. </li></ul>
<img src='./pic_038_sample_list.png' width='100%'>
<ul style='color:white'><li> 설명 : 샘플 프로그램 order_tab의 데이터 리스트 화면.
<br>'Write'버턴은 데이터등록 화면으로 이동합니다.
<br>'Excel Down'버턴은 데이터를 엑셀화일로 다운로드합니다.
<br>'Source Down'버턴은 데이터리스트 프로그램 소스코드를 다운로드합니다.
</li></ul>

<br><ul><li style='font-size:18px;color:yellow;'>1.7.4 샘플 프로그램 order_tab의 데이터 상세 화면. </li></ul>
<img src='./pic_052_sample3.png' width='100%'>
<ul style='color:white'><li> 설명 : 샘플 프로그램 order_tab의 데이터 리스트에서 항목을 클릭했을때 화면.
<br>'Modify'버턴은 데이터를 변경하는 화면으로 이동 합니다.
<br>'Delete'버턴은 데이터를 삭제합니다.
<br>'List'버턴은 데이터 목록으로 이동합니다.
<br>'Source Down'버턴은 데이터 변경,삭제관련 소스코드를 다운로드합니다.
</li></ul>

<br><ul><li style='font-size:18px;color:yellow;'>1.7.5 샘플 프로그램 order_tab의 데이터 등록 화면. </li></ul>
<img src='./write.png' width='100%' style='height:450px;width:600px;'>
<ul style='color:white'><li> 설명 : 샘플 프로그램 order_tab의 데이터 리스트 화면.
<br>'submit'버턴은 데이터를 등록 합니다.
<br>'reset'버턴은 데이터를 다시 입력 합니다.
<br>'Source Down'버턴은 데이터리스트 프로그램 소스코드를 다운로드합니다.
<br>'Excel Upload'버턴은 엑셀 화일의 데이터를 Table에 저장 합니다.
<br>[Sample Excel file]
<br><img src='./excel_data_sample.png' style='width:600px;height:360px'>
</li></ul>

<a name="FTP프로그램"></a>
<br><br>
<br><ul><li style='font-size:18px;color:yellow;'>1.7.6 사용자 서버에서 소스를 사용하는 방법. FTP 'Filezilla;실행 화면 입니다. </li></ul>
<img src='./pic_055_FTP.png' width='100%'>
<ul style='color:white'><li> 설명 : 
<br>사용자 서버에서 소스를 사용하는 방법으로 'Source Down'버턴을 클릭하여 다운받습니다.
<br>압축을 풀고 서버에 'FTP' 프로그램으로 화일을 업로드합니다. FTP프로그램은 주로 오픈소스인 FileZilla를 많이 사용합니다.
<br>FileZilla 사이트는: <a href="https://filezilla-project.org/">FTP FileZilla 다운로드 사이트 입니다.</a>
</li></ul>

<a href="#top">Top</a>

<a name="tree_menu"></a>

<br><ul>
<li style='font-size:18px;color:yellow;'>8 Tree Menu  제작 방법
[Tree Menu List]<br><img src='./menu0.png' style='width:36%;height:80%;'></li></ul>
<ul style='color:white'>
<li> 설명 : 사용자의 Tree menu List 입니다.
<br>메뉴를 생성하고 소스 코드를 다운 받을 수 있습니다. 
<br>1. 'New Create' 버턴은 메뉴를 생성합니다.
<br>2. 'Tree DN' 버턴은 'Tree menu' 소스 코드를 생성하고 다운 받습니다.
<br>3. 'Popup DN' 버턴은 'Popup menu' 소스 코드를 생성하고 다운 받습니다.
<br>4. 'Title'의 항목을 클릭하면 'Tree menu'를 실행 합니다.
<br>5. 'Popup'을 클릭 하면 'Popup menu'를 실행 합니다.
</li></ul>


<br><ul>
<li style='font-size:18px;color:yellow;'>8.1 Tree Menu Source Code DownLoad
<br><img src='./menu_source.png' style='width:60%;height:60%;'></li></ul>
<ul style='color:white'>
<li> 설명 : 'Tree Menu List'에서 'Tree DN' 버턴을 클릭한 화면 입니다.
<br>1. 'Download Action' 을 클릭하면 소스를 다운 받습니다.
<br>2. 'Tree Menu List'에서 'Popup DN' 버턴을 클릭하면 'Popup menu' 소스코드를 다운 받습니다.
</li></ul>


<ul><li style='font-size:18px;color:yellow;'>8.2 Tree Menu Create : [메뉴 생성 화면] - 'Tree Menu List'에서 'New Create'버턴을 클릭.
<br><img src='./menu_create.png' style='width:36%;height:80%;'></li></ul>
<ul style='color:white'>
<li> 설명 : 사용자의 Tree menu를 생성 합니다.
<br>1. 'Creates' 버턴 메뉴를 생성 합니다. 
<br>2. 'Tree-Menu List' 버턴 메뉴 리스트 화면 이동.
<br>3. 'Background Color' 메뉴의 배경색 입니다.
<br>4. 'Font Color' 메뉴의 문자 색상 입니다.
<br>5. 'Font' 문자 폰트 입니다.
</li></ul>



<ul><li style='font-size:18px;color:yellow;'>8.3 Tree Menu Job : [메뉴 실행 화면] - 메뉴를 추가, 변경, 삭제를 합니다.
<br><img src='./menu_job.png' style='width:50%;height:80%;'></li></ul>
<ul style='color:white'>
<li> 설명 : 'Select Job'을 클릭하여 작업을 선택 합니다.
<br>1. 'Insert job'은 메뉴를 추가 합니다.
<br>1. 'Update job'은 메뉴의 타이틀 및 링크 'url'을 변경 할 수 있습니다..
<br>1. 'Execute' 클릭은 메뉴 실행.
<br>1. 'Tree design'은  디자인을 재 설정하는 기능 입니다.
</li></ul>


<ul><li style='font-size:18px;color:yellow;'>8.4 Menu Insert
[메뉴 추가] - 'Select job'에서 'Insert job'버턴을 클릭.</li></ul>
<li><img src='./menu_insert2.png' style='width:80%;height:90%;'></li>
<ul style='color:white'>
<li> 설명 : 'Insert job'을 클릭.
<br>1. 'Link'는 URL을 연결 합니다.
<br>2. 'Note'는 Note를 생성합니다.
<br>3. 'Board'는 게시판을 생성합니다.
</li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.5 Menu Insert
[메뉴 추가] - 메뉴를 추가후 다시 'Insert job'버턴을 클릭하고 'sports'를 클릭한 화면 입니다..</li></ul>
<li><img src='./menu_insert4.png' style='width:80%;height:90%;'></li>
<ul style='color:white'>
<li> 설명 : 'sports'의 하단에 메뉴를 추가 합니다.
<br>1. 'Save' 메뉴를 저장합니다.
<br>2. 'Switch to main level'버턴은 현재'sports'의 하단에서 다시 '메인 레벨의 메뉴' 등록으로 변경 합니다.

</li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.6 Menu Update
<br>[메뉴 변경 및 삭제] - 메뉴를 변경 또는 삭제 합니다. 'Update job'버턴을 클릭.</li></ul>
<li><img src='./menu_update.png' style='width:80%;height:70%;'></li>
<ul style='color:white'>
<li> 설명 : Tree menu를 변경 또는 삭제.
<br>'Save'버턴을 클릭 Title 변경 내용을 저장 합니다.
<br>'Search'버턴은 Link url을 검색하여 선택합니다.
<br>'Delete'버턴을 클릭하면 메뉴에서 삭제 합니다.
<li>[Search 클릭 화면]<br><img src='./menu_search.png' style='width:45%;height:70%;'></li>
</li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.7 Tree Menu Design.
<br>[메뉴 디자인 변경] - 'Tree Design'버턴을 클릭.</li></ul>
<li><img src='./menu_design_set.png' style='width:70%;height:70%;'></li>
<ul style='color:white'>
<li> 설명 : Tree menu의 디자인을 변경.
<br>메뉴 배경색, 문자 색상, 문자 크기 등을 변경합니다.
</li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.8 Note 사용 방법.
<br>[메뉴에서] -> 'My-Job' 을 클릭.</li></ul>
<li><img src='./menu_note.png' style='width:54%;height:70%;'></li>
<ul style='color:white'>
<li> 설명 : Tree menu를 생성 하면 메인 타이틀은 'Note' 입니다.
<br>찻번쨰 메인 타이틀을 클릭하면 타이틀과 내용을 변경할 수있습니다.
<br>내용은 암호화 하여 저장 할 수 있습니다. 암호를 분실하면 복호화를 할수가 없습니다. 중요합니다.
<li>[내용이 암호화된 화면]<br><img src='./menu_note_encryption.png' style='width:45%;height:70%;'></li>
비밀번호를 입력하고 'Decryption'버턴을 클릭하면 복호화 됩니다.
</li></ul>


<ul><li style='font-size:18px;color:yellow;'>9. 메뉴를 추가 하여도 메뉴가 변경 되지않는 경우가 간혹 발생 합니다. 
<br>이것은 브라우즈의 문제로 새로운 내용을 갱신 하지 못한 경우입니다. 이럴떄 해결 방법 입니다. 
<br>1. 크롬 브라우즈의 설정을 클릭하고 
<br>2. 캐시된 이미지 화일 삭제 버턴을 클릭합니다.
<li><img src='./menu_crome_cookie_delete.png' style='width:90%;height:70%;'></li>
<ul style='color:white'>
<li> 설명 : 브라우즈의 오른쪽 상단의 설정 클릭 .
<br>캐시된 이미지 화일 삭제 버턴을 클릭합니다.
<br>메뉴 화면을 새로 고침 하면 메뉴가 정상 출력 됩니다.
</li></ul>
<a href="#top">Top</a>
