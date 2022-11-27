<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;

    /**
     * Mutator for month
     */
    public function setMonthAttribute($value)
    {
        $this->attributes['month'] = date('Y-m-d', strtotime($value));
    }

    /**
     * accessor Fr date
     */
    public function getMonthAttribute($value)
    {
        return date('F-Y', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    /**
     * Relation With User
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
