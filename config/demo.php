<?php

return [
    'enabled' => (bool) env('DEMO_MODE', false),
    'user_email' => env('DEMO_USER_EMAIL', 'demo@demo.test'),
    'company_name' => env('DEMO_COMPANY_NAME', 'TechFlow Solutions'),
    'plan' => env('DEMO_PLAN', 'pro'),
    // Ahora por defecto permite crear/editar; se puede activar sólo si quieres congelar
    'read_only' => (bool) env('DEMO_READ_ONLY', false),
];
