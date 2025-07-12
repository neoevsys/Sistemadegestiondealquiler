<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $propietario_id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $direccion
 * @property int $departamento_id
 * @property int $provincia_id
 * @property int $distrito_id
 * @property string|null $codigo_postal
 * @property string|null $telefono
 * @property string|null $email
 * @property string|null $latitud
 * @property string|null $longitud
 * @property string|null $servicios_adicionales
 * @property string|null $politicas
 * @property numeric|null $calificacion_promedio
 * @property int $estado_id
 * @property \Illuminate\Support\Carbon|null $fecha_registro
 * @property array<array-key, mixed>|null $fotos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Departamento $departamento
 * @property-read \App\Models\Distrito $distrito
 * @property-read \App\Models\EstadoCentro $estadoCentro
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Evaluacion> $evaluaciones
 * @property-read int|null $evaluaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Instalacion> $instalaciones
 * @property-read int|null $instalaciones_count
 * @property-read \App\Models\Propietario $propietario
 * @property-read \App\Models\Provincia $provincia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereCalificacionPromedio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereCodigoPostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereDepartamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereDistritoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereFechaRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereFotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo wherePoliticas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo wherePropietarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereProvinciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereServiciosAdicionales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CentroDeportivo withoutTrashed()
 */
	class CentroDeportivo extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departamento whereNombre($value)
 */
	class Departamento extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $provincia_id
 * @property string $nombre
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distrito newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distrito newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distrito query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distrito whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distrito whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distrito whereProvinciaId($value)
 */
	class Distrito extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoCentro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoCentro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoCentro query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoCentro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoCentro whereNombre($value)
 */
	class EstadoCentro extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EstadoUsuario whereNombre($value)
 */
	class EstadoUsuario extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $centro_id
 * @property int $reserva_id
 * @property int $calificacion
 * @property string|null $comentario
 * @property \Illuminate\Support\Carbon|null $fecha_evaluacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CentroDeportivo|null $centroDeportivo
 * @property-read \App\Models\Reserva|null $reserva
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereCalificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereCentroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereComentario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereFechaEvaluacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereReservaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluacion whereUsuarioId($value)
 */
	class Evaluacion extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $instalacion_id
 * @property string $dia_semana
 * @property \Illuminate\Support\Carbon $hora_inicio
 * @property \Illuminate\Support\Carbon $hora_fin
 * @property int $estado_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Instalacion|null $instalacion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereDiaSemana($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereHoraFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereInstalacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HorarioDisponibilidad whereUpdatedAt($value)
 */
	class HorarioDisponibilidad extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $centro_id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int|null $capacidad_maxima
 * @property string|null $precio_por_hora
 * @property string|null $superficie
 * @property string|null $dimensiones
 * @property string|null $equipamiento_incluido
 * @property int $estado_id
 * @property array<array-key, mixed>|null $fotos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\CentroDeportivo $centroDeportivo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HorarioDisponibilidad> $horariosDisponibilidad
 * @property-read int|null $horarios_disponibilidad_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reserva> $reservas
 * @property-read int|null $reservas_count
 * @property-read \App\Models\TipoDeporte|null $tipoDeporte
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereCapacidadMaxima($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereCentroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereDimensiones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereEquipamientoIncluido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereFotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion wherePrecioPorHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereSuperficie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Instalacion whereUpdatedAt($value)
 */
	class Instalacion extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $reserva_id
 * @property string $monto
 * @property int $metodo_pago_id
 * @property int $estado_id
 * @property \Illuminate\Support\Carbon|null $fecha_pago
 * @property string|null $referencia_transaccion
 * @property string|null $comprobante
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Reserva|null $reserva
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereComprobante($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereFechaPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMetodoPagoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereReferenciaTransaccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereReservaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereUpdatedAt($value)
 */
	class Pago extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $estado_id
 * @property string|null $logo_negocio
 * @property string|null $nombre_negocio
 * @property string|null $descripcion_negocio
 * @property string|null $telefono_negocio
 * @property string|null $email_negocio
 * @property string|null $direccion_negocio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CentroDeportivo> $centrosDeportivos
 * @property-read int|null $centros_deportivos_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereDescripcionNegocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereDireccionNegocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereEmailNegocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereLogoNegocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereNombreNegocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereTelefonoNegocio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Propietario whereUsuarioId($value)
 */
	class Propietario extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $departamento_id
 * @property string $nombre
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provincia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provincia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provincia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provincia whereDepartamentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provincia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provincia whereNombre($value)
 */
	class Provincia extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $instalacion_id
 * @property \Illuminate\Support\Carbon $fecha_reserva
 * @property \Illuminate\Support\Carbon $hora_inicio
 * @property \Illuminate\Support\Carbon $hora_fin
 * @property string|null $duracion_horas
 * @property string|null $precio_total
 * @property int $estado_id
 * @property \Illuminate\Support\Carbon $fecha_creacion
 * @property \Illuminate\Support\Carbon|null $fecha_modificacion
 * @property string|null $observaciones
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Evaluacion|null $evaluacion
 * @property-read \App\Models\Instalacion|null $instalacion
 * @property-read \App\Models\Pago|null $pago
 * @property-read \App\Models\User|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereDuracionHoras($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereFechaCreacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereFechaModificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereFechaReserva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereHoraFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereInstalacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva wherePrecioTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reserva whereUsuarioId($value)
 */
	class Reserva extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $equipamiento_requerido
 * @property string|null $icono_imagen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Instalacion> $instalaciones
 * @property-read int|null $instalaciones_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte whereEquipamientoRequerido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte whereIconoImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDeporte whereUpdatedAt($value)
 */
	class TipoDeporte extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoDocumento whereUpdatedAt($value)
 */
	class TipoDocumento extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $usuarios
 * @property-read int|null $usuarios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoUsuario whereNombre($value)
 */
	class TipoUsuario extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $apellido
 * @property string $email
 * @property string $password
 * @property string|null $telefono
 * @property \Illuminate\Support\Carbon|null $fecha_nacimiento
 * @property int $tipo_documento_id
 * @property string $numero_documento
 * @property string|null $razon_social
 * @property int $tipo_usuario_id
 * @property int $estado_id
 * @property string|null $foto_perfil
 * @property \Illuminate\Support\Carbon $fecha_registro
 * @property bool $es_admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\EstadoUsuario $estadoUsuario
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Evaluacion> $evaluaciones
 * @property-read int|null $evaluaciones_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Propietario|null $propietario
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reserva> $reservas
 * @property-read int|null $reservas_count
 * @property-read \App\Models\TipoDocumento $tipoDocumento
 * @property-read \App\Models\TipoUsuario $tipoUsuario
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereApellido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFechaRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFotoPerfil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNumeroDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRazonSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTipoDocumentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTipoUsuarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

