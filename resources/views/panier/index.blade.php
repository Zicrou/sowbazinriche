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
    {{-- {{ $paniers->links() }} --}}
    <section>
        <div class="container">
            @foreach ($paniers as $panier)
                @if ($panier->lineItems->isEmpty())
                    <p>Pas de produit dans le panier</p>
                @else 
                @foreach ($panier->lineItems as $item)
                @unless ($item->commande_id != null)
                    
                <div class="card col-10 mx-auto mb-3"  style="background-color: white;">
                    <div class="card-header bg-white">
                        <h2 class="text-start mx-2">{{ $item->produit->titre}}</h2>
                        <div class="row d-flex line-item">
                            <div class="col-12 col-lg-6 mx-2 d-flex justify-content-center">
                                <p>
                                    <img class="d-block w-50" style="height:auto; object-fit:cover;" src="{{ asset($item->produit->image) }}" alt="">
                                </p>
            
                            </div>
                            <div class="col-12 col-lg-3 gap-3 mx-3">
                                <p>Prix: {{ number_format($item->produit->prix, thousands_separator: ' ') }}</p>
                                <label for="">Quantite</label>
                                <input type="number"
                                    class="quantite form-control"
                                    value="{{ $item->quantite }}"
                                    min="1"
                                    data-prix="{{ $item->prix_unitaire }}">
                                    
                                <p class="total">Total: {{ number_format($item->quantite  * $item->produit->prix, 0, ',', ' ') . " FCFA" }}</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer d-flex gap-2 justify-content-evenly">
                        <form action="{{ route('admin.commande.store', $item) }}" method="post">
                            @csrf
                            <button class="btn btn-outline-primary">Valider</button>
                        </form>
                        {{-- <a href="{{ route('admin.commande.store', $item) }}" class="btn btn-outline-primary">Valider</a>  --}}
                        {{-- <a href="{{ route('admin.commande.edit', $item) }}" class="btn btn-outline-warning">Editer</a> --}}
                        <form action="{{ route('lineItems.destroy', $item) }}" method="post"> 
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger delete-line-item" data-id="{{ $item->id }}"" id="delete">Supprimer</button>
                        </form>
                        
                    </div>
                </div>
                @endunless
            @endforeach
                @endif
                
            @endforeach
            {{ $paniers->links() }}
        
        </div>
    </section>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    const quantites = document.querySelectorAll(".quantite");

    quantites.forEach(input => {
        input.addEventListener("input", function() {
            const prix = parseFloat(this.dataset.prix);
            const quantite = parseInt(this.value);
            const card = this.closest(".card"); // 🔥 On cherche le parent .card
            const totalElement = card ? card.querySelector(".total") : null;

            if (!totalElement) {
                console.error("⚠️ Aucun élément '.total' trouvé pour cet input");
                return;
            }

            const total = isNaN(quantite) ? 0 : prix * quantite;
            totalElement.textContent = `Total: ${total.toLocaleString('fr-FR', { style: 'currency', currency: 'XOF' })}`;
        });
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".delete-line-item").forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault();

            const lineItemId = this.dataset.id;
            if (!confirm("Voulez-vous vraiment supprimer ce produit ?")) return;

            fetch(`/lineItems/${lineItemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error(`Erreur réseau: ${res.status}`);
                return res.json();
            })
            .then(data => {
                // console.log(data.success); // 🔹 Vérifie la réponse côté console
                if (data === 1) {
                    alert(data.message);
                    location.reload(); // ou supprimer l’élément du DOM
                } else {
                    alert(data.message || "Erreur lors de la suppression");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Erreur lors de la suppression");
            });
        });
    });
});
</script>