<?php
declare(strict_types=1);


namespace Application\Request;

use Application\Request\Exception\EmptyRequestUriException;
use Application\Request\Exception\UnsupportedMethodException;

final class Request
{
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';
    private const ACCEPTED_METHODS = [
        self::METHOD_POST,
        self::METHOD_GET,
    ];
    /**
     * @var string
     */
    private $requestMethod;
    /**
     * @var string
     */
    private $requestUri;

    public function __construct(
        string $requestMethod,
        string $requestUri
    ) {
        if (false === in_array(
            $requestMethod,
            self::ACCEPTED_METHODS
        )) {
            throw new UnsupportedMethodException($requestMethod);
        }
        if (true === empty($requestUri)) {
            throw new EmptyRequestUriException();
        }

        $this->requestMethod = $requestMethod;
        $this->requestUri = $requestUri;
    }

    public function isPost(): bool
    {
        return $this->requestMethod === self::METHOD_POST;
    }

    public function isUriStartingWith(string $URI): bool
    {
        return 0 === stripos($this->requestUri, $URI);
    }
}
