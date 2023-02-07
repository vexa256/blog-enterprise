<?php

namespace App;

use App\Traits\Messages\Messagable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword as ResetPassword;

class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    use HasFactory, Notifiable, ResetPassword, Messagable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['usertype', 'username', 'username_slug', 'name', 'surname', 'genre', 'about', 'facebookurl', 'twitterurl', 'weburl', 'social_profiles', 'email', 'icon', 'splash', 'password', 'remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = ['social_profiles' => AsArrayObject::class];

    protected $appends = [
        'profile_link',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }

    public function vote()
    {
        return $this->hasMany('App\PollVotes', 'user_id');
    }

    public function followers()
    {
        return $this->hasMany('App\Followers', 'followed_id');
    }

    public function following()
    {
        return $this->hasMany('App\Followers', 'user_id');
    }

    public function scopeBySlug($query, $username_slug)
    {
        return $query->where('username_slug', $username_slug);
    }

    public function isAdmin()
    {
        return $this->usertype == 'Admin';
    }

    public function isStaff()
    {
        return $this->usertype == 'Staff';
    }

    public function isDemoAdmin()
    {
        if (!env('APP_DEMO')) {
            return false;
        }

        return $this->email == 'demo@admin.com';
    }

    public function setUsernameSlugAttribute($username)
    {
        return $this->attributes['username_slug'] = sanitize_title_with_dashes($username);
    }

    public function getProfileLinkAttribute()
    {
        return route('user.profile', ['user' => $this->username_slug]);
    }

    /**
     * Force a hard delete user.
     *
     * @return bool|null
     */
    public function userDelete()
    {
        $this->posts()->forceDelete();
        $this->followers()->delete();
        $this->following()->delete();

        $this->messages()->forceDelete();
        $this->participants()->forceDelete();
        $this->threads()->forceDelete();
        $this->comments()->forceDelete();
        $this->delete();
    }
}
