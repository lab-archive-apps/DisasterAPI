<?php
/**
 * Dependency Injection Container(依存性注入)
 * Slimに様々なものを注入できる（現在は，ViewとLogを注入している）
 */
use Slim\Views\Twig;

$container = $app->getContainer();

// view renderer(twig)
$container['view'] = function ($c) {

    $settings = $c->get('settings')['renderer'];

    $view = new Twig($settings['views_path'], [
        'debug' => true,    // enable debug mode
        'cache' => false,   // enable cache
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));
    // This line should allow the use of {{ dump() }}
    $view->addExtension(new \Twig_Extension_Debug());
    // Flash Message Extension
    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
        new Slim\Flash\Messages()
    ));

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Flash Message
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
