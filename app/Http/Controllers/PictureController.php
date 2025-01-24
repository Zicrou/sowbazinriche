<?php

namespace App\Http\Controllers;

use App\Http\Requests\PictureFormRequest;
use App\Models\Picture;
use App\Models\Produit;
use Illuminate\Support\Facades\File;


class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pictures.index",[
            "pictures" => Picture::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('pictures.form', [
            'picture' => new Picture(),
            // 'types' => Type::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PictureFormRequest $request)
    {
        $data = $request->validated();
        //dd($data['image']);
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
        // dd($produit);

        // $produit->types()->sync($request->validated('types'));
        return to_route('admin.produit.index')->with('success', 'Le produit a été créé');
    }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        return view('pictures.form', [
            'produit' => $produit, 
            // 'types' => Type::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PictureFormRequest $request, Produit $produit)
    {
        $data = $request->validated();
        $produit->update($data);
        // $produit->types()->sync($request->validated('types'));
        return to_route('admin.produit.index')->with('success', 'Le produit a été modifié');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Picture $picture)
    {
        if (File::exists($picture->images)) {
            File::delete($picture->images);
        }
        $produit = $picture->produit_id;
        $picture->delete();
        return to_route('admin.produit.edit', $produit)->with('success', 'Photo supprimée');
    }
}
