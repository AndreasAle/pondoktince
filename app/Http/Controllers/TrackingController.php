<?php

namespace App\Http\Controllers;

use App\Models\WhatsappClickLog;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Records a WhatsApp button click. Called via navigator.sendBeacon(), so it
     * must stay lightweight and always return quickly (no redirect needed).
     */
    public function whatsappClick(Request $request)
    {
        $data = $request->validate([
            'source_page' => ['nullable', 'string', 'max:255'],
            'button_label' => ['nullable', 'string', 'max:120'],
            'brand_key' => ['nullable', 'string', 'max:50'],
            'destination_number' => ['nullable', 'string', 'max:30'],
            'message_preview' => ['nullable', 'string', 'max:500'],
        ]);

        WhatsappClickLog::create([
            ...$data,
            // Anonymised visitor identifier: hashed IP + UA + app key (not reversible).
            'visitor_hash' => hash('sha256', $request->ip().'|'.$request->userAgent().'|'.config('app.key')),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'referrer' => substr((string) $request->headers->get('referer'), 0, 1000),
        ]);

        return response()->noContent();
    }
}
