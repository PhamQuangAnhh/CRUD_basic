<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $status = $_POST['status'];

        $sql = "INSERT INTO customers 
                (name, email, phone, address, gender, status) 
                VALUES (:name, :email, :phone, :address, :gender, :status)";
        
        $stmt = $connect->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':gender' => $gender,
            ':status' => $status
        ]);

        header("Location: index.php");
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Duplicate email!";
        } else {
            echo "Error: ".$e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer_add</title>
</head>
<body>
    <form action="" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="" required>
        <label for="phone">Phone</label>
        <input type="number" name="phone" id="" required>
        <label for="address">Address</label>
        <input type="text" name="address" id="" required>
        <label for="gender">Gender</label>
        <select name="gender" id="" required>
            <option value="male">male</option>
            <option value="female">female</option>
            <option value="other">other</option>
        </select>
        <label for="status">Status</label>
        <select name="status" id="" required>
            <option value="1">active</option>
            <option value="0">inactive</option>
        </select>
        <button type="submit">Add</button>
    </form>
</body>
</html>