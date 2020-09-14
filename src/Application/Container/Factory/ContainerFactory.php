<?php
declare(strict_types=1);


namespace Application\Container\Factory;

use Application\Container\Container;
use Application\Request\Authentication\BasicRequestAuthenticationResolver;
use Application\Request\Authentication\BasicRequestAuthenticator;
use Application\Request\Authentication\RequestAuthenticationResolverInterface;
use Application\Request\Factory\RequestFactory;
use Application\Response\Factory\ResponseFactory;
use Application\Router\Router;

final class ContainerFactory
{

    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function createRequestFactory(): RequestFactory
    {
        return new RequestFactory();
    }

    public function createResponseFactory(): ResponseFactory
    {
        return new ResponseFactory();
    }

    public function createBasicRequestAuthenticationResolver(): BasicRequestAuthenticationResolver
    {
        return new BasicRequestAuthenticationResolver();
    }

    public function createBasicRequestAuthenticator(BasicRequestAuthenticationResolver $resolver): BasicRequestAuthenticator
    {
        return new BasicRequestAuthenticator($resolver);
    }

    public function createRouter(ResponseFactory $responseFactory): Router
    {
        return new Router($responseFactory);
    }
}
