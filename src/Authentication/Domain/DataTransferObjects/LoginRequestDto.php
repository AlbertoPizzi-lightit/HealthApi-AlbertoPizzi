<?php

declare(strict_types=1);

namespace Lightit\Authentication\Domain\DataTransferObjects;

use SensitiveParameter;

readonly class LoginRequestDto
{
    public function __construct(
        public string $email,
        #[SensitiveParameter]
        public string $password,
    ) {
    }
}
