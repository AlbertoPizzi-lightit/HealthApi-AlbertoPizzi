<?php

declare(strict_types=1);

namespace Lightit\Authentication\Domain\Actions;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Lightit\Authentication\Domain\DataTransferObjects\LoginDto;
use Lightit\Users\Domain\Models\User;
use PHPOpenSourceSaver\JWTAuth\Factory as JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

final readonly class LoginByUserAction
{
    public function __construct(
        private AuthFactory $factory,
        private JWTAuth $jwtAuth,
    ) {
    }

    public function execute(User $user): LoginDto
    {
        /** @var JWTGuard $guard */
        $guard = $this->factory->guard();

        /** @var string $token */
        $token = $guard->tokenById($user->getKey());

        return new LoginDto(
            $token,
            'bearer',
            $this->jwtAuth->getTTL() * 60,
        );
    }
}
