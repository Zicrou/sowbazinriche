<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'images', 'produit_id',
    ];
}
