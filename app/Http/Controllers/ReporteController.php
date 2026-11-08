<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servicio;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function clientes()
    {
        $clientes = Cliente::with('servicio:id,nombre')->orderBy('nombre')->get();
        $servicios = Servicio::withCount('clientes')->orderBy('nombre')->get();

        $pdf = Pdf::loadView('reportes.clientes', [
            'clientes' => $clientes,
            'servicios' => $servicios,
        ]);

        return $pdf->download('informe-confiance.pdf');
    }
}
