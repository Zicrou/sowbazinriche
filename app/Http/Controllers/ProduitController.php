<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $query = Produit::query()->orderBy('created_at', 'desc');
		// if ($price = $request->validated('price')) {
		// 	$query->where('price', '<=', $price);
		// }
		// if ($surface = $request->validated('surface')) {
		// 	$query->where('surface', '>=', $surface);
		// }
		// if ($rooms = $request->validated('rooms')) {
		// 	$query->where('rooms', '>=', $rooms);
		// }
		// if ($title = $request->validated('title')) {
		// 	$query->where('title', 'like', "%{$title}%");
		// }
        return view('produits.index',[
			'produits' => $query->paginate(3),
			// 'input'      => $request->validated(),
		]);
    }

    public function show(string $slug, Produit $produit)
    {
        // DemoJob::dispatch($property)->delay(now()->addSeconds(10));
        $expectedSlug = $produit->getSlug();
        if($slug !== $expectedSlug){
            return to_route('produit.show', ['slug' => $expectedSlug, 'produit' => $produit]);
        }
        // $images = Picture::where('produit_id', $produit->id)->get();
        return view('produits.show', [
            'produit' => $produit,
            // 'images' => $images
        ]);
    }
}
