<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdventureImage extends Model
{
    protected $fillable = [
        'adventure_id',
        'image',
        'sort_order',
        'is_cover',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    public function adventure()
    {
        return $this->belongsTo(Adventure::class);
    }
}
