<?php
/* Подключение к БД */
$db = new PDO("mysql:host=localhost;dbname=sg_news;charset=utf8", "root", "123");

/* Создание таблицы "resources", если ее не существует*/
try
{
//    $rows = $db->query("DROP TABLE resources");
    $db->query("CREATE TABLE IF NOT EXISTS resources(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	url VARCHAR(255) NOT NULL UNIQUE,
	name VARCHAR(80) NOT NULL
	) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
catch(PDOException $e)
{
    die("Error: ".$e->getMessage());
}

/* Отключение от БД */
$db = null;