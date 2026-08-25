<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }

    public function isReplied(): bool
    {
        return $this->replied_at !== null;
    }

    public function markReplied(): void
    {
        $this->forceFill(['replied_at' => now()])->save();
    }

    public function scopeUnreplied(Builder $query): Builder
    {
        return $query->whereNull('replied_at');
    }
}
