<?php
declare(strict_types=1);

namespace ScoreBoard;

use Doctrine\Common\Collections\Collection;
use ScoreBoard\Entity\Game;
use ScoreBoard\ValueObject\ScoresPair;
use ScoreBoard\ValueObject\TeamsPair;

final class Board
{

    public function __construct(
        /**
         * @var Collection<int, Game>
         */
        private readonly Collection $board,
    )
    {
    }

    public function startGame(Game $game): void
    {
        if ($this->getGame($game->getTeams())) {
            throw new \DomainException('Game for this teams already started!');
        }

        $this->board->add($game);
    }

    public function updateGameScore(TeamsPair $teamsPair, ScoresPair $scoresPair): void
    {
        /**
         * @var Game $game
         */
        foreach ($this->board as $key => $game) {
            if ($game->getTeams()->isEqual($teamsPair)) {
                $this->board->remove($key);
                $this->board->add(new Game($teamsPair, $scoresPair));
                return;
            }
        }

        throw new \DomainException('Can\'t update score for non exists teams!');
    }

    public function getGame(TeamsPair $teamsPair): ?Game
    {
        return $this->board->findFirst(function (int $key, Game $game) use ($teamsPair): bool {
            return $game->getTeams()->isEqual($teamsPair);
        });
    }

    public function finishGame(TeamsPair $teamsPair): void
    {
        /**
         * @var Game $game
         */
        foreach ($this->board as $game) {
            if ($game->getTeams()->isEqual($teamsPair)) {
                $this->board->removeElement($game);
                return;
            }
        }

        throw new \DomainException('Can\'t finish non exists game!');
    }
}
