<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\Customer;

class Customer_Controller extends BaseController
{
    private $customerModel;

    public function __construct()
    {
        $db = new Database();
        $connect = $db->getConnection();
        $this->customerModel = new Customer($connect);
    }

    public function index()
    {
        $customers = $this->customerModel->getAll();
        $this->renderView('Customer_list', ['customers' => $customers]);
    }

    public function delete()
    {
        $id = $_GET['id'];
        $customer = $this->customerModel->getById($id);
        if (!empty($customer['avatar'])) {
            $file = __DIR__ . '/../../public' . $customer['avatar'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $this->customerModel->deleteCustomer($id);
        header('Location: /');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $avatarPath = null;
            if (!empty($_FILES['avatar']['name'])) {
                $uploadDir = __DIR__ . '/../../public/images/';
                $fileName = time() . '_' . $_FILES['avatar']['name'];
                $targetFile = $uploadDir . $fileName;
                $tail = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (!in_array($tail, ['png', 'jpg', 'jpeg'])) {
                    die('Do not except this kind of file');
                }
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                    $avatarPath = '/images/' . $fileName;
                }
            }

            $name = $_POST['name'];
            $avatar = $avatarPath;
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $status = $_POST['status'];
            $this->customerModel->addCustomer(
                $name,
                $avatar,
                $email,
                $phone,
                $address,
                $gender,
                $status,
            );
            header('Location: /');
        } else {
            $this->renderView('add');
        }
    }

    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            $customer = $this->customerModel->getById($id);
            $avatarPath = $customer['avatar'];
            if (!empty($_FILES['avatar']['name'])) {
                $uploadDir = __DIR__ . '/../../public/images/';
                $fileName = time() . '_' . $_FILES['avatar']['name'];
                $targetFile = $uploadDir . $fileName;
                $tail = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (!in_array($tail, ['png', 'jpg', 'jpeg'])) {
                    die('Do not except this kind of file');
                }
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                    if (!empty($customer['avatar'])) {
                        $oldFile = __DIR__ . '/../../public' . $customer['avatar'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    $avatarPath = '/images/' . $fileName;
                }
            }

            $id = $_POST['id'];
            $avatar = $avatarPath;
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $status = $_POST['status'];
            $this->customerModel->editCustomer(
                $id,
                $avatar,
                $name,
                $email,
                $phone,
                $address,
                $gender,
                $status,
            );
            header('Location: /');
        }
        $id = $_GET['id'];
        $customer = $this->customerModel->getById($id);
        $this->renderView('edit', ['customer' => $customer]);
    }

    public function search()
    {
        $search = trim($_GET['search'] ?? '');
        if ($search) {
            $customers = $this->customerModel->searchCustomer($search);
            $this->renderView('Customer_list', ['customers' => $customers, 'search' => $search]);
        } else {
            $customers = $this->customerModel->getAll();
            $this->renderView('Customer_list', ['customers' => $customers, 'search' => '']);
        }
    }

    public function view()
    {
        $id = $_GET['id'];
        $customer = $this->customerModel->getById($id);
        $this->renderView('detail', ['customer' => $customer]);
    }
}
