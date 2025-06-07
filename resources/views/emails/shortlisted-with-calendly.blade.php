@component('mail::message')
# ¡Hemos revisado tu perfil!

Hola {{ $candidate->name }},

Hemos revisado tu perfil y nos gustaría conocerte más. Te invitamos a agendar una entrevista con nosotros.

@component('mail::button', ['url' => $calendlyLink])
Agendar Entrevista
@endcomponent

El enlace de agendamiento es: {{ $calendlyLink }}

**Detalles importantes:**
- La entrevista será por videollamada
- Duración aproximada: 30-45 minutos
- Por favor, asegúrate de tener una conexión estable a internet
- Tener tu cámara y micrófono funcionando correctamente
- Tener un ambiente tranquilo y bien iluminado

Si tienes alguna dificultad para agendar la entrevista, no dudes en contactarnos.

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 