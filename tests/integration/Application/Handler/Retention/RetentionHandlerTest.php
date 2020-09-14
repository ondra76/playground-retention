<?php

namespace Tests\Integration\Application\Handler\Retention;

use Application\Handler\Retention\RetentionHandler;
use Domain\Retention\Logger\RetentionActionLoggerInterface;
use Domain\Retention\Resolver\RetentionResolver;
use Infrastructure\Retention\Parser\UserFileParser;
use PHPUnit\Framework\TestCase;

class RetentionHandlerTest extends TestCase
{
    /**
     * @var RetentionHandlerTest
     */
    protected $handler;

    /**
     * @var string
     */
    protected $filePath;

    protected function setUp()
    {
        $this->handler = new RetentionHandler(
            new UserFileParser(),
            new RetentionResolver(
                $this->createMock(RetentionActionLoggerInterface::class)
            )
        );
        $this->filePath = \tempnam(\sys_get_temp_dir(), 'CSV');
    }

    public function testHandle()
    {
        $data = <<<EOT
ANABELA,500,1.8.2020
BRETISLAV,100,1.6.2019
EOT;
        \file_put_contents($this->filePath, $data);
        $result = $this->handler->handle($this->filePath);
        $this->assertSame(
            [
                [
                    'name' => 'ANABELA',
                    'credit' => 500,
                    'lastTopUpDate' => '01.08.2020',
                    'action' => 'NONE',
                ],
                [
                    'name' => 'BRETISLAV',
                    'credit' => 100,
                    'lastTopUpDate' => '01.06.2019',
                    'action' => 'SMS',
                ],
            ],
            $result
        );
    }
}
