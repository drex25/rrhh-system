<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function pricing()
    {
        $plans = Plan::where('is_active',true)->orderBy('price_cents')->get();
        return view('billing.pricing', compact('plans'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|exists:plans,code',
            'interval' => 'required|in:monthly,annual'
        ]);
        $company = $request->user()->company; // ajustar si multiple companies
        $planCode = $request->input('plan');
        $interval = $request->input('interval');
        $planModel = Plan::where('code',$planCode)->firstOrFail();

        $priceCents = $interval === 'annual'
            ? ($planModel->yearly_price_cents ?? (int) ($planModel->price_cents * 12 * 0.8))
            : $planModel->price_cents;

        DB::transaction(function () use ($company, $planCode, $interval, $priceCents) {
            Subscription::create([
                'company_id' => $company->id,
                'plan_code' => $planCode,
                'billing_interval' => $interval,
                'status' => 'active',
                'provider' => 'internal',
                'renews_at' => $interval === 'annual' ? now()->addYear() : now()->addMonth(),
                'meta' => [
                    'price_cents' => $priceCents,
                ]
            ]);
        });

        return redirect()->route('dashboard')->with('success','Plan actualizado a ' . $planCode . ' (' . $interval . ')');
    }

    public function cancel(Request $request)
    {
        $company = $request->user()->company;
        $sub = Subscription::where('company_id',$company->id)->whereNull('ends_at')->latest()->first();
        if($sub){
            $sub->update(['ends_at'=>now(),'status'=>'canceled']);
        }
        return back()->with('success','Suscripción cancelada. Mantendrás acceso hasta la fecha de finalización.');
    }
}
