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
    <div class="container mt-1">

        <hr>
<!-- Carousel with thumbnails -->
<style>
  .gallery {
    max-width: 900px;
    margin: 0 auto;
    user-select: none;
  }

  .carousel {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    background: #f8f8f8;
  }

  .carousel-track {
    display: flex;
    transition: transform 300ms ease;
    will-change: transform;
  }

  .carousel-slide {
    min-width: 100%;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
  }

  .carousel-slide img {
    max-width: 100%;
    max-height: 60vh;
    object-fit: contain;
    display:block;
  }

  .carousel-controls {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    pointer-events: none;
  }

  .carousel-controls button {
    pointer-events: auto;
    background: rgba(0,0,0,0.45);
    color: #fff;
    border: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin: 0 8px;
  }

  /* thumbnails */
  .thumbs {
    margin-top: 12px;
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 6px;
  }

  .thumb {
    flex: 0 0 auto;
    width: 96px;
    height: 64px;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    box-sizing: border-box;
  }

  .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display:block;
  }

  .thumb.active {
    border-color: #007bff;
  }

  /* nice scrollbar fallback */
  .thumbs::-webkit-scrollbar { height: 8px; }
  .thumbs::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 4px; }

  /* small screens */
  @media (max-width: 520px) {
    .thumb { width: 72px; height: 48px; }
  }
</style>

<div class="row">
    <div class="col-8">
        <div class="gallery" id="gallery1" data-gallery>
            <div class="carousel" data-carousel>
                <div class="carousel-track" data-track>
                    @foreach($images as $i => $img)
                        <div class="carousel-slide" data-slide>
                            <img loading="lazy" src="{{ asset($img->images) }}" alt="{{ $img['alt'] }}">
                        </div>
                    @endforeach
                </div>

                <!-- controls -->
                <div class="carousel-controls" aria-hidden="false">
                    <button type="button" data-prev aria-label="Précédent">‹</button>
                    <button type="button" data-next aria-label="Suivant">›</button>
                </div>
            </div>

            <div class="thumbs" data-thumbs>
            @foreach($images as $i => $img)
                <div class="thumb" data-thumb data-index="{{ $i }}"><img src="{{ asset($img->images) }}" alt="{{ $img['alt'] }}"></div>
            @endforeach
            </div>

        </div>
    </div>
    <div class="col-4">
        <h1><strong>{{ $produit->titre }}</strong></h1>
        <div class="text-primary fw-bold" style="font-size: 4rem;">
            {{ number_format($produit->prix, thousands_separator: ' ') }} FCFA   
        </div>

        {{-- <h4>{{ __('Interested in this property :title ?', ['title' => $produit->titre]) }}</h4> --}}
        
        @include('shared.flash')

        <form action="{{ route('panier.store') }}" method="post" class="vstack gap-3">
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
                    'label' => 'User:',
                    'type' => 'number',
                    'value' => Auth::check() ? Auth::user()->id : '' ,

                ])
                </div>
                {{-- <div class="col-12 d-flex justify-content-center">
                    @include('shared.input', [
                    'class' => 'col-5 visually-hidden',
                    'name' => 'quantite',
                    'label' => 'Quantité:',
                    'type' => 'number',
                    'value' => $input['quantite'] ?? '',
                ])
                </div> --}}
                <div class="col-12 m-5">
                    @if (Auth::check() and Auth::user()->role == "user")
                        <button class="col-4 btn btn-primary mx-5">
                            Ajouter au Panier
                        </button>
                    @endif
                </div>
            <div>
            </div>
        </form>
    </div>
</div>

<script>
  (function () {
    // Simple, reusable carousel component
    function initGallery(root) {
      const track = root.querySelector('[data-track]');
      const slides = Array.from(root.querySelectorAll('[data-slide]'));
      const thumbs = Array.from(root.querySelectorAll('[data-thumb]'));
      const prevBtn = root.querySelector('[data-prev]');
      const nextBtn = root.querySelector('[data-next]');
      let index = 0;
      let startX = null;

      function update() {
        const width = root.querySelector('.carousel').clientWidth;
        track.style.transform = `translateX(${-index * width}px)`;
        thumbs.forEach(t => t.classList.remove('active'));
        if (thumbs[index]) {
          thumbs[index].classList.add('active');
          // ensure thumbnail is visible in scroll viewport
          thumbs[index].scrollIntoView({behavior: 'smooth', inline: 'center', block: 'nearest'});
        }
      }

      function goTo(i) {
        index = Math.max(0, Math.min(i, slides.length - 1));
        update();
      }

      function next() { goTo(index + 1); }
      function prev() { goTo(index - 1); }

      // click thumbnails
      thumbs.forEach((thumb, i) => {
        thumb.addEventListener('click', (e) => { goTo(i); });
        thumb.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); goTo(i); }
        });
      });

      // controls
      if (prevBtn) prevBtn.addEventListener('click', prev);
      if (nextBtn) nextBtn.addEventListener('click', next);

      // keyboard
      root.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') next();
        if (e.key === 'ArrowLeft') prev();
      });

      // handle resize
      window.addEventListener('resize', update);

      // touch support
      const carousel = root.querySelector('.carousel');
      carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
      });
      carousel.addEventListener('touchend', (e) => {
        if (startX === null) return;
        const endX = e.changedTouches[0].clientX;
        const dx = startX - endX;
        if (Math.abs(dx) > 40) {
          if (dx > 0) next(); else prev();
        }
        startX = null;
      });

      // init
      goTo(0);
      // allow focus to root for keyboard support
      root.setAttribute('tabindex', '0');
    }

    document.querySelectorAll('[data-gallery]').forEach(initGallery);
  })();
</script>

        <div class="mt-4">
            <p>{!! nl2br($produit->prix) !!}</p>
        </div>
        <div class="row">
            <div class="col-8">
                <h2>Caractéristique</h2>
                <table class="table table-striped">
                    <tr>
                        <td>Couleur</td>
                        <td>Bleu, Vert, Rouge</td>
                    </tr>
                    <tr>
                        <td>Temps de livraison</td>
                        <td>15jours</td>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>