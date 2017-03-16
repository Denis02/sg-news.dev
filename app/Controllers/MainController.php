<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 10.03.17
 * Time: 12:14
 */

namespace Controllers;

use Models\News;

class MainController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Страница новостей
     */
    public function index(){
        $this->log->debug('Start',['controller'=>'News','method'=>'getView']);

        // получение номера страницы и значения для лимита
        $query = parse_url($_SERVER['REQUEST_URI'])['query'] ?? false;
        $cur_page = 1;
        $per_page = 50;
        if ($query)
        {
            foreach (explode("&", $query) as $value)
            {
                $page = explode("=", $value);
                if ($page[0]=='page') $cur_page = $page[1] ?? 1;
                if ($page[0]=='limit') $per_page = $page[1] ?? 50;
            }
        }

        self::view('news',(new News())->getNews($cur_page,$per_page));

        $this->log->debug('Finish',['controller'=>'News','method'=>'getView']);
    }

}