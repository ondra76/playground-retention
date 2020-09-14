<?php
declare(strict_types=1);


namespace Model\Retention;

final class UserAction
{
    public const ACTION_SMS = 'SMS';
    public const ACTION_NONE = 'NONE';
    private const ACTIONS_ALLOWED = [
        self::ACTION_SMS,
        self::ACTION_NONE,
    ];
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $action;

    public function __construct(
        User $user,
        string $action
    ) {
        if (false === in_array($action, self::ACTIONS_ALLOWED)) {
            throw new \InvalidArgumentException("Action ({$action}) is not recognized.");
        }

        $this->user = $user;
        $this->action = $action;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return array_merge(
            $this->user->toArray(),
            [
                'action' => $this->action,
            ]
        );
    }

    public function getAction(): string
    {
        return $this->action;
    }
}
