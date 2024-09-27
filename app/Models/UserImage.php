<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_id',
    ];

    public function images(): BelongsTo
    {
     return $this->belongsTo(Image::class);
    }
}
