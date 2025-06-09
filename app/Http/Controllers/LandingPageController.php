<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadNotification;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $lead = Lead::create($validated);

        // Enviar notificación por correo
        Mail::to(config('mail.from.address'))->send(new LeadNotification($lead));

        return response()->json([
            'message' => '¡Gracias por tu interés! Nos pondremos en contacto contigo pronto.',
            'success' => true
        ]);
    }
}
