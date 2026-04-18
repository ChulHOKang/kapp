	function column_modify_mode_func( no,  table_yn, colunm_cnt ) {
		fld_hnm = document.kapp_table_Form["fld_hnm[" + no + "]"].value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');
			return false;
		}
		for( var k=1; k < colunm_cnt; k++ ){
				knm = document.kapp_table_Form["fld_hnm[" + k + "]"].value;
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
			document.kapp_table_Form.add_column_hnm.value = document.kapp_table_Form["fld_hnm[" + no + "]"].value;
			document.kapp_table_Form.add_column_enm.value = document.kapp_table_Form["fld_enm[" + no + "]"].value;
			document.kapp_table_Form.add_column_type.value = document.kapp_table_Form["fld_type[" + no + "]"].value;
			document.kapp_table_Form.add_column_len.value = document.kapp_table_Form["fld_len[" + no + "]"].value;
			document.kapp_table_Form.add_column_memo.value = document.kapp_table_Form["memo[" + no + "]"].value;
			document.kapp_table_Form.del_seqno.value = document.kapp_table_Form["seqno[" + no + "]"].value;
			document.kapp_table_Form.action					="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
		}
	}
	function column_add_mode_func( no,  table_yn, column_cnt) {
		if( document.kapp_table_Form["fld_enm[" + no + "]"].value == '' ) {
			alert(" Define columns! "); 
			document.kapp_table_Form["fld_enm[" + no + "]"].focus();
			return false;
		} else if ( document.kapp_table_Form["fld_hnm[" + no + "]"].value == ''){
			alert(" Define column name!");
			document.kapp_table_Form["fld_hnm[" + no + "]"].focus();
			return false;
		} else if ( document.kapp_table_Form["fld_len[" + no + "]"].value == ''){
			alert(" Define the column length!");
			document.kapp_table_Form["fld_len[" + no + "]"].focus();
			return false;
		}
		fld_hnm = document.kapp_table_Form["fld_hnm[" + no + "]"].value;
		if( fld_hnm == 'seqno'){
			alert(' Can not use column name seqno.');
			return false;
		}
		msg = " Add " + fld_hnm + " entry? ";
		if ( window.confirm( msg ) ){
			document.kapp_table_Form.del_mode.value		="column_add_mode";
			document.kapp_table_Form.mode.value			="SearchTAB";
			document.kapp_table_Form.table_yn.value = table_yn;
			document.kapp_table_Form.add_column_hnm.value = document.kapp_table_Form["fld_hnm[" + no + "]"].value;
			document.kapp_table_Form.add_column_enm.value = document.kapp_table_Form["fld_enm[" + no + "]"].value;
			document.kapp_table_Form.add_column_type.value = document.kapp_table_Form["fld_type[" + no + "]"].value;
			document.kapp_table_Form.add_column_len.value = document.kapp_table_Form["fld_len[" + no + "]"].value;
			document.kapp_table_Form.add_column_memo.value = document.kapp_table_Form["memo[" + no + "]"].value;
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
			document.kapp_table_Form["fld_type[0]"].value = 'INT';
			return false;
		}
		if( document.kapp_table_Form["fld_type["+i+"]"].value == "INT") document.kapp_table_Form["fld_len["+i+"]"].value = '12';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TINYINT")   document.kapp_table_Form["fld_len["+i+"]"].value = '3';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "SMALLINT")  document.kapp_table_Form["fld_len["+i+"]"].value = '5';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "MEDIUMINT") document.kapp_table_Form["fld_len["+i+"]"].value = '8';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "BIGINT")    document.kapp_table_Form["fld_len["+i+"]"].value = '15';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DECIMAL")   document.kapp_table_Form["fld_len["+i+"]"].value = '6';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "FLOAT")     document.kapp_table_Form["fld_len["+i+"]"].value = '8.3';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DOUBLE")    document.kapp_table_Form["fld_len["+i+"]"].value = '12.3';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "CHAR")      document.kapp_table_Form["fld_len["+i+"]"].value = '5';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "VARCHAR")   document.kapp_table_Form["fld_len["+i+"]"].value = '15';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TEXT")      document.kapp_table_Form["fld_len["+i+"]"].value = '255';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "LONGBLOB")  document.kapp_table_Form["fld_len["+i+"]"].value = '255';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "BLOB")  document.kapp_table_Form["fld_len["+i+"]"].value = '255';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DATE")      document.kapp_table_Form["fld_len["+i+"]"].value = '10';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "DATETIME")  document.kapp_table_Form["fld_len["+i+"]"].value = '19';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TIMESTAMP")  document.kapp_table_Form["fld_len["+i+"]"].value = '19';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "TIME")      document.kapp_table_Form["fld_len["+i+"]"].value = '8';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "YEAR")      document.kapp_table_Form["fld_len["+i+"]"].value = '4';
		else if( document.kapp_table_Form["fld_type["+i+"]"].value == "MONTH")     document.kapp_table_Form["fld_len["+i+"]"].value = '7';
	}
	function line_set_func(cnt) { // 2026-03-19 hh:ii:ss
			document.kapp_table_Form.mode.value='line_set';
			document.kapp_table_Form.line_set.value=cnt;
			document.kapp_table_Form.action="kapp_table30m_A.php";
			document.kapp_table_Form.submit();
	}
	function sendCon(form){
		f_nm = document.kapp_table_Form["fld_enm[0]"].value;
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
			len = document.kapp_table_Form["fld_len[" + i + "]"].value;
			fnm = document.kapp_table_Form["fld_hnm[" + i + "]"].value;
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
			len = document.kapp_table_Form["fld_len[" + i + "]"].value;
			fnm = document.kapp_table_Form["fld_hnm[" + i + "]"].value;
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
	function ref_func( no ) {
		document.kapp_table_Form.no.value=no;
		fld_hnm = document.kapp_table_Form["fld_hnm[" + no + "]"].value;
		if( fld_hnm == "seqno"){
			alert(' Can not use column name seqno.');
			return false;
		}
		window.open('./fld_select.php?no='+no,'','width=700,height=700, toolbar=no,scrollbars=yes,resizable=no');
	}
	var	fld_enmV, fld_hnmV, fld_typeV, fld_lenV, memoV,	seqnoV, Aif_lineV, Aif_typeV, Aif_dataV, Arelation_dataV;

	function up_bakup(j){
		fld_enmV  = document.kapp_table_Form["fld_enm[" + j + "]"].value;
		fld_hnmV  = document.kapp_table_Form["fld_hnm[" + j + "]"].value;
		fld_typeV = document.kapp_table_Form["fld_type[" + j + "]"].value;
		fld_lenV  = document.kapp_table_Form["fld_len[" + j + "]"].value;
		memoV     = document.kapp_table_Form["memo[" + j + "]"].value;
		seqnoV    = document.kapp_table_Form["seqno[" + j + "]"].value;
		Aif_lineV = document.kapp_table_Form["Aif_line[" + j + "]"].value;
		Aif_typeV = document.kapp_table_Form["Aif_type[" + j + "]"].value;
		Aif_dataV = document.kapp_table_Form["Aif_data[" + j + "]"].value;
		Arelation_dataV  = document.kapp_table_Form["Arelation_data[" + j + "]"].value;
	}
    function up_move(i, j){
		document.kapp_table_Form["fld_enm[" + j + "]"].value  = document.kapp_table_Form["fld_enm[" + i + "]"].value;
		document.kapp_table_Form["fld_hnm[" + j + "]"].value  = document.kapp_table_Form["fld_hnm[" + i + "]"].value;
		document.kapp_table_Form["fld_type[" + j + "]"].value  = document.kapp_table_Form["fld_type[" + i + "]"].value;
		document.kapp_table_Form["fld_len[" + j + "]"].value  = document.kapp_table_Form["fld_len[" + i + "]"].value;
		document.kapp_table_Form["memo[" + j + "]"].value  = document.kapp_table_Form["memo[" + i + "]"].value;
		document.kapp_table_Form["seqno[" + j + "]"].value  = document.kapp_table_Form["seqno[" + i + "]"].value;
		document.kapp_table_Form["Aif_line[" + j + "]"].value  = document.kapp_table_Form["Aif_line[" + i + "]"].value;
		document.kapp_table_Form["Aif_type[" + j + "]"].value  = document.kapp_table_Form["Aif_type[" + i + "]"].value;
		document.kapp_table_Form["Aif_data[" + j + "]"].value  = document.kapp_table_Form["Aif_data[" + i + "]"].value;
		document.kapp_table_Form["Arelation_data[" + j + "]"].value  = document.kapp_table_Form["Arelation_data[" + i + "]"].value;
	}
    function up_recover(i){
		fld_enmI = document.kapp_table_Form["fld_enm[" + i + "]"].value;
		fld_hnmI = document.kapp_table_Form["fld_hnm[" + i + "]"].value;
		document.kapp_table_Form["fld_enm[" + i + "]"].value  = fld_enmV;
		document.kapp_table_Form["fld_hnm[" + i + "]"].value  = fld_hnmV;
		document.kapp_table_Form["fld_type[" + i + "]"].value = fld_typeV;
		document.kapp_table_Form["fld_len[" + i + "]"].value  = fld_lenV;
		document.kapp_table_Form["memo[" + i + "]"].value     = memoV;
		document.kapp_table_Form["seqno[" + i + "]"].value    = seqnoV;
		document.kapp_table_Form["Aif_line[" + i + "]"].value = Aif_lineV;
		document.kapp_table_Form["Aif_type[" + i + "]"].value = Aif_typeV;
		document.kapp_table_Form["Aif_data[" + i + "]"].value = Aif_dataV;
		document.kapp_table_Form["Arelation_data[" + i + "]"].value = Arelation_dataV;
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

		fld_enmV  = document.kapp_table_Form["fld_enm[" + j + "]"].value;
		fld_hnmV  = document.kapp_table_Form["fld_hnm[" + j + "]"].value;
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
