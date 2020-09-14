<?php
declare(strict_types=1);


namespace Application\Container;

use Application\Container\Exception\EnvironmentVariableNotFoundException;
use Application\Container\Factory\ContainerFactory;
use Application\Controller\RetentionController;
use Application\Handler\Retention\RetentionHandler;
use Application\Request\Authentication\BasicRequestAuthenticationResolver;
use Application\Request\Authentication\BasicRequestAuthenticator;
use Application\Request\Factory\RequestFactory;
use Application\Response\Factory\ResponseFactory;
use Application\Router\Router;
use Domain\Retention\Logger\RetentionActionLoggerInterface;
use Domain\Retention\Resolver\RetentionResolver;
use Infrastructure\Retention\Parser\UserFileParser;

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

    /**
     * @var RetentionController|null
     */
    private $retentionController = null;

    /**
     * @var RetentionHandler|null
     */
    private $retentionHandler = null;

    /**
     * @var UserFileParser|null
     */
    private $userFileParser = null;

    /**
     * @var RetentionResolver|null
     */
    private $retentionResolver = null;
    /**
     * @var RetentionActionLoggerInterface|null
     */
    private $retentionActionLogger = null;

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
                    $this->getResponseFactory(),
                    $this->getRetentionController(),
                    $this->getEnvironmentVariable('RETENTION_RESOLVER_URL')
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


    private function getRetentionController(): RetentionController
    {
        if (null === $this->retentionController) {
            $this->retentionController
                = $this->factory->createRetentionController(
                    $this->getEnvironmentVariable('RETENTION_RESOLVER_FORM_FIELD'),
                    $this->getResponseFactory(),
                    $this->getRetentionHandler()
                );
        }

        return $this->retentionController;
    }

    private function getEnvironmentVariable(string $environmentVariableName): string
    {
        $variable = \getenv($environmentVariableName);
        if (false === $variable) {
            throw new EnvironmentVariableNotFoundException($environmentVariableName);
        }

        return $variable;
    }

    public function getUserFileParser(): UserFileParser
    {
        if (null === $this->userFileParser) {
            $this->userFileParser
                = $this->factory->createUserFileParser();
        }

        return $this->userFileParser;
    }


    private function getRetentionHandler(): RetentionHandler
    {
        if (null === $this->retentionHandler) {
            $this->retentionHandler
                = $this->factory->createRetentionHandler(
                    $this->getUserFileParser(),
                    $this->getRetentionResolver()
                );
        }

        return $this->retentionHandler;
    }

    private function getRetentionResolver(): RetentionResolver
    {
        if (null === $this->retentionResolver) {
            $this->retentionResolver
                = $this->factory->createRetentionResolver(
                    $this->getRetentionActionLogger()
                );
        }

        return $this->retentionResolver;
    }


    private function getRetentionActionLogger(): RetentionActionLoggerInterface
    {
        if (null === $this->retentionActionLogger) {
            $this->retentionActionLogger
                = $this->factory->createRetentionActionLogger(
                    $this->getEnvironmentVariable('RETENTION_RESOLVER_PATH_LOG_ACTION_SMS'),
                    $this->getEnvironmentVariable('RETENTION_RESOLVER_PATH_LOG_ACTION_NONE')
                );
        }

        return $this->retentionActionLogger;
    }
}
