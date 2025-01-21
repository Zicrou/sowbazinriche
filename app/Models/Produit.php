<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'quantite',
        'prix',
        'image',
        'taille',
    ];

    public function getslug(): string
    {
        return Str::slug($this->titre);
    }

    public function getFormatedPrice()
	{
		$formatedPrice = number_format($this->prix, 0, ',', ' ');
		$formatedPrice = str_replace(' ', '&nbsp;', $formatedPrice);

		return $formatedPrice . '&nbsp;CFA';
	}
}
