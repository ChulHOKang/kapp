<?php
include_once('../../tkher_start_necessary.php');
//include_once('./tkher_start_necessary.php');

if (!$is_member) die("0");

$as_id = (int)$_REQUEST['as_id'];

$sql = " delete from {$tkher['autosave_table']} where mb_id = '{$member['mb_id']}' and as_id = {$as_id} ";
$result = sql_query($sql);
if (!$result) {
    echo "-1";
}

echo autosave_count($member['mb_id']);
?>