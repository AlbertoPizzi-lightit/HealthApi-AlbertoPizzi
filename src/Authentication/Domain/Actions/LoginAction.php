<?php

declare(strict_types=1);

namespace Lightit\Authentication\Domain\Actions;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Lightit\Authentication\Domain\DataTransferObjects\LoginDto;
use Lightit\Shared\App\Exceptions\Http\UnauthorizedException;
use PHPOpenSourceSaver\JWTAuth\Factory as JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

final readonly class LoginAction
{
    public function __construct(
        private AuthFactory $factory,
        private JWTAuth $jwtAuth,
    ) {
    }

    /** @throws UnauthorizedException */
    public function execute(array $credentials): LoginDto
    {
        /** @var JWTGuard $guard */
        $guard = $this->factory->guard();
        if (! $token = $guard->attempt($credentials)) {
            throw new UnauthorizedException();
        }

        /** @var string $token */
        return new LoginDto(
            $token,
            'Bearer',
            $this->jwtAuth->getTTL() * 60,
        );
    }
}
