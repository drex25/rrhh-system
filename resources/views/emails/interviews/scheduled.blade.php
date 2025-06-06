@component('mail::message')
# Entrevista Programada

Estimado/a {{ $interview->candidate->first_name }},

Hemos programado una entrevista para el puesto de **{{ $interview->jobPosting->title }}**.

**Detalles de la entrevista:**

- **Fecha y hora:** {{ $interview->scheduled_at->format('d/m/Y H:i') }}
- **Tipo:** {{ ucfirst($interview->type) }}
@if($interview->type === 'in_person')
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

Por favor, confirma tu asistencia respondiendo a este correo.

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 