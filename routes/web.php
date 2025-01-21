<?php

use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Boutique\BoutiqueController;
use Illuminate\Support\Facades\Route;

$idRegex   = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

// Route::prefix('boutique')->name('boutique.')->group(function (){
    Route::get('/boutique', [BoutiqueController::class, 'index'])->name('boutique.index');
    Route::get('/boutique/{slug}-{produit}', [BoutiqueController::class, 'show'])->name('boutique.show')->where([
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


