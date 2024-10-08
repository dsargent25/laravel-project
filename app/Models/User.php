<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function chirps(): HasMany
    {
       return $this->hasMany(Chirp::class);
    }

    public function comments(): HasMany
    {
     return $this->hasMany(Comment::class, Chirp::class);
    }

    public function follows(){
     return $this->belongsToMany(User::class,'follower_user', 'follower_id', 'user_id')->withTimestamps();
    }

    public function followers(){
     return $this->belongsToMany(User::class,'follower_user', 'user_id', 'follower_id')->withTimestamps();
    }

    public function images(): BelongsToMany
    {
     return $this->belongsToMany(Image::class, 'image_user', 'user_id', 'image_id')->withTimestamps();
    }

}
