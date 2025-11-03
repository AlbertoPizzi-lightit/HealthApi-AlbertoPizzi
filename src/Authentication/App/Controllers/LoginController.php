<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Lightit\Authentication\App\Requests\LoginRequest;
use Lightit\Authentication\App\Resources\LoginResource;
use Lightit\Authentication\Domain\Actions\LoginAction;

#[Group('auth')]
class LoginController
{
    public function __invoke(LoginRequest $request, LoginAction $loginAction): JsonResponse
    {
        $credentials = $request->toDto();

        $loginDto = $loginAction->execute(['email'=> $credentials->email, 'password' => $credentials->password]);

        return LoginResource::make($loginDto)
            ->response();
    }
}
