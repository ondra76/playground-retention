<?php
declare(strict_types=1);


namespace Application\Request;

use Application\Request\Exception\EmptyRequestUriException;
use Application\Request\Exception\MissingPostFilePathException;
use Application\Request\Exception\UnsupportedMethodException;

final class Request
{
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';
    private const ACCEPTED_METHODS = [
        self::METHOD_POST,
        self::METHOD_GET,
    ];
    private const PATH_FIELD_NAME = 'tmp_name';
    /**
     * @var string
     */
    private $requestMethod;
    /**
     * @var string
     */
    private $requestUri;

    /**
     * @var array<string,array>
     */
    private $files;

    /**
     * @param array<string,array> $files
     */
    public function __construct(
        string $requestMethod,
        string $requestUri,
        array $files
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
        $this->files = $files;
    }

    public function isPost(): bool
    {
        return $this->requestMethod === self::METHOD_POST;
    }

    public function isUriStartingWith(string $URI): bool
    {
        return 0 === stripos($this->requestUri, $URI);
    }

    public function getPostFilePath(string $formFieldName): string
    {
        if (false === isset($this->files[$formFieldName][self::PATH_FIELD_NAME])) {
            throw new MissingPostFilePathException($formFieldName);
        }
        return $this->files[$formFieldName][self::PATH_FIELD_NAME];
    }
}
