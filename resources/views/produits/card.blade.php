<div @class(['card']) style="m-0 p-0;">
    <a href="{{ route('produit.show', ['slug' => $produit->getSlug(), 'produit' => $produit]) }}">
        <img class="card-img-top img-fluid rounded-start" src="{{ asset($produit->image) }}" alt="image">
    </a>
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ route('produit.show', ['slug' => $produit->getSlug(), 'produit' => $produit]) }}">{{ Str::limit($produit->titre, 40) }}</a>
        </h5>
        <div class="d-flex justify-content-start">
            <p class="card-text">
                <span class="justify-content-start">{!! $produit->getFormatedPrice() !!} /</span>
                <span class="text-end">{{ $produit->taille }}métres</span>
            </p>

        </div>
        <p class="card-text"></p>
        <a href="#" class="btn btn-primary">Commander</a>
    </div>
</div>
