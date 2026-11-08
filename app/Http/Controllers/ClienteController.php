<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    private function reglas(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'sector' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:30',
            'servicio_id' => 'nullable|exists:servicios,id',
        ];
    }

    public function index()
    {
        return Cliente::with('servicio:id,nombre')->orderBy('nombre')->get();
    }

    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());
        $cliente = Cliente::create($datos);

        return response()->json($cliente->load('servicio:id,nombre'), 201);
    }

    public function show(Cliente $cliente)
    {
        return $cliente->load('servicio:id,nombre');
    }

    public function update(Request $request, Cliente $cliente)
    {
        $datos = $request->validate($this->reglas());
        $cliente->update($datos);

        return $cliente->load('servicio:id,nombre');
    }

        public function destroy(Cliente $cliente)
    {
        if ($cliente->logo) {
            Storage::disk('public')->delete($cliente->logo);
        }
        $cliente->delete();

        return response()->json(['mensaje' => 'Cliente eliminado']);
    }

        public function subirLogo(Request $request, Cliente $cliente)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($cliente->logo) {
            Storage::disk('public')->delete($cliente->logo);
        }

        $ruta = $request->file('logo')->store('clientes', 'public');
        $cliente->update(['logo' => $ruta]);

        return $cliente->load('servicio:id,nombre');
    }
}