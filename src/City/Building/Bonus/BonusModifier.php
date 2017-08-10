<?php
declare(strict_types=1);

namespace TileLand\City\Building\Bonus;

function bonusModifier(int $baseAmount): int
{
    return min(
        1,
        (int) floor($baseAmount * 1.5)
    );
}

function reductionModifier(int $baseAmount): int
{
    return min(
        1,
        (int) floor($baseAmount * 0.5)
    );
}
