<?php

use App\Http\Controllers\Admin\ProduitController;
use Illuminate\Support\Facades\Route;

$idRegex   = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

// Refactor Boutique to use ProduitController instead of BoutiqueController, and remove the BoutiqueController
// Route::prefix('boutique')->name('boutique.')->group(function (){
    Route::get('/produit', [App\Http\Controllers\ProduitController::class, 'index'])->name('produit.index');
    Route::get('/produit/{slug}-{produit}', [App\Http\Controllers\ProduitController::class, 'show'])->name('produit.show')->where([
        'produit' => $idRegex,
        'slug'     => $slugRegex,
    ]);
    // });
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('produit', ProduitController::class);
});


