<?php 
$dbhost = 'localhost';
$dbname = 'user_db';
$dbuser = 'user_db';
$dbpass = 'password';

$pdo = new PDO ("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
$pdo->query("SET NAMES utf8");