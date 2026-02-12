<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Customer_Controller;

$app = new Customer_Controller();
$action = $_GET['action'] ?? 'index';
switch ($action) {
    case 'add':
        $app->add();
        break;
    case 'delete':
        $app->delete();
        break;
    case 'edit':
        $app->edit();
        break;
    case 'search':
        $app->search();
        break;
    case 'view':
        $app->view();
        break;
    default:
        $app->index();
        break;
}
?>
