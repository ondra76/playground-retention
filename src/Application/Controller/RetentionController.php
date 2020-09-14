<?php
declare(strict_types=1);


namespace Application\Controller;

use Application\Handler\Retention\RetentionHandler;
use Application\Request\Request;
use Application\Response\Factory\ResponseFactory;
use Application\Response\ResponseInterface;

final class RetentionController
{

    /**
     * @var string
     */
    private $resolverFormField;
    /**
     * @var ResponseFactory
     */
    private $responseFactory;
    /**
     * @var RetentionHandler
     */
    private $retentionHandler;

    public function __construct(
        string $resolverFormField,
        ResponseFactory $responseFactory,
        RetentionHandler $retentionHandler
    ) {
        $this->resolverFormField = $resolverFormField;
        $this->responseFactory = $responseFactory;
        $this->retentionHandler = $retentionHandler;
    }

    public function smsResolver(Request $request): ResponseInterface
    {

        try {
            return $this->responseFactory->createJsonResponse(
                ResponseInterface::CODE_OK,
                $this->retentionHandler->handle(
                    $request->getPostFilePath($this->resolverFormField)
                )
            );
        } catch (\Throwable $exception) {
            return $this->responseFactory->createJsonResponse(
                ResponseInterface::CODE_INTERNAL_ERROR,
                [
                    'Exception' => get_class($exception),
                    'Message' => $exception->getMessage(),
                ]
            );
        }
    }
}
