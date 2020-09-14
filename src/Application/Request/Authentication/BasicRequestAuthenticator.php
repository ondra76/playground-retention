<?php
declare(strict_types=1);


namespace Application\Request\Authentication;

final class BasicRequestAuthenticator
{

    /**
     * @var BasicRequestAuthenticationResolver
     */
    private $resolver;

    public function __construct(BasicRequestAuthenticationResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param array<string,mixed> $serverVars
     */
    public function authenticateOrExit(
        array $serverVars,
        string $username,
        string $password
    ): void {
        if (true === $this->resolver->isAuthenticated(
            $serverVars,
            $username,
            $password
        )) {
            return;
        }
        header('WWW-Authenticate: Basic realm="Protected area"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Authentication failed';
        exit;
    }
}
