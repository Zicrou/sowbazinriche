@extends('admin.admin')

@section('title', $produit->exists? 'Editer le produit' : 'Ajouter un produit')

@section('content')
    <h1>@yield('title')</h1>
    <form action="{{route($produit->exists ? 'admin.produit.update' : 'admin.produit.store', $produit)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method($produit->exists ? 'put' : 'post')
        <div class="row">
        
            <div class="d-flex flex-column col-sm-6 row mb-3">
                @include('shared.input', ['class' => 'col', 'name' => 'titre', 'label' => 'Titre', 'value' => $produit->titre])
                @include('shared.input', ['class' => 'col', 'name' => 'quantite', 'label' => 'quantite','type' => 'number', 'value' => $produit->quantite])
                @include('shared.input', ['class' => 'col', 'name' => 'prix', 'label' => 'Prix', 'type' => 'number', 'value' => $produit->prix])
            </div>
            <div class="mb-3 col-sm-3">
                {{-- <label class="mb-1">Image</label> --}}
                @include('shared.input', ['class' => 'col', 'name' => 'image', 'label' => 'Image Cover', 'type' => 'file', 'value' => $produit->image])
                @if ($produit->image)
                    <div class="d-flex col-md-3 mt-1">
                        <img class="" src="{{ asset($produit->image) }}" alt="image" style="width:200px;height:200px">
                    </div>
                @endif
                {{-- @include('shared.input', ['class' => 'col', 'name' => 'images[]', 'multiple', 'label' => 'Ajouter des photos', 'type' => 'file', 'value' => $produit->images]) --}}
            </div>
            <div class="mb-3 col-sm-3">
                {{-- @include('shared.input', ['class' => 'col', 'name' => 'images[]', 'multiple', 'label' => 'Ajouter des photos', 'type' => 'file', 'value' => $produit->images, 'multiple' => true]) --}}
                <label for="images">Ajouter des Photos</label>
                <input type="file" name="images[]" multiple class="col form-control " value="{{ $produit->images }}">
            </div>
            @include('shared.checkbox', ['class' => 'col mx-4', 'name' => 'disponible', 'label' => 'Disponible', 'value' => $produit->disponible])
            
            {{-- <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>
              
                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2">Radio 2</label>
              
                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio3">Radio 3</label>
              </div> --}}    
        </div>
        <div class="col-6 d-flex justify-content-center mt-4">
            <button class="btn btn-primary">
                @if ($produit->exists)
                    Modifier
                @else
                    Créer
                @endif
            </button>
        </div>
    </form>
    @php
    @endphp
    <div class="row">
        <h2>Images</h2>
        @if ($pictures !== "" )
            @if ($pictures->count() !==0 )
                @foreach ( $pictures as $picture )
                    <div class="d-flex col-sm-3 mt-4">
                        <img class="" src="{{ asset($picture->images) }}" alt="image" style="width:200px;height:200px">
                        <a class="px-2" href="{{ route('picture.delete', $picture->id) }}">Effacer</a>

                    </div>
                @endforeach
            @endif
        @endif
    </div>
@endsection

    
    <div class="zoom"></div> 