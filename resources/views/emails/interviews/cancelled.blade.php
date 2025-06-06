@component('mail::message')
# Entrevista Cancelada

Hola {{ $interview->candidate->first_name }},

Te informamos que la entrevista programada para la posición de **{{ $interview->jobPosting->title }}** ha sido cancelada.

@if($interview->notes)
**Razón de la cancelación:**
{{ $interview->notes }}
@endif

Nos disculpamos por cualquier inconveniente que esto pueda causar. Te mantendremos informado sobre futuras oportunidades.

@component('mail::button', ['url' => config('app.url')])
Ver detalles
@endcomponent

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 