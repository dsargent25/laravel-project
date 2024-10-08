<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chirp extends Model
{
    use HasFactory;

    protected $fillable = [
	'message',
    ];

    protected $dispatchesEvents = [
        'created' => ChirpCreated::class,
    ];

    public function user(): BelongsTo
   {
	return $this->belongsTo(User::class);
   }

   public function comment(): HasMany
   {
    return $this->hasMany(Comment::class);
   }

   public function images(): BelongsToMany
   {
    return $this->belongsToMany(Image::class);
   }

}
