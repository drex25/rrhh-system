# Arquitectura Multi-Tenant (SaaS)

Este documento resume la implementación actual de multi-tenancy por columna (`company_id`).

## Componentes clave
- Tabla `companies` (modelo `Company`).
- Columna `company_id` en tablas de negocio.
- Trait `App\\Traits\\BelongsToCompany` + `App\\Scopes\\CompanyScope` para filtrar automáticamente.
- Middleware `SetCurrentCompany` que resuelve la empresa actual y la vincula al contenedor (`currentCompany`).
- Helpers `current_company()` y `company_id()`.
- Regla de validación `UniquePerCompany`.
- Comando `tenant:backfill` para asignar `company_id` a registros existentes.
- Tabla `plan_limits` + `PlanLimitService` para límites por plan.
- Servicio `BillingService` + comando `billing:check-trials` para expiración de trials.
- Logging con `company_id` en `extra` (Monolog processor en `AppServiceProvider`).

## Flujo de resolución de Company
Orden de búsqueda:
1. Subdominio (si `APP_BASE_DOMAIN` configurado).
2. Header `X-Company`.
3. `auth()->user()->company_id`.

## Cómo iniciar (Development)
```bash
php artisan migrate
php artisan db:seed
php artisan tenant:backfill --dry   # ver qué se asignaría
php artisan tenant:backfill         # asigna company_id faltantes
```

Probar aislamiento (Tinker):
```php
$c1 = App\Models\Company::first();
$c2 = App\Models\Company::create(['name'=>'Otra','slug'=>'otra']);
app()->instance('currentCompany', $c1);
App\Models\Department::create(['name'=>'Dept A','code'=>'DA']);
app()->instance('currentCompany', $c2);
App\Models\Department::create(['name'=>'Dept B','code'=>'DB']);
app()->instance('currentCompany', $c1);
App\Models\Department::pluck('name'); // sólo Dept A
```

## Endpoints Company (CRUD básico)
| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | /api/companies | Listar companies (admin) |
| POST | /api/companies | Crear company + slug opcional |
| GET | /api/companies/{company} | Ver detalles |
| PUT/PATCH | /api/companies/{company} | Actualizar |
| DELETE | /api/companies/{company} | Soft delete |

Agregar protección de roles/policies según necesidad.

## Plan Limits
Ejemplo de consulta de límite:
```php
$limitService = app(\App\Services\PlanLimitService::class);
$limitService->assert(current_company(), 'employees', $cantidadActual);
```
`plan_limits` soporta `limit = null` (ilimitado) y `period` (mensual/anual) para futura implementación de resets.

## Billing & Trials
`BillingService` provee:
- `startTrial($company, $days)`
- `isTrialExpired($company)`
- `isActive($company)`
- `markPaid($company, $until)`

Comando cron sugerido (scheduler en `app/Console/Kernel.php`):
```php
$schedule->command('billing:check-trials')->hourly();
```
Desactiva empresas con trial vencido y sin pago.

## Validaciones únicas
Ejemplo en FormRequest:
```php
use App\Rules\UniquePerCompany;
'rule_code' => [new UniquePerCompany('departments','code',$this->route('department')?->id)]
```
O Rule::unique con closure:
```php
Rule::unique('departments','code')->where(fn($q)=>$q->where('company_id', company_id()));
```

## Agregar nuevas tablas multi-tenant
1. Migración: añadir `company_id` FK a `companies`.
2. Modelo: usar trait `BelongsToCompany` y agregar `company_id` a `$fillable`.
3. Ajustar índices únicos a compuestos (`company_id`, campo).
4. Actualizar comando `tenant:backfill` si aplica.

## Seguridad
- Middleware debe ejecutarse antes de acceder a datos multi-tenant.
- Evitar `withoutGlobalScopes()` salvo mantenimiento (auditoría: grep periódica).
- Logging añade `company_id` para rastreo.

## Escalabilidad futura
- Migrar a multi-database con `stancl/tenancy` sin refactor grande (manteniendo interfaz `current_company()`).
- Feature flags por plan (`plan_features` tabla a futuro).
- Medición de consumo (storage, empleados, etc.) y enforcement.

## Próximos pasos sugeridos
1. Integrar facturación real (Stripe/Paddle) + webhooks.
2. Implementar límites dinámicos por período (reset counters).
3. Export/portabilidad de datos (GDPR).
4. Endpoint para cambiar plan y recalcular límites.
5. Métricas y panel de administración multi-tenant.

## Test básico de aislamiento
```php
public function test_company_scope_isolates_departments() {
    $c1 = Company::factory()->create(['slug'=>'c1']);
    $c2 = Company::factory()->create(['slug'=>'c2']);
    app()->instance('currentCompany', $c1);
    Department::factory()->create(['code'=>'D1']);
    app()->instance('currentCompany', $c2);
    Department::factory()->create(['code'=>'D2']);
    app()->instance('currentCompany', $c1);
    $this->assertEquals(['D1'], Department::pluck('code')->all());
}
```

## Comandos útiles
```bash
php artisan tenant:backfill --dry
php artisan tenant:backfill --company=demo
php artisan billing:check-trials
```

## Troubleshooting
| Problema | Causa probable | Solución |
|----------|----------------|----------|
| No filtra datos | Middleware no ejecutado | Verificar alias en `bootstrap/app.php` |
| company_id null en nuevos registros | Falta instancia currentCompany | Revisar resolución (header/subdominio) |
| Límite plan no se aplica | No se llamó a assert/check | Integrar `PlanLimitService` en capa de servicio |
| Empresa se desactiva inesperadamente | Trial vencido sin pago | Revisar `billing:check-trials` |

---
Mantener este documento actualizado conforme evolucione el modelo SaaS.
