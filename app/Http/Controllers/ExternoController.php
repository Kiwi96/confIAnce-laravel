<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ExternoController extends Controller
{
    // Tasa dólar a peso colombiano (ExchangeRate-API)
    public function dolar()
    {
        $datos = Cache::get('dolar_cop');

        if (! $datos) {
            try {
                $respuesta = Http::timeout(15)->acceptJson()->get('https://open.er-api.com/v6/latest/USD');
            } catch (\Throwable $e) {
                Log::error('ExchangeRate-API no responde: ' . $e->getMessage());

                return response()->json(['mensaje' => 'No se pudo conectar con la API del dólar.'], 502);
            }

            $cop = $respuesta->json('rates.COP');

            if ($respuesta->failed() || ! $cop) {
                Log::error('ExchangeRate-API respuesta inesperada: ' . $respuesta->status() . ' ' . Str::limit($respuesta->body(), 500));

                return response()->json(['mensaje' => 'No se pudo consultar la tasa del dólar.'], 502);
            }

            $datos = [
                'cop' => (float) $cop,
                'actualizado' => $respuesta->json('time_last_update_utc'),
            ];

            Cache::put('dolar_cop', $datos, now()->addHour());
        }

        return response()->json($datos);
    }
}