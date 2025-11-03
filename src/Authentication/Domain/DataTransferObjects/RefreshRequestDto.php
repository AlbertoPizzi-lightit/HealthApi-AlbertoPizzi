<?php

declare(strict_types=1);

namespace Lightit\Authentication\Domain\DataTransferObjects;

use PHPOpenSourceSaver\JWTAuth\Factory as JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWT;

class RefreshRequestDto
{
    public function __construct(
        public JWTAuth $jwtAuth,
        public JWT $jwt,
    ) {
    }
}
