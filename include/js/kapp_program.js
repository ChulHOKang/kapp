	function program_del_funcList2( seqno, pg_name, pg_code, hid, mid ) {
		msg = "Are you sure you want to delete the program " + pg_name +"?";
		if ( window.confirm( msg ) ){
			document.kapp_program_list_Form.mode.value="Delete_mode";
			document.kapp_program_list_Form.seqno.value		=seqno;
			document.kapp_program_list_Form.pg_code.value	=pg_code;
			document.kapp_program_list_Form.pg_name.value	=pg_name;
			document.kapp_program_list_Form.action="kapp_program_list.php";
			document.kapp_program_list_Form.target='_self';
			document.kapp_program_list_Form.submit();
		} else {
			return false;
		}
	}
	function program_run_funcList2( seqno, pg_name, pg_code ) {
		document.kapp_program_list_Form.mode.value="kapp_program_list";
		document.kapp_program_list_Form.seqno.value=seqno;
		document.kapp_program_list_Form.pg_name.value=pg_name;
		document.kapp_program_list_Form.pg_code.value=pg_code;
		document.kapp_program_list_Form.action="./kapp_program_data_list.php";
		document.kapp_program_list_Form.target="_blank";
		document.kapp_program_list_Form.submit();
	}
	function program_upgrade( seqno, pg_code, userid ) {
		document.kapp_program_list_Form.mode.value		="program_upgrade";
		document.kapp_program_list_Form.seqno.value		=seqno;
		document.kapp_program_list_Form.userid.value	=userid;
		document.kapp_program_list_Form.pg_code.value	=pg_code;
		document.kapp_program_list_Form.action= "./kapp_pg_Upgrade.php";
		document.kapp_program_list_Form.target ="_blank";
		document.kapp_program_list_Form.submit();
	}

	function page_func( page, data ){
		document.kapp_program_list_Form.mode.value		='';
		document.kapp_program_list_Form.data.value		=data;
		document.kapp_program_list_Form.page.value		=page;
		document.kapp_program_list_Form.action		="kapp_program_list.php";
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.submit();
	}
	function kproject_func( pj, pg ) {
		document.kapp_program_list_Form.page.value = 1;                
		document.kapp_program_list_Form.data.value = '';
		document.kapp_program_list_Form.mode.value='Project_search';
		Prj = pj.split(':');
		document.kapp_program_list_Form.project_code.value= Prj[0];
		document.kapp_program_list_Form.project_name.value= Prj[1];
		document.kapp_program_list_Form.action=pg; //"kapp_program_list.php";
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.submit();
	}
	function PGsearch_func(pg){
		document.kapp_program_list_Form.page.value = 1;
		document.kapp_program_list_Form.mode.value = 'Program_Search';
		document.kapp_program_list_Form.action=pg; //'kapp_program_list.php';
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.submit();
	}
	function title_wfunc(fld_code, pg){       
		document.kapp_program_list_Form.page.value = 1;
		document.kapp_program_list_Form.fld_code.value= fld_code;
		document.kapp_program_list_Form.fld_code_asc.value= 'desc';
		document.kapp_program_list_Form.mode.value='title_wfunc';
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.action=pg; //'kapp_program_list.php';
		document.kapp_program_list_Form.submit();                         
	} 
	function title_func(fld_code, pg){       
		document.kapp_program_list_Form.page.value = 1;                
		document.kapp_program_list_Form.fld_code.value= fld_code;           
		document.kapp_program_list_Form.fld_code_asc.value= 'asc';
		document.kapp_program_list_Form.mode.value='title_func';           
		document.kapp_program_list_Form.target='_self';
		document.kapp_program_list_Form.action=pg; //'kapp_program_list.php';
		document.kapp_program_list_Form.submit();                         
	} 
	function kapp_line_cnt_submit(pg){
		document.kapp_program_list_Form.page.value= 1;
		document.kapp_program_list_Form.mode.value='';
		document.kapp_program_list_Form.action=pg; //'kapp_program_list.php';
		document.kapp_program_list_Form.target="_self";
		document.kapp_program_list_Form.submit();
	}
	function page_move(thisform, $page, linkurl){
		thisform.page.value = $page;
		thisform.action= linkurl; //'kapp_program_data_list.php';
		thisform.submit();
	}
