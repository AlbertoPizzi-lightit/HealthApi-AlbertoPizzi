<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\Authentication\Domain\Actions\LogoutAction;

#[Group('auth')]
class LogoutController
{
    public function __invoke(Request $request, LogoutAction $logoutAction): JsonResponse
    {
        $logoutAction->execute();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
