<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'category' => 'Reservas',
                'question' => '¿Cómo puedo hacer una reserva?',
                'answer' => 'Para hacer una reserva, primero debes registrarte en nuestra plataforma. Luego busca el centro deportivo de tu preferencia, selecciona la fecha y hora disponible, y procede con el pago. Recibirás una confirmación por email.',
                'is_active' => true,
                'order' => 1
            ],
            [
                'category' => 'Reservas',
                'question' => '¿Puedo cancelar mi reserva?',
                'answer' => 'Sí, puedes cancelar tu reserva hasta 24 horas antes de la fecha programada. El reembolso se procesará automáticamente a tu método de pago original en un plazo de 3-5 días hábiles.',
                'is_active' => true,
                'order' => 2
            ],
            [
                'category' => 'Reservas',
                'question' => '¿Qué pasa si llego tarde a mi reserva?',
                'answer' => 'Si llegas tarde, tu tiempo de reserva se reducirá correspondientemente. Te recomendamos llegar 10 minutos antes de tu hora programada. No hay reembolso por tiempo perdido debido a llegadas tardías.',
                'is_active' => true,
                'order' => 3
            ],
            [
                'category' => 'Pagos',
                'question' => '¿Qué métodos de pago aceptan?',
                'answer' => 'Aceptamos tarjetas de crédito y débito Visa, MasterCard, American Express, así como pagos a través de billeteras digitales como Yape, Plin y transferencias bancarias.',
                'is_active' => true,
                'order' => 4
            ],
            [
                'category' => 'Pagos',
                'question' => '¿Es seguro pagar en línea?',
                'answer' => 'Sí, utilizamos encriptación SSL de 256 bits y procesamos todos los pagos a través de pasarelas de pago seguras y certificadas. Nunca almacenamos información sensible de tarjetas de crédito.',
                'is_active' => true,
                'order' => 5
            ],
            [
                'category' => 'Pagos',
                'question' => '¿Cuándo se cobra el pago?',
                'answer' => 'El pago se procesa inmediatamente al confirmar tu reserva. Recibirás un recibo digital por email con todos los detalles de la transacción.',
                'is_active' => true,
                'order' => 6
            ],
            [
                'category' => 'Cuenta',
                'question' => '¿Cómo creo una cuenta?',
                'answer' => 'Haz clic en "Registrarse" en la parte superior de la página. Completa el formulario con tu información personal, elige si serás cliente o propietario, y verifica tu email. ¡Es rápido y gratis!',
                'is_active' => true,
                'order' => 7
            ],
            [
                'category' => 'Cuenta',
                'question' => '¿Olvidé mi contraseña, qué hago?',
                'answer' => 'En la página de inicio de sesión, haz clic en "¿Olvidaste tu contraseña?". Ingresa tu email y te enviaremos un enlace para restablecer tu contraseña de forma segura.',
                'is_active' => true,
                'order' => 8
            ],
            [
                'category' => 'Cuenta',
                'question' => '¿Puedo cambiar mi información personal?',
                'answer' => 'Sí, puedes actualizar tu información personal en cualquier momento desde tu perfil. Ve a "Mi Cuenta" > "Editar Perfil" para modificar tus datos.',
                'is_active' => true,
                'order' => 9
            ],
            [
                'category' => 'Propietarios',
                'question' => '¿Cómo puedo registrar mi centro deportivo?',
                'answer' => 'Primero regístrate como propietario en nuestra plataforma. Luego accede a tu panel de control y selecciona "Agregar Centro Deportivo". Completa toda la información requerida y sube fotos de alta calidad.',
                'is_active' => true,
                'order' => 10
            ],
            [
                'category' => 'Propietarios',
                'question' => '¿Cuánto cobran de comisión?',
                'answer' => 'Cobramos una comisión del 8% sobre cada reserva completada. Esta comisión se descuenta automáticamente de los pagos que recibas. No hay costos ocultos ni tarifas de membresía.',
                'is_active' => true,
                'order' => 11
            ],
            [
                'category' => 'Propietarios',
                'question' => '¿Cuándo recibo mis pagos?',
                'answer' => 'Los pagos se transfieren a tu cuenta bancaria cada 15 días. Puedes ver el estado de tus pagos y descargar reportes detallados desde tu panel de propietario.',
                'is_active' => true,
                'order' => 12
            ],
            [
                'category' => 'Soporte',
                'question' => '¿Cómo puedo contactar con soporte?',
                'answer' => 'Puedes contactarnos a través del chat en vivo en nuestra página web, enviar un email a soporte@ctmundial.com, o llamar a nuestro número de atención al cliente: (01) 234-5678.',
                'is_active' => true,
                'order' => 13
            ],
            [
                'category' => 'Soporte',
                'question' => '¿Cuál es el horario de atención?',
                'answer' => 'Nuestro equipo de soporte está disponible de lunes a viernes de 8:00 AM a 8:00 PM, y sábados de 9:00 AM a 5:00 PM. El chat en vivo está disponible 24/7.',
                'is_active' => true,
                'order' => 14
            ],
            [
                'category' => 'General',
                'question' => '¿En qué ciudades están disponibles?',
                'answer' => 'Actualmente operamos en Lima, Arequipa, Cusco, Trujillo y Chiclayo. Estamos expandiéndonos constantemente a nuevas ciudades. ¡Mantente atento a nuestras novedades!',
                'is_active' => true,
                'order' => 15
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
