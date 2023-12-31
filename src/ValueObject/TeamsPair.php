<?php
declare(strict_types=1);

namespace ScoreBoard\ValueObject;

use ScoreBoard\Contracts\ValueObject;

final class TeamsPair implements ValueObject
{

    public function __construct(
        private readonly string $home,
        private readonly string $away,
    )
    {
        $this->guard();
    }

    private function guard(): void
    {
        if ($this->home == '') {
            throw new \DomainException('Name can not be empty for home team');
        }

        if ($this->away == '') {
            throw new \DomainException('Name can not be empty for away team');
        }
    }

    public function getHome(): string
    {
        return $this->home;
    }

    public function getAway(): string
    {
        return $this->away;
    }

    public function isEqual(TeamsPair $teamsPair): bool
    {
        if ($teamsPair->getHome() === $this->getHome() && $teamsPair->getAway() === $this->getAway()) {
            return true;
        }

        return false;
    }
}
