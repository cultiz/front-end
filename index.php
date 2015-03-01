<?php
require 'vendor/autoload.php';
require 'conf/prod.conf.php';
require 'app/controllers/DataController.php';

$loader = new Twig_Loader_Filesystem('app/views');
$twig = new Twig_Environment(
    $loader, 
    array(
        'cache' => 'cache/views',
));

$app = new \Slim\Slim(array(
    'debug' => true
));

$controller = new DataController($twig);

// Homepage
$app->get('/', function () use ($controller) {
    echo $controller->render('/', 'index.html');
});

// Category
$app->get('/category/:slug', function ($slug) use ($controller) {
    echo $controller->render('/categories/' . $slug, 'index.html');
});

// Tag
$app->get('/tag/:slug', function ($slug) use ($controller) {
    echo $controller->render('/tags/' . $slug, 'index.html');
});

// Author
$app->get('/author/:slug', function ($slug) use ($controller) {
    echo $controller->render('/author/' . $slug, 'index.html');
});

// Search
$app->get('/search/:query', function ($query) use ($controller) {
    echo $controller->render('/search/' . $query, 'index.html');
});

// Article || Page
$app->get('/:slug', function ($slug) use ($controller) {
    echo $controller->render('/' . $slug, 'index.html');
});

$app->run();