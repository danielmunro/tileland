<?php
declare(strict_types=1);

namespace TileLand\Tile\Visualizer;

use TileLand\Direction\East;
use TileLand\Direction\South;
use TileLand\Direction\West;
use TileLand\Entity\Tile;

class TileVisualizer
{
    public function draw(Tile $tile, int $maxX = null, int $maxY = null): TileVisualization
    {
        $drawnX = 0;
        $drawnY = 0;
        $visualization = new TileVisualization();
        $drawing = true;
        if (null === $maxX) {
            $maxX = 1000;
        }
        if (null === $maxY) {
            $maxY = 1000;
        }
        while ($drawing) {
            $visualization->setTile($tile, $drawnX, $drawnY);
            $edge = $tile->getEdge(new East());
            if ($edge) {
                $tile = $edge->getToTile();
                if ($drawnX < $maxX) {
                    $drawnX++;
                    continue;
                }
            }
            $edge = $tile->getEdge(new South());
            if ($edge) {
                $tile = $this->firstCol($tile)->getEdge(new South())->getToTile();
                if ($drawnY < $maxY) {
                    $drawnX = 0;
                    $drawnY++;
                    continue;
                }
            }
            $drawing = false;
        }

        return $visualization;
    }

    protected function firstCol(Tile $tile): Tile
    {
        while ($tile->getEdge(new West())) {
            $tile = $tile->getEdge(new West())->getToTile();
        }

        return $tile;
    }
}
