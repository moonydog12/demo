<?php

require 'functions.php';
// require 'router.php';

$env = parse_ini_file('.env');
$dbPassword = $env['DB_PASSWORD'];

// connect to MySQL db
$dsn = "mysql:host=localhost;port=3306;dbname=myapp;user=root;password=$dbPassword;charset=utf8mb4";
$pdo = new PDO($dsn);
$statement = $pdo->prepare('SELECT * FROM posts');

$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

dd($posts);
