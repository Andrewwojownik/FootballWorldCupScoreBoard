<?php
declare(strict_types=1);

namespace Tests\Entity;

use PHPUnit\Framework\TestCase;
use ScoreBoard\Contracts\Entity;
use ScoreBoard\Entity\Game;
use ScoreBoard\ValueObject\ScoresPair;
use ScoreBoard\ValueObject\TeamsPair;

final class GameTest extends TestCase
{
    public function testInit(): void
    {
        $class = new Game(
            new TeamsPair('Mexico', 'Canada'),
            new ScoresPair(0, 0),
        );

        $this->assertTrue($class->getTeams()->isEqual(
            new TeamsPair('Mexico', 'Canada'))
        );
        $this->assertEquals(new ScoresPair(0, 0), $class->getScore());
        $this->assertInstanceOf(Entity::class, $class);
    }

    public function testWithDifferentScore(): void
    {
        $class = new Game(
            new TeamsPair('Mexico', 'Canada'),
            new ScoresPair(3, 2),
        );

        $this->assertTrue($class->getTeams()->isEqual(
            new TeamsPair('Mexico', 'Canada'))
        );
        $this->assertEquals(new ScoresPair(3, 2), $class->getScore());
        $this->assertInstanceOf(Entity::class, $class);
    }
}
