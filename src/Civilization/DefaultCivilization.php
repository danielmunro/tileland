<?php
declare(strict_types=1);

namespace TileLand\Civilization;

use TileLand\Entity\Building;
use TileLand\Entity\Unit;
use TileLand\Entity\UnitAttributes;
use TileLand\Enum\UnitType;
use TileLand\Unit\Worker;

abstract class DefaultCivilization implements Civilization
{
    public function createBuildingEntity(\TileLand\City\Building\Building $building): Building
    {
        return $building->createEntityForCivilization($this);
    }

    public function createUnitEntity(\TileLand\Unit\Unit $unit): Unit
    {
        /**
         * @todo apply same pattern as $this->createBuildingEntity()
         */
        switch (get_class($unit)) {
            case Worker::class:
                return new Unit(
                    UnitType::WORKER(),
                    new UnitAttributes(
                        10,
                        1,
                        0,
                        0,
                        '0'
                    )
                );
            default:
                throw new \RuntimeException('not implemented');
        }
    }
}
