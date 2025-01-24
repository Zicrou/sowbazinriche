<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitFormRequest;
use App\Http\Requests\Admin\UpdateProduitFormRequest;
use App\Models\Produit;
use App\Models\Picture;
use Illuminate\Support\Facades\File;


class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.produits.index",
    ["produits" => Produit::orderBy('created_at', 'desc')->paginate(25) ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('admin.produits.form', [
            'produit' => new Produit(),
            // 'types' => Type::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProduitFormRequest $request)
    {
        $data = $request->validated();
        if (request()->hasFile('image')) {
            if($image = $request->file('image')){
                $filename = $image->getClientOriginalName();
                $imageName = time().'-'.uniqid().'_'.$filename;
                $path = 'pictures/produit/';
                $data['image'] = $path.$imageName;
                // $image->storeAs($path, $imageName, 'public'); 
                $image->move($path, $imageName);
            }
        }
        $produit = Produit::create($data);
        if (request()->hasFile('images')) {
            if($images = $request->file('images')){
                foreach ($images as $image) {
                    $filename = $image->getClientOriginalName();
                    $imageName = time().'-'.uniqid().'_'.$filename;
                    $path = 'pictures/produit/'.$produit->id.'/';
                    // $image->storeAs($path, $imageName, 's3'); 

                    $image->move($path, $imageName);
                    $picture = Picture::create([
                        'images' => $path.$imageName,
                        'produit_id' => $produit->id
                    ]);
                    // PropertyPicture::create([
                    //     'picture_id' => $picture->id,
                    //     'property_id' => $property->id
                    // ]);
                }
            }
        }


        // $produit->types()->sync($request->validated('types'));
        return to_route('admin.produit.index')->with('success', 'Le produit a été créé');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        $pictures = Picture::where('produit_id', $produit->id)->get();
        // dd($pictures);
        return view('admin.produits.form', [
            'produit' => $produit, 
            'pictures' => $pictures,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduitFormRequest $request, Produit $produit)
    {
        $data = $request->validated();
        
            if($image = $request->file('image')){
                $filename = $image->getClientOriginalName();
                $imageName = time().'-'.uniqid().'_'.$filename;
                $path = 'pictures/produit/';
                $data['image'] = $path.$imageName;
                // $image->storeAs($path, $imageName, 'public'); 
                $image->move($path, $imageName);
            }
        $produit->update($data);
            if (request()->hasFile('images')) {
                if($images = $request->file('images')){
                    foreach ($images as $image) {
                        $filename = $image->getClientOriginalName();
                        
                        $path = 'pictures/produit/'.$produit->id.'/';
                        // $image->storeAs($path, $imageName, 's3'); 
                        $imageName = $path.$filename; 
                        $picture_exist = Picture::where('images', $imageName)->where('produit_id', $produit->id)->first();
                        // dd(!$picture_exist->exists());
                        
                        if(!$picture_exist->exists()){
                            $image->move($path, $filename);
                            $picture = Picture::create([
                                'images' => $path.$filename,
                                'produit_id' => $produit->id
                            ]);
                        }
                        // if($picture_exist->exists()){
                            // Si la picture existe supprimer l'ancienne and replace it Et update it again in the Database 
                            // if (File::exists($picture_exist->image)) {
                            //     File::delete($picture_exist->image);
                            // }
                            // $picture_exist->delete();
                            // $image->move($path, $filename);
                            // $picture_exist->update(['images' => $imageName]);
                        // }
                    }
                }
            }

        // $produit->types()->sync($request->validated('types'));
        return to_route('admin.produit.index')->with('success', 'Le produit a été modifié');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        // dd($produit);
        if (File::exists($produit->image)) {
            File::delete($produit->image);
        }
        $produit->delete();
        return to_route('admin.produit.index')->with('success', 'Le produit a été supprimé');
    }
}
