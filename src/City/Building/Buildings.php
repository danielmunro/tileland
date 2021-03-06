<?php
declare(strict_types=1);

namespace TileLand\City\Building;

interface Buildings
{
    /**
     * Culture production
     */
    const COMMONS = 'commons';

    /**
     * Food production
     */
    const GRANARY = 'granary';
    const AQUEDUCT = 'aqueduct';

    /**
     * Science production
     */
    const LIBRARY = 'library';

    /**
     * Faith production
     */
    const SHRINE = 'shrine';
    const MONUMENT = 'monument';

    /**
     * Gold production
     */
    const TRADING_POST = 'trading post';

    /**
     * Military/defense buildings
     */
    const BARRACKS = 'barracks';
    const OUTPOST = 'outpost';
    const WALLS = 'walls';

    /**
     * Test
     */
    const TEST_BUILDING = 'test building';
}
