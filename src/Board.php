<?php
declare(strict_types=1);

namespace ScoreBoard;

use Doctrine\Common\Collections\Collection;
use ScoreBoard\ValueObject\ScoresPair;
use ScoreBoard\ValueObject\TeamsPair;

final class Board
{

    public function __construct(
        private Collection $board,
    )
    {
    }

    public function startGame(TeamsPair $teamsPair)
    {
        $this->board->add([$teamsPair, new ScoresPair(0, 0)]);
    }
}
