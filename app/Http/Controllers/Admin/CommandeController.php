<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommandeFormRequest;
use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::orderBy("created_at","desc");
        // dd($commande->first()->produit);
        return view("admin.commandes.index", ['commandes' => $commandes->paginate(3)]);
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
        $data = $request->validate([
            'statut' => 'required|string|max:255',
        ]);
        $commande = Commande::findOrFail($id);
        $commande->update($data);

        return redirect()->route('admin.commande.index')->with('success', 'Commande mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
