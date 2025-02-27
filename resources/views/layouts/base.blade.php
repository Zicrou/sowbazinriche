<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <title>@yield('title') | User</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark" style="background-color: black;">
        <div class="container-fluid">
          <a class="navbar-brand py-0 m-0" href="/"><img class="p-0 m-0" src="{{ asset("pictures/logo.jpg")}}" style=" width:4rem;" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          @php
              $route = request()->route()->getName();
          @endphp
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
              </li>
              <li class="nav-item">
                <a href="{{ route("produit.index")}}" @class(["nav-link", "active" => str_contains($route, 'produit.')]) aria-current="page">Boutique</a>
              </li>
              <li class="nav-item">
                <a href="{{ route("admin.commande.index")}}" @class(["nav-link", "active" => str_contains($route, 'commande.')]) aria-current="page">Panier</a>
              </li>
            </ul>
            <div class="ms-auto">
              @auth
              <ul class="navbar-nav">
                <li class="nav-item ">
                  <a href="{{  route('dashboard') }}" @class(["nav-link", "fw-bold"]) aria-current="page">Dashboard</a>
                </li>
              </ul> 
              @elseguest
              <ul class="navbar-nav">
                <li class="nav-item ">
                  <a href="{{ route('login') }}" @class(["nav-link", "fw-bold"]) aria-current="page">Se connecter</a>
                </li>
                <li class="nav-item ">
                  <a href="{{ route('register') }}" @class(["nav-link", "fw-bold"]) aria-current="page">S'inscrire</a>
                </li>
              </ul> 
              @endauth
            </div>
          </div>
        </div>
    </nav>
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="my-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    <script>
    //   new TomSelect("#types[multiple]", {plugins: {remove_button: {title: 'Supprimer'}}}); 
    //   new TomSelect("#produit_id", {plugins: {remove_button: {title: 'Supprimer'}}});
    </script>
</body>
</html>