<?php
declare(strict_types=1);

namespace ScoreBoard\ValueObject;

use ScoreBoard\Contracts\ValueObject;

final class ScoresPair implements ValueObject
{

    public function __construct(
        private readonly int $home,
        private readonly int $away,
    )
    {
        $this->guard();
    }

    private function guard(): void
    {
        if ($this->home < 0) {
            throw new \DomainException('Score can not be lower than 0 for home team');
        }

        if ($this->away < 0) {
            throw new \DomainException('Score can not be lower than 0 for away team');
        }
    }

    public function getHome(): int
    {
        return $this->home;
    }

    public function getAway(): int
    {
        return $this->away;
    }

    public function getTotalScore(): int
    {
        return $this->home + $this->away;
    }

}
