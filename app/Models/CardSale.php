<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardSale extends Model
{
    use HasFactory;

    /**
     * Relation With User Table
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Accessor
     */
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y h:i:s A', strtotime($value));
    }
}
