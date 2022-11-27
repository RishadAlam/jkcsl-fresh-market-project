<?php

namespace App\Models;

use App\Models\stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class category extends Model
{
    use HasFactory;

    /**
     * Relation With Stock Table
     */
    public function stock()
    {
        return $this->hasMany('App\Models\stock');
    }

    /**
     * Relation With Service sales Table
     */
    public function serviceSale()
    {
        return $this->hasMany('App\Models\serviceSale');
    }
}
