<?php

namespace TileLand\Tests\Tile;

use PHPUnit\Framework\TestCase;
use TileLand\Direction\North;
use TileLand\Direction\South;
use TileLand\Direction\Southeast;
use TileLand\Entity\Edge;
use TileLand\Entity\Tile;
use TileLand\Enum\Terrain;
use TileLand\Tile\TileBuilder;

class TileBuilderTest extends TestCase
{
    public function testConnect(): void
    {
        $tileBuilder = new TileBuilder(new Tile(Terrain::PLAINS()));
        $tile = $tileBuilder->connect(new South(), new Tile(Terrain::DESERT()));
        static::assertTrue($tile->isTerrain(Terrain::PLAINS()));
        static::assertCount(1, $tile->getEdges());
        $edge = $tile->getEdge(new South());
        static::assertInstanceOf(Edge::class, $edge);
        static::assertTrue($edge->getToTile()->isTerrain(Terrain::DESERT()));

        $tileBuilder->connect(new North(), new Tile(Terrain::HILLS()));
        static::assertCount(2, $tile->getEdges());
        $edge = $tile->getEdge(new North());
        static::assertInstanceOf(Edge::class, $edge);
        static::assertTrue($edge->getToTile()->isTerrain(Terrain::HILLS()));
    }

    public function testBuildGrid(): void
    {
        $tileBuilder = new TileBuilder(new Tile(Terrain::PLAINS()));
        $tile = $tileBuilder->generateGrid(10,10);
        static::assertCount(3, $tile->getEdges());
        $first = true;
        $edge = true;
        $traversals = 0;
        while($edge) {
            $edge = $tile->getEdge(new Southeast());
            if ($edge) {
                $traversals++;
                $tile = $edge->getToTile();
                if (!$first && $tile->getEdge(new Southeast())) {
                    static::assertCount(8, $tile->getEdges());
                }
                $first = false;
            }
        }
        static::assertEquals(9, $traversals);
    }
}