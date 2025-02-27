<?php
require_once '../config/config.php';
require_once '../includes/Database.php';

$db = Database::getInstance()->getConnection();
$categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($categories);