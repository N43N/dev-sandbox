<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class EmailVerificationController extends Controller
{
    // 1. Display the Email Verification Playground UI
    public function index()
    {
        $user = auth()->user();
        return view('modules.email.verify', compact('user'));
    }

    // 2. Generate a 10-minute Temporary Signed URL and dispatch via Mailpit
    public function send(Request $request)
    {
        $user = auth()->user();

        // Create a secure, expiring cryptographic link valid for 10 minutes
        $verificationUrl = URL::temporarySignedRoute(
            'email.verify.confirm',
            now()->addMinutes(10),
            [
                'id'   => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        // Send clean HTML email directly to Mailpit (port 1025)
        Mail::send([], [], function ($message) use ($user, $verificationUrl) {
            $message->to($user->email)
                ->subject('Sandbox Verification: Confirm Your Identity')
                ->html("
                    <div style='font-family: sans-serif; max-width: 500px; margin: auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px;'>
                        <h2 style='color: #0f172a;'>✉️ Verify Your Sandbox Email</h2>
                        <p style='color: #475569; font-size: 14px;'>Hi <strong>{$user->name}</strong>, click the button below to verify your email address. This cryptographic link expires in <strong>10 minutes</strong>.</p>
                        <div style='margin: 24px 0;'>
                            <a href='{$verificationUrl}' style='background-color: #10b981; color: white; padding: 12px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 14px;'>Confirm Email Address</a>
                        </div>
                        <p style='color: #94a3b8; font-size: 11px; word-break: break-all;'>Or paste this signed URL into your browser:<br>{$verificationUrl}</p>
                    </div>
                ");
        });

        return back()->with('status_success', 'Verification link dispatched! Check your Mailpit inbox at localhost:8025.');
    }

    // 3. Validate the signature and mark the user as verified
    public function verify(Request $request, $id, $hash)
    {
        $user = auth()->user();

        if ((string) $user->id !== (string) $id || !hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Invalid verification signature.');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->route('email.verify.index')
            ->with('status_success', 'Success! Your email address has been cryptographically verified.');
    }
}
