<?php

namespace App\Models;

use App\Models\category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class stock extends Model
{
    use HasFactory;

    /**
     * Relation With Category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\category');
    }

    /**
     * Relation With Service sales Table
     */
    public function serviceSale()
    {
        return $this->hasMany('App\Models\serviceSale');
    }
}
