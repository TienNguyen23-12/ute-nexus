<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PermissionModule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'code',
        'name',
        'module',
    ];

    protected function casts(): array
    {
        return [
            'module' => PermissionModule::class,
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->withPivot('assigned_at');
    }
}
