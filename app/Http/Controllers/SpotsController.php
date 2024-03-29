<?php

namespace App\Http\Controllers;

use App\Models\advertisings;
use App\Models\articles;
use App\Models\cliente;
use App\Models\spots;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Storage;

class SpotsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publi = spots::paginate(5);
        return view('publicidad.index', compact('publi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = cliente::pluck('id', 'nombre');
        $publi = advertisings::get(['id', 'nombre', 'descripcion']);
        return view('spots.create', compact('publi', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'image.required' => 'El archivo de la imagen debe ser seleccionada.',
            'image.image' => 'El archivo de la imagen debe ser una imagen.',
            'image.mimes' => 'El archivo de la imagen debe ser de tipo: :values.',
        ];
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ], $messages);

        $spot = new spots;
        $spot->cliente_id = $request->cliente;
        $spot->advertising_id = $request->publicidad;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $path = Storage::putFile('public/publicidad/botones', $request->file('image'));
            $nuevo_path = str_replace('public/', '', $path);
            $spot->boton = $nuevo_path;
        }
        $spot->save();

        return redirect()->route('publicidad.index')->with('success', 'publicidad creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(spots $spots)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(spots $spots)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, spots $spots)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $spot = Spots::findOrFail($id);

        // Eliminar imagen asociada si existe
        if ($spot->boton) {
            Storage::delete('public/' . $spot->boton);
        }

        // Eliminar el registro del spot
        $spot->delete();

        return redirect()->route('publicidad.index')->with('success', 'Publicidad eliminada correctamente.');
    }

    public function pstore($id)
    {
        $spotId =$id;
        

        $articles = Articles::where('spot_id', $spotId)->paginate(1);
        $contador=$articles->count();

        $identificador = $id;
        return view('publicidad.pubstore', compact('identificador','articles','contador'));
    }
}
