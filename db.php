<?php
// db.php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // sesuaikan password MySQL Anda
$DB_NAME = 'schedule_db';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    http_response_code(500);
    echo "DB Connection failed: " . $mysqli->connect_error;
    exit;
}
$mysqli->set_charset('utf8mb4');
