<?php
declare(strict_types=1);


namespace Domain\Retention\Resolver;

use Domain\Retention\Logger\RetentionActionLoggerInterface;
use Model\Retention\User;
use Model\Retention\UserAction;

final class RetentionResolver
{
    /**
     * @var RetentionActionLoggerInterface
     */
    private $actionLogger;

    public function __construct(RetentionActionLoggerInterface $actionLogger)
    {
        $this->actionLogger = $actionLogger;
    }

    public function resolve(User $user): UserAction
    {
        $action = $this->getAction($user);

        $actionDto = new UserAction(
            $user,
            $action
        );
        $this->actionLogger->logAction($actionDto);

        return $actionDto;
    }

    private function getAction(User $user): string
    {

        if ($user->getCredit() < 200) {
            return UserAction::ACTION_SMS;
        }
        if ($user->getLastTopUpDate() < new \DateTimeImmutable('-5 months')) {
            return UserAction::ACTION_SMS;
        }
        if ($user->getCredit() <= 300 &&
            $user->getLastTopUpDate() > new \DateTimeImmutable('-2 months')
        ) {
            return UserAction::ACTION_SMS;
        }

        return UserAction::ACTION_NONE;
    }
}
