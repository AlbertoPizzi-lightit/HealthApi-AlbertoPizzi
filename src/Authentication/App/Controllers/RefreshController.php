<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Authentication\App\Resources\RefreshResource;
use Lightit\Authentication\Domain\DataTransferObjects\RefreshRequestDto;
use PHPOpenSourceSaver\JWTAuth\Factory as JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;

#[Group('auth')]
class RefreshController
{
    public function __invoke(JWTAuth $jwtAuth, JWT $jwt): JsonResponse
    {
       $refreshRequestDto = $this->toDto($jwtAuth , $jwt);

        return RefreshResource::make($refreshRequestDto)
            ->response();
    }

    public function toDto(JWTAuth $jwtAuth, JWT $jwt) : RefreshRequestDto{
        return new RefreshRequestDto(
            $jwtAuth,
            $jwt
        );
    }
}
