@component('mail::message')
# Entrevista Programada

Hola {{ $candidate->name }},

Tu entrevista ha sido programada para el {{ \Carbon\Carbon::parse($candidate->interview_date)->format('d/m/Y') }} a las {{ \Carbon\Carbon::parse($candidate->interview_date)->format('H:i') }}.

@if($candidate->meet_link)
Para unirte a la entrevista, haz clic en el siguiente enlace:

@component('mail::button', ['url' => $candidate->meet_link])
Unirse a la Entrevista
@endcomponent

El enlace de la reunión es: {{ $candidate->meet_link }}
@endif

@if($candidate->interview_location)
**Ubicación:** {{ $candidate->interview_location }}
@endif

**Entrevistador:** {{ $candidate->interviewer_name }}

Por favor, asegúrate de:
- Llegar 5 minutos antes de la hora programada
- Tener una conexión estable a internet
- Tener tu cámara y micrófono funcionando correctamente
- Tener un ambiente tranquilo y bien iluminado

Si necesitas reprogramar la entrevista, por favor contáctanos lo antes posible.

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 