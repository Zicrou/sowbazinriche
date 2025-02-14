@extends('admin.admin')

@section('title','Editer la commande')

@section('content')
    <h1>@yield('title')</h1>
    @if (Auth::check())
        @if (Auth::user()->role == "admin")
            <form action="{{route('admin.commande.update' ,$commande)}}" method="post">
                @csrf
                @method('put')
                <div class="row">
                
                    <div class="d-flex flex-column col-sm-6 row mb-3">
                        <select name="statut" class="form-select " aria-label="Default select example">
                            <option value="">Modifier le statut</option>
                            <option value="enAttente">Commencé</option>
                            <option value="enAttente">En attente</option>
                            <option value="Encaissé">Encaissé</option>
                            <option value="livré">Livré</option>
                        </select>
                    </div>
                    
                </div>
                <div class="col-6 d-flex justify-content-center mt-4">
                    <a href="{{route('admin.commande.index')}}" class="btn btn-warning px-3 mx-3">Retour</a>
                    <button class="btn btn-primary">
                        @if ($commande->exists)
                            Modifier le Statut
                        @endif
                    </button>
                </div>
            </form>
        @elseif(Auth::user()->role == "user")
            <form action="{{route('admin.commande.update' ,$commande)}}" method="post">
                @csrf
                @method('put')
                <div class="row">
                
                    <div class="d-flex form-group col-sm-6 row mb-3">
                        <input type="number" name="quantite" value="{{ $commande->quantite }}" class="form-control">
                    </div>
                    
                </div>
                <div class="col-6 d-flex justify-content-center mt-4">
                    <a href="{{route('admin.commande.index')}}" class="btn btn-warning px-3 mx-3">Retour</a>
                    <button class="btn btn-primary">
                        @if ($commande->exists)
                            Modifier la quantité
                        @endif
                    </button>
                </div>
            </form>
        @endif
    @endif
    
@endsection

    
    <div class="zoom"></div> 