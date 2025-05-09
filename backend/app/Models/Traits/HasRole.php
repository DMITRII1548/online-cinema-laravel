<?php

namespace App\Models\Traits;

trait HasRole
{
    public function hasRole(string $role): ?bool
    {
        return $this->roles
            ->pluck('name')
            ->contains($role);
    }
}
