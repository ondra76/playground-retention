<?php


namespace Application\Response;

interface ResponseInterface
{
    public const CODE_OK = 200;
    public const CODE_UNAUTHORIZED = 401;
    public const CODE_NOT_FOUND = 404;
    public const CODE_INTERNAL_ERROR = 500;
    public const CODES_SUPPORTED = [
        self::CODE_OK,
        self::CODE_UNAUTHORIZED,
        self::CODE_NOT_FOUND,
        self::CODE_INTERNAL_ERROR,
    ];

    public function printAndExit(): void;
}
