<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'chirp_id',
        'user_id',
        'content'
        ];
    
        public function chirp(): BelongsTo
        {
            return $this->belongsTo(Chirp::class);
        }
    
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }
}
