<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Authentication\App\Resources\RefreshResource;
use Lightit\Authentication\Domain\Actions\RefreshAction;
use PHPOpenSourceSaver\JWTAuth\Factory as JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;

#[Group('auth')]
class RefreshController
{
    public function __invoke(JWTAuth $jwtAuth, JWT $jwt, RefreshAction $action): JsonResponse
    {
        $refreshDto = $action->execute($jwtAuth, $jwt);

        return RefreshResource::make($refreshDto)
            ->response();
    }
}
