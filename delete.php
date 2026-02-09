<?php
require_once "connection.php";

$id = $_GET['id'];

$sql = "DELETE FROM customers WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->execute([$id]);

header("Location: index.php");
exit();
