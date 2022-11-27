<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serviceSale extends Model
{
    use HasFactory;

    /**
     * Accessor
     */
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y h:i:s A', strtotime($value));
    }

    /**
     * Relation With Category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\category');
    }

    /**
     * Relation With User Table
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relation With Stock Table
     */
    public function stock()
    {
        return $this->belongsTo('App\Models\stock');
    }
}
