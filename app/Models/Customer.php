<?php
namespace App\Models;

class Customer
{
    private $connect;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM customers';
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchCustomer($search)
    {
        $sql =
            'SELECT * FROM customers WHERE name LIKE ? OR email LIKE ? OR phone LIKE ? OR address LIKE ?';

        $stmt = $this->connect->prepare($sql);
        $stmt->execute(["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"]);
        return $stmt->fetchAll();
    }

    public function deleteCustomer($id)
    {
        $sql = 'DELETE FROM customers WHERE id = ?';
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$id]);
    }

    public function addCustomer($name, $avatar, $email, $phone, $address, $gender, $status)
    {
        $sql = "INSERT INTO customers 
                (name, avatar, email, phone, address, gender, status) 
                VALUES (:name, :avatar, :email, :phone, :address, :gender, :status)";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':avatar' => $avatar,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':gender' => $gender,
            ':status' => $status,
        ]);
    }

    public function editCustomer($id, $avatar, $name, $email, $phone, $address, $gender, $status)
    {
        $sql = "UPDATE customers 
                SET name = :name, avatar = :avatar, email = :email, phone = :phone, address = :address, gender = :gender, status = :status 
                WHERE id = :id";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':avatar' => $avatar,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':gender' => $gender,
            ':status' => $status,
        ]);
    }

    public function getById($id)
    {
        $sql = 'SELECT * FROM customers WHERE id = ?';
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
