<?php 

require_once 'auth.php';

if (!Auth::checkauth()) {
    die('Authorization required');
}


class CRUD {

    private $conn;
    public function __construct() {
        require 'config.php';
        $this->pdo = new PDO ("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
        $this->pdo->query("SET NAMES utf8");
    }

    public function delete($id) {
        $id = intval($id);
        $sql = "DELETE FROM `orders` WHERE `id` = ?";

        $sth = $this->pdo->prepare($sql);
        $sth->bindParam(1,$id,PDO::PARAM_INT);
        $sth->execute();
        header("Location: /orders.php");         
    }

    public function create($post) {
       
        $sql = "INSERT INTO `orders`(`product`,`price`,`amount`,`total_price`,`status`) VALUES (?,?,?,?,?)";
        
        $product = $_POST['product'];
        $price = $_POST['price'];
        $amount = $_POST['amount'];
        $total_price = floatval($price) * floatval($amount);
        $status = $_POST['status'];

        $sth = $this->pdo->prepare($sql);
        $sth->bindParam(1,$product,PDO::PARAM_STR);
        $sth->bindParam(2,$price,PDO::PARAM_STR);
        $sth->bindParam(3,$amount,PDO::PARAM_STR);
        $sth->bindParam(4,$total_price,PDO::PARAM_STR);
        $sth->bindParam(5,$status,PDO::PARAM_STR);
        $sth->execute();
        header("Location: /orders.php"); 
    }

    public function update($post) {
        $sql = "UPDATE `orders` SET `product`= ?,`price`= ?,`amount`= ?,`total_price`= ?,`status`= ? WHERE `id`= ?";
        $product = $_POST['product'];
        $price = $_POST['price'];
        $amount = $_POST['amount'];
        $total_price = floatval($price) * floatval($amount);
        $status = $_POST['status'];
        $id = $_POST['id'];
        $sth = $this->pdo->prepare($sql);
        $sth->bindParam(1,$product,PDO::PARAM_STR);
        $sth->bindParam(2,$price,PDO::PARAM_STR);
        $sth->bindParam(3,$amount,PDO::PARAM_STR);
        $sth->bindParam(4,$total_price,PDO::PARAM_STR);
        $sth->bindParam(5,$status,PDO::PARAM_STR);
        $sth->bindParam(6,$id,PDO::PARAM_STR);
        $sth->execute();
        header("Location: /orders.php"); 

    }

    public function read() 
    {
        
        $sql = "SELECT * FROM orders";

        $sth = $this->pdo->prepare($sql);
        $sth->execute();

        $orders = $sth->fetchall(PDO::FETCH_ASSOC);
        return $orders;
    }


    
}

$crud = new CRUD();

    if (isset($_GET['delete']) && $_GET['delete'] == '1') {
        $crud->delete($_GET['id']);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'create') {
            $crud->create($_POST);
        }
        if ($_POST['action'] == 'update') {
            $crud->update($_POST);
        }
    }
