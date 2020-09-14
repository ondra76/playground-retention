<?php
declare(strict_types=1);


namespace Application\Router;

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

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function getResponse(Request $request): ResponseInterface
    {
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
