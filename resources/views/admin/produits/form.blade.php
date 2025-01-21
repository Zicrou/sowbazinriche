@extends('admin.admin')

@section('title', $produit->exists? 'Editer le produit' : 'Ajouter un produit')

@section('content')
    <h1>@yield('title')</h1>
    <form action="{{route($produit->exists ? 'admin.produit.update' : 'admin.produit.store', $produit)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method($produit->exists ? 'put' : 'post')
        <div class="row">
        
            <div class="d-flex flex-column col row mb-3">
                @include('shared.input', ['class' => 'col', 'name' => 'titre', 'label' => 'Titre', 'value' => $produit->titre])
                @include('shared.input', ['class' => 'col', 'name' => 'quantite', 'label' => 'quantite','type' => 'number', 'value' => $produit->quantite])
                @include('shared.input', ['class' => 'col', 'name' => 'prix', 'label' => 'Prix', 'type' => 'number', 'value' => $produit->prix])
                @include('shared.input', ['class' => 'col', 'name' => 'taille', 'label' => 'Taille', 'type' => 'number', 'value' => $produit->taille])
            </div>
            <div class="mb-3 col-3">
                {{-- <label class="mb-1">Image</label> --}}
                @include('shared.input', ['class' => 'col', 'name' => 'image', 'label' => 'Image', 'type' => 'file', 'value' => $produit->taille])
                {{-- <input type="file" name="image[]" multiple class="form-control" value="{{ $produit->image }}"> --}}
            </div>
            @include('shared.checkbox', ['class mx-2' => 'col', 'name' => 'disponible', 'label' => 'Disponible', 'value' => $produit->disponible])
            
            {{-- <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>
              
                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio2">Radio 2</label>
              
                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio3">Radio 3</label>
              </div> --}}

              <div class="col-md-12 mt-4">
                <div class="d-flex">
                    @php
                        // dd($produit->id);
                    @endphp
                    {{-- @if ($produit->count() !==0 ) --}}
                    @if (File::exists($produit->image))
                        {{-- @foreach ( $produit as $image ) --}}
                            <img class="border p-2 m-2" src="{{ asset($produit->image) }}" alt="image" style="width:200px;height:275px">
                            {{-- <a href="{{ route('admin.produit.destroy', $produit->id) }}">Effacer</a> --}}
                        {{-- @endforeach --}}
                    @else
                        <p>Aucune image</p>
                    @endif
                </div>
            </div>
            <div>
                <button class="btn btn-primary">
                    @if ($produit->exists)
                        Modifier
                    @else
                        Créer
                    @endif
                </button>
            </div>
        </div>
    </form>
@endsection

    
    <div class="zoom"></div> 