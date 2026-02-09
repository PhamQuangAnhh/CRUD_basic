<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $status = $_POST['status'];

        $sql = "UPDATE customers 
                SET name = :name, email = :email, phone = :phone, address = :address, gender = :gender, status = :status 
                WHERE id = :id";
        
        $stmt = $connect->prepare($sql);
        $stmt->execute([
            ':id' => $id,
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

// Get id from URL
$id = $_GET['id'];

$sql = "SELECT * FROM customers WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->execute([$id]);
$customer = $stmt->fetch();
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
        <input type="hidden" name="id" value="<?= $customer['id'] ?>">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?= $customer['name'] ?>" required>
        <label for="email">Email</label>
        <input type="email" name="email" id="" value="<?= $customer['email'] ?>" required>
        <label for="phone">Phone</label>
        <input type="number" name="phone" id="" value="<?= $customer['phone'] ?>" required>
        <label for="address">Address</label>
        <input type="text" name="address" id="" value="<?= $customer['address'] ?>" required>
        <label for="gender">Gender</label>
        <select name="gender" id="" required>
            <option value="male" <?= ($customer['gender'] == 'male') ? 'selected' : '' ?> >male</option>
            <option value="female" <?= ($customer['gender'] == 'female') ? 'selected' : '' ?> >female</option>
            <option value="other" <?= ($customer['gender'] == 'other') ? 'selected' : '' ?> >other</option>
        </select>
        <label for="status">Status</label>
        <select name="status" id="" selected required>
            <option value="1" <?= ($customer['status'] === '1') ? 'selected' : '' ?> >active</option>
            <option value="0" <?= ($customer['status'] === '0') ? 'selected' : '' ?> >inactive</option>
        </select>
        <button type="submit">Update</button>
    </form>
</body>
</html>