<?php
declare(strict_types=1);


namespace Application\Request\Authentication;

final class BasicRequestAuthenticationResolver
{
    private const VARS_KEY_USER = 'PHP_AUTH_USER';
    private const VARS_KEY_PASSWORD = 'PHP_AUTH_PW';
    private const REQUIRED_VARS_KEYS = [
        self::VARS_KEY_PASSWORD,
        self::VARS_KEY_USER,
    ];


    /**
     * @param array<string,mixed> $serverVars
     */
    public function isAuthenticated(array $serverVars, string $username, string $password): bool
    {
        foreach (self::REQUIRED_VARS_KEYS as $varsKey) {
            if (true === empty($serverVars[$varsKey])) {
                return false;
            }
        }

        return $serverVars[self::VARS_KEY_USER] === $username &&
            $serverVars[self::VARS_KEY_PASSWORD] === $password;
    }
}
