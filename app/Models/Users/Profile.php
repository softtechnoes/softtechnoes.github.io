<?php

namespace App\Models\Users;
#default
use Illuminate\Database\Eloquent\Model;
#custom
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public    $primaryKey   = 'id';
    protected $table        = 'profiles';
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];
    
    /**
     * Get the User
     *
     * @return string
     */
    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }
}
