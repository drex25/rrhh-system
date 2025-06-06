@component('mail::message')
# Entrevista Reprogramada

Estimado/a {{ $interview->candidate->first_name }},

La entrevista programada para el puesto de **{{ $interview->jobPosting->title }}** ha sido reprogramada.

**Nuevos detalles de la entrevista:**

- **Nueva fecha y hora:** {{ $interview->scheduled_at->format('d/m/Y H:i') }}
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