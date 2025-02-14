@extends('layouts.base')

@section('title', 'Tous nos biens')


@section('content')

    <div class="bg-light p-5 mb-5 text-center">
        <form action="" method="get" class="container d-flex gap-2">
            <input type="number" placeholder="Budget max" class="form-control" name="price" value="{{ $input['price'] ?? ''}}">
            <input placeholder="Mot clef" class="form-control" name="title" value="{{ $input['title'] ?? ''}}">
            <button class="btn btn-primary btn-sm flex-grow-0">
                Rechercher
            </button>
        </form>
    </div>
    <div class="container">
        <div class="row">
            @forelse ($produits as $produit)
            
                <div class="col-3 mb-4">
                    @include('produits.card')
                </div>
            @empty
                <div class="col">
                    Aucun bien ne correspond à votre recherche
                </div>
            @endforelse
        </div>

        <div class="container my-4">
            {{ $produits->links() }}
        </div>
    </div>

@endsection