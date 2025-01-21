<div @class(['card']) style="m-0 p-0 min-width: 124px;">
    <div class="card-body">
        <h5 class="card-title">
            <a
                href="">{{ Str::limit($produit->titre, 40) }}</a>
        </h5>
        <hr>
        <p class="card-text">{{ $produit->taille }} yard</p>
        <div class="text-primary fw-bold" style="font-size: 1.4rem;">{!! $produit->getFormatedPrice() !!}</div>
    </div>
</div>
