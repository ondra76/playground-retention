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

\putenv('RETENTION_RESOLVER_URL=/api/retention/sms-resolver');
\putenv('RETENTION_RESOLVER_FORM_FIELD=file');
\putenv('RETENTION_RESOLVER_PATH_LOG_ACTION_SMS='.dirname(__DIR__).'/var/log/retention-action-sms.txt');
\putenv('RETENTION_RESOLVER_PATH_LOG_ACTION_NONE='.dirname(__DIR__).'/var/log/retention-action-none.txt');
//we would load this from a secure storage on a normal project
$username = 'user';
$password = 'pass';

$container = Container::create();

$request = $container
    ->getRequestFactory()
    ->create($_SERVER, $_FILES);

header('Cache-Control: no-cache, must-revalidate, max-age=0');

$container->getBasicRequestAuthenticator()
    ->authenticateOrExit(
        $_SERVER,
        $username,
        $password
    );

$container->getRouter()->getResponse($request)->printAndExit();
