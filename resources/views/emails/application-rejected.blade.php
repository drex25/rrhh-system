@component('mail::message')
# Actualización de tu postulación

Hola {{ $candidate->name }},

Gracias por tu interés en formar parte de nuestro equipo. Después de revisar cuidadosamente tu perfil, lamentamos informarte que en esta ocasión no has sido seleccionado para continuar con el proceso.

{{ $candidate->rejection_reason ? "Razón: {$candidate->rejection_reason}" : '' }}

Sin embargo, conservaremos tu información en nuestra base de datos para futuras oportunidades que se ajusten mejor a tu perfil.

Te deseamos mucho éxito en tu búsqueda laboral.

Saludos cordiales,<br>
{{ config('app.name') }}
@endcomponent 