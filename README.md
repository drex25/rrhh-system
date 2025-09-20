# RRHH SaaS Platform

Una plataforma SaaS completa para la gestión de recursos humanos, construida con Laravel 11 y diseñada para empresas de todos los tamaños.

## 🚀 Características Principales

### Multi-Tenancy
- **Arquitectura Single Database**: Cada empresa (tenant) tiene su propio contexto aislado
- **Switching dinámico**: Los usuarios pueden cambiar entre compañías
- **Global Scopes**: Aislamiento automático de datos por `company_id`
- **Middleware inteligente**: Bootstrap automático de contexto de compañía

### Módulos Funcionales
- **Gestión de Personal**: Legajos digitales completos
- **Reclutamiento**: ATS con gestión de candidatos y entrevistas
- **Nómina**: Generación automática de recibos de sueldo
- **Asistencia**: Control de horarios, vacaciones y permisos
- **Evaluaciones**: Ciclos de feedback y evaluación de desempeño
- **Reportes**: Analytics en tiempo real y dashboards ejecutivos

### Demo Mode 🎯
Sistema de demostración en vivo para visitantes:

```bash
# Activar en .env
DEMO_MODE=true
DEMO_USER_EMAIL=demo@demo.test
DEMO_COMPANY_NAME="TechFlow Solutions"
DEMO_PLAN=pro
DEMO_READ_ONLY=false
```

**Características del Demo:**
- **Login automático**: Ruta `/demo` loguea como usuario demo
- **Datos pre-poblados**: 4 departamentos + empleados de ejemplo
- **Experiencia realista**: TechFlow Solutions con estructura completa
- **Protección configurable**: Bloqueo opcional de eliminaciones
- **UI integrada**: Botón "Live Demo" visible para visitantes

### Onboarding Wizard 🧙‍♂️
Sistema de configuración inicial para nuevos usuarios:

**Paso 1: Información de Empresa**
- Nombre de la empresa
- Industria y tamaño
- Plan automático basado en tamaño

**Paso 2: Departamentos**
- Selección de departamentos comunes
- Opción de agregar departamentos personalizados
- Creación automática de posiciones básicas

**Paso 3: Primer Empleado**
- Empleado inicial opcional
- Configuración básica de datos

## 📋 Instalación Rápida

### Configuración Inicial

1. **Clonar e instalar:**
```bash
git clone <repository>
cd rrhh-tsgroup
composer install && npm install
```

2. **Configurar entorno:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Base de datos:**
```bash
# Configurar DB en .env, luego:
php artisan migrate:fresh --seed
```

4. **Assets y demo:**
```bash
npm run dev
# Agregar a .env para demo:
echo "DEMO_MODE=true" >> .env
php artisan config:clear
```

### Acceso al Sistema

**Usuarios demo predeterminados:**
- Admin: admin@company.com / password
- HR: hr@company.com / password
- **Demo en vivo**: Visita `/demo` como visitante

## 🔧 Multi-Tenancy

### Helpers Disponibles
```php
$company = current_company(); // Compañía actual
$companyId = company_id();    // ID de compañía actual
```

### API Endpoints
```javascript
GET /api/company/current      // Datos compañía actual
GET /api/companies/mine       // Compañías del usuario
POST /api/company/switch      // Cambiar compañía
GET /api/company/limits       // Límites y uso del plan
```

### Trait para Modelos
```php
use App\Traits\BelongsToCompany;

class Employee extends Model
{
    use BelongsToCompany; // Agrega scope automático + company_id
}
```

## 🎨 UI & Experience

### Demo Flow
1. Visitante ve botón "Live Demo" en landing
2. Clic → login automático como Sarah Johnson
3. Explora TechFlow Solutions con datos realistas
4. Puede crear/editar (no eliminar si read-only activo)

### Onboarding Flow
1. Usuario se registra normalmente
2. First login → redirect a `/onboarding`
3. Wizard 3 pasos → empresa configurada
4. Redirect a dashboard con estructura lista

### Stack Frontend
- **Blade + Alpine.js**: SSR con interactividad ligera
- **Tailwind CSS**: Styling moderno y responsive
- **Componentes SaaS**: Hero, pricing, testimonials reutilizables

## 🚀 Próximos Pasos SaaS

### ✅ Implementado
- Multi-tenancy base
- Demo mode completo
- Onboarding wizard
- API switching
- Límites por plan (estructura)

### 🔄 Siguiente Sprint
- Enforcement de límites en creación
- Policies de autorización
- Billing básico (Stripe)
- Invitaciones de usuarios

### 📋 Roadmap
- API pública
- Integraciones (Slack, etc.)
- Mobile companion
- Analytics avanzados

---

**🎯 Estado actual**: Sistema SaaS funcional con demo en vivo, onboarding completo y base multi-tenant sólida. Listo para implementar billing y enforcement de límites.

**💡 Pruébalo**: Visita `/demo` para ver la experiencia completa sin registro.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
