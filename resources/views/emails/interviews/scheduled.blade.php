@component('mail::message')
# Entrevista Programada

Hola {{ $interview->candidate->first_name }},

Te informamos que se ha programado una entrevista para la posición de **{{ $interview->jobPosting->title }}**.

**Detalles de la entrevista:**

- **Fecha y hora:** {{ $interview->scheduled_at->format('d/m/Y H:i') }}
- **Tipo:** {{ ucfirst($interview->type) }}
@if($interview->type === 'in-person')
- **Ubicación:** {{ $interview->location }}
@elseif($interview->type === 'video')
- **Enlace de la reunión:** {{ $interview->meeting_link }}
@endif

**Entrevistador:** {{ $interview->interviewer->name }}

@if($interview->notes)
**Notas adicionales:**
{{ $interview->notes }}
@endif

@if($interview->type === 'video')
@component('mail::button', ['url' => $interview->meeting_link])
Unirse a la reunión
@endcomponent
@endif

@component('mail::button', ['url' => config('app.url')])
Ver detalles
@endcomponent

Por favor, confirma tu asistencia respondiendo a este correo.

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 