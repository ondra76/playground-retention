<?php
declare(strict_types=1);


namespace Application\Router;

use Application\Controller\RetentionController;
use Application\Request\Request;
use Application\Response\Factory\ResponseFactory;
use Application\Response\ResponseInterface;

/**
 * Intentionally simple, but extendable easily
 */
final class Router
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;
    /**
     * @var RetentionController
     */
    private $retentionController;
    /**
     * @var string
     */
    private $retentionSmsResolverUrl;

    public function __construct(
        ResponseFactory $responseFactory,
        RetentionController $retentionController,
        string $retentionSmsResolverUrl
    ) {
        $this->responseFactory = $responseFactory;
        $this->retentionController = $retentionController;
        $this->retentionSmsResolverUrl = $retentionSmsResolverUrl;
    }

    public function getResponse(Request $request): ResponseInterface
    {
        if (true === $request->isUriStartingWith($this->retentionSmsResolverUrl) &&
            true === $request->isPost()
        ) {
            return $this->retentionController->smsResolver($request);
        }

        return $this->getNotFoundResponse();
    }

    private function getNotFoundResponse(): ResponseInterface
    {
        return $this->responseFactory->createJsonResponse(
            ResponseInterface::CODE_NOT_FOUND,
            [
                'message' => 'Route not found',
            ]
        );
    }
}
