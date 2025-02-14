<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommandeFormRequest;
use App\Models\Commande;
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
        if (Auth::check()) {
            if (Auth::user()->role == "user") {
                $commandes = Commande::where('user_id', Auth::user()->id)->where('validated', false)->orderBy("created_at","desc");
                return view("panier.index", ['commandes' => $commandes->paginate(3)]);
            }elseif (Auth::user()->role == "admin") {
                $commandes = Commande::where('validated', '=',1)->where('statut', '!=', 'livré' )->orderBy("created_at","desc")->paginate(1);
                //dd($commandes[0]);
                return view("panier.index", ['commandes' => $commandes]);
                // return redirect()->route('admin.commande.index', ['commandes' => $commandes->paginate(3)]);
            }
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
    public function store(CommandeFormRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route('/login')->with('success', 'Vous devez vous connecté d\'abord');
        }
        $data = $request->all();
        $produit = Produit::find($data["produit_id"]);

        $command = Commande::create($data);
        // dd($command);
        $expectedSlug = $produit->getSlug();
        return to_route('produit.show', ['slug' => $expectedSlug, 'produit' => $produit, 'commande' => $command->quantite])->with('success', 'La commande a été créé avec succés');
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
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $data = $request->validate([
                    'statut' => 'required|string|max:255',
                    'quantite' => ['integer'], 
                ]);
                $commande = Commande::findOrFail($id);
                $commande->update($data);
                return redirect()->route('panier.index')->with('success', 'Commande mise à jour avec succès');
            }elseif (Auth::user()->role == 'user') {
                $data = $request->validate([
                    'validated' => 'boolean',
                    'quantite' => ['required', 'integer'], 
                ]);
                $commande = Commande::findOrFail($id);
                $commande->update($data);
                return redirect()->route('admin.commande.index')->with('success', 'Commande mise à jour avec succès');
            }
        }
        return redirect()->route('login')->with('error', 'Vous devez vous connecter d\'abord');
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
                    $commandes = Commande::where('user_id', Auth::user()->id)->where('validated', false)->orderBy("created_at","desc");
                    return view('panier.index', ['commandes' => $commandes->paginate(3)]); //->with('error', 'Vous ne pouvez pas supprimer une commande validée');
                }
            }
            if (Auth::user()->role == "admin") {
                $commande = Commande::where('id', $id)->where('validated', 1)->first();
                if ($commande) {
                    $commande->delete();
                    $commandes = Commande::where('user_id', Auth::user()->id)->where('validated', true)->orderBy("created_at","desc");
                    return view("admin.commandes.index", ['commandes' => $commandes->paginate(3)])->with('success', 'Commande supprimée avec succès');
                }
            }
        }
        return redirect()->route('/login')->with('success', 'Vous devez vous connecté d\'abord');
        
        // if (!Auth::check()) {
        // }
        // if (Auth::user()->role == "user") {
        //     $commande = Commande::where('id', $id)->where('validated', 0)->exists();
        //     if ($commande) {
        //         return redirect()->route('panier.index')->with('success', 'Commande supprimée avec succès'); //->with('error', 'Vous ne pouvez pas supprimer une commande validée');
        //         $commande->delete();
        //     }
        // }

        // elseif (Auth::user()->role == "user") {
        //     return redirect()->route('panier.index')->with('error', 'Le type est utilisé dans une vente');
        // }

        // if (Auth::user()->role == "admin") {
        //     $commande = Commande::where('id', $id)->where('validated', false)->exists();
        //     if ($commande) {
        //         return redirect()->route('admin.commande.index')->with('error', 'Vous ne pouvez pas supprimer une commande validée');
        //     }
        //     return redirect()->route('admin.commande.index')->with('error', 'Le type est utilisé dans une vente');
        // }

       
        // elseif (Auth::user()->role == "admin") {
        //     $commande = Commande::where('id', $id)->where('validated', false)->exists();
        //     $commande;
        // }
        
        //$commande->delete();
        return redirect()->route('admin.commande.index')->with('success', 'Commande supprimée avec succès');
    }
}
