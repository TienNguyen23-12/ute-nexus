<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RoleCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'code' => RoleCode::class,
        ];
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withPivot('assigned_at');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withPivot('assigned_at');
    }
}
