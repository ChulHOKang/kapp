<?php
session_start(); // <<< 반드시 맨 처음에 호출!
/*
	save_session.php - call: kapp_table_index_Create.php
	projectnmS, pnmS
	: projectnmS: 'project_nmS', pnmS: 'dao_1765672506:ERP'
	: $_SESSION['project_nmS'] = 'dao_1765672506:ERP' 을 전달.
*/

// JSON 데이터 받기
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if( isset( $data['projectnmS'])) {
    $fld_A = $data['projectnmS']; // 세션에 저장
	$_SESSION[$fld_A] = $data['pnmS'];

    $_SESSION['projectnmS'] = $data['projectnmS']; // 세션에 저장
    $_SESSION['pnmS'] = $data['pnmS']; // 추가 데이터 저장
    echo json_encode(['status' => 'success', 'message' => $data['projectnmS']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data']);
}
?>
