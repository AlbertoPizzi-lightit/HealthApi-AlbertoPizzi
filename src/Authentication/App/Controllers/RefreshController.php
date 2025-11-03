<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Factory as JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;

#[Group('auth')]
class RefreshController
{
    public function __invoke(JWTAuth $jwtAuth, JWT $jwt): JsonResponse
    {
        return response()->json([
            'data' => [
                'access_token' => $jwt->refresh(),
                'token_type' => 'Bearer',
                'expires_in' => $jwtAuth->getTTL() * 60,
            ],
        ]);
    }
}
