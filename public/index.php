<?php


use Application\Container\Container;

spl_autoload_register(function ($class_name) {
    $filename = str_ireplace('\\', DIRECTORY_SEPARATOR, $class_name);
    include
        dirname(__DIR__).
        DIRECTORY_SEPARATOR.
        'src'
        .DIRECTORY_SEPARATOR.
        $filename.
        '.php';
});

//we would load this from the ENV on a normal project
$username = 'user';
$password = 'pass';

$container = Container::create();

$request = $container
    ->getRequestFactory()
    ->create($_SERVER);

header('Cache-Control: no-cache, must-revalidate, max-age=0');

$container->getBasicRequestAuthenticator()
    ->authenticateOrExit(
    $_SERVER,
    $username,
    $password
);

$container->getRouter()->getResponse($request)->printAndExit();
