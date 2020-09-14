<?php
declare(strict_types=1);


namespace Model\Retention;

final class User
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $credit;
    /**
     * @var \DateTimeImmutable
     */
    private $lastTopUpDate;

    public function __construct(
        string $name,
        int $credit,
        \DateTimeImmutable $lastTopUpDate
    ) {
        $this->name = $name;
        $this->credit = $credit;
        $this->lastTopUpDate = $lastTopUpDate;
    }

    public function getCredit(): int
    {
        return $this->credit;
    }

    public function getLastTopUpDate(): \DateTimeImmutable
    {
        return $this->lastTopUpDate;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'credit' => $this->credit,
            'lastTopUpDate' => $this->lastTopUpDate->format('d.m.Y'),
        ];
    }
}
