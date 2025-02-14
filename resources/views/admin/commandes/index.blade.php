@extends('admin.admin')

@section('title', 'Tous les produits')

@section('content')

    <div class="row">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title') @if (Auth::check())
                @if (Auth::user()->role == "admin")
                    Admin
                @endif
            @endif</h1>
            {{-- <a href="{{ route('admin.produit.create') }}" class="btn btn-primary">Ajouter un produit</a> --}}
        </div>
        {{ $commandes->links() }}
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>User</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th>Image</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($commandes as $commande)
                
                    <tr>
                        <td>{{ $commande->produit->titre }}</td>
                        <td>{{ $commande->user->name }}</td>
                        <td>{{ $commande->quantite }}</td>
                        <td>{{ number_format($commande->produit->prix, thousands_separator: ' ') }}</td>
                        <td>{{ $commande->quantite  * $commande->produit->prix}} FCFA</td>
                        <td>
                            <img class="d-block w-10" style="height:90px; object-fit:cover;" src="{{ asset($commande->produit->image) }}" alt="">
                        </td>
                        <td>{{ $commande->statut }}</td>
                        <td>
                            <div class="d-flex gap-2 w-100 justify-content-end">
                                {{-- <a href="{{ route('admin.upload.image', $commande) }}" class="btn btn-primary">Images</a>
                                <a href="{{ route('admin.picture.index', $commande) }}" class="btn btn-primary">Picture</a> --}}
                                <a href="{{ route('admin.commande.edit', $commande) }}" class="btn btn-primary">Editer</a>
                                {{-- @can('delete', $commande) --}}
                                    <form action="{{ route('admin.commande.destroy', $commande) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">Supprimer</button>
                                    </form>
                                {{-- @endcan --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        {{ $commandes->links() }}
    
    </div>
@endsection