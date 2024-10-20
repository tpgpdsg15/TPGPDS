<?php
include 'inc/header.php';
$users = new Users();

$field = $_POST['field'];
$value = $_POST['value'];

$isUnique = $users->checkUnique($field, $value);

echo json_encode(['isUnique' => $isUnique]);
