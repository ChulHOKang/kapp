<?php
	include_once('../tkher_start_necessary.php');
	/*
	  point_list_adm.php : point 지급 내역.
	  call : admin menu : t/adm/
	*/
	$H_ID		= get_session("ss_mb_id");
	if( $H_ID == '') {
		m_("login please");
		exit;
	}
	$H_LEV		= $member['mb_level'];
	if( $H_LEV < 8) {
		m_("admin page");
		exit;
	}
	connect_count($host_script, $H_ID, 0, $referer);

	if( isset($_POST['mode']) ) $mode = $_POST['mode'];
	else $mode = '';
	if( isset($_POST['sdata']) ) $sdata = $_POST['sdata'];
	else if( isset($_REQUEST['sdata']) ) $sdata = $_REQUEST['sdata'];
	else $sdata = '';
	if( isset($_POST['scolumn']) ) $scolumn = $_POST['scolumn'];
	else if( isset($_REQUEST['scolumn']) ) $scolumn = $_REQUEST['scolumn'];
	else $scolumn = '';
	if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else $page = 1;
	$sql_ = " from {$tkher['point_table']} ";
	$search_ = " where (1) ";
	if( $sdata) {
		$search_ .= " and ( ";
		switch ($scolumn) {
			case 'mb_id' :
				$search_ .= " ({$scolumn} = '{$sdata}') ";
				break;
			default :
				$search_ .= " ({$scolumn} like '%{$sdata}%') ";
				break;
		}
		$search_ .= " ) ";
	}
	if( !$sst) {
		$sst  = "po_id";
		$sod = "desc";
	}
	$order_ = " order by {$sst} {$sod} ";
	$sql = " select count(*) as cnt {$sql_} {$search_} {$order_} ";
	$row = sql_fetch( $sql);
	if( isset($config['kapp_page_rows'])) $rows = $config['kapp_page_rows'];
	else $rows = 10;
	if( isset($row['cnt']) ) {
		$total_count = $row['cnt'];
		$total_page  = ceil($total_count / $rows);
		$record_start = ($page - 1) * $rows;
	} else {
		$total_count = 0;
		$total_page  = 1;
		$record_start = 0;
	}
	$sql = " select * {$sql_} {$search_} {$order_} limit {$record_start}, {$rows} ";
	$result = sql_query( $sql); 
	$mb = array();
	if( $scolumn == 'mb_id' && $sdata) $mb = get_member($sdata);
	$colspan = 9;
	$po_expire_term = '';
	if( $config['kapp_point_term'] > 0) {
		$po_expire_term = $config['kapp_point_term'];
	}
	if( strstr($scolumn, "mb_id"))
		$mb_id = $sdata;
	else
		$mb_id = "";
?>
<script src="//code.jquery.com/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=KAPP_URL_T_?>/include/css/dddropdownpanel.css" />
<script type="text/javascript" src="<?=KAPP_URL_T_?>/include/js/dddropdownpanel.js"></script>

<script type="text/javascript" >
	function search_func(){
		data = document.fsearch.sdata.value;
		document.fsearch.mode.value	="Search";
		document.fsearch.action="point_list_adm.php";
		document.fsearch.submit();
	}
	function Submit_func(){
		if( document.admpointlistA.mb_id.value == '' ) {
			alert("id confirm!");	return false;
		}
		if( document.admpointlistA.po_content.value == '' ) {
			alert("message confirm!");	return false;
		}
		if( document.admpointlistA.po_point.value == '' ) {
			alert("point count confirm!");	return false;
		}

	jQuery(document).ready(function ($) {
			var yn = window.confirm("Do you want to pay point : " + $("#po_point").val());
			if ( yn ){
				var $mb_id = $("#mb_id").val();
				var $po_content= $("#po_content").val();		
				var $po_point= $("#po_point").val();		
				$.ajax({
					header:{"Content-Type":"application/json"},
					method: "post",
						url: 'kapp_admin_point_ajax.php',
						data: {
							"mode_insert": 'Point_Admin_Pay',
							"mb_id": $mb_id,
							"po_content": $po_content,
							"po_point": $po_point
						},
					success: function(data) {
							//	$("#po_content").val(data);
							//console.log(data);
							alert( "OK, data: " + data);
							location.replace(location.href);
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert("데이터 타입, 또는 URL이 올바르지 않습니다.-- kapp_project_ajax.php");
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						return;
					}
				});
			}
	});
}
</script>

<body style="background-color:black;color:white;">
<center>

<form name="admpointlistA" method="post" id="admpointlistA" action="./point_update_adm.php" autocomplete="off">
			<input type="hidden" name="sdata"   value="<?=$sdata?>" >
			<input type="hidden" name="scolumn" value="<?=$scolumn?>" >
			<input type="hidden" name="page"    value="<?=$page?>" >
			<input type="hidden" name="token"   value="<?=$token?>" >
	<div id="mypanel" class="ddpanel">
		<div id="mypanelcontent" class="ddpanelcontent">
			<table>
				<tr>
					<th scope="row"><label for="mb_id">id</label></th>
					<td><input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" class="required frm_input" required></td>
				</tr>
				<tr>
					<th scope="row"><label for="po_content">message</label></th>
					<td><input type="text" name="po_content" id="po_content" required class="required frm_input" size="80"></td>
				</tr>
				<tr>
					<th scope="row"><label for="po_point">point</label></th>
					<td><input type="text" name="po_point" id="po_point" required class="required frm_input"></td>
				</tr>
			</table>
			<div><input type="button" value="Confirm" onclick="javascript:Submit_func()"></div>
		</div>
		<div id="mypaneltab" class="ddpaneltab" ><span style="background-color:;color:yellow;"><a href="#" style='height:25px;color:yellow;font-size:21px;'>&nbsp; &#9776; Admin Point Pay &nbsp;▼ &nbsp;</a></span></div>
	</div>
</form>

<center>
<form name="fsearch" id="fsearch" method="post">
	<input type="hidden" name="mode"  value="">
	<label for="scolumn" class="sound_only">Target</label>
	<select name="scolumn" id="scolumn">
		<option value="mb_id" <?php if($scolumn=='mb_id') echo " selected ";?> >id</option>
		<option value="po_content"<?php  if($scolumn=='po_content') echo " selected ";?> >Point msg</option>
	</select>
	<label for="sdata" class="sound_only">word</label>
	<input type="text" name="sdata" value="<?php echo $sdata ?>" id="sdata" required class="required frm_input">
	<input type="button" onclick="javascript:search_func();" value="Search">
</form>
<form name="admpointlist" id="admpointlist" method="post" action="./point_list_delete.php" onsubmit="return delfunc_submit(this);">
	<input type="hidden" name="sst"     value="<?php echo $sst ?>">
	<input type="hidden" name="sod"     value="<?php echo $sod ?>">
	<input type="hidden" name="scolumn" value="<?php echo $scolumn ?>">
	<input type="hidden" name="sdata"   value="<?php echo $sdata ?>">
	<input type="hidden" name="page"    value="<?php echo $page ?>">
	<input type="hidden" name="token"   value="">

<div>
    <table>
    <caption>Point history (Total Count : <?php echo number_format($total_count) ?>
    <?php
    if (isset($mb['mb_id']) && $mb['mb_id']) {
        echo '&nbsp;(' . $mb['mb_id'] .' Total Point : ' . number_format($mb['mb_point']) . ')';
    } else {
        $row2 = sql_fetch(" select sum(po_point) as sum_point from {$tkher['point_table']} ");
        echo '&nbsp;, Total Point : '.number_format($row2['sum_point']);
    }
    ?>)
	</caption>

    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">no</label>
        </th>
        <th scope="col">id</a></th>
        <th scope="col" style='width:200px'>title</th>
        <th scope="col" style='width:300px'>point msg</a></th>
        <th scope="col" title='get Point'>Get</th>
        <th scope="col" title='Total Point'>tot Point</th>
        <th scope="col">date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for( $i=0, $j=1; $row=sql_fetch_array($result); $i++, $j++) {
        if ($i==0 || ( $row2['mb_id'] != $row['mb_id'])) {
            $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$tkher['tkher_member_table']} where mb_id = '{$row['mb_id']}' ";
            $row2 = sql_fetch($sql2);
        }
        $link1 = $link2 = '';
        if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {
			if( strpos( $row['po_content'], "contents_view_menuD.php") !== false) {
				if( strpos( $row['po_content'], "https://") !== false) {
					$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
					$link2 = '</a>';
				} else {
					$link1 = '<a href="' . KAPP_URL_T_ . '/menu/'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
					$link2 = '</a>';
				}
			} else {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
				$link2 = '</a>';
			}
        } else {
			if( strpos( $row['po_content'], "https://") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "http://") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "contents_view.php") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "_r1.htm") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "tkher_program_data_list.php") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'" style="background-color:black;color:yellow;">';
				$link2 = '</a>';
			}
		}
        $expr = '';
        if( $row['po_expired'] == 1)
            $expr = ' txt_expired';
        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>"  style="background-color:black;color:yellow;">
        <td class="td_chk"  style="background-color:black;color:yellow;">
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
            <input type="hidden" name="po_id[<?php echo $i ?>]" value="<?php echo $row['po_id'] ?>" id="po_id_<?php echo $i ?>">
			<label for="chk_<?php echo $i; ?>" ><?php echo $j ?></label>
        </td>
        <td style="background-color:black;color:white;"><a href="?scolumn=mb_id&amp;sdata=<?php echo $row['mb_id'] ?>" style="background-color:black;color:white;"><?php echo $row['mb_id'] ?></a></td>
        <td style="background-color:black;color:yellow;"><?php echo $row['po_title'] ?></td>
        <td style="background-color:black;color:yellow;"><?php echo $link1 ?><?php echo $row['po_content'] ?><?php echo $link2 ?></td>
        <td style="background-color:black;color:white;"><?php echo number_format($row['po_point']) ?></td>
        <td style="background-color:black;color:white;" align='right'><?php echo number_format($row['po_mb_point']) ?></td>
        <td style="background-color:black;color:yellow;"><?php echo $row['po_datetime'] ?></td>
</tr>
<?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">no found.</td></tr>';
?>
    </tbody>
    </table>
</div>

<!-- <div><input type="submit" name="act_button" value="delete" onclick="document.pressed=this.value"></div> -->

</form>
<center>
<?php
$Stm = "sdata=" . $sdata . "&scolumn=". $scolumn ;
$ss = "{$_SERVER['SCRIPT_NAME']}?" . $Stm . "&amp;page=";
echo page_dis( $p=10, $page, $total_page, $ss);
?>

<?php
function page_dis($write_pages, $cur_page, $total_page, $url)
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<a href="'.$url.'1'.'" style="background-color:black;color:white;">[First]</a>'.PHP_EOL;
    }
    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<a href="'.$url.($start_page-1).'" style="background-color:black;color:white;">Prev</a>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<a href="'.$url.$k.'" class="page" style="background-color:black;color:white;font-size:25px;" title="'.$url.'">['.$k.']</a>'.PHP_EOL;
            else
                $str .= '<span class=""></span><strong class="" style="background-color:black;color:white;">'.$k.'</strong>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<a href="'.$url.($end_page+1).'" style="background-color:black;color:white;">Next</a>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<a href="'.$url.$total_page.'" style="background-color:black;color:white;" title="'.$url.'">[Last]</a>'.PHP_EOL;
    }

    if ($str)
        return "<nav class=''><span class=''>{$str}</span></nav>";
    else
        return "";
}
?>
