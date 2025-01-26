@extends('layouts.base')

@section('title', Str::limit($produit->title, 20))

@section('content')
    <style>
        .carousel-indicators img {
            width: 70px;
            display: block;
        }

        .carousel-indicators button {
            width: max-content !important;
        }
    </style>
    <div class="container mt-4">

        <hr>

        <div class="mt-4">
            <div class="row">
                <div class="col">
                   @if ($produit->count() !== 0)
                   <div class="carousel slide" id="carouselDemo" data-bs-wrap="true" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            {{-- @foreach ($produit as $key => $image ) --}}
                                    <button type="button" data-bs-target="#carouselDemo" data-bs-slide-to="{{$produit->id}}" class="{{ $produit->id == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $produit->id }}" >
                                        <img src="{{ asset($produit->image) }}" alt=""/>
                                    </button>
                            {{-- @endforeach --}}
                        </div>
                        <div class="carousel-inner">
                            {{-- @foreach ($produit as $key => $image ) --}}
                                <div class="carousel-item {{ 'active'  }}">
                                    <img class="d-block w-100" style="object-fit:cover;" src="{{ asset($produit->image) }}" alt="">
                                    <div class="carousel-caption">
                                        <h5>{{ $produit->titre }}</h5>
                                    </div>
                                </div>
                            {{-- @endforeach --}}
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselDemo" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon text-black"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselDemo"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            <div class="carousel-indicators">
                                {{-- @for ($i = 0; $i >= $produit->count(); $i++) --}}
                                    <button type="button" class="border"></button>
                                {{-- @endfor --}}
                            </div>
                        </div>
                    </div>
                   @endif
                    
                </div>
                <div class="col">
                    <h1><strong>{{ $produit->titre }}</strong></h1>
                    <div class="text-primary fw-bold" style="font-size: 4rem;">
                        {{ number_format($produit->prix, thousands_separator: ' ') }} FCFA   
                    </div>

                    <h4>{{ __('Interested in this property :title ?', ['title' => $produit->titre]) }}</h4>
                    @include('shared.flash')

                    <form action="{{ route('admin.commande.store') }}" method="post" class="vstack gap-3">
                        @csrf
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                @include('shared.input', [
                                'class' => 'col-5 visually-hidden',
                                'name' => 'produit_id',
                                'label' => 'Quantité par métre:',
                                'type' => 'number',
                                'value' => $produit->id,
                            ])
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                @include('shared.input', [
                                'class' => 'col-5 visually-hidden',
                                'name' => 'user_id',
                                'label' => 'Quantité par métre:',
                                'type' => 'number',
                                'value' => Auth::user()->id,

                            ])
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                @include('shared.input', [
                                'class' => 'col-5',
                                'name' => 'quantite',
                                'label' => 'Quantité par métre:',
                                'type' => 'number',
                                'value' => $input['quantite'] ?? '',
                            ])
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-4">
                                <button class="col-3 btn btn-primary d-flex justify-content-center">
                                    Nous contacter
                                </button>
                            </div>
                        <div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <p>{!! nl2br($produit->prix) !!}</p>
        </div>
        <div class="row">
            <div class="col-8">
                <h2>Caractéristique</h2>
                <table class="table table-striped">
                    <tr>
                        <td>titre</td>
                        <td>{{ $produit->titre }}m²</td>
                    </tr>
                    <tr>
                        <td>Piéces</td>
                        <td>{{ $produit->titre }}</td>
                    </tr>
                    <tr>
                        <td>Chambres</td>
                        <td>{{ $produit->titre }}</td>
                    </tr>
                    <tr>
                        <td>Etage</td>
                        <td>{{ $produit->titre ?: 'Rez de chaussé' }}</td>
                    </tr>
                    <tr>
                        <td>Localisation</td>
                        <td>
                            {{ $produit->prix }}<br />
                            {{ $produit->prix }} {{ $produit->prix }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-4">
                <h2>Spécificités</h2>
                <ul class="list-group">
                    {{-- @foreach ($produit->options as $option)
                        <li class="list-group-item">{{ $option->name }}</li>
                    @endforeach --}}
                </ul>
            </div>

        </div>
    </div>

@endsection
