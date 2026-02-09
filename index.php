<?php
require_once "connection.php";

$search = trim($_GET['search'] ?? "");
$sql = "SELECT * FROM customers";
$params = [];

if ($search !== "") {
    $sql .= " WHERE name LIKE :q OR email LIKE :q OR phone LIKE :q";
    $params[':q'] = "%{$search}%";
}

$stmt = $connect->prepare($sql);
$stmt->execute($params);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="get">
        <label for="search">Search</label>
        <input type="text" name="search" placeholder="Search name, phone, email" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
        <a href="index.php">Reset</a>
    </form>
    
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>phone</th>
            <th>address</th>
            <th>gender</th>
            <th>status</th>
            <th>created_at</th>
            <th><a href="add.php">Add</a></th>
        </tr>
        <?php while($customer = $stmt->fetch()): ?>
            <tr>
                <td><?= $customer['id']?></td>
                <td><?= $customer['name']?></td>
                <td><?= $customer['email']?></td>
                <td><?= $customer['phone']?></td>
                <td><?= $customer['address']?></td>
                <td><?= $customer['gender']?></td>
                <td><?= $customer['status']?></td>
                <td><?= $customer['created_at']?></td>
                <td>
                    <a href="edit.php?id=<?= $customer['id'] ?>">Edit</a>
                    <a onclick="return confirm('Do you want to delete ?')" href="delete.php?id=<?= $customer['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>    
    </table>
</body>
</html>