<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'content',
        'question_type',
        'points',
        'explanation',
        'options',
        'order_index',
    ];

    protected $attributes = [
        'points' => '1.00',
        'options' => '[]',
        'order_index' => 1,
    ];

    protected function casts(): array
    {
        return [
            'question_type' => QuestionType::class,
            'points' => 'decimal:2',
            'options' => 'array',
            'order_index' => 'integer',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
