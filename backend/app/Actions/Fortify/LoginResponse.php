<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        
        return response()->json([
            'two_factor' => false,
            'token' => $user->createToken(Hash::make((string)microtime(true)))->plainTextToken,
        ]);
    }
}
