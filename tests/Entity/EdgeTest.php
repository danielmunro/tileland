<?php

namespace TileLand\Tests\Entity;

use PHPUnit\Framework\TestCase;
use TileLand\Direction\East;
use TileLand\Direction\North;
use TileLand\Direction\Northeast;
use TileLand\Direction\Northwest;
use TileLand\Direction\South;
use TileLand\Direction\Southeast;
use TileLand\Direction\Southwest;
use TileLand\Direction\West;
use TileLand\Entity\Edge;
use TileLand\Entity\Tile;
use TileLand\Enum\Terrain;

class EdgeTest extends TestCase
{
    public function testIsDirection(): void
    {
        $edge = new Edge(
            new North(),
            new Tile(Terrain::PLAINS()),
            new Tile(Terrain::PLAINS())
        );
        $badDirections = [
            new Northeast(),
            new East(),
            new Southeast(),
            new South(),
            new Southwest(),
            new West(),
            new Northwest(),
        ];

        foreach ($badDirections as $direction) {
            static::assertFalse($edge->isDirection($direction));
        }
        static::assertTrue($edge->isDirection(new North()));
    }

    public function testFromTile(): void
    {
        $fromTile = new Tile(Terrain::PLAINS());
        $edge = new Edge(
            new North(),
            $fromTile,
            new Tile(Terrain::PLAINS())
        );
        static::assertEquals($fromTile, $edge->getFromTile());
    }

    public function testToTile(): void
    {
        $toTile = new Tile(Terrain::PLAINS());
        $edge = new Edge(
            new North(),
            new Tile(Terrain::PLAINS()),
            $toTile
        );
        static::assertEquals($toTile, $edge->getToTile());
    }
}
