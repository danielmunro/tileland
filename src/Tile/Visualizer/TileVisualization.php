<?php
declare(strict_types=1);

namespace TileLand\Tile\Visualizer;

use function Functional\reduce_left;
use TileLand\Entity\Tile;
use TileLand\Enum\Terrain;

class TileVisualization
{
    protected $vis = [];

    public function setTile(Tile $tile, int $x, int $y): void
    {
        if (!isset($this->vis[$x])) {
            $this->vis[$x] = [];
        }

        $this->vis[$x][$y] = self::getTerrainVisualization($tile->getTerrain());
    }

    public static function getTerrainVisualization(Terrain $terrain): string
    {
        switch ($terrain->getValue()) {
            case Terrain::PLAINS:
                return '.';
            case Terrain::MOUNTAINS:
                return '^';
            case Terrain::HILLS:
                return 'n';
            case Terrain::DESERT:
                return '%';
            case Terrain::OCEAN:
                return '~';
            case Terrain::RIVER:
                return '*';
            default:
                return '?';
        }
    }

    public function __toString()
    {
        return (string) reduce_left(
            $this->vis,
            function ($x, int $i, array $collection, string $initial) {
                return $initial.reduce_left(
                    $x,
                    function (string $y, int $i, array $collection, string $initial) {
                        return $initial.$y;
                    },
                    ''
                )."\n";
            },
            ''
        );
    }
}
