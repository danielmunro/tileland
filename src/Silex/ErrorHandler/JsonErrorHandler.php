<?php
declare(strict_types=1);

namespace TileLand\Silex\ErrorHandler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JsonErrorHandler
{
    public function __invoke(\Exception $e, Request $request, $code): JsonResponse
    {
        return new JsonResponse(
            ['message' => $e->getMessage()],
            $code
        );
    }
}
