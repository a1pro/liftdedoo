<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'gender',
        'role',
        'status',
        'otp_counter',
        'otp',
        'mobile_verify_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Accessors for Status

    public function getUserStatusAttribute()
    {
        if($this->status == 0)
        {
            return 'Active';
        }
        else
        {
            return 'Deactive';
        }
    }


    public function getRememberToken()
	{
        return $this->remember_token;
	}

	public function setRememberToken($value)
	{
        $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
        return 'remember_token';
	}
}
