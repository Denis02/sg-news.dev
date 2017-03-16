<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 15.03.17
 * Time: 22:52
 */

namespace Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Models\News;

class CabinetController extends BaseController
{
    protected $news;

    public function __construct()
    {
        parent::__construct();
        $this->news = new News();
    }

    public function index(){
        if(!$this->user)
            header("Location: /login");

        $items = $this->news->getResources();

        self::view('cabinet', ['items'=>$items]);
    }

    public function addRss(){
        if(!$this->user)
            header("Location: /login");

        if (isset($_POST['name']) && isset($_POST['url']))
            $this->news->setResource($_POST['name'],$_POST['url']);

        header("Location: /cabinet");
    }

    public function deleteRss($id=null){
        if(!$this->user)
            header("Location: /login");

        if (isset($_POST['id']))
            $this->news->deleteResource((int)$_POST['id']);

        header("Location: /cabinet");
    }

    public function updateRss($id=null){
        if(!$this->user)
            header("Location: /login");

        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['url']))
            $this->news->updateResource($_POST['id'], $_POST['name'],$_POST['url']);

        header("Location: /cabinet");
    }

}