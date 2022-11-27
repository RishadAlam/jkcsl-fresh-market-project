<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class officer_expence extends Model
{
    use HasFactory;

    /**
     * Relation With User Table
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Mutator User for Date Format
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }

    /**
     * Accessor User for Date Format
     */
    public function getDateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
}
