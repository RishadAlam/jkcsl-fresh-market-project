<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * accessor
     */
    public function getDobAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    /**
     * Relation With Service sales Table
     */
    public function serviceSale()
    {
        return $this->hasMany('App\Models\serviceSale');
    }

    /**
     * Relation With Card sales Table
     */
    public function cardSale()
    {
        return $this->hasMany('App\Models\serviceSale');
    }

    /**
     * Relation With officer expence Table
     */
    public function officer_expence()
    {
        return $this->hasMany('App\Models\officer_expence');
    }

    /**
     * Relation With officer Salary Table
     */
    public function salary()
    {
        return $this->hasMany('App\Models\salary');
    }
}
