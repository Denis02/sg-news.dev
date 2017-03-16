<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 15.03.17
 * Time: 22:54
 */

namespace Controllers;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class BaseController
{
    protected $log;
    protected $user=null;

    protected function __construct()
    {
        // Создание регистратора
        $this->log = new Logger('logger');
        $this->log->pushHandler(new StreamHandler(ROOT_DIR.'logs/debug.log',Logger::DEBUG));
        $this->log->pushHandler(new StreamHandler(ROOT_DIR.'logs/info.log',Logger::INFO,false));
        $this->log->pushHandler(new StreamHandler(ROOT_DIR.'logs/error.log',Logger::WARNING,false));

        $this->log->debug('Start',['controller'=>'Main','method'=>'__construct']);

        if(isset($_SESSION['user']))
            $this->user = unserialize($_SESSION['user']);

        $this->log->debug('Finish',['controller'=>'Main','method'=>'__construct']);
    }


    /**
     * Вывод страницы на экран
     * @param string $content - название файла представления
     * @param array $data - данные использующиеся в представлениии
     * @param string $layout - название файла разметки представления
     */
    protected static function view(string $content, array $data=[], string $layout='default'){
        extract($data, EXTR_PREFIX_INVALID, '_');
        include_once "views/layouts/$layout.php";
    }

    /**
     * Запуск скрипта для заполнения БД новыми новостями
     */
    protected function runJob(){
        $this->log->debug('Start',['controller'=>'News','method'=>'runJob']);
        include_once APP_DIR . 'Helpers/jobs/news_job.php';
        $this->log->debug('Finish',['controller'=>'News','method'=>'runJob']);
    }
}