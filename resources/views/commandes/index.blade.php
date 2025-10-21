@extends('layouts.base')

@section('title', 'Tous les produits')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    /* .card p {
        font-family: 'Open Sans';
        color: #333;
    } */
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
    {{ $commandes->links() }}
    <section>
        <div class="container">
            @foreach ($commandes as $commande)
                @if ($commande->lineItems->isEmpty())
                    <p>Pas de produit dans le panier</p>
                @else 
                    @foreach ($commande->lineItems as $item)
                        <div class="card col-10 mx-auto mb-3"  style="background-color: white;">
                            <div class="card-header bg-white">
                                <h2 class="mx-2 text-start">{{ $item->produit->titre}}</h2>
                                <div class="row d-flex line-item justify-content-start">
                                    <div class="col-6 col-lg-6 mx-2 ">
                                        <p>
                                            <img class="d-block w-50" style="height:auto; object-fit:cover;" src="{{ asset($item->produit->image) }}" alt="">
                                        </p>
                    
                                    </div>
                                    <div class="col-6 col-lg-3 gap-3 mt-4">
                                        <p>Prix: {{ number_format($item->produit->prix, thousands_separator: ' ') }}</p>
                                        <p>Quantite: {{ $item->quantite }} </p>
                                        {{-- <label for="">Quantite</label>
                                        <input type="number"
                                            class="quantite form-control"
                                            value="{{ $item->quantite }}"
                                            min="1"
                                            data-prix="{{ $item->prix_unitaire }}" disabled readonly> --}}
                                            <p class="mt-3">Statut:  @if($commande->status == 'en_attente') En Attente @elseif ($commande->status == 'en_cours') En cours @endif </p>
                                        <p class="total">Total: {{ number_format($item->quantite  * $item->produit->prix, 0, ',', ' ') . " FCFA" }}</p>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card-footer d-flex gap-2 justify-content-evenly">
                                <span>Text</span>                                
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
            {{ $commandes->links() }}
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