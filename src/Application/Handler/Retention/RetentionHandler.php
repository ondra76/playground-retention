<?php
declare(strict_types=1);


namespace Application\Handler\Retention;

use Domain\Retention\Resolver\RetentionResolver;
use Infrastructure\Retention\Parser\UserFileParser;

final class RetentionHandler
{

    /**
     * @var UserFileParser
     */
    private $fileParser;
    /**
     * @var RetentionResolver
     */
    private $resolver;

    public function __construct(
        UserFileParser $fileParser,
        RetentionResolver $resolver
    ) {
        $this->fileParser = $fileParser;
        $this->resolver = $resolver;
    }


    /**
     * @return array<int, array<string, mixed>>
     */
    public function handle(string $csvFilePath): array
    {
        $parsedUsers = $this->fileParser->parseUserCsv($csvFilePath);
        $resolvedUsers = [];
        foreach ($parsedUsers as $parsedUser) {
            $resolvedUsers[] = $this->resolver->resolve($parsedUser);
        }

        $resolvedUserData = [];
        foreach ($resolvedUsers as $resolvedUser) {
            $resolvedUserData[] = $resolvedUser->toArray();
        }

        return $resolvedUserData;
    }
}
