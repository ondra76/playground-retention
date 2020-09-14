<?php
declare(strict_types=1);


namespace Application\Container\Factory;

use Application\Container\Container;
use Application\Controller\RetentionController;
use Application\Handler\Retention\RetentionHandler;
use Application\Request\Authentication\BasicRequestAuthenticationResolver;
use Application\Request\Authentication\BasicRequestAuthenticator;
use Application\Request\Authentication\RequestAuthenticationResolverInterface;
use Application\Request\Factory\RequestFactory;
use Application\Response\Factory\ResponseFactory;
use Application\Router\Router;
use Domain\Retention\Logger\RetentionActionLoggerInterface;
use Domain\Retention\Resolver\RetentionResolver;
use Infrastructure\Retention\Logger\RetentionActionLogger;
use Infrastructure\Retention\Parser\UserFileParser;

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

    public function createRouter(
        ResponseFactory $responseFactory,
        RetentionController $retentionController,
        string $retentionSmsResolverUrl
    ): Router {
        return new Router(
            $responseFactory,
            $retentionController,
            $retentionSmsResolverUrl
        );
    }

    public function createRetentionController(
        string $resolverFormField,
        ResponseFactory $responseFactory,
        RetentionHandler $retentionHandler
    ): RetentionController {
        return new RetentionController(
            $resolverFormField,
            $responseFactory,
            $retentionHandler
        );
    }

    public function createUserFileParser(): UserFileParser
    {
        return new UserFileParser();
    }

    public function createRetentionHandler(
        UserFileParser $fileParser,
        RetentionResolver $resolver
    ): RetentionHandler {
        return new RetentionHandler($fileParser, $resolver);
    }

    public function createRetentionResolver(
        RetentionActionLoggerInterface $actionLogger
    ): RetentionResolver {
        return new RetentionResolver($actionLogger);
    }

    public function createRetentionActionLogger(
        string $fileSmsAction,
        string $fileNoneAction
    ): RetentionActionLoggerInterface {
        return new RetentionActionLogger(
            $fileSmsAction,
            $fileNoneAction
        );
    }
}
