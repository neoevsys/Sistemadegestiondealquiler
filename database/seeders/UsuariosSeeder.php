<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar usuario administrador principal
        DB::table('usuarios')->insert([
            'nombre' => 'Admin',
            'apellido' => 'Principal',
            'email' => 'admin@plataforma.com',
            'password' => Hash::make('12345678'),
            'telefono' => '900000000',
            'fecha_nacimiento' => '1990-01-01',
            'tipo_documento_id' => 1, // DNI
            'numero_documento' => '00000001',
            'razon_social' => null,
            'tipo_usuario_id' => 1, // Asume que 1 es administrador
            'estado_id' => 1, // Asume que 1 es activo
            'foto_perfil' => 'https://randomuser.me/api/portraits/men/1.jpg',
            'fecha_registro' => Carbon::now(),
            'es_admin' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Insertar 9 usuarios normales
        for ($i = 2; $i <= 10; $i++) {
            $isPropietario = $i >= 7;
            $tipoDocumentoId = $isPropietario ? 2 : 1; // 2 = RUC, 1 = DNI
            $numeroDocumento = $isPropietario ? str_pad($i, 11, '2', STR_PAD_LEFT) : str_pad($i, 8, '0', STR_PAD_LEFT);
            $razonSocial = $isPropietario ? 'Razon Social Demo '.$i : null;
            DB::table('usuarios')->insert([
                'nombre' => 'Usuario'.$i,
                'apellido' => 'Demo',
                'email' => 'usuario'.$i.'@mail.com',
                'password' => Hash::make('12345678'),
                'telefono' => '90000000'.$i,
                'fecha_nacimiento' => '1995-01-0'.($i%9+1),
                'tipo_documento_id' => $tipoDocumentoId,
                'numero_documento' => $numeroDocumento,
                'razon_social' => $razonSocial,
                'tipo_usuario_id' => $isPropietario ? 3 : 2, // 3 propietario, 2 cliente
                'estado_id' => 1, // Activo
                'foto_perfil' => 'https://randomuser.me/api/portraits/men/'.($i+10).'.jpg',
                'fecha_registro' => Carbon::now(),
                'es_admin' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Crear propietarios solo para usuarios de prueba (no admin)
        $usuarios = DB::table('usuarios')->where('es_admin', false)->get();
        foreach ($usuarios as $usuario) {
            // Solo algunos usuarios serán propietarios (por ejemplo, los últimos 5)
            if ($usuario->id >= 7) {
                // Actualizar tipo_usuario_id a 3 (propietario)
                DB::table('usuarios')->where('id', $usuario->id)->update([
                    'tipo_usuario_id' => 3
                ]);
                DB::table('propietarios')->insert([
                    'usuario_id' => $usuario->id,
                    'estado_id' => 1, // Asume que 1 es aprobado
                    'logo_negocio' => null,
                    'nombre_negocio' => 'Negocio ' . $usuario->nombre,
                    'descripcion_negocio' => 'Negocio deportivo demo de ' . $usuario->nombre,
                    'telefono_negocio' => $usuario->telefono,
                    'email_negocio' => 'negocio' . $usuario->id . '@mail.com',
                    'direccion_negocio' => 'Calle ' . $usuario->id . ', Ciudad',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
