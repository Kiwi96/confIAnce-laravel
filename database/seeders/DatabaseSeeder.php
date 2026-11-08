<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario de demostración (cambia el correo y la clave si quieres)
        User::updateOrCreate(
            ['email' => 'admin@confiance.test'],
            ['name' => 'Administrador', 'password' => 'Confiance2026x']
        );

        $servicios = [
            ['nombre' => 'Gobernanza IA', 'categoria' => 'Gobernanza de IA', 'descripcion' => 'Diseño e implementación de políticas para el uso responsable de inteligencia artificial.', 'precio_base' => 4500000],
            ['nombre' => 'Analítica Jurídica', 'categoria' => 'Analítica jurídica', 'descripcion' => 'Transformamos datos legales en información estratégica para la toma de decisiones.', 'precio_base' => 3800000],
            ['nombre' => 'Automatización Legal', 'categoria' => 'Analítica jurídica', 'descripcion' => 'Optimización de procesos jurídicos mediante herramientas de inteligencia artificial.', 'precio_base' => 4200000],
            ['nombre' => 'Cumplimiento Tecnológico', 'categoria' => 'Cumplimiento', 'descripcion' => 'Acompañamiento para cumplir la normativa aplicable a sistemas y datos de tu organización.', 'precio_base' => 3500000],
            ['nombre' => 'Derecho Digital', 'categoria' => 'Protección de datos', 'descripcion' => 'Asesoría jurídica en protección de datos, contratos tecnológicos y entornos digitales.', 'precio_base' => 3000000],
            ['nombre' => 'Transformación Legal-Tech', 'categoria' => 'LegalTech', 'descripcion' => 'Acompañamos a firmas y áreas legales en la adopción de soluciones tecnológicas propias.', 'precio_base' => 5000000],
        ];

        foreach ($servicios as $s) {
            Servicio::updateOrCreate(['nombre' => $s['nombre']], $s + ['activo' => true]);
        }

        // nombre, sector, país, correo, teléfono, servicio
        $clientes = [
            ['Clínica Salud Total S.A.S.', 'Salud', 'Colombia', 'contacto@saludtotal.co', '3001112233', 'Derecho Digital'],
            ['FinPay Latam', 'Fintech', 'México', 'legal@finpay.mx', '5512345678', 'Cumplimiento Tecnológico'],
            ['EduTech Andina', 'Educación', 'Perú', 'info@edutechandina.pe', '987654321', 'Gobernanza IA'],
            ['Bufete Ramírez & Asociados', 'Legal', 'Colombia', 'admin@bufeteramirez.co', '3109876543', 'Transformación Legal-Tech'],
            ['Logística Pacífico', 'Logística', 'Chile', 'ti@logpacifico.cl', null, 'Analítica Jurídica'],
            ['RetailMax Colombia', 'Comercio', 'Colombia', 'datos@retailmax.co', '3201234567', 'Derecho Digital'],
            ['Seguros Horizonte', 'Seguros', 'Colombia', 'cumplimiento@horizonte.co', '3157778899', 'Cumplimiento Tecnológico'],
        ];

        foreach ($clientes as [$nombre, $sector, $pais, $email, $telefono, $servicio]) {
            Cliente::updateOrCreate(
                ['email' => $email],
                [
                    'nombre' => $nombre,
                    'sector' => $sector,
                    'pais' => $pais,
                    'telefono' => $telefono,
                    'servicio_id' => Servicio::where('nombre', $servicio)->value('id'),
                ]
            );
        }
    }
}