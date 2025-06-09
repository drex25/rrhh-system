@component('mail::message')
# Nuevo Lead Recibido

Se ha recibido un nuevo lead a través del formulario de contacto.

**Detalles del Lead:**
- **Nombre:** {{ $lead->name }}
- **Email:** {{ $lead->email }}
- **Empresa:** {{ $lead->company }}
- **Mensaje:** {{ $lead->message }}

@component('mail::button', ['url' => route('admin.leads.show', $lead)])
Ver Lead
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent 