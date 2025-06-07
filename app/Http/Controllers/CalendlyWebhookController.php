<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Mail\InterviewScheduled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CalendlyWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $payload = $request->all();
            Log::info('Calendly webhook received', ['payload' => $payload]);

            // Verificar que sea un evento de creación de invitado
            if ($payload['event'] !== 'invitee.created') {
                return response()->json(['message' => 'Event not handled'], 200);
            }

            // Obtener el email del candidato del evento
            $inviteeEmail = $payload['payload']['invitee']['email'];
            
            // Buscar el candidato por email
            $candidate = Candidate::where('email', $inviteeEmail)
                                ->where('status', Candidate::STATUS_SHORTLISTED)
                                ->first();

            if (!$candidate) {
                Log::warning('Candidate not found for Calendly event', ['email' => $inviteeEmail]);
                return response()->json(['message' => 'Candidate not found'], 404);
            }

            // Actualizar el candidato con la información de la entrevista
            $candidate->update([
                'status' => Candidate::STATUS_INTERVIEW_SCHEDULED,
                'interview_date' => $payload['payload']['event']['start_time'],
                'interview_type' => 'video',
                'meet_link' => $payload['payload']['invitee']['location']['join_url'] ?? null,
                'interviewer_name' => $payload['payload']['event']['name'],
            ]);

            // Enviar correo de confirmación
            Mail::to($candidate->email)->send(new InterviewScheduled($candidate));

            return response()->json(['message' => 'Interview scheduled successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error processing Calendly webhook', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
} 