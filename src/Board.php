<?php
declare(strict_types=1);

namespace ScoreBoard;

use ScoreBoard\Entity\Game;
use ScoreBoard\ValueObject\ScoresPair;
use ScoreBoard\ValueObject\TeamsPair;

final class Board
{

    public function __construct(
        private readonly \Ds\Vector $board,
    )
    {
    }

    public function startGame(Game $game): void
    {
        $gameIndex = null;
        try {
            $gameIndex = $this->getGameIndex($game->getTeams());
        } catch (\DomainException $e) {
        }

        if (null !== $gameIndex) {
            throw new \DomainException('Game for this teams already started!');
        }

        $this->board->push($game);
    }

    public function updateGameScore(TeamsPair $teamsPair, ScoresPair $scoresPair): void
    {
        $gameIndex = $this->getGameIndex($teamsPair);

        $this->board->set($gameIndex, new Game($teamsPair, $scoresPair));
    }

    private function getGameIndex(TeamsPair $teamsPair): int
    {
        $gameIndex = null;

        /**
         * @var $game Game
         */
        foreach ($this->board as $key => $game) {
            if ($game->getTeams()->isEqual($teamsPair)) {
                $gameIndex = $key;
                break;
            }
        }

        if (null === $gameIndex) {
            throw new \DomainException('Can\'t get non exists game!');
        }

        return $gameIndex;
    }

    public function getGame(TeamsPair $teamsPair): Game
    {
        $gameIndex = $this->getGameIndex($teamsPair);
        return $this->board->get($gameIndex);
    }

    public function finishGame(TeamsPair $teamsPair): void
    {
        $gameIndex = $this->getGameIndex($teamsPair);

        $this->board->remove($gameIndex);
    }
}
