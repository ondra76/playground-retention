<?php
declare(strict_types=1);


namespace Application\Container;

use Application\Container\Factory\ContainerFactory;
use Application\Request\Authentication\BasicRequestAuthenticationResolver;
use Application\Request\Authentication\BasicRequestAuthenticator;
use Application\Request\Factory\RequestFactory;
use Application\Response\Factory\ResponseFactory;
use Application\Router\Router;

final class Container
{
    /**
     * @var ContainerFactory
     */
    private $factory;

    /**
     * @var RequestFactory|null
     */
    private $requestFactory = null;

    /**
     * @var BasicRequestAuthenticationResolver|null
     */
    private $basicRequestAuthenticationResolver = null;

    /**
     * @var BasicRequestAuthenticator|null
     */
    private $basicRequestAuthenticator = null;

    /**
     * @var ResponseFactory|null
     */
    private $responseFactory = null;

    /**
     * @var Router|null
     */
    private $router = null;

    private function __construct()
    {
        $this->factory = new ContainerFactory($this);
    }

    public static function create(): self
    {
        return new self();
    }

    public function getRequestFactory(): RequestFactory
    {
        if (null === $this->requestFactory) {
            $this->requestFactory
                = $this->factory->createRequestFactory();
        }

        return $this->requestFactory;
    }

    public function getBasicRequestAuthenticator(): BasicRequestAuthenticator
    {
        if (null === $this->basicRequestAuthenticator) {
            $this->basicRequestAuthenticator
                = $this->factory->createBasicRequestAuthenticator(
                    $this->getBasicRequestAuthenticationResolver()
                );
        }

        return $this->basicRequestAuthenticator;
    }

    private function getBasicRequestAuthenticationResolver(): BasicRequestAuthenticationResolver
    {
        if (null === $this->basicRequestAuthenticationResolver) {
            $this->basicRequestAuthenticationResolver
                = $this->factory->createBasicRequestAuthenticationResolver();
        }

        return $this->basicRequestAuthenticationResolver;
    }

    public function getRouter(): Router
    {
        if (null === $this->router) {
            $this->router
                = $this->factory->createRouter(
                    $this->getResponseFactory()
                );
        }

        return $this->router;
    }

    private function getResponseFactory(): ResponseFactory
    {
        if (null === $this->responseFactory) {
            $this->responseFactory
                = $this->factory->createResponseFactory();
        }

        return $this->responseFactory;
    }
}
