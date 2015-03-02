<?php
require 'vendor/autoload.php';
require 'conf/prod.conf.php';
require 'app/controllers/DataController.php';

$conf = new AppConfig();
$app = $conf->getApp();
$controller = new DataController($conf);

// Homepage
$app->get('/', function () use ($controller) {
    echo $controller->render('/', 'pages/homepage.html.twig');
});

// Category
$app->get('/category/:slug', function ($slug) use ($controller) {
    echo $controller->render('/categories/' . $slug, 'pages/category.html.twig');
});

// Tag
/*$app->get('/tag/:slug', function ($slug) use ($controller) {
    echo $controller->render('/tags/' . $slug, 'pages/tag.html.twig');
});*/

// Author
$app->get('/author/:slug', function ($slug) use ($controller) {
    echo $controller->render('/author/' . $slug, 'pages/author.html.twig');
});

// Search
$app->get('/search/:query', function ($query) use ($controller) {
    echo $controller->render('/search/' . $query, 'pages/search.html.twig');
});

// Article || Page
$app->get('/:slug', function ($slug) use ($controller) {
    echo $controller->render('/' . $slug, 'pages/post.html.twig');
});

$app->run();