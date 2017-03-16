<?php
/* Подключение к БД */
$db = new PDO("mysql:host=localhost;dbname=sg_news;charset=utf8", "root", "123");

/* Создание таблицы "news", если ее не существует*/
try
{
//    $rows = $db->query("DROP TABLE news");
    $db->query("CREATE TABLE IF NOT EXISTS news(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(255) NOT NULL,
	link VARCHAR(255) NOT NULL UNIQUE,
	description MEDIUMTEXT NOT NULL,
	source VARCHAR(255) NOT NULL,
	pub_date DATETIME NOT NULL
	) CHARACTER SET utf8 COLLATE utf8_general_ci;");
}
catch(PDOException $e)
{
    die("Error: ".$e->getMessage());
}

/* Отключение от БД */
$db = null;