<?php
declare(strict_types=1);

namespace Tests;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use ScoreBoard\Board;
use ScoreBoard\ValueObject\TeamsPair;

final class BoardTest extends TestCase
{
    public function testInit(): void
    {
        $class = new Board(new ArrayCollection());

        $this->assertInstanceOf(Board::class, $class);
    }

    public function testStartGame(): void
    {
        $class = new Board(new ArrayCollection());

        $class->startGame(new TeamsPair('Mexico', 'Canada'));
    }
}
