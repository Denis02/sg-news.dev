<?php
/* Подключение к БД */
$db = new PDO("mysql:host=localhost;dbname=sg_news;charset=utf8", "root", "123");

/* Создание таблицы "users", если ее не существует*/
try
{
//    $rows = $db->query("DROP TABLE users");
    $db->query("CREATE TABLE IF NOT EXISTS users(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(80) NOT NULL UNIQUE,
	password VARCHAR(80) NOT NULL
	) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
catch(PDOException $e)
{
    die("Error: ".$e->getMessage());
}

$db->query("INSERT IGNORE INTO users (email, password) VALUES ('Denis@com','1111')");

/* Отключение от БД */
$db = null;