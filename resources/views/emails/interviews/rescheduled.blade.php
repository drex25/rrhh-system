@component('mail::message')
# Entrevista Reprogramada

Hola {{ $interview->candidate->first_name }},

Te informamos que la entrevista para la posición de **{{ $interview->jobPosting->title }}** ha sido reprogramada.

**Nuevos detalles de la entrevista:**

- **Fecha y hora:** {{ $interview->scheduled_at->format('d/m/Y H:i') }}
- **Tipo:** {{ ucfirst($interview->type) }}
@if($interview->type === 'in-person')
- **Ubicación:** {{ $interview->location }}
@elseif($interview->type === 'video')
- **Enlace de la reunión:** {{ $interview->meeting_link }}
@endif

@if($interview->notes)
**Notas adicionales:**
{{ $interview->notes }}
@endif

@component('mail::button', ['url' => config('app.url')])
Ver detalles
@endcomponent

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 