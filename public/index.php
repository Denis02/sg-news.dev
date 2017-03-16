<?php

//session_start();

date_default_timezone_set('europe/kiev');

// Константы проекта
define('ROOT_DIR',getcwd().'/../');
define('MAIN_DIR',getcwd().'/');
define('APP_DIR',getcwd().'/../app/');

// Подключение пакетов
require_once ROOT_DIR.'vendor/autoload.php';

// Подключение файла маршрутизации
require_once ROOT_DIR.'app/routes.php';
