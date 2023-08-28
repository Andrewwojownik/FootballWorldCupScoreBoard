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
        $games = $this->getGameBaseData();

        foreach ($games as $game) {
            $board->startGame($game);
        }

        foreach ($games as $game) {
            $currentGame = $board->getGame($game->getTeams());
            $this->assertNotNull($currentGame);
            $this->assertEquals(0, $currentGame->getScore()->getHome());
            $this->assertEquals(0, $currentGame->getScore()->getAway());
        }

        $updatedGames = $this->getUpdatedGameData();

        foreach ($updatedGames as $game) {
            $board->updateGameScore($game->getTeams(), $game->getScore());
        }

        foreach ($updatedGames as $game) {
            $currentGame = $board->getGame($game->getTeams());
            $this->assertNotNull($currentGame);
            $this->assertEquals($game->getScore()->getHome(), $currentGame->getScore()->getHome());
            $this->assertEquals($game->getScore()->getAway(), $currentGame->getScore()->getAway());
        }

        $finishedGames = $this->getFinishedGameData();

        foreach ($finishedGames as $game) {
            $board->updateGameScore($game->getTeams(), $game->getScore());
        }

        foreach ($finishedGames as $game) {
            $currentGame = $board->getGame($game->getTeams());
            $this->assertNotNull($currentGame);
            $this->assertEquals($game->getScore()->getHome(), $currentGame->getScore()->getHome());
            $this->assertEquals($game->getScore()->getAway(), $currentGame->getScore()->getAway());
        }
    }

    private function getGameBaseData(): array
    {
        return [
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
    }

    private function getUpdatedGameData(): array
    {
        return [
            new Game(
                new TeamsPair('Mexico', 'Canada'),
                new ScoresPair(0, 3),
            ),
            new Game(
                new TeamsPair('Spain', 'Brazil'),
                new ScoresPair(3, 1),
            ),
            new Game(
                new TeamsPair('Germany', 'France'),
                new ScoresPair(1, 1),
            ),
            new Game(
                new TeamsPair('Uruguay', 'Italy'),
                new ScoresPair(1, 0),
            ),
            new Game(
                new TeamsPair('Argentina', 'Australia'),
                new ScoresPair(2, 1),
            ),
        ];
    }

    private function getFinishedGameData(): array
    {
        return [
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
    }
}
