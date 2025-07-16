# 🏟️ Sistema de Gestión de Alquiler de Centros Deportivos

Un sistema completo para la gestión de centros deportivos, reservas y pagos online desarrollado en Laravel 11.

## 📋 Descripción del Proyecto

**CTMundial** es una plataforma web que permite a los propietarios de centros deportivos gestionar sus instalaciones y a los usuarios realizar reservas y pagos online. El sistema incluye gestión automática de reservas, integración con pasarelas de pago y un panel de administración completo.

## 🎯 Funcionalidades Principales

### 👥 **Para Usuarios (Clientes)**
- ✅ Registro y autenticación
- ✅ Búsqueda y navegación de centros deportivos
- ✅ Reserva de instalaciones por horas
- ✅ Pago online con Izipay
- ✅ Historial de reservas y pagos
- ✅ Sistema de evaluaciones

### 🏢 **Para Propietarios**
- ✅ Gestión completa de centros deportivos
- ✅ Administración de instalaciones y horarios
- ✅ Panel de reservas en tiempo real
- ✅ Gestión de pagos y transacciones
- ✅ Reportes y estadísticas
- ✅ Sistema de confirmación/cancelación

### 🤖 **Gestión Automática**
- ✅ Cancelación automática de reservas impagadas (24h)
- ✅ Completación automática de reservas finalizadas
- ✅ Actualización de estados cada hora
- ✅ Liberación automática de horarios

## 🔧 Requisitos del Sistema

### **Requisitos Mínimos:**
- PHP 8.1 o superior
- Composer
- Node.js 16+ y npm
- MySQL 8.0 o superior
- Apache/Nginx

### **Extensiones PHP Requeridas:**
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- JSON
- Ctype
- Fileinfo
- GD (para procesamiento de imágenes)

## 🚀 Instalación Paso a Paso

### **1. Clonar el Repositorio**
```bash
git clone https://github.com/neoevsys/Sistemadegestiondealquiler.git
cd Sistemadegestiondealquiler
```

### **2. Instalar Dependencias**
```bash
# Instalar dependencias PHP
composer install

# Instalar dependencias Node.js
npm install
```

### **3. Configurar Variables de Entorno**
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### **4. Configurar Base de Datos**
Editar el archivo `.env` con los datos de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_alquiler
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### **5. Configurar Pagos (Izipay)**
Agregar al archivo `.env`:
```env
IZIPAY_USERNAME=tu_usuario_izipay
IZIPAY_PASSWORD=tu_password_izipay
IZIPAY_ENDPOINT=https://api.micuentaweb.pe
IZIPAY_PUBLIC_KEY=tu_clave_publica
IZIPAY_HMAC_KEY=tu_clave_hmac
```

### **6. Ejecutar Migraciones y Seeders**
```bash
# Método 1: Ejecutar todo desde 0
php artisan migrate:fresh --seed

# Método 2: Usar script automatizado (Windows)
./reset_migrations.bat

# Método 3: Paso a paso
php artisan migrate
php artisan db:seed
```

### **7. Generar Assets**
```bash
# Compilar assets para desarrollo
npm run dev

# Compilar assets para producción
npm run build
```

### **8. Configurar Permisos (Linux/Mac)**
```bash
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/cache/
```

### **9. Configurar Scheduler (Producción)**
Agregar al crontab del servidor:
```bash
crontab -e

# Agregar esta línea:
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### **10. Levantar el Servidor**
```bash
# Servidor de desarrollo
php artisan serve

# El sitio estará disponible en: http://localhost:8000
```

## 📊 Usuarios Demo

El sistema incluye usuarios demo creados automáticamente:

### **Propietarios:**
- **Email:** `propietario1@mail.com`
- **Email:** `propietario2@mail.com`
- **Contraseña:** `password123`

### **Clientes:**
- **Email:** `cliente1@mail.com`
- **Email:** `cliente2@mail.com`
- **Contraseña:** `password123`

### **Administrador:**
- **Email:** `admin@sistema.com`
- **Contraseña:** `admin123`

## 🗂️ Estructura del Proyecto

```
├── app/
│   ├── Console/Commands/
│   │   └── GestionarEstadosReservas.php    # Gestión automática
│   ├── Http/Controllers/
│   │   ├── CentroDeportivoController.php   # Gestión de centros
│   │   ├── ReservaController.php           # Gestión de reservas
│   │   ├── PagoController.php              # Procesamiento de pagos
│   │   └── PropietarioController.php       # Panel propietario
│   ├── Models/
│   │   ├── CentroDeportivo.php
│   │   ├── Reserva.php
│   │   ├── Pago.php
│   │   └── ...
│   └── Policies/
│       └── CentroDeportivoPolicy.php       # Autorización
├── database/
│   ├── migrations/                         # Migraciones consolidadas
│   └── seeders/                            # Datos iniciales
├── resources/views/
│   ├── propietario/                        # Vistas del propietario
│   ├── cliente/                            # Vistas del cliente
│   └── centros/                            # Vistas públicas
└── routes/
    ├── web.php                             # Rutas web
    └── console.php                         # Comandos programados
```

## 🔄 Comandos Útiles

### **Gestión de Base de Datos:**
```bash
# Resetear base de datos completa
php artisan migrate:fresh --seed

# Ejecutar solo migraciones
php artisan migrate

# Ejecutar solo seeders
php artisan db:seed

# Rollback migraciones
php artisan migrate:rollback
```

### **Gestión de Reservas:**
```bash
# Gestionar estados automáticamente
php artisan reservas:gestionar-estados

# Ver programación de tareas
php artisan schedule:list

# Ejecutar scheduler manualmente
php artisan schedule:run
```

### **Desarrollo:**
```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Compilar assets
npm run dev          # Desarrollo
npm run build        # Producción
npm run watch        # Desarrollo con watch
```

## 🌐 Rutas Principales

### **Rutas Públicas:**
- `/` - Página de inicio
- `/centros` - Listado de centros deportivos
- `/centros/{id}` - Detalle de centro deportivo
- `/login` - Inicio de sesión
- `/register` - Registro

### **Rutas de Propietario:**
- `/propietario/dashboard` - Dashboard principal
- `/propietario/centros` - Gestión de centros
- `/propietario/reservas` - Gestión de reservas
- `/propietario/centros/{id}/instalaciones` - Gestión de instalaciones

### **Rutas de Cliente:**
- `/cliente/dashboard` - Dashboard del cliente
- `/reservas` - Historial de reservas
- `/pagos` - Historial de pagos

## 🔧 Configuración Adicional

### **Configuración de Correo (.env):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_password
MAIL_ENCRYPTION=tls
```

### **Configuración de Archivos (.env):**
```env
FILESYSTEM_DISK=local
```

### **Configuración de Log (.env):**
```env
LOG_CHANNEL=daily
LOG_LEVEL=debug
```

## 🐛 Troubleshooting

### **Problemas Comunes:**

#### **Error: "SQLSTATE[HY000] [1045] Access denied"**
```bash
# Verificar configuración de base de datos en .env
# Asegurarse de que MySQL esté ejecutándose
sudo systemctl start mysql
```

#### **Error: "Class 'Facade\Ignition\...' not found"**
```bash
# Reinstalar dependencias
composer install --no-dev --optimize-autoloader
```

#### **Error: "The stream or file could not be opened"**
```bash
# Configurar permisos
sudo chmod -R 775 storage/
sudo chmod -R 775 bootstrap/cache/
```

#### **Error: "Vite manifest not found"**
```bash
# Compilar assets
npm run build
```

#### **Las reservas no se procesan automáticamente:**
```bash
# Verificar que el scheduler esté configurado
php artisan schedule:list

# Ejecutar manualmente
php artisan reservas:gestionar-estados
```

## 🚀 Despliegue en Producción

### **1. Configurar Entorno:**
```bash
# Instalar dependencias optimizadas
composer install --no-dev --optimize-autoloader

# Compilar assets
npm run build

# Configurar cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **2. Configurar Cron Job:**
```bash
# Agregar al crontab del servidor
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### **3. Configurar Servidor Web:**
- Configurar DocumentRoot hacia `/public`
- Configurar SSL/HTTPS
- Configurar redirects apropiados

## 📝 Notas Importantes

- ⚠️ **Seguridad:** Cambiar todas las contraseñas demo en producción
- ⚠️ **Pagos:** Configurar correctamente las credenciales de Izipay
- ⚠️ **Scheduler:** Esencial para el funcionamiento automático
- ⚠️ **Backups:** Configurar backups automáticos de la base de datos
- ⚠️ **Logs:** Monitorear logs regularmente

## 🤝 Contribución

1. Fork el proyecto
2. Crear rama para feature (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir Pull Request

## 📞 Soporte

Para soporte técnico o consultas:
- **Email:** info@tuisitio.com
- **Documentación:** [Documentación del proyecto]
- **Issues:** [GitHub Issues]

---

**Desarrollado con ❤️ usando Laravel 11**
