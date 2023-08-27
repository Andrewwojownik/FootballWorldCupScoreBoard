<?php
declare(strict_types=1);

namespace ScoreBoard\Entity;

use ScoreBoard\Contracts\Entity;
use ScoreBoard\ValueObject\ScoresPair;
use ScoreBoard\ValueObject\TeamsPair;

final class Game implements Entity
{
    public function __construct(
        private readonly TeamsPair $teams,
        private readonly ScoresPair $score,
    )
    {
    }

    public function getTeams(): TeamsPair
    {
        return $this->teams;
    }

    public function getScore(): ScoresPair
    {
        return $this->score;
    }

}
