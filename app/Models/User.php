<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Customer;
use Laravel\Passport\HasApiTokens;
use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','email','mobile','role_id','company_id','username','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    function role() {
        return $this->belongsTo(Role::class);
    }
    
    public function redeemed() {
        return $this->hasMany(Customer::class,'service_user_id')->where('status',0);
    }

    public function company() {
    	return $this->belongsTo(Company::class);
    }

    public function  shops()
    {
        return $this->hasManyThrough(
            Company::class,
            UserShop::class,
            'user_id', // Foreign key on users table...
            'id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'company_id' // Local key on users table...
        );
    }
}
