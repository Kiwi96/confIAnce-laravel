<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicioController extends Controller
{
    private function reglas(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'activo' => 'boolean',
        ];
    }

    // Público: solo servicios activos
    public function index()
    {
        return Servicio::where('activo', true)->orderBy('nombre')->get();
    }

    // Panel: todos, activos e inactivos
    public function todos()
    {
        return Servicio::orderBy('nombre')->get();
    }

    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());

        return response()->json(Servicio::create($datos), 201);
    }

    public function show(Servicio $servicio)
    {
        return $servicio;
    }

    public function update(Request $request, Servicio $servicio)
    {
        $datos = $request->validate($this->reglas());
        $servicio->update($datos);

        return $servicio;
    }

        public function destroy(Servicio $servicio)
    {
        if ($servicio->imagen) {
            Storage::disk('public')->delete($servicio->imagen);
        }
        $servicio->delete();

        return response()->json(['mensaje' => 'Servicio eliminado']);
    }

        public function subirImagen(Request $request, Servicio $servicio)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($servicio->imagen) {
            Storage::disk('public')->delete($servicio->imagen);
        }

        $ruta = $request->file('imagen')->store('servicios', 'public');
        $servicio->update(['imagen' => $ruta]);

        return $servicio;
    }
}