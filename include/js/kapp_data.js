//var kapp_dataManager = new function(){
var Kapp_ProgramJS = new function(){

	var idle 		= true;
	var interval	= 500;
	var xmlHttp		= new XMLHttpRequest();
	var finalDate	= '';

	// 채팅내용 가져오기
	this.proc = function(){		// 중복실행 방지 플래그가 ON이면 실행하지 않음
		if(!idle){
			return false;
		}		// 중복실행 방지 플래그 ON
		idle = false;		// Ajax 통신
		xmlHttp.open("GET", "proc.php?date=" + encodeURIComponent(finalDate), true);
		xmlHttp.send();
	}

	// 채팅내용 보여주기
	this.show = function(data){
		var o = document.getElementById('list');
		var dt, dd;		// 채팅내용 추가
		for(var i=0; i<data.length; i++){
			dt = document.createElement('dt');
			dt.appendChild(document.createTextNode(data[i].name));
			o.appendChild(dt);
			dd = document.createElement('dd');
			dd.appendChild(document.createTextNode(data[i].msg));
			o.appendChild(dd);
		}		// 가장 아래로 스크롤
		o.scrollTop = o.scrollHeight;
	}
	// 채팅내용 작성하기
	this.write = function(frm){		//alert('----------- write');
		var xmlHttpWrite	= new XMLHttpRequest();
		var name			= frm.name.value;
		var msg				= frm.msg.value;
		var param			= [];		// 이름이나 내용이 입력되지 않았다면 실행하지 않음	//alert('name:'+name + ', msg:' +msg);
		if(name.length == 0 || msg.length == 0)	{
			return false;
		}		// POST Parameter 구축
		param.push("name=" + encodeURIComponent(name));
		param.push("msg=" + encodeURIComponent(msg));		// Ajax 통신
		xmlHttpWrite.open("POST", "write.php", true);
		xmlHttpWrite.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttpWrite.send(param.join('&'));		// 내용 입력란 비우기
		frm.msg.value = '';	// 채팅내용 갱신
		Kapp_ProgramJS.proc();
	}

	this.kapp_program_data_save = function( thisform ) {
		thisform = document.Kapp_HtmlForm;
		jQuery(document).ready(function ($) {
			//const formElement = document.querySelector('form');
			const formData = new FormData(thisform);
			/*   //폼데이터 값 출력 OK
			let entries = formData.entries();
			for (const pair of entries) {
				console.log(pair[0]+ ', ' + pair[1]); 
			}*/
            $.ajax({
                url: 'kapp_program_data_write_r.php',
                type: 'POST',
                data: formData,
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata){
                    alert(" OK! -" + returndata);
					//pg_code = thisform.pg_code.value;
					//this.data_list_proc(pg_code); // ok
                },
                error: function(){
					alert("error in ajax form submission");
                }
			});
		});
		pg_code = thisform.pg_code.value;
		this.data_list_proc(pg_code); // ok
	}
	this.kapp_program_data_modify = function ( thisform, seqno ){
		if( confirm("Do you want to change it? ") ) {
			thisform = document.Kapp_HtmlForm;
			thisform.seqno.value=seqno;
			thisform.mode.value = "CHG_MODE";
			thisform.action = 'kapp_program_data_update.php';
			thisform.submit();
		}
	}
	this.data_list_proc = function(pg_code){
		thisform = document.Kapp_HtmlForm;
		thisform.mode='home_func';
		thisform.action='kapp_program_data_list.php?pg_code='+pg_code;
		thisform.target='_self';
		thisform.submit();
	}
	this.table_record_write_list = function( thisform, h_lev, grant_write ){
		thisform = document.Kapp_HtmlForm;
		if( grant_write > h_lev ){
			alert("No permission. ");
			return;
		} else {
			thisform.action='kapp_program_data_write.php'; 
			thisform.target='_self';
			thisform.submit();
		}
	}
	/*
	this.call_pg_select = function ( pp, pw, pd) {
		p1 = pp.split("|");
		p2 = pw.split("|");
		p3 = pd.split(":");
		for( i=0; p1[i] !== "";  i++){
			pk		= p1[i].split(":");
			$p0	= pk[0];
			$p1	= pk[1];
			pg		= p2[i].split(":");
			$pg0	= pg[0];
			$pg1	= pg[1];
			$dd0	= p3[i];
			eval( "parent.window.opener.document.Kapp_HtmlForm."+$pg0+".value = $dd0" );
		}
		window.close(); // 팝업창이 닫히지않는것은 컬럼속성이 checkbox로 설정되어 있었기때문이다. 컬럼 이동식이에는 속성을 정의 하지 마라.
		return;
	}*/

	this.popup_call = function ( thisform, i ) {
		thisform = document.Kapp_HtmlForm;
		thisform.column_cnt.value = i;
		window.open("popup_call.php?fld_session="+i,"","alwaysLowered=no,resizable=no,width=700,height=700,left=50,top=50,dependent=yes,z-lock=yes");
		return true;  
	}

	this.page_move = function ( thisform, page, linkurl ){
		//thisform = document.Kapp_HtmlForm; // use ok
		thisform.page.value = page;
		thisform.action= linkurl; //'kapp_program_data_list.php';
		thisform.submit();
	}
	this.Change_grant_view_list = function ( thisform, cd, grant_view, pg_code){
		resp = confirm("Are you sure change? Y/N ");
		if( resp === true ) {
			jQuery(document).ready(function ($) {
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: 'kapp_column_change_ajax.php',
						data: {
							"mode": 'grant_view_change',
							"pg_code": pg_code,
							"grant_view": grant_view
								
						},
					success: function(data) {
						alert("OK change --- " + grant_view);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" error.-- kapp_column_change_ajax.php");
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						return;
					}
				});
			});
		} else {
			switch(cd){
				case '0': 
				case '1': old_cd = 0; msg='Guest'; break;
				case '2': old_cd = 1; msg='Member'; break;
				case '3': old_cd = 2; msg='For creators only'; break;
				case '8': old_cd = 3; msg='Only system manager'; break;
				default : old_cd = 0; msg='Guest'; break;
			}
			view_form.grant_view.selectedIndex = old_cd;
		}
	}	
	this.Change_grant_write_list = function ( thisform, cd, grant_write, pg_code){
		resp = confirm("Are you sure change? Y/N ");
		if( resp === true) {
			jQuery(document).ready(function ($) {
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: 'kapp_column_change_ajax.php',
						data: {
							"mode": 'grant_write_change',
							"pg_code": pg_code,
							"grant_write": grant_write
								
						},
					success: function(data) {
						alert("OK change --- " + grant_write);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert(" 올바르지 않습니다.-- kapp_column_ajax.php");
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						return;
					}
				});
			});
		} else {
			switch(cd){
				case '0': 
				case '1': old_cd = 0; msg='Guest'; break;
				case '2': old_cd = 1; msg='Member'; break;
				case '3': old_cd = 2; msg='For creators only'; break;
				case '8': old_cd = 3; msg='Only system manager'; break;
				default : old_cd = 0; msg='Guest'; break;
			}
			view_form.grant_write.selectedIndex = old_cd;
		}
	}	
	this.kapp_program_data_view = function ( thisform, seqno, data_mid ){
		thisform = document.Kapp_HtmlForm;
		thisform.seqno.value=seqno;
		thisform.data_mid.value=data_mid;
		thisform.action='kapp_program_data_view.php';  //'tkher_program_data_view.php'; 
		thisform.target="_self";
		thisform.submit();
	}

	this.excel_down = function ( thisform, hid ){
		if( confirm( "Would you like to download the data as an Excel file?" ) ) {
			if( !hid  ) {
				alert('Login Please! hid:' + hid); return false;
			}
			thisform.mode.value = 'excel_create';
			thisform.action='down_excel_file.php';
			thisform.submit();
		}
	}
	this.excel_upload_write_func = function ( thisform, tab_enm, tab_hnm){
		if( confirm( "Would you like to upload the CSV file to the DB?" ) ) {
			thisform = document.Kapp_HtmlForm;
			pg_code = thisform.pg_code.value;
			thisform.pg_call.value="kapp_program_data_list.php?pg_code="+pg_code;
			thisform.mode.value="Upload_mode_table10i";
			thisform.tab_enm.value=tab_enm;
			thisform.tab_hnm.value=tab_hnm;
			thisform.action="excel_load.php";
			thisform.submit();
		}
	}
	this.excel_upload_list_func = function ( thisform, tab_enm, tab_hnm){
		if( confirm( "Would you like to upload the CSV file to the DB?" ) ) {
			pg_code = thisform.pg_code.value;
			thisform.pg_call.value="kapp_program_data_list.php?pg_code="+pg_code;
			thisform.mode.value="Upload_mode_table10i";
			thisform.tab_enm.value=tab_enm;
			thisform.tab_hnm.value=tab_hnm;
			thisform.action="excel_load.php";
			thisform.submit();
		}
	}
	this.kapp_program_data_list_home_func = function ( thisform ){
		thisform = document.Kapp_HtmlForm;
		thisform.line_cnt.value='';
		thisform.mode.value='';
		thisform.fld_code_pg.value='';
		thisform.fld_code_asc_pg.value='';
		thisform.search_fld.value='';
		thisform.search_choice.value='';
		thisform.searchT.value='';
		pg_code = thisform.pg_code.value;
		thisform.action='kapp_program_data_list.php?pg_code='+pg_code;
		thisform.target="_self";
		thisform.submit();
	}
    this.kapp_program_listAll = function ( thisform, pg_code, tab_enm ){
		thisform = document.Kapp_HtmlForm;
		thisform.mode.value='';
		thisform.fld_code_pg.value='';
		thisform.fld_code_asc_pg.value='';
		thisform.search_fld.value='';
		thisform.search_choice.value='';
		thisform.searchT.value='';
		thisform.target="_blank";
		thisform.action='kapp_program_data_list.php?pg_code='+pg_code+"&tab_enm="+tab_enm; 
		thisform.submit();
	}
	this.kapp_program_data_list = function( thisform ) {
		thisform = document.Kapp_HtmlForm;
		var pg_code= thisform.pg_code.value;
		thisform.action="kapp_program_data_list.php?pg_code=" + pg_code;
		thisform.target="_self";
		thisform.submit();
	}
	/*
	this.kapp_program_data_listV = function ( thisform ) {
		thisform = document.Kapp_HtmlForm;
		thisform.action="kapp_program_data_list.php";
		thisform.target='_self';
		thisform.submit();
	}
	this.table_data_view_list = function ( thisform ) {
//		thisform = document.Kapp_HtmlForm;
		var pg_code= thisform.pg_code.value;
		thisform.action="kapp_program_data_list.php?pg_code=" + pg_code;
		thisform.target="_self";
		thisform.submit();
	}*/
	this.kapp_program_data_ChangeView = function ( thisform, hid, RelTs_hnm){
//		thisform = document.Kapp_HtmlForm;
		if( hid=='Guest'){
			alert("Guests cannot make changes");
			return;
		}
		if( thisform.Hid.value =='Guest') {
			alert("Guests cannot make changes");
			return false;
		}
		if( RelTs_hnm !='' ){
			alert("A table relation has been established. \n It cannot be changed. \n table name is: "+RelTs_hnm);
			return false;
		}
		thisform.mode.value='modify';
		thisform.action='kapp_program_data_update.php';
		thisform.target = '_self';
		thisform.submit();
	}
	this.write_home_func = function ( thisform, pg_code){
//		thisform = document.Kapp_HtmlForm;
		thisform.mode='home_func';
		thisform.action='kapp_program_data_list.php?pg_code='+pg_code;
		thisform.target="_self";
		thisform.submit();
	}

	this.tkher_source_createDNW = function ( thisform, $coin){
//		thisform = document.Kapp_HtmlForm;
		if( !thisform.H_ID.value ) {
			alert('Login Please!'); return false;
		}
		if( $coin < 1000 ) {
			alert('AppGenerator Point is low. You must do activities to accumulate points. point:'+ $coin);
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				thisform.mode.value = 'write_r';
				thisform.action='tkher_php_programDNW.php';
				thisform.target = '_blank';
				thisform.submit();
			}
		}
	}
	this.tkher_source_createDN = function ( thisform, $coin ){ 
//		thisform = document.Kapp_HtmlForm;
		if( !thisform.id.value ) {
			alert('Login Please!'); return false;
		}
		if( $coin < 1000 ) {
			alert('Requires more than 1000 points. Point is low. You must do activities to accumulate points. point:'+ $coin);
			thisform.action='<?=KAPP_URL_T_?>/manual/user_manual.php';
			thisform.target = '_blank';
			thisform.submit();
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				thisform.mode.value = "data_list";
				thisform.action='tkher_php_programDN.php';
				thisform.target = '_blank';
				thisform.submit();
			}
		}
	}
	this.tkher_source_createDNV = function ( thisform, $coin, seq){
//		thisform = document.Kapp_HtmlForm;
		if( thisform.Hid.value == 'Guest' ) {
			alert('Login Please!'); return false;
		}
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				thisform.mode.value = 'view';
				thisform.action='tkher_php_programDNV.php';
				thisform.target = '_blank';
				thisform.submit();
			}
		}
	}

	this.input_check = function (thisform, item_cnt,iftype) { 
//		thisform = document.Kapp_HtmlForm;
		return true; // now no use - 입력 필수 체크 필요. Input required check.
	}
	//------------------ data list ----------------------------------------
	this.title_wfunc = function ( thisform, fld_code_pg){       
//		thisform = document.Kapp_HtmlForm;
		thisform.page.value = 1;
		thisform.fld_code_pg.value= fld_code_pg;
		thisform.fld_code_asc_pg.value= 'desc';
		thisform.mode.value='title_wfunc';
		thisform.target='_self';
		thisform.action='kapp_program_data_list.php';
		thisform.submit();                         
	} 
	this.title_func = function ( thisform, fld_code_pg){       
//		thisform = document.Kapp_HtmlForm;
		thisform.page.value = 1;                
		thisform.fld_code_pg.value= fld_code_pg;           
		thisform.fld_code_asc_pg.value= 'asc';
		thisform.mode.value='title_func';           
		thisform.target='_self';
		thisform.action='kapp_program_data_list.php';
		thisform.submit();                         
	} 
	/*function Change_Csel3( thisform, c_sel){
		thisform.search_choice.value=c_sel;
		thisform.c_sel3.value=c_sel;
	}
	function Change_Csel2( thisform, c_sel){
		var obj = document.getElementById("c_sel3");
		var c = c_sel.split("|");
		thisform.search_fld.value = c[0];
		thisform.mode.value = 'search';
	}*/
	

	/*function group_code_change_func_list( cd, pg_code){
		index = thisform.group_code.selectedIndex;
		thisform.mode.value = "project_search";
		thisform.action ="kapp_program_data_list.php";
		thisform.submit();
		return;
	}*/
	//---------------- view ---------
	this.popimageV = function ( thisform, imagesrc,winwidth,winheight){
		var look='width='+winwidth+',height='+winheight+','
		popwin=window.open("","",look)
		popwin.document.open()
		popwin.document.write('<title>K-APP</title><body bgcolor="white" topmargin=0 leftmargin=0 marginheight=0 marginwidth=0><a href="javascript:window.close()"><img src="'+imagesrc+'" border=0></a></body>')
		popwin.document.close()
	}
	this.data_deleteView = function ( thisform, hid, seqno, RelTs_hnm){
		thisform = document.Kapp_HtmlForm;
		if( hid=='Guest'){
			alert("Guests cannot make changes");
			return;
		}
		if( thisform.Hid.value =='Guest') {
			alert('Guests cannot delete!'); return false;
		}
		if( RelTs_hnm !='')	$msg=" A table relation has been established. \n It cannot be changed. \n table name is: "+RelTs_hnm + "\n Are you sure you want to delete? ";
		else $msg="Are you sure you want to delete? ";
		if( confirm( $msg ) ) {
			thisform.mode.value="data_delete";
			thisform.seqno.value=seqno;
			thisform.action='kapp_program_data_view.php';
			thisform.submit();
		}
	}
	// interval에서 지정한 시간 후에 실행
	//setInterval(this.proc, interval);
}