<?php

namespace Tests\UnitDomain\Retention\Resolver;

use Domain\Retention\Logger\RetentionActionLoggerInterface;
use Domain\Retention\Resolver\RetentionResolver;
use Model\Retention\User;
use Model\Retention\UserAction;
use PHPUnit\Framework\TestCase;

class RetentionResolverTest extends TestCase
{
    public function testResolveRule1Sms()
    {
        $this->processRuleTests(
            new User(
                'Franklin',
                199,
                new \DateTimeImmutable('-1 week')
            ),
            UserAction::ACTION_SMS
        );
    }

    public function testResolveRule1None()
    {
        $this->processRuleTests(
            new User(
                'Joshua',
                200,
                new \DateTimeImmutable('-3 months')
            ),
            UserAction::ACTION_NONE
        );
    }

    public function testResolveRule2Sms()
    {
        $this->processRuleTests(
            new User(
                'Franklin',
                2000,
                new \DateTimeImmutable('-6 months')
            ),
            UserAction::ACTION_SMS
        );
    }

    public function testResolveRule2None()
    {
        $this->processRuleTests(
            new User(
                'Joshua',
                2000,
                new \DateTimeImmutable('-4 months')
            ),
            UserAction::ACTION_NONE
        );
    }

    public function testResolveRule3Sms()
    {
        $this->processRuleTests(
            new User(
                'Franklin',
                300,
                new \DateTimeImmutable('-1 month')
            ),
            UserAction::ACTION_SMS
        );
    }

    public function testResolveRule3NoneBecauseDate()
    {
        $this->processRuleTests(
            new User(
                'Joshua',
                300,
                new \DateTimeImmutable('-3months')
            ),
            UserAction::ACTION_NONE
        );

    }

    public function testResolveRule3NoneBecauseAmount()
    {
        $this->processRuleTests(
            new User(
                'Joshua',
                301,
                new \DateTimeImmutable('-1 month')
            ),
            UserAction::ACTION_NONE
        );
    }

    private function processRuleTests(
        User $user,
        string $expectedAction
    ) {
        $logger = $this->createMock(RetentionActionLoggerInterface::class);
        $logger->expects($this->once())
            ->method('logAction')
            ->with(new UserAction($user, $expectedAction));
        $resolver = new RetentionResolver($logger);
        $resolvedUser = $resolver->resolve($user);
        $this->assertSame($expectedAction, $resolvedUser->getAction());
    }
}
