	function column_modify_mode_func( no,  table_yn, colunm_cnt ) {
		fld_hnm = document.getElementById('fld_hnm['+no+']').value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');
			return false;
		}
		for( var k=1; k < colunm_cnt; k++ ){
				knm = document.getElementById("fld_hnm[" + k + "]").value;
				if( fld_hnm == knm) {
					if( k != no ) {
						alert(' Column name '+ fld_hnm +' can not be used as a duplicate.');
						return false;
					}
				}
		}
		msg = " Modify " + fld_hnm + " entry? "; 
		if( window.confirm( msg ) ){
			document.kapp_table_Form.del_mode.value		="column_modify_mode";
			document.kapp_table_Form.mode.value			="SearchTAB";
			document.kapp_table_Form.table_yn.value = table_yn;
			document.kapp_table_Form.add_column_hnm.value = document.getElementById('fld_hnm['+no+']').value;
			document.kapp_table_Form.add_column_enm.value = document.getElementById('fld_enm['+no+']').value;
			document.kapp_table_Form.add_column_type.value = document.getElementById('fld_type['+no+']').value;
			document.kapp_table_Form.add_column_len.value = document.getElementById('fld_len['+no+']').value;
			document.kapp_table_Form.add_column_memo.value = document.getElementById('memo['+no+']').value;
			document.kapp_table_Form.del_seqno.value = document.getElementById('seqno['+no+']').value;
			document.kapp_table_Form.action="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
		}
	}
	function column_add_mode_func( no,  table_yn, column_cnt) {
		if( document.getElementById('fld_enm['+no+']').value == '' ) {
			alert(" Define columns! "); 
			document.kapp_table_Form["fld_enm[" + no + "]"].focus();
			return false;
		} else if ( document.getElementById('fld_hnm['+no+']').value == ''){
			alert(" Define column name!");
			document.kapp_table_Form["fld_hnm[" + no + "]"].focus();
			return false;
		} else if ( document.getElementById('fld_len['+no+']').value == ''){
			alert(" Define the column length!");
			document.kapp_table_Form["fld_len[" + no + "]"].focus();
			return false;
		}
		fld_hnm = document.getElementById('fld_hnm['+no+']').value;
		if( fld_hnm == 'seqno'){
			alert(' Can not use column name seqno.');
			return false;
		}
		msg = " Add " + fld_hnm + " entry? ";
		if ( window.confirm( msg ) ){
			document.kapp_table_Form.del_mode.value		="column_add_mode";
			document.kapp_table_Form.mode.value			="SearchTAB";
			document.kapp_table_Form.table_yn.value = table_yn;
			document.kapp_table_Form.add_column_hnm.value = document.getElementById('fld_hnm['+no+']').value;
			document.kapp_table_Form.add_column_enm.value = document.getElementById('fld_enm['+no+']').value;
			document.kapp_table_Form.add_column_type.value = document.getElementById('fld_type['+no+']').value;
			document.kapp_table_Form.add_column_len.value = document.getElementById('fld_len['+no+']').value;
			document.kapp_table_Form.add_column_memo.value = document.getElementById('memo['+no+']').value;
			document.kapp_table_Form.action					="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
		}
	}
	function delete_column_func(seqnoA, fld_hnmA, fld_enmA, i) {
		msg = " Delete " + fld_hnmA + " entry? ";
		if ( window.confirm( msg ) ){
			document.kapp_table_Form.del_mode.value		="Delete_column_mode";
			document.kapp_table_Form.mode.value			="SearchTAB";
			document.kapp_table_Form.pg_mode.value		="on";
			document.kapp_table_Form.del_seqno.value		=seqnoA;
			document.kapp_table_Form.del_fld_enm.value	=fld_enmA;
			document.kapp_table_Form.del_fld_hnm.value	=fld_hnmA;
			document.kapp_table_Form.action				="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
		}
	}
	function Save_Update(cnt){ 
		tab = document.kapp_table_Form.tab_hnmS.value;
		tabA = tab.split(":");
		document.kapp_table_Form.old_tab_enm.value = tabA[0];
		msg = " The data in the table is deleted. Want to regenerate? table is " + tab + " ";
		if( window.confirm( msg ) ){
			document.kapp_table_Form.mode.value='table_update_remake';
			document.kapp_table_Form.del_mode.value		="";
			document.kapp_table_Form.action="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
			ret = window.open('./progressbar.php?kapp_delay_time=3','','width=600,height=300, toolbar=no,scrollbars=yes,resizable=no');
			return true;
		} else {
			return false;
		}
	}
	function type_set_func(i, v) {
		if( i==0 ) {
			alert('Can not be changed because it is a key.' );
			document.getElementById("fld_type[0]").value = 'INT';
			return false;
		}
		if( document.kapp_table_Form["fld_type["+i+"]"].value == "INT") document.getElementById('fld_len['+i+']').value = '12';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TINYINT")   document.getElementById('fld_len['+i+']').value = '3';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "SMALLINT")  document.getElementById('fld_len['+i+']').value = '5';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "MEDIUMINT") document.getElementById('fld_len['+i+']').value = '8';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "BIGINT")    document.getElementById('fld_len['+i+']').value = '15';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DECIMAL")   document.getElementById('fld_len['+i+']').value = '6';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "FLOAT")     document.getElementById('fld_len['+i+']').value = '8.3';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DOUBLE")    document.getElementById('fld_len['+i+']').value = '12.3';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "CHAR")      document.getElementById('fld_len['+i+']').value = '5';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "VARCHAR")   document.getElementById('fld_len['+i+']').value = '15';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TEXT")      document.getElementById('fld_len['+i+']').value = '255';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "LONGBLOB")  document.getElementById('fld_len['+i+']').value = '255';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "BLOB")      document.getElementById('fld_len['+i+']').value = '255';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DATE")      document.getElementById('fld_len['+i+']').value = '10';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DATETIME")  document.getElementById('fld_len['+i+']').value= '19';
		
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TIMESTAMP")  document.getElementById('fld_len['+i+']').value = '19';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TIME")      document.getElementById('fld_len['+i+']').value = '8';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "YEAR")      document.getElementById('fld_len['+i+']').value = '4';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "MONTH")     document.getElementById('fld_len['+i+']').value = '7';
	}
	function line_set_func(cnt) { // 2026-03-19 hh:ii:ss
			document.kapp_table_Form.mode.value='line_set';
			document.kapp_table_Form.line_set.value=cnt;
			document.kapp_table_Form.action="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
	}
	function sendCon(form){
		f_nm = document.getElementById("fld_enm[0]").value;
		if( f_nm == "" ) {
			window.alert("An unentered field remains.");
		} else {
			document.kapp_table_Form.action="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
		}
	}
	function New_table_create_func(line){
		if( !document.kapp_table_Form.userid.value) {
			alert(' Please login! ');
			return false;
		} else if( !document.kapp_table_Form.project_name.value) {
			alert(' Please select project name! ');
			return false;
		} else if( !document.kapp_table_Form.new_tab_hnm.value) {
			alert(' Please enter a table name! ');
			return false;
		}
		for(var i=0;i<line; i++){
			len = document.getElementById('fld_len['+i+']').value;
			fnm = document.getElementById('fld_hnm['+i+']').value;
			if( !len) {
				if( fnm ) {
					alert('Check the column length input! ');
					return false;
				}
			}
		}
		var ins = window.confirm("Register and create the table. ");
		if( ins) {
			document.kapp_table_Form.mode.value='table_create';
			document.kapp_table_Form.action="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
			ret = window.open('./progressbar.php?kapp_delay_time=3','','width=600,height=300, toolbar=no,scrollbars=yes,resizable=no');
		}
	}
	function sql_func(){
		window.open( 'table_sql.php' , '_self', '');
		return;
	}
	function resetgo(){
		window.open( 'kapp_table30m_A.php?mode=Reset' , '_self', '');
		return;
	}
	function Copy_New_table_save(cnt){
		new_table_name = document.kapp_table_Form.new_tab_hnm.value;
		tab = document.kapp_table_Form.tab_hnmS.value;
		da = tab.split(":");
		hnm=da[1];
		enm=da[0];
		document.kapp_table_Form.project_code.value=da[2];
		document.kapp_table_Form.project_name.value=da[3];
		if( new_table_name == hnm ) {
			alert('Change the table name! ');
			document.kapp_table_Form.tab_hnm.focus();
			return false;
		} else {
			var item_cnt = document.kapp_table_Form.tab_hnmS.options.length;
			for(i=0;i < item_cnt; i++){
				tabA = document.kapp_table_Form.tab_hnmS[i].value;
				tt = tabA.split(":");
				t = tt[1];
				if( new_table_name == t ) {
					alert('Table name is duplicate.' );
					document.kapp_table_Form.tab_hnm.focus();
					return false;
				}
			}
			msg = " Do you want to save the new table name as " + new_table_name + "? ";
			if ( window.confirm( msg ) ){
					document.kapp_table_Form.old_tab_enm.value=enm;
					document.kapp_table_Form.mode.value='table_new_copy';
					document.kapp_table_Form.action="kapp_table30m_A.php";
					document.kapp_table_Form.submit();
					ret = window.open('./progressbar.php?kapp_delay_time=3','','width=600,height=300, toolbar=no,scrollbars=yes,resizable=no');
					return;
			} else return false;
		}
	}
	function Save_Update_Insert(line){
		if( !document.kapp_table_Form.userid.value) {
			alert(' Please login! ');
			return false;
		}
		else if( !document.kapp_table_Form.tab_hnm.value) {
			alert(' Please enter a table name! ');
			return false;
		}
		for(var i=0;i<line; i++){
			len = document.getElementById('fld_len['+i+']').value;
			fnm = document.getElementById('fld_hnm['+i+']').value;
			if( !len) {
				if( fnm ) {
					alert('Check the column length input! ' + fnm);
					return false;
				}
			}
		}
		var ins = window.confirm("Register the table. ");
		if (ins){
			document.kapp_table_Form.mode.value='table_create_reaction';
			document.kapp_table_Form.action="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
		}
	}
	function create_after_run(tab_enm, tab_hnm, mode){
		var selectIndex = document.kapp_table_Form.tab_hnmS.selectedIndex;
		tab_hnmS=tab_enm + ":" + tab_hnm;
		document.kapp_table_Form.tab_hnmS[selectIndex].value = tab_hnmS;
		document.kapp_table_Form.mode.value		= "SearchTAB";
		document.kapp_table_Form.pg_mode.value		="on";
		document.kapp_table_Form.tab_enm.value	=tab_enm;
		document.kapp_table_Form.tab_hnm.value	=tab_hnm;
jQuery(document).ready(function ($) {
		$.ajax({
			header:{"Content-Type":"application/json"},
			method: "post",
                url: 'kapp_pg_curl_ajax.php',
				data: {
					"mode_insert": 'pg_curl',
					"project_nm": project_nm,
					"memo": memo,
					"seq_no": seq_no
				},
			success: function(data) {
				//console.log(data);
				alert("OK --- " + seq_no);
				location.replace(location.href);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(" Error.-- kapp_project_ajax.php");
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				return;
			}
		});
});

		document.kapp_table_Form.action="kapp_table30m_A.php";
		document.kapp_table_Form.submit();
	}
	function ref_func( no, PGthisform ) {
		fld_hnm = document.getElementById('fld_hnm['+no+']').value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');
			return false;
		}
		window.open('./fld_select.php?no='+no+'&thisform='+PGthisform,'','width=700,height=700, toolbar=no,scrollbars=yes,resizable=no');
	}
	var	fld_enmV, fld_hnmV, fld_typeV, fld_lenV, memoV,	seqnoV, Aif_lineV, Aif_typeV, Aif_dataV, Arelation_dataV;

	function up_bakup(j){
		fld_enmV  = document.getElementById('fld_enm['+j+']').value;
		fld_hnmV  = document.getElementById("fld_hnm[" + j + "]").value;
		fld_typeV = document.getElementById("fld_type[" + j + "]").value;
		fld_lenV  = document.getElementById("fld_len[" + j + "]").value;
		memoV     = document.getElementById("memo[" + j + "]").value;
		seqnoV    = document.getElementById("seqno[" + j + "]").value;
		Aif_lineV = document.getElementById("Aif_line[" + j + "]").value;
		Aif_typeV = document.getElementById("Aif_type[" + j + "]").value;
		Aif_dataV = document.getElementById("Aif_data[" + j + "]").value;
		Arelation_dataV  = document.getElementById("Arelation_data[" + j + "]").value;
	}
    function up_move(i, j){
		document.getElementById('fld_enm['+j+']').value  = document.getElementById("fld_enm[" + i + "]").value;
		document.getElementById("fld_hnm[" + j + "]").value  = document.getElementById('fld_hnm['+i+']').value;
		document.getElementById("fld_type[" + j + "]").value  = document.getElementById("fld_type[" + i + "]").value;
		document.getElementById("fld_len[" + j + "]").value  = document.getElementById('fld_len['+i+']').value;
		document.getElementById("memo[" + j + "]").value  = document.getElementById("memo[" + i + "]").value;
		document.getElementById("seqno[" + j + "]").value  = document.getElementById("seqno[" + i + "]").value;
		document.getElementById("Aif_line[" + j + "]").value  = document.getElementById("Aif_line[" + i + "]").value;
		document.getElementById("Aif_type[" + j + "]").value  = document.getElementById("Aif_type[" + i + "]").value;
		document.getElementById("Aif_data[" + j + "]").value  = document.getElementById("Aif_data[" + i + "]").value;
		document.getElementById("Arelation_data[" + j + "]").value  = document.getElementById("Arelation_data[" + i + "]").value;
	}
    function up_recover(i){
		fld_enmI = document.getElementById("fld_enm[" + i + "]").value;
		fld_hnmI = document.getElementById('fld_hnm['+i+']').value;
		document.getElementById("fld_enm[" + i + "]").value  = fld_enmV;
		document.getElementById('fld_hnm['+i+']').value  = fld_hnmV;
		document.getElementById("fld_type[" + i + "]").value = fld_typeV;
		document.getElementById('fld_len['+i+']').value  = fld_lenV;
		document.getElementById("memo[" + i + "]").value     = memoV;
		document.getElementById("seqno[" + i + "]").value    = seqnoV;
		document.getElementById("Aif_line[" + i + "]").value = Aif_lineV;
		document.getElementById("Aif_type[" + i + "]").value = Aif_typeV;
		document.getElementById("Aif_data[" + i + "]").value = Aif_dataV;
		document.getElementById("Arelation_data[" + i + "]").value = Arelation_dataV;
	}
    function up_func(){
		var i = document.kapp_table_Form.line_index.value;
		var j = Number(i) -1; // 윗 라인 //alert('up_func i:' + i);
		if( i > 0) {
			up_bakup(j);   // 윗라인 데이터 보관
			up_move(i, j);    // 현재라인 데이터 윗 라인으로 이동
			up_recover(i); 
		} else {
			return;
		}
		document.kapp_table_Form.line_index.value = j;
	    $(".manager_"+i).css('display', 'none');
	    $(".manager_"+j).css('display', 'none');
		document.kapp_table_Form["fld_hnm[" + j + "]"].focus();
		return;
	}
    function down_func(){
		var i = document.kapp_table_Form.line_index.value;
		var j = i*1 +1;

		fld_enmV  = document.getElementById('fld_enm['+j+']').value;
		fld_hnmV  = document.getElementById("fld_hnm[" + j + "]").value;
		if( fld_enmV == '' || fld_hnmV == '' ){
			alert('move column none');
			return;
		}
		if( i > 0) {
			up_bakup(j);
			up_move(i, j);
			up_recover(i);
		} else {
			return;
		}
		document.kapp_table_Form.line_index.value = j;
	    $(".manager_"+i).css('display', 'none');
	    $(".manager_"+j).css('display', 'none');
		document.kapp_table_Form["fld_hnm[" + j + "]"].focus();
		return;
	}
    function line_getA(no){
		document.kapp_table_Form.line_index.value = no;
	}
	function change_project_func(pnmS){
		document.kapp_table_Form.mode.value="Project_Search";
		document.kapp_table_Form.action="kapp_table30m_A.php";
		document.kapp_table_Form.submit();
	}
	function change_table_func(pnmS){ // Relation_Table_func
		tab = pnmS.split(":");
		hnm=tab[1];
		enm=tab[0];
		document.kapp_table_Form.old_tab_enm.value = enm;
		document.kapp_table_Form.mode.value="SearchTAB";
		document.kapp_table_Form.action="kapp_table30m_A.php";
		document.kapp_table_Form.submit();
	}
//------------ table list -------------
	function page_move(thisform, $page, linkurl){
		thisform.page.value = $page;
		thisform.action= linkurl; 
		thisform.submit();
	}
	function title_wfunc(fld_code){       
		document.table_list.page.value = 1;
		document.table_list.fld_code.value= fld_code;
		document.table_list.fld_code_asc.value= 'desc';
		document.table_list.mode.value='title_wfunc';
		document.table_list.target='_self';
		document.table_list.action='kapp_table_list.php';
		document.table_list.submit();                         
	} 
	function title_func(fld_code){       
		document.table_list.page.value = 1;                
		document.table_list.fld_code.value= fld_code;           
		document.table_list.fld_code_asc.value= 'asc';
		document.table_list.mode.value='title_func';           
		document.table_list.target='_self';
		document.table_list.action='kapp_table_list.php';
		document.table_list.submit();                         
	} 
	function check_enter() { if (event.keyCode == 13) { search_func(); } }
	function Cancle_run() {
		window.open('/','_top','');
	}
	function excel_upload_func(tab_enm, tab_hnm){
		document.table_list.pg_call.value ="kapp_table_list.php";
		document.table_list.mode.value		="Upload_mode_table10i";
		document.table_list.tab_enm.value	=tab_enm;
		document.table_list.tab_hnm.value	=tab_hnm;
		document.table_list.action			="excel_load.php";
		document.table_list.submit();
	}
	function excel_down_func(tab_enm, tab_hnm){
		Lid = document.table_list.login_id.value;
		if( !Lid ) {
			alert("member page "); return false;
		} else {
			document.table_list.mode.value		="Excel_mode_table10i";
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.action			="down_excel_file.php";
			document.table_list.submit();
		}
	}
	function table_update_func(tab_enm, tab_hnm, group_code , mid) {
		msg = "table are also update. \n Do you want to update the " + tab_hnm + " table? ";
		if ( window.confirm( msg ) ){
			document.table_list.mode.value ="Search";
			document.table_list.mid.value	=mid;
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.tab_hnmS.value	=tab_enm + ":"+tab_hnm;
			document.table_list.group_code.value	=group_code;
			document.table_list.action ="table_design_update.php";
			document.table_list.submit();
		} else {
			return false;
		}
	}
	function delete_table_func(tab_enm, tab_hnm ) {
		msg = "When you delete a table, all the programs that used the table are also deleted. \n Data can not be recovered.\n Do you want to delete the " + tab_hnm + " table? ";
		if ( window.confirm( msg ) ){
			document.table_list.mode.value ="Delete_mode";
			document.table_list.tab_enm.value	=tab_enm;
			document.table_list.tab_hnm.value	=tab_hnm;
			document.table_list.action ="kapp_table_list.php";
			document.table_list.submit();
		} else {
			return false;
		}
	}
	function table_sel_func(enm, hnm, data, page) {
		document.table_list.data.value = data;
		document.table_list.page.value = page;
		document.table_list.tab_hnmS.value = enm + ":" + hnm;
		document.table_list.tab_enm.value=enm;
		document.table_list.tab_hnm.value=hnm;
		document.table_list.mode.value='Search';
		document.table_list.action="kapp_table_list.php";
		document.table_list.target='_self'; // .htm
		document.table_list.submit();
	}
	function program_run_funcList( pg_name, pg_code ) {
		document.table_list.mode.value		="tab_list_pg70";
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		document.table_list.action				="tkher_program_run.php";
		document.table_list.target='_blank';
		document.table_list.submit();
	}
	function program_run_funcListT( pg_name, pg_code, group_code ) {
		document.table_list.mode.value		="tab_list_pg70";
		document.table_list.pg_name.value	=pg_name;
		document.table_list.pg_code.value	=pg_code;
		document.table_list.group_code.value=group_code;
		document.table_list.page.value	=1;
		document.table_list.action ="kapp_program_data_list.php";
		document.table_list.target='_blank';
		document.table_list.submit();
	}
	function tkher_source_create(hnm, enm, $coin){
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.table_list.mode.value = "DN_sqltable";
				document.table_list.action = 'tkher_php_tableDN.php';
				document.table_list.target = '_blank';
				document.table_list.submit();
			} else {
				alert('Cancel!');
			}
		}
	}
	function Table_source_create(hnm, enm, $coin){
		if( $coin < 1000 ) {
			alert('Point is low. You must do activities to accumulate points. point:'+ $coin);
			return false;
		} else {
			if( confirm("Are you sure you want to Create? ") ) {
				document.table_list.mode.value	= "sqltable_only";
				document.table_list.action		= 'tkher_php_tableDN.php';
				document.table_list.target		= '_blank';
				document.table_list.submit();
			} else {
				alert('Cancel!');
			}
		}
	}
	function table_search(){
		var tab_hnm = document.table_list.data.value;
		var tab = document.table_list.tab_hnmS.value;
		document.table_list.page.value =1;
		document.table_list.mode.value='Table_Search';
		document.table_list.action="kapp_table_list.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function run_back( mode, data, page){
		//document.table_list.group_code.value='';
		document.table_list.mode.value		='';
		document.table_list.data.value		=data;
		document.table_list.page.value		=page;
		document.table_list.action		="kapp_table_list.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function my_data(){
		document.table_list.mode.value='My_List';
		document.table_list.action		="kapp_table_list.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	function Change_line_cnt( $line){
		document.table_list.page.value = 1;
		document.table_list.line_cnt.value = $line;
		document.table_list.action='kapp_table_list.php';
		document.table_list.submit();
	}
	function group_code_change_func(cd){
		index=document.table_list.group_code.selectedIndex;
		nm = document.table_list.group_code.options[index].text;
		document.table_list.mode.value='Search_Project';
		document.table_list.group_name.value=nm;
		document.table_list.action		="kapp_table_list.php";
		document.table_list.target='_self';
		document.table_list.submit();
	}
	//------- table index create -----------
	function indexlist_onclick(keyval) {
		if( keyval == 'seqno') {
			alert("Primary key is not delete : " + keyval);
			document.kapp_makeform.index_name.value='';
		} else {
			document.kapp_makeform.index_name.value=keyval;
		}
	}
	function k_func_ok( r, j ){
		return;
	}
	function r_func(r,qna){
		qna1 = qna.split('^');
		len = qna1.length;
		ss="";
		for(i=0;i<len;i++){
			rr = qna1[i].split('|');
			lenj = rr.length-2;
			ok = rr.length-1;
			ss+=" &#160; <p><form><div>"+(i+1)+". "+rr[0]+"</div> ";
			for(k=0,j=1; k < lenj; k++, j++){
				ss+=" &#160; <label><span><input type='radio' name='qna' onclick=\"k_func_ok('"+ rr[j] +"', "+j+")\" value='"+ rr[j] +"' >" +j+'. ' + rr[j]+" &#160; </span></label><br>";
			}
		}
		ss+="</form></p>";
		here.innerHTML=ss;
	}
	function Print_item_func( ss, qna ){
		if(!ss) r_func('A', qna);
		else here.innerHTML = ss;
	}
	let A_click=0;
	function column_list_onclickAA( j ){
		if( A_click == 1){
			A_click=0;
		} else if( A_click == 0){
			if( document.getElementById('column_list'+j).checked === false ){
				document.getElementById('column_list'+j).checked = true;
			}else{
				document.getElementById('column_list'+j).checked = false;
			}
		}
	}
	function column_list_onclickA( ss, j ){
		A_click = 1;
	}
	function change_project_Index_func(pnmS){
		if( pnmS == '') {
			alert('Select Project!');
			return false;
		}
		document.getElementById('mode').value = 'Project_Search';
		document.kapp_makeform.action="./kapp_table_index_Create.php";
		document.kapp_makeform.submit();
	}

	function change_table_Index_func(pnmS){
		document.kapp_makeform.mode.value='SearchTAB';
		document.kapp_makeform.action="./kapp_table_index_Create.php";
		document.kapp_makeform.submit();
	}

	function index_Create_button( pg) {
		var idx_name = document.getElementById('idx_name').value;
		if( idx_name == '' ){
			document.kapp_makeform.idx_name.focus();
			alert("enter index name"); return false;
		}
		var key_array = document.getElementById('key_array').value;
		var p_selind = kapp_makeform.project_nmS.selectedIndex; 
		var p_val    = kapp_makeform.project_nmS.options[p_selind].value;
		var p_nm      = kapp_makeform.project_nmS.options[p_selind].text;
		if( p_nm =='1.Select Project' || p_nm =='' ){
			alert( " Please select a project! p_selind: " + p_selind);
			document.kapp_makeform.project_nmS.focus();
			return false;
		}
		var tab_selind = kapp_makeform.tab_hnmS.selectedIndex; 
		var tab_val    = kapp_makeform.tab_hnmS.options[tab_selind].value;
		var tabnm      = kapp_makeform.tab_hnmS.options[tab_selind].text;
		if( !tab_selind || !tabnm) {
			alert( tab_selind+" :  Please select a table! ");
			document.kapp_makeform.tab_hnmS.focus();
			return false;
		}
		if( !confirm('Do you want to Create! '+idx_name + ', tab: '+tabnm ) ) return;
		const checkbox = document.getElementById('idxdup_confirm');
		if( checkbox.checked === false){
			alert("Please check for duplicate index names.");
			return false;
		} else{
			Index_name_Dup_Check();
		}
		var colnm = document.getElementsByName('column_list'); 
		var item_cnt = colnm.length;
		str_array = '';
		icnt= 0;
		var index_data = '|' + idx_name + '|';
		for( i = 0; i < item_cnt; i++) {
			if( document.getElementById('column_list'+i).checked === true ){
				colnm_value = colnm[i].value;
				fldA = colnm_value.split('|');
				icnt++;
				if(icnt == 1) index_data = index_data + fldA[1];
				else if(icnt > 1) index_data = index_data  + '|' + fldA[1];
			}
		} 
		if( icnt == 0){
			alert("Select one or more columns"); return false;
		}
		key_array = key_array + index_data+ '@' ;

		if( pg == "kapp_index_Create") {
			jQuery(document).ready(function ($) {
					var tab_enm= $("#tab_enm").val();
					$.ajax({
						header:{"Content-Type":"application/json"},
						method: "post",
							data: {
								"mode": 'kapp_table_index_add',
								"tab_enm": JSON.stringify(tab_enm),
								"key_array": JSON.stringify(key_array),
								"index_data": JSON.stringify(index_data),
								"index_name": JSON.stringify(idx_name)
							},
						url: "./kapp_table_index_ajax.php",
						success: function(data) {
							alert(data); //console.log(data);
							document.kapp_makeform.mode.value='SearchTAB';
							document.kapp_makeform.action="./kapp_table_index_Create.php";
							document.kapp_makeform.submit();
						},
						error: function(jqXHR, textStatus, errorThrown) {
							alert("data: ");
							console.log(jqXHR);
							console.log(textStatus);
							console.log(errorThrown);
							return;
						}
					});

			});
		}
	}
	function Index_name_Dup_Check(){
		const checkbox = document.getElementById('idxdup_confirm');
		var idx_name = document.getElementById('idx_name').value;
		if( idx_name == '' ){
			document.kapp_makeform.idx_name.focus();
			alert("enter index name"); return false;
		}
		var key_array = document.getElementById('key_array').value;
		if( key_array == '') {
			checkbox.checked = true;
			return true;
		} else{
			keyA = key_array.split('@');
			for( i=0; i<keyA.length; i++){
				ikey = keyA[i].split('|');
				if( ikey[1] == idx_name ) {
					alert("Please check for duplicate index names.");
					checkbox.checked = false;
					return false;
				}
			}
		}
		checkbox.checked = true;
		return true;
	}
	jQuery(document).ready(function ($) {
		$('#Delete_idx').on('click', function() {
			var tab_enm= $("#tab_enm").val();
			var index_name= $("#index_name").val();
			var key_array= $("#key_array").val();
			if( !confirm('Do you want to delete! '+index_name ) ) return;
			keyA = key_array.split('@');
			keyB = '';
			for(i=0;i<keyA.length && keyA[i] !==''; i++){
				keyfld = keyA[i].split('|');
				if( keyfld[1] !== index_name) {
					keyB = keyB + keyA[i] + '@';
				}
			}
			$.ajax({
				header:{"Content-Type":"application/json"},
				method: "post",
					data: {
						"mode": 'kapp_table_index_delete',
						"tab_enm": JSON.stringify(tab_enm),
						"key_array": JSON.stringify(keyB),
						"index_name": JSON.stringify(index_name)
					},
				url: "./kapp_table_index_ajax.php",
				success: function(data) {
					alert(data); //console.log(data);
					document.kapp_makeform.mode.value='SearchTAB';
					document.kapp_makeform.action="./kapp_table_index_Create.php";
					document.kapp_makeform.submit();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("data: ");
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
					return;
				}
			});
		});
	});

//---------- SQL to Table --------
	function sql_tab(tab) {
		table_enm = tab.split('`');
		document.kapp_SQL_Form.tab_enm.value = 'SQLKapp_' + table_enm[1];
		document.kapp_SQL_Form.tab_hnm.value = table_enm[1];
		return table_enm[1];
	}
	function fld0_enmF(fld0) {
		fld0_enm = fld0.split('`');
		return fld0_enm[3];
	}

	function fld0_typeF(fld0) {

		fld0_type_ok = '';
		fld0_ = fld0.split('`');
		if( fld0_[4].indexOf("(") == -1 ){ // none
			fld0_t = fld0_[4].split(' ');
			if( fld0_t[1] !='') fld0_type_ok = fld0_t[1];
		} else {
			fld0_tt = fld0_[4].split('(');
			fld0_type_ok = fld0_tt[0];
		}
		fld0_type_ok = fld0_type_ok.replace(' ', '');
		return fld0_type_ok;
	}
	function fld0_lenF( fld0 ) {
		fld0_ = fld0.split('`');
		if( fld0_[4].indexOf("(") == -1 ){
			f_len = '';
		} else {
			fld0_t = fld0_[4].split('(');
			fld0_len = fld0_t[1].split(')');
			f_len = fld0_len[0];
		}
		return f_len;
	}

	function fld0_deF( fld0 ) {
		fld0_type_ok ='';
		fld0_ = fld0.split('`');
		if( fld0_[4].indexOf("(") == -1 ){
			fld0_t = fld0_[4].split(' ');
			for( i=0; i < fld0_t.length; i++){
				if( i> 1 && fld0_t[i] !='') fld0_type_ok = fld0_type_ok + ' ' + fld0_t[i];
			}
		} else {
			fld0_t = fld0_[4].split('(');
			fld0_len = fld0_t[1].split(')');
			fld0_type_ok = fld0_len[1];
		}
		return fld0_type_ok;
	}

	function fld_typeF( mf2 ) {
		fld_ = mf2.split('(');
		fld_t = fld_[0].replace(' ', '');
		return fld_t;
	}

	function fld_lenF( mf2) {
		field_len = '';
		fld_ = mf2.split('(');
		fld_len = fld_[1].split(')');
		field_len = fld_len[0];
		default_data = fld_len[0] + '|' +fld_len[1];
		return field_len;
	}
	function SQL_check() {
		Pnm=document.kapp_SQL_Form.project_code.value;
		if( Pnm ==''){
			alert("Project name confirm;");
			return false;
		}
		document.kapp_SQL_Form.dup_confirm.checked =false;
		document.kapp_SQL_Form.sql_table.value = '';
		if(!document.kapp_SQL_Form.sql_memo.value) {
			alert('Please enter SQL.');
			document.kapp_SQL_Form.sql_memo.focus();
			return;
		} else {
			let sqlm = [];
			msg = '';
			auto = '';
			key_msg = '';
			key_cnt = 0;
			item_array ='';
			sqlA= document.kapp_SQL_Form.sql_memo.value;
			sqlm = sqlA.split(',');
			tab_enm = sql_tab( sqlm[0]);
			sqlm0 = sqlm[0].split('`');
			if( sqlm0[3] =='' && sqlm0[4] =='' ) {
				alert("The format of the first line of SQL should be \n 'CREATE TABLE IF NOT EXISTS `table_name` ( `colunm_name` data_type' ");
				return;
			}
			tab_enm = sqlm0[1];
			fld0_enm = sqlm0[3];

			if( sqlm0[4].indexOf("(") != -1 ) {
				fnm = sqlm0[4].split('(');
				fld0_type = fnm[0].replace( ' ', '');
				f_len = fnm[1].split(')');
				fld_len = f_len[0];
				fld_len_default = sqlm0[4];

			} else {
				fnm = sqlm0[4].split(' ');
				fld0_type = fnm[1];
				fld_len = '';
				fld_len_default = sqlm0[4].replace( fnm[1], '');
			}
			fld0_type = fld0_type.toUpperCase();
			msg = tab_enm + '\n' + '@' + '|' +fld0_enm + '|' + fld0_type +'|'+ fld_len + '|' + fld_len_default + '\n' +'@';
			item_array = '|' +fld0_enm + '|' +fld0_enm + '|' + fld0_type +'|'+ fld_len + '|' + fld_len_default +'@';
			if( fld0_enm == 'seqno') { // seqno is kapp system column
				jj =1;
			} else {
				jj = 2;
				document.kapp_SQL_Form["fld_enm[1]"].value  = fld0_enm;
				document.kapp_SQL_Form["fld_hnm[1]"].value  = fld0_enm;
				document.kapp_SQL_Form["fld_type[1]"].value  = fld0_type;
				document.kapp_SQL_Form["fld_len[1]"].value  = fld_len;
				document.kapp_SQL_Form["memo[1]"].value  = fld_len_default;
			}

			last_check = ''; 
			for( i=1; i < sqlm.length; i++, jj++){
				fld_enm = '';
				fld_t = '';
				fld_len = '';
				auto = '';
				sqlm_i = sqlm[i];
				mf = sqlm[i].split('`');
				fld_enm = mf[1];

				if( last_check == 'on' ){
					if( i == sqlm.length-1 ) {
						key_msg = key_msg + sqlm_i;
						/*
							KEY `em_tran_1` (`tran_date`), 
							KEY `em_tran_2` (`tran_id`, `tran_rslt`), 
							KEY `em_tran_4` (`tran_refkey`), 
							KEY `em_tran_5` (`tran_status`, `tran_date`), 
							KEY `em_tran_6` (`tran_status`, `tran_rslt`), 
							KEY `em_tran_7` (`tran_net`)
							)  AUTO_INCREMENT=1 ;
						*/
						kmsg = key_msg.split(')');
						key_array = '';
						for( ii=0; ii < kmsg.length; ii++){
							keyf = kmsg[ii].split('`');
							for( jj=0; jj < keyf.length; jj++){
								if( jj == 1 || jj == 3 || jj == 5 || jj == 7) key_array = key_array + '|' + keyf[jj];
							}
							key_array = key_array + '@';
						}
						document.kapp_SQL_Form.key_array.value = key_array;
						//key_array: |em_tran_1|tran_date
						//@|em_tran_2|tran_id|tran_rslt@|em_tran_4|tran_refkey@|em_tran_5|tran_status|tran_date@|em_tran_6|tran_status|tran_rslt@|em_tran_7|tran_net@@@
					} else key_msg = key_msg + sqlm_i + ', ';
					continue;
				}

				if( mf[2] == '' ){	
					alert(" SQL error : mf2: " + mf[2]);
					if( last_check == 'on' && i == sqlm.length-1 ) {
						alert( i+ " - msg: " +msg);
						break;
					} else if( last_check == 'on' && i < sqlm.length-1 ) continue;
					break;
				}

				if( sqlm[i].indexOf("PRIMARY KEY") != -1 || sqlm[i].indexOf("primary key") != -1 ) {
					fld_enm = '';
					fld_t = '';
					last_check = 'on';
					continue;
				} else if( sqlm[i].indexOf("UNIQUE KEY") != -1 ) {
					fld_enm = '';
					fld_t = '';
					key_msg = key_msg +sqlm[i] + ',';
					last_check = 'on';
					continue;
				} else if( sqlm[i].indexOf("KEY index") != -1 ) {
					fld_enm = '';
					fld_t = '';
					key_msg = key_msg +sqlm[i] + ',';
					last_check = 'on';
					continue;
				} else if( sqlm[i].indexOf("KEY ") != -1 || sqlm[i].indexOf("key ") != -1 ) {
					key_msg = key_msg +sqlm[i] + ',';
					last_check = 'on';
					continue;
				} else {
					if( mf[2].indexOf("(") != -1 ) {
						fnm = mf[2].split('(');
						fld_t = fnm[0].replace( ' ', '');
						f_len = fnm[1].split(')');
						fld_len = f_len[0];
						fld_len_default = mf[2];
						if( i== sqlm.length-1 ){
							def = fld_len_default.split(')');
							fld_len_default = def[0] + ') '+ def[1];
						}
					} else {
						if( i== sqlm.length-1 ) alert("222 mf2: " + mf[2]);
						fnm = mf[2].split(' ');
						fld_t = fnm[1];
						fld_len_default = mf[2];
						fld_len ='';
						if( i== sqlm.length-1 ){
							def = fld_len_default.split(')');
							fld_len_default = def[0] + ' ' + def[1];
						}
					}
					fld_t = fld_t.toUpperCase();
					msg = msg + '|' + fld_enm + '|' + fld_t +'|'+ fld_len + '|' + fld_len_default + '\n' +'@';
					item_array = item_array + '|' +fld_enm + '|' +fld_enm + '|' + fld_t +'|'+ fld_len + '|' + fld_len_default +'@';
				}
				fld_t = fld_t.toUpperCase();			//alert( i+ ",  fld_t: " + fld_t );
				document.kapp_SQL_Form["fld_enm[" + jj + "]"].value  = fld_enm;
				document.kapp_SQL_Form["fld_hnm[" + jj + "]"].value  = fld_enm;
				document.kapp_SQL_Form["fld_type[" + jj + "]"].value  = fld_t;
				document.kapp_SQL_Form["fld_len[" + jj + "]"].value  = fld_len;
				fld_len_default = fld_len_default.replace('auto_increment', '');
				document.kapp_SQL_Form["memo[" + jj + "]"].value  = fld_len_default;
			} //for
			document.kapp_SQL_Form.key_msg.value = key_msg;
			msg = msg + key_msg;
			document.kapp_SQL_Form.sql_table.value = msg;
			document.kapp_SQL_Form.item_array.value = item_array;
			document.kapp_SQL_Form.item_cnt.value = i;
		}
		document.kapp_SQL_Form.mode.value='SQL_Search';
		document.kapp_SQL_Form.action="kapp_Sql_to_Table.php";
		document.kapp_SQL_Form.submit();
	}

	function Project_change_SQL_func(cd){
		index=document.kapp_SQL_Form.project_code.selectedIndex;
		//document.kapp_SQL_Form.project_name.value=document.kapp_SQL_Form.project_code.options[index].text;
		document.kapp_SQL_Form.old_group_code.value=document.kapp_SQL_Form.project_code.options[index].value;
		return;
	}

	function type_set_SQL_func( i, v) {
		if( i==0 ) {
			alert('Can not be changed because it is a key.' );
			document.kapp_SQL_Form["fld_type[0]"].value = 'INT';
			return false;
		}
		if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "INT") document.kapp_SQL_Form["fld_len["+i+"]"].value = '12';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "TINYINT")   document.kapp_SQL_Form["fld_len["+i+"]"].value = '3';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "SMALLINT")  document.kapp_SQL_Form["fld_len["+i+"]"].value = '5';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "MEDIUMINT") document.kapp_SQL_Form["fld_len["+i+"]"].value = '8';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "BIGINT")    document.kapp_SQL_Form["fld_len["+i+"]"].value = '15';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "DECIMAL")   document.kapp_SQL_Form["fld_len["+i+"]"].value = '6';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "FLOAT")     document.kapp_SQL_Form["fld_len["+i+"]"].value = '8.3';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "DOUBLE")    document.kapp_SQL_Form["fld_len["+i+"]"].value = '12.3';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "CHAR")      document.kapp_SQL_Form["fld_len["+i+"]"].value = '5';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "VARCHAR")   document.kapp_SQL_Form["fld_len["+i+"]"].value = '15';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "TEXT")      document.kapp_SQL_Form["fld_len["+i+"]"].value = '255';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "BLOB")      document.kapp_SQL_Form["fld_len["+i+"]"].value = '255'; // default 255
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "LONGBLOB")  document.kapp_SQL_Form["fld_len["+i+"]"].value = '255';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "DATE")      document.kapp_SQL_Form["fld_len["+i+"]"].value = '15';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "DATETIME")  document.kapp_SQL_Form["fld_len["+i+"]"].value = '20';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "TIME")      document.kapp_SQL_Form["fld_len["+i+"]"].value = '8';
		else if( document.kapp_SQL_Form["fld_type["+i+"]"].value == "YEAR")      document.kapp_SQL_Form["fld_len["+i+"]"].value = '4';
	}
	function line_set_func(cnt) {
		document.kapp_SQL_Form.mode.value='line_set';
		document.kapp_SQL_Form.line_set.value=cnt;
		document.kapp_SQL_Form.action="kapp_Sql_to_Table.php";
		document.kapp_SQL_Form.submit();
	}

    async function delay(delayInms) {
      return new Promise(resolve  => {
        setTimeout(() => {
          resolve(2);
        }, delayInms);
      });
    }
    async function time_delay_sample(cnt, ret) {
		console.log('waiting...')
		let delayres = await delay(cnt);
		ret.close();
    }

	function table_create_func(line){
		if( document.kapp_SQL_Form.dup_confirm.checked === false ) {
			alert("duplicate Confirm error, table - duplicate confirm please!");
			return false;
		}
		if( !document.kapp_SQL_Form.project_code.value) {
			alert(' Select Project! code:' + document.kapp_SQL_Form.project_code.value);
			return false;
		}

		if( !document.kapp_SQL_Form.userid.value) {
			alert(' Please login! ');
			return false;
		}
		else if( !document.kapp_SQL_Form.tab_hnm.value) {
			alert(' Please enter a table name! ');
			return false;
		}
		var ins = window.confirm("Register and create the table. ");
		if( ins ) {
			document.kapp_SQL_Form.mode.value='sql_table_create';
			document.kapp_SQL_Form.action="kapp_Sql_to_Table.php";
			document.kapp_SQL_Form.submit();
			ret = window.open('./progressbar.php?kapp_delay_time=6','','width=600,height=300, toolbar=no,scrollbars=yes,resizable=no');
			//time_delay_sample(6000, ret);
		}
	}

	function resetgo(){
		window.open( 'kapp_Sql_to_Table.php' , '_self', '');
		return;
	}
	function ref_func_SQL( no ) {
		document.kapp_SQL_Form.no.value=no;
		fld_hnm = document.kapp_SQL_Form["fld_hnm[" + no + "]"].value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');
			return false;
		}
		window.open('./fld_select.php?no='+no,'','width=700,height=700, toolbar=no,scrollbars=yes,resizable=no');
	}
	var	fld_enmV, fld_hnmV, fld_typeV, fld_lenV, memoV,	seqnoV, Aif_lineV, Aif_typeV, Aif_dataV, Arelation_dataV;

	function up_bakup(j){
		fld_enmV  = document.kapp_SQL_Form["fld_enm[" + j + "]"].value;
		fld_hnmV  = document.kapp_SQL_Form["fld_hnm[" + j + "]"].value;
		fld_typeV = document.kapp_SQL_Form["fld_type[" + j + "]"].value;
		fld_lenV  = document.kapp_SQL_Form["fld_len[" + j + "]"].value;
		memoV     = document.kapp_SQL_Form["memo[" + j + "]"].value;
		seqnoV    = document.kapp_SQL_Form["seqno[" + j + "]"].value;
	}
    function up_move(i, j){
		document.kapp_SQL_Form["fld_enm[" + j + "]"].value  = document.kapp_SQL_Form["fld_enm[" + i + "]"].value;
		document.kapp_SQL_Form["fld_hnm[" + j + "]"].value  = document.kapp_SQL_Form["fld_hnm[" + i + "]"].value;
		document.kapp_SQL_Form["fld_type[" + j + "]"].value  = document.kapp_SQL_Form["fld_type[" + i + "]"].value;
		document.kapp_SQL_Form["fld_len[" + j + "]"].value  = document.kapp_SQL_Form["fld_len[" + i + "]"].value;
		document.kapp_SQL_Form["memo[" + j + "]"].value  = document.kapp_SQL_Form["memo[" + i + "]"].value;
		document.kapp_SQL_Form["seqno[" + j + "]"].value  = document.kapp_SQL_Form["seqno[" + i + "]"].value;
	}
    function up_recover(i){
		fld_enmI = document.kapp_SQL_Form["fld_enm[" + i + "]"].value;
		fld_hnmI = document.kapp_SQL_Form["fld_hnm[" + i + "]"].value;
		document.kapp_SQL_Form["fld_enm[" + i + "]"].value  = fld_enmV;
		document.kapp_SQL_Form["fld_hnm[" + i + "]"].value  = fld_hnmV;
		document.kapp_SQL_Form["fld_type[" + i + "]"].value = fld_typeV;
		document.kapp_SQL_Form["fld_len[" + i + "]"].value  = fld_lenV;
		document.kapp_SQL_Form["memo[" + i + "]"].value     = memoV;
		document.kapp_SQL_Form["seqno[" + i + "]"].value    = seqnoV;
	}
    function up_func(){
		var i = document.kapp_SQL_Form.line_index.value;
		var j = i*1 -1;
		if ( i > 0) {
			up_bakup(j);
			up_move(i, j);
			up_recover(i);
		} else {
			return;
		}
		document.kapp_SQL_Form.line_index.value = j;
	    $(".manager_"+i).css('display', 'none');
	    $(".manager_"+j).css('display', 'none');
		document.kapp_SQL_Form["fld_hnm[" + j + "]"].focus();
		return;
	}
    function down_func(){
		var i = document.kapp_SQL_Form.line_index.value;
		var j = i*1 +1;
		fld_enmV  = document.kapp_SQL_Form["fld_enm[" + j + "]"].value;
		fld_hnmV  = document.kapp_SQL_Form["fld_hnm[" + j + "]"].value; //alert('fld_enmV i:' + fld_enmV + ', fld_hnmV:' +fld_hnmV);
		if( fld_enmV == '' || fld_hnmV == '' ){
			alert('last line.');
			return;
		}
		if ( i > 0) {
			up_bakup(j);
			up_move(i, j);
			up_recover(i);
		} else {
			return;
		}
		document.kapp_SQL_Form.line_index.value = j;
	    $(".manager_"+i).css('display', 'none');
	    $(".manager_"+j).css('display', 'none');
		document.kapp_SQL_Form["fld_hnm[" + j + "]"].focus();
		return;
	}
    function line_getA(no){
		document.kapp_SQL_Form.line_index.value = no;
	}

	function table_nm_dup_check(){
		Pnm=document.kapp_SQL_Form.project_code.value;
		if( Pnm ==''){
			alert("Project name confirm;");
			return false;
		}

		var $tab_enm= document.kapp_SQL_Form.tab_enm.value;
		var $tab_hnm= document.kapp_SQL_Form.tab_hnm.value;
		if( $tab_enm =='' || $tab_hnm =='') {
			alert("table code and table name confirm; Project name: " + Pnm);
			return false;
		}
		jQuery(document).ready(function ($) {
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: 'kapp_table_dup_ajax.php',
						data: {
							"mode_insert": 'table_dup_check',
							"tab_hnm": $tab_hnm,
							"tab_enm": $tab_enm
						},
					success: function(data) {
						//console.log(data);
						if( data.indexOf('Already exists') == -1 ) {
							document.kapp_SQL_Form.dup_confirm.checked =true;
							alert( data + ",  tab_enm " + $tab_enm);
						} else {
							document.kapp_SQL_Form.dup_confirm.checked =false;
							alert("Error - Table name is duplicated "+ data + ",  tab_enm " + $tab_enm);
						}
						//location.replace(location.href);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert("Error Dup! data: "+ data + ", tab_enm: " + $tab_enm);
						document.kapp_SQL_Form.dup_confirm.checked =false;
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						return;
					}
				});
		});
	}
	//------ table relationship : kapp_table_relation_Change10 --------
	function reset_confirm(){
		var relation_num = document.getElementById('relation_num').value;
		resp = confirm(' Would you like to reset relationship data removable? reset relation no: ' + relation_num);
		if( !resp ) return false;
		else {
			document.kapp_Relation_Form.mode.value='Reset_Check';
			document.kapp_Relation_Form.relation_reset.value='on';
			document.kapp_Relation_Form.relation_move_data.value='';
			document.kapp_Relation_Form.relation_data.value='';
			document.kapp_Relation_Form.relation_key.value='';
			document.kapp_Relation_Form.action="./kapp_table_relation_Change10.php";
			document.kapp_Relation_Form.target='_self';
			document.kapp_Relation_Form.submit();
		}
		return;
	}
	function delete_confirm(){
		resp = confirm(' Would you like to Delete relationship data removable?');
		if( !resp ) return false;
		else {
			document.kapp_Relation_Form.mode.value='Delete_Check';
			document.kapp_Relation_Form.relation_reset.value='';
			document.kapp_Relation_Form.relation_move_data.value='';
			document.kapp_Relation_Form.relation_data.value='';
			document.kapp_Relation_Form.action="./kapp_table_relation10.php";
			document.kapp_Relation_Form.submit();
		}
		return;
	}
	function relation_save_ALL_func(relation_num) {
		if( document.kapp_Relation_Form.relation_type_SQL[0] === false && document.kapp_Relation_Form.relation_type_SQL[1] === false){
			alert(" The relation is Update. Please select a key field and click the 'SQL Save' button to save it! ");
			return false;
		}
		if( document.kapp_Relation_Form.relation_move_data.value ==''){ 
			alert(" After setting the relational expression, click the 'save' button!");
			return false; 
		}
		if( document.kapp_Relation_Form.relation_key_column.value ==''){ 
			alert(" After setting the relational key column expression, click the 'save' button!");
			return false; 
		}
		key_col = document.kapp_Relation_Form.relation_key_column.value;
		var colnm = document.getElementsByName('re_key_col'); 
		var k_cnt = colnm.length;
		colnm_value = document.getElementById('relation_key_column').value + ":";
		$k_check = 0;
		for( i=0; i<k_cnt; i++){
			if( document.getElementById('re_key_col'+i).checked === true ){
				if( i ==0 ) colnm_value =  colnm_value + colnm[i].value + "|";
				else if( i > 0 ) colnm_value =  colnm_value + ":" + colnm[i].value + "|";
				$k_check++;
			}
		}
		if( $k_check == 0 ){ //key column none clicked
			alert("key column no clicked"); return false;
		}
		document.getElementById('relation_key').value= colnm_value;
		document.getElementById('relation_key_old_['+relation_num+']').value = colnm_value;
		Rnum = relation_num + 1;
		document.getElementById('relation_key_column').value = colnm_value;
		resp = confirm(' Do you want to Save relation - '+Rnum +' ?');
		if( !resp ) return false;
		kapp_Relation_Form.relation_reset.value = '';
		document.kapp_Relation_Form.mode.value="table_relation_save";
		document.kapp_Relation_Form.action="./kapp_table_relation10.php";
		document.kapp_Relation_Form.submit();
	}

	function delete_after_run(relation_pg_codeS, pg_code){
		alert('relation_pg_codeS: '+relation_pg_codeS+', pg_code: '+pg_code);
		document.kapp_Relation_Form.pg_code.value =pg_code;
		document.kapp_Relation_Form.relation_pg_codeS.value=relation_pg_codeS;
		document.kapp_Relation_Form.mode.value='DeletePG';
		document.kapp_Relation_Form.target		='_self';
		document.kapp_Relation_Form.action		="./kapp_table_relation10.php";
		document.kapp_Relation_Form.submit();
	}
	function create_after_runX(relation_pg_codeS, Rtab_hnmS){
		document.kapp_Relation_Form.mode.value='Save_OK';
		document.kapp_Relation_Form.target		='_self';
		document.kapp_Relation_Form.action		="./kapp_table_relation10.php";
		document.kapp_Relation_Form.submit();
	}
	function relation_sql_type( pg, val){
		dd = document.getElementById('relation_data_old_['+pg+']').value;
		if( dd==''){
			alert("Please set up the removable data first! type: "+val);
			document.kapp_Relation_Form.relation_type_SQL[0].checked = false;
			document.kapp_Relation_Form.relation_type_SQL[1].checked = false
			return;
		}
		document.getElementById('relation_key_column').value= val;
		Rtab_col = document.getElementById('Rtab_col').value; 	
		RTcol = Rtab_col.split('|');
		rdata = dd.split('$');
		st = " style='background-color:cyan;' ";
		ss='';
		k=0;
		for( i=0; RTcol[i] !='' && i<RTcol.length; i++){
			RTcol_i = RTcol[i];
			rr_fld = RTcol_i.split(':');
			re_enm = rr_fld[0]; // enm
			re_hnm = rr_fld[1]; // hnm
			re_yp  = rr_fld[2]; // type
			ck = '';
			for( j=1; rdata[j] !='' && j<rdata.length; j++){
				rr = rdata[j].split('|');
				pg = rr[0]; // program field
				sk = rr[1]; // sik
				RF = rr[2]; // relation table field
				fn = RF.split(':');
				Renm = fn[0];
				Rhnm = fn[1];
				Rtyp = fn[2];
				Rlen = fn[3];
				Kval = Renm+":"+Rhnm+":"+Rtyp+":"+Rlen;
				if( Renm == re_enm) {
					tt = "Renm:" + Renm+", Rhnm:" + Rhnm+", Rtyp:" + Rtyp+", Rlen:" + Rlen;
					ss+="<label " +st+ " title='"+ tt +"'><input type='checkbox' "+ck+" id='re_key_col"+k+"' name='re_key_col' title='"+ tt+"' value='"+ Kval+"'>"+Rhnm+"</label><br>";
					k++;
				}
			}
		}
		here_relation.innerHTML = ss;
		alert("Now, set the key column!");
	}
	function relation_move_set(){
		var relation_pg_codeS = document.getElementById('relation_pg_codeS').value;
		var Rtab_hnmS = document.getElementById('Rtab_hnmS').value;
		var pg_name = document.getElementById('pg_name').value;
		var tab_hnm = document.getElementById('tab_hnm').value;
		if(!relation_pg_codeS){
			alert(' Select the program for which you want to set the relationship!');
			return false;
		}
		if(!Rtab_hnmS){
			alert(' Please select a table of relations!');
			return false;
		}
		var fld1e = document.kapp_Relation_Form.pg_tab_column.value;
		if( !fld1e ) {
			alert(' Please select a column in the program table!');
			return false; 
		}
		var fld2e = document.kapp_Relation_Form.re_tab_column.value;
		if( !fld2e  ) {
			alert(' Please select a column in the relational table!');
			return false; 
		}
		var t3 = document.kapp_Relation_Form.sellist_calc.value;
		if( !t3 ) {
			alert(' Please select a relationship!');
			return false; 
		}
		fld1ex = fld1e.split(":"); 
		var fld1h = fld1ex[1];  
		fld2ex = fld2e.split(":");	 
		var fld2h = fld2ex[1];  
		if( fld1ex[2] == fld2ex[2] ){ //2:data type, 3:data length, = rj[1]+':'+ rj[2] + ':'+ rj[3]+ ':' + rj[4];
		} else {
			if( fld1ex[2]!='TIMESTAMP' && fld1ex[2]!='DATETIME' && fld2ex[2] !='DATE' && fld2ex[2] !='YEAR') {
				alert("The data types are not the same." + ", pg type: "+fld1ex[2]+", relation type:"+ fld2ex[2]);
				return false;
			}
		}
		r_tab = Rtab_hnmS.split(":");
		relation_data = document.kapp_Relation_Form.relation_data.value;
		nmxh = document.kapp_Relation_Form.nmxh.value;
		document.kapp_Relation_Form.nmxh.value = nmxh + fld1h + calc_val + fld2h + " , ";
		nmx2 = document.kapp_Relation_Form.relation_move_data.value;
		var calc_val = t3; 
		document.kapp_Relation_Form.relation_move_data.value =  nmx2 + fld1h + calc_val + fld2h + " , ";	
		document.kapp_Relation_Form.relation_data.value = relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		relation_num = document.getElementById('relation_num').value;
		Rdata = Rtab_hnmS + relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		document.getElementById('relation_data_old_['+relation_num+']').value = Rdata; 
		return;
	}
	function Relation_Num_Delete(){
		var relation_num = document.getElementById('relation_num').value;
		resp = confirm(' Do you want to delete relation '+relation_num +' ?');
		if( !resp ) { 
			return false;
		} else {
			document.getElementById('relation_data_old_['+relation_num+']').value = ''; 
			document.getElementById('relation_key_old_['+relation_num+']').value = ''; 
		}
	}
	function change_relation_num_func(pg) {
		dt = document.getElementById('relation_key_old_['+pg+']').value; 
		dd = document.getElementById('relation_data_old_['+pg+']').value;
		if( dd !=''){
			document.getElementById('relation_data').value = dd;
			document.getElementById('relation_key').value = dt;
		} else {
				pgA = Number(pg) + 1;
				resp = confirm(' Do you want to relation number: '+pgA +' ?');
				if( !resp ) { 
					return false;
				}
				here_relation.innerHTML='';
				return false
		}
		if( dt !=''){
			document.getElementById('relation_key').value= dt;
			document.getElementById('relation_key_column').value = dt;
			R_Key_A = dt.split('|');
			key_cnt = R_Key_A.length;
			R_k = R_Key_A[0].split(':');
			if( R_k[0] == 'Insert' ) {
				document.getElementById('relation_type_SQL[0]').checked=true;
				document.getElementById('relation_type_SQL[1]').checked=false;
				document.getElementById("type_SQL[0]").style.backgroundColor = "cyan";
				document.getElementById('type_SQL[1]').style.backgroundColor = 'white';
			} else if( R_k[0] == 'Update' ) {
				document.getElementById('relation_type_SQL[1]').checked=true;
				document.getElementById('relation_type_SQL[0]').checked=false;
				document.getElementById("type_SQL[0]").style.backgroundColor = "white";
				document.getElementById('type_SQL[1]').style.backgroundColor = 'cyan';
			} else {
				document.getElementById('relation_type_SQL[1]').checked=false;
				document.getElementById('relation_type_SQL[0]').checked=false;
				document.getElementById("type_SQL[0]").style.backgroundColor = "white";
				document.getElementById('type_SQL[1]').style.backgroundColor = 'white';
			}
		}
		var selectIndex = document.kapp_Relation_Form.Rtab_hnmS.selectedIndex;
		if( dd !=''){
			Rdata = dd.split('$');
			dataT = Rdata[0].split(':');
			tabenm = dataT[0];
			tabhnm = dataT[1];
			document.kapp_Relation_Form.Rtab_hnmS[selectIndex].value = tabenm+':'+tabhnm;
			document.kapp_Relation_Form.Rtab_hnmS[selectIndex].text = tabhnm;
			document.getElementById('all_save_button').style.visibility = 'hidden';
		} else {
			document.getElementById('Rtab_hnmS').value = '';
			document.getElementById('re_tab_column').value = '';
		}
		relation_move_data= r_func( dd, dt );
		document.kapp_Relation_Form.relation_move_data.value = relation_move_data;
		pg_relation( dd, dt );
		return;
	}
	function r_func(relation_column, keyf){
		rk = keyf.split('|'); // keyf=Update:fld_1:일자:DATE:10|:fld_2:상품:VARCHAR:15|
		key_count = rk.length;
		
		rdata = relation_column.split('$'); 
		len = rdata.length;
		rd0 = rdata[0];
		tcol =rd0.split(':');
		rtab =tcol[2].split('@');
		rlen = rtab.length;
		ss="";
		relation_move_data ="";
		here_relation.innerHTML=ss;
				ck = "";
		for( j=0; rtab[j]!='' && j<=rlen; j++){ // relation table column |fld_1|날짜|DATE|15
			rj = rtab[j].split('|');
			ck = "";
			for( i=1; i<len; i++){        // relation column
				rr = rdata[i].split('|'); //$fld_7:날짜|=|fld_1:날짜:DATE
				pg = rr[0];               // program field
				pgnm = pg.split(':');
				pg_enm = pgnm[0];
				pg_hnm = pgnm[1];
				sk = rr[1];          // sik
				col = rr[2];         // $fld_6:수량|+|fld_3:수량:INT:12 
				reA = rr[2];         // relation table field
				fn = reA.split(':'); //alert("reA: " + reA); //reA: fld_5:product:VARCHAR
				re_enm = fn[0];
				re_hnm = fn[1];
				re_typ = fn[2];
				re_len = fn[3];

				st = " style='background-color:white;' ";
				tt = rtab[j];
				if( rj[1] == re_enm ){
					st = " style='background-color:cyan;' ";
					tt = rdata[i];
					key_yn = key_col_func( keyf, re_enm);
					if( key_yn == 'yes' ) {
						st = " style='background-color:blue;' ";
						ck = " checked ";
						tt = " key " + tt;
					} 
					relation_move_data = relation_move_data + pg_hnm + sk + re_hnm + ',';
					break;
				} else {
					//col = rj[1] + ':'+ rj[2];
					col = rj[1] + ':'+ rj[2] + ':'+ rj[3]+ ':'+ rj[4]; // 3=data type, 4=length
					st = " style='background-color:white;' ";
					tt = rtab[j];
					ck = "";
				}
			}//for
				ss+="<label " +st+ " title='"+ col +"'><input type='radio' "+ck+" id='re_tab_column' name='re_tab_column' onclick='re_col_func(this.value)' title='"+ col+"' value='"+ col+"'>"+rj[2]+"</label><br>";
		}//for
		here_relation.innerHTML=ss;
		return relation_move_data; //document.kapp_Relation_Form.relation_move_data.value = relation_move_data;
	} 
	function key_col_func(keyf, re_enm){
		chk = '';
		rk = keyf.split('|'); // dt keyf: Update:fld_1:날짜:DATE|:fld_5:product:VARCHAR|
		key_count = rk.length;
		for( i=0; i<key_count && rk[i]!=''; i++){
			rt = rk[i].split(':');
			if( rt[1] == re_enm ){
				chk = 'yes';
				break;
			}
		}
		return chk;
	}
	function pg_relation(relation_column, keyf) {
		rt = keyf.split(':'); //Update:fld_1:fld_1:CHAR
		rdata = relation_column.split('$');
		len = rdata.length;
		rd0 =rdata[0];
		tcol =rd0.split(':');
		rtab =tcol[2].split('@');
		rlen = rtab.length;
		relation_PGdata = document.kapp_Relation_Form.relation_pg_codeS.value;
		pgD=relation_PGdata.split('!');
		itemA = pgD[3];
		prel =itemA.split('@');
		plen = prel.length;
		ss="";
		here_pgcolumn.innerHTML=ss;
		for( j=0; prel[j]!='' && j<=plen; j++){ 
			rj = prel[j].split('|'); //|fld_1|fld1|VARCHAR|15
				ck = "";
			for( i=1; i<len; i++){
				rr = rdata[i].split('|');
				pg = rr[0]; // program field
				pgnm = pg.split(':');
				pg_enm = pgnm[0];
				pg_hnm = pgnm[1];
				sk = rr[1]; // sik
				re = rr[2]; // relation table field
				fn = re.split(':');
				re_enm = fn[0];
				re_hnm = fn[1];
				re_typ = fn[2];
				re_len = fn[3];
				if( rj[1] == pg_enm ){
					st = " style='background-color:cyan;' ";
					tt = rdata[i];
					if( rt[1] == pg_enm) {
						ck = " checked ";
						tt = " key " + tt;
					} 
					pre = rj[1] + ':'+ rj[2] + ':'+ rj[3]+ ':' + rj[4]; // 3=data type, 4=data length add
					pre_hnm = rj[2];
					break;
				} else {
					st = " style='background-color:white;' ";
					pre_hnm = rj[2];
					pre = rj[1] + ':'+ rj[2] + ':'+ rj[3]+ ':' + rj[4]; // 3=data type, 4=data length add
					tt = prel[j];
				}

			}
			ss+= "<label " +st+ " title='"+ tt +"'><input type='radio' "+ck+" id='pg_tab_column' name='pg_tab_column' title='"+ pre+"' value='"+ pre+"'>"+pre_hnm+"</label><br>";
		}
		here_pgcolumn.innerHTML=ss;

	}
	function change_project_func(pnmS){
		if( pnmS == '') {
			alert('Select Project!');
			return false;
		}
		document.getElementById('mode').value = 'Project_Search';
		document.getElementById('relation_num').value = '0';
		document.kapp_Relation_Form.action="./kapp_table_relation10.php";
		document.kapp_Relation_Form.submit();	//location.replace(location.href);
	}
	function change_program_func(pcdS){
		if( pcdS == '') {
			alert('Select Program!');
			return false;
		}
		pgS = pcdS.split("!");
		pgcodeS = pgS[0].split(":");
		document.getElementById('pg_code').value = pgcodeS[0];
		document.getElementById('pg_name').value = pgcodeS[1];
		document.getElementById('tab_enm').value = pgcodeS[2];
		document.getElementById('tab_hnm').value = pgcodeS[3];
		document.getElementById('mode').value = 'pg_codeS_Search';
		document.getElementById('relation_num').value = '0';
		document.kapp_Relation_Form.action="./kapp_table_relation10.php";
		document.kapp_Relation_Form.submit();
		//location.replace(location.href);
	}
	function Change_Relation_Table_func(ptbS){
		relation_reset = document.getElementById('relation_reset').value;
		no = document.getElementById('relation_num').value;
		if( ptbS == '') {
			alert('Select Relation Table!');
			return false;
		}
		//tb = ptbS.split(':');
		document.getElementById('mode').value = 'Relation_SearchTAB';
		document.kapp_Relation_Form.action="./kapp_table_relation10.php";
		document.kapp_Relation_Form.submit();
	}
	function re_col_func(val){
		//alert('val: '+ val); //val: fld_5:product:VARCHAR
	}
	//---------- relation reset : kapp_table_relation_Change10 -----------
	/*function Xreset_confirm(){
		var relation_num = document.getElementById('relation_num').value;
		resp = confirm(' Would you like to reset relationship data removable? reset relation no: ' + relation_num);
		if( !resp ) return false;
		else {
			document.kapp_Relation_resetForm.mode.value='Reset_Check';
			document.kapp_Relation_resetForm.relation_reset.value='on';
			document.kapp_Relation_resetForm.relation_move_data.value='';
			document.kapp_Relation_resetForm.relation_data.value='';
			document.kapp_Relation_resetForm.relation_key.value='';
			document.kapp_Relation_resetForm.action="./kapp_table_relation_Change10.php";
			document.kapp_Relation_resetForm.submit();
		}
		return;
	}*/
	function delete_confirmX(){
		resp = confirm(' Would you like to Delete relationship data removable?');
		if( !resp ) return false;
		else {
			document.kapp_Relation_resetForm.mode.value='Delete_Check';
			document.kapp_Relation_resetForm.relation_reset.value='';
			document.kapp_Relation_resetForm.relation_move_data.value='';
			document.kapp_Relation_resetForm.relation_data.value='';
			document.kapp_Relation_resetForm.action="./kapp_table_relation_Change10.php";
			document.kapp_Relation_resetForm.submit();
		}
		return;
	}
	function relation_back_func(){
		document.kapp_Relation_resetForm.mode.value="";
		document.kapp_Relation_resetForm.relation_reset.value = '';
		document.kapp_Relation_resetForm.action="./kapp_table_relation10.php";
		document.kapp_Relation_resetForm.submit();
	}
	function relation_Cancel_func(relation_num){
		resp = confirm(' Do you want to Cancel relation - '+relation_num +' ?');
		if( !resp ) return false;
		document.kapp_Relation_resetForm.mode.value="";
		document.kapp_Relation_resetForm.relation_reset.value = '';
		document.kapp_Relation_resetForm.action="./kapp_table_relation10.php";
		document.kapp_Relation_resetForm.submit();
	}
	function relation_save_ALL_resetfunc(relation_num) {
		if( document.kapp_Relation_resetForm.relation_type_SQL[0] === false && document.kapp_Relation_resetForm.relation_type_SQL[1] === false){
			alert(" The relation is Update. Please select a key field and click the 'SQL Save' button to save it! ");
			return false;
		}
		if( document.kapp_Relation_resetForm.relation_move_data.value ==''){ 
			alert(" After setting the relational expression, click the 'save' button!");
			return false; 
		}
		if( document.kapp_Relation_resetForm.relation_key_column.value ==''){ 
			alert(" After setting the relational key column expression, click the 'save' button!");
			return false; 
		}
		key_col = document.kapp_Relation_resetForm.relation_key_column.value;
		var colnm = document.getElementsByName('re_key_col'); 
		var k_cnt = colnm.length;
		colnm_value = document.getElementById('relation_key_column').value + ":";
		$k_check = 0;
		for( i=0; i<k_cnt; i++){
			if( document.getElementById('re_key_col'+i).checked === true ){
				if( i ==0 ) colnm_value =  colnm_value + colnm[i].value + "|";
				else if( i > 0 ) colnm_value =  colnm_value + ":" + colnm[i].value + "|";
				$k_check++;
			}
		}
		if( $k_check == 0 ){
			alert("key column no clicked"); return false;
		}
		document.getElementById('relation_key').value= colnm_value;
		document.getElementById('relation_key_column').value = colnm_value;
		document.getElementById('relation_key_old_['+relation_num+']').value = colnm_value;
		resp = confirm(' Do you want to Save relation - '+relation_num +' ?');
		if( !resp ) return false;
		document.kapp_Relation_resetForm.modeRun.value="table_relation_save_Change";
		document.kapp_Relation_resetForm.action="./kapp_table_relation_Change10.php";
		document.kapp_Relation_resetForm.submit();
	}
	function Xcreate_after_runX(relation_pg_codeS, Rtab_hnmS){
		document.kapp_Relation_resetForm.mode.value='Save_OK';
		document.kapp_Relation_resetForm.target		='_self';
		document.kapp_Relation_resetForm.action		="./kapp_table_relation_Change10.php";
		document.kapp_Relation_resetForm.submit();
	}

	function relation_move_Reset(){
		var relation_pg_codeS = document.getElementById('relation_pg_codeS').value;
		var Rtab_hnmS = document.getElementById('Rtab_hnmS').value;
		var pg_name = document.getElementById('pg_name').value;
		var tab_hnm = document.getElementById('tab_hnm').value;
		if(!relation_pg_codeS){
			alert(' Select the program for which you want to set the relationship!');
			return false;
		}
		if(!Rtab_hnmS){
			alert(' Please select a table of relations!');
			return false;
		}
		var fld1e = document.kapp_Relation_resetForm.pg_tab_column.value;
		if( !fld1e ) {
			alert(' Please select a column in the program table!');
			return false; 
		}
		var fld2e = document.kapp_Relation_resetForm.re_tab_column.value;
		if( !fld2e  ) {
			alert(' Please select a column in the relational table!');
			return false; 
		}
		var t3 = document.kapp_Relation_resetForm.sellist_calc.value;
		if( !t3 ) {
			alert(' Please select a relationship!');
			return false; 
		}
		fld1ex = fld1e.split(":"); 
		var fld1h = fld1ex[1];
		fld2ex = fld2e.split(":");	 
		var fld2h = fld2ex[1];
		if( fld1ex[2] == fld2ex[2] ){ //2:data type, 3:data length, = rj[1]+':'+ rj[2] + ':'+ rj[3]+ ':' + rj[4];
		} else {
			if( fld1ex[2]!='TIMESTAMP' && fld1ex[2]!='DATETIME' && fld2ex[2] !='DATE' && fld2ex[2] !='YEAR') {
				alert("The data types are not the same." + ", pg type: "+fld1ex[2]+", relation type:"+ fld2ex[2]);
				return false;
			}
		}
		r_tab = Rtab_hnmS.split(":");
		relation_data = document.kapp_Relation_resetForm.relation_data.value;
		nmxh = document.kapp_Relation_resetForm.nmxh.value;
		document.kapp_Relation_resetForm.nmxh.value = nmxh + fld1h + calc_val + fld2h + " , ";
		nmx2 = document.kapp_Relation_resetForm.relation_move_data.value;
		var calc_val = t3;
		document.kapp_Relation_resetForm.relation_move_data.value =  nmx2 + fld1h + calc_val + fld2h + " , ";	
		document.kapp_Relation_resetForm.relation_data.value = relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		relation_num = document.getElementById('relation_num').value;
		Rdata = Rtab_hnmS + relation_data + "$" + fld1e + "|" + calc_val + "|" + fld2e;
		document.getElementById('relation_data_old_['+relation_num+']').value = Rdata; 
		return;
	}
	function Change_Relation_Table_resetfunc(ptbS){ // Relation_Table_func
		no = document.getElementById('relation_num').value;
		if( ptbS == '') {
			alert('Select Relation Table!');
			return false;
		}
		tb = ptbS.split(':');
		document.getElementById('modeRun').value = 'Relation_SearchTAB';
		document.kapp_Relation_resetForm.action="./kapp_table_relation_Change10.php";
		document.kapp_Relation_resetForm.submit();
	}
	function relation_sql_typeReset( pg, val){
		dd = document.getElementById('relation_data_old_['+pg+']').value;
		if( dd==''){
			alert("Please set up the removable data first! type: "+val);//data 이동식을 먼저 설정 하세요! 
			document.kapp_Relation_resetForm.relation_type_SQL[0].checked = false;
			document.kapp_Relation_resetForm.relation_type_SQL[1].checked = false
			return;
		}
		sql_v = val+':::@@'; 
		document.getElementById('relation_key_column').value= val;
		Rtab_col = document.getElementById('Rtab_col').value; 	
		RTcol = Rtab_col.split('|');
		rdata = dd.split('$');
		st = " style='background-color:cyan;' ";
		ss='';
		k=0;
		for( i=0; RTcol[i] !='' && i<RTcol.length; i++){
			RTcol_i = RTcol[i];
			rr_fld = RTcol_i.split(':');
			re_enm = rr_fld[0]; // enm
			re_hnm = rr_fld[1]; // hnm
			re_yp  = rr_fld[2]; // type
			ck = '';
			for( j=1; rdata[j] !='' && j<rdata.length; j++){
				rr = rdata[j].split('|');
				pg = rr[0]; // program field
				sk = rr[1]; // sik
				RF = rr[2]; // relation table field
				fn = RF.split(':');
				Renm = fn[0];
				Rhnm = fn[1];
				Rtyp = fn[2];
				Rlen = fn[3];
				Kval = Renm+":"+Rhnm+":"+Rtyp+":"+Rlen;
				if( Renm == re_enm) {
					tt = "Renm:" + Renm+", Rhnm:" + Rhnm+", Rtyp:" + Rtyp+", Rlen:" + Rlen;
					ss+="<label " +st+ " title='"+ tt +"'><input type='checkbox' "+ck+" id='re_key_col"+k+"' name='re_key_col' title='"+ tt+"' value='"+ Kval+"'>"+Rhnm+"</label><br>";
					k++;
				}
			}
		}
		here_relation.innerHTML = ss;
		alert("Now, set the key column!");
	}
	function close_func(){
		windows.close();
	}
	function Breturn_func(){
		document.kapp_Relation_resetForm.relation_reset.value = '';
		document.kapp_Relation_resetForm.mode.value='';	
		document.kapp_Relation_resetForm.action ="./kapp_table_relation10.php";
		document.kapp_Relation_resetForm.target='_self';
		document.kapp_Relation_resetForm.submit();
	}
	/*
	function sendDataToPHP( projectnmS, pnmdataS ) {
		fetch('<?=KAPP_URL_T_?>/kapp_save_session.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ projectnmS: projectnmS, pnmdataS: pnmdataS }),
		})
		.then(response => response.json())
		.then(data => {
			console.log('Success:', data);
		})
		.catch((error) => {
			console.error('Error:', error);
		});
	}*/
