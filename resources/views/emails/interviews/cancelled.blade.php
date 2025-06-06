@component('mail::message')
# Entrevista Cancelada

Estimado/a {{ $interview->candidate->first_name }},

Lamentamos informarte que la entrevista programada para el puesto de **{{ $interview->jobPosting->title }}** ha sido cancelada.

**Detalles de la entrevista cancelada:**

- **Fecha y hora programada:** {{ $interview->scheduled_at->format('d/m/Y H:i') }}
- **Tipo:** {{ ucfirst($interview->type) }}

@if($interview->notes)
**Notas adicionales:**
{{ $interview->notes }}
@endif

Nos pondremos en contacto contigo pronto para reprogramar la entrevista.

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 