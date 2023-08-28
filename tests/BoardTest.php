<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use ScoreBoard\Board;
use ScoreBoard\Entity\Game;
use ScoreBoard\ValueObject\ScoresPair;
use ScoreBoard\ValueObject\TeamsPair;

final class BoardTest extends TestCase
{
    public function testInit(): void
    {
        $class = new Board(new \Ds\Vector());

        $this->assertInstanceOf(Board::class, $class);
    }

    public function testStartGame(): void
    {
        $class = new Board(new \Ds\Vector());
        $team = new TeamsPair('Mexico', 'Canada');
        $game = new Game(
            $team,
            new ScoresPair(0, 0),
        );

        $class->startGame($game);
        $findGame = $class->getGame($team);

        $this->assertEquals($game, $findGame);
    }

    public function testUpdateScoreForNonExistsGame(): void
    {
        $class = new Board(new \Ds\Vector());
        $game = new TeamsPair('Mexico', 'Canada');
        $newScore = new ScoresPair(1, 0);

        $this->expectException(\DomainException::class);

        $class->updateGameScore($game, $newScore);
    }

    public function testGetExistsGame(): void
    {
        $class = new Board(new \Ds\Vector());
        $team = new TeamsPair('Mexico', 'Canada');
        $game = new Game(
            $team,
            new ScoresPair(0, 0),
        );

        $class->startGame($game);
        $findGame = $class->getGame($team);

        $this->assertEquals($game, $findGame);
    }

    public function testAddThisSameGameTwice(): void
    {
        $class = new Board(new \Ds\Vector());
        $team = new TeamsPair('Mexico', 'Canada');
        $game = new Game(
            $team,
            new ScoresPair(0, 0),
        );

        $this->expectException(\DomainException::class);

        $class->startGame($game);
        $class->startGame($game);
    }

    public function testFinishGame(): void
    {
        $class = new Board(new \Ds\Vector());
        $team = new TeamsPair('Mexico', 'Canada');
        $game = new Game(
            $team,
            new ScoresPair(0, 0),
        );

        $class->startGame($game);

        $class->finishGame($team);
    }

    public function testFinishNonExistsGame(): void
    {
        $class = new Board(new \Ds\Vector());
        $team = new TeamsPair('Mexico', 'Canada');

        $this->expectException(\DomainException::class);

        $class->finishGame($team);
    }

    public function testUpdateScore(): void
    {
        $class = new Board(new \Ds\Vector());
        $team = new TeamsPair('Mexico', 'Canada');
        $game = new Game(
            $team,
            new ScoresPair(0, 0),
        );
        $newScore = new ScoresPair(3, 2);
        $gameAfterChange = new Game(
            $team,
            $newScore,
        );

        $class->startGame($game);
        $class->updateGameScore($team, $newScore);
        $findGame = $class->getGame($team);

        $this->assertEquals($gameAfterChange, $findGame);
    }

    public function testGetSortedBoard(): void
    {
        $class = new Board(new \Ds\Vector());
        $game1 = new Game(
            new TeamsPair('Mexico', 'Canada'),
            new ScoresPair(0, 2),
        );
        $game2 = new Game(
            new TeamsPair('France', 'Poland'),
            new ScoresPair(0, 2),
        );
        $game3 = new Game(
            new TeamsPair('Spain', 'Portugal'),
            new ScoresPair(4, 2),
        );
        $game4 = new Game(
            new TeamsPair('Japan', 'Grece'),
            new ScoresPair(3, 2),
        );

        $class->startGame($game1);
        $class->startGame($game2);
        $class->startGame($game3);
        $class->startGame($game4);
        $sorted = $class->getSortedBoard();

        $this->assertTrue($sorted[0]->getTeams()->isEqual(new TeamsPair('Spain', 'Portugal')));
        $this->assertTrue($sorted[1]->getTeams()->isEqual(new TeamsPair('Japan', 'Grece')));
        $this->assertTrue($sorted[2]->getTeams()->isEqual(new TeamsPair('Mexico', 'Canada')));
        $this->assertTrue($sorted[3]->getTeams()->isEqual(new TeamsPair('France', 'Poland')));
    }
}
