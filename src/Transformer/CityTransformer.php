<?php
declare(strict_types=1);

namespace TileLand\Transformer;

use League\Fractal\TransformerAbstract;
use Symfony\Component\Routing\Generator\UrlGenerator;
use TileLand\Entity\City;

class CityTransformer extends TransformerAbstract
{
    protected $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function transform(City $city): array
    {
        return [
            'id' => $city->getId(),
            'population' => $city->getPopulation(),
            'links' => [
                'self' => ''
            ],
        ];
    }
}