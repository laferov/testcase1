<?php 

require_once 'auth.php';

if (!Auth::checkauth()) {
    die('Authorization required');
}


class CRUD {

    public static function delete($id) {
        require $_SERVER['DOCUMENT_ROOT'].'/config.php';
        $id = intval($id);
        $sql = "DELETE FROM `orders` WHERE `id` = ?";

        $sth = $pdo->prepare($sql);
        $sth->bindParam(1,$id,PDO::PARAM_INT);
        $sth->execute();
        header("Location: /orders.php");         
    }

    public static function create($post) {

        require $_SERVER['DOCUMENT_ROOT'].'/config.php';
        
        $sql = "INSERT INTO `orders`(`product`,`price`,`amount`,`total_price`,`status`) VALUES (?,?,?,?,?)";
        
        $product = $_POST['product'];
        $price = $_POST['price'];
        $amount = $_POST['amount'];
        $total_price = floatval($price) * floatval($amount);
        $status = $_POST['status'];

        $sth = $pdo->prepare($sql);
        $sth->bindParam(1,$product,PDO::PARAM_STR);
        $sth->bindParam(2,$price,PDO::PARAM_STR);
        $sth->bindParam(3,$amount,PDO::PARAM_STR);
        $sth->bindParam(4,$total_price,PDO::PARAM_STR);
        $sth->bindParam(5,$status,PDO::PARAM_STR);
        $sth->execute();
        header("Location: /orders.php"); 
    }

    public static function update($post) {
    
        require $_SERVER['DOCUMENT_ROOT'].'/config.php';
        $sql = "UPDATE `orders` SET `product`= ?,`price`= ?,`amount`= ?,`total_price`= ?,`status`= ? WHERE `id`= ?";
        $product = $_POST['product'];
        $price = $_POST['price'];
        $amount = $_POST['amount'];
        $total_price = floatval($price) * floatval($amount);
        $status = $_POST['status'];
        $id = $_POST['id'];
        $sth = $pdo->prepare($sql);
        $sth->bindParam(1,$product,PDO::PARAM_STR);
        $sth->bindParam(2,$price,PDO::PARAM_STR);
        $sth->bindParam(3,$amount,PDO::PARAM_STR);
        $sth->bindParam(4,$total_price,PDO::PARAM_STR);
        $sth->bindParam(5,$status,PDO::PARAM_STR);
        $sth->bindParam(6,$id,PDO::PARAM_STR);
        $sth->execute();
        header("Location: /orders.php"); 

    }

    public static function read() 
    {
        
        require $_SERVER['DOCUMENT_ROOT'].'/config.php';

        $sql = "SELECT * FROM orders";


        $sth = $pdo->prepare($sql);
        $sth->execute();

        $orders = $sth->fetchall(PDO::FETCH_ASSOC);
        return $orders;
    }


    
}


    if (isset($_GET['delete']) && $_GET['delete'] == '1') {
        CRUD::delete($_GET['id']);
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'create') {
            CRUD::create($_POST);
        }
        if ($_POST['action'] == 'update') {
            CRUD::update($_POST);
        }
    }
