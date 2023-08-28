<?php
declare(strict_types=1);

namespace Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use ScoreBoard\ValueObject\ScoresPair;

final class ScoresPairTest extends TestCase
{
    public function testInit(): void
    {
        $class = new ScoresPair(0, 1);

        $this->assertEquals(0, $class->getHome());
        $this->assertEquals(1, $class->getAway());
    }

    public function testGetTotalScore(): void
    {
        $class = new ScoresPair(3, 4);

        $this->assertEquals(7, $class->getTotalScore());
    }
}
