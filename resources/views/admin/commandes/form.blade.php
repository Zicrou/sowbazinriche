@extends('admin.admin')

@section('title','Editer la commande')

@section('content')
    <h1>@yield('title')</h1>
    <form action="{{route('admin.commande.update' ,$commande)}}" method="post">
        @csrf
        @method('put')
        <div class="row">
        
            <div class="d-flex flex-column col-sm-6 row mb-3">
                <select name="statut" class="form-select " aria-label="Default select example">
                    <option selected value="enAttente">En attente</option>
                    <option value="Encaissé">Encaissé</option>
                    <option value="livré">Livré</option>
                  </select>
            </div>
            
        </div>
        <div class="col-6 d-flex justify-content-center mt-4">
            <button class="btn btn-primary">
                @if ($commande->exists)
                    Modifier le Statut
                @endif
            </button>
        </div>
    </form>
    
@endsection

    
    <div class="zoom"></div> 