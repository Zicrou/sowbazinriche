<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineItems extends Model
{
    protected $fillable = ['produit_id', 'commande_id', 'panier_id', 'quantite', 'prix_unitaire'];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function panier()
    {
        return $this->belongsTo(Panier::class);
    }

}
