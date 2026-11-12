<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstructorAsset extends Model
{
    protected $fillable = [
        'instructor_id',
        'name',
        'asset_type',
        'cloudinary_url',
        'file_size_bytes',
        'folder_path',
        'visibility',
        'shared_emails',
        'status',
    ];

    protected $attributes = [
        'file_size_bytes' => 0,
        'folder_path' => '/',
        'visibility' => Visibility::PRIVATE->value,
        'status' => AssetStatus::PENDING_MODERATOR->value,
    ];

    protected function casts(): array
    {
        return [
            'asset_type' => AssetType::class,
            'file_size_bytes' => 'integer',
            'visibility' => Visibility::class,
            'status' => AssetStatus::class,
        ];
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
