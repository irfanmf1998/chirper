<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelFollow\Traits\Followable;

class User extends Authenticatable
{
    use Notifiable;

    use HasFactory;

    use Follower;
    use Followable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class);
    }

    //Mengambil ID para pengguna yang di-follow
    public function getFollowingsIds()
    {
        return $this->followings()->pluck('followable_id')->toArray();
    }

    // ... more code
}