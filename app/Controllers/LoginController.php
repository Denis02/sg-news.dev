<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 15.03.17
 * Time: 22:51
 */

namespace Controllers;


use Models\User;

class LoginController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if($this->user)
            header("Location: /cabinet");

        self::view('login');
    }

    public function login()
    {
        if (isset($_SESSION['auth_error']))
            unset($_SESSION['auth_error']);

        if (isset($_POST['login']) && isset($_POST['password'])) {
            if ($user = (new User)->login($_POST['login'], $_POST['password'])) {
                $this->user = $user;
                var_dump($user);
                $_SESSION['user'] = serialize($user);
                header("Location: /cabinet");
            }
            else {
                $_SESSION['auth_error'] = 'Невірний логін або пароль!';
            }
        }

        self::view('login');
    }

    /**
     * Выход из учетной записи
     */
    public function logout(){
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
        header("Location: /login");
    }

}