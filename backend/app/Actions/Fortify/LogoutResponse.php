<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;

class LogoutResponse implements LogoutResponseContract
{
    public function toResponse($request)
    {
        return response()->json(['message' => 'Logout successful.']);
    }
}
