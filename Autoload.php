<?php
if (session_status() !== 'PHP_SESSION_ACTIVE') session_start();
require_once __DIR__ . '/Classes/Database.php';
$database = new Database('localhost', 'project_2_db', 'root', '');
$connObj = $database->getConnection();
