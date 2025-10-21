<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommandeFormRequest;
use App\Models\Commande;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (Auth::check()) {
        //     // dd($paniers->first()->lineItems->first()->produit->titre);
        // }
        // return redirect()->route('login')->with('error', 'Vous devez vous connecter d\'abord');
        
        if (Auth::user()->role == "user") {
            $commandes = Commande::where('user_id', Auth::user()->id)->with('lineItems.produit')->orderBy("created_at","desc")->paginate(25);
            // $commandes = Commande::where('user_id', Auth::user()->id)->where('validated', false)->orderBy("created_at","desc");
            return view("commandes.index", ['commandes' => $commandes]);
                // return view("panier.index", ['commandes' => $commandes->paginate(1)]);
        }elseif (Auth::user()->role == "admin") {
            $commandes = Commande::where('status',  '!=', "terminé")->with(['lineItems.produit', 'user'])->orderBy("created_at","desc")->paginate(25);
            return view("admin.commandes.index", ['commandes' => $commandes]);
            // return redirect()->route('admin.commande.index', ['commandes' => $commandes]);
        }
        
        return redirect()->route('login')->with('error', 'Vous devez vous connecter d\'abord');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin.produits.form', [
        //     'produit' => new Commande(),
        //     'pictures' => '',
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/login')->with('success', 'Vous devez vous connecté d\'abord');
        }
        $data = $request->all();
        $panier = Panier::where('user_id', Auth::user()->id)->first();
        if(Auth::user()->role == 'user'){
            $commande = Commande::where('user_id', Auth::user()->id)->first();
            // dd($commande);
            if($commande == null){
                $commande = Commande::create([
                    'user_id' => $panier->user_id,
                    'total' => $panier->lineItems->sum(fn($item) => $item->prix_unitaire * $item->quantite),
                    'status' => 'en_attente',
                ]);
            }
            // Créer une commande depuis le panier
             $produitId = 0;
             foreach ($panier->lineItems as $item) {
                 $produitId = $item->produit_id;
                 $commande->lineItems()->create([
                     'produit_id' => $item->produit_id,
                     'quantite' => $item->quantite,
                     'prix_unitaire' => $item->prix_unitaire,
                 ]);
     
             }
             $produit = Produit::find($produitId);
             $expectedSlug = $produit->getSlug();
        }
        //$panier->delete(); // vider le panier après commande
        
        // return to_route('panier.index')->with('success', 'Produit ajouté au panier avec succés');
        return to_route('admin.commande.index')->with('success', 'La commande a été créé avec succés');
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
    public function edit(Commande $commande)
    {
        // dd($commande);
        return view('admin.commandes.form', [
            'commande' => $commande,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // if (Auth::check()) {
            //     if (Auth::user()->role == 'admin') {
                $data = $request->validate([
                    'status' => 'required|string|max:255',
                    // 'quantite' => ['integer'], 
                ]);
                $commande = Commande::find($id);
                // dd($commande->update($data));
                $commande->update($data);
            // }
            // elseif (Auth::user()->role == 'user') {
            //     $data = $request->validate([
            //         'validated' => 'boolean',
            //         'quantite' => ['required', 'integer'], 
            //     ]);
            //     $commande = Commande::findOrFail($id);
            //     $commande->update($data);
            // }
            return redirect()->route('admin.commande.index')->with('success', 'Statut de la commande modifiée avec succès');
        // }
        // return redirect()->route('login')->with('error', 'Vous devez vous connecter d\'abord');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::check()) {
            if (Auth::user()->role == "user") {
                $commande = Commande::where('id', $id)->where('validated', 0)->first();
                if ($commande) {
                    $commande->forceDelete();
                }
            }
            if (Auth::user()->role == "admin") {
                $commande = Commande::where('id', $id)->where('validated', 1)->first();
                if ($commande) {
                    $commande->delete();
                }
            }
            return redirect()->route('admin.commande.index')->with('success', 'Commande supprimée avec succès');

        }
        return redirect()->route('/login')->with('success', 'Vous devez vous connecté d\'abord');
    }

    public function validateCommande(string $id)
    {
        if (Auth::check()) {
            if (Auth::user()->role == "user") {
                $commande = Commande::where('id', $id)->first();
                //dd($commande->exists());
                if ($commande) {
                    $commande->validated = 1;//['validated' => 1]);
                    $commande->save();
                }
                return redirect()->route('admin.commande.index')->with('success', 'Commande validée avec succès');
            }
        }
        return redirect()->route('login')->with('error', 'Vous devez vous connecter d\'abord');
    }
}
