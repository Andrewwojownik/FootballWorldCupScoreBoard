<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ScoreBoard\Board;
use ScoreBoard\Entity\Game;
use ScoreBoard\ValueObject\ScoresPair;
use ScoreBoard\ValueObject\TeamsPair;

final class BoardFunctionalTest extends TestCase
{
    public function testFullBoard(): void
    {
        $board = new Board(new \Ds\Vector());
        $games = [
            new Game(
                new TeamsPair('Mexico', 'Canada'),
                new ScoresPair(0, 0),
            ),
            new Game(
                new TeamsPair('Spain', 'Brazil'),
                new ScoresPair(0, 0),
            ),
            new Game(
                new TeamsPair('Germany', 'France'),
                new ScoresPair(0, 0),
            ),
            new Game(
                new TeamsPair('Uruguay', 'Italy'),
                new ScoresPair(0, 0),
            ),
            new Game(
                new TeamsPair('Argentina', 'Australia'),
                new ScoresPair(0, 0),
            ),
        ];

        foreach ($games as $game) {
            $board->startGame($game);
        }

        foreach ($games as $game) {
            $currentGame = $board->getGame($game->getTeams());
            $this->assertNotNull($currentGame);
            $this->assertEquals(0, $currentGame->getScore()->getHome());
            $this->assertEquals(0, $currentGame->getScore()->getAway());
        }

        $updatedGames = $games = [
            new Game(
                new TeamsPair('Mexico', 'Canada'),
                new ScoresPair(0, 5),
            ),
            new Game(
                new TeamsPair('Spain', 'Brazil'),
                new ScoresPair(10, 2),
            ),
            new Game(
                new TeamsPair('Germany', 'France'),
                new ScoresPair(2, 2),
            ),
            new Game(
                new TeamsPair('Uruguay', 'Italy'),
                new ScoresPair(6, 6),
            ),
            new Game(
                new TeamsPair('Argentina', 'Australia'),
                new ScoresPair(3, 1),
            ),
        ];

        foreach ($updatedGames as $game) {
            $board->updateGameScore($game->getTeams(), $game->getScore());
        }

        foreach ($updatedGames as $game) {
            $currentGame = $board->getGame($game->getTeams());
            $this->assertNotNull($currentGame);
            $this->assertEquals($game->getScore()->getHome(), $currentGame->getScore()->getHome());
            $this->assertEquals($game->getScore()->getAway(), $currentGame->getScore()->getAway());
        }
    }
}
