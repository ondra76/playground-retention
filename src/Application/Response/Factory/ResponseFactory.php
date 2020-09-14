<?php
declare(strict_types=1);


namespace Application\Response\Factory;

use Application\Response\JsonResponse;
use Application\Response\ResponseInterface;

final class ResponseFactory
{
    /**
     * @param array<mixed,mixed> $data
     */
    public function createJsonResponse(int $code, array $data): ResponseInterface
    {
        return new JsonResponse($code, $data);
    }
}
