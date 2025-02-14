<?php

use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\ProfileController;
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

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::resource('produit', ProduitController::class);
    Route::resource('commande', CommandeController::class);
    Route::patch('commande/{commande}/validate', [CommandeController::class, 'validateCommande'])->name('commande.validate');
    //Route::patch('/admin/commandes/{id}/validate', [CommandeController::class, 'validateCommande'])->name('admin.commande.validate');

});

// Route::resource('picture', PictureController::class);

Route::get('picture/{picture}', [PictureController::class, 'destroy'])
    ->name('picture.delete')
    ->where([
        'picture' => $idRegex,
]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

        
