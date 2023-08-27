<?php
declare(strict_types=1);

namespace Tests\ValueObject;

use PHPUnit\Framework\TestCase;
use ScoreBoard\ValueObject\TeamsPair;

final class TeamsPairTest extends TestCase
{
    public function testInit(): void
    {
        $class = new TeamsPair('Mexico', 'Canada');

        $this->assertEquals('Mexico', $class->getHome());
        $this->assertEquals('Canada', $class->getAway());
    }
}
