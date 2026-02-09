<?php
$host = "phpmyadmin";
$dbname = "customer_details";
$charset = "utf8mb4";
$user = "root";
$pass = "12345";
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try{
    $connect = new PDO($dsn, $user, $pass);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e){
    echo "Connection error: ".$e->getMessage();
}