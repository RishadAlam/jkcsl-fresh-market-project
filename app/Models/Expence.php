<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
    use HasFactory;

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }

    public function getDateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
}
