<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Uuids as Uuids;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // Primary key
    public $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userPreference()
    {
        return $this->hasOne('App\Models\Users\UserPreference');
    }

    public function getNameWithEmailAttribute()
    {
        return $this->Profile->first_name.' '.$this->Profile->last_name.' ('.$this->email.')';
    }
    public function scopeFilterByEmail($q, $email = null)
    {
        if (! $email) {
            return $q;
        }
        return $q->where('email', 'like', '%'.$email.'%');
    }

    public function scopeFilterByName($q, $name = null)
    {
        if (! $name) {
            return $q;
        }

        return $q->whereHas('profile', function ($q1) use ($name) {
            $q1->where(function($q2) use($name) {
                $q2->where('first_name', 'like', '%'.$name.'%')->orWhere('last_name', 'like', '%'.$name.'%');
            });
        });
    }

    public function scopeFilterByStatus($q, $status = null)
    {
        if (! $status) {
            return $q;
        }
        return $q->where('status', '=', $status);
    }

    public function scopeCreatedAtDateBetween($q, $dates)
    {
        if ((! $dates['start_date'] || ! $dates['end_date']) && $dates['start_date'] <= $dates['end_date']) {
            return $q;
        }
        return $q->where('created_at', '>=', getStartOfDate($dates['start_date']))->where('created_at', '<=', getEndOfDate($dates['end_date']));
    }
    
    public function requests(){
        return $this->hasMany('App\Models\App\ContainerRequest', 'owner_id', 'id');
    }

     /**
     * Get the User profile
     *
     * @return string
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Users\Profile', 'user_id');
    }
}
