@extends('admin.admin')

@section('title', 'Liste des commandes')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    /* .card p {
        font-family: 'Open Sans';
        color: #333;
    } */
    body{
        background-color: #F2F2F2;
    }
</style>

    <div class="row">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            {{-- <a href="{{ route('admin.produit.create') }}" class="btn btn-primary">Ajouter un produit</a> --}}
        </div>
    
    </div>
    {{ $commandes->links() }}
    <section>
        <div class="container">
            @foreach ($commandes as $commande)
                @if ($commande->lineItems && $commande->lineItems->count() > 0)
                    @foreach ($commande->lineItems as $item)
                        @unless ($item->status == 'terminé')
                            <div class="card col-10 mx-auto mb-3"  style="background-color: white;">
                                <div class="card-header bg-white">
                                    <h2 class="mx-2 text-start">{{ $item->produit->titre}} {{ $commande->id }}</h2>
                                    <div class="row d-flex line-item justify-content-start">
                                        <div class="col-6 col-lg-6 mx-2 ">
                                            <p>
                                                <img class="d-block w-50" style="height:auto; object-fit:cover;" src="{{ asset($item->produit->image) }}" alt="">
                                            </p>
                        
                                        </div>
                                        <div class="col-6 col-lg-3 gap-3 mt-4">
                                            <p>Prix: {{ number_format($item->produit->prix, thousands_separator: ' ') }}</p>
                                            <label for="">Quantite</label>
                                            <input type="number"
                                            class="quantite form-control"
                                            value="{{ $item->quantite }}"
                                            min="1"
                                            data-prix="{{ $item->prix_unitaire }}" disabled readonly>
                                            <form action="{{ route('admin.commande.update', $commande) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <p class="mt-3">Statut: {{ $commande->status }}</p>
                                                <div class="d-flex col-sm-12 mb-3">
                                                    <select name="status" class="form-select " aria-label="Default select example">
                                                        <option value="">Modifier le statut</option>
                                                        <option value="en_attente">En Attente</option>
                                                        <option value="en_cours">En cours</option>
                                                        <option value="Encaissé">Encaissé</option>
                                                        <option value="livré">Livré</option>
                                                        <option value="terminé">terminé</option>
                                                    </select>
                                                </div>
                                                
                                                <button class="btn btn-outline-primary">Update</button>
                                            </form>
                                            <p class="total">Total: {{ number_format($item->quantite  * $item->produit->prix, 0, ',', ' ') . " FCFA" }}</p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="card-footer d-flex gap-2 justify-content-evenly">
                                    
                                        
                                    {{-- <a href="{{ route('admin.commande.store', $item) }}" class="btn btn-outline-primary">Valider</a>  --}}
                                    {{-- <a href="{{ route('admin.commande.edit', $item) }}" class="btn btn-outline-warning">Editer</a> --}}
                                    <form action="{{ route('lineItems.destroy', $item) }}" method="post"> 
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger delete-line-item" data-id="{{ $item->id }}"" id="delete">Supprimer</button>
                                    </form>                              
                                </div>
                            </div>
                        @endunless
                    @endforeach
                @else 
                    {{-- <p>Pas de produit dans le panier</p> --}}
                @endif
            @endforeach
            {{ $commandes->links() }}
        </div>
    </section>
@endsection
