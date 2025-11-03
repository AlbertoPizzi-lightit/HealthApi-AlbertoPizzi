<?php

declare(strict_types=1);

namespace Lightit\Authentication\Domain\Actions;

use Lightit\Authentication\Domain\DataTransferObjects\RefreshRequestDto;
use PHPOpenSourceSaver\JWTAuth\Factory as JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;

class RefreshAction
{
    public function execute(JWTAuth $jwtAuth, JWT $jwt): RefreshRequestDto
    {
        return new RefreshRequestDto(
            $jwtAuth,
            $jwt
        );
    }
}
