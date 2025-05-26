<?php
include_once('../tkher_start_necessary.php');
	$H_ID		= get_session("ss_mb_id");
	$H_LEV		= $member['mb_level'];

	connect_count( $host_script, $H_ID, 0, $referer);
	if( $H_LEV < 2) {
		m_("my page"); exit;
	}

	if( isset($_POST['sdata']) ) $sdata = $_POST['sdata'];
	else if( isset($_REQUEST['sdata']) ) $sdata = $_REQUEST['sdata'];
	else $sdata = '';
	if( isset($_POST['scolumn']) ) $scolumn = $_POST['scolumn'];
	else if( isset($_REQUEST['scolumn']) ) $scolumn = $_REQUEST['scolumn'];
	else $scolumn = '';

	$sql_ = " from {$tkher['point_table']} ";
	$search_ = " where mb_id='".$H_ID."' ";
	if( $sdata) {
		$search_ .= " and ( {$scolumn} like '%{$sdata}%' ) ";
	} else $search_ .= " ";
	if( !$sst) {
		$sst  = "po_id";
		$sod = "desc";
	}
	$order_ = " order by {$sst} {$sod} ";
	$sql = " select count(*) as cnt
				{$sql_}
				{$search_}
				{$order_} ";		//echo "sql: " . $sql; exit;
	$row = sql_fetch($sql);

	if( isset($row['cnt']) ) {
		$total_count = $row['cnt'];
		if( isset($config['kapp_page_rows']) ) $rows = $config['kapp_page_rows'];
		else $rows = 1;
		$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	} else {
		$total_count = 0;
		$total_page  = 1;
		$rows = 1;
	}


	if( isset($_POST["page"]) ) $page= $_POST["page"];
	else if( isset($_REQUEST['page']) ) $page = $_REQUEST['page'];
	else $page =1;

	$record_start = ($page - 1) * $rows; // 시작 열을 구함

	$sql = " select *
				{$sql_}
				{$search_}
				{$order_}
				limit {$record_start}, {$rows} ";
	$result = sql_query($sql);

	$mb = array();
	if( $scolumn == 'mb_id' && isset($sdata) ) $mb = get_member($sdata);

	$colspan = 9;

	$po_expire_term = '';
	$mb_id = "";
	if( isset($config['kapp_point_term']) ) $po_expire_term = $config['kapp_point_term'];
	if( $scolumn == "mb_id" ) $mb_id = $sdata;
?>
<link rel='StyleSheet' HREF='<?=KAPP_URL_T_?>/include/css/style_history.css' type='text/css' >

<center>
<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
	<label for="scolumn" class="sound_only">Target</label>

	<select name="scolumn" id="scolumn">
		<!-- <option value="mb_id"<?php if($scolumn=='mb_id') echo " selected ";?> >id</option> -->
		<option value="po_content"<?php  if($scolumn=='po_content') echo " selected ";?> >Point msg</option>
	</select>

	<label for="sdata" class="sound_only">word</label>
	<input type="text" name="sdata" value="<?php echo $sdata ?>" id="sdata" required class="required frm_input">
	<input type="submit" class="btn_submit" value="Search">
</form>

<form name="admpointlist" id="admpointlist" method="post" action="./point_list_delete.php" onsubmit="return delfunc_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="scolumn" value="<?php echo $scolumn ?>">
<input type="hidden" name="sdata" value="<?php echo $sdata ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div>
    <table>
    <caption>Point history (Total Count : <?php echo number_format($total_count) ?>
<?php
		$sql2 = " select sum(po_point) as sum_point from {$tkher['point_table']} where mb_id='".$H_ID."' ";
		$row2 = sql_fetch( $sql2 );

		if( isset($row2['sum_point']) ) {
			$sum_point = $row2['sum_point'];
			echo '&nbsp;[' . $H_ID .'] Total Point : ' . number_format( $sum_point ) . ')';
		} else {
			$sum_point = 0;
			echo '&nbsp;[' . $H_ID .'] Total Point : ' . number_format( $sum_point ) . ')';
		}
?>
	</caption>

    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">no</label>
        </th>
        <th scope="col">id</a></th>
        <th scope="col">name</th>
        <!-- <th scope="col">nick</th> -->
        <th scope="col" style='width:150px'>title</a></th>
        <th scope="col" style='width:300px'>point msg</a></th>
        <th scope="col" title="get point">Get</th>
        <th scope="col">tot Point</th>
        <th scope="col">date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for( $i=0, $j=1; $row=sql_fetch_array($result); $i++, $j++) {
        if( $i==0 || ($row2['mb_id'] != $row['mb_id'])) { //m_($i . ", m id:" . $row2['mb_id'] . ", p id:" . $row['mb_id']);
            $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$tkher['tkher_member_table']} where mb_id = '{$row['mb_id']}' ";
            $row2 = sql_fetch($sql2);
        }

        $link1 = $link2 = '';
        if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {

			if(strpos( $row['po_content'], "contents_view_menuD.php") !== false) {
				if( strpos( $row['po_content'], "https://") !== false) {
					$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				} else {
					$link1 = '<a href="../menu/'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				}
				$link2 = '</a>';
			} else {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				$link2 = '</a>';
			}
        } else {
			if( strpos( $row['po_content'], "https://") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "http://") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "contents_view.php") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "_r1.htm") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				$link2 = '</a>';
			} else if( strpos( $row['po_content'], "tkher_program_data_list.php") !== false) {
				$link1 = '<a href="'.$row['po_content'].'" target="_blank" title="'.$row['po_content'].'">';
				$link2 = '</a>';
			} else {

			}
		}
        $expr = '';
        if($row['po_expired'] == 1) $expr = ' txt_expired';
        //$bg = 'bg'.($i%2);
    ?>

    <tr>
        <td class="td_chk">
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
            <input type="hidden" name="po_id[<?php echo $i ?>]" value="<?php echo $row['po_id'] ?>" id="po_id_<?php echo $i ?>">
			<label for="chk_<?php echo $i; ?>" ><?php echo $j ?></label>

        </td>
        <td><a href="?scolumn=mb_id&amp;sdata=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
        <td><?=$row2['mb_name']?></td>
        <td><?=$row['po_title']?></td>

        <td><?php echo $link1 ?><?php echo $row['po_content'] ?><?php echo $link2 ?></td>
        <td><?php echo number_format($row['po_point']) ?></td>
        <td align='right'><?php echo number_format($row['po_mb_point']) ?></td>
        <td><?php echo $row['po_datetime'] ?></td>
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">no found.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

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

    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<a href="'.$url.'1'.'">[First]</a>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<a href="'.$url.($start_page-1).'">Prev</a>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<a href="'.$url.$k.'" class="page" style="font-size:25px;">['.$k.']</a>'.PHP_EOL;
            else
                $str .= '<span class=""></span><strong class="">'.$k.'</strong>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<a href="'.$url.($end_page+1).'">Next</a>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<a href="'.$url.$total_page.'">[Last]</a>'.PHP_EOL;
    }

    if ($str)
        return "<nav class=''><span class=''>{$str}</span></nav>";
    else
        return "";
}
?>
