<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commande extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'total', 'status'];

    public function lineItems()
    {
        return $this->hasMany(LineItems::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'line_items')
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
