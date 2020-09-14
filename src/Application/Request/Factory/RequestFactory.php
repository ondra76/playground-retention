<?php
declare(strict_types=1);


namespace Application\Request\Factory;

use Application\Request\Exception\MissingServerKeyException;
use Application\Request\Request;

final class RequestFactory
{
    private const KEY_REQUEST_METHOD = 'REQUEST_METHOD';
    private const KEY_REQUEST_URI = 'REQUEST_URI';
    private const KEYS_REQUIRED = [
        self::KEY_REQUEST_METHOD,
        self::KEY_REQUEST_URI,
    ];

    /**
     * @param array<string,mixed> $serverVars
     */
    public function create($serverVars): Request
    {
        foreach (self::KEYS_REQUIRED as $key) {
            if (false === key_exists($key, $serverVars)) {
                throw new MissingServerKeyException($key);
            }
        }

        return new Request(
            $serverVars[self::KEY_REQUEST_METHOD],
            $serverVars[self::KEY_REQUEST_URI]
        );
    }
}
