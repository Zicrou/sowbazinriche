@extends('layouts.base')

@section('title', 'Tous les produits')

@section('content')
<style>
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
                <div class="card col-10 mx-auto mb-3"  style="background-color: white;">
                    <div class="card-heade bg-white">
                        <h2 class="text-center">{{ $commande->produit->titre }}</h2>
                        <div class="row d-flex">
                            <div class="col-12 col-lg-3 gap-3 mx-3">
                                <p>Prix: {{ number_format($commande->produit->prix, thousands_separator: ' ') }}</p>
                                <p>Quantité: {{ $commande->quantite }}</p>
                                <p>Total: {{ $commande->quantite  * $commande->produit->prix }} FCFA</p>
                                @php
                                 $commande->id = 52;
                                @endphp
                                @if ($commande->validated == 1)
                                <p>Total: {{ $commande->statut }} </p>
                                <p>Utilisateur: {{ $commande->user->name }} - {{ $commande->user->phone }}</p>
                                @endif
                            </div>
                            <div class="col-12 col-lg-6 mx-2 d-flex justify-content-center">
                                <p>
                                    <img class="d-block w-50" style="height:auto; object-fit:cover;" src="{{ asset($commande->produit->image) }}" alt="">
                                </p>
            
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex gap-2 justify-content-evenly">
                        <a href="{{ route('admin.commande.update', $commande) }}" class="btn btn-outline-primary">Valider</a>
                        <a href="{{ route('admin.commande.edit', $commande) }}" class="btn btn-outline-warning">Editer</a>
                        <form action="{{ route('admin.commande.destroy', $commande) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger">Supprimer</button>
                        </form>
                        
                    </div>
                </div>
            @endforeach
            {{ $commandes->links() }}
        
        </div>
    </section>
@endsection