<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Requests\SearchProduitsRequest;

class ProduitController extends Controller
{
    public function index(SearchProduitsRequest $request)
    {
        $query = Produit::query()->orderBy('created_at', 'desc');
		
        if ($price = $request->validated('price')) {
            $query->where('prix', '<=', $price);
            // dd($query->get());
			
		}if ($title = $request->validated('title')) {
            $query->where('titre', 'like', "%{$title}%");
		}
       
        return view('produits.index',[
			'produits' => $query->paginate(3),
			'input'      => $request->validated(),
		]);
    }

    public function show(string $slug, Produit $produit)
    {
        // DemoJob::dispatch($property)->delay(now()->addSeconds(10));
        $expectedSlug = $produit->getSlug();
        if($slug !== $expectedSlug){
            return to_route('produit.show', ['slug' => $expectedSlug, 'produit' => $produit]);
        }
        $images = Picture::where('produit_id', $produit->id)->get();
        return view('produits.show', [
            'produit' => $produit,
            'images' => $images
        ]);
    }
}
