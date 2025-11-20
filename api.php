<?php
// api.php
header('Content-Type: application/json; charset=utf-8');
require_once 'db.php';

$action = $_REQUEST['action'] ?? '';

function send($data){
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($action === 'list') {
    $q = $mysqli->prepare("SELECT * FROM transactions ORDER BY t_date DESC, t_time DESC, id DESC");
    $q->execute();
    $res = $q->get_result()->fetch_all(MYSQLI_ASSOC);
    send(['status'=>'ok','data'=>$res]);
}

if ($action === 'add') {
    $t_date = $_POST['t_date'] ?? date('Y-m-d');
    $t_time = $_POST['t_time'] ?: null;
    $title = $_POST['title'] ?? '';
    $type = $_POST['type'] ?? 'expense';
    $category = $_POST['category'] ?? '';
    $amount = $_POST['amount'] ?? '0';
    $note = $_POST['note'] ?? '';

    // basic validation
    if (trim($title) === '' || !is_numeric($amount)) send(['status'=>'error','msg'=>'Judul atau jumlah tidak valid']);

    $stmt = $mysqli->prepare("INSERT INTO transactions (t_date,t_time,title,type,category,amount,note) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssss', $t_date, $t_time, $title, $type, $category, $amount, $note);
    if ($stmt->execute()) send(['status'=>'ok','id'=>$stmt->insert_id]);
    send(['status'=>'error','msg'=>$stmt->error]);
}

if ($action === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $t_date = $_POST['t_date'] ?? date('Y-m-d');
    $t_time = $_POST['t_time'] ?: null;
    $title = $_POST['title'] ?? '';
    $type = $_POST['type'] ?? 'expense';
    $category = $_POST['category'] ?? '';
    $amount = $_POST['amount'] ?? '0';
    $note = $_POST['note'] ?? '';

    if ($id <= 0) send(['status'=>'error','msg'=>'ID tidak valid']);
    $stmt = $mysqli->prepare("UPDATE transactions SET t_date=?, t_time=?, title=?, type=?, category=?, amount=?, note=? WHERE id=?");
    $stmt->bind_param('sssssdsi', $t_date, $t_time, $title, $type, $category, $amount, $note, $id);
    if ($stmt->execute()) send(['status'=>'ok']);
    send(['status'=>'error','msg'=>$stmt->error]);
}

if ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) send(['status'=>'error','msg'=>'ID tidak valid']);
    $stmt = $mysqli->prepare("DELETE FROM transactions WHERE id=?");
    $stmt->bind_param('i',$id);
    if ($stmt->execute()) send(['status'=>'ok']);
    send(['status'=>'error','msg'=>$stmt->error]);
}

if ($action === 'export') {
    // Return CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="transactions_' . date('Ymd_His') . '.csv"');
    $out = fopen('php://output','w');
    fputcsv($out, ['id','date','time','title','type','category','amount','note','created_at']);
    $res = $mysqli->query("SELECT * FROM transactions ORDER BY t_date DESC, t_time DESC");
    while ($row = $res->fetch_assoc()) {
        fputcsv($out, [$row['id'],$row['t_date'],$row['t_time'],$row['title'],$row['type'],$row['category'],$row['amount'],$row['note'],$row['created_at']]);
    }
    fclose($out);
    exit;
}

send(['status'=>'error','msg'=>'Aksi tidak dikenal']);
