<?php 
class Auth {
    private $conn;
    public function __construct() {
        require_once 'config.php';
        $this->pdo = new PDO ("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
        $this->pdo->query("SET NAMES utf8");
    }

    public static function checkauth() {
        require 'config.php';
        $pdo = new PDO ("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
        $pdo->query("SET NAMES utf8");
        if (isset($_COOKIE['Auth'])) {
            require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
            $password = $_COOKIE['Auth'];
            $login = $_COOKIE['Login'];
            $sql = "SELECT `login`,`password` FROM `users` WHERE `login` = ?";
            $sth = $pdo->prepare($sql);
            $sth->bindParam(1,$login,PDO::PARAM_STR);
            $sth->execute();
            $sql_resp = ($sth->fetch(PDO::FETCH_ASSOC));
            
            $check = $sql_resp['login'] . current(str_split($sql_resp['password'], 32));
            
            if ( $check == $password) {
                return True;
            }
        } else {
            return False;
        }
        
    } 
    public function signin($email,$password) {
        $email = strtolower($email);
        $sql = "SELECT `login`,`password` FROM `users` WHERE `email` = ?";

        $sth = $this->pdo->prepare($sql);
        $sth->bindParam(1,$email,PDO::PARAM_STR);
        $sth->execute();
        $sql_resp = ($sth->fetch(PDO::FETCH_ASSOC));
        if (password_verify($password, $sql_resp['password'])) {

                        $cookie_options = array(
                            'expires' => time()+3600,
                            'path' => '/',                            
                        );
                        setcookie("Auth", $sql_resp['login'] . current(str_split($sql_resp['password'], 32)), $cookie_options);
                        setcookie("Login", $sql_resp['login'] , $cookie_options);
                        header("Location: /orders.php");   
                        
        }        
    }


    public function register($reg_values) {
        $login = $reg_values['login'];
        $password = $reg_values['password'];
        $email = $reg_values['email'];
        $sql = "SELECT * FROM `users` WHERE `login` = ?";

        $sth = $this->pdo->prepare($sql);
        $sth->bindParam(1,$login,PDO::PARAM_STR);
        $sth->execute();

        $sql = "INSERT INTO `users`(`login`, `password`,`email`,`created_at`) VALUES (?,?,?,NOW())";
            $sth = $this->pdo->prepare($sql);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sth->bindParam(1,$login,PDO::PARAM_STR);
            $sth->bindParam(2,$password,PDO::PARAM_STR);
            $sth->bindParam(3,$email,PDO::PARAM_STR);
            $sth->execute();
            header("Location: /login.php");   

    }
}


// if (isset($_POST['email'])) {
//     if (isset($_POST['login'])) {
//         Auth::register($_POST);   
//     } else Auth::signin($_POST['email'],$_POST['password']);   
// }

$auth = new Auth();

if (isset($_POST['email'])) {
    if (isset($_POST['login'])) {
        $auth->register($_POST);   
    } else $auth->signin($_POST['email'],$_POST['password']);   
}





#$auth->signin('abc@abc.ru','abc@abc.ru');

#var_dump(Auth::checkauth());