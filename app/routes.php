<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$request = Request::createFromGlobals();
$response = new Response;

$session = new Session;
$session->start();

$request->setSession($session);

$routes = new RouteCollection();

$routes->add('index', new Route('/', ['_controller' => 'Controllers\MainController@index'],
    [], [], '', [], ['GET']));

$routes->add('login', new Route('/login', ['_controller' => 'Controllers\LoginController@index'],
    [], [], '', [], ['GET']));
$routes->add('post_login', new Route('/login', ['_controller' => 'Controllers\LoginController@login'],
    [], [], '', [], ['POST']));
$routes->add('logout', new Route('/logout', ['_controller' => 'Controllers\LoginController@logout'],
    [], [], '', [], ['GET']));

$routes->add('cabinet', new Route('/cabinet', ['_controller' => 'Controllers\CabinetController@index'],
    [], [], '', [], ['GET']));
$routes->add('add_rss', new Route('/add-rss', ['_controller' => 'Controllers\CabinetController@addRss'],
    [], [], '', [], ['POST']));
$routes->add('delete_rss', new Route('/delete-rss', ['_controller' => 'Controllers\CabinetController@deleteRss'],
    [], [], '', [], ['POST']));
$routes->add('update_rss', new Route('/update-rss', ['_controller' => 'Controllers\CabinetController@updateRss'],
    [], [], '', [], ['POST']));


$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

try {
    $parameters = $matcher->matchRequest($request);
    $request->attributes->replace($parameters);
    $action = $parameters['_controller'];
} catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    $response->setStatusCode('404');
    $response->setContent('404: Сторінка не знайдена!');
} catch (Symfony\Component\Routing\Exception\MethodNotAllowedException $e) {
    $response->setStatusCode('405');
    $response->setContent('405: Метод не існує');
}

if (isset($action) && is_string($action)) {
    $controller = explode('@', $action);

    $controller_class_name = $controller[0];
    $controller_instance = new $controller_class_name;
    $method = $controller[1];

    $response = $controller_instance->$method($request, $response);
}

//if (isset($action) && is_callable($action)) {
//    $response = $action($request, $response);
//}

//$response->send();