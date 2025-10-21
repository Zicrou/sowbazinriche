<?php

namespace App\Http\Controllers;

use App\Http\Requests\PanierFormRequest;
use App\Models\LineItems;
use App\Models\Panier;
use Illuminate\Http\Request;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
class PanierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
                $paniers = Panier::where('user_id', Auth::user()->id)->with('lineItems.produit')->orderBy("created_at","desc")->paginate(25);
                // dd($paniers->first()->lineItems->first()->produit->titre);
                return view("panier.index", ['paniers' => $paniers]);
        }
        return redirect()->route('login')->with('error', 'Vous devez vous connecter d\'abord');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PanierFormRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/login')->with('success', 'Vous devez vous connecté d\'abord');
        }
        $data = $request->validated();
        $produit = Produit::find($data["produit_id"]);

        // Ajouter un produit au panier
        $panier = Panier::where('user_id', Auth::user()->id)->first();
        if (!$panier) {
            $panier = Panier::create($data);
        }
        
        // $produit = Produit::find(2);
        
        // dd($panier);
        $panier->lineItems()->create([
            'produit_id' => $produit->id,
            'quantite' => 1,
            'prix_unitaire' => $produit->prix,
        ]);
        // dd($command);
        $expectedSlug = $produit->getSlug();
        return to_route('panier.index')->with('success', 'Produit ajouté au panier avec succés');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PanierFormRequest $request, string $id)
    {
        if (Auth::check()) {
            
                $data = $request->validated();
                $panier = Panier::findOrFail($id);
                $panier->update($data);
            return redirect()->route('admin.commande.index')->with('success', 'Commande modifiée avec succès');
        }
        return redirect()->route('login')->with('error', 'Vous devez vous connecter d\'abord');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
