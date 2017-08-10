<?php
declare(strict_types=1);

namespace TileLand\Silex\View;

use function Functional\with;
use League\Fractal\Manager;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Serializer\DataArraySerializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JsonView
{
    public function __invoke(ResourceAbstract $resource, Request $request): JsonResponse
    {
        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        with(
            $request->get('include'),
            function (string $include) use ($manager) {
                $manager->parseIncludes($include);
            }
        );

        return new JsonResponse(
            $manager->createData($resource)->toArray()
        );
    }
}
