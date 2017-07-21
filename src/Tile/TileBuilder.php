<?php
declare(strict_types=1);

namespace TileLand\Tile;

use TileLand\Direction\Direction;
use TileLand\Direction\East;
use TileLand\Direction\South;
use TileLand\Direction\Southeast;
use TileLand\Direction\Southwest;
use TileLand\Entity\Edge;
use TileLand\Entity\Tile;
use TileLand\Enum\Terrain;

class TileBuilder
{
    /**
     * @var Tile
     */
    protected $tile;

    public function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }

    public function connect(Direction $direction, Tile $toTile): Tile
    {
        return static::connectTiles($direction, $this->tile, $toTile);
    }

    public function generateGrid(int $width, int $height): Tile
    {
        $x = 0;
        $y = 0;
        $grid = [[$this->tile]];
        $looping = true;

        while ($looping) {
            if (!isset($grid[$x])) {
                $grid[$x] = [];
            }
            if (!isset($grid[$x][$y])) {
                $grid[$x][$y] = new Tile(Terrain::PLAINS());
            }
            $x++;
            if ($x > $width - 1) {
                $x = 0;
                $y++;
                if ($y > $height - 1) {
                    $looping = false;
                }
            }
        }

        $x = 0;
        $y = 0;
        $looping = true;

        while ($looping) {
            if (isset($grid[$x+1][$y])) {
                static::connectTiles(new East(), $grid[$x][$y], $grid[$x+1][$y]);
            }
            if (isset($grid[$x+1][$y+1])) {
                static::connectTiles(new Southeast(), $grid[$x][$y], $grid[$x+1][$y+1]);
            }
            if (isset($grid[$x-1][$y+1])) {
                static::connectTiles(new Southwest(), $grid[$x][$y], $grid[$x-1][$y+1]);
            }
            if (isset($grid[$x][$y+1])) {
                static::connectTiles(new South(), $grid[$x][$y], $grid[$x][$y+1]);
            }
            $x++;
            if ($x > $width - 1) {
                $x = 0;
                $y++;
                if ($y > $height - 1) {
                    $looping = false;
                }
            }
        }

        return $this->tile;
    }

    public static function connectTiles(Direction $direction, Tile $fromTile, Tile $toTile): Tile
    {
        $fromTile->addEdge(new Edge($direction, $fromTile, $toTile));
        $toTile->addEdge(new Edge($direction->getReverse(), $toTile, $fromTile));

        return $fromTile;
    }
}
