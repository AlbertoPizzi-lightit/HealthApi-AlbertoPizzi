<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lightit\Authentication\Domain\DataTransferObjects\RefreshRequestDto;

/**
 * @mixin RefreshRequestDto
 */
class RefreshResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'access_token' =>$this->jwt->refresh(),
            'token_type' => 'Bearer',
            'expires_in' => $this->jwtAuth->getTTL() * 60,
        ];
    }
}
