<?php

namespace Tests\Integration\Infrastructure\Retention\Logger;

use Infrastructure\Retention\Logger\RetentionActionLogger;
use Model\Retention\User;
use Model\Retention\UserAction;
use PHPUnit\Framework\TestCase;

class RetentionActionLoggerTest extends TestCase
{
    /**
     * @var string
     */
    protected $fileSmsAction;
    /**
     * @var string
     */
    protected $fileNoneAction;
    /**
     * @var RetentionActionLogger
     */
    protected $logger;


    protected function setUp()
    {
        $this->fileSmsAction = \tempnam(\sys_get_temp_dir(), 'SMS');
        $this->fileNoneAction = \tempnam(\sys_get_temp_dir(), 'NONE');
        $this->logger = new RetentionActionLogger(
            $this->fileSmsAction,
            $this->fileNoneAction
        );

    }

    public function testLogOneSms()
    {
        $this->logger
            ->logAction($this->createUserAction(UserAction::ACTION_SMS));
        $this->assertSame('1', \file_get_contents($this->fileSmsAction));
    }

    public function testLogTwoSms()
    {
        $this->logger
            ->logAction($this->createUserAction(UserAction::ACTION_SMS));
        $this->logger
            ->logAction($this->createUserAction(UserAction::ACTION_SMS));
        $this->assertSame('2', \file_get_contents($this->fileSmsAction));
    }

    public function testLogOneNone()
    {
        $this->logger
            ->logAction($this->createUserAction(UserAction::ACTION_NONE));
        $this->assertSame('1', \file_get_contents($this->fileNoneAction));
    }

    public function testLogTwoNone()
    {
        $this->logger
            ->logAction($this->createUserAction(UserAction::ACTION_NONE));
        $this->logger
            ->logAction($this->createUserAction(UserAction::ACTION_NONE));
        $this->assertSame('2', \file_get_contents($this->fileNoneAction));
    }

    private function createUserAction(string $action): UserAction
    {
        return new UserAction(
            new User(
                'Josh',
                200,
                new \DateTimeImmutable()
            ),
            $action
        );
    }
}
