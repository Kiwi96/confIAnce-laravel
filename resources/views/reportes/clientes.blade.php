<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Informe ConfIAnce</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h1 { color: #ea580c; font-size: 22px; margin: 0; }
        h2 { color: #ea580c; font-size: 14px; margin: 28px 0 8px; border-bottom: 2px solid #ea580c; padding-bottom: 4px; }
        .sub { color: #666; margin: 4px 0 20px; }
        .resumen td { padding: 10px 16px; background: #fff7ed; border: 1px solid #fed7aa; text-align: center; }
        .resumen .num { font-size: 20px; font-weight: bold; color: #ea580c; }
        table.datos { width: 100%; border-collapse: collapse; }
        table.datos th { background: #ea580c; color: #fff; text-align: left; padding: 6px 8px; }
        table.datos td { padding: 6px 8px; border-bottom: 1px solid #e5e5e5; }
        table.datos tr:nth-child(even) td { background: #fafafa; }
        .der { text-align: right; }
        .pie { margin-top: 30px; text-align: center; color: #999; font-size: 9px; }
    </style>
</head>
<body>
    <h1>ConfIAnce</h1>
    <p class="sub">Informe de clientes y servicios · Generado el {{ now()->format('d/m/Y H:i') }}</p>

    <table class="resumen" style="border-spacing: 8px 0;">
        <tr>
            <td><div class="num">{{ $servicios->count() }}</div>Servicios</td>
            <td><div class="num">{{ $servicios->where('activo', true)->count() }}</div>Activos</td>
            <td><div class="num">{{ $clientes->count() }}</div>Clientes</td>
            <td><div class="num">{{ $clientes->pluck('pais')->unique()->count() }}</div>Países</td>
        </tr>
    </table>

    <h2>Servicios y clientes asociados</h2>
    <table class="datos">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Categoría</th>
                <th class="der">Precio base</th>
                <th>Estado</th>
                <th class="der">Clientes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicios as $s)
                <tr>
                    <td>{{ $s->nombre }}</td>
                    <td>{{ $s->categoria }}</td>
                    <td class="der">${{ number_format($s->precio_base, 0, ',', '.') }}</td>
                    <td>{{ $s->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td class="der">{{ $s->clientes_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Listado de clientes</h2>
    <table class="datos">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Sector</th>
                <th>País</th>
                <th>Correo</th>
                <th>Servicio</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clientes as $c)
                <tr>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->sector }}</td>
                    <td>{{ $c->pais }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->servicio?->nombre ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay clientes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="pie">ConfIAnce · Derecho, inteligencia artificial, datos y seguridad digital</p>
</body>
</html>