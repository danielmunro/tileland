<?php

namespace TileLand\Tests\Tile\Visualizer;

use PHPUnit\Framework\TestCase;
use TileLand\Entity\Tile;
use TileLand\Enum\Terrain;
use TileLand\Tile\TileBuilder;
use TileLand\Tile\Visualizer\TileVisualization;
use TileLand\Tile\Visualizer\TileVisualizer;

class TileVisualizerTest extends TestCase
{
    public function testVisualizeSimpleGraph()
    {
        $width = 3;
        $height = 3;
        $tileBuilder = new TileBuilder(new Tile(Terrain::PLAINS()));
        $tile = $tileBuilder->generateGrid($width, $height);
        $visualizer = new TileVisualizer();
        $visualization = $visualizer->draw($tile);
        $expected = '';
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $expected .= TileVisualization::getTerrainVisualization(Terrain::PLAINS());
            }
            $expected .= "\n";
        }
        static::assertEquals($expected, (string)$visualization);
    }
}
