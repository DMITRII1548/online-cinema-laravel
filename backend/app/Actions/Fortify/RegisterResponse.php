<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        return response()->json(['message' => 'Registration successful.']);
    }
}
