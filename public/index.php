<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../app/db.php';
require '../vendor/autoload.php';

$app = new \Slim\App;

$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segment = explode('/', $_SERVER['REQUEST_URI_PATH']);
//$url = $segment[2];

if (isset($segment[3])) {
    $url = $segment[3];

    if ($url == 'post' || $url == 'posts') {

       // echo $url;
        require_once('../app/api/post.php');
    } elseif ($url == 'category' || $url == 'categories') {

        require_once('../app/api/category.php');
       // echo $url;

    } else {
        die('Please use API endpoint');
    }
}

    $app->run();
